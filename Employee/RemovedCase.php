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
        <title><?php echo $ProjectName; ?> | Removed Case </title>
        <?php include_once './include.php'; ?>
        <link href="<?php echo $web_url; ?>Employee/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker.css" rel="stylesheet" type="text/css" />
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
                                <span>Removed Case </span>
                            </li>
                        </ul>
                        <div class="page-toolbar">
                            
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <!-- END DASHBOARD STATS 1-->
                    <div class="portlet light " style="" id="SLID">
                        <div class="portlet-title">
                            <div class="caption font-red-sunglo">
                                <span class="caption-subject bold uppercase">List of Removed Cases</span>
                            </div>
                            <div class="actions">
                                <a href="javascript:void(0);" onclick="ExportToExcel();" class="btn green" title="Export to Excel">
                                    <i class="fa fa-file-excel-o"></i> 
                                </a>
                                &nbsp;
                                <a href="UploadRemovedCase.php" class="btn red pull-right margin-bottom-20" style="margin-right: 15px;" title="Upload Removed Cases">
                                    <i class="fa fa-upload"></i> 
                                </a>
                            </div>
                        </div>
                        <div class="portlet-body form">
                            <div class="row">
                                <form role="form" method="POST" action="" name="frmSearch" id="frmSearch" enctype="multipart/form-data">
                                    <div class="portlet-body form">
                                        <div class="row">
                                            <div class="form-group col-md-2">
                                                <input type="text" value="" name="formDate" class="form-control" id="formDate" placeholder="Search From Date"/>
                                            </div>
                                            <div class="form-group col-md-2">
                                                <input type="text" value="" name="toDate" class="form-control" id="toDate" placeholder="Search To Date"/>
                                            </div>
                                            <div class="form-group col-md-2">
                                                <input type="text" value="" name="applicatipnNo" class="form-control" id="applicatipnNo" placeholder="Search Application No"/>
                                            </div>
                                            <?php
                                            if ($_SESSION['Designation'] == 4 || $_SESSION['Designation'] == 6) {
                                                ?>
                                                <div class="form-group col-md-2">
                                                    <select name="EmployeeId" id="EmployeeId" class="form-control"> 
                                                        <option value="">Select Agent</option>
                                                        <option value="<?php echo $_SESSION['elisionloginid']; ?>"><?php echo $_SESSION['EmployeeName']; ?></option>
                                                        <?php
                                                        if ($_SESSION['Designation'] == 4) {
                                                            $filterEmployee = mysqli_query($dbconn, "SELECT * FROM `employee` where iteamleadid='" . $_SESSION['EmployeeId'] . "' order by empname asc");
                                                        } else if ($_SESSION['Designation'] == 6) {
                                                            $filterEmployee = mysqli_query($dbconn, "SELECT * FROM `employee` where asstmanagerid='" . $_SESSION['EmployeeId'] . "' order by empname asc");
                                                        }
                                                        while ($rowEmployee = mysqli_fetch_array($filterEmployee)) {
                                                            ?>
                                                            <option value="<?php echo $rowEmployee['elisionloginid']; ?>"><?php echo $rowEmployee['empname']; ?></option>
                                                        <?php }
                                                        ?>
                                                    </select>
                                                </div>
                                                <?php
                                            }
                                            ?>
                                            <div class="form-group col-md-1">
                                                <a href="#" class="btn blue pull-left" onclick="PageLoadData(1);">Search</a>
                                            </div>
                                        </div>
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
            var EmployeeId = $('#EmployeeId').val();
            $('#loading').css("display", "block");
            $.ajax({
                type: "POST",
                url: "<?php echo $web_url; ?>Employee/AjaxRemovedCase.php",
                data: {action: 'ListUser', Page: Page, toDate: toDate, formDate: formDate, applicatipnNo: applicatipnNo, EmployeeId: EmployeeId},
                success: function (msg) {
                    $('#SLID').show();
                    $('#loading').css("display", "none");
                    $("#PlaceUsersDataHere").html(msg);
                }
            });
        }
        
        PageLoadData(1);

        function ExportToExcel() {
            var toDate = $('#toDate').val();
            var formDate = $('#formDate').val();
            var applicatipnNo = $('#applicatipnNo').val();
            var EmployeeId = $('#EmployeeId').val();
            var strURL = "RemovedCaseExcel.php?toDate=" + toDate + "&formDate=" + formDate + "&applicatipnNo=" + applicatipnNo + "&EmployeeId=" + EmployeeId;
            window.open(strURL);
        }

        function restoreCase(appId, appNo) {
            if (confirm('Are you sure you want to restore case: ' + appNo + '?')) {
                $('#loading').css("display", "block");
                $.ajax({
                    type: "POST",
                    url: "<?php echo $web_url; ?>Employee/AjaxRemovedCase.php",
                    data: {action: 'restoreCase', appId: appId, appNo: appNo},
                    success: function (response) {
                        $('#loading').css("display", "none");
                        var result = JSON.parse(response);
                        if (result.success) {
                            alert('Case restored successfully!');
                            PageLoadData(1);
                        } else {
                            alert('Error: ' + result.message);
                        }
                    }
                });
            }
        }
    </script>
</body>
</html>