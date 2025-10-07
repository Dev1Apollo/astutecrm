<?php
require_once('../common.php');
ob_start();                

/*$qry="SELECT examassigneduser.SubmitDateTime as stemptime,examassigneduser.userId, 
CONCAT(IFNULL((SELECT sum(QA.questionMarks) FROM usertablesubmit USANS INNER JOIN questionanswer QA WHERE USANS.examId=QA.examId AND USANS.questionId=QA.questionId AND USANS.selectAnswer=QA.rightAnswer AND USANS.userId=examassigneduser.userId and QA.isDelete=0 and USANS.examId='".$_REQUEST['id']."' ),0) ,' / ',
(select exam.Marks from exammaster exam where exam.examId=examassigneduser.examId) ) as score,e.empname,
(select em.empname from employee em where em.employeeid=e.iteamleadid) as TLname
FROM `employee` e inner join employeedesignation ed on e.employeeid=ed.iEmployeeId inner join examassigneduser on examassigneduser.userId=e.employeeid  where ed.iDesignationId=5 and e.isDelete=0 and e.istatus=1 and examassigneduser.examId='".$_REQUEST['id']."'";*/
$qry="SELECT examassigneduser.SubmitDateTime as stemptime,examassigneduser.userId, 
CONCAT(IFNULL((SELECT sum(QA.questionMarks) FROM usertablesubmit USANS INNER JOIN questionanswer QA WHERE USANS.examId=QA.examId AND USANS.questionId=QA.questionId AND USANS.selectAnswer=QA.rightAnswer AND USANS.userId=examassigneduser.userId and QA.isDelete=0 and USANS.examId='".$_REQUEST['id']."' ),0) ,' / ',
(select exam.Marks from exammaster exam where exam.examId=examassigneduser.examId) ) as score,e.empname,
(select em.empname from employee em where em.employeeid=e.iteamleadid) as TLname
FROM `employee` e inner join employeedesignation ed on e.employeeid=ed.iEmployeeId inner join examassigneduser on examassigneduser.userId=e.employeeid  where  e.istatus=1 and examassigneduser.examId='".$_REQUEST['id']."'";
//e.isDelete=0 and
$sql=mysqli_query($dbconn,$qry);  

$filename = 'Result' . date('d-m-Y H:i:s') . '.xls';
header("Content-Type: application/vnd.ms-excel");
header("Content-disposition: attachment; filename=" . $filename);
ob_end_clean();

$query = mysqli_query($dbconn,"select q.question from questionanswer q where  isDelete='0' and istatus='1' and examId='".$_REQUEST['id']."' order by questionId asc");


  echo $preheader1 = ("Timestamp"
                      ."\t  Score"
                      ."\t Agent Name"
                      ."\t  Team Leader Name");
while ($rowfilter = mysqli_fetch_array($query)) {   
 echo  $preheader2 = ("\t". $rowfilter['question']); 
}  
echo $preheader3="\n";
  

    

  while ($row = mysqli_fetch_assoc($sql)) {        
   
  
  echo   $value1=($row['stemptime']
              ."\t".$row['score']
              ."\t".$row['empname']
              ."\t".$row['TLname']);


   $qryans=mysqli_query($dbconn,"select *,(select usertablesubmit.selectAnswer from usertablesubmit where usertablesubmit.questionId= questionanswer.questionId and usertablesubmit.userId=examassigneduser.userId and usertablesubmit.examId=questionanswer.examId) as Answer from questionanswer,examassigneduser where questionanswer.examId ='".$_REQUEST['id']."' and questionanswer.examId=examassigneduser.examId and questionanswer.isDelete=0 and examassigneduser.userId ='".$row['userId']."' order by questionId asc");
              while ($rowans = mysqli_fetch_assoc($qryans)) {
                          if ($rowans['Answer']==1) {
                              $Ans= $rowans['option1'];
                          }elseif ($rowans['Answer']==2) {
                               $Ans=$rowans['option2'];
                          }elseif ($rowans['Answer']==3) {
                               $Ans=$rowans['option3'];
                         } elseif ($rowans['Answer']==4) {
                               $Ans=$rowans['option4'];
                         }
                           else {
                               $Ans="";
                          }
             echo  $value2="\t".$Ans;
              }
      echo    $value3="\n";
  }
?>