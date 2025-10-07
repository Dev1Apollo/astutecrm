<?php

error_reporting(0);
include('../config.php');
include('IsLogin.php');

$ID = intval($_GET['ID']);
//echo "SELECT * FROM `dispositionmaster` where masterDispoId='".$ID."' and masterDispoId!=0";
$result = mysqli_query($dbconn, "SELECT iDispoId,dispoDesc FROM `dispositionmaster` where masterDispoId='" . $ID . "' and masterDispoId!=0");
if (mysqli_num_rows($result) > 0) {
    $data = '<select name="sub_disposition" id="sub_disposition" class="form-control" >
<option value="">Select Sub Disposition Name</option>';
    while ($row = mysqli_fetch_array($result)) {
        $data.='<option value=' . $row['iDispoId'] . '>' . $row['dispoDesc'] . '</option>';
    }
    $data .='</select>';
} else {
//    $data = '<select name="sub_disposition" id="sub_disposition" class="form-control" >
//<option value="">Select Sub Disposition Name</option>';
    $data.='0';
}


echo $data;
?>