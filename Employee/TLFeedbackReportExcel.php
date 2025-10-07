<?php

include('../config.php');
include('IsLogin.php');
ini_set('max_execution_time', 0);

$where = "where 1=1";
if (isset($_REQUEST['formDate']) && $_REQUEST['formDate'] != '') {
    $where.=" and STR_TO_DATE(customerfeedback.strEntryDate,'%d-%m-%Y')>= STR_TO_DATE('" . $_REQUEST['formDate'] . "','%d-%m-%Y')";
} else {
    $where.=" and STR_TO_DATE(customerfeedback.strEntryDate,'%d-%m-%Y')>= STR_TO_DATE('" . $date . "','%d-%m-%Y')";
}
if (isset($_REQUEST['toDate']) && $_REQUEST['toDate'] != '') {
    $where.=" and STR_TO_DATE(customerfeedback.strEntryDate,'%d-%m-%Y')<=STR_TO_DATE('" . $_REQUEST['toDate'] . "','%d-%m-%Y')";
}
$whereEmp = "";
if ($_SESSION['Designation'] == 4) {
    $whereEmp.=" and enterBy in (select employee.employeeid from employee where iteamleadid='" . $_SESSION['EmployeeId'] . "')";
} else {
    $whereEmp.=" and enterBy='" . $_SESSION['elisionloginid'] . "'";
}
$filterstr = "SELECT * FROM `customerfeedback` inner join feedback on feedback.iFeedbackId=customerfeedback.iFeedbackId  " . $where . $whereEmp . " order by STR_TO_DATE(customerfeedback.strEntryDate,'%d-%m-%Y') DESC";
    
$result1 = mysqli_query($dbconn, $filterstr);
if (mysqli_num_rows($result1) > 0) {
    $filename = 'Agent_Feedback_Report_' . date('d-m-Y H:s:i') . '.xls';

    header("Content-Type: application/vnd.ms-excel");
    header("Content-disposition: attachment; filename=" . $filename);

    ob_end_clean();

    echo
    "Loan Application No"
    . "\t Feedback"
    . "\t Enter By"
    . "\t Entry Date"
    . "\n";
    $i = 1;
    while ($row = mysqli_fetch_array($result1)) {
        $filterEmployee = mysqli_fetch_array(mysqli_query($dbconn, "Select empname from employee where employeeid='" . $row['enterBy'] . "' "));
        echo
        $row['applicatipnNo']
        . "\t" . $row['strfeedbackName']
        . "\t" . $filterEmployee['empname']
        . "\t" . $row['strEntryDate']
        . "\n";
        $i++;
    }
} else {
    header('location:TLFeedbackReport.php');
}
exit;
