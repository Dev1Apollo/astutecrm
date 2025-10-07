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
                                <?php                                
                                $filterSetting = mysqli_fetch_array(mysqli_query($dbconn, "SELECT * FROM `crmsetting` where elisionloginid='" . $_SESSION['elisionloginid'] . "'"));
                                ?>
                                <form role="form" method="POST" action="" name="fromCRMsetting" id="fromCRMsetting" enctype="multipart/form-data" class="margin-bottom-40">
                                    <input type="hidden" value="CRMSettting" name="action" id="action">
                                    <input type="hidden" value="<?php echo $_SESSION['Designation']; ?>" name="Designation" id="Designation"> 
                                    <div class="form-body">
                                        <input type="checkbox" id="ckbCheckAll" /> Check All
                                        <p id="checkBoxes">
                                        <div class="custom-control custom-checkbox mb-3">
                                            <?php 
                                            if ($filterSetting['applicatipnNo'] == 1) { ?>
                                                <input type="checkbox" checked="" id="applicatipnNo" value="1" name="applicatipnNo" class="custom-control-input">
                                            <?php } else { ?>
                                                <input type="checkbox" id="applicatipnNo" value="1" name="applicatipnNo" class="custom-control-input">
                                            <?php } ?>
                                            <label class="custom-control-label" for="customCheck">Application Number</label>
                                        </div>

                                        <div class="custom-control custom-checkbox mb-3">
                                            <?php 
                                            if ($filterSetting['bucket'] == 1) { ?>
                                                <input type="checkbox" checked="" id="bucket" value="1" name="bucket" class="custom-control-input">
                                            <?php } else { ?>
                                                <input type="checkbox" id="bucket" value="1" name="bucket" class="custom-control-input">
                                            <?php } ?>
                                            <label class="custom-control-label" for="customCheck">Bucket</label>
                                        </div>

                                        <div class="custom-control custom-checkbox mb-3">
                                            <?php if ($filterSetting['customerName'] == 1) { ?>
                                                <input type="checkbox" id="customerName" checked="" value="1" name="customerName" class="custom-control-input">
                                            <?php } else { ?>
                                                <input type="checkbox" id="customerName" value="1" name="customerName" class="custom-control-input">
                                            <?php } ?>
                                            <label class="custom-control-label" for="customCheck">Customer Name</label>
                                        </div>
                                        <div class="custom-control custom-checkbox mb-3">
                                            <?php if ($filterSetting['branch'] == 1) { ?>
                                                <input type="checkbox" id="branch" name="branch" value="1" checked="" class="custom-control-input">
                                            <?php } else { ?>
                                                <input type="checkbox" id="branch" name="branch" value="1" class="custom-control-input">
                                            <?php } ?>
                                            <label class="custom-control-label" for="customCheck">branch</label>
                                        </div>

                                        <div class="custom-control custom-checkbox mb-3">
                                            <?php if ($filterSetting['state'] == 1) { ?>
                                                <input type="checkbox" id="state" name="state" value="1" class="custom-control-input" checked="">
                                            <?php } else { ?>
                                                <input type="checkbox" id="state" name="state" value="1" class="custom-control-input">
                                            <?php } ?>
                                            <label class="custom-control-label" for="customCheck">State</label>
                                        </div>
                                        <div class="custom-control custom-checkbox mb-3">
                                            <?php if ($filterSetting['customerMobile'] == 1) { ?>
                                                <input type="checkbox" id="customerMobile" name="customerMobile" value="1" class="custom-control-input" checked="">
                                            <?php } else { ?>
                                                <input type="checkbox" id="customerMobile" name="customerMobile" value="1" class="custom-control-input">
                                            <?php } ?>
                                            <label class="custom-control-label" for="customCheck">Customer Mobile</label>
                                        </div>
                                        <div class="custom-control custom-checkbox mb-3">
                                            <?php if ($filterSetting['customerAddress'] == 1) { ?>
                                                <input type="checkbox" id="customerAddress" name="customerAddress" value="1" class="custom-control-input" checked="">
                                            <?php } else { ?>
                                                <input type="checkbox" id="customerAddress" name="customerAddress" value="1" class="custom-control-input">
                                            <?php } ?>
                                            <label class="custom-control-label" for="customCheck">Customer Address</label>
                                        </div>
                                        <div class="custom-control custom-checkbox mb-3">
                                            <?php if ($filterSetting['customerCity'] == 1) { ?>
                                                <input type="checkbox" id="customerCity" name="customerCity" value="1" class="custom-control-input" checked="">
                                            <?php } else { ?>
                                                <input type="checkbox" id="customerCity" name="customerCity" value="1" class="custom-control-input">
                                            <?php } ?>
                                            <label class="custom-control-label" for="customCheck">Customer City</label>
                                        </div>
                                        <div class="custom-control custom-checkbox mb-3">
                                            <?php if ($filterSetting['customerZipcode'] == 1) { ?>
                                                <input type="checkbox" id="customerZipcode" name="customerZipcode" value="1" class="custom-control-input" checked="">
                                            <?php } else { ?>
                                                <input type="checkbox" id="customerZipcode" name="customerZipcode" value="1" class="custom-control-input">
                                            <?php } ?>
                                            <label class="custom-control-label" for="customCheck">Customer Zip Code</label>
                                        </div>
                                        <div class="custom-control custom-checkbox mb-3">
                                            <?php if ($filterSetting['loanAmount'] == 1) { ?>
                                                <input type="checkbox" id="loanAmount" name="loanAmount" value="1" class="custom-control-input" checked="">
                                            <?php } else { ?>
                                                <input type="checkbox" id="loanAmount" name="loanAmount" value="1" class="custom-control-input">
                                            <?php } ?>
                                            <label class="custom-control-label" for="customCheck">Loan Amount</label>
                                        </div>
                                        <div class="custom-control custom-checkbox mb-3">
                                            <?php if ($filterSetting['EMIAmount'] == 1) { ?>
                                                <input type="checkbox" id="EMIAmount" name="EMIAmount" value="1" class="custom-control-input" checked="">
                                            <?php } else { ?>
                                                <input type="checkbox" id="EMIAmount" name="EMIAmount" value="1" class="custom-control-input">
                                            <?php } ?>
                                            <label class="custom-control-label" for="customCheck">EMI Amount</label>
                                        </div>
                                        <div class="custom-control custom-checkbox mb-3">
                                            <?php if ($filterSetting['agencyName'] == 1) { ?>
                                                <input type="checkbox" id="agencyName" name="agencyName" value="1" class="custom-control-input" checked="">
                                            <?php } else { ?>
                                                <input type="checkbox" id="agencyName" name="agencyName" value="1" class="custom-control-input">
                                            <?php } ?>
                                            <label class="custom-control-label" for="customCheck">Agency Name</label>
                                        </div>
                                        <!--                                        <div class="custom-control custom-checkbox mb-3">
                                                                                    <input type="checkbox" id="agentId" name="agentId" value="1" class="custom-control-input">
                                                                                    <label class="custom-control-label" for="customCheck">Agent Id</label>
                                                                                </div>-->
                                        <div class="custom-control custom-checkbox mb-3">
                                            <?php if ($filterSetting['FOSName'] == 1) { ?>
                                                <input type="checkbox" id="FOSName" name="FOSName" value="1" class="custom-control-input" checked="">
                                            <?php } else { ?>
                                                <input type="checkbox" id="FOSName" name="FOSName" value="1" class="custom-control-input">
                                            <?php } ?>
                                            <label class="custom-control-label" for="customCheck">FOS Name</label>
                                        </div>
                                        <div class="custom-control custom-checkbox mb-3">
                                            <?php if ($filterSetting['FOSContact'] == 1) { ?>
                                                <input type="checkbox" id="FOSContact" name="FOSContact" value="1" class="custom-control-input" checked="">
                                            <?php } else { ?>
                                                <input type="checkbox" id="FOSContact" name="FOSContact" value="1" class="custom-control-input">
                                            <?php } ?>
                                            <label class="custom-control-label" for="customCheck">FOS Contact</label>
                                        </div>
                                        <div class="custom-control custom-checkbox mb-3">
                                            <?php if ($filterSetting['LastCallDate'] == 1) { ?>
                                                <input type="checkbox" id="LastCallDate" name="LastCallDate" value="1" class="custom-control-input" checked="">
                                            <?php } else { ?>
                                                <input type="checkbox" id="LastCallDate" name="LastCallDate" value="1" class="custom-control-input">
                                            <?php } ?>
                                            <label class="custom-control-label" for="customCheck">Last Call Date</label>
                                        </div>
                                        <div class="custom-control custom-checkbox mb-3">
                                            <?php if ($filterSetting['Lastdisposition'] == 1) { ?>
                                                <input type="checkbox" id="Lastdisposition" name="Lastdisposition" value="1" class="custom-control-input" checked="">
                                            <?php } else { ?>
                                                <input type="checkbox" id="Lastdisposition" name="Lastdisposition" value="1" class="custom-control-input">
                                            <?php } ?>
                                            <label class="custom-control-label" for="customCheck">Last disposition</label>
                                        </div>
                                        <div class="custom-control custom-checkbox mb-3">
                                            <?php if ($filterSetting['FollowupDate'] == 1) { ?>
                                                <input type="checkbox" id="FollowupDate" name="FollowupDate" value="1" class="custom-control-input" checked="">
                                            <?php } else { ?>
                                                <input type="checkbox" id="FollowupDate" name="FollowupDate" value="1" class="custom-control-input">
                                            <?php } ?>
                                            <label class="custom-control-label" for="customCheck">Follow-up / PTP Date</label>
                                        </div>

                                        <div class="custom-control custom-checkbox mb-3">
                                            <?php if ($filterSetting['FollowupTime'] == 1) { ?>
                                                <input type="checkbox" id="FollowupTime" name="FollowupTime" value="1" class="custom-control-input" checked="">
                                            <?php } else { ?>
                                                <input type="checkbox" id="FollowupTime" name="FollowupTime" value="1" class="custom-control-input">
                                            <?php } ?>
                                            <label class="custom-control-label" for="customCheck">Follow-up / PTP Time</label>
                                        </div>
                                        <div class="custom-control custom-checkbox mb-3">
                                            <?php if ($filterSetting['Remark'] == 1) { ?>
                                                <input type="checkbox" id="Remark" name="Remark" value="1" class="custom-control-input" checked="">
                                            <?php } else { ?>
                                                <input type="checkbox" id="Remark" name="Remark" value="1" class="custom-control-input">
                                            <?php } ?>
                                            <label class="custom-control-label" for="customCheck">Remark</label>
                                        </div>
                                        <div class="custom-control custom-checkbox mb-3">
                                            <?php if ($filterSetting['feedback'] == 1) { ?>
                                                <input type="checkbox" id="feedback" name="feedback" value="1" class="custom-control-input" checked="">
                                            <?php } else { ?>
                                                <input type="checkbox" id="feedback" name="feedback" value="1" class="custom-control-input">
                                            <?php } ?>
                                            <label class="custom-control-label" for="customCheck">Feedback</label>
                                        </div>
                                        </p>
                                    </div>
                                    <div class="form-actions noborder">
                                        <input type="submit" id="submit" name="submit" value="Submit" class="btn blue margin-top-20"></button>
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
        $(document).ready(function () {
            $("#ckbCheckAll").click(function () {
                $(".custom-control-input").prop('checked', $(this).prop('checked'));
            });

            $(".checkBoxClass").change(function () {
                if (!$(this).prop("checked")) {
                    $("#ckbCheckAll").prop("checked", false);
                }
            });
        });

        $('#fromCRMsetting').submit(function (e) {
            e.preventDefault();
            var Designation = $('#Designation').val();
            var $form = $(this);
            $('#loading').css("display", "block");
            $.ajax({
                type: 'POST',
                url: 'CentralManagerQuerydata.php',
                data: $('#fromCRMsetting').serialize(),
                success: function (response) {
//                    alert(response);
                    response = response.trim();
                    if (response) {
                        if (Designation == 6) {
                            $('#loading').css("display", "none");
                            alert("Add Successfully");
                            window.location.href = '<?php echo $web_url; ?>Employee/CRM.php';
                        } else {
                            $('#loading').css("display", "none");
                            alert("Add Successfully");
                            window.location.href = '<?php echo $web_url; ?>Employee/AgentCRM.php';
                        }
                    } else {
                        $('#loading').css("display", "none");
                        alert("Invlied Request");
                        window.location.href = '<?php echo $web_url; ?>Employee/CRMTableCloumn.php';
                    }
                }
            });
        });
    </script>
</body>

</html>