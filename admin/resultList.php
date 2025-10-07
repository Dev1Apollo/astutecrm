<?php
require_once('../common.php');
ob_start();                
/*$qry="SELECT e.empname,examassigneduser.examUserId,examassigneduser.isAutoSubmit,(select count(*) from questionanswer q where q.examId=examassigneduser.examId and isDelete='0' and istatus='1') as TotalQuestion,
(select count(*) from usertablesubmit us where us.userId=examassigneduser.userId and us.examId=examassigneduser.examId and us.userId=e.employeeid) as attendedQuestion,
(SELECT COUNT(*) FROM `questionanswer` QAUA WHERE QAUA.questionId NOT IN (SELECT questionId FROM usertablesubmit us WHERE QAUA.examId=us.examId and us.userId=examassigneduser.userId and QAUA.isDelete=0 and QAUA.questionId=us.questionId) and QAUA.examId=examassigneduser.examId and QAUA.isDelete=0 ) as unattempQuestion,
(SELECT COUNT(*) FROM usertablesubmit USANS INNER JOIN questionanswer QA WHERE USANS.examId=QA.examId AND USANS.questionId=QA.questionId AND USANS.selectAnswer=QA.rightAnswer AND USANS.userId=examassigneduser.userId and QA.isDelete=0 and USANS.examId='".$_REQUEST['id']."') AS RIGHTANSWER,
(SELECT COUNT(*) FROM usertablesubmit USANS INNER JOIN questionanswer QA WHERE USANS.examId=QA.examId AND USANS.questionId=QA.questionId AND USANS.selectAnswer!=QA.rightAnswer AND USANS.userId=examassigneduser.userId and USANS.examId='".$_REQUEST['id']."') AS WRONGANSWER,
IFNULL((SELECT sum(QA.questionMarks) FROM usertablesubmit USANS INNER JOIN questionanswer QA WHERE USANS.examId=QA.examId AND USANS.questionId=QA.questionId AND USANS.selectAnswer=QA.rightAnswer AND USANS.userId=examassigneduser.userId and QA.isDelete=0 and USANS.examId='".$_REQUEST['id']."' ),0) AS obtainMarks, 
(select (exam.iPassingMarks) from exammaster exam where exam.examId=examassigneduser.examId) as passingMarks FROM `employee` e inner join employeedesignation ed on e.employeeid=ed.iEmployeeId inner join  examassigneduser on examassigneduser.userId=e.employeeid where ed.iDesignationId in (4,1,5,9,12) and e.isDelete=0 and e.istatus=1 and examassigneduser.examId='".$_REQUEST['id']."' ORDER by e.empname ASC";
*/

$qry="SELECT e.empname,examassigneduser.examUserId,examassigneduser.isAutoSubmit,(select count(*) from questionanswer q where q.examId=examassigneduser.examId and isDelete='0' and istatus='1') as TotalQuestion,
(select count(*) from usertablesubmit us where us.userId=examassigneduser.userId and us.examId=examassigneduser.examId and us.userId=e.employeeid) as attendedQuestion,
(SELECT COUNT(*) FROM `questionanswer` QAUA WHERE QAUA.questionId NOT IN (SELECT questionId FROM usertablesubmit us WHERE QAUA.examId=us.examId and us.userId=examassigneduser.userId and QAUA.isDelete=0 and QAUA.questionId=us.questionId) and QAUA.examId=examassigneduser.examId and QAUA.isDelete=0 ) as unattempQuestion,
(SELECT COUNT(*) FROM usertablesubmit USANS INNER JOIN questionanswer QA WHERE USANS.examId=QA.examId AND USANS.questionId=QA.questionId AND USANS.selectAnswer=QA.rightAnswer AND USANS.userId=examassigneduser.userId and QA.isDelete=0 and USANS.examId='".$_REQUEST['id']."') AS RIGHTANSWER,
(SELECT COUNT(*) FROM usertablesubmit USANS INNER JOIN questionanswer QA WHERE USANS.examId=QA.examId AND USANS.questionId=QA.questionId AND USANS.selectAnswer!=QA.rightAnswer AND USANS.userId=examassigneduser.userId and USANS.examId='".$_REQUEST['id']."') AS WRONGANSWER,
IFNULL((SELECT sum(QA.questionMarks) FROM usertablesubmit USANS INNER JOIN questionanswer QA WHERE USANS.examId=QA.examId AND USANS.questionId=QA.questionId AND USANS.selectAnswer=QA.rightAnswer AND USANS.userId=examassigneduser.userId and QA.isDelete=0 and USANS.examId='".$_REQUEST['id']."' ),0) AS obtainMarks, 
(select (exam.iPassingMarks) from exammaster exam where exam.examId=examassigneduser.examId) as passingMarks FROM `employee` e inner join employeedesignation ed on e.employeeid=ed.iEmployeeId inner join  examassigneduser on examassigneduser.userId=e.employeeid where ed.iDesignationId in (4,1,5,9,12,18) and e.istatus=1 and examassigneduser.examId='".$_REQUEST['id']."' ORDER by e.empname ASC";
// and e.isDelete=0
$sql=mysqli_query($dbconn,$qry);  

$filename = 'Result' . date('d-m-Y H:i:s') . '.xls';
header("Content-Type: application/vnd.ms-excel");
header("Content-disposition: attachment; filename=" . $filename);
ob_end_clean();
$filterstr="select * from exammaster where examId='".$_REQUEST['id']."'  and istatus=1 and isDelete=0";
$resultfilter = mysqli_query($dbconn, $filterstr);
$rowfilter = mysqli_fetch_array($resultfilter);

echo
"Exam Name"
 . "\t ".$rowfilter['examTitle']
 . "\t "
 . "\t  Total Marks"
 . "\t ".$rowfilter['Marks']
  . "\t"
  . "\t Exam Date :"
  . "\t". date('d-m-Y',strtotime($rowfilter['examDateTime']))
  . "\n";

 echo 
  " Exam Start Time:"
  ."\t".date('H:i:s',strtotime($rowfilter['examDateTime']))
  ."\t"
  ."\t Exam Duration Time :"
  ."\t".$rowfilter['examDuration']
  ."\t"
  ."\t Exam End Date & Time:"
  ."\t".$rowfilter['examEndDateTime']
  ."\n";

echo
"SrNo"
 . "\t  Employee Name"
 . "\t  Total Question"
 . "\t  Attempted Question"
 . "\t  Unattempted Question"
 . "\t  Right answer"
 . "\t  Wrong Answer"
 . "\t  Obtain Marks"
 . "\t  Passing Marks"
 . "\t  Result"
. "\n";

$i = 1;

while ($row = mysqli_fetch_assoc($sql)) {
    if ($row['TotalQuestion']==$row['unattempQuestion'] &&$row['isAutoSubmit']==0) {
                                $result="Unattempted Exam";
                            }else{
    $result=$row['obtainMarks'];
    if ($result>=$row['passingMarks'] ) {
      $result= "Pass";
    }else{
      $result="Fail";
    }}
    $result;                      
    echo
    $i
    . "\t" . $row['empname']
    . "\t" . $row['TotalQuestion']
    . "\t" . $row['attendedQuestion']
    . "\t" . $row['unattempQuestion']
    . "\t" . $row['RIGHTANSWER']
    . "\t" . $row['WRONGANSWER']
    . "\t" . $row['obtainMarks']
    . "\t" . $row['passingMarks']
    . "\t" . $result
         . "\n";
    $i++;
  }
?>