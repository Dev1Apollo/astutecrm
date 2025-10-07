<?php

ob_start();

include('../config.php');
include('IsLogin.php');

$query = "select * from employee where elisionloginid = '" . $_GET['ID'] . "' and isDelete='0' ";
$result = mysqli_query($dbconn, $query);
if (mysqli_num_rows($result) >= 1) {
    echo 'Login ID Already Exits';
} else {
    echo '0';
}
?>