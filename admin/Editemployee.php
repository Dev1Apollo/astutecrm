<?php
ob_start();
include_once '../common.php';
$connect = new connect();
include('IsLogin.php');
$result = mysqli_query($dbconn, "SELECT * FROM `employee` as e,employeedesignation as ed where e.employeeid=ed.iEmployeeId and  `employeeid`='" . $_REQUEST['token'] . "'");
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
    <meta charset="utf-8">
    <link rel="shortcut icon" href="images/favicon.png">
    <title> <?php echo $ProjectName ?> |Edit Employee</title>
    <?php include_once './include.php'; ?>
</head>

<body class="page-container-bg-solid page-boxed">
    <?php
    include('header.php');
    ?>
    <div style="display: none; z-index: 10060;" id="loading">
        <img id="loading-image" src="<?php echo $web_url; ?>admin/images/loader1.gif">
    </div>
    <div class="page-container">
        <div class="page-content">
            <div class="container">
                <ul class="page-breadcrumb breadcrumb">
                    <li>
                        <a href="<?php echo $web_url; ?>admin/index.php">Home</a>
                        <i class="fa fa-circle"></i>
                    </li>
                    <li>
                        <a href="<?php echo $web_url; ?>admin/employee.php">List Of Employee</a>
                        <i class="fa fa-circle"></i>
                    </li>
                    <li>
                        <span> Edit Employee</span>
                    </li>
                </ul>
                <div class="page-content-inner">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="portlet light ">
                                <div class="portlet-title">
                                    <div class="caption font-red-sunglo">
                                        <i class="icon-settings font-red-sunglo"></i>
                                        <span class="caption-subject bold uppercase"> Edit Employee</span>
                                    </div>
                                </div>
                                <div class="portlet-body form">
                                   
                                    <form role="form" method="POST" action="" name="frmparameter" id="frmparameter" enctype="multipart/form-data">
                                        <input type="hidden" value="Editemployee" name="action" id="action">
                                        <input type="hidden" value="<?php echo $row['iDesignationId']; ?>" name="DesignationId" id="DesignationId">
                                        <input type="hidden" value="<?php echo $row['iteamleadid']; ?>" name="TLID" id="TLID">
                                        <input type="hidden" value="<?php echo $row['processmanager']; ?>" name="PMID" id="PMID">
                                        <input type="hidden" value="<?php echo $row['qualityanalistid']; ?>" name="QAID" id="QAID">
                                        <input type="hidden" value="<?php echo $row['asstmanagerid']; ?>" name="AMID" id="AMID">
                                        <input type="hidden" value="<?php echo $row['trainerId']; ?>" name="TRId" id="TRId">
                                        <input type="hidden" value="<?php echo $row['employeeid'] ?>" name="employeeid" id="employeeid">
                                        
                                        <input type="hidden" value="<?php echo $row['managerTQid']; ?>" name="TQId" id="TQId">
                                        <input type="hidden" value="<?php echo $row['managerOpsid']; ?>" name="Opsid" id="Opsid">
                                        <input type="hidden" value="<?php echo $row['managerHRid']; ?>" name="HRid" id="HRid">
                                        <input type="hidden" value="<?php echo $row['managerITid']; ?>" name="ITId" id="ITId">
                                        <input type="hidden" value="<?php echo $row['managerMISid']; ?>" name="MISId" id="MISId">
                                        <div class="form-body">

                                            <div class="form-group col-md-4">

                                                <label for="form_control_1">Employee Name</label>

                                                <input name="employeename" id="employeename" value="<?php echo $row['empname']; ?>" class="form-control" placeholder="Enter Your  Name" type="text" required="">

                                            </div>

                                            <div class="form-group col-md-4">

                                                <label for="form_control_1">Date Of Joining</label>

                                                <input type="text" id="dojoin" name="dojoin" value="<?php echo $row['dojoin']; ?>" class="form-control date-picker" placeholder="Enter The From Date" />

                                            </div>

                                            <div class="form-group col-md-4">

                                                <label for="form_control_1">Contact Number</label>

                                                <input name="contactnumber" id="contactnumber" value="<?php echo $row['contactnumber']; ?>" class="form-control" placeholder="Enter Your  Mobile" type="text">

                                            </div>

                                            <div class="form-group col-md-4">

                                                <label for="form_control_1">Employee Number</label>

                                                <input name="astutenumber" id="astutenumber" value="<?php echo $row['astutenumber']; ?>" class="form-control" placeholder="Enter Your  Astute Number" type="text">

                                            </div>

                                            <div class="form-group col-md-4">
                                                <label for="form_control_1">Process</label>
                                                <?php
                                                $queryCom = "SELECT * FROM `processmaster`  where isDelete='0'  and  istatus='1' order by  processmasterid asc";
                                                $resultCom = mysqli_query($dbconn, $queryCom);
                                                echo '<select class="form-control" name="process[]" id="process" required="" multiple="multiple">';
                                                while ($rowCom = mysqli_fetch_array($resultCom)) {
                                                    $rowProcess = mysqli_fetch_array(mysqli_query($dbconn, "SELECT * FROM `employeeprocess`  where  iEmployeeId='" . $row['employeeid'] . "' and iProcessId='" . $rowCom['processmasterid'] . "'  "));
                                                    if ($rowCom['processmasterid'] == $rowProcess['iProcessId']) {
                                                        echo "<option value='" . $rowCom['processmasterid'] . "' selected>" . $rowCom['processname'] . "</option>";
                                                    } else {
                                                        echo "<option value='" . $rowCom['processmasterid'] . "'>" . $rowCom['processname'] . "</option>";
                                                    }
                                                }
                                                echo "</select>";
                                                ?>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="form_control_1">Login ID</label>
                                                <div id="errordiv"></div>
                                                <input name="elisionloginid" id="LoginID" value="<?php echo $row['elisionloginid']; ?>" class="form-control" placeholder="Enter Your Login ID." type="text" required="" onblur="return chkLoginId();">
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="form_control_1">Designation</label>
                                                <?php
                                                $queryCom = "SELECT * FROM `designation`  where isDelete='0'  and  istatus='1' order by  designationid asc";
                                                $resultCom = mysqli_query($dbconn, $queryCom);
                                                echo '<select class="form-control" name="designation" id="designation" required="">';
                                                while ($rowCom = mysqli_fetch_array($resultCom)) {
                                                    $designation = mysqli_fetch_array(mysqli_query($dbconn, "SELECT * FROM `employeedesignation`  where  iEmployeeId='" . $row['employeeid'] . "' and iDesignationId='" . $rowCom['designationid'] . "'  "));
                                                    if ($rowCom['designationid'] == $designation['iDesignationId']) {
                                                        echo "<option value='" . $rowCom['designationid'] . "' selected>" . $rowCom['designation'] . "</option>";
                                                    } else {
                                                        echo "<option value='" . $rowCom['designationid'] . "'>" . $rowCom['designation'] . "</option>";
                                                    }
                                                }
                                                echo "</select>";
                                                ?>
                                            </div>
                                            <!--<div id="DivTraining">
                                                <div class="form-group col-md-4">
                                                   <label for="form_control_1">Trainee Incharge</label>
                                                    <?php
                                                    $queryCM = "SELECT * FROM `employee` where employeeid IN (select employeedesignation.iEmployeeId from employeedesignation where employeedesignation.iDesignationId=9) and isDelete=0 and istatus='1'";
                                                    $resultCM = mysqli_query($dbconn, $queryCM);
                                                    ?>
                                                    <select class="form-control" name="trainerId" id="trainerId">
                                                        <option value='0'>Select Trainer</option>
                                                        <?php
                                                        while ($rowCM = mysqli_fetch_array($resultCM)) {
                                                         //   $empname = mysqli_fetch_array(mysqli_query($dbconn, "SELECT * FROM `employee`  where isDelete='0'  and  istatus='1' and employeeid='" . $rowCM['iEmployeeId'] . "' "));
                                                            echo "<option value='" . $rowCM['employeeid'] . "'>" . $rowCM['empname'] . "</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>-->
                                            <div id="DivCentralManager">
                                                <div class="form-group col-md-4">
                                                    <label for="form_control_1">Central Manager</label>
                                                    <?php
                                                    $queryCM = "SELECT * FROM `employeedesignation`  where isDelete='0'  and  istatus='1' and iDesignationId='6' ";
                                                    $resultCM = mysqli_query($dbconn, $queryCM);
                                                    ?>
                                                    <select class="form-control" name="centralmanager" id="centralmanager" onchange="geteditcentralmanager();">
                                                        <option value='0'>Select Central Manager</option>
                                                        <?php
                                                        while ($rowCM = mysqli_fetch_array($resultCM)) {
                                                            $empname = mysqli_fetch_array(mysqli_query($dbconn, "SELECT * FROM `employee`  where isDelete='0'  and  istatus='1' and employeeid='" . $rowCM['iEmployeeId'] . "' "));
                                                            if ($rowCM['iEmployeeId'] == $row['centralmanagerId']) {
                                                                echo "<option value='" . $rowCM['iEmployeeId'] . "' selected>" . $empname['empname'] . "</option>";
                                                            } else {
                                                                echo "<option value='" . $rowCM['iEmployeeId'] . "'>" . $empname['empname'] . "</option>";
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                           <!-- <div id="DivProcessManager">
                                                <div class="form-group col-md-4">
                                                    <label for="form_control_1">Process Manager</label>                                                   
                                                    <select class="form-control" name="processmanager" id="processmanager">
                                                        <option value=''>Select Process Manager</option>
                                                    </select>
                                                </div>
                                            </div>-->
                                            <div id="divAsstManager">
                                                <div class="form-group col-md-4">
                                                    <label for="form_control_1">AsstManager</label>                                                  
                                                    <select class="form-control" name="asstmanagerid" id="asstmanagerid">
                                                        <option value=''>Select AsstManager</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div id="DivTeamLeader">
                                                <div class="form-group col-md-4">
                                                    <label for="form_control_1">Team leader</label>
                                                    <select class="form-control" name="iteamleadid" id="iteamleadid">
                                                        <option value=''>Select Team leader</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div id="DivQualityAnalist">
                                                <div class="form-group col-md-4">
                                                    <label for="form_control_1">Quality Analist</label>
                                                    <select class="form-control" name="qualityanalistid" id="qualityanalistid">
                                                        <option value=''>Select Quality Analist</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div id="DivTraining">
                                                <div class="form-group col-md-4">
                                                   <label for="form_control_1">Trainee Incharge</label>
                                                    <?php
                                                    
                                                    $queryCM = "SELECT * FROM `employee` where employeeid IN (select employeedesignation.iEmployeeId from employeedesignation where employeedesignation.iDesignationId=9) and isDelete=0 and istatus='1'";
                                                    $resultCM = mysqli_query($dbconn, $queryCM);
                                                    ?>
                                                    <select class="form-control" name="trainerId" id="trainerId" >
                                                        <option value=''>Select Trainer</option>
                                                        <?php
                                                        while ($rowCM = mysqli_fetch_array($resultCM)) {
                                                         //   $empname = mysqli_fetch_array(mysqli_query($dbconn, "SELECT * FROM `employee`  where isDelete='0'  and  istatus='1' and employeeid='" . $rowCM['iEmployeeId'] . "' "));
                                                         if ($rowCM['employeeid'] == $row['trainerId']) 
                                                            echo "<option value='" . $rowCM['employeeid'] . "' selected>" . $rowCM['empname'] . "</option>";
                                                        else    
                                                            echo "<option value='" . $rowCM['employeeid'] . "'>" . $rowCM['empname'] . "</option>";

                                                        }
                                                        ?>
                                                    </select>
                                                   
                                                </div>
                                            </div>
                                            <div id="DivManagerTQ">
                                                    <div class="form-group col-md-4">
                                                        <label for="form_control_1">Manager T&Q</label>
                                                        <select class="form-control" name="managerTQid" id="managerTQid">
                                                            <option value=''>Select Manager T&Q</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                 <div id="DivManagerOps">
                                                    <div class="form-group col-md-4">
                                                        <label for="form_control_1">Manager Ops</label>
                                                        <select class="form-control" name="managerOpsid" id="managerOpsid">
                                                            <option value=''>Select Manager Ops</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                 <div id="DivManagerHR">
                                                    <div class="form-group col-md-4">
                                                        <label for="form_control_1">Manager HR</label>
                                                        <select class="form-control" name="managerHRid" id="managerHRid">
                                                            <option value=''>Select Manager HR</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div id="DivManagerIT">
                                                    <div class="form-group col-md-4">
                                                        <label for="form_control_1">Manager IT</label>
                                                        <select class="form-control" name="managerITid" id="managerITid">
                                                            <option value=''>Select Manager IT</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div id="DivManagerMIS">
                                                    <div class="form-group col-md-4">
                                                        <label for="form_control_1">Manager WFM/MIS</label>
                                                        <select class="form-control" name="managerMISid" id="managerMISid">
                                                            <option value=''>Select Manager WFM/MIS</option>
                                                        </select>
                                                    </div>
                                                </div>
                                        </div>
                                        <div class="form-actions noborder">
                                            <input class="btn blue margin-top-20" type="button" id="Btnmybtn" value="Submit" name="submit" onclick="SubmitData(Event);">
                                            <button type="button" class="btn blue margin-top-20" onClick="checkclose();">Cancel</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <?php include_once './footer.php'; ?>
    <style>
        .multiselect {
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
    <link href="assets/bootstrap-multiselect.css" rel="stylesheet" type="text/css" />
    <script src="assets/bootstrap-multiselect.js" type="text/javascript"></script>
    <script type="text/javascript">
        $('#designation').multiselect({
            nonSelectedText: 'Select designation',
            includeSelectAllOption: true,
            buttonWidth: '100%',
            maxHeight: 250,
        });
        $('#process').multiselect({
            nonSelectedText: 'Select process',
            includeSelectAllOption: true,
            buttonWidth: '100%',
            maxHeight: 250,
            enableFiltering: true
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            var designation = $("#DesignationId").val();
            $('#DivTraining').hide();
            getEditManagerTQ();
            getEditManagerOps();
            getEditManagerHR();
            getEditManagerIT();
            getEditManagerMIS();
            
            geteditprocessmanager();
            geteditasstmanager();
            geteditteamlead();
            geteditqualityanalist();
            
            $('#trainerId').attr('required', false);
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
            /*if (DesignationId == 5) {
                $("#DivProcessManager").hide();
                $("#divAsstManager").hide();
                geteditteamlead();
                geteditqualityanalist();
                $("#iteamleadid").attr('required', true);
                $("#qualityanalistid").attr('required', true);
                $('#centralmanager').attr('required', true);
                $('#asstmanagerid').attr('required', false);
                $('#processmanager').attr('required', false);

            } else if (DesignationId == 6) {
                $("#DivCentralManager").hide();
                $("#DivProcessManager").hide();
                $("#divAsstManager").hide();
                $("#DivTeamLeader").hide();
                $("#DivQualityAnalist").hide();
                $("#iteamleadid").attr('required', false);
                $("#qualityanalistid").attr('required', false);
                $('#centralmanager').attr('required', true);
                $('#asstmanagerid').attr('required', false);
                $('#processmanager').attr('required', false);
            } else if (DesignationId == 3) {
                $("#DivProcessManager").hide();
                $("#divAsstManager").hide();
                $("#DivTeamLeader").hide();
                $("#DivQualityAnalist").hide();
                $("#iteamleadid").attr('required', false);
                $("#qualityanalistid").attr('required', false);
                $('#centralmanager').attr('required', true);
                $('#asstmanagerid').attr('required', false);
                $('#processmanager').attr('required', false);
            } else if (DesignationId == 2) {
                $("#divAsstManager").hide();
                $("#DivTeamLeader").hide();
                $("#DivQualityAnalist").hide();

                $('#centralmanager').attr('required', true);
                $('#iteamleadid').attr('required', false);
                $('#qualityanalistid').attr('required', false);
                $('#asstmanagerid').attr('required', false);
                $('#processmanager').attr('required', true);
                geteditprocessmanager();

            } else if (DesignationId == 7) {
                $("#divAsstManager").hide();
                $("#DivTeamLeader").hide();
                $("#DivQualityAnalist").hide();
                $("#iteamleadid").attr('required', false);
                $("#qualityanalistid").attr('required', false);
                $('#centralmanager').attr('required', true);
                $('#asstmanagerid').attr('required', false);
                $('#processmanager').attr('required', true);
                geteditprocessmanager();
            } else if (DesignationId == 10) {
                $("#divAsstManager").hide();
                $("#DivTeamLeader").hide();
                $("#DivQualityAnalist").hide();
                $("#iteamleadid").attr('required', false);
                $("#qualityanalistid").attr('required', false);
                $('#centralmanager').attr('required', true);
                $('#asstmanagerid').attr('required', false);
                $('#processmanager').attr('required', true);
                geteditprocessmanager();
            } else if (DesignationId == 11) {
                $("#divAsstManager").hide();
                $("#DivTeamLeader").hide();
                $("#DivQualityAnalist").hide();
                $("#iteamleadid").attr('required', false);
                $("#qualityanalistid").attr('required', false);
                $('#centralmanager').attr('required', true);
                $('#asstmanagerid').attr('required', false);
                $('#processmanager').attr('required', true);
                geteditprocessmanager();
            } else if (DesignationId == 8) {
                $("#divAsstManager").hide();
                $("#DivTeamLeader").hide();
                $("#DivQualityAnalist").hide();
                $("#iteamleadid").attr('required', false);
                $("#qualityanalistid").attr('required', false);
                $('#centralmanager').attr('required', true);
                $('#asstmanagerid').attr('required', false);
                $('#processmanager').attr('required', true);
                geteditprocessmanager();
            } else if (DesignationId == 4) {
                $("#DivProcessManager").hide();
                $("#DivTeamLeader").hide();
                $("#DivQualityAnalist").hide();
                $("#iteamleadid").attr('required', false);
                $("#qualityanalistid").attr('required', false);
                $('#centralmanager').attr('required', true);
                $('#asstmanagerid').attr('required', true);
                $('#processmanager').attr('required', false);
                geteditasstmanager();
            } else if (DesignationId == 1) {
                $("#DivProcessManager").hide();
                $("#DivTeamLeader").hide();
                $("#DivQualityAnalist").hide();
                $("#iteamleadid").attr('required', false);
                $("#qualityanalistid").attr('required', false);
                $('#centralmanager').attr('required', true);
                $('#asstmanagerid').attr('required', true);
                $('#processmanager').attr('required', false);
                geteditasstmanager();
            } else if (DesignationId == 9) {
                $("#DivProcessManager").hide();
                $("#DivTeamLeader").hide();
                $("#DivQualityAnalist").hide();
                $("#iteamleadid").attr('required', false);
                $("#qualityanalistid").attr('required', false);
                $('#centralmanager').attr('required', true);
                $('#asstmanagerid').attr('required', true);
                $('#processmanager').attr('required', false);
                geteditasstmanager();
            } else if (DesignationId == 12) {
                $("#DivProcessManager").hide();
                $("#DivQualityAnalist").hide();
                $('#DivTeamLeader').hide();
                $("#DivCentralManager").hide();
                $("#divAsstManager").hide();
                $("#iteamleadid").attr('required', false);
                $("#qualityanalistid").attr('required', false);
                $('#centralmanager').attr('required', true);
                $('#asstmanagerid').attr('required', true);
                $('#processmanager').attr('required', false);
                $('#DivTraining').show();
                $('#trainerId').attr('required', true);
            }*/
            // $("#iteamleadid").val($("#TLID").val());
            // $("#qualityanalistid").val($("#QAID").val());

        });
        
        $('#designation').change(function() {

            var designation = $(this).val();
            var CMid = $('#centralmanager').val();
            $('#DivTraining').hide();
            $('#trainerId').attr('required', false);
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
            /*if (designation == 2) {
                $('#DivCentralManager').show();
                $('#divAsstManager').hide();
                $('#DivTeamLeader').hide();
                $('#DivProcessManager').show();
                $('#DivQualityAnalist').hide();

                $('#centralmanager').attr('required', true);
                $('#iteamleadid').attr('required', false);
                $('#qualityanalistid').attr('required', false);
                $('#asstmanagerid').attr('required', false);
                $('#processmanager').attr('required', true);

                geteditprocessmanager();

            } else if (designation == 3) {

                $('#DivCentralManager').show();
                $('#divAsstManager').hide();
                $('#DivTeamLeader').hide();
                $('#DivProcessManager').hide();
                $('#DivQualityAnalist').hide();

                $('#centralmanager').attr('required', true);
                $('#iteamleadid').attr('required', false);
                $('#qualityanalistid').attr('required', false);
                $('#asstmanagerid').attr('required', false);
                $('#processmanager').attr('required', false);

            } else if (designation == 4) {
                $('#DivCentralManager').show();
                $('#divAsstManager').show();
                $('#DivTeamLeader').hide();
                $('#DivProcessManager').hide();
                $('#DivQualityAnalist').hide();

                $('#centralmanager').attr('required', true);
                $('#asstmanagerid').attr('required', true);
                $('#iteamleadid').attr('required', false);
                $('#qualityanalistid').attr('required', false);
                $('#processmanager').attr('required', false);
                geteditasstmanager();

            } else if (designation == 5) {
                $('#DivCentralManager').show();
                $('#DivTeamLeader').show();
                $('#DivQualityAnalist').show();
                $('#divAsstManager').hide();
                $('#DivProcessManager').hide();

                $('#centralmanager').attr('required', true);
                $('#iteamleadid').attr('required', true);
                $('#qualityanalistid').attr('required', true);
                $('#asstmanagerid').attr('required', false);
                $('#processmanager').attr('required', false);
                geteditteamlead();
                geteditqualityanalist();

            } else if (designation == 6) {
                $('#divAsstManager').hide();
                $('#DivTeamLeader').hide();
                $('#DivProcessManager').hide();
                $('#DivQualityAnalist').hide();
                $('#DivCentralManager').hide();

                $('#iteamleadid').attr('required', false);
                $('#qualityanalistid').attr('required', false);
                $('#asstmanagerid').attr('required', false);
                $('#processmanager').attr('required', false);
                $('#centralmanager').attr('required', false);

            } else if (designation == 7) {
                $('#DivCentralManager').show();
                $('#divAsstManager').hide();
                $('#DivTeamLeader').hide();
                $('#DivProcessManager').show();
                $('#DivQualityAnalist').hide();

                $('#centralmanager').attr('required', true);
                $('#iteamleadid').attr('required', false);
                $('#qualityanalistid').attr('required', false);
                $('#asstmanagerid').attr('required', false);
                $('#processmanager').attr('required', true);
                geteditprocessmanager();

            } else if (designation == 8) {
                $('#DivCentralManager').show();
                $('#DivProcessManager').show();
                $('#divAsstManager').hide();
                $('#DivTeamLeader').hide()
                $('#DivQualityAnalist').hide();

                $('#centralmanager').attr('required', true);
                $('#processmanager').attr('required', true);
                $('#iteamleadid').attr('required', false);
                $('#qualityanalistid').attr('required', false);
                $('#asstmanagerid').attr('required', false);
                geteditprocessmanager();

            } else if (designation == 9) {
                $('#DivCentralManager').show();
                $('#divAsstManager').show();
                $('#DivTeamLeader').hide();
                $('#DivProcessManager').hide();
                $('#DivQualityAnalist').hide();

                $('#centralmanager').attr('required', true);
                $('#asstmanagerid').attr('required', true);
                $('#iteamleadid').attr('required', false);
                $('#qualityanalistid').attr('required', false);
                $('#processmanager').attr('required', false);
                geteditasstmanager();

            } else if (designation == 10) {
                $('#DivCentralManager').show();
                $('#divAsstManager').hide();
                $('#DivTeamLeader').hide();
                $('#DivProcessManager').show();
                $('#DivQualityAnalist').hide();

                $('#centralmanager').attr('required', true);
                $('#iteamleadid').attr('required', false);
                $('#qualityanalistid').attr('required', false);
                $('#asstmanagerid').attr('required', false);
                $('#processmanager').attr('required', true);
                geteditprocessmanager();

            } else if (designation == 11) {
                $('#DivCentralManager').show();
                $('#divAsstManager').hide();
                $('#DivTeamLeader').hide();
                $('#DivProcessManager').show();
                $('#DivQualityAnalist').hide();

                $('#centralmanager').attr('required', true);
                $('#iteamleadid').attr('required', false);
                $('#qualityanalistid').attr('required', false);
                $('#asstmanagerid').attr('required', false);
                $('#processmanager').attr('required', true);
                geteditprocessmanager();

            } else if (designation == 1) {
                $('#DivCentralManager').show();
                $('#divAsstManager').show();
                $('#DivTeamLeader').hide();
                $('#DivProcessManager').hide();
                $('#DivQualityAnalist').hide();

                $('#centralmanager').attr('required', true);
                $('#asstmanagerid').attr('required', true);
                $('#iteamleadid').attr('required', false);
                $('#qualityanalistid').attr('required', false);
                $('#processmanager').attr('required', false);
                geteditasstmanager();

            } else if (designation == 12) {

                $('#divAsstManager').hide();
                $('#DivTeamLeader').hide();
                $('#DivProcessManager').hide();
                $('#DivQualityAnalist').hide();
                $('#DivCentralManager').hide();
                $('#centralmanager').attr('required', false);
                $('#iteamleadid').attr('required', false);
                $('#qualityanalistid').attr('required', false);
                $('#processmanager').attr('required', false);
                $('#asstmanagerid').attr('required', false);
                $('#DivTraining').show();
                $('#trainerId').attr('required', true);

            } else {
                $('#divAsstManager').hide();
                $('#DivTeamLeader').hide();
                $('#DivProcessManager').hide();
                $('#DivQualityAnalist').hide();
                $('#DivCentralManager').hide();
                $('#centralmanager').attr('required', false);
                $('#iteamleadid').attr('required', false);
                $('#qualityanalistid').attr('required', false);
                $('#processmanager').attr('required', false);
                $('#asstmanagerid').attr('required', false);
            }*/
        });

        $("#centralmanager").on('change', function() {
            var CMid = $(this).val();
            geteditprocessmanager(CMid);
            geteditasstmanager(CMid);
            geteditteamlead(CMid);
            geteditqualityanalist(CMid);
            
            getEditManagerTQ();
            getEditManagerOps();
            getEditManagerHR();
            getEditManagerIT();
            getEditManagerMIS();
        });

        function geteditcentralmanager() {
            var id = $("#centralmanager").val();
            $.ajax({
                type: 'POST',
                url: '<?php echo $web_url; ?>admin/querydata.php',
                data: {
                    action: "geteditcentralmanager",
                    ID: id
                },
                success: function(response) {
                    console.log(response);
                    $("#processmanager").html(response);
                }
            });
        }

        function geteditprocessmanager() {
            var id = $("#centralmanager").val();
            var PMID = $("#PMID").val();
            $.ajax({
                type: 'POST',
                url: '<?php echo $web_url; ?>admin/querydata.php',
                data: {
                    action: "geteditprocessmanager",
                    ID: id,
                    PMID: PMID
                },
                success: function(response) {
                    console.log(response);
                    $("#processmanager").html(response);
                }
            });
        }

        function geteditasstmanager() {
            var id = $("#centralmanager").val();
            var AMID = $("#AMID").val();
            $.ajax({
                type: 'POST',
                url: '<?php echo $web_url; ?>admin/querydata.php',
                data: {
                    action: "geteditasstmanager",
                    ID: id,
                    AMID: AMID
                },
                success: function(response) {
                    console.log(response);
                    $("#asstmanagerid").html(response);
                }
            });
        }

        function geteditteamlead() {
            var id = $("#centralmanager").val();
            var TLID = $("#TLID").val();
            $.ajax({
                type: 'POST',
                url: '<?php echo $web_url; ?>admin/querydata.php',
                data: {
                    action: "geteditteamlead",
                    ID: id,
                    TLID: TLID
                },
                success: function(response) {
                    console.log(response);
                    $("#iteamleadid").html(response);
                }
            });
        }

        function geteditqualityanalist() {
            var id = $("#centralmanager").val();
            var QAID = $("#QAID").val()
            $.ajax({
                type: 'POST',
                url: '<?php echo $web_url; ?>admin/querydata.php',
                data: {
                    action: "geteditqualityanalist",
                    ID: id,
                    QAID: QAID
                },
                success: function(response) {
                    console.log(response);
                    $("#qualityanalistid").html(response);
                }
            });
        }

        function checkclose() {
            window.location.href = '<?php echo $web_url; ?>admin/employee.php';
        }

        function chkLoginId(ID) {
            var q = $('#LoginID').val();
            var companyemployeeid = $('#companyemployeeid').val();
            var urlp = '<?php echo $web_url; ?>admin/findeditemployeeLoginID.php?ID=' + q;
            $.ajax({
                type: 'POST',
                url: urlp,
                success: function(data) {
                    if (data == 0) {
                        $('#errordiv').html('');
                    } else {
                        $('#errordiv').html(data);
                        $('#LoginID').val('');
                    }
                }
            }).error(function() {
                alert('An error occured');
            });
        }
    </script>
    <script type="text/javascript">
        function SubmitData(e) {
            $('#loading').css("display", "block");
            $.ajax({
                type: 'POST',
                url: '<?php echo $web_url; ?>admin/querydata.php',
                data: $('#frmparameter').serialize(),
                success: function(response) {
                    console.log(response);
                    if (response == 2) {
                        $('#loading').css("display", "none");
                        $("#Btnmybtn").attr('disabled', 'disabled');
                        alert(' Employee Edited Sucessfully.');
                        window.location.href = '<?php echo $web_url; ?>admin/employee.php';
                        return false;
                    } else {
                        $('#loading').css("display", "none");
                        $("#Btnmybtn").attr('disabled', 'disabled');
                        alert("Invalid Request");
                        return false;
                    }
                    return false;
                },
                error: function(error) {
                    alert("error");
                }
            });
            return false;
        }
        
        function getEditManagerTQ(){
            var id = $("#centralmanager").val();
            var TQId = $("#TQId").val()
            $.ajax({
                type: 'POST',
                url: '<?php echo $web_url; ?>admin/querydata.php',
                data: {
                    action: "getEditManagerTQ",
                    ID: id,
                    TQId: TQId
                },
                success: function(response) {
                    console.log(response);
                    $("#managerTQid").html(response);
                }
            });
        }
        
        function getEditManagerOps(){
            var id = $("#centralmanager").val();
            var Opsid = $("#Opsid").val();
            $.ajax({
                type: 'POST',
                url: '<?php echo $web_url; ?>admin/querydata.php',
                data: {
                    action: "getEditManagerOps",
                    ID: id,
                    Opsid: Opsid
                },
                success: function(response) {
                    console.log(response);
                    $("#managerOpsid").html(response);
                }
            });
        }
        
        function getEditManagerHR(){
            var id = $("#centralmanager").val();
            var HRid = $("#HRid").val();
            $.ajax({
                type: 'POST',
                url: '<?php echo $web_url; ?>admin/querydata.php',
                data: {
                    action: "getEditManagerHR",
                    ID: id,
                    HRid: HRid
                },
                success: function(response) {
                    console.log(response);
                    $("#managerHRid").html(response);
                }
            });
        }
        
        function getEditManagerIT(){
            var id = $("#centralmanager").val();
            var ITId = $("#ITId").val();
            $.ajax({
                type: 'POST',
                url: '<?php echo $web_url; ?>admin/querydata.php',
                data: {
                    action: "getEditManagerIT",
                    ID: id,
                    ITId: ITId
                },
                success: function(response) {
                    console.log(response);
                    $("#managerITid").html(response);
                }
            });
        }
        
        function getEditManagerMIS(){
            var id = $("#centralmanager").val();
            var MISId = $("#MISId").val();
            $.ajax({
                type: 'POST',
                url: '<?php echo $web_url; ?>admin/querydata.php',
                data: {
                    action: "getEditManagerMIS",
                    ID: id,
                    MISId: MISId
                },
                success: function(response) {
                    console.log(response);
                    $("#managerMISid").html(response);
                }
            });
        }
    </script>
</body>

</html>