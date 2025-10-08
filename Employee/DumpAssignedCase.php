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
    <title><?php echo $ProjectName; ?> | Dump Assigned Case</title>
    <?php include_once './include.php'; ?>
    <link href="<?php echo $web_url; ?>Employee/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker.css" rel="stylesheet" type="text/css" />
</head>

<body class="page-header-fixed page-sidebar-closed-hide-logo page-content-white page-md">
<div class="page-wrapper">
    <?php include_once './header.php'; ?>
    <div style="display: none; z-index: 10060;" id="loading">
        <img id="loading-image" src="<?php echo $web_url; ?>Employee/images/loader.gif">
    </div>

    <div class="page-content-wrapper">
        <div class="page-content">
            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li><a href="index.php">Home</a><i class="fa fa-circle"></i></li>
                    <li><span>Dump Assigned Cases</span></li>
                </ul>
            </div>

            <div class="portlet light" id="SLID">
                <div class="portlet-title">
                    <div class="caption font-red-sunglo">
                        <span class="caption-subject bold uppercase">List of Assigned Cases</span>
                    </div>
                    <div class="actions">
                        <a href="javascript:void(0);" onclick="ExportToExcel();" class="btn green" title="Export to Excel">
                            <i class="fa fa-file-excel-o"></i> Export
                        </a>
                    </div>
                </div>

                <div class="portlet-body form">
                    <form method="POST" id="frmSearch">
                        <div class="row">
                            <div class="form-group col-md-2">
                                <input type="text" name="formDate" class="form-control" id="formDate" placeholder="From Date" />
                            </div>
                            <div class="form-group col-md-2">
                                <input type="text" name="toDate" class="form-control" id="toDate" placeholder="To Date" />
                            </div>
                            <!--<div class="form-group col-md-2">-->
                            <!--    <input type="text" name="applicatipnNo" class="form-control" id="applicatipnNo" placeholder="Application No" />-->
                            <!--</div>-->
                            <div class="form-group col-md-1">
                                <a href="#" class="btn blue" onclick="PageLoadData(1);">Search</a>
                            </div>
                        </div>
                    </form>

                    <div class="row">
                        <div id="PlaceUsersDataHere"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include_once './footer.php'; ?>
</div>

<?php include_once './footerjs.php'; ?>
<script src="<?php echo $web_url; ?>Employee/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>

<script>
$(document).ready(function () {
    $("#formDate, #toDate").datepicker({
        format: 'dd-mm-yyyy',
        autoclose: true,
        todayHighlight: true
    });

    //PageLoadData(1);
});

function PageLoadData(Page) {
    var toDate = $('#toDate').val();
    var formDate = $('#formDate').val();
    //var applicatipnNo = $('#applicatipnNo').val();

    $('#loading').show();

    $.ajax({
        type: "POST",
        url: "<?php echo $web_url; ?>Employee/AjaxDumpAssignedCase.php",
        data: {
            action: 'ListUser',
            Page: Page,
            toDate: toDate,
            formDate: formDate,
            //applicatipnNo: applicatipnNo
        },
        success: function (msg) {
            $('#loading').hide();
            $("#PlaceUsersDataHere").html(msg);
        }
    });
}

function ExportToExcel() {
    var toDate = $('#toDate').val();
    var formDate = $('#formDate').val();
    var applicatipnNo = $('#applicatipnNo').val();

    //var strURL = "DumpAssignedCaseExcel.php?toDate=" + toDate + "&formDate=" + formDate + "&applicatipnNo=" + applicatipnNo;
    var strURL = "DumpAssignedCaseExcel.php?toDate=" + toDate + "&formDate=" + formDate;
    window.open(strURL);
}
</script>
</body>
</html>
