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
        <title><?php echo $ProjectName; ?> | Axis Bank Branch</title>
        <?php include_once './include.php'; ?>
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
                                <span>Axis Bank Branch</span>
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
                    <div class="portlet light ">
                        <div class="portlet-title">
                            <div class="caption font-red-sunglo">
                                <span class="caption-subject bold uppercase">Search Axis Bank Branch</span>
                            </div>
                            <?php if($_SESSION['Designation'] == 6){?>
                                <a href="AxisBankBranchUploadExcel.php" class="btn blue pull-right" title="Upload Excel"><i class="fa fa-upload"></i> </a>
                            <?php } ?>
                        </div>
                        <div class="portlet-body form">
                            <form role="form" method="POST" action="" name="frmparameter" id="frmparameter" enctype="multipart/form-data">
                                <div class="form-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group col-md-3">
                                                <label for="form_control_1">Pin Code</label>
                                                <input name="PinCode" id="PinCode" class="form-control" pattern="[0-9]{6}" placeholder="Enter Your Pin Code" type="text">
                                            </div>
<!--                                            <div class="form-group col-md-3">
                                                <label for="form_control_1">Partner Name</label>
                                                <input name="Partner" id="Partner" class="form-control" placeholder="Enter Your Partner Name" type="text">
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="form_control_1">City Name</label>
                                                <input name="City" id="City" class="form-control" placeholder="Enter Your City Name" type="text">
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="form_control_1">State Name</label>
                                                <input name="State" id="State" class="form-control" placeholder="Enter Your State Name" type="text">
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="form_control_1">Zone Name</label>
                                                <input name="Zone" id="Zone" class="form-control" placeholder="Enter Your Zone Name" type="text">
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="form_control_1">Merchant Name/Store Name/Dealer Name</label>
                                                <input name="StoreName" id="StoreName" class="form-control" placeholder="Enter Your Store Name" type="text">
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="form_control_1">SO Name</label>
                                                <input name="SOName" id="SOName" class="form-control" placeholder="Enter Your SO Name" type="text">
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="form_control_1">ASM</label>
                                                <input name="ASM" id="ASM" class="form-control" placeholder="Enter Your ASM" type="text">
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="form_control_1">Contact Number</label>
                                                <input name="ContactNumber" id="ContactNumber" class="form-control" placeholder="Enter Your Contact Number" type="text">
                                            </div>-->
                                            <div class="form-group col-md-3">
                                                <label for="form_control_1">Address</label>
                                                <textarea name="Address" id="Address" class="form-control" placeholder="Enter Your Address" type="text"></textarea>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <a href="#" class="btn blue margin-top-20" onclick="PageLoadData(1);">Search</a>
                                                <button type="button" class="btn blue margin-top-20" onclick="return checkClear();">Clear</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="portlet light " style="display: none;" id="SLID">
                        <div class="portlet-title">
                            <div class="caption font-red-sunglo">
                                <i class="icon-settings font-red-sunglo"></i>
                                <span class="caption-subject bold uppercase">List of Axis Bank Branch</span>
                            </div>
                        </div>
                        <div class="portlet-body form">
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
    <script type="text/javascript">

        function checkClear() {
            $('#PinCode').val('');
//            $('#Partner').val('');
//            $('#City').val('');
//            $('#State').val('');
//            $('#Zone').val('');
//            $('#StoreName').val('');
//            $('#SOName').val('');
//            $('#ASM').val('');
//            $('#ContactNumber').val('');
            $('#Address').val('');
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
                    url: "<?php echo $web_url; ?>Employee/AjaxAxisBankBranch.php",
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
            var PinCode = $('#PinCode').val();
//            var Partner = $('#Partner').val();
//            var City = $('#City').val();
//            var State = $('#State').val();
//            var Zone = $('#Zone').val();
//            var StoreName = $('#StoreName').val();
//            var SOName = $('#SOName').val();
//            var ASM = $('#ASM').val();
//            var ContactNumber = $('#ContactNumber').val();
            var Address = $('#Address').val();

            $('#loading').css("display", "block");
            $.ajax({
                type: "POST",
                url: "<?php echo $web_url; ?>Employee/AjaxAxisBankBranch.php",
                data: {action: 'ListUser', Page: Page, PinCode: PinCode, Address: Address},
                success: function (msg) {
                    $('#SLID').show();
                    $("#PlaceUsersDataHere").html(msg);
                    $('#loading').css("display", "none");
                },
            });
        }// end of filter
//            PageLoadData(1);

    </script>
</body>

</html>