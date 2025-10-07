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
                                <span class="caption-subject bold uppercase">LIST OF Employee </span>
                            </div>
                            <?php 
                                if($_SESSION['Designation'] == 6)
                                { ?>
                            <a href="EmployeeExcel.php" class="btn green pull-right margin-bottom-20" style="margin-left:15px;" title="Employee"><i class="fa fa-file-excel-o"></i></a>
                               <?php } ?>
                            <a href="<?php echo $web_url; ?>Employee/Addemployee.php" class="btn blue" style="float: right;" title="Add Company Employee">ADD Employee</a>
                            
                        </div>
                        <div class="portlet-body form">
                            <div class="row">
                                <form  role="form"  method="POST"  action="" name="frmSearch"  id="frmSearch" enctype="multipart/form-data">
                                    <div class="row">
                                        <div class="form-group col-md-3">
                                            <input type="text" value="" name="Search_Txt" class="form-control" id="Search_Txt" placeholder="Search Employee Name " required/>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <a href="#" class="btn blue pull-left" onclick="PageLoadData(1);">Search</a>
                                        </div>
                                    </div>
                                </form>
                                <div id="PlaceUsersDataHere">
                                </div>
                            </div>
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
        <script src="<?php echo $web_url; ?>Employee/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js" type="text/javascript"></script>
        <script type="text/javascript">
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
                                                            url: "<?php echo $web_url; ?>Employee/Ajaxemployee.php",
                                                            data: {action: task, ID: id},
                                                            success: function (msg) {
                                                                $('#loading').css("display", "none");
                                                                window.location.href = '';
                                                                return false;
                                                            },
                                                        });
                                                    }
                                                    return false;
                                                }

                                                function PageLoadData(Page) {
                                                    var Location = $('#Location').val();
                                                    var Search_Txt = $('#Search_Txt').val();
                                                    $('#loading').css("display", "block");
                                                    $.ajax({
                                                        type: "POST",
                                                        url: "<?php echo $web_url; ?>Employee/Ajaxemployee.php",
                                                        data: {action: 'ListUser', Page: Page, Location: Location, Search_Txt: Search_Txt},
                                                        success: function (msg) {
                                                            $('#loading').css("display", "none");
                                                            $("#PlaceUsersDataHere").html(msg);
                                                        },
                                                    });
                                                }// end of filter
                                                PageLoadData(1);

        </script>
    </script>
</body>
</html>