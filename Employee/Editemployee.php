<?php
ob_start();
error_reporting(E_ALL);
include_once '../common.php';
$connect = new connect();
include('IsLogin.php');


$result = mysqli_query($dbconn, "SELECT * FROM `employee` WHERE `employeeid`='" . $_REQUEST['token'] . "'");
if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_array($result);
} else {
    echo 'somthig going worng! try again';
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title><?php echo $ProjectName; ?> | Edit Employee </title>
        <?php include_once './include.php'; ?>
        <link href="<?php echo $web_url; ?>Employee/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo $web_url; ?>Employee/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.css" rel="stylesheet" type="text/css" />
    </head>
    <!-- END HEAD -->
    <body class="page-header-fixed page-sidebar-closed-hide-logo page-content-white page-md">
        <div class="page-wrapper">
            <?php include_once './header.php'; ?>
            <div style="display: none; z-index: 10060;" id="loading">
                <img id="loading-image" src="<?php echo $web_url; ?>Employee/images/loader.gif">
            </div>
            <!-- END SIDEBAR -->
            <!-- BEGIN CONTENT -->
            <div class="page-content-wrapper">
                <!-- BEGIN CONTENT BODY -->
                <div class="page-content">

                    <div class="page-bar">
                        <ul class="page-breadcrumb">
                            <li>
                                <a href="index.php">Home</a>
                                <i class="fa fa-circle"></i>
                            </li>
                            <li>
                                <span>Edit Employee</span>
                            </li>
                        </ul>
                        <div class="page-toolbar">
                            <div id="dashboard-report-range" class="pull-right tooltips btn btn-sm" data-container="body" data-placement="bottom" data-original-title="Change dashboard date range">
                                <i class="icon-calendar"></i>&nbsp;
                                <span class="thin uppercase hidden-xs"></span>&nbsp;
                                <i class="fa fa-angle-down"></i>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="portlet light ">
                        <div class="portlet-title">
                            <div class="caption font-red-sunglo">
                                <span class="caption-subject bold uppercase">Edit Employee </span>
                            </div>
                        </div>
                        <div class="portlet-body form">
                            <form  role="form"  method="POST"  action="" name="frmparameter"  id="frmparameter" enctype="multipart/form-data">
                                <input type="hidden" value="Editemployee" name="action" id="action">
                                <input type="hidden" value="<?php echo $row['employeeid'] ?>" name="employeeid" id="employeeid">
                                <div class="form-body">
                                    <div class="row">
                                        <div class="form-group col-md-4">
                                            <label for="form_control_1">Employee  Name</label>
                                            <input name="employeename" id="employeename" value="<?php echo $row['empname']; ?>"  class="form-control" placeholder="Enter Your  Name" type="text" required="">
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="form_control_1">Date Of Joining</label>
                                            <input type="text" id="dojoin" name="dojoin" value="<?php echo $row['dojoin']; ?>" class="form-control date-picker" placeholder="Enter The From Date"/>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="form_control_1">Contact Number</label>
                                            <input name="contactnumber" id="contactnumber" value="<?php echo $row['contactnumber']; ?>" class="form-control" placeholder="Enter Your  Mobile" type="text" >
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-4">
                                            <label for="form_control_1">Astute Number</label>
                                            <input name="astutenumber" id="astutenumber" value="<?php echo $row['astutenumber']; ?>" class="form-control" placeholder="Enter Your  Astute Number" type="text" >
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="form_control_1">Process</label>
                                            <?php
                                            $queryCom = "SELECT * FROM `processmaster`  where isDelete='0'  and  istatus='1' order by  processmasterid asc";
                                            $resultCom = mysqli_query($dbconn, $queryCom);
                                            echo '<select class="form-control" name="process" id="proces" required="">';
                                            echo "<option value='' >Select Process Name</option>";
                                            while ($rowCom = mysqli_fetch_array($resultCom)) {
                                                if ($row['iProcessid'] == $rowCom ['processmasterid']) {
                                                    echo "<option value='" . $rowCom ['processmasterid'] . "' selected>" . $rowCom ['processname'] . "</option>";
                                                } else {
                                                    echo "<option value='" . $rowCom ['processmasterid'] . "'>" . $rowCom ['processname'] . "</option>";
                                                }
                                            }
                                            echo "</select>";
                                            ?>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="form_control_1">Elision Login ID</label><div id="errordiv"></div>
                                            <input name="elisionloginid" id="LoginID" value="<?php echo $row['elisionloginid']; ?>"  class="form-control" placeholder="Enter Your Login ID." type="text" required="" onblur="return chkLoginId();">
                                        </div> 
                                    </div>
                                    <div class="row">
                                        <!--<div class="form-group col-md-4">
                                            <label for="form_control_1">Designation</label>
                                            <?php
                                            /*$queryCom = "SELECT * FROM `designation`  where isDelete='0'  and  istatus='1' order by  designationid asc";
                                            $resultCom = mysqli_query($dbconn, $queryCom);
                                            echo '<select class="form-control" name="designation[]" id="designation" required="" multiple="multiple">';
                                            while ($rowCom = mysqli_fetch_array($resultCom)) {
                                                $designation = mysqli_fetch_array(mysqli_query($dbconn, "SELECT * FROM `employeedesignation`  where  iEmployeeId='" . $row['employeeid'] . "' and iDesignationId='" . $rowCom ['designationid'] . "'  "));
                                                if ($rowCom['designationid'] == $designation ['iDesignationId']) {
                                                    echo "<option value='" . $rowCom ['designationid'] . "' selected>" . $rowCom ['designation'] . "</option>";
                                                } else {
                                                    echo "<option value='" . $rowCom ['designationid'] . "'>" . $rowCom ['designation'] . "</option>";
                                                }
                                            }
                                            echo "</select>";*/
                                            ?>
                                        </div>-->
                                        <div class="form-group col-md-4">
                                            <label for="form_control_1">Designation</label>
                                            <?php
                                            $queryCom = "SELECT * FROM `designation`  where isDelete='0'  and  istatus='1' order by  designationid asc";
                                            $resultCom = mysqli_query($dbconn, $queryCom);
                                            echo '<select class="form-control" name="designation" id="designation" required="required" >';
                                            echo "<option value='' >Select Designation Name</option>";
                                            while ($rowCom = mysqli_fetch_array($resultCom)) {
                                                $designation = mysqli_fetch_array(mysqli_query($dbconn, "SELECT * FROM `employeedesignation`  where  iEmployeeId='" . $row['employeeid'] . "' and iDesignationId='" . $rowCom ['designationid'] . "'  "));
                                                if ($rowCom['designationid'] == $designation ['iDesignationId']) {
                                                    echo "<option value='" . $rowCom ['designationid'] . "' selected>" . $rowCom ['designation'] . "</option>";
                                                } else {
                                                    echo "<option value='" . $rowCom ['designationid'] . "'>" . $rowCom ['designation'] . "</option>";
                                                }
                                            }
                                            echo "</select>";
                                            ?>
                                        </div>
                                        <div id="DivTeamLeader">
                                        <div class="form-group col-md-4">
                                            <label for="form_control_1">Team leader</label>
                                            <?php
                                            $queryCom = "SELECT * FROM `employeedesignation`  where isDelete='0'  and  istatus='1' and iDesignationId='4' ";
                                            $resultCom = mysqli_query($dbconn, $queryCom);
                                            echo '<select class="form-control" name="iteamleadid" required="" id="iteamleadid" >';
                                            echo "<option value='0' >Select Team leader</option>";
                                            while ($rowCom = mysqli_fetch_array($resultCom)) {
                                                $empname = mysqli_fetch_array(mysqli_query($dbconn, "SELECT * FROM `employee`  where isDelete='0'  and  istatus='1' and employeeid='" . $rowCom['iEmployeeId'] . "' "));
                                                if ($row['iteamleadid'] == $rowCom ['iEmployeeId']) {
                                                    echo "<option value='" . $rowCom ['iEmployeeId'] . "' selected>" . $empname['empname'] . "</option>";
                                                } else {
                                                    echo "<option value='" . $rowCom ['iEmployeeId'] . "'>" . $empname ['empname'] . "</option>";
                                                }
                                            }
                                            echo "</select>";
                                            ?>
                                        </div>
                                        </div>
                                        <div id="DivQualityAnalist">
                                        <div class="form-group col-md-4">
                                            <label for="form_control_1">Quality Analist</label>
                                            <?php
                                            $queryCom = "SELECT * FROM `employeedesignation`  where isDelete='0'  and  istatus='1' and iDesignationId='1' ";
                                            $resultCom = mysqli_query($dbconn, $queryCom);
                                            echo '<select class="form-control" name="qualityanalistid" required="" id="qualityanalistid" >';
                                            echo "<option value='0' >Select Quality Analist</option>";
                                            while ($rowCom = mysqli_fetch_array($resultCom)) {
                                                $empname = mysqli_fetch_array(mysqli_query($dbconn, "SELECT * FROM `employee`  where isDelete='0'  and  istatus='1' and employeeid='" . $rowCom['iEmployeeId'] . "' "));
                                                if ($row['qualityanalistid'] == $rowCom ['iEmployeeId']) {
                                                    echo "<option value='" . $rowCom ['iEmployeeId'] . "' selected>" . $empname['empname'] . "</option>";
                                                } else {
                                                    echo "<option value='" . $rowCom ['iEmployeeId'] . "'>" . $empname ['empname'] . "</option>";
                                                }
                                            }
                                            echo "</select>";
                                            ?>
                                        </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-4" id="divAsstManager">
                                            <label for="form_control_1">AsstManager</label>
                                            <?php
                                            //$queryCom = "SELECT * FROM `employeedesignation`  where isDelete='0'  and  istatus='1' and iDesignationId='2' ";
                                            $queryCom = "SELECT * FROM `employee` INNER JOIN employeedesignation on employee.employeeid=employeedesignation.iEmployeeId WHERE employee.centralmanagerId=".$_SESSION['EmployeeId']." and employeedesignation.iDesignationId=2 and employee.isDelete=0 and employee.istatus=1";
                                            $resultCom = mysqli_query($dbconn, $queryCom);
                                            echo '<select class="form-control" name="asstmanagerid" id="asstmanagerid" >';
                                            echo "<option value='0' >Select AsstManager</option>";
                                            while ($rowCom = mysqli_fetch_array($resultCom)) {
                                                $empname = mysqli_fetch_array(mysqli_query($dbconn, "SELECT * FROM `employee`  where isDelete='0'  and  istatus='1' and employeeid='" . $rowCom['iEmployeeId'] . "' "));
                                                if ($row['asstmanagerid'] == $rowCom['iEmployeeId']) {
                                                    echo "<option value='" . $rowCom['iEmployeeId'] . "' selected>" . $rowCom['empname'] . "</option>";
                                                } else {
                                                    echo "<option value='" . $rowCom['iEmployeeId'] . "'>" . $rowCom['empname'] . "</option>";
                                                }
                                            }
                                            echo "</select>";
                                            ?>
                                        </div>
                                        <!--<div class="form-group col-md-4">
                                            <label for="form_control_1">Process Manager</label>
                                            <?php
                                            /*$queryCom = "SELECT * FROM `employeedesignation`  where isDelete='0'  and  istatus='1' and iDesignationId='3' ";
                                            $resultCom = mysqli_query($dbconn, $queryCom);
                                            echo '<select class="form-control" name="processmanager" id="processmanager" >';
                                            echo "<option value='0' >Select Process Manager</option>";
                                            while ($rowCom = mysqli_fetch_array($resultCom)) {
                                                $empname = mysqli_fetch_array(mysqli_query($dbconn, "SELECT * FROM `employee`  where isDelete='0'  and  istatus='1' and employeeid='" . $rowCom['iEmployeeId'] . "' "));
                                                if ($row['processmanager'] == $rowCom ['iEmployeeId']) {
                                                    echo "<option value='" . $rowCom ['iEmployeeId'] . "' selected>" . $empname['empname'] . "</option>";
                                                } else {
                                                    echo "<option value='" . $rowCom ['iEmployeeId'] . "'>" . $empname ['empname'] . "</option>";
                                                }
                                            }
                                            echo "</select>";*/
                                            ?>
                                        </div>-->
                                        
                                        <div id="DivTraining">
                                        <div class="form-group col-md-4">
                                            <label for="form_control_1">Trainee Incharge</label>
                                            <?php
                                            //$queryCM = "SELECT * FROM `employee` where employeeid IN (select employeedesignation.iEmployeeId from employeedesignation where employeedesignation.iDesignationId=9) and isDelete=0 and istatus='1'";
                                            $queryCM = "SELECT * FROM `employee` INNER JOIN employeedesignation on employee.employeeid=employeedesignation.iEmployeeId WHERE employee.centralmanagerId=".$_SESSION['EmployeeId']." and employeedesignation.iDesignationId=9 and employee.isDelete=0 and employee.istatus=1";
                                            $resultCM = mysqli_query($dbconn, $queryCM);
                                            ?>
                                            <select class="form-control" name="trainerId" id="trainerId">
                                                <option value='0'>Select Trainer</option>
                                                <?php
                                                while ($rowCM = mysqli_fetch_array($resultCM)) {
                                                    //   $empname = mysqli_fetch_array(mysqli_query($dbconn, "SELECT * FROM `employee`  where isDelete='0'  and  istatus='1' and employeeid='" . $rowCM['iEmployeeId'] . "' "));
                                                    //echo "<option value='" . $rowCM['employeeid'] . "'>" . $rowCM['empname'] . "</option>";
                                                    $empname = mysqli_fetch_array(mysqli_query($dbconn, "SELECT * FROM `employee`  where isDelete='0'  and  istatus='1' and employeeid='" . $rowCM['iEmployeeId'] . "' "));
                                                    if ($row['trainerId'] == $rowCM['iEmployeeId']) {
                                                        echo "<option value='" . $rowCM['iEmployeeId'] . "' selected>" . $rowCM['empname'] . "</option>";
                                                    } else {
                                                        echo "<option value='" . $rowCM['iEmployeeId'] . "'>" . $rowCM['empname'] . "</option>";
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div id="DivManagerTQ">
                                        <div class="form-group col-md-4">
                                            <?php 
                                            $resTQ = "SELECT * FROM `employee` INNER JOIN employeedesignation on employee.employeeid=employeedesignation.iEmployeeId WHERE employee.centralmanagerId=".$_SESSION['EmployeeId']." and employeedesignation.iDesignationId=13 and employee.isDelete=0 and employee.istatus=1";
                                            $resultCM = mysqli_query($dbconn, $resTQ);
                                            ?>
                                            <label for="form_control_1">Manager T&Q</label>
                                            <select class="form-control" name="managerTQid" id="managerTQid">
                                                <option value=''>Select Manager T&Q</option>
                                                <?php
                                                while ($rowCM = mysqli_fetch_array($resultCM)) {
                                                    //   $empname = mysqli_fetch_array(mysqli_query($dbconn, "SELECT * FROM `employee`  where isDelete='0'  and  istatus='1' and employeeid='" . $rowCM['iEmployeeId'] . "' "));
                                                    //echo "<option value='" . $rowCM['employeeid'] . "'>" . $rowCM['empname'] . "</option>";
                                                    $empname = mysqli_fetch_array(mysqli_query($dbconn, "SELECT * FROM `employee`  where isDelete='0'  and  istatus='1' and employeeid='" . $rowCM['iEmployeeId'] . "' "));
                                                    if ($row['managerTQid'] == $rowCM['iEmployeeId']) {
                                                        echo "<option value='" . $rowCM['iEmployeeId'] . "' selected>" . $rowCM['empname'] . "</option>";
                                                    } else {
                                                        echo "<option value='" . $rowCM['iEmployeeId'] . "'>" . $rowCM['empname'] . "</option>";
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                     <div id="DivManagerOps">
                                        <div class="form-group col-md-4">
                                            <label for="form_control_1">Manager Ops</label>
                                            <?php
                                            $resCM =  "SELECT * FROM `employee` INNER JOIN employeedesignation on employee.employeeid=employeedesignation.iEmployeeId WHERE employee.centralmanagerId=".$_SESSION['EmployeeId']." and employeedesignation.iDesignationId=14 and employee.isDelete=0 and employee.istatus=1";
                                            $resultCM = mysqli_query($dbconn, $resCM);
                                            ?>
                                            <select class="form-control" name="managerOpsid" id="managerOpsid">
                                                <option value=''>Select Manager Ops</option>
                                                <?php
                                                while ($rowCM = mysqli_fetch_array($resultCM)) {
                                                    //   $empname = mysqli_fetch_array(mysqli_query($dbconn, "SELECT * FROM `employee`  where isDelete='0'  and  istatus='1' and employeeid='" . $rowCM['iEmployeeId'] . "' "));
                                                    //echo "<option value='" . $rowCM['employeeid'] . "'>" . $rowCM['empname'] . "</option>";
                                                    $empname = mysqli_fetch_array(mysqli_query($dbconn, "SELECT * FROM `employee`  where isDelete='0'  and  istatus='1' and employeeid='" . $rowCM['iEmployeeId'] . "' "));
                                                    if ($row['managerOpsid'] == $rowCM['iEmployeeId']) {
                                                        echo "<option value='" . $rowCM['iEmployeeId'] . "' selected>" . $rowCM['empname'] . "</option>";
                                                    } else {
                                                        echo "<option value='" . $rowCM['iEmployeeId'] . "'>" . $rowCM['empname'] . "</option>";
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                     <div id="DivManagerHR">
                                        <div class="form-group col-md-4">
                                            <label for="form_control_1">Manager HR</label>
                                            <?php 
                                            $resCM = "SELECT * FROM `employee` INNER JOIN employeedesignation on employee.employeeid=employeedesignation.iEmployeeId WHERE employee.centralmanagerId=".$_SESSION['EmployeeId']." and employeedesignation.iDesignationId=15 and employee.isDelete=0 and employee.istatus=1";
                                            $resultCM = mysqli_query($dbconn, $resCM);
                                            ?>
                                            <select class="form-control" name="managerHRid" id="managerHRid">
                                                <option value=''>Select Manager HR</option>
                                                <?php
                                                while ($rowCM = mysqli_fetch_array($resultCM)) {
                                                    //   $empname = mysqli_fetch_array(mysqli_query($dbconn, "SELECT * FROM `employee`  where isDelete='0'  and  istatus='1' and employeeid='" . $rowCM['iEmployeeId'] . "' "));
                                                    //echo "<option value='" . $rowCM['employeeid'] . "'>" . $rowCM['empname'] . "</option>";
                                                    $empname = mysqli_fetch_array(mysqli_query($dbconn, "SELECT * FROM `employee`  where isDelete='0'  and  istatus='1' and employeeid='" . $rowCM['iEmployeeId'] . "' "));
                                                    if ($row['managerHRid'] == $rowCM['iEmployeeId']) {
                                                        echo "<option value='" . $rowCM['iEmployeeId'] . "' selected>" . $rowCM['empname'] . "</option>";
                                                    } else {
                                                        echo "<option value='" . $rowCM['iEmployeeId'] . "'>" . $rowCM['empname'] . "</option>";
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div id="DivManagerIT">
                                        <div class="form-group col-md-4">
                                            <label for="form_control_1">Manager IT</label>
                                            <?php 
                                            $resCM = "SELECT * FROM `employee` INNER JOIN employeedesignation on employee.employeeid=employeedesignation.iEmployeeId WHERE employee.centralmanagerId=".$_SESSION['EmployeeId']." and employeedesignation.iDesignationId=16 and employee.isDelete=0 and employee.istatus=1";
                                            $resultCM = mysqli_query($dbconn, $resCM);
                                            ?>
                                            <select class="form-control" name="managerITid" id="managerITid">
                                                <option value=''>Select Manager IT</option>
                                                <?php
                                                while ($rowCM = mysqli_fetch_array($resultCM)) {
                                                    //   $empname = mysqli_fetch_array(mysqli_query($dbconn, "SELECT * FROM `employee`  where isDelete='0'  and  istatus='1' and employeeid='" . $rowCM['iEmployeeId'] . "' "));
                                                    //echo "<option value='" . $rowCM['employeeid'] . "'>" . $rowCM['empname'] . "</option>";
                                                    $empname = mysqli_fetch_array(mysqli_query($dbconn, "SELECT * FROM `employee`  where isDelete='0'  and  istatus='1' and employeeid='" . $rowCM['iEmployeeId'] . "' "));
                                                    if ($row['managerITid'] == $rowCM['iEmployeeId']) {
                                                        echo "<option value='" . $rowCM['iEmployeeId'] . "' selected>" . $rowCM['empname'] . "</option>";
                                                    } else {
                                                        echo "<option value='" . $rowCM['iEmployeeId'] . "'>" . $rowCM['empname'] . "</option>";
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div id="DivManagerMIS">
                                        <div class="form-group col-md-4">
                                            <label for="form_control_1">Manager WFM/MIS</label>
                                            <?php
                                                $resCM = "SELECT * FROM `employee` INNER JOIN employeedesignation on employee.employeeid=employeedesignation.iEmployeeId WHERE employee.centralmanagerId=".$_SESSION['EmployeeId']." and employeedesignation.iDesignationId=17 and employee.isDelete=0 and employee.istatus=1";
                                                $resultCM = mysqli_query($dbconn, $resCM);
                                            ?>
                                            <select class="form-control" name="managerMISid" id="managerMISid">
                                                <option value=''>Select Manager WFM/MIS</option>
                                                <?php
                                                while ($rowCM = mysqli_fetch_array($resultCM)) {
                                                    //   $empname = mysqli_fetch_array(mysqli_query($dbconn, "SELECT * FROM `employee`  where isDelete='0'  and  istatus='1' and employeeid='" . $rowCM['iEmployeeId'] . "' "));
                                                    // echo "<option value='" . $rowCM['employeeid'] . "'>" . $rowCM['empname'] . "</option>";
                                                    $empname = mysqli_fetch_array(mysqli_query($dbconn, "SELECT * FROM `employee`  where isDelete='0'  and  istatus='1' and employeeid='" . $rowCM['iEmployeeId'] . "' "));
                                                    if ($row['managerMISid'] == $rowCM['iEmployeeId']) {
                                                        echo "<option value='" . $rowCM['iEmployeeId'] . "' selected>" . $rowCM['empname'] . "</option>";
                                                    } else {
                                                        echo "<option value='" . $rowCM['iEmployeeId'] . "'>" . $rowCM['empname'] . "</option>";
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                                <div class="form-actions noborder">
                                    <input class="btn blue margin-top-20" type="submit" id="Btnmybtn"  value="Submit" name="submit">      
                                    <button type="button" class="btn blue margin-top-20" onClick="checkclose();">Cancel</button>
                                </div>
                            </form>
                        </div>
                        <!-- END DASHBOARD STATS 1-->
                    </div>
                    <!-- END CONTENT BODY -->
                </div>
                <!-- END CONTENT -->
                <!-- BEGIN QUICK SIDEBAR -->
                <a href="javascript:;" class="page-quick-sidebar-toggler">
                    <i class="icon-login"></i>
                </a>
                <!-- END QUICK SIDEBAR -->
            </div>
            <!-- END CONTAINER -->
            <!-- BEGIN FOOTER -->
            <?php include_once './footer.php'; ?>
            <!-- END FOOTER -->
        </div>
        <!-- BEGIN CORE PLUGINS -->
        <?php include_once './footerjs.php'; ?>
        <style>
            .multiselect
            {
                display: block;
                height: 35px;
                padding: 6px;
                text-align: left !important;
                line-height: 1.42857;
                /* color: #DFDFDF; */
                background-color: #fff;
                background-image: none;
                border: 1px solid #2E7FC1 !important;
                border-radius: 4px;
                color: #555555;
                font-size: 15px;
                font-weight: normal !important;
                text-transform: lowercase;
            }
        </style>
        <link href="<?php echo $web_url; ?>admin/assets/bootstrap-multiselect.css" rel="stylesheet" type="text/css"/>
        <script src="<?php echo $web_url; ?>admin/assets/bootstrap-multiselect.js" type="text/javascript"></script>
        <script type="text/javascript">
                                        $('#designation').multiselect({
                                            nonSelectedText: 'Select designation',
                                            includeSelectAllOption: true,
                                            buttonWidth: '100%',
                                            maxHeight: 250,
                                            enableFiltering: true
                                        });
        </script>

        <script src="<?php echo $web_url; ?>Employee/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js" type="text/javascript"></script>
        <script type="text/javascript">

        $('#designation').change(function () {
            // var designation = $(this).val();
            // if (designation == 5) {
            //     $('#divAsstManager').hide();
            // } else {
            //     $('#divAsstManager').show();
            //     $('#qualityanalistid').attr('required', false);
            //     $('#asstmanagerid').attr('required', false);
            // }
            designation();
        });
        
        $(document).ready(function() {
            designation();
        });
        function designation(){
            var designation = $('#designation').val();
            
            if(designation == 12){
                
                $("#DivTraining").show();
                $("#DivCentralManager").hide();
                $("#divAsstManager").hide();
                $("#DivTeamLeader").hide();
                $("#DivQualityAnalist").hide();
                $("#DivManagerTQ").hide();
                $("#DivManagerOps").hide();
                $("#DivManagerHR").hide();
                $("#DivManagerIT").hide();
                $("#DivManagerMIS").hide();
                $('#trainerId').attr('required', true);
                $('#centralmanager').attr('required', false);
                $('#asstmanagerid').attr('required', false);
                $('#iteamleadid').attr('required', false);
                $('#qualityanalistid').attr('required', false);
                $('#managerTQid').attr('required', false);
                $('#managerOpsid').attr('required', false);
                $('#managerHRid').attr('required', false);
                $('#managerITid').attr('required', false);
                $('#managerHRid').attr('required', false);
            } else if(designation == 5){
                $("#DivTraining").hide();
                $("#DivCentralManager").show();
                $("#divAsstManager").hide();
                $("#DivTeamLeader").show();
                $("#DivQualityAnalist").show();
                $("#DivManagerTQ").hide();
                $("#DivManagerOps").hide();
                $("#DivManagerHR").hide();
                $("#DivManagerIT").hide();
                $("#DivManagerMIS").hide();
                $('#trainerId').attr('required', false);
                $('#centralmanager').attr('required', true);
                $('#asstmanagerid').attr('required', false);
                $('#iteamleadid').attr('required', false);
                $('#qualityanalistid').attr('required', false);
                $('#managerTQid').attr('required', false);
                $('#managerOpsid').attr('required', false);
                $('#managerHRid').attr('required', false);
                $('#managerITid').attr('required', false);
                $('#managerHRid').attr('required', false);
            } else if(designation == 9){
                
                $("#DivTraining").hide();
                $("#DivCentralManager").show();
                $("#divAsstManager").show();
                $("#DivTeamLeader").hide();
                $("#DivQualityAnalist").hide();
                $("#DivManagerTQ").show();
                $("#DivManagerOps").hide();
                $("#DivManagerHR").hide();
                $("#DivManagerIT").hide();
                $("#DivManagerMIS").hide();
                $('#trainerId').attr('required', false);
                $('#centralmanager').attr('required', true);
                $('#asstmanagerid').attr('required', false);
                $('#iteamleadid').attr('required', false);
                $('#qualityanalistid').attr('required', false);
                $('#managerTQid').attr('required', false);
                $('#managerOpsid').attr('required', false);
                $('#managerHRid').attr('required', false);
                $('#managerITid').attr('required', false);
                $('#managerHRid').attr('required', false);
            } else if(designation == 1){
                $("#DivTraining").hide();
                $("#DivCentralManager").show();
                $("#divAsstManager").show();
                $("#DivTeamLeader").hide();
                $("#DivQualityAnalist").hide();
                $("#DivManagerTQ").show();
                $("#DivManagerOps").hide();
                $("#DivManagerHR").hide();
                $("#DivManagerIT").hide();
                $("#DivManagerMIS").hide();
                $('#trainerId').attr('required', false);
                $('#centralmanager').attr('required', true);
                $('#asstmanagerid').attr('required', false);
                $('#iteamleadid').attr('required', false);
                $('#qualityanalistid').attr('required', false);
                $('#managerTQid').attr('required', false);
                $('#managerOpsid').attr('required', false);
                $('#managerHRid').attr('required', false);
                $('#managerITid').attr('required', false);
                $('#managerHRid').attr('required', false);
            } else if(designation == 4){
                $("#DivTraining").hide();
                $("#DivCentralManager").show();
                $("#divAsstManager").show();
                $("#DivTeamLeader").hide();
                $("#DivQualityAnalist").hide();
                $("#DivManagerTQ").hide();
                $("#DivManagerOps").show();
                $("#DivManagerHR").hide();
                $("#DivManagerIT").hide();
                $("#DivManagerMIS").hide();
                $('#trainerId').attr('required', false);
                $('#centralmanager').attr('required', true);
                $('#asstmanagerid').attr('required', false);
                $('#iteamleadid').attr('required', false);
                $('#qualityanalistid').attr('required', false);
                $('#managerTQid').attr('required', false);
                $('#managerOpsid').attr('required', false);
                $('#managerHRid').attr('required', false);
                $('#managerITid').attr('required', false);
                $('#managerHRid').attr('required', false);
            } else if(designation == 18){
                $("#DivTraining").hide();
                $("#DivCentralManager").show();
                $("#divAsstManager").show();
                $("#DivTeamLeader").hide();
                $("#DivQualityAnalist").hide();
                $("#DivManagerTQ").hide();
                $("#DivManagerOps").show();
                $("#DivManagerHR").hide();
                $("#DivManagerIT").hide();
                $("#DivManagerMIS").hide();
                $('#trainerId').attr('required', false);
                $('#centralmanager').attr('required', true);
                $('#asstmanagerid').attr('required', false);
                $('#iteamleadid').attr('required', false);
                $('#qualityanalistid').attr('required', false);
                $('#managerTQid').attr('required', false);
                $('#managerOpsid').attr('required', false);
                $('#managerHRid').attr('required', false);
                $('#managerITid').attr('required', false);
                $('#managerHRid').attr('required', false);
            } else if(designation == 7){
                $("#DivTraining").hide();
                $("#DivCentralManager").show();
                $("#divAsstManager").show();
                $("#DivTeamLeader").hide();
                $("#DivQualityAnalist").hide();
                $("#DivManagerTQ").hide();
                $("#DivManagerOps").hide();
                $("#DivManagerHR").show();
                $("#DivManagerIT").hide();
                $("#DivManagerMIS").hide();
                $('#trainerId').attr('required', false);
                $('#centralmanager').attr('required', true);
                $('#asstmanagerid').attr('required', false);
                $('#iteamleadid').attr('required', false);
                $('#qualityanalistid').attr('required', false);
                $('#managerTQid').attr('required', false);
                $('#managerOpsid').attr('required', false);
                $('#managerHRid').attr('required', false);
                $('#managerITid').attr('required', false);
                $('#managerHRid').attr('required', false);
            } else if(designation == 8){
                $("#DivTraining").hide();
                $("#DivCentralManager").show();
                $("#divAsstManager").show();
                $("#DivTeamLeader").hide();
                $("#DivQualityAnalist").hide();
                $("#DivManagerTQ").hide();
                $("#DivManagerOps").hide();
                $("#DivManagerHR").hide();
                $("#DivManagerIT").show();
                $("#DivManagerMIS").hide();
                $('#trainerId').attr('required', false);
                $('#centralmanager').attr('required', true);
                $('#asstmanagerid').attr('required', false);
                $('#iteamleadid').attr('required', false);
                $('#qualityanalistid').attr('required', false);
                $('#managerTQid').attr('required', false);
                $('#managerOpsid').attr('required', false);
                $('#managerHRid').attr('required', false);
                $('#managerITid').attr('required', false);
                $('#managerHRid').attr('required', false);
            } else if(designation == 10){
                $("#DivTraining").hide();
                $("#DivCentralManager").show();
                $("#divAsstManager").show();
                $("#DivTeamLeader").hide();
                $("#DivQualityAnalist").hide();
                $("#DivManagerTQ").hide();
                $("#DivManagerOps").hide();
                $("#DivManagerHR").hide();
                $("#DivManagerIT").hide();
                $("#DivManagerMIS").show();
                $('#trainerId').attr('required', false);
                $('#centralmanager').attr('required', true);
                $('#asstmanagerid').attr('required', false);
                $('#iteamleadid').attr('required', false);
                $('#qualityanalistid').attr('required', false);
                $('#managerTQid').attr('required', false);
                $('#managerOpsid').attr('required', false);
                $('#managerHRid').attr('required', false);
                $('#managerITid').attr('required', false);
                $('#managerHRid').attr('required', false);
            } else if(designation == 11){
                $("#DivTraining").hide();
                $("#DivCentralManager").show();
                $("#divAsstManager").show();
                $("#DivTeamLeader").hide();
                $("#DivQualityAnalist").hide();
                $("#DivManagerTQ").hide();
                $("#DivManagerOps").hide();
                $("#DivManagerHR").hide();
                $("#DivManagerIT").hide();
                $("#DivManagerMIS").show();
                $('#trainerId').attr('required', false);
                $('#centralmanager').attr('required', true);
                $('#asstmanagerid').attr('required', false);
                $('#iteamleadid').attr('required', false);
                $('#qualityanalistid').attr('required', false);
                $('#managerTQid').attr('required', false);
                $('#managerOpsid').attr('required', false);
                $('#managerHRid').attr('required', false);
                $('#managerITid').attr('required', false);
                $('#managerHRid').attr('required', false);
            } else if(designation == 2){
                $("#DivTraining").hide();
                $("#DivCentralManager").show();
                $("#divAsstManager").hide();
                $("#DivTeamLeader").hide();
                $("#DivQualityAnalist").hide();
                $("#DivManagerTQ").show();
                $("#DivManagerOps").show();
                $("#DivManagerHR").show();
                $("#DivManagerIT").show();
                $("#DivManagerMIS").show();
                $('#trainerId').attr('required', false);
                $('#centralmanager').attr('required', true);
                $('#asstmanagerid').attr('required', false);
                $('#iteamleadid').attr('required', false);
                $('#qualityanalistid').attr('required', false);
                $('#managerTQid').attr('required', false);
                $('#managerOpsid').attr('required', false);
                $('#managerHRid').attr('required', false);
                $('#managerITid').attr('required', false);
                $('#managerHRid').attr('required', false);
            } else if(designation == 13){
                $("#DivTraining").hide();
                $("#DivCentralManager").show();
                $("#divAsstManager").hide();
                $("#DivTeamLeader").hide();
                $("#DivQualityAnalist").hide();
                $("#DivManagerTQ").hide();
                $("#DivManagerOps").hide();
                $("#DivManagerHR").hide();
                $("#DivManagerIT").hide();
                $("#DivManagerMIS").hide();
                $('#trainerId').attr('required', false);
                $('#centralmanager').attr('required', true);
                $('#asstmanagerid').attr('required', false);
                $('#iteamleadid').attr('required', false);
                $('#qualityanalistid').attr('required', false);
                $('#managerTQid').attr('required', false);
                $('#managerOpsid').attr('required', false);
                $('#managerHRid').attr('required', false);
                $('#managerITid').attr('required', false);
                $('#managerHRid').attr('required', false);
            } else if(designation == 14){
                $("#DivTraining").hide();
                $("#DivCentralManager").show();
                $("#divAsstManager").hide();
                $("#DivTeamLeader").hide();
                $("#DivQualityAnalist").hide();
                $("#DivManagerTQ").hide();
                $("#DivManagerOps").hide();
                $("#DivManagerHR").hide();
                $("#DivManagerIT").hide();
                $("#DivManagerMIS").hide();
                $('#trainerId').attr('required', false);
                $('#centralmanager').attr('required', true);
                $('#asstmanagerid').attr('required', false);
                $('#iteamleadid').attr('required', false);
                $('#qualityanalistid').attr('required', false);
                $('#managerTQid').attr('required', false);
                $('#managerOpsid').attr('required', false);
                $('#managerHRid').attr('required', false);
                $('#managerITid').attr('required', false);
                $('#managerHRid').attr('required', false);
            } else if(designation == 15){
                $("#DivTraining").hide();
                $("#DivCentralManager").show();
                $("#divAsstManager").hide();
                $("#DivTeamLeader").hide();
                $("#DivQualityAnalist").hide();
                $("#DivManagerTQ").hide();
                $("#DivManagerOps").hide();
                $("#DivManagerHR").hide();
                $("#DivManagerIT").hide();
                $("#DivManagerMIS").hide();
                $('#trainerId').attr('required', false);
                $('#centralmanager').attr('required', true);
                $('#asstmanagerid').attr('required', false);
                $('#iteamleadid').attr('required', false);
                $('#qualityanalistid').attr('required', false);
                $('#managerTQid').attr('required', false);
                $('#managerOpsid').attr('required', false);
                $('#managerHRid').attr('required', false);
                $('#managerITid').attr('required', false);
                $('#managerHRid').attr('required', false);
            } else if(designation == 16){
                $("#DivTraining").hide();
                $("#DivCentralManager").show();
                $("#divAsstManager").hide();
                $("#DivTeamLeader").hide();
                $("#DivQualityAnalist").hide();
                $("#DivManagerTQ").hide();
                $("#DivManagerOps").hide();
                $("#DivManagerHR").hide();
                $("#DivManagerIT").hide();
                $("#DivManagerMIS").hide();
                $('#trainerId').attr('required', false);
                $('#centralmanager').attr('required', true);
                $('#asstmanagerid').attr('required', false);
                $('#iteamleadid').attr('required', false);
                $('#qualityanalistid').attr('required', false);
                $('#managerTQid').attr('required', false);
                $('#managerOpsid').attr('required', false);
                $('#managerHRid').attr('required', false);
                $('#managerITid').attr('required', false);
                $('#managerHRid').attr('required', false);
            } else if(designation == 17){
                $("#DivTraining").hide();
                $("#DivCentralManager").show();
                $("#divAsstManager").hide();
                $("#DivTeamLeader").hide();
                $("#DivQualityAnalist").hide();
                $("#DivManagerTQ").hide();
                $("#DivManagerOps").hide();
                $("#DivManagerHR").hide();
                $("#DivManagerIT").hide();
                $("#DivManagerMIS").hide();
                $('#trainerId').attr('required', false);
                $('#centralmanager').attr('required', true);
                $('#asstmanagerid').attr('required', false);
                $('#iteamleadid').attr('required', false);
                $('#qualityanalistid').attr('required', false);
                $('#managerTQid').attr('required', false);
                $('#managerOpsid').attr('required', false);
                $('#managerHRid').attr('required', false);
                $('#managerITid').attr('required', false);
                $('#managerHRid').attr('required', false);
            }else {
                $("#DivTraining").hide();
                $("#DivCentralManager").hide();
                $("#divAsstManager").hide();
                $("#DivTeamLeader").hide();
                $("#DivQualityAnalist").hide();
                $("#DivManagerTQ").hide();
                $("#DivManagerOps").hide();
                $("#DivManagerHR").hide();
                $("#DivManagerIT").hide();
                $("#DivManagerMIS").hide();
                
                $('#trainerId').attr('required', false);
                $('#centralmanager').attr('required', false);
                $('#asstmanagerid').attr('required', false);
                $('#iteamleadid').attr('required', false);
                $('#qualityanalistid').attr('required', false);
                $('#managerTQid').attr('required', false);
                $('#managerOpsid').attr('required', false);
                $('#managerHRid').attr('required', false);
                $('#managerITid').attr('required', false);
                $('#managerHRid').attr('required', false);
            }
        }


        function checkclose() {
            window.location.href = '<?php echo $web_url; ?>Employee/employee.php';
        }

        function chkLoginId(ID)
        {

            var q = $('#LoginID').val();
            var companyemployeeid = $('#companyemployeeid').val();

            var urlp = '<?php echo $web_url; ?>admin/findeditemployeeLoginID.php?ID=' + q;
            $.ajax({
                type: 'POST',
                url: urlp,
                success: function (data) {
                    if (data == 0)
                    {
                        $('#errordiv').html('');
                    } else
                    {
                        $('#errordiv').html(data);
                        $('#LoginID').val('');
                    }
                }
            }).error(function () {
                alert('An error occured');
            });

        }


        $('#frmparameter').submit(function (e) {

            e.preventDefault();
            var $form = $(this);
            $('#loading').css("display", "block");
            $.ajax({
                type: 'POST',
                url: '<?php echo $web_url; ?>Employee/CentralManagerQuerydata.php',
                data: $('#frmparameter').serialize(),
                success: function (response) {
                    // alert(response);
                    console.log(response);
                    //$("#Btnmybtn").attr('disabled', 'disabled');
                    if (response == 2)
                    {
                        $('#loading').css("display", "none");
                        $("#Btnmybtn").attr('disabled', 'disabled');
                        alert(' Employee Edited Sucessfully.');
                        window.location.href = '<?php echo $web_url; ?>Employee/employee.php';
                    }
                }

            });
        });

    </script>
    </script>
</body>
</html>