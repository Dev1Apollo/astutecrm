<?php
ob_start();
include_once '../common.php';

$connect = new connect();

include('IsLogin.php');


$action = $_REQUEST['action'];


switch ($action) {

	 case "getcentralmanager":
		//echo "select * from employee where centralmanagerId=".$_REQUEST['ID']." and processmanager=0 and  isDelete=0 and istatus=1";
	 echo $_REQUEST['ID'];
		$resCM = mysqli_query($dbconn, "select * from employee where centralmanagerId=".$_REQUEST['ID']." and processmanager=0 and isDelete=0 and istatus=1");
			 $data='';

		if (mysqli_num_rows($resCM) > 0) {
				$data.="<option value='' >Select Process Manager</option>\n";
		
		    while ($result_PM =  mysqli_fetch_array($resCM)) {

		         $data.="<option value='".$result_PM['employeeid']."'>".$result_PM['empname']."</option>";
		    }
		}
		echo $data;

      break;

    default:


        echo "Page not Found";

        break;

}

?>