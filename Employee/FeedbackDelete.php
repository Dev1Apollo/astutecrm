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
        <title><?php echo $ProjectName; ?> | Feedback Report </title>
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
                                <span>Feedback Report</span>
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
                                <span class="caption-subject bold uppercase">List of Feedback Report</span>
                            </div>
                        </div>
                        <div class="f_tab_main">
                        <div class="f_tab_link" style="border-bottom: 1px solid;color: #3f4296;">
                            <a href="onlineFeedback.php" class="f_tab_link_active">Post Feedback</a>
                            <a href="TlDisputeFeedback.php" class="f_tab_link_active" > Pending Feedback</a> 
                            <a href="closeFeedback.php" class="f_tab_link_active">Closed Feedback</a>
                            <?php
                                if(!empty($_SESSION)){
                                    if($_SESSION['Designation'] == 6){
                            ?>
                            <a href="FeedbackReport.php" class="f_tab_link_active">Feedback Report</a>
                            <a href="FeedbackDelete.php">Delete Feedback</a>
                            <?php } 
                            }
                            ?>
                          </div>
                      </div>
                        <div class="portlet-body form">
                            <div class="row">
                                <form  role="form"  method="POST"  action="" name="frmSearch"  id="frmSearch" enctype="multipart/form-data">
                                    <div class="form-group col-md-offset-1 col-md-3">
                                        <input type="text" value="" name="searchFeedback" class="form-control" id="searchFeedback" placeholder="Search Feedback Id" required/>
                                    </div>
                                    <div class="form-group col-md-5">
                                        <a href="#" class="btn blue pull-left" onclick="PageLoadData(1);">Search</a>
                                    </div>
                                </form>
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
                                            $(document).ready(function () {
                                                var date = new Date();
                                                var todayDate = new Date(date.getFullYear(), date.getMonth(0), 1);
//                                                var lastDate = new Date(today.getFullYear(), today.getMonth(0) - 1, 31);
                                                $("#formDate").datepicker({
                                                    format: 'dd-mm-yyyy',
                                                    autoclose: true,
                                                    todayHighlight: true,
                                                    // startDate: todayDate,
                                                    // endDate: new Date(),
                                                    // defaultDate: "now"
                                                });

                                                $("#toDate").datepicker({
                                                    format: 'dd-mm-yyyy',
                                                    autoclose: true,
                                                    todayHighlight: true,
                                                    // startDate: todayDate,
                                                    // endDate: new Date(),
                                                    // defaultDate: "now"
                                                });
                                            });

                                            function PageLoadData(Page) {
                                                var searchFeedback = $('#searchFeedback').val();
                                                $('#loading').css("display", "block");
                                                $.ajax({
                                                    type: "POST",
                                                    url: "<?php echo $web_url; ?>Employee/AjaxFeedbackDelete.php",
                                                    data: {action: 'ListUser', Page: Page, searchFeedback: searchFeedback},
                                                    success: function (msg) {
                                                        $('#SLID').show();
                                                        $('#loading').css("display", "none");
                                                        $("#PlaceUsersDataHere").html(msg);
                                                    }
                                                });
                                            }// end of filter
                                            //PageLoadData(1);
                                            
                                            function DeleteHistory(task, id)
                                            {
                                                var errMsg = '';
                                                if (task == 'Delete') {
                                                    errMsg = 'Are you sure to delete?';
                                                }
                                                if (confirm(errMsg)) {
                                                    $('#loading').css("display", "block");
                                                    $.ajax({
                                                        type: "POST",
                                                        url: "<?php echo $web_url; ?>Employee/AjaxFeedbackDelete.php",
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
                                        
                                        
    </script>
</body>

</html>