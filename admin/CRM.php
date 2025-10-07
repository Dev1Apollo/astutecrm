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
        <title><?php echo $ProjectName; ?> | CRM </title>
        <?php include_once './include.php'; ?>
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
                                <span> CRM </span>
                            </li>
                        </ul>
                        <div class="page-content-inner">
                            <div class="row">
                                <div class="portlet light ">
                                    <div class="portlet-title">
                                        <div class="caption font-red-sunglo">
                                            <i class="icon-settings font-red-sunglo"></i>
                                            <span class="caption-subject bold uppercase">List of CRM </span>
                                        </div>
                                        <a href="<?php echo $web_url; ?>admin/AddCRM.php" class="btn blue pull-right margin-bottom-20" style="float: right;" title="ADD CRM"><i class="fa fa-upload"></i> </a>
                                    </div>
                                    <div class="portlet-body form">
                                        <div class="row">
                                            <form  role="form"  method="POST"  action="" name="frmSearch"  id="frmSearch" enctype="multipart/form-data">
                                                <div class="form-group col-md-offset-0 col-md-3">
                                                    <input type="text" value="" name="formDate" class="form-control" id="formDate" placeholder="Search Form Date" required/>
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <input type="text" value="" name="toDate" class="form-control" id="toDate" placeholder="Search To Date" required/>
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <input type="text" value="" name="applicatipnNo" class="form-control" id="applicatipnNo" placeholder="Search Applicatipn No" required/>
                                                </div>
                                                <div class="form-actions  col-md-3">
                                                    <a href="#" class="btn blue pull-left" onclick="PageLoadData(1);">Search</a>
                                                </div>
                                            </form>
                                            <div id="PlaceUsersDataHere">
                                            </div>
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
        <script src="<?php echo $web_url; ?>admin/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js" type="text/javascript"></script>
        <script type="text/javascript">

                                                        $(document).ready(function () {
                                                            $("#formDate").datepicker({
                                                                format: 'dd-mm-yyyy',
                                                                autoclose: true,
                                                                todayHighlight: true,
                                                                defaultDate: "now"
                                                            });
                                                            
                                                            $("#toDate").datepicker({
                                                                format: 'dd-mm-yyyy',
                                                                autoclose: true,
                                                                todayHighlight: true,
                                                                defaultDate: "now"
                                                            });
                                                        });

                                                        function PageLoadData(Page) {
                                                            var toDate = $('#toDate').val();
                                                            var formDate = $('#formDate').val();
                                                            var applicatipnNo = $('#applicatipnNo').val();
                                                            $('#loading').css("display", "block");
                                                            $.ajax({
                                                                type: "POST",
                                                                url: "<?php echo $web_url; ?>admin/AjaxCRM.php",
                                                                data: {action: 'ListUser', Page: Page, toDate: toDate, formDate: formDate,applicatipnNo: applicatipnNo},
                                                                success: function (msg) {
                                                                    $("#PlaceUsersDataHere").html(msg);
                                                                    $('#loading').css("display", "none");
                                                                }
                                                            });
                                                        }// end of filter
                                                    PageLoadData(1);

        </script>
    </body>
</html>