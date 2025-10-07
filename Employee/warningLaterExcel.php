<?php
ob_start();
include('../config.php');
include('IsLogin.php');
ini_set('max_execution_time', 0);

$where = "where 1=1 ";

if ($_SESSION['Designation'] == 5) {
    $filterstr = "SELECT * from warninglater where  warningForId='" . $_SESSION['EmployeeId'] . "'  and istatus='1' and isDelete='0'  order by STR_TO_DATE(strEntryDatetime,'%d-%m-%Y') desc";
   
} else {

    if ($_SESSION['Designation'] == 1)
        $where .= " and qualityanalistid='" . $_SESSION['EmployeeId'] . "'";
    else if ($_SESSION['Designation'] == 2)
        $where .= " and asstmanagerid='" . $_SESSION['EmployeeId'] . "'";
    else if ($_SESSION['Designation'] == 3)
        $where .= " and qualityanalistid='" . $_SESSION['EmployeeId'] . "'";
    else if ($_SESSION['Designation'] == 4)
        $where .= " and qualityanalistid='" . $_SESSION['EmployeeId'] . "'";
    else
        $where .= " and centralmanagerId='" . $_SESSION['EmployeeId'] . "'";
    $filterstr = "SELECT * from warninglater where  warningForId IN (select employeeId from employee  " . $where . " and istatus='1' and isDelete='0' ) and istatus='1' and isDelete='0'  ";
   
}
if (isset($_REQUEST['fromDate']) && $_REQUEST['fromDate'] != '') {
    $filterstr .= " and STR_TO_DATE(strEntryDatetime,'%d-%m-%Y %T')>= STR_TO_DATE('" . $_REQUEST['fromDate'] . "','%d-%m-%Y')";
    
}
if (isset($_REQUEST['toDate']) && $_REQUEST['toDate'] != '') {
    $filterstr .= " and STR_TO_DATE(strEntryDatetime,'%d-%m-%Y %T') < STR_TO_DATE('" . $_REQUEST['toDate'] . "','%d-%m-%Y')";
    
}    
$result1 = mysqli_query($dbconn, $filterstr);
if (mysqli_num_rows($result1) > 0) {
    $filename = 'Warning_Later_Report_' . date('d-m-Y H:s:i') . '.xls';

    header("Content-Type: application/vnd.ms-excel");
    header("Content-disposition: attachment; filename=" . $filename);

    ob_end_clean();
   
    echo
    "Sr NO."
    . "\t Warning For"
    . "\t Raise By"
    . "\t Entry Date"
    . "\n";
    $i = 1;
    while ($row = mysqli_fetch_array($result1)) {
        $raiseByDetail = mysqli_fetch_assoc(mysqli_query($dbconn, "select * from employee where employeeid=" . $row['raiseById']));
        $warningFor = mysqli_fetch_assoc(mysqli_query($dbconn, "select * from employee where employeeid=" . $row['warningForId']));
        echo
        $i
        . "\t" . $warningFor['empname']
        . "\t" . $raiseByDetail['empname']
        . "\t" . $row['strEntryDatetime']
        . "\n";
        $i++;
    }
} else {
    header('location:warningLater.php');
}
exit;
