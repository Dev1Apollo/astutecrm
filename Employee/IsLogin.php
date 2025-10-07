<?php 
if(!isset($_SESSION['EmployeeId']) && !isset($_SESSION['EmployeeName']))
{
	header('location:'.$web_url.'Employee/login.php');	
}

?>