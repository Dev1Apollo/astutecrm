<?php

include('../config.php');
include('IsLogin.php');

$where = "where 1=1 ";

if ($_REQUEST['fromDate'] != NULL && isset($_REQUEST['fromDate']))
    $where.=" and STR_TO_DATE(date,'%d-%M-%Y')>= STR_TO_DATE('" . $_REQUEST['fromDate'] . "','%d-%M-%Y')";
if ($_REQUEST['toDate'] != NULL && isset($_REQUEST['toDate']))
    $where.=" and STR_TO_DATE(date, '%d-%M-%Y')<= STR_TO_DATE('" . $_REQUEST['toDate'] . "','%d-%M-%Y')";

$filterstr = "SELECT * FROM `employeeperformance` " . $where . " and elisionloginid='" . $_SESSION['elisionloginid'] . "'  and isDelete='0'  order by STR_TO_DATE(date,'%d-%m-%Y') asc";

$result1 = mysqli_query($dbconn, $filterstr);

$filename = 'Employee_Performance_'.date('d-m-Y H:s:i').'.xls';

header("Content-Type: application/vnd.ms-excel");
header("Content-disposition: attachment; filename=" . $filename);

ob_end_clean();

echo
"Date"
 . "\t Login"
 . "\t Attendance"
 . "\t Login Time"
 . "\t Logout Time"
 . "\t Login hour"
 . "\t Talk Time"
 . "\t Pause Time"
 . "\t Connect Call"
 . "\t PU PTP"
 . "\t DG PTP"
 . "\t WK PTP"
 . "\t PU Conv"
 . "\t DG Conv"
 . "\t WK Conv"
 . "\t PU Conv %"
 . "\t DG Conv %"
 . "\t WK Conv %"
 . "\t Penal Collected"
 . "\n";
$i = 1;
while ($row = mysqli_fetch_array($result1)) {
    
    echo
    $row['date']
    . "\t" . $row['elisionloginid']
    . "\t" . $row['Attendance']
    . "\t" . $row['LoginTime']
    . "\t" . $row['LogoutTime']
    . "\t" . $row['Loginhour']
    . "\t" . $row['TalkTime']
    . "\t" . $row['PauseTime']
    . "\t" . $row['ConnectCall']
    . "\t" . $row['PU_PTP']
    . "\t" . $row['DG_PTP']
    . "\t" . $row['WK_PTP']
    . "\t" . $row['PU_Conv']
    . "\t" . $row['DG_Conv']
    . "\t" . $row['WK_Conv']
    . "\t" . $row['PU_Conv_per']
    . "\t" . $row['DG_Conv_per']
    . "\t" . $row['WK_Conv_per']
    . "\t" . $row['PenalCollected']
    . "\n";
    $i++;
}