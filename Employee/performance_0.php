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
        <title><?php echo $ProjectName; ?> | Performance</title>
        <?php include_once './include.php'; ?>
        <link href="global/plugins/bootstrap-datepicker/css/bootstrap-datepicker.css" rel="stylesheet" type="text/css" />
    </head>
    <!-- END HEAD -->
    <body class="page-header-fixed page-sidebar-closed-hide-logo page-content-white page-md">
        <div class="page-wrapper">
            <?php include_once './header.php'; ?>
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
                                <span>Performance</span>
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
                                <span class="caption-subject bold uppercase">List of Performance</span>
                            </div>
                            <!--<a onclick="exportexceldata()" class="btn green pull-right margin-bottom-20"><i class="fa fa-file-excel-o"></i></a>-->
                        </div>
                        <div class="portlet-body form">
                            <form role="form" method="POST" action="" name="frmparameter" id="frmparameter" enctype="multipart/form-data">
                                <div class="form-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group col-md-3">
                                                <label for="form_control_1">Performance Month</label>
                                                 
                                                <select name="Date" id="Date" class="form-control date-picker"> 
                                                    <option value="">Select Month</option>
                                                    <?php
                                                    $filterPerformance = mysqli_query($dbconn, "select * from employeeperformance GROUP by MONTH(date) limit 3 ");
                                                    while ($row = mysqli_fetch_array($filterPerformance)) {
                                                        $monthYear = date('M-y', strtotime($row['date']));
                                                        ?>
                                                        <option value="<?php echo $row['date']; ?>" ><?php echo $monthYear; ?></option>    
                                                        <?php
                                                    }
                                                    ?>
                                                </select>
                                                <!--<input name="fromDate" id="fromDate" class="form-control date-picker"  placeholder="Enter Your From Date" type="text">-->
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="form_control_1">To Date</label>
                                                <input name="toDate" id="toDate" class="form-control date-picker" placeholder="Enter Your To Date" type="text">
                                            </div>
                                            <div class="form-group col-md-3">
                                                <a href="#" class="btn blue margin-top-20" onclick="PageLoadData(1);">Search</a>
                                                <button type="button" class="btn blue margin-top-20" onclick="return checkClear();">Clear</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <div id="PlaceUsersDataHere">

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
    <script src="global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js" type="text/javascript"></script>
    <script type="text/javascript">
                                                    $(document).ready(function () {
                                                        $('#fromDate').datepicker({
                                                            format: 'dd-MM-yyyy',
                                                            autoclose: true,
                                                            todayHighlight: true,
                                                            defaultDate: "now",
                                                            endDate: "now"
                                                        });
                                                        $('#toDate').datepicker({
                                                            format: 'dd-MM-yyyy',
                                                            autoclose: true,
                                                            todayHighlight: true,
                                                            defaultDate: "now",
                                                            endDate: "now"
                                                        });
                                                    });
                                                    function PageLoadData(Page) {
                                                        var fromDate = $('#fromDate').val();
                                                        var toDate = $('#toDate').val();
                                                        $('#loading').css("display", "block");
                                                        $.ajax({
                                                            type: "POST",
                                                            url: "<?php echo $web_url; ?>Employee/AjaxPerformance.php",
                                                            data: {action: 'ListUser', Page: Page, fromDate: fromDate, toDate: toDate},
                                                            success: function (msg) {
                                                                $('#SLID').show();
                                                                $("#PlaceUsersDataHere").html(msg);
                                                                $('#loading').css("display", "none");
                                                            }
                                                        });
                                                    }// end of filter
//        PageLoadData(1);

                                                    function exportexceldata() {
                                                        var fromDate = $('#fromDate').val();
                                                        var toDate = $('#toDate').val();
                                                        window.location.href = 'export_Employee_Performance.php';
                                                    }
    </script>
</body>
</html>