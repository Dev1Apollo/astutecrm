<?php

include('../config.php');
include('IsLogin.php');
ini_set('max_execution_time', 0);

$where = "where 1=1";
$whereDate = "where 1=1";
if (isset($_REQUEST['strfilter']) && $_REQUEST['strfilter'] != '') {
    if (isset($_REQUEST['filterValue']) && $_REQUEST['filterValue']) {
        if ($_REQUEST['strfilter'] == 'TotalAttempt') {
            $where.=" and applicationfollowup.iAppId in (select iAppId from applicationfollowup GROUP BY iAppId HAVING count(*) = '" . trim($_REQUEST['filterValue']) . "' )";
        } else if ($_REQUEST['strfilter'] == 'TotalConnect') {
            $where.=" and applicationfollowup.iAppId in (select iAppId from applicationfollowup where dispoType='1' GROUP BY iAppId HAVING count(*) = '" . trim($_REQUEST['filterValue']) . "' )";
        } elseif ($_REQUEST['strfilter'] == 'followupDate') {
            $where.=" and application.iAppId in (select iAppId from applicationfollowup where STR_TO_DATE(followupDate,'%d-%m-%Y') = STR_TO_DATE('" . trim($_REQUEST['filterValue']) . "','%d-%m-%Y'))";
        } else if ($_REQUEST['strfilter'] == 'followupTime') {
            $where.=" and application.iAppId in (select iAppId from applicationfollowup where STR_TO_DATE(followupDate,'%d-%m-%Y %h') = STR_TO_DATE('" . trim($_REQUEST['filterValue']) . "','%d-%m-%Y %h'))";
        } else if ($_REQUEST['strfilter'] == 'Lastdisposition') {
            $where.=" and mainDispoId='" . $_REQUEST['filterValue'] . "'";
//            $where.=" and applicationfollowup.iAppId in (select iAppId from applicationfollowup where mainDispoId='" . $_REQUEST['filterValue'] . "' GROUP BY iAppId order by iAppLogId desc)";
        } else if ($_REQUEST['strfilter'] == 'CustomSearch') {
            $where.=" and (application.customerName  like '%" . trim($_REQUEST['filterValue']) . "%' OR application.applicatipnNo like '%" . trim($_REQUEST['filterValue']) . "%' OR application.customerZipcode like '%" . trim($_REQUEST['filterValue']) . "%' OR application.customerCity like '%" . trim($_REQUEST['filterValue']) . "%' OR application.agencyName like '%" . trim($_REQUEST['filterValue']) . "%' OR application.state like '%" . trim($_REQUEST['filterValue']) . "%')";
        } else if ($_REQUEST['strfilter'] == 'LastCallDate') {
            if (isset($_REQUEST['fromdate']) && $_REQUEST['fromdate'] != "") {
                $whereDate .= " and STR_TO_DATE(applicationfollowup.strEntryDate,'%d-%m-%Y') >= STR_TO_DATE('" . trim($_REQUEST['fromdate']) . "','%d-%m-%Y')";
            }
            if (isset($_REQUEST['todate']) && $_REQUEST['todate'] != "") {
                $whereDate .= " and STR_TO_DATE(applicationfollowup.strEntryDate,'%d-%m-%Y') <= STR_TO_DATE('" . trim($_REQUEST['todate']) . "','%d-%m-%Y')";
            }
            if ($_REQUEST['strfilter'] == 'LastCallDate') {
                $whereDate .=" and applicationfollowup.iAppId in (select iAppId from applicationfollowup where mainDispoId='" . $_REQUEST['filterValue'] . "' GROUP BY iAppId order by iAppLogId desc)";
            }
            $where.=" and application.iAppId in (select iAppId from applicationfollowup " . $whereDate . ")";
        } else {
            $where.=" and application." . $_REQUEST['strfilter'] . " like '%" . trim($_REQUEST['filterValue']) . "%'";
        }
    }
}
$whereEmp = "";
if ($_SESSION['Designation'] == 4) {
    if ($_REQUEST['EmployeeId'] != NULL && isset($_REQUEST['EmployeeId'])) {
        $whereEmp.=" and agentId='" . $_REQUEST['EmployeeId'] . "'";
    } else {
        $whereEmp.=" and agentId in (select elisionloginid from employee where iteamleadid='" . $_SESSION['EmployeeId'] . "')";
    }
} else if ($_SESSION['Designation'] == 6) {
    $whereEmp.=" and agentId in (select elisionloginid from employee)";
} else {
    $whereEmp.=" and agentId='" . $_SESSION['elisionloginid'] . "'";
}

// $filterstr = "SELECT application.iAppId,application.bucket,application.isEmiPending,application.applicatipnNo,application.customerName,application.branch,application.state,application.customerAddress,application.customerCity, "
//         . "application.customerZipcode,application.loanAmount,application.agentId,application.EMIAmount,application.agencyName,application.FOSName,application.customerAddress,application.FosNumber, "
//         . "applicationfollowup.strEntryDate,applicationfollowup.subDispoId,applicationfollowup.dispoType,applicationfollowup.subDispoId,applicationfollowup.mainDispoId,applicationfollowup.followupDate,applicationfollowup.PTPDate,applicationfollowup.remark "
//         . " FROM `application` LEFT JOIN (select max(applicationfollowup.iAppLogId) as iAppLogId,applicationfollowup.subDispoId,applicationfollowup.iAppId,applicationfollowup.followupDate,applicationfollowup.PTPDate,applicationfollowup.dispoType,applicationfollowup.remark,applicationfollowup.strEntryDate,applicationfollowup.mainDispoId from applicationfollowup group by applicationfollowup.iAppId ORDER BY applicationfollowup.iAppLogId DESC) as "
//         . "applicationfollowup ON application.iAppId=applicationfollowup.iAppId  " . $where . $whereEmp . "  and bucket!='' and isWithdraw=0 and isPaid=0 and isDelete='0'  and  iStatus='1'  ORDER BY STR_TO_DATE(`applicationfollowup`.`strEntryDate`,'%d-%m-%Y') ASC";

$filterstr = "SELECT application.iAppId,application.bucket,application.isEmiPending,application.applicatipnNo,application.customerName,application.branch,application.state,application.customerAddress,application.customerCity, "
            . "application.customerZipcode,application.loanAmount,application.EMIAmount,application.agencyName,application.FOSName,application.customerAddress,application.FosNumber, application.customerMobile, "
            . "applicationfollowup.strEntryDate,applicationfollowup.mainDispoId,applicationfollowup.followupDate,applicationfollowup.PTPDate,applicationfollowup.remark "
            . " FROM `application` LEFT JOIN "
            . "applicationfollowup ON application.iAppLogId=applicationfollowup.iAppLogId  " . $where . $whereEmp . "  and isWithdraw=0 and isPaid=0 and isDelete='0'  and  iStatus='1'  ORDER BY STR_TO_DATE(`applicationfollowup`.`strEntryDate`,'%d-%m-%Y') ASC";


$result1 = mysqli_query($dbconn, $filterstr);
if (mysqli_num_rows($result1) > 0) {
    $filename = 'CRM_Data_' . date('d-m-Y_H:s:i') . '.xls';

    header("Content-Type: application/vnd.ms-excel");
    header("Content-disposition: attachment; filename=" . $filename);

    ob_end_clean();

    echo
    "Loan Application No"
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
    . "\t Paid Status"
    . "\t Call Status"
    . "\t Main Disposition"
    . "\t Sub Disposition"
    . "\t Call Back Date"
    . "\t PTP Date"
    . "\t Next Follow-up call"
//. "\t Alt No"
    . "\t Remark"
    . "\t Call Date and Time"
    . "\n";
    $i = 1;
    while ($row = mysqli_fetch_array($result1)) {

//        $filterFollowUp = mysqli_fetch_array(mysqli_query($dbconn, "Select followupDate,PTPDate,dispoType,mainDispoId,subDispoId,remark,strEntryDate from applicationfollowup where iAppId='" . $row['iAppId'] . "' ORDER BY iAppLogId DESC LIMIT 1"));
        if ($row['followupDate'] != "") {
            $date = explode(" ", $row['followupDate']);
        } else if ($row['PTPDate'] != '') {
            $date = explode(" ", $row['PTPDate']);
        } else {
            $date = array("", "");
        }
        if (isset($filterFollowUp['dispoType'])) {
            if ($row['dispoType'] == 0) {
                $CallStatus = "Not Contact";
            } else {
                $CallStatus = "Connect";
            }
        } else {
            $CallStatus = "";
        }
        if ($row['isEmiPending'] == 1) {
            $isEmiPending = "One Emi Pending";
        } else {
            $isEmiPending = "";
        }
        $filterDisPosition = mysqli_fetch_array(mysqli_query($dbconn, "Select dispoDesc from dispositionmaster where iDispoId='" . $row['mainDispoId'] . "'"));
        $filterSubDisPosition = mysqli_fetch_array(mysqli_query($dbconn, "Select dispoDesc from dispositionmaster where iDispoId='" . $row['subDispoId'] . "'"));
        echo
        $row['applicatipnNo']
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
        . "\t" . $isEmiPending
        . "\t" . $CallStatus
        . "\t" . $filterDisPosition['dispoDesc']
        . "\t" . $filterSubDisPosition['dispoDesc']
        . "\t" . $date[0]
        . "\t" . $date[0]
        . "\t" . $date[0]
        . "\t" . preg_replace('/\s+/', ' ', trim(str_replace(',', '.', $row['remark'])))
        . "\t" . $row['strEntryDate']
        . "\n";
        $i++;
    }
} else {
    header('location:CRM.php');
}
exit;
