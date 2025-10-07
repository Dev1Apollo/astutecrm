<?php

include('../config.php');
include('IsLogin.php');
ini_set('max_execution_time', 0);

function cleanComment($comment) {
    if (empty($comment)) return '';
    
    // First, normalize line endings and HTML breaks
    $cleaned = preg_replace('/[\r\n]+|<br\s*\/?>/i', ' ', $comment);
    
    // Replace tabs with single space
    $cleaned = str_replace("\t", " ", $cleaned);
    
    // Allow common punctuation: , . ? ! - : ; ( ) %
    // Allow basic math symbols: + - / *
    // Allow currency symbols: $ € £ ₹
    // Allow apostrophes and quotes for proper nouns
    $cleaned = preg_replace('/[^\w\s,.?!\-:;()%+\/*$€£₹\'"@#&=]/u', '', $cleaned);
    
    // Collapse multiple spaces into one
    $cleaned = preg_replace('/\s+/', ' ', $cleaned);
    
    // Trim whitespace from both ends
    return trim($cleaned);
}

$where = "where 1=1";
if (isset($_REQUEST['formDate']) && $_REQUEST['formDate'] != '') {
    $where.=" and STR_TO_DATE(onlinefeedback.strEntryDate,'%d-%m-%Y')>= STR_TO_DATE('" . $_REQUEST['formDate'] . "','%d-%m-%Y')";
} 
// else {
//     $where.=" and STR_TO_DATE(customerfeedback.strEntryDate,'%d-%m-%Y')>= STR_TO_DATE('" . $date . "','%d-%m-%Y')";
// }
if (isset($_REQUEST['toDate']) && $_REQUEST['toDate'] != '') {
    $where.=" and STR_TO_DATE(onlinefeedback.strEntryDate,'%d-%m-%Y')<=STR_TO_DATE('" . $_REQUEST['toDate'] . "','%d-%m-%Y')";
}

if($_SESSION['Designation'] == 1 || $_SESSION['Designation'] == 9){
    $where.=" and onlinefeedback.complainBy='".$_SESSION['EmployeeId']."'";
}

$filterstr = "SELECT 
(select historyfeedback.strEntryDate from historyfeedback where historyfeedback.feedbackId=onlinefeedback.feedbackId ORDER by historyfeedback.historyFeedbackId asc limit 1) as RaisedDate,
(select employee.empname from employee where employee.employeeid=onlinefeedback.complainBy) as FeedbackFrom,
(select employee.empname from employee where employee.employeeid=onlinefeedback.agentId) as FeedbackTo,
(select employee.elisionloginid from employee where employee.employeeid=onlinefeedback.agentId) as elisionloginid,
(select tl.empname from employee inner join employee as tl on employee.iteamleadid=tl.employeeid where employee.employeeid=onlinefeedback.agentId) as AgentTl,
(select feedbackcategory.categoryName from feedbackcategory where feedbackcategory.feedbackCategoryId=onlinefeedback.feedbackCategoryId) as FeedbackCategory,
comment,
CASE 
	WHEN status = 1 THEN 'Pending'
    WHEN status = 2 THEN 'Disputed'
    WHEN status = 3 THEN 'Closed'
    ELSE 'Unknown'
END AS Status,
(select employee.empname from historyfeedback inner join employee on  historyfeedback.statusby=employee.employeeid where historyfeedback.feedbackId=onlinefeedback.feedbackId and historyfeedback.status=2 order by historyfeedback.historyFeedbackId desc limit 1) AS Disputedfrom,
(select historyfeedback.historyComment from historyfeedback where historyfeedback.feedbackId=onlinefeedback.feedbackId and historyfeedback.status=2 order by historyfeedback.historyFeedbackId desc limit 1) AS DisputedComment,
(select historyfeedback.strEntryDate from historyfeedback where historyfeedback.feedbackId=onlinefeedback.feedbackId and historyfeedback.status=2 order by historyfeedback.historyFeedbackId desc limit 1)  AS DisputedDate,
onlinefeedback.strEntryDate,statusDate,feedbackId
 FROM `onlinefeedback` " . $where . " order by STR_TO_DATE(onlinefeedback.strEntryDate,'%d-%m-%Y') DESC";

$result1 = mysqli_query($dbconn, $filterstr);
if (mysqli_num_rows($result1) > 0) {
    $filename = 'Feedback_Report_' . date('d-m-Y H:s:i') . '.xls';

    header("Content-Type: application/vnd.ms-excel");
    header("Content-disposition: attachment; filename=" . $filename);

    ob_end_clean();

    echo
    "Sr. No."
    . "\t Feedback Id"
    . "\t Raised Date"
    . "\t Feedback From"
    . "\t Feedback To"
    . "\t Elision Id"
    . "\t Agent TL"
    . "\t Feedback Category"
    . "\t Feedback Comment"
    . "\t Disputed"
    . "\t Disputed From"
    . "\t Disputed Date"
    . "\t Disputed Comment"
    . "\t Closed"
    . "\t Closure Date"
    . "\n";
    $i = 1;
    while ($row = mysqli_fetch_array($result1)) {
        $DisputedStatus = "";
        if($row['DisputedComment'] != ''){
            $DisputedStatus = "Yes";
        } else {
           $DisputedStatus = "No";
        }
        $Status = "";
        if($row['Status'] == 'Closed'){
            $Status = "Yes";
        } else {
           $Status = "No";
        }
        $StatusDate = "";
        if($row['Status'] == 'Closed'){
            $StatusDate = $row['statusDate']; 
        } else {
           $StatusDate = "-";
        }
        
        /*$cleaned_comment = preg_replace('/[\r\n]+|<br\s*\/?>/i', ' ', preg_replace('/[^A-Za-z0-9\s.,?!]/', '', $row['comment']));
        $cleaned_comment = str_replace("\t", " ", $cleaned_comment); // Replace tabs with space
        $cleaned_comment = trim($cleaned_comment); // Remove extra whitespace
        
        $cleaned_DisputedComment = preg_replace('/[\r\n]+|<br\s*\/?>/i', ' ', preg_replace('/[^A-Za-z0-9\s.,?!]/', '', $row['DisputedComment']));
        $cleaned_DisputedComment = str_replace("\t", " ", $cleaned_DisputedComment); // Replace tabs with space
        $cleaned_DisputedComment = trim($cleaned_DisputedComment); // Remove extra whitespace */

        echo
        $i
        . "\t" . $row['feedbackId']
        . "\t" . $row['RaisedDate']
        . "\t" . $row['FeedbackFrom']
        . "\t" . $row['FeedbackTo']
        
        . "\t" . $row['elisionloginid']
        . "\t" . $row['AgentTl']
        
        . "\t" . $row['FeedbackCategory']
        . "\t" . cleanComment($row['comment'])
        . "\t" . $DisputedStatus
        . "\t" . $row['Disputedfrom']
        . "\t" . $row['DisputedDate']
        . "\t" . cleanComment($row['DisputedComment'])
        . "\t" . $Status
        . "\t" . $StatusDate
        . "\n";
        $i++;
    }
    
    

} else {
    header('location:FeedbackReport.php');
}
exit;
