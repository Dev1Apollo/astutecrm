<?php

error_reporting(E_ALL);
include('../config.php');
include('IsLogin.php');

$strfilter = $_GET['strfilter'];
$whereEmp = "";

if ($_SESSION['Designation'] == 4) {
    if (is_numeric($_SESSION['elisionloginid'])) {
        $whereEmp .= " agentId=" . $_SESSION['elisionloginid'];
    } else {
        $whereEmp.=" agentId in (select elisionloginid from employee where iteamleadid='" . $_SESSION['EmployeeId'] . "')";
    }
} else if ($_SESSION['Designation'] == 6) {
    $whereEmp.=" agentId in (select elisionloginid from employee)";
} else {
    $whereEmp .= " agentId=" . $_SESSION['elisionloginid'];
}

//if ($strfilter == 'applicatipnNo') {
//    $result = mysqli_query($dbconn, "SELECT applicatipnNo FROM `application` where " . $whereEmp . " and bucket!='' order by applicatipnNo desc");
//    if (mysqli_num_rows($result) > 0) {
//        $data = '<select name="filterValue" id="filterValue" required="" class="form-control" >
//<option value="">Select Application Number</option>';
//        while ($row = mysqli_fetch_array($result)) {
//            $data.='<option value=' . $row['applicatipnNo'] . '>' . $row['applicatipnNo'] . '</option>';
//        }
//    } else {
//        $data = '<select name="filterValue" id="filterValue" class="form-control" >
//<option value="">Select Application Number</option>';
//    }
//
//    echo $data;
//} else if ($strfilter == 'customerName') {
//    $result = mysqli_query($dbconn, "SELECT customerName FROM `application` where " . $whereEmp . "  order by customerName asc");
//    if (mysqli_num_rows($result) > 0) {
//        $data = '<select name="filterValue" id="filterValue" required="" class="form-control" >
//<option value="">Select Customer Name</option>';
//        while ($row = mysqli_fetch_array($result)) {
//            $data.='<option value=' . trim($row['customerName']) . '>' . trim($row['customerName']) . '</option>';
//        }
//    } else {
//        $data = '<select name="filterValue" id="filterValue" class="form-control" >
//<option value="">Select Customer Name</option>';
//    }
//
//    echo $data;
//} else 
if ($strfilter == 'state') {
    $result = mysqli_query($dbconn, "SELECT state FROM `application` where " . $whereEmp . " GROUP BY state  order by state asc");
    if (mysqli_num_rows($result) > 0) {
        $data = '<select name="filterValue" id="filterValue" required="" class="form-control" >
<option value="">Select State</option>';
    } else {
        $data = '<select name="filterValue" id="filterValue" class="form-control" >
<option value="">Select State</option>';
    }
    while ($row = mysqli_fetch_array($result)) {
        $data.='<option value=' . trim($row['state']) . '>' . trim($row['state']) . '</option>';
    }
    echo $data;
} else if ($strfilter == 'agencyName') {
    $result = mysqli_query($dbconn, "SELECT agencyName FROM `application` where " . $whereEmp . " GROUP BY agencyName order by agencyName asc");
    if (mysqli_num_rows($result) > 0) {
        $data = '<select name="filterValue" id="filterValue" required="" class="form-control" >
<option value="">Select Agency Name</option>';
    } else {
        $data = '<select name="filterValue" id="filterValue" class="form-control" >
<option value="">Select Agency Name</option>';
    }
    while ($row = mysqli_fetch_array($result)) {
        $data.='<option value=' . trim($row['agencyName']) . '>' . trim($row['agencyName']) . '</option>';
    }
    echo $data;
} else if ($strfilter == 'customerCity') {
    $result = mysqli_query($dbconn, "SELECT customerCity FROM `application` where " . $whereEmp . " GROUP BY customerCity order by customerCity asc");
    if (mysqli_num_rows($result) > 0) {
        $data = '<select name="filterValue" id="filterValue" required="" class="form-control" >
<option value="">Select City</option>';
    } else {
        $data = '<select name="filterValue" id="filterValue" class="form-control" >
<option value="">Select City</option>';
    }
    while ($row = mysqli_fetch_array($result)) {
        $data.='<option value=' . trim($row['customerCity']) . '>' . trim($row['customerCity']) . '</option>';
    }
    echo $data;
} else if ($strfilter == 'customerZipcode') {
    $result = mysqli_query($dbconn, "SELECT customerZipcode FROM `application` where " . $whereEmp . " GROUP BY customerZipcode order by customerZipcode asc");
    if (mysqli_num_rows($result) > 0) {
        $data = '<select name="filterValue" id="filterValue" required="" class="form-control" >
<option value="">Select Zip Code</option>';
    } else {
        $data = '<select name="filterValue" id="filterValue" class="form-control" >
<option value="">Select Zip Code</option>';
    }
    while ($row = mysqli_fetch_array($result)) {
        $data.='<option value=' . trim($row['customerZipcode']) . '>' . trim($row['customerZipcode']) . '</option>';
    }
    echo $data;
} else if ($strfilter == 'TotalAttempt') {
    $result = mysqli_query($dbconn, "SELECT DISTINCT  Count(*) as TotalAttempt FROM application inner join `applicationfollowup`  ON application.iAppId=applicationfollowup.iAppId where " . $whereEmp . " GROUP BY application.iAppId order by TotalAttempt asc");
    if (mysqli_num_rows($result) > 0) {
        $data = '<select name="filterValue" id="filterValue" required="" class="form-control" >
<option value="">Select Total Attempt</option><option value="0">0</option>';
    } else {
        $data = '<select name="filterValue" id="filterValue" class="form-control" >
<option value="">Select Total Attempt</option>';
    }
    while ($row = mysqli_fetch_array($result)) {
        $data.='<option value=' . trim($row['TotalAttempt']) . '>' . trim($row['TotalAttempt']) . '</option>';
    }
    echo $data;
} else if ($strfilter == 'TotalConnect') {
    $result = mysqli_query($dbconn, "SELECT DISTINCT  Count(*) as TotalConnect FROM application inner join `applicationfollowup`  ON application.iAppId=applicationfollowup.iAppId where " . $whereEmp . " and dispoType='1' GROUP BY application.iAppId order by TotalConnect asc");
    if (mysqli_num_rows($result) > 0) {
        $data = '<select name="filterValue" id="filterValue" required="" class="form-control" >
<option value="">Select Total Connect</option><option value="0">0</option>';
    } else {
        $data = '<select name="filterValue" id="filterValue" class="form-control" >
<option value="">Select Total Connect</option>';
    }
    while ($row = mysqli_fetch_array($result)) {
        $data.='<option value=' . trim($row['TotalConnect']) . '>' . trim($row['TotalConnect']) . '</option>';
    }
    echo $data;
} else if ($strfilter == 'Lastdisposition') {
    $result = mysqli_query($dbconn, "SELECT iDispoId,dispoDesc FROM dispositionmaster group by dispoDesc order by dispoDesc asc");

    if (mysqli_num_rows($result) > 0) {
        $data = '<select name="filterValue" id="filterValue" required="" class="form-control" >
<option value="">Select Dispostion</option>';
    } else {
        $data = '<select name="filterValue" id="filterValue" class="form-control" >
<option value="">Select Dispostion</option>';
    }
    while ($row = mysqli_fetch_array($result)) {
        $data.='<option value=' . trim($row['iDispoId']) . '>' . trim($row['dispoDesc']) . '</option>';
    }
    echo $data;
} else if ($strfilter == 'LastCallDate') {

    $result = mysqli_query($dbconn, "SELECT iDispoId,dispoDesc FROM dispositionmaster group by dispoDesc order by dispoDesc asc");

    if (mysqli_num_rows($result) > 0) {
        $data = '<select name="filterValue" id="filterValue" required="" class="form-control" >
<option value="">Select Dispostion</option>';
    } else {
        $data = '<select name="filterValue" id="filterValue" class="form-control" >
<option value="">Select Dispostion</option>';
    }
    while ($row = mysqli_fetch_array($result)) {
        $data.='<option value=' . trim($row['iDispoId']) . '>' . trim($row['dispoDesc']) . '</option>';
    }
    echo $data;
}
?>