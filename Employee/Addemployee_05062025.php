<?php
ob_start();
include_once '../common.php';
$connect = new connect();
include('IsLogin.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title><?php echo $ProjectName; ?> | Employee </title>
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
                            <span>Employee</span>
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
                            <span class="caption-subject bold uppercase">Add Employee </span>
                        </div>
                    </div>
                    <div class="portlet-body form">
                        <form role="form" method="POST" action="" name="frmparameter" id="frmparameter" enctype="multipart/form-data">
                            <input type="hidden" value="Addemployee" name="action" id="action">
                            <div class="form-body">
                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label for="form_control_1">Employee Name</label>
                                        <input name="employeename" id="employeename" class="form-control" placeholder="Enter Your  Name" type="text" required="">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="form_control_1">Date Of Joining</label>
                                        <input type="text" id="dojoin" name="dojoin" class="form-control date-picker" placeholder="Enter The From Date" />
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="form_control_1">Contact Number</label>
                                        <input name="contactnumber" id="contactnumber" class="form-control" placeholder="Enter Your  Mobile" type="text">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label for="form_control_1">Astute Number</label>
                                        <input name="astutenumber" id="astutenumber" class="form-control" placeholder="Enter Your  Astute Number" type="text">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="form_control_1">Process</label>
                                        <?php
                                        $queryCom = "SELECT * FROM `processmaster`  where isDelete='0'  and  istatus='1' order by  processmasterid asc";
                                        $resultCom = mysqli_query($dbconn, $queryCom);
                                        echo '<select class="form-control" name="process" id="proces" required="required">';
                                        while ($rowCom = mysqli_fetch_array($resultCom)) {
                                            echo "<option value='" . $rowCom['processmasterid'] . "'>" . $rowCom['processname'] . "</option>";
                                        }
                                        echo "</select>";
                                        ?>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="form_control_1">Elision Login ID</label>
                                        <div id="errordiv"></div>
                                        <input name="elisionloginid" id="LoginID" class="form-control" placeholder="Enter Your Login ID." type="text" required="required" onblur="return chkLoginId();">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label for="form_control_1">Password</label>
                                        <input name="Password" id="Password" class="form-control" placeholder="Enter Your Password." type="text" required="required">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="form_control_1">Designation</label>
                                        <?php
                                        $queryCom = "SELECT * FROM `designation`  where isDelete='0'  and  istatus='1' order by  designationid asc";
                                        $resultCom = mysqli_query($dbconn, $queryCom);
                                        echo '<select class="form-control" name="designation" id="designation" required="required" >';
                                        echo "<option value='' >Select Designation Name</option>";
                                        while ($rowCom = mysqli_fetch_array($resultCom)) {
                                            echo "<option value='" . $rowCom['designationid'] . "'>" . $rowCom['designation'] . "</option>";
                                        }
                                        echo "</select>";
                                        ?>
                                    </div>
                                    <div id="DivTeamLeader">
                                        <div class="form-group col-md-4">
                                            <label for="form_control_1">Team leader</label>
                                            <select class="form-control" name="iteamleadid" id="iteamleadid">
                                                <option value='0'>Select Team leader</option>
                                                <?php
                                                $queryCom = "SELECT * FROM `employee` where employeeid IN (select employeedesignation.iEmployeeId from employeedesignation where employeedesignation.iDesignationId=4) and isDelete=0 and istatus='1'";
                                                $resultCom = mysqli_query($dbconn, $queryCom);
                                                while ($rowCom = mysqli_fetch_array($resultCom)) {
                                                    //$empname = mysqli_fetch_array(mysqli_query($dbconn, "SELECT * FROM `employee`  where isDelete='0'  and  istatus='1' and employeeid='" . $rowCom['iEmployeeId'] . "' "));
                                                    echo "<option value='" . $rowCom['employeeid'] . "'>" . $rowCom['empname'] . "</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div id="DivQualityAnalist">
                                        <div class="form-group col-md-4">
                                            <label for="form_control_1">Quality Analist</label>
                                            <select class="form-control" name="qualityanalistid" id="qualityanalistid">
                                                <option value='0'>Select Quality Analist</option>
                                                <?php
                                                $queryCom = "SELECT * FROM `employee` where employeeid IN (select employeedesignation.iEmployeeId from employeedesignation where employeedesignation.iDesignationId=1) and isDelete=0 and istatus='1'";
                                                $resultCom = mysqli_query($dbconn, $queryCom);
                                                while ($rowCom = mysqli_fetch_array($resultCom)) {
                                                    //  $empname = mysqli_fetch_array(mysqli_query($dbconn, "SELECT * FROM `employee`  where isDelete='0'  and  istatus='1' and employeeid='" . $rowCom['iEmployeeId'] . "' "));
                                                    echo "<option value='" . $rowCom['employeeid'] . "'>" . $rowCom['empname'] . "</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div id="divAsstManager">
                                        <div class="form-group col-md-4">
                                            <label for="form_control_1">AsstManager</label>
                                            <?php
                                            $queryCom = "SELECT * FROM `employee` where employeeid IN (select employeedesignation.iEmployeeId from employeedesignation where employeedesignation.iDesignationId=2) and isDelete=0 and istatus='1'";
                                            $resultCom = mysqli_query($dbconn, $queryCom);
                                            echo '<select class="form-control" name="asstmanagerid" id="asstmanagerid" >';
                                            echo "<option value='0' >Select AsstManager</option>";
                                            while ($rowCom = mysqli_fetch_array($resultCom)) {
                                                // $empname = mysqli_fetch_array(mysqli_query($dbconn, "SELECT * FROM `employee`  where isDelete='0'  and  istatus='1' and employeeid='" . $rowCom['iEmployeeId'] . "' "));
                                                echo "<option value='" . $rowCom['employeeid'] . "'>" . $rowCom['empname'] . "</option>";
                                            }
                                            echo "</select>";
                                            ?>
                                        </div>
                                    </div>
                                    <div id="DivProcessManager">
                                        <div class="form-group col-md-4">
                                            <label for="form_control_1">Process Manager</label>
                                            <?php
                                            $queryCom = "SELECT * FROM `employee` where employeeid IN (select employeedesignation.iEmployeeId from employeedesignation where employeedesignation.iDesignationId=3) and isDelete=0 and istatus='1'";
                                            $resultCom = mysqli_query($dbconn, $queryCom);
                                            echo '<select class="form-control" name="processmanager" id="processmanager" >';
                                            echo "<option value='0' >Select Process Manager</option>";
                                            while ($rowCom = mysqli_fetch_array($resultCom)) {
                                                //    $empname = mysqli_fetch_array(mysqli_query($dbconn, "SELECT * FROM `employee`  where isDelete='0'  and  istatus='1' and employeeid='" . $rowCom['iEmployeeId'] . "' "));
                                                echo "<option value='" . $rowCom['employeeid'] . "'>" . $rowCom['empname'] . "</option>";
                                            }
                                            echo "</select>";
                                            ?>
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
                                                    echo "<option value='" . $rowCM['employeeid'] . "'>" . $rowCM['empname'] . "</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
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
            buttonWidth: '100%',
            maxHeight: 250,
            enableFiltering: true
        });
    </script>
    <script src="<?php echo $web_url; ?>Employee/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js" type="text/javascript"></script>
    <script type="text/javascript">
        function checkclose() {
            window.location.href = '<?php echo $web_url; ?>Employee/employee.php';

        }

        $(document).ready(function() {
            $("#dojoin").datepicker({
                format: 'dd-mm-yyyy',
                autoclose: true,
                todayHighlight: true,
                defaultDate: "now",
                cache: false
            });
        });
        $('#designation').change(function() {
            var designation = $(this).val();
            if (designation == 5) {
                $('#DivQualityAnalist').show();
                $('#DivTeamLeader').show();
                $('#iteamleadid').attr('required', true);
                $('#qualityanalistid').attr('required', true);
                $('#divAsstManager').hide();
                $('#asstmanagerid').attr('required', false);
                $('#DivProcessManager').hide();
                $('#processmanager').attr('required', false);
                $('#DivTraining').hide();
                $('#trainerId').attr('required', false);
            } else if (designation == 2) {

               
                $('#divAsstManager').hide();
                $('#DivTeamLeader').hide();
                $('#DivProcessManager').show();
                $('#DivQualityAnalist').hide();
                $('#DivTraining').hide();
                $('#trainerId').attr('required', false);              
                $('#iteamleadid').attr('required', false);
                $('#qualityanalistid').attr('required', false);
                $('#asstmanagerid').attr('required', false);
                $('#processmanager').attr('required', true);

            } else if (designation == 6) {
                $('#divAsstManager').hide();
                $('#DivTeamLeader').hide();
                $('#DivProcessManager').hide();
                $('#DivQualityAnalist').hide();
                $('#iteamleadid').attr('required', false);
                $('#qualityanalistid').attr('required', false);
                $('#asstmanagerid').attr('required', false);
                $('#processmanager').attr('required', false);
                $('#DivTraining').hide();
                $('#trainerId').attr('required', false);
            } else if (designation == 4) {
                $('#divAsstManager').show();
                $('#DivTeamLeader').hide();
                $('#DivProcessManager').hide();
                $('#DivQualityAnalist').hide();
                $('#asstmanagerid').attr('required', true);
                $('#iteamleadid').attr('required', false);
                $('#qualityanalistid').attr('required', false);
                $('#processmanager').attr('required', false);
                $('#DivTraining').hide();
                $('#trainerId').attr('required', false);
            } else if (designation == 1) {
                $('#divAsstManager').show();
                $('#DivTeamLeader').hide();
                $('#DivProcessManager').hide();
                $('#DivQualityAnalist').hide();
                $('#asstmanagerid').attr('required', true);
                $('#iteamleadid').attr('required', false);
                $('#qualityanalistid').attr('required', false);
                $('#processmanager').attr('required', false);
                $('#DivTraining').hide();
                $('#trainerId').attr('required', false);
            } else if (designation == 12) {

                $('#divAsstManager').hide();
                $('#DivTeamLeader').hide();
                $('#DivProcessManager').hide();
                $('#DivQualityAnalist').hide();
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
                $('#iteamleadid').attr('required', false);
                $('#qualityanalistid').attr('required', false);
                $('#processmanager').attr('required', false);
                $('#asstmanagerid').attr('required', false);
                $('#DivTraining').hide();
                $('#trainerId').attr('required', false);
            }
        });



        function chkLoginId(ID) {
            var q = $('#LoginID').val();
            var urlp = '<?php echo $web_url; ?>Employee/findemployeeLoginID.php?ID=' + q;
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
                    $('#loading').css("display", "none");
                    console.log(response);
                         $("#Btnmybtn").attr('disabled', 'disabled');

                        alert('Employee Added Sucessfully.');

                    window.location.href = '<?php echo $web_url; ?>Employee/employee.php';

                    //}

                }
            });
        });
    </script>
    </script>
</body>

</html>