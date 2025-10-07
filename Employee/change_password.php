<?php
ob_start();
include_once '../common.php';
$connect = new connect();
include('IsLogin.php');
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <?php include_once './include.php'; ?>
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
                                <span>Change Password</span>
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
                    <div class="page-content-inner">
                        <div class="portlet light ">
                            <div class="portlet-title">
                                <div class="caption font-red-sunglo">
                                    <span class="caption-subject bold uppercase">Change Password</span>
                                </div>
                            </div>
                            <div class="portlet-body form">
                                <form role="form" method="POST" action="" name="fromchangepassword" id="fromchangepassword" enctype="multipart/form-data" class="margin-bottom-40">
                                    <input type="hidden" value="UserProfileChangePassword" name="action">
                                    <div class="form-body">
                                        <div class="form-group form-md-line-input col-md-4">
                                            <label for="form_control_1">Old Password</label>
                                            <input type="password" id="oldpassword" name="oldpassword" class="form-control" placeholder="Enter your Old Password" required="">
                                        </div>
                                        <div class="form-group form-md-line-input  col-md-4">
                                            <label for="form_control_1">New Password</label>
                                            <input type="password" id="password" name="password" class="form-control" placeholder="Enter your New Password" required="">
                                        </div>
                                        <div class="form-group form-md-line-input  col-md-4">
                                            <label for="form_control_1">Confirm Password</label>
                                            <input type="password" id="cpassword" name="cpassword" class="form-control" placeholder="Enter your Confirm Password" required="">
                                        </div>
                                    </div>
                                    <div class="form-actions noborder">
                                        <button type="button" onclick="changepassword();" class="btn blue margin-top-20">Submit</button>
                                        <button type="button" class="btn blue margin-top-20" onclick="checkclose();">Close</button>
                                    </div>
                                </form>
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
    <script type="text/javascript">
        function checkclose() {
            $('#loading').css("display", "block");
            window.location.href = '<?php echo $web_url; ?>Employee/index.php';
            $('#loading').css("display", "none");
        }

        function changepassword()
        {
            var oldps = $.trim($("#oldpassword").val());
            var ps = $.trim($("#password").val());
            var cps = $.trim($("#cpassword").val());
            if (oldps == '')
            {
                $("#oldpassword").attr("placeholder", "Old password Cannot be Blank");
                $("#oldpassword").focus();
            }
            if (ps != "" && cps != "")
            {
                if (ps != cps)
                {
                    $("#cpassword").val('');
                    $("#cpassword").attr("placeholder", "Confirm password Doen't match");
                    $("#cpassword").focus();
                } else {
                    var data = $('#fromchangepassword').serializeArray();
                    $('#loading').css("display", "block");
                    $.ajax({
                        type: "POST",
                        url: "<?php echo $web_url; ?>Employee/querydata.php",
                        data: data,
                        success: function (msg) {
                            $('#loading').css("display", "none");
                            var msg = $.trim(msg);
                            if (msg == 'Sucess') {
                                alert('Successfully Password Changed.')
                                window.location.href = "<?php echo $web_url; ?>Employee/Logout.php";
                            } else if (msg == 'OldNot') {
                                alert('Wrong Old Password !')
                                window.location.href = "";
                            } else {
                            }
                        },
                    });
                }
            } else {
                if (ps == "")
                    $("#password").attr("placeholder", "Enter New Password please");
                if (cps == "")
                    $("#cpassword").attr("placeholder", "Enter Confirm password");
            }
        }
    </script>
</body>

</html>