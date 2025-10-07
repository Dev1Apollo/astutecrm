<?php
ob_start();
include('../config.php');
include('IsLogin.php');
if($_REQUEST['action']=='teamleaduser'){
    echo $query="SELECT * FROM `employee` join employeedesignation on employee.employeeid=employeedesignation.iEmployeeId WHERE employee.isDelete = 0 and employeedesignation.iDesignationId=4";
}else{
    if($_REQUEST['teamleadId'])
        $query="SELECT * FROM `employee` join employeedesignation on employee.employeeid=employeedesignation.iEmployeeId WHERE employee.isDelete = 0 and employee.iteamleadid=".$_REQUEST['teamleadId']." and employeedesignation.iDesignationId=".$_REQUEST['warningfor'] ;
    else
        $query="SELECT * FROM `employee` join employeedesignation on employee.employeeid=employeedesignation.iEmployeeId WHERE employee.isDelete = 0 and employeedesignation.iDesignationId=".$_REQUEST['warningfor'] ;
}
$result=mysqli_query($dbconn,$query);
if(mysqli_num_rows($result)>= 1)
{
    echo '<option value="">Select Employee</option>';
	while($row=mysqli_fetch_assoc($result)){
        echo '<option value="'.$row['employeeid'].'">'.$row['empname'].'</option>';
    }
}

?>