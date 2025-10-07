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
        <title><?php echo $ProjectName; ?> | Upload Reassign Agent</title>
        <?php include_once './include.php'; ?>
        <link href="global/plugins/bootstrap-datepicker/css/bootstrap-datepicker.css" rel="stylesheet" type="text/css" />
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
                                <span> Upload Reassign Agent</span>
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
                                <span class="caption-subject bold uppercase">Upload Reassign Agent</span>
                            </div>
                            <!--<a onclick="exportexceldata()" class="btn green pull-right margin-bottom-20"><i class="fa fa-file-excel-o"></i></a>-->
                        </div>
                        <div class="portlet-body form">
                            <!--<form role="form" method="POST" action="" name="frmparameter" id="frmparameter" enctype="multipart/form-data">-->
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <form  role="form"  method="POST"  action="" name="frmuploadExcel"  id="frmuploadExcel" enctype="multipart/form-data" class="margin-bottom-40">
                                            <input type="hidden" value="AddReassignAgent" name="action" id="action">
                                            <div class="form-body">
                                                <div class="row">
                                                    <div class="form-group form-md-line-input has-warning col-md-12">
                                                        <div>
                                                            <div class="form-group">
                                                                <label for="exampleInputFile1">Excel file</label><br />
                                                                <input type="file"  id="gallery" name="gallery" class="btn red" required=""/>
                                                                <input type="hidden" name="galeryID" ID="galeryID" />
                                                            </div>
                                                            <div id="ImageGallery" style="display:none;">  </div>
                                                        </div>    
                                                    </div>
                                                    <div class="form-group form-md-line-input col-md-12">                                                            
                                                        <input class="btn blue" type="submit" id="Btnmybtn"  value="Submit" name="submit"> 
                                                        <div style="display: none;" id="loading"><img src="<?php echo $web_url ?>images/loader.gif"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="col-md-6">
                                        <h4 style="color : #f03f2a; font-weight: bold" id="errorlog">
                                        </h4>
                                    </div>
                                </div>
                            </div>
                            <!--</form>-->
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
        function checkclose() {
            window.location.href = '<?php echo $web_url; ?>Employee/TLandAMReassignAgent.php';
        }

        $('#frmuploadExcel').submit(function (e) {
            e.preventDefault();
            var $form = $(this);
            $('#loading').css("display", "block");
            $.ajax({
                type: 'POST',
                url: 'CentralManagerQuerydata.php',
                data: $('#frmuploadExcel').serialize(),
                success: function (response) {
                    if (response) {
                        console.log(response);
                        $('#loading').css("display", "none");
                        response = response.replace("0", "");
                        $('#loading').css("display", "none");
                        $("#errorlog").html(response);
                    } 
                }
            });
        });

    </script>
    <script type="text/javascript">

        $(document).ready(function ()
        {
            $("#gallery").on('change', function ()
            {
                var galeryID = 0;
                galeryID = galeryID + 1;
                $("#galeryID").val(galeryID);
                $("#ImageGallery").html('<img src="<?php echo $web_url; ?>admin/images/input-spinner.gif" alt="Uploading...."/>');
                var formData = new FormData($('form#frmuploadExcel')[0]);
                $.ajax({
                    type: "POST",
                    url: "uploadExcelTemp.php",
                    processData: false,
                    contentType: false,
                    data: formData,
                    success: function (msg) {
                        // alert(msg);
                        $("#ImageGallery").show();
                        $("#ImageGallery").html(msg);
                    }
                });
            });
        });

    </script>    
</body>
</html>