<?php
include_once '../config.php';
include('IsLogin.php');

$language = intval($_GET['ID']);
//
//$result = mysqli_query($dbconn, "select * from city  where  istatus='1' and isDelete='0' and state_id=" . $sId . " order by city_name ASC");
//$data = '<select name="City" id="City" class="form-control">
//<option value="0">Select City Name</option>';
//while ($row = mysqli_fetch_array($result)) {
//    $data.='<option value=' . $row['city_id'] . '>' . $row['city_name'] . '</option>';
//}
//$data .='</select>';
//echo $data;

$queryCom = "SELECT * FROM `faq` where language='".$language."' and isDelete='0'  and  istatus='1' order by  faqid asc";
$resultCom = mysqli_query($dbconn, $queryCom);
$data = '<select class="form-control" name="faqid" id="faqid" required="">';
$data.= "<option value='' >Select FAQ</option>";
while ($rowCom = mysqli_fetch_array($resultCom)) {
    $data.= "<option value='" . $rowCom ['faqid'] . "'>" . $rowCom ['strfaq'] . "</option>";
}
$data.= "</select>";
echo $data;
?>
