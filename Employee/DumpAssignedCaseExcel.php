<?php
error_reporting(0);
include('../common.php');
include('IsLogin.php');
$connect = new connect();

header("Content-Type: application/xls");
header("Content-Disposition: attachment; filename=DumpAssignedCase_" . date('Ymd_His') . ".xls");
header("Pragma: no-cache");
header("Expires: 0");

$where = "WHERE 1=1";

if (!empty($_GET['formDate'])) {
    $where .= " AND STR_TO_DATE(application.strEntryDate, '%d-%m-%Y') >= STR_TO_DATE('" . $_GET['formDate'] . "', '%d-%m-%Y')";
}
if (!empty($_GET['toDate'])) {
    $where .= " AND STR_TO_DATE(application.strEntryDate, '%d-%m-%Y') <= STR_TO_DATE('" . $_GET['toDate'] . "', '%d-%m-%Y')";
}
// if (!empty($_GET['applicatipnNo'])) {
//     $where .= " AND a.applicatipnNo LIKE '%" . mysqli_real_escape_string($dbconn, $_GET['applicatipnNo']) . "%'";
// }

$query = "SELECT application.iAppId,application.bucket,application.isEmiPending,application.applicatipnNo,application.customerName,application.branch,application.state,application.customerAddress,application.customerCity, application.agencyId, "
            . "application.customerZipcode,application.loanAmount,application.EMIAmount,application.agencyName,application.FOSName,application.customerAddress,application.FosNumber, application.customerMobile,"
            . "applicationfollowup.strEntryDate,applicationfollowup.mainDispoId,applicationfollowup.followupDate,applicationfollowup.PTPDate,applicationfollowup.PTP_Amount,applicationfollowup.remark,(select employee.empname from employee where employee.elisionloginid=application.agentId) as employeeName"
            . " FROM `application` LEFT JOIN "
            . "applicationfollowup ON application.iAppLogId=applicationfollowup.iAppLogId  " . $where . " and isWithdraw=0 and isPaid=0 and isDelete='0'  and  iStatus='1'ORDER BY STR_TO_DATE(application.strEntryDate, '%d-%m-%Y') DESC, application.iAppId DESC";

$result = mysqli_query($dbconn, $query);

echo "<table border='1'>";
echo "<tr>
        <th>#</th>
        <th>Loan App No</th>
        <th>Customer Name</th>
        <th>Customer Mobile</th>
        <th>Total Attempt</th>
        <th>Total Connect</th>
        <th>POS Amount</th>
        <th>Last Call Date</th>
        <th>Last Disposition</th>
        <th>PTP Amount</th>
        <th>Follow-up / PTP Date</th>
        <th>Follow-up / PTP Time</th>
        <th>Remark</th>
        <th>Agent Name</th>
      </tr>";

$i = 1;
while ($rowfilter = mysqli_fetch_array($result)) {
    $lastCall = $rowfilter['strEntryDate'] ? date('d-m-Y H:i', strtotime($rowfilter['strEntryDate'])) : '-';
    if ($rowfilter['followupDate'] != "") {
        $date = explode(" ", $rowfilter['followupDate']);
    } else if ($rowfilter['PTPDate'] != '') {
        $date = explode(" ", $rowfilter['PTPDate']);
    } else {
        $date = array("", "");
    }
    
    $filterDisPosition = mysqli_fetch_array(mysqli_query($dbconn, "Select dispoDesc from dispositionmaster where iDispoId='" . $rowfilter['mainDispoId'] . "'"));
    $LastDisposition = $filterDisPosition['dispoDesc'];
    
    echo "<tr>
            <td>$i</td>
           <td>{$rowfilter['applicatipnNo']}</td>
                                <td>{$rowfilter['customerName']}</td>
                                <td>{$rowfilter['customerMobile']}</td>
                                <td style='text-align:center;'>{$rowfilter['TotalAttempt']}</td>
                                <td style='text-align:center;'>{$rowfilter['TotalConnect']}</td>
                                <td style='text-align:right;'>{$rowfilter['loanAmount']}</td>
                                <td>{$lastCall}</td>
                                <td>{$LastDisposition}</td>
                                <td style='text-align:right;'>{$rowfilter['PTP_Amount']}</td>
                                <td>{$date['0']}</td>
                                <td>{$date['1']}</td>
                                <td>{$rowfilter['remark']}</td>
                                <td>{$rowfilter['employeeName']}</td>
          </tr>";
    $i++;
}
echo "</table>";
?>
