<?php
ob_start();
error_reporting(0);
include_once '../common.php';
$connect = new connect();
include('IsLogin.php');
//headers("cache-control : no-cache" );
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title><?php echo $ProjectName; ?> | TL Agent Lead Details</title>
        <?php include_once './include.php'; ?>
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
                                <span> TL Agent Lead Details </span>
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
                                <span class="caption-subject bold uppercase">TL Agent Lead Details</span>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <?php
                            $filterTL = mysqli_query($dbconn, "Select * from employee where iteamleadid='" . $_REQUEST['token'] . "' ORDER BY `employeeid` ASC");
                            if (mysqli_num_rows($filterTL) > 0) {
                                ?>
                                <table class="table table-bordered table-hover center table-responsive" width="100%" id="tableC">
                                    <thead class="tbg">
                                        <tr>
                                            <th class="pop_in_heading" colspan="3"></th>
                                            <th class="pop_in_heading" colspan="5">MTD</th>
                                            <th class="pop_in_heading" colspan="4">FTD</th>
                                        </tr>
                                        <tr>
                                            <th class="pop_in_heading_1">Agent Name</th>
                                            <th class="pop_in_heading_1">Total Leads</th>
                                            <th class="pop_in_heading_1">Unresolved Leads</th>
                                            <th class="pop_in_heading_1">Total Attempt</th>
                                            <th class="pop_in_heading_1">Total Connect</th>
                                            <th class="pop_in_heading_1">0 Dial</th>
                                            <th class="pop_in_heading_1">Paid</th>
                                            <th class="pop_in_heading_1">PTP</th>

                                            <th class="pop_in_heading_1">Attempt</th>
                                            <th class="pop_in_heading_1">Connect</th>
                                            <th class="pop_in_heading_1">0 dial</th>
                                            <th class="pop_in_heading_1">PTP</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $addData = array();
                                        while ($rowEmployee = mysqli_fetch_array($filterTL)) {
                                            ?>
                                            <tr>
                                                <td>
                                                    <?php
                                                    echo $rowEmployee['empname'];
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    $filterTotalLeads = mysqli_fetch_array(mysqli_query($dbconn, "SELECT count(*) as `totalCount` FROM `application` where agentId='" . $rowEmployee['elisionloginid'] . "' and isWithdraw='0'"));
                                                    echo $filterTotalLeads['totalCount'];
                                                    $addData[0]+=$filterTotalLeads['totalCount'];
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    $filterTotalUnpaidLeads = mysqli_fetch_array(mysqli_query($dbconn, "SELECT count(*) as `totalCount` FROM `application` where agentId='" . $rowEmployee['elisionloginid'] . "' and isWithdraw='0' and isPaid='0'"));
                                                    echo $filterTotalUnpaidLeads['totalCount'];
                                                    $addData[1]+=$filterTotalUnpaidLeads['totalCount'];
                                                    ?>
                                                </td>
                                                <!---------------------------------- MTD ----------------------------------->
                                                <td>
                                                    <?php
                                                    $filterTotalAttemptLeads = mysqli_fetch_array(mysqli_query($dbconn, "SELECT count(*) as `totalCount` FROM `applicationfollowup` where iAppId IN (select iAppId from application where agentId='" . $rowEmployee['elisionloginid'] . "' and isWithdraw='0') and MONTH(STR_TO_DATE(strEntryDate,'%d-%m-%Y'))=MONTH(CURRENT_DATE()) and YEAR(STR_TO_DATE(strEntryDate,'%d-%m-%Y'))=YEAR(CURRENT_DATE())"));
                                                    echo $filterTotalAttemptLeads['totalCount'];
                                                    $addData[2]+=$filterTotalAttemptLeads['totalCount'];
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    $filterTotalConnectLeads = mysqli_fetch_array(mysqli_query($dbconn, "SELECT count(*) as `totalCount` FROM `applicationfollowup` where iAppId IN (select iAppId from application where agentId='" . $rowEmployee['elisionloginid'] . "' and isWithdraw='0') and dispoType='1' and MONTH(STR_TO_DATE(strEntryDate,'%d-%m-%Y'))=MONTH(CURRENT_DATE()) and YEAR(STR_TO_DATE(strEntryDate,'%d-%m-%Y'))=YEAR(CURRENT_DATE())"));
                                                    echo $filterTotalConnectLeads['totalCount'];
                                                    $addData[3]+=$filterTotalConnectLeads['totalCount'];
                                                    ?>
                                                </td>

                                                <?php
                                                $filterTotalzeroDialLeads = mysqli_fetch_array(mysqli_query($dbconn, "SELECT count(*) as `totalCount` FROM `application` where iAppId NOT IN (select iAppId from applicationfollowup where MONTH(STR_TO_DATE(strEntryDate,'%d-%m-%Y'))=MONTH(CURRENT_DATE()) and YEAR(STR_TO_DATE(strEntryDate,'%d-%m-%Y'))=YEAR(CURRENT_DATE())) and agentId='" . $rowEmployee['elisionloginid'] . "' and isWithdraw='0' and isPaid='0' "));
                                                if ($filterTotalzeroDialLeads['totalCount'] == 0) {
                                                    echo '<td>';
                                                    echo $filterTotalzeroDialLeads['totalCount'];
                                                    $addData[4]+=$filterTotalzeroDialLeads['totalCount'];
                                                    echo "</td>";
                                                } else {
                                                    echo '<td style="background-color: red">';
                                                    echo $filterTotalzeroDialLeads['totalCount'];
                                                    $addData[4]+=$filterTotalzeroDialLeads['totalCount'];
                                                    echo "</td>";
                                                }
                                                ?>
                                                <td>
                                                    <?php
                                                    $filterTotalPaidLeads = mysqli_fetch_array(mysqli_query($dbconn, "SELECT count(*) as `totalCount` FROM `application` where agentId='" . $rowEmployee['elisionloginid'] . "' and isWithdraw='0' and isPaid='1' and MONTH(STR_TO_DATE(strEntryDate,'%d-%m-%Y'))=MONTH(CURRENT_DATE()) and YEAR(STR_TO_DATE(strEntryDate,'%d-%m-%Y'))=YEAR(CURRENT_DATE())"));
                                                    echo $filterTotalPaidLeads['totalCount'];
                                                    $addData[5]+=$filterTotalPaidLeads['totalCount'];
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    $filterTotalPTPLeads = mysqli_fetch_array(mysqli_query($dbconn, "SELECT count(*) as `totalCount` FROM `applicationfollowup` where iAppId IN (select iAppId from application where agentId='" . $rowEmployee['elisionloginid'] . "' and isWithdraw='0') and  PTPDate <>'' and MONTH(STR_TO_DATE(strEntryDate,'%d-%m-%Y'))=MONTH(CURRENT_DATE()) and YEAR(STR_TO_DATE(strEntryDate,'%d-%m-%Y'))=YEAR(CURRENT_DATE())"));
                                                    echo $filterTotalPTPLeads['totalCount'];
                                                    $addData[6]+=$filterTotalPTPLeads['totalCount'];
                                                    ?>
                                                </td>

                                                <!---------------------------------- FTD ----------------------------------->
                                                <td>
                                                    <?php
                                                    $filterTodaysAttemptLeads = mysqli_fetch_array(mysqli_query($dbconn, "SELECT count(*) as `totalCount` FROM `applicationfollowup` where iAppId IN (select iAppId from application where agentId='" . $rowEmployee['elisionloginid'] . "' and isWithdraw='0') and MONTH(STR_TO_DATE(strEntryDate,'%d-%m-%Y'))=MONTH(CURRENT_DATE()) and YEAR(STR_TO_DATE(strEntryDate,'%d-%m-%Y'))=YEAR(CURRENT_DATE()) and STR_TO_DATE(strEntryDate,'%d-%m-%Y') = CURRENT_DATE()"));
                                                    echo $filterTodaysAttemptLeads['totalCount'];
                                                    $addData[7]+=$filterTodaysAttemptLeads['totalCount'];
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    $filterTodaysConnectLeads = mysqli_fetch_array(mysqli_query($dbconn, "SELECT count(*) as `totalCount` FROM `applicationfollowup` where iAppId IN (select iAppId from application where agentId='" . $rowEmployee['elisionloginid'] . "' and isWithdraw='0') and dispoType='1' and MONTH(STR_TO_DATE(strEntryDate,'%d-%m-%Y'))=MONTH(CURRENT_DATE()) and YEAR(STR_TO_DATE(strEntryDate,'%d-%m-%Y'))=YEAR(CURRENT_DATE()) and STR_TO_DATE(strEntryDate,'%d-%m-%Y') = CURRENT_DATE()"));
                                                    echo $filterTodaysConnectLeads['totalCount'];
                                                    $addData[8]+=$filterTodaysConnectLeads['totalCount'];
                                                    ?>
                                                </td>

                                                <?php
                                                $filterTodaysZeroDialLeads = mysqli_fetch_array(mysqli_query($dbconn, "SELECT count(*) as `totalCount` FROM `application` where iAppId NOT IN (select iAppId from applicationfollowup where MONTH(STR_TO_DATE(strEntryDate,'%d-%m-%Y'))=MONTH(CURRENT_DATE()) and YEAR(STR_TO_DATE(strEntryDate,'%d-%m-%Y'))=YEAR(CURRENT_DATE()) and STR_TO_DATE(strEntryDate,'%d-%m-%Y') = CURRENT_DATE()) and agentId='" . $rowEmployee['elisionloginid'] . "' and isWithdraw='0' and isPaid='0'"));
                                                if ($filterTodaysZeroDialLeads['totalCount'] == 0) {
                                                    echo '<td>';
                                                    echo $filterTodaysZeroDialLeads['totalCount'];
                                                    $addData[9]+=$filterTodaysZeroDialLeads['totalCount'];
                                                    echo "</td>";
                                                } else {
                                                    echo '<td style="background-color: red">';
                                                    echo $filterTodaysZeroDialLeads['totalCount'];
                                                    $addData[9]+=$filterTodaysZeroDialLeads['totalCount'];
                                                    echo "</td>";
                                                }
                                                ?>

                                                <td>
                                                    <?php
                                                    $filterTodaysPTPLeads = mysqli_fetch_array(mysqli_query($dbconn, "SELECT count(*) as `totalCount` FROM `applicationfollowup` where iAppId IN (select iAppId from application where agentId='" . $rowEmployee['elisionloginid'] . "' and isWithdraw='0') and  PTPDate <>'' and MONTH(STR_TO_DATE(strEntryDate,'%d-%m-%Y'))=MONTH(CURRENT_DATE()) and YEAR(STR_TO_DATE(strEntryDate,'%d-%m-%Y'))=YEAR(CURRENT_DATE()) and STR_TO_DATE(strEntryDate,'%d-%m-%Y') = CURRENT_DATE()"));
                                                    echo $filterTodaysPTPLeads['totalCount'];
                                                    $addData[10]+=$filterTodaysPTPLeads['totalCount'];
                                                    ?>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                    <tr>
                                        <th class="pop_in_heading" colspan="1"><b>Total</b></th>
                                        <th class="pop_in_heading" colspan="1"><?php echo $addData[0]; ?></th>
                                        <th class="pop_in_heading" colspan="1"><?php echo $addData[1]; ?></th>
                                        <th class="pop_in_heading" colspan="1"><?php echo $addData[2]; ?></th>
                                        <th class="pop_in_heading" colspan="1"><?php echo $addData[3]; ?></th>
                                        <th class="pop_in_heading" colspan="1"><?php echo $addData[4]; ?></th>
                                        <th class="pop_in_heading" colspan="1"><?php echo $addData[5]; ?></th>
                                        <th class="pop_in_heading" colspan="1"><?php echo $addData[6]; ?></th>
                                        <th class="pop_in_heading" colspan="1"><?php echo $addData[7]; ?></th>
                                        <th class="pop_in_heading" colspan="1"><?php echo $addData[8]; ?></th>
                                        <th class="pop_in_heading" colspan="1"><?php echo $addData[9]; ?></th>                            
                                        <th class="pop_in_heading" colspan="1"><?php echo $addData[10]; ?></th>
                                    </tr>
                                </table>
                                <?php
                            } else {
                                ?>
                                <div class="row">
                                    <div class="col-lg-12 col-md-12  col-xs-12 col-sm-12 padding-5 bottom-border-verydark">
                                        <div class="alert alert-info clearfix profile-information padding-all-10 margin-all-0 backgroundDark">
                                            <h1 class="font-white text-center"> No Data Found ! </h1>
                                        </div>   
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
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

        <!-- END CONTAINER -->
        <!-- BEGIN FOOTER -->
        <?php include_once './footer.php'; ?>
        <!-- END FOOTER -->

        <!-- BEGIN CORE PLUGINS -->
        <?php include_once './footerjs.php'; ?>

        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <link rel="stylesheet" type="text/css" href="css/jquery.datetimepicker.min.css"/>
        <script src="js/jquery.datetimepicker.js"></script>

        <script type="text/javascript">
            function checkclose() {
                window.close();
            }

            function checkCallStatus()
            {
                var callStatus = $('#callStatus').val();
                if (callStatus == '1')
                {
                    var urlp = '<?php echo $web_url; ?>Employee/findDispositionName.php?ID=' + callStatus;
                    $.ajax({
                        type: 'POST',
                        url: urlp,
                        success: function (data) {
                            if (data == 0) {
                                $('#errordiv').html('');
                            } else {
                                $('#errordiv').html(data);
                                $('#subDisPos').show();
                                $('#LoginID').val('');
                            }
                        }
                    }).error(function () {
                        alert('An error occured');
                    });
                } else if (callStatus == '0') {
                    var urlp = '<?php echo $web_url; ?>Employee/findSubDispositionName.php?ID=' + callStatus;
                    $.ajax({
                        type: 'POST',
                        url: urlp,
                        success: function (data) {
                            if (data == 0) {
                                $('#errordiv').html('');
                            } else {
                                $('#errordiv').html(data);
                                $('#subDisPos').hide();
                                $('#LoginID').val('');
                            }
                        }
                    }).error(function () {
                        alert('An error occured');
                    });
                }
            }



            function checkSubDispos() {

                var id = $('#disposition_name').val();
                if (id == 12 || id == 21 || id == 25 || id == 30) {
                    if (id == 12) {

                        $(document).ready(function () {
                            var todayDate = new Date().getDate();
                            $('#PTPDate').datetimepicker({
                                format: 'd-m-Y H:i:s',
                                datepicker: true,
                                allowTimes: [
                                    '9:00', '10:00', '11:00',
                                    '12:00', '13:00', '14:00', '15:00',
                                    '16:00', '17:00', '18:00'
                                ],
                                minDate: new Date(), //yesterday is minimum date
                                maxDate: new Date(new Date().setDate(todayDate + 2)),
                                autoclose: true
                            }).attr('readonly', 'readonly');
                        });
                    } else {
                        $(document).ready(function () {
                            var todayDate = new Date().getDate();
                            $('#PTPDate').datetimepicker({
                                format: 'd-m-Y H:i:s',
                                datepicker: true,
                                allowTimes: [
                                    '9:00', '10:00', '11:00',
                                    '12:00', '13:00', '14:00', '15:00',
                                    '16:00', '17:00', '18:00'
                                ],
                                minDate: new Date(), //yesterday is minimum date
                                maxDate: new Date(new Date().setDate(todayDate + 3)),
                                autoclose: true
                            }).attr('readonly', 'readonly');
                        });
                    }
                }

                if (id == 13) {
                    $(document).ready(function () {
                        var todayDate = new Date().getDate();
                        $('#datetimepicker').datetimepicker({
                            format: 'd-m-Y H:i:s',
                            datepicker: true,
                            allowTimes: [
                                '9:00', '10:00', '11:00',
                                '12:00', '13:00', '14:00', '15:00',
                                '16:00', '17:00', '18:00'
                            ],
                            minDate: new Date(), //yesterday is minimum date
                            maxDate: new Date(new Date().setDate(todayDate + 3)),
                            autoclose: true
                        }).attr('readonly', 'readonly');
                    });
                } else {
                    $(document).ready(function () {
                        $('#datetimepicker').datetimepicker({
                            format: 'd-m-Y H:i:s',
                            datepicker: true,
                            allowTimes: [
                                '9:00', '10:00', '11:00',
                                '12:00', '13:00', '14:00', '15:00',
                                '16:00', '17:00', '18:00'
                            ],
                            autoclose: true
                        }).attr('readonly', 'readonly');
                    });
                }

                if (id == 12 || id == 21 || id == 25 || id == 30) {
                    $('#divPTPDate').show();
                    $('#PTPDate').attr('required', true);
                    $('#FollowUpDate').hide();
                    $('#Date').attr('required', false);
                } else if (id == 22) {
                    $('#divPTPDate').hide();
                    $('#PTPDate').attr('required', false);
                    $('#FollowUpDate').show();
                    $('#Date').attr('required', true);
                } else {
                    $('#FollowUpDate').show();
                    $('#Date').attr('required', false);
                    $('#divPTPDate').hide();
                    $('#PTPDate').attr('required', false);
                }
                var urlp = '<?php echo $web_url; ?>Employee/findSubDisposition.php?ID=' + id;
                $.ajax({
                    type: "POST",
                    url: urlp,
                    success: function (data) {
                        if (data != 0) {
                            $('#subCategoryId').html(data);
                        } else {
                            $('#subDisPos').hide();
                            $('#sub_disposition').attr('required', false);
                        }
                        if (id == 19 || id == 20 || id == 26) {
                            $('#FollowUpDate').hide();
                            $('#Date').attr('required', false);
                        }
                    }
                });
            }

            $('#frmparameter').submit(function (e) {
                e.preventDefault();
                var $form = $(this);
                $('#loading').css("display", "block");
                $.ajax({
                    type: 'POST',
                    url: 'querydata.php',
                    data: $('#frmparameter').serialize(),
                    success: function (response) {
                        if (response == 1) {
                            console.log(response);
                            $('#loading').css("display", "none");
                            alert("Added Successfully.");
                            window.close();
                        } else {
                            $('#loading').css("display", "none");
                            alert('Invalid Request.');
                            window.close();
                        }
                    }
                });
            });

        </script>   
    </body>
</html>