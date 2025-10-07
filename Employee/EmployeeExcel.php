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
$filterstr = "SELECT empname,dojoin,contactnumber,astutenumber,elisionloginid,iProcessid,iteamleadid,qualityanalistid,asstmanagerid,processmanager,employeeid FROM `employee`  " . $where . " and isDelete='0'  and  istatus='1' order by elisionloginid asc";

$result1 = mysqli_query($dbconn, $filterstr);

$filename = 'Employee_Data_' . date('d-m-Y_H:s:i') . '.xls';

header("Content-Type: application/vnd.ms-excel");
header("Content-disposition: attachment; filename=" . $filename);

ob_end_clean();

echo
"Name"
 . "\t Designation"
 . "\t Date Of Join"
 . "\t Contact Number"
 . "\t Astute Number"
 . "\t Process"
 . "\t Elision Id"
 . "\t Team Leader"
 . "\t Quality Analist"
 . "\t AsstManager"
 . "\t Process Manager"
 . "\n";
$i = 1;
while ($row = mysqli_fetch_array($result1)) {
    $Process = mysqli_fetch_array(mysqli_query($dbconn, "SELECT processname FROM `processmaster`  where isDelete='0'  and  istatus='1' and processmasterid='" . $row['iProcessid'] . "' "));
    $teamlead = mysqli_fetch_array(mysqli_query($dbconn, "SELECT empname FROM `employee`  where isDelete='0'  and  istatus='1' and employeeid='" . $row['iteamleadid'] . "' "));
    $qualityanalist = mysqli_fetch_array(mysqli_query($dbconn, "SELECT empname FROM `employee`  where isDelete='0'  and  istatus='1' and employeeid='" . $row['qualityanalistid'] . "' "));
    $asstmanagerid = mysqli_fetch_array(mysqli_query($dbconn, "SELECT empname FROM `employee`  where isDelete='0'  and  istatus='1' and employeeid='" . $row['asstmanagerid'] . "' "));
    $processmanager = mysqli_fetch_array(mysqli_query($dbconn, "SELECT empname FROM `employee`  where isDelete='0'  and  istatus='1' and employeeid='" . $row['processmanager'] . "' "));
    $filterDesignation = mysqli_fetch_array(mysqli_query($dbconn, "select designation.designation from employeedesignation inner join designation on designation.designationid = employeedesignation.iDesignationId where iEmployeeId='".$row['employeeid']."' "));
    echo
    $row['empname']
    . "\t" . $filterDesignation['designation']   
    . "\t" . $row['dojoin']
    . "\t" . $row['contactnumber']
    . "\t" . $row['astutenumber']
    . "\t" . $Process['processname']
    . "\t" . $row['elisionloginid']
    . "\t" . $teamlead['empname']
    . "\t" . $qualityanalist['empname']
    . "\t" . $asstmanagerid['empname']
    . "\t" . $processmanager['empname']
    . "\n";
    $i++;
}