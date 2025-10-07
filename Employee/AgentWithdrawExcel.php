<?php

include('../config.php');
include('IsLogin.php');

$where = "where 1=1";
if (isset($_REQUEST['Search_Txt'])) {
    if ($_REQUEST['Search_Txt'] != '') {
        $where.=" and  empname like '%$_REQUEST[Search_Txt]%'";
    }
}
$where .= " and agentId='".$_SESSION['elisionloginid']."'";
$filterstr = "SELECT * FROM `application`  " . $where . " and isWithdraw=1 and isDelete='0'  and  istatus='1' order by applicatipnNo asc";

$result1 = mysqli_query($dbconn, $filterstr);
if (mysqli_num_rows($result1) > 0) {
    $filename = 'CRM_WithDraw_Data_' . date('d-m-Y H:s:i') . '.xls';

    header("Content-Type: application/vnd.ms-excel");
    header("Content-disposition: attachment; filename=" . $filename);

    ob_end_clean();

   echo
    "Loan Application No"
    . "\t Agent ID"
    . "\t Call Status"
    . "\t Main Disposition"
    . "\t Sub Disposition"
    . "\t Remark"
    . "\t Call Date and Time"
    . "\n";
    $i = 1;
    while ($row = mysqli_fetch_array($result1)) {

        $filterFollowUp = mysqli_fetch_array(mysqli_query($dbconn, "Select * from applicationfollowup where iAppId='" . $row['iAppId'] . "' ORDER BY iAppLogId DESC LIMIT 1"));
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
        . "\t" . $row['agentId']
        . "\t" . $CallStatus
        . "\t" . $filterDisPosition['dispoDesc']
        . "\t" . $filterSubDisPosition['dispoDesc']
        . "\t" . $filterFollowUp['remark']
        . "\t" . $filterFollowUp['strEntryDate']
        . "\n";
        $i++;
    }
} else {
    header('location:WithdrawCase.php');
}
exit;
