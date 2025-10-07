<?php
include('../config.php');
include('IsLogin.php');
ini_set('max_execution_time', 0);

$where = "WHERE 1=1";

// Date filter for PTP date
if(isset($_REQUEST['formDate']) && $_REQUEST['formDate'] != ''){
    $where .= " AND STR_TO_DATE(latest_followup.PTPDate, '%d-%m-%Y') >= STR_TO_DATE('" . mysqli_real_escape_string($dbconn, $_REQUEST['formDate']) . "', '%d-%m-%Y')";
}

if(isset($_REQUEST['toDate']) && $_REQUEST['toDate'] != ''){
    $where .= " AND STR_TO_DATE(latest_followup.PTPDate, '%d-%m-%Y') <= STR_TO_DATE('" . mysqli_real_escape_string($dbconn, $_REQUEST['toDate']) . "', '%d-%m-%Y')";
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
    // } else {
    //     $whereEmp = " AND application.agentId IN (SELECT elisionloginid FROM employee WHERE asstmanagerid='" . $_SESSION['EmployeeId'] . "')";
    // }
} else { // Regular Employee
    $whereEmp = " AND application.agentId='" . $_SESSION['elisionloginid'] . "'";
}

// Main query for Agent Wise PTP Report
$filterstr = "SELECT 
                application.iAppId,
                application.applicatipnNo,
                application.customerName,
                application.loanAmount,
                latest_followup.PTP_Amount,
                latest_followup.PTPDate,
                latest_followup.subDispoId,
                latest_followup.remark,
                employee.empname as AgentName
            FROM application 
            INNER JOIN (
                SELECT 
                    iAppId,
                    MAX(iAppLogId) as latest_log_id
                FROM applicationfollowup 
                GROUP BY iAppId
            ) latest ON application.iAppId = latest.iAppId
            INNER JOIN applicationfollowup latest_followup ON latest.latest_log_id = latest_followup.iAppLogId
            LEFT JOIN employee ON employee.elisionloginid = application.agentId
            $where $whereEmp 
            AND application.isWithdraw=0 
            AND application.isPaid=0 
            AND application.isDelete='0'  
            AND application.iStatus='1'
            AND latest_followup.mainDispoId = '12'  -- Promise to Pay disposition
            AND latest_followup.PTPDate IS NOT NULL
            AND latest_followup.PTPDate != ''
            ORDER BY STR_TO_DATE(latest_followup.PTPDate, '%d-%m-%Y') ASC, application.agentId ASC";

$result1 = mysqli_query($dbconn, $filterstr);
if (mysqli_num_rows($result1) > 0) {
    $filename = 'CRM_Agent_PTP_Report_' . date('d-m-Y H:i:s') . '.xls';

    header("Content-Type: application/vnd.ms-excel");
    header("Content-disposition: attachment; filename=" . $filename);

    ob_end_clean();

    echo
    "Sr No"
    . "\t Loan App No"
    . "\t Customer Name"
    . "\t Agent Name"
    . "\t PTP Date"
    . "\t PTP Amount"
    . "\t Sub Disposition"
    . "\t Remarks"
    . "\n";
    
    $i = 1;
    while ($row = mysqli_fetch_array($result1)) {
        // Format PTP Date
        $ptpDate = '';
        if ($row['PTPDate'] != '') {
            $ptpDate = date('d-m-Y', strtotime($row['PTPDate']));
        }

        // Get sub disposition name
        $subdispositionName = '-';
        if ($row['subDispoId']) {
            $filterSubDisPosition = mysqli_fetch_array(mysqli_query($dbconn, "SELECT dispoDesc FROM dispositionmaster WHERE iDispoId='" . $row['subDispoId'] . "'"));
            $subdispositionName = $filterSubDisPosition['dispoDesc'] ?? '-';
        }

        // Clean data for Excel
        $remark = preg_replace('/\s+/', ' ', trim(str_replace(array("\t", "\n", "\r"), ' ', $row['remark'])));

        echo
        $i
        . "\t" . $row['applicatipnNo']
        . "\t" . $row['customerName']
        . "\t" . ($row['AgentName'] ?? '-')
        . "\t" . $ptpDate
        . "\t" . ($row['PTP_Amount'] ?: '0')
        . "\t" . $subdispositionName
        . "\t" . $remark
        . "\n";
        $i++;
    }
} else {
    header('location:AgentPTPReport.php');
}
exit;
?>