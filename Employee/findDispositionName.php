<?php
error_reporting(0);
include('../config.php');
include('IsLogin.php');

$ID=intval($_GET['ID']);
//echo "SELECT * FROM `dispositionmaster` where dispoType='".$ID."' and masterDispoId='0'";
$result=mysqli_query($dbconn,"SELECT iDispoId,dispoDesc FROM `dispositionmaster` where dispoType='".$ID."' and masterDispoId='0'");
$data='<select name="disposition_name" id="disposition_name" required="" class="form-control" onchange="checkSubDispos();">
<option value="">Select Disposition Name</option>';
 while($row=mysqli_fetch_array($result)) { 
	$data.='<option value='.$row['iDispoId'].'>'.$row['dispoDesc'].'</option>';
}
$data .='</select>';
echo $data;
?>
