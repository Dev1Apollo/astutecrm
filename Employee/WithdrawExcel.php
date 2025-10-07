<?php

include('../config.php');
include('IsLogin.php');
ini_set('max_execution_time', 0);
$where = "where 1=1";
if (isset($_REQUEST['Search_Txt'])) {
    if ($_REQUEST['Search_Txt'] != '') {
        $where.=" and  empname like '%$_REQUEST[Search_Txt]%'";
    }
}
$filterstr = "SELECT * FROM `application`  " . $where . " and isWithdraw=1 and isDelete='0'  and  istatus='1' order by applicatipnNo asc";

$result1 = mysqli_query($dbconn, $filterstr);
if (mysqli_num_rows($result1) > 0) {
    $filename = 'CRM_WithDraw_Data_' . date('d-m-Y H:s:i') . '.xls';

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
    . "\t Call Status"
    . "\t Main Disposition"
    . "\t Sub Disposition"
    . "\t Call Back Date"
    . "\t PTP Date"
    . "\t Next Follow-up call"
//. "\t Alt No"
    . "\t Remark"
    . "\t Call Date and Time"
    . "\t Withdraw Reason"
    . "\n";
    $i = 1;
    while ($row = mysqli_fetch_array($result1)) {

        $filterFollowUp = mysqli_fetch_array(mysqli_query($dbconn, "Select dispoType,followupDate,PTPDate,strEntryDate,remark,mainDispoId,subDispoId from applicationfollowup where iAppId='" . $row['iAppId'] . "' ORDER BY iAppLogId DESC LIMIT 1"));
        if ($filterFollowUp['followupDate'] != "") {
            $date = explode(" ", $filterFollowUp['followupDate']);
        } else if ($filterFollowUp['PTPDate'] != '') {
            $date = explode(" ", $filterFollowUp['PTPDate']);
        } else {
            $date = array("", "");
        }
        if (isset($filterFollowUp['dispoType'])) {
            if ($filterFollowUp['dispoType'] == 0) {
                $CallStatus = "Not Contact";
            } else {
                $CallStatus = "Connect";
            }
        } else {
            $CallStatus = "";
        }
        $filterDisPosition = mysqli_fetch_array(mysqli_query($dbconn, "Select dispoDesc from dispositionmaster where iDispoId='" . $filterFollowUp['mainDispoId'] . "'"));
        $filterSubDisPosition = mysqli_fetch_array(mysqli_query($dbconn, "Select dispoDesc from dispositionmaster where iDispoId='" . $filterFollowUp['subDispoId'] . "'"));
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
        . "\t" . $CallStatus
        . "\t" . $filterDisPosition['dispoDesc']
        . "\t" . $filterSubDisPosition['dispoDesc']
        . "\t" . $date[0]
        . "\t" . $date[0]
        . "\t" . $date[0]
        . "\t" . preg_replace('/\s+/', ' ', trim(str_replace(',', '.', $filterFollowUp['remark'])))
        . "\t" . $filterFollowUp['strEntryDate']
        . "\t" . $row['remark']
        . "\n";
        $i++;
    }
} else {
    header('location:WithdrawCase.php');
}
exit;
