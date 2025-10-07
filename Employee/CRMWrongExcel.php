<?php

include('../config.php');
include('IsLogin.php');
ini_set('max_execution_time', 0);

$where = "where 1=1";

$filterstr = "SELECT applicatipnNo,bucket,customerName,branch,state,customerAddress,customerCity,customerZipcode,loanAmount,EMIAmount,agencyName,FOSName,FosNumber,agentId,ErrorLog FROM `worngapplication` " . $where . " and isDelete='0'  and  iStatus='1'  ORDER BY STR_TO_DATE(`strEntryDate`,'%d-%m-%Y') ASC";

$result1 = mysqli_query($dbconn, $filterstr);
if (mysqli_num_rows($result1) > 0) {
    $filename = 'Wrong_Upload_CRM_Data_' . date('d-m-Y H:s:i') . '.xls';

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
    . "\t Error"
    . "\n";
    $i = 1;
    while ($row = mysqli_fetch_array($result1)) {
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
        . "\t" . preg_replace('/\s+/', ' ', trim(str_replace(',', '.', $row['ErrorLog'])))
        . "\n";
        $i++;
    }
} else {
    header('location:WrongCrm.php');
}
exit;
