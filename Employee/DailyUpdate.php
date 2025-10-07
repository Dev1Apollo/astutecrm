<?php
ob_start();
error_reporting(E_ALL);
include_once '../common.php';
$connect = new connect();
include('IsLogin.php');
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title><?php echo $ProjectName; ?> | Daily Update </title>
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
                                <span>Daily Update</span>
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
                                <span class="caption-subject bold uppercase">LIST OF Daily Update </span>
                            </div>
                            <?php if ($_SESSION['Designation'] == 6) { ?>
                                <a href="<?php echo $web_url; ?>Employee/Adddailyupdate.php" class="btn blue pull-right margin-bottom-20" style="float: right;" title="ADD Daily Update"><i class="fa fa-upload"></i> </a>
                            <?php } ?>
                        </div>
                        <div class="portlet-body form">
                            <div class="row">
                                <form  role="form"  method="POST"  action="" name="frmSearch"  id="frmSearch" enctype="multipart/form-data">
                                    <div class="form-group  col-md-3">
                                        <input type="text" value="" name="formDate" class="form-control" id="formDate" placeholder="Search Form Date" required/>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <input type="text" value="" name="toDate" class="form-control" id="toDate" placeholder="Search To Date" required/>
                                    </div>
                                    <?php
//                                            echo "SELECT * FROM `employeedesignation` where iEmployeeId='" . $_SESSION['EmployeeId'] . "' and iDesignationId='4' and istatus='1' and isDelete='0'";
                                    $filterTeamLeader = mysqli_query($dbconn, "SELECT * FROM `employeedesignation` where iEmployeeId='" . $_SESSION['EmployeeId'] . "' and iDesignationId='4' and istatus='1' and isDelete='0'");
                                    if (mysqli_num_rows($filterTeamLeader) > 0) {
                                        ?>
                                        <div class="form-group col-md-3">
                                            <!--                                            <label for="form_control_1">Employee </label>-->
                                            <select name="EmployeeId" id="EmployeeId" class="form-control"> 
                                                <option value="">Select Employee</option>
                                                <option value="<?php echo $_SESSION['elisionloginid']; ?>"><?php echo $_SESSION['EmployeeName']; ?></option>
                                                <?php
                                                $filterEmployee = mysqli_query($dbconn, "SELECT * FROM `employee` where iteamleadid='" . $_SESSION['EmployeeId'] . "' order by empname asc");
                                                while ($rowEmployee = mysqli_fetch_array($filterEmployee)) {
                                                    ?>
                                                    <option value="<?php echo $rowEmployee['elisionloginid']; ?>"><?php echo $rowEmployee['empname']; ?></option>
                                                <?php }
                                                ?>
                                            </select>
                                        </div>
                                    <?php } if ($_SESSION['Designation'] == 6) { ?>
                                        <div class="form-group col-md-3">
                                            <select name="EmployeeId" required="" id="EmployeeId" class="form-control"> 
                                                <option value="">Select Employee</option>
                                                <?php
                                                $filterEmployee = mysqli_query($dbconn, "SELECT * FROM `employee` where istatus=1 and isDelete=0 order by empname asc");
                                                while ($rowEmployee = mysqli_fetch_array($filterEmployee)) {
                                                    ?>
                                                    <option value="<?php echo $rowEmployee['elisionloginid']; ?>"><?php echo $rowEmployee['empname']; ?></option>
                                                <?php }
                                                ?>
                                            </select>
                                        </div>
                                    <?php } ?>
                                    <div class="form-group col-md-3">
                                        <a href="#" class="btn blue pull-left" onclick="PageLoadData(1);">Search</a>
                                    </div>
                                </form>
                                <div id="PlaceUsersDataHere">
                                </div>
                            </div>
                        </div>
                        <!-- END DASHBOARD STATS 1-->
                    </div>
<!--                    <div class="portlet light " style="" id="SLID">
                        <div class="portlet-title">
                            <div class="caption font-red-sunglo">
                                <i class="icon-settings font-red-sunglo"></i>
                                <span class="caption-subject bold uppercase">List of Daily Update</span>
                            </div>
                        </div>
                        <div class="portlet-body form">
                            <div id="PlaceUsersDataHere"> 
                            </div>
                        </div>
                    </div>-->
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
        <script src="<?php echo $web_url; ?>Employee/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js" type="text/javascript"></script>
        <script type="text/javascript">

                                            $(document).ready(function () {
                                                $("#formDate").datepicker({
                                                    format: 'dd-mm-yyyy',
                                                    autoclose: true,
                                                    todayHighlight: true,
                                                    defaultDate: "now",
                                                });
                                                $("#toDate").datepicker({
                                                    format: 'dd-mm-yyyy',
                                                    autoclose: true,
                                                    todayHighlight: true,
                                                    defaultDate: "now",
                                                });
                                            });

                                            function checkClear() {
                                                $('#strfaq').val('');
                                                return false;
                                            }

                                            function deletedata(task, id)
                                            {
                                                var errMsg = '';
                                                if (task == 'Delete') {
                                                    errMsg = 'Are you sure to delete?';
                                                }
                                                if (confirm(errMsg)) {
                                                    $('#loading').css("display", "block");
                                                    $.ajax({
                                                        type: "POST",
                                                        url: "<?php echo $web_url; ?>Employee/AjaxDailyUpdate.php",
                                                        data: {action: task, ID: id},
                                                        success: function (msg) {
                                                            $('#loading').css("display", "none");
                                                            window.location.href = '';
                                                            return false;
                                                        }
                                                    });
                                                }
                                                return false;
                                            }

                                            function PageLoadData(Page) {
                                                var token = $('#token').val();
                                                var toDate = $('#toDate').val();
                                                var formDate = $('#formDate').val();
                                                var EmployeeId = $('#EmployeeId').val();
                                                $('#loading').css("display", "block");
                                                $.ajax({
                                                    type: "POST",
                                                    url: "<?php echo $web_url; ?>Employee/AjaxDailyUpdate.php",
                                                    data: {action: 'ListUser', Page: Page, token: token, EmployeeId: EmployeeId, toDate: toDate, formDate: formDate},
                                                    success: function (msg) {
                                                        $('#SLID').show();
                                                        $('#loading').css("display", "none");
                                                        $("#PlaceUsersDataHere").html(msg);
                                                    }
                                                });
                                            }// end of filter
                                            //PageLoadData(1);

        </script>
    </body>
</html>