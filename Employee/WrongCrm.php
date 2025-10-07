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
        <title><?php echo $ProjectName; ?> | Wrong CRM </title>
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
                                <span>Wrong CRM </span>
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
                    <!-- END DASHBOARD STATS 1-->
                    <div class="portlet light " style="" id="SLID">
                        <div class="portlet-title">
                            <div class="caption font-red-sunglo">
                                <span class="caption-subject bold uppercase">List of Wrong CRM</span>
                            </div>
                            <?php if ($_SESSION['Designation'] == 6) { ?>
                                                                <!--<a href="<?php // echo $web_url;   ?>Employee/AddCRM.php" class="btn blue pull-right margin-bottom-20" style="float: right;" title="ADD CRM"><i class="fa fa-upload"></i> </a>-->
                                                                <!--<a href="CNEmployeeFollowup.php" class="btn green pull-right margin-bottom-20" style="margin-right: 15px;" title="Employee"><i class="fa fa-eye"></i> Employee Followup Details</a>-->
                            <?php } ?>
                        </div>
                        <div class="portlet-body form">
                            <div class="row">
                                <form  role="form"  method="POST"  action="" name="frmSearch"  id="frmSearch" enctype="multipart/form-data">
<!--                                    <input type="hidden" name="Designation" id="Designation" value="<?php echo $_SESSION['Designation']; ?>">
                                    <div class="form-group col-md-2" >
                                        <input type="text" value="" name="formdate" class="form-control" id="formdate" placeholder="Enter From Date" required/>
                                    </div>
                                    <div class="form-group col-md-2" >
                                        <input type="text" value="" name="todate" class="form-control" id="todate" placeholder="Enter To Date" required/>
                                    </div>-->
                                    <div class="form-group col-md-3">
                                        <a href="#" class="btn blue pull-left" onclick="DeleteData();">Delete All</a>
                                        <a onclick="exportToEmployeeData();" href="#" target="_blank" class="btn green  margin-bottom-20" style="margin-right: 20px; margin-left: 10px;" title="Employee"><i class="fa fa-file-excel-o"></i></a>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="row">
                            <div id="PlaceUsersDataHere">
                            </div>
                        </div>
                    </div>
                </div>
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
<script src="<?php echo $web_url; ?>Employee/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js" type="text/javascript"></script>
<script type="text/javascript">
//                                            $(function () {
//
//                                                $("#formdate").datepicker({
//                                                    format: 'dd-mm-yyyy',
//                                                    autoclose: true,
//                                                    todayHighlight: true,
//                                                    defaultDate: "now"
//                                                });
//
//                                                $("#todate").datepicker({
//                                                    format: 'dd-mm-yyyy',
//                                                    autoclose: true,
//                                                    todayHighlight: true,
//                                                    defaultDate: "now"
//                                                });
//
//                                            });

                                            function PageLoadData(Page) {
                                                var EmployeeId = $('#EmployeeId').val();

                                                $('#loading').css("display", "block");
                                                $.ajax({
                                                    type: "POST",
                                                    url: "<?php echo $web_url; ?>Employee/AjaxWrongCRM.php",
                                                    data: {action: 'ListUser', Page: Page, EmployeeId: EmployeeId},
                                                    success: function (msg) {
                                                        $('#SLID').show();
                                                        $('#loading').css("display", "none");
                                                        $("#PlaceUsersDataHere").html(msg);
                                                    }
                                                });
                                            }// end of filter
                                            PageLoadData(1);

                                            function exportToEmployeeData() {
                                                window.location.href = 'CRMWrongExcel.php';
                                            }

                                            function DeleteData() {
                                                var error = "Are You Sure To Delete?";
                                                $('#loading').css("display", "block");
                                                if (confirm(error)) {
                                                    $.ajax({
                                                        type: "POST",
                                                        url: "<?php echo $web_url; ?>Employee/AjaxWrongCRM.php",
                                                        data: {action: 'DeleteAllData'},
                                                        success: function (msg) {
                                                            $('#loading').css("display", "none");
                                                            alert("Delete Data Successfully");
                                                            window.location.href = "";
                                                        }
                                                    });
                                                } else {
                                                    return false;
                                                }
                                            }

</script>   
</body>

</html>