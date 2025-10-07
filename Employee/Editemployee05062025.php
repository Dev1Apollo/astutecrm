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

                        <form role="form" method="POST" action="" name="frmparameter" id="frmparameter" enctype="multipart/form-data">

                            <input type="hidden" value="Editemployee" name="action" id="action">


                            <input type="hidden" value="<?php echo $row['iDesignationId']; ?>" name="DesignationId" id="DesignationId">
                            <input type="hidden" value="<?php echo $row['iteamleadid']; ?>" name="TLID" id="TLID">
                            <input type="hidden" value="<?php echo $row['processmanager']; ?>" name="PMID" id="PMID">
                            <input type="hidden" value="<?php echo $row['qualityanalistid']; ?>" name="QAID" id="QAID">
                            <input type="hidden" value="<?php echo $row['asstmanagerid']; ?>" name="AMID" id="AMID">
                            <input type="hidden" value="<?php echo $row['trainerId']; ?>" name="TRId" id="TRId">
                            <input type="hidden" value="<?php echo $row['employeeid'] ?>" name="employeeid" id="employeeid">
                            <?php if ($_SESSION['Designation'] == 6) { ?>
                                <input type="hidden" value="<?php echo $_SESSION['EmployeeId'] ?>" name="centralmanager" id="centralmanager">
                            <?php } else { ?>
                                <input type="hidden" value="<?php echo $row['centralmanagerId'] ?>" name="centralmanager" id="centralmanager">
                            <?php } ?>

                            <div class="form-body">

                                <div class="row">

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

                                </div>

                                <div class="row">

                                    <div class="form-group col-md-4">

                                        <label for="form_control_1">Astute Number</label>

                                        <input name="astutenumber" id="astutenumber" value="<?php echo $row['astutenumber']; ?>" class="form-control" placeholder="Enter Your  Astute Number" type="text">

                                    </div>

                                    <div class="form-group col-md-4">

                                        <label for="form_control_1">Process</label>

                                        <?php

                                        $queryCom = "SELECT * FROM `processmaster`  where isDelete='0'  and  istatus='1' order by  processmasterid asc";

                                        $resultCom = mysqli_query($dbconn, $queryCom);

                                        echo '<select class="form-control" name="process" id="proces" required="">';

                                        echo "<option value='' >Select Process Name</option>";

                                        while ($rowCom = mysqli_fetch_array($resultCom)) {

                                            if ($row['iProcessid'] == $rowCom['processmasterid']) {

                                                echo "<option value='" . $rowCom['processmasterid'] . "' selected>" . $rowCom['processname'] . "</option>";
                                            } else {

                                                echo "<option value='" . $rowCom['processmasterid'] . "'>" . $rowCom['processname'] . "</option>";
                                            }
                                        }

                                        echo "</select>";

                                        ?>

                                    </div>



                                    <div class="form-group col-md-4">

                                        <label for="form_control_1">Elision Login ID</label>
                                        <div id="errordiv"></div>

                                        <input name="elisionloginid" id="LoginID" value="<?php echo $row['elisionloginid']; ?>" class="form-control" placeholder="Enter Your Login ID." type="text" required="" onblur="return chkLoginId();">

                                    </div>

                                </div>

                                <div class="row">

                                    <div class="form-group col-md-4">

                                        <label for="form_control_1">Designation</label>

                                        <?php

                                        $queryCom = "SELECT * FROM `designation`  where isDelete='0'  and  istatus='1' order by  designationid asc";

                                        $resultCom = mysqli_query($dbconn, $queryCom);

                                        echo '<select class="form-control" name="designation" id="designation" required="">';

                                        while ($rowCom = mysqli_fetch_array($resultCom)) {
                                            //$designation = mysqli_fetch_array(mysqli_query($dbconn, "SELECT * FROM `employeedesignation`  where  iEmployeeId='" . $row['employeeid'] . "' and iDesignationId='" . $rowCom['designationid'] . "'  "));
                                            if ($rowCom['designationid'] == $row['iDesignationId']) {
                                                echo "<option value='" . $rowCom['designationid'] . "' selected>" . $rowCom['designation'] . "</option>";
                                            } else {
                                                echo "<option value='" . $rowCom['designationid'] . "'>" . $rowCom['designation'] . "</option>";
                                            }
                                        }
                                        echo "</select>";
                                        ?>
                                    </div>
                                    <div id="DivProcessManager">
                                        <div class="form-group col-md-4">
                                            <label for="form_control_1">Process Manager</label>
                                            <select class="form-control" name="processmanager" id="processmanager">
                                                <option value=''>Select Process Manager</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div id="divAsstManager">
                                        <div class="form-group col-md-4">
                                            <label for="form_control_1">AsstManager</label>
                                            <select class="form-control" name="asstmanagerid" id="asstmanagerid">
                                                <option value=''>Select AsstManager</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
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
                                            <select class="form-control" name="trainerId" id="trainerId">
                                                <option value='0'>Select Trainer</option>
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
                                </div>
                                <div class="form-actions noborder">
                                    <input class="btn blue margin-top-20" type="submit" id="Btnmybtn" value="Submit" name="submit">
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

    <link href="<?php echo $web_url; ?>admin/assets/bootstrap-multiselect.css" rel="stylesheet" type="text/css" />

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
        $(document).ready(function() {
            var DesignationId = $("#DesignationId").val();
            $('#DivTraining').hide();
            $('#trainerId').attr('required', false);
            if (DesignationId == 5) {
                $("#DivProcessManager").hide();
                $("#divAsstManager").hide();
                geteditteamlead();
                geteditqualityanalist();
                $("#iteamleadid").attr('required', true);
                $("#qualityanalistid").attr('required', true);
                $('#asstmanagerid').attr('required', false);
                $('#processmanager').attr('required', false);

            } else if (DesignationId == 3) {
                $("#DivProcessManager").hide();
                $("#divAsstManager").hide();
                $("#DivTeamLeader").hide();
                $("#DivQualityAnalist").hide();
                $("#iteamleadid").attr('required', false);
                $("#qualityanalistid").attr('required', false);
                $('#asstmanagerid').attr('required', false);
                $('#processmanager').attr('required', false);
            } else if (DesignationId == 2) {
                $("#divAsstManager").hide();
                $("#DivTeamLeader").hide();
                $("#DivQualityAnalist").hide();
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
                $('#asstmanagerid').attr('required', false);
                $('#processmanager').attr('required', true);
                geteditprocessmanager();
            } else if (DesignationId == 10) {
                $("#divAsstManager").hide();
                $("#DivTeamLeader").hide();
                $("#DivQualityAnalist").hide();
                $("#iteamleadid").attr('required', false);
                $("#qualityanalistid").attr('required', false);
                $('#asstmanagerid').attr('required', false);
                $('#processmanager').attr('required', true);
                geteditprocessmanager();
            } else if (DesignationId == 11) {
                $("#divAsstManager").hide();
                $("#DivTeamLeader").hide();
                $("#DivQualityAnalist").hide();
                $("#iteamleadid").attr('required', false);
                $("#qualityanalistid").attr('required', false);
                $('#asstmanagerid').attr('required', false);
                $('#processmanager').attr('required', true);
                geteditprocessmanager();
            } else if (DesignationId == 8) {
                $("#divAsstManager").hide();
                $("#DivTeamLeader").hide();
                $("#DivQualityAnalist").hide();
                $("#iteamleadid").attr('required', false);
                $("#qualityanalistid").attr('required', false);
                $('#asstmanagerid').attr('required', false);
                $('#processmanager').attr('required', true);
                geteditprocessmanager();
            } else if (DesignationId == 4) {
                $("#DivProcessManager").hide();
                $("#DivTeamLeader").hide();
                $("#DivQualityAnalist").hide();
                $("#iteamleadid").attr('required', false);
                $("#qualityanalistid").attr('required', false);
                $('#asstmanagerid').attr('required', true);
                $('#processmanager').attr('required', false);
                geteditasstmanager();
            } else if (DesignationId == 1) {
                $("#DivProcessManager").hide();
                $("#DivTeamLeader").hide();
                $("#DivQualityAnalist").hide();
                $("#iteamleadid").attr('required', false);
                $("#qualityanalistid").attr('required', false);
                $('#asstmanagerid').attr('required', true);
                $('#processmanager').attr('required', false);
                geteditasstmanager();
            } else if (DesignationId == 9) {
                $("#DivProcessManager").hide();
                $("#DivTeamLeader").hide();
                $("#DivQualityAnalist").hide();
                $("#iteamleadid").attr('required', false);
                $("#qualityanalistid").attr('required', false);
                $('#asstmanagerid').attr('required', true);
                $('#processmanager').attr('required', false);
                geteditasstmanager();
            } else if (DesignationId == 12) {
                $("#DivProcessManager").hide();
                $("#DivQualityAnalist").hide();
                $('#DivTeamLeader').hide();
                $("#divAsstManager").hide();
                $("#iteamleadid").attr('required', false);
                $("#qualityanalistid").attr('required', false);
                $('#asstmanagerid').attr('required', true);
                $('#processmanager').attr('required', false);
                $('#DivTraining').show();
                $('#trainerId').attr('required', true);
            }
            // $("#iteamleadid").val($("#TLID").val());
            // $("#qualityanalistid").val($("#QAID").val());

        });
        $('#designation').change(function() {

            var designation = $(this).val();
            var CMid = $('#centralmanager').val();
            $('#DivTraining').hide();
            $('#trainerId').attr('required', false);
            if (designation == 2) {
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
            }
        });


        function geteditprocessmanager() {
            var id = $("#centralmanager").val();
            var PMID = $("#PMID").val();
            $.ajax({
                type: 'POST',
                url: '<?php echo $web_url; ?>Employee/CentralManagerQuerydata.php',
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
                url: '<?php echo $web_url; ?>Employee/CentralManagerQuerydata.php',
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
                url: '<?php echo $web_url; ?>Employee/CentralManagerQuerydata.php',
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
                url: '<?php echo $web_url; ?>Employee/CentralManagerQuerydata.php',
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

            window.location.href = '<?php echo $web_url; ?>Employee/employee.php';

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

        $('#frmparameter').submit(function(e) {
            e.preventDefault();
            var $form = $(this);
            $('#loading').css("display", "block");
            $.ajax({
                type: 'POST',
                url: '<?php echo $web_url; ?>Employee/CentralManagerQuerydata.php',
                data: $('#frmparameter').serialize(),
                success: function(response) {
                    // alert(response);
                    console.log(response);
                    //$("#Btnmybtn").attr('disabled', 'disabled');
                    if (response == 2) {
                        $('#loading').css("display", "none");
                        $("#Btnmybtn").attr('disabled', 'disabled');
                        alert(' Employee Edited Sucessfully.');
                        window.location.href = '<?php echo $web_url; ?>Employee/employee.php';
                    }
                }
            });
        });
    </script>
</body>

</html>