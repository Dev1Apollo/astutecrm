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
    <title><?php echo $ProjectName; ?> | Add Employee </title>
    <?php include_once 'include.php'; ?>
    <link href="<?php echo $web_url; ?>admin/assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo $web_url; ?>admin/assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.css" rel="stylesheet" type="text/css" />
</head>

<body class="page-container-bg-solid page-boxed">

    <?php include_once './header.php'; ?>

    <div style="display: none; z-index: 10060;" id="loading">

        <img id="loading-image" src="<?php echo $web_url; ?>admin/images/loader1.gif">

    </div>

    <div class="page-container">
        <div class="page-content-wrapper">
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
                            <span>Add Employee</span>
                        </li>
                    </ul>
                    <div class="page-content-inner">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="portlet light ">
                                    <div class="portlet-title">
                                        <div class="caption font-red-sunglo">
                                            <i class="icon-settings font-red-sunglo"></i>
                                            <span class="caption-subject bold uppercase"> Add Employee</span>
                                        </div>
                                    </div>
                                    <div class="portlet-body form">
                                        <form role="form" method="POST" action="" name="frmparameter" id="frmparameter" enctype="multipart/form-data">
                                            <input type="hidden" value="Addemployee" name="action" id="action">
                                            <div class="form-body">
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
                                                <div class="form-group col-md-4">
                                                    <label for="form_control_1">Employee Number</label>
                                                    <input name="astutenumber" id="astutenumber" class="form-control" placeholder="Enter Your  Astute Number" type="text">
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label for="form_control_1">Process</label>
                                                    <?php
                                                    $queryCom = "SELECT * FROM `processmaster`  where isDelete='0'  and  istatus='1' order by  processmasterid asc";
                                                    $resultCom = mysqli_query($dbconn, $queryCom);
                                                    echo '<select class="form-control" name="process[]" id="process" required="" multiple="multiple">';
                                                    while ($rowCom = mysqli_fetch_array($resultCom)) {
                                                        echo "<option value='" . $rowCom['processmasterid'] . "'>" . $rowCom['processname'] . "</option>";
                                                    }
                                                    echo "</select>";
                                                    ?>
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label for="form_control_1">Login ID</label>
                                                    <div id="errordiv"></div>
                                                    <input name="elisionloginid" id="LoginID" class="form-control" placeholder="Enter Your Login ID." type="text" required="" onblur="return chkLoginId();">
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label for="form_control_1">Password</label>
                                                    <input name="Password" id="Password" class="form-control" placeholder="Enter Your Password." type="text" required="">
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label for="form_control_1">Designation</label>
                                                    <?php
                                                    $queryCom = "SELECT * FROM `designation`  where isDelete='0'  and  istatus='1' order by  designationid asc";
                                                    $resultCom = mysqli_query($dbconn, $queryCom);
                                                    echo '<select class="form-control" name="designation[]" id="designation" required="" >';
                                                    while ($rowCom = mysqli_fetch_array($resultCom)) {
                                                        echo "<option value='" . $rowCom['designationid'] . "'>" . $rowCom['designation'] . "</option>";
                                                   }
                                                    echo "</select>";
                                                    ?>
                                                </div>
                                                <div id="DivTraining">
                                                    <div class="form-group col-md-4">
                                                       <label for="form_control_1">Trainee Incharge</label>
                                                        <?php
                                                        $queryCM = "SELECT * FROM `employee` where employeeid IN (select employeedesignation.iEmployeeId from employeedesignation where employeedesignation.iDesignationId=9) and isDelete=0 and istatus='1'";
                                                        $resultCM = mysqli_query($dbconn, $queryCM);
                                                        ?>
                                                        <select class="form-control" name="trainerId" id="trainerId" >
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
                                                <div id="DivCentralManager">
                                                    <div class="form-group col-md-4">
                                                       <label for="form_control_1">Central Manager</label>
                                                        <?php
                                                        //$queryCM = "SELECT * FROM `employeedesignation`  where isDelete='0'  and  istatus='1' and iDesignationId='6' ";
                                                        $queryCM = "SELECT * FROM `employee` where employeeid IN (select employeedesignation.iEmployeeId from employeedesignation where employeedesignation.iDesignationId=6) and isDelete=0 and istatus='1'";
                                                        $resultCM = mysqli_query($dbconn, $queryCM);
                                                        ?>
                                                        <select class="form-control" name="centralmanager" id="centralmanager" onchange="getcentralmanager();">
                                                            <option value=''>Select Central Manager</option>
                                                            <?php
                                                            while ($rowCM = mysqli_fetch_array($resultCM)) {
                                                                //$empname = mysqli_fetch_array(mysqli_query($dbconn, "SELECT * FROM `employee`  where isDelete='0'  and  istatus='1' and employeeid='" . $rowCM['iEmployeeId'] . "' "));
                                                                echo "<option value='" . $rowCM['employeeid'] . "'>" . $rowCM['empname'] . "</option>";
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
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
                                                <div id="DivTeamLeader">
                                                    <div class="form-group col-md-4">
                                                        <label for="form_control_1">Team leader</label>
                                                        <select class="form-control" name="iteamleadid" id="iteamleadid" required="required">
                                                            <option value=''>Select Team leader</option>
                                                       </select>
                                                    </div>
                                                </div>

                                                <div id="DivQualityAnalist">
                                                    <div class="form-group col-md-4">
                                                        <label for="form_control_1">Quality Analist</label>
                                                        <select class="form-control" name="qualityanalistid" id="qualityanalistid" required="required">
                                                            <option value=''>Select Quality Analist</option>
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

            enableFiltering: true

        });

        $('#process').multiselect({

            nonSelectedText: 'Select process',

            includeSelectAllOption: true,

            buttonWidth: '100%',

            maxHeight: 250,

            enableFiltering: true

        });
    </script>

    <script src="<?php echo $web_url; ?>admin/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js" type="text/javascript"></script>

    <script type="text/javascript">
        $(document).ready(function() {

            $("#dojoin").datepicker({

                format: 'dd-mm-yyyy',

                autoclose: true,

                todayHighlight: true,

                defaultDate: "now",

            });

        });
    </script>

    <script type="text/javascript">
        function checkclose() {

            window.location.href = '<?php echo $web_url; ?>admin/employee.php';

        }



        $('#designation').change(function() {

            var designation = $(this).val();

            if (designation == 2) {

                $('#DivCentralManager').show();
                $('#divAsstManager').hide();
                $('#DivTeamLeader').hide();
                $('#DivProcessManager').show();
                $('#DivQualityAnalist').hide();
                $('#DivTraining').hide();
                $('#trainerId').attr('required', false);
                $('#centralmanager').attr('required', true);
                $('#iteamleadid').attr('required', false);
                $('#qualityanalistid').attr('required', false);
                $('#asstmanagerid').attr('required', false);
                $('#processmanager').attr('required', true);

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
                $('#DivTraining').hide();
                $('#trainerId').attr('required', false);
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
                $('#DivTraining').hide();
                $('#trainerId').attr('required', false);
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
                $('#DivTraining').hide();
                $('#trainerId').attr('required', false);
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
                $('#DivTraining').hide();
                $('#trainerId').attr('required', false);
            } else if (designation == 7) {
                $('#DivCentralManager').show();
                $('#DivProcessManager').show();
                $('#divAsstManager').hide();
                $('#DivTeamLeader').hide();
                $('#DivQualityAnalist').hide();
               $('#centralmanager').attr('required', true);
                $('#iteamleadid').attr('required', false);
                $('#qualityanalistid').attr('required', false);
                $('#asstmanagerid').attr('required', false);
                $('#processmanager').attr('required', true);
                $('#DivTraining').hide();
                $('#trainerId').attr('required', false);

            } else if (designation == 8) {
                $('#DivCentralManager').show();
                $('#DivProcessManager').show();
                $('#divAsstManager').hide();
                $('#DivTeamLeader').hide();
                $('#DivQualityAnalist').hide();
                $('#centralmanager').attr('required', true);
                $('#processmanager').attr('required', true);
                $('#iteamleadid').attr('required', false);
                $('#qualityanalistid').attr('required', false);
                $('#asstmanagerid').attr('required', false);
                $('#DivTraining').hide();
                $('#trainerId').attr('required', false);
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
                $('#DivTraining').hide();
                $('#trainerId').attr('required', false);
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
                $('#DivTraining').hide();
                $('#trainerId').attr('required', false);
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
                $('#DivTraining').hide();
                $('#trainerId').attr('required', false);

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
                $('#DivTraining').hide();
                $('#trainerId').attr('required', false);

            } else if (designation == 12)  {
             
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



        function chkLoginId(ID)

        {

            var q = $('#LoginID').val();

            var urlp = '<?php echo $web_url; ?>admin/findemployeeLoginID.php?ID=' + q;

            $.ajax({

                type: 'POST',

                url: urlp,

                success: function(data) {

                    if (data == 0)

                    {

                        $('#errordiv').html('');

                    } else

                    {

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

                url: '<?php echo $web_url; ?>admin/querydata.php',

                data: $('#frmparameter').serialize(),

                success: function(response) {

                    //alert(response);

                    console.log(response);

                    //$("#Btnmybtn").attr('disabled', 'disabled');

                    // $('#loading').css("display", "none");

                    // $("#Btnmybtn").attr('disabled', 'disabled');

                    // alert('Employee Added Sucessfully.');

                    // window.location.href = '<?php echo $web_url; ?>admin/employee.php';

                    //}
                    if (response == 1) {

                        $('#loading').css("display", "none");

                        $("#Btnmybtn").attr('disabled', 'disabled');

                        alert('Employee Added Sucessfully.');

                        window.location.href = '<?php echo $web_url; ?>admin/employee.php';

                    } else if (response == 2) {

                        $('#loading').css("display", "none");

                        $("#Btnmybtn").attr('disabled', 'disabled');

                        alert('Elisionloginid is already in useed...');

                        window.location.href = '<?php echo $web_url; ?>admin/Addemployee.php';

                    } else {

                        $('#loading').css("display", "none");

                        $("#Btnmybtn").attr('disabled', 'disabled');

                        alert('Invalid Request.');

                        window.location.href = '';

                    }

                }



            });

        });
        $("#centralmanager").on('change', function() {
            var CMid = $(this).val();
            getasstmanager(CMid);
            getteamlead(CMid);
            getqualityanalist(CMid);
        });

        function getcentralmanager() {
            var id = $("#centralmanager").val();


            $.ajax({
                type: 'POST',
                url: '<?php echo $web_url; ?>admin/querydata.php',
                data: {
                    action: "getcentralmanager",
                    ID: id
                },
                success: function(response) {
                    console.log(response);
                    $("#processmanager").html(response);
                }
            });
        }

        function getasstmanager() {
            var id = $("#centralmanager").val();


            $.ajax({
                type: 'POST',
                url: '<?php echo $web_url; ?>admin/querydata.php',
                data: {
                    action: "getasstmanager",
                    ID: id
                },
                success: function(response) {
                    console.log(response);
                    $("#asstmanagerid").html(response);
                }
            });
        }

        function getteamlead() {
            var id = $("#centralmanager").val();


            $.ajax({
                type: 'POST',
                url: '<?php echo $web_url; ?>admin/querydata.php',
                data: {
                    action: "getteamlead",
                    ID: id
                },
                success: function(response) {
                    console.log(response);
                    $("#iteamleadid").html(response);
                }
            });
        }

        function getqualityanalist() {
            var id = $("#centralmanager").val();


            $.ajax({
                type: 'POST',
                url: '<?php echo $web_url; ?>admin/querydata.php',
                data: {
                    action: "getqualityanalist",
                    ID: id
                },
                success: function(response) {
                    console.log(response);
                    $("#qualityanalistid").html(response);
                }
            });
        }
    </script>

</body>

</html>