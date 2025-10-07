<?php
require_once('../common.php');
ob_start();                
 $qry="SELECT * FROM `employee`  where 1=1 and isDelete='0'  and  istatus='1' order by elisionloginid asc";

$sql=mysqli_query($dbconn,$qry);  

$filename = 'Employee List' . date('d-m-Y H:i:s') . '.xls';
 header("Content-Type: application/vnd.ms-excel");
header("Content-disposition: attachment; filename=" . $filename);
ob_end_clean();

echo
"SrNo"
 . "\t  Name"
 . "\t  Designation"
 . "\t  Date Of Join"
 . "\t  Contact Number"  
 . "\t  Astute Number"
 . "\t  Process"
 . "\t  Elision Login Id"
 . "\t  Team Lead"
 . "\t  Quality Analist"
 . "\t  AsstManager"
 . "\t  Process Manager"
. "\n";

$i = 1;

while ($row = mysqli_fetch_assoc($sql)) {
       
                    
    echo $value1=$i. "\t" . $row['empname'];
    $filterDesignation = mysqli_fetch_array(mysqli_query($dbconn, "select designation.designation from employeedesignation inner join designation on designation.designationid = employeedesignation.iDesignationId where iEmployeeId='".$row['employeeid']."' "));
    echo $value2="\t" . $filterDesignation['designation']
    . "\t" . $row['dojoin']
    . "\t" . $row['contactnumber']
    . "\t" . $row['astutenumber'];


    $Process = mysqli_fetch_array(mysqli_query($dbconn, "SELECT * FROM `processmaster`  where isDelete='0'  and  istatus='1' and processmasterid='" . $row['iProcessid'] . "' "));

    echo $value3="\t" . $Process['processname']."\t".$row['elisionloginid'];


    if(isset($row['iteamleadid']) && $row['iteamleadid'] != 0){
      $teamlead = mysqli_fetch_array(mysqli_query($dbconn, "SELECT * FROM `employee`  where isDelete='0'  and  istatus='1' and employeeid='" . $row['iteamleadid'] . "' "));
      echo $value4="\t". $teamlead['empname']; 
    } else {
      echo $value4="\t ";
    }

    if (isset($row['qualityanalistid']) && $row['qualityanalistid']!=0) {
    $qualityanalist = mysqli_fetch_array(mysqli_query($dbconn, "SELECT * FROM `employee`  where isDelete='0'  and  istatus='1' and employeeid='" . $row['qualityanalistid'] . "' "));
   echo  $value5="\t".$qualityanalist['empname'];
   }else{
    echo  $value5="\t";
   }


   if (isset($row['asstmanagerid'])&&$row['asstmanagerid']) {
   $asstmanagerid = mysqli_fetch_array(mysqli_query($dbconn, "SELECT * FROM `employee`  where isDelete='0'  and  istatus='1' and employeeid='" . $row['asstmanagerid'] . "' "));
   echo $value6="\t".$asstmanagerid['empname'];
   }else{
    echo $value6="\t";
   }


   if (isset($row['processmanager'])&&$row['processmanager']!=0) {
   $processmanager = mysqli_fetch_array(mysqli_query($dbconn, "SELECT * FROM `employee`  where isDelete='0'  and  istatus='1' and employeeid='" . $row['processmanager'] . "' "));
   echo $value7="\t".$processmanager['empname']."\n";
    }else{
      echo $value7="\t";
    }
    
    echo $value8="\n";
    $i++;
  }
?>