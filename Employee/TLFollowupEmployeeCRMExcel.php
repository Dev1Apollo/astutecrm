<?php

include('../config.php');
include('IsLogin.php');
ini_set('max_execution_time', 0);

$where = "where 1=1";

if (isset($_REQUEST['formDate']) && $_REQUEST['formDate'] != '') {
    $where.=" and STR_TO_DATE(applicationfollowup.strEntryDate,'%d-%m-%Y')>= STR_TO_DATE('" . $_REQUEST['formDate'] . "','%d-%m-%Y')";
} else {
    $where.=" and STR_TO_DATE(applicationfollowup.strEntryDate,'%d-%m-%Y')>= STR_TO_DATE('" . $date . "','%d-%m-%Y')";
}
if (isset($_REQUEST['toDate']) && $_REQUEST['toDate'] != '') {
    $where.=" and STR_TO_DATE(applicationfollowup.strEntryDate,'%d-%m-%Y')<=STR_TO_DATE('" . $_REQUEST['toDate'] . "','%d-%m-%Y')";
}
$whereEmp = "";
if ($_SESSION['Designation'] == 4) {
    $whereEmp.=" and agentId in (select elisionloginid from employee where iteamleadid='" . $_SESSION['EmployeeId'] . "')";
} else {
    $whereEmp.=" and agentId='" . $_SESSION['elisionloginid'] . "'";
}

$filterstr = "SELECT application.applicatipnNo,application.bucket,application.customerName,application.branch,application.state,application.customerAddress,application.customerCity,application.customerZipcode,application.loanAmount,application.EMIAmount,"
        . " application.agencyName,application.FOSName,application.FosNumber,application.agentId,application.isEmiPending,"
        . " applicationfollowup.followupDate,applicationfollowup.PTPDate,applicationfollowup.dispoType,applicationfollowup.mainDispoId,applicationfollowup.subDispoId,applicationfollowup.remark,applicationfollowup.strEntryDate "
        . " FROM `application` inner join applicationfollowup on applicationfollowup.iAppId=application.iAppId  " . $where . $whereEmp . " and application.isPaid=0 and application.isWithdraw=0 and application.isDelete='0'  and  application.istatus='1' order by STR_TO_DATE(applicationfollowup.strEntryDate,'%d-%m-%Y') DESC";

$result1 = mysqli_query($dbconn, $filterstr);
if (mysqli_num_rows($result1) > 0) {
    $filename = 'CRM_Data_' . date('d-m-Y H:s:i') . '.xls';

    header("Content-Type: application/vnd.ms-excel");
    header("Content-disposition: attachment; filename=" . $filename);

    ob_end_clean();

    $header = "Loan Application No"
            . "\t Bucket"
            . "\t Customer Name"
            . "\t Branch"
            . "\t State"
            . "\t Customer  Address"
            . "\t Customer  City"
            . "\t Customer  Zip Code"
            . "\t Loan Amount"
            . "\t EMI Amount"
            . "\t Agency Name"
            . "\t FOS Name"
            . "\t FOS Contact"
            . "\t Agent ID"
            . "\t Paid Status";
    $concateHeader = array();

//    while ($rowfollowup = mysqli_fetch_array($result1)) {
        $query = mysqli_fetch_array(mysqli_query($dbconn, "SELECT MAX(Total) as RowCount FROM (SELECT COUNT(iAppId) AS Total FROM applicationfollowup ".$where." GROUP BY iAppId) AS Results"));
        for($iCounter = 0; $iCounter < $query['RowCount']; $iCounter++ ){
            $concateHeader[$iCounter] = "\t Call Status"
                    . "\t Main Disposition"
                    . "\t Sub Disposition"
                    . "\t Call Back Date"
                    . "\t PTP Date"
                    . "\t Next Follow-up call"
                    . "\t Remark"
                    . "\t Call Date and Time";
        }
//    }
//    $endHeader = "\n";
    echo $header.implode("", $concateHeader) . $endHeader;
            
    $i = 1;
//    $filterstr = "SELECT DISTINCT(application.iAppId),applicationfollowup.strEntryDate,application.* FROM `application` inner join applicationfollowup on applicationfollowup.iAppId=application.iAppId  " . $where . " and application.isPaid=0 and application.isWithdraw=0 and application.isDelete='0'  and  application.istatus='1' order by STR_TO_DATE(applicationfollowup.strEntryDate,'%d-%m-%Y') DESC";
    $resultFilter = mysqli_query($dbconn, $filterstr);
    while ($row = mysqli_fetch_array($resultFilter)) {

        if ($row['isEmiPending'] == 1) {
            $isEmiPending = "One Emi Pending";
        } else {
            $isEmiPending = "";
        }

        $mainData = $row['applicatipnNo']
                . "\t" . $row['bucket']
                . "\t" . $row['customerName']
                . "\t" . $row['branch']
                . "\t" . $row['state']
                . "\t" . $row['customerAddress']
                . "\t" . $row['customerCity']
                . "\t" . $row['customerZipcode']
                . "\t" . $row['loanAmount']
                . "\t" . $row['EMIAmount']
                . "\t" . $row['agencyName']
                . "\t" . $row['FOSName']
                . "\t" . $row['FosNumber']
                . "\t" . $row['agentId']
                . "\t" . $isEmiPending;
        $subData = array();
        $queryfollowup = mysqli_query($dbconn, "select * from applicationfollowup ".$where." and  iAppId ='" . $row['iAppId'] . "' order by STR_TO_DATE(applicationfollowup.strEntryDate,'%d-%m-%Y %H:%i') DESC");
        $iCounter=0;
        while ($row1 = mysqli_fetch_array($queryfollowup)) {
            echo $iCounter;
            if (isset($row1['dispoType'])) {
                if ($row1['dispoType'] == 0) {
                    $CallStatus = "Not Contact";
                } else {
                    $CallStatus = "Connect";
                }
            } else {
                $CallStatus = "";
            }
            if ($row1['followupDate'] != "") {
                $date = explode(" ", $row1['followupDate']);
            } else if ($row1['PTPDate'] != '') {
                $date = explode(" ", $row1['PTPDate']);
            } else {
                $date = array("", "");
            }
            $filterDisPosition = mysqli_fetch_array(mysqli_query($dbconn, "Select dispoDesc from dispositionmaster where iDispoId='" . $row1['mainDispoId'] . "'"));
            $filterSubDisPosition = mysqli_fetch_array(mysqli_query($dbconn, "Select dispoDesc from dispositionmaster where iDispoId='" . $row1['subDispoId'] . "'"));
            $subData[$iCounter] = "\t" . $CallStatus
                    . "\t" . $filterDisPosition['dispoDesc']
                    . "\t" . $filterSubDisPosition['dispoDesc']
                    . "\t" . $date[0]
                    . "\t" . $date[0]
                    . "\t" . $date[0]
                    . "\t" . preg_replace('/\s+/', ' ', trim(str_replace(',', '.', $row1['remark'])))
                    . "\t" . $row1['strEntryDate'];
            $iCounter++;
        }
        $endDataLine = "\n";
        echo $mainData . implode("", $subData) . $endDataLine;
        $i++;
    }
     
} else {
    header('location:CNEmployeeFollowup.php');
}
exit;
