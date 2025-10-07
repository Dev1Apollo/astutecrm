<?php
include('../config.php');
include('IsLogin.php');
ini_set('max_execution_time', 0);

$where = "WHERE 1=1";

// Date filter
if(isset($_REQUEST['formDate']) && $_REQUEST['formDate'] != ''){
    $where .= " AND STR_TO_DATE(applicationfollowup.strEntryDate, '%d-%m-%Y') >= STR_TO_DATE('" . mysqli_real_escape_string($dbconn, $_REQUEST['formDate']) . "', '%d-%m-%Y')";
}

if(isset($_REQUEST['toDate']) && $_REQUEST['toDate'] != ''){
    $where .= " AND STR_TO_DATE(applicationfollowup.strEntryDate, '%d-%m-%Y') <= STR_TO_DATE('" . mysqli_real_escape_string($dbconn, $_REQUEST['toDate']) . "', '%d-%m-%Y')";
}

// Employee filter based on designation
$whereEmp = "";
if ($_SESSION['Designation'] == 4) { // Team Leader
    if ($_REQUEST['EmployeeId'] != NULL && isset($_REQUEST['EmployeeId'])) {
        $whereEmp = " AND application.agentId='" . mysqli_real_escape_string($dbconn, $_REQUEST['EmployeeId']) . "'";
    } else {
        $whereEmp = " AND application.agentId IN (SELECT elisionloginid FROM employee WHERE iteamleadid='" . $_SESSION['EmployeeId'] . "')";
    }
} else if ($_SESSION['Designation'] == 6) { // Central Manager
    // if ($_REQUEST['EmployeeId'] != NULL && isset($_REQUEST['EmployeeId'])) {
    //     $whereEmp = " AND application.agentId='" . mysqli_real_escape_string($dbconn, $_REQUEST['EmployeeId']) . "'";
    // }
    // else {
    //     $whereEmp = " AND application.agentId IN (SELECT elisionloginid FROM employee WHERE asstmanagerid='" . $_SESSION['EmployeeId'] . "')";
    // }
} else { // Regular Employee
    $whereEmp = " AND applicationfollowup.agentId='" . $_SESSION['elisionloginid'] . "'";
}

// Main query for entry-wise report
$filterstr = "SELECT 
                application.iAppId,
                application.applicatipnNo,
                application.customerName,
                application.customerMobile,
                application.loanAmount,
                applicationfollowup.strEntryDate,
                applicationfollowup.mainDispoId,
                applicationfollowup.subDispoId,
                applicationfollowup.PTP_Amount,
                applicationfollowup.followupDate,
                applicationfollowup.PTPDate,
                applicationfollowup.remark,
                employee.empname as AgentName
            FROM applicationfollowup 
            INNER JOIN application ON application.iAppId = applicationfollowup.iAppId
            LEFT JOIN employee ON employee.elisionloginid = application.agentId
            $where $whereEmp 
            AND application.isWithdraw=0 
            AND application.isPaid=0 
            AND application.isDelete='0'  
            AND application.iStatus='1'
            ORDER BY STR_TO_DATE(applicationfollowup.strEntryDate, '%d-%m-%Y') ASC";

$result1 = mysqli_query($dbconn, $filterstr);
if (mysqli_num_rows($result1) > 0) {
    $filename = 'CRM_Entry_Wise_Report_' . date('d-m-Y H:i:s') . '.xls';

    header("Content-Type: application/vnd.ms-excel");
    header("Content-disposition: attachment; filename=" . $filename);

    ob_end_clean();

    echo
    // "Entry Date"
    //. "\t Loan Application No"
    "Loan Application No"
    . "\t Customer Name"
    . "\t Customer Mobile"
    . "\t Agent Name"
    . "\t POS Amount"
    . "\t Disposition"
    . "\t Sub Disposition"
    . "\t PTP Amount"
    . "\t Follow-up Date  / PTP Date"
    . "\t Disposition Date"
    . "\t Remark"
    . "\n";
    
    $i = 1;
    while ($row = mysqli_fetch_array($result1)) {
        // Format dates
        $entryDate = $row['strEntryDate'] ? date('d-m-Y', strtotime($row['strEntryDate'])) : '';
        
        if ($row['followupDate'] != "") {
            $followupDate = date('d-m-Y', strtotime($row['followupDate']));
        } else {
            $followupDate = '';
        }
        
        if ($row['PTPDate'] != '') {
            $ptpDate = date('d-m-Y', strtotime($row['PTPDate']));
        } else {
            $ptpDate = '';
        }

        // Get disposition name
        $dispositionName = '-';
        if ($row['mainDispoId']) {
            $filterDisPosition = mysqli_fetch_array(mysqli_query($dbconn, "SELECT dispoDesc FROM dispositionmaster WHERE iDispoId='" . $row['mainDispoId'] . "'"));
            $dispositionName = $filterDisPosition['dispoDesc'] ?? '-';
        }
        
        $subdispositionName = '-';
        if ($row['subDispoId']) {
            $filterDisPosition = mysqli_fetch_array(mysqli_query($dbconn, "SELECT dispoDesc FROM dispositionmaster WHERE iDispoId='" . $row['subDispoId'] . "'"));
            $subdispositionName = $filterDisPosition['dispoDesc'] ?? '-';
        }

        // Clean data for Excel
        $remark = preg_replace('/\s+/', ' ', trim(str_replace(array("\t", "\n", "\r"), ' ', $row['remark'])));
        $followupDate = $followupDate ? explode(' ', $followupDate)[0] : ($ptpDate ? explode(' ', $ptpDate)[0] : '-');
        echo
        // $entryDate
        $row['applicatipnNo']
        . "\t" . $row['customerName']
        . "\t" . $row['customerMobile']
        . "\t" . ($row['AgentName'] ?? '-')
        . "\t" . $row['loanAmount']
        . "\t" . $dispositionName
        . "\t" . $subdispositionName
        . "\t" . ($row['PTP_Amount'] ?: '-')
        . "\t" . $followupDate
        . "\t" . $entryDate
        . "\t" . $remark
        . "\n";
        $i++;
    }
} else {
    header('location:EntryWiseReport.php');
}
exit;
?>