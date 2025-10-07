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

    <title><?php echo $ProjectName; ?> | Initiate Warning</title>

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

                            <span>Initiate Warning</span>

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

                            <span class="caption-subject bold uppercase">Initiate Warning </span>

                        </div>

                    </div>

                    <div class="portlet-body form">

                        <form role="form" method="POST" action="" name="frmparameter" id="frmparameter" enctype="multipart/form-data">

                            <input type="hidden" value="addWarning" name="action" id="action">

                            <div class="form-body">

                                <div class="row">

                                    <div class="form-group col-md-4">

                                        <label for="form_control_1">Warning For </label>
                                        <select name="warningfor" id="warningfor" class="form-control">
                                            <option value="">Select Employee Type</option>
                                            <option value="4">Team Leader</option>
                                            <option value="5">Agent</option>
                                        </select>

                                    </div>
                                    <div class="form-group col-md-4" id="teamleadDiv" style="display:none;">

                                        <label for="form_control_1">Select Team Lead</label>

                                        <select class="form-control" name="teamleadId" id="teamleadId">

                                            <option value=''>Select Employee</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-4">

                                        <label for="form_control_1">Warning For User</label>

                                        <select class="form-control" name="warningForId" id="warningForId" required="required">

                                            <option value=''>Select Employee</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <input type="file" id="gallery" name="gallery" class="btn red" required="" accept="application/msword,text/plain" />
                                    <input type="hidden" name="galeryID" ID="galeryID" />
                                    <div id="ImageGallery" style="display:none;">
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
    <script type="text/javascript">
        function checkclose() {
            window.location.href = '<?php echo $web_url; ?>Employee/employee.php';
        }
        $(document).ready(function() {
            $("#gallery").on('change', function() {
                var galeryID = 0;
                galeryID = galeryID + 1;
                $("#galeryID").val(galeryID);
                $("#ImageGallery").html('<img src="<?php echo $web_url; ?>admin/images/input-spinner.gif" alt="Uploading...."/>');
                var formData = new FormData($('form#frmparameter')[0]);
                $.ajax({
                    type: "POST",
                    url: "uploadFile.php",
                    processData: false,
                    contentType: false,
                    data: formData,
                    success: function(msg) {
                        //                         alert(msg);
                        $("#ImageGallery").show();
                        $("#ImageGallery").html(msg);
                    }
                });
            });
        });
        $('#warningfor').change(function() {
            var warningfor = $(this).val();
            if (warningfor=='5'){
                $("#teamleadDiv").show();
                $.ajax({
                    type: 'POST',
                    url: '<?php echo $web_url; ?>Employee/findWarningUser.php',
                    data: {
                        action: "teamleaduser"
                    },
                    success: function(response) {
                        $('#loading').css("display", "none");
                        $("#teamleadId").html(response);
                    }
                });
            }else{
                $("#teamleadDiv").hide();
                $.ajax({
                    type: 'POST',
                    url: '<?php echo $web_url; ?>Employee/findWarningUser.php',
                    data: {
                        warningfor: warningfor
                    },
                    success: function(response) {
                        $('#loading').css("display", "none");
                        $("#warningForId").html(response);
                    }
                });
            }
        });
        $('#teamleadId').change(function() {
            var teamleadId = $(this).val();
            var warningfor=$('#warningfor').val();
                $.ajax({
                    type: 'POST',
                    url: '<?php echo $web_url; ?>Employee/findWarningUser.php',
                    data: {
                        warningfor: warningfor,teamleadId:teamleadId
                    },
                    success: function(response) {
                        $('#loading').css("display", "none");
                        $("#warningForId").html(response);
                    }
                });
          
        });
        $('#frmparameter').submit(function(e) {
            e.preventDefault();
            var $form = $(this);
            $('#loading').css("display", "block");
            $.ajax({
                type: 'POST',
                url: '<?php echo $web_url; ?>Employee/querydata.php',
                data: $('#frmparameter').serialize(),
                success: function(response) {
                    $('#loading').css("display", "none");
                    $("#Btnmybtn").attr('disabled', 'disabled');
                    alert('Warning Later Added Sucessfully.');
                    window.location.href = '<?php echo $web_url; ?>Employee/warningLater.php';
                }
            });
        });
    </script>
</body>

</html>