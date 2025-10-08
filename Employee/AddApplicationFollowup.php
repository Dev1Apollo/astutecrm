<?php
ob_start();
error_reporting(E_ALL);
include_once '../common.php';
$connect = new connect();
include('IsLogin.php');
//headers("cache-control : no-cache" );
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title><?php echo $ProjectName; ?> | Application FollowUp</title>
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
                                <span> Application FollowUp </span>
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
                                <span class="caption-subject bold uppercase">Application FollowUp</span>
                            </div>
                        </div>
                        <div class="portlet-body form">
                            <?php
                            $rowfilter = mysqli_fetch_array(mysqli_query($dbconn, "SELECT applicatipnNo,customerName,customerCity,customerZipcode,EMIAmount,customerMobile FROM `application`  where iAppId='" . $_REQUEST['token'] . "'"));
                            ?>
                            <div class="row">
                                <div class="col-md-12">
                                    <h4 class="bold text-center">Customer Details</h4>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <h6><span class="bold">Loan Application No:</span>&nbsp;<?php echo $rowfilter['applicatipnNo']; ?></h6>
                                        </div>
                                        <div class="col-md-3">
                                            <h6><span class="bold">Customer Name:</span>&nbsp;<?php echo $rowfilter['customerName']; ?>  </h6>
                                        </div>
                                        <div class="col-md-3">
                                            <h6><span class="bold">Customer Mobile:</span>&nbsp;<?php echo $rowfilter['customerMobile']; ?>  </h6>
                                        </div>
                                        <div class="col-md-3">
                                            <h6><span class="bold">EMI Amount:</span>&nbsp;<?php echo $rowfilter['EMIAmount']; ?></h6>
                                        </div>
                                        <!--<div class="col-md-3">-->
                                        <!--    <h6><span class="bold">Customer City:</span>&nbsp;<?php echo $rowfilter['customerCity']; ?></h6>-->
                                        <!--</div>-->
                                        <!--<div class="col-md-3">-->
                                        <!--    <h6><span class="bold">Customer Zip Code :</span>&nbsp;<?php echo $rowfilter['customerZipcode']; ?></h6>-->
                                        <!--</div>-->
                                    </div>
                                    <!--<div class="row">-->
                                        <!--<div class="col-md-3">
                                            <h6><span class="bold">EMI Amount:</span>&nbsp;<?php echo $rowfilter['EMIAmount']; ?></h6>
                                        </div>-->
                                        <!--<form role="form"  method="POST"  action="" name="frmFeedback"  id="frmFeedback" enctype="multipart/form-data">
                                            <input type="hidden" value="AddFeedBack" name="action" id="action">
                                            <input type="hidden" value="<?php echo $_REQUEST['token'] ?>" name="iAppId" id="iAppId">
                                            <input type="hidden" value="<?php echo $rowfilter['applicatipnNo']; ?>" name="applicatipnNo" id="applicatipnNo">
                                            <div class="form-group col-md-6 row">
                                                <h6><span class="bold col-md-4">Add Feedback: </span></h6>
                                                <div class="col-md-8">
                                                    <select class="form-control" name="Feedback" id="Feedback" required="">
                                                        <option value="">Select Feedback</option>
                                                        <?php
                                                        $filteragentFeedback = mysqli_fetch_array(mysqli_query($dbconn, "SELECT * FROM `customerfeedback` where applicatipnNo='".$rowfilter['applicatipnNo']."'"));
                                                        $filterstrFeedback = mysqli_query($dbconn, "SELECT strfeedbackName,iFeedbackId FROM `feedback` where isDelete=0");
                                                        while ($rowfeedback = mysqli_fetch_array($filterstrFeedback)) {
                                                            if($filteragentFeedback['iFeedbackId'] == $rowfeedback['iFeedbackId']){
                                                            ?>
                                                        <option value="<?php echo $rowfeedback['iFeedbackId'] ?>" selected="selected"><?php echo $rowfeedback['strfeedbackName'] ?></option>
                                                        <?php }else{ ?>
                                                            <option value="<?php echo $rowfeedback['iFeedbackId'] ?>"><?php echo $rowfeedback['strfeedbackName'] ?></option>
                                                        <?php }} ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                
                                                <button class="btn blue margin-top-10" type="button" onclick="addFeedbackData();" id="Btnmyfeedback" name="Btnmyfeedback">Save</button>
                                                
                                            </div>
                                        </form> -->
                                    <!--</div>-->
                                </div>
                            </div>
                            <hr />
                            <form  role="form"  method="POST"  action="" name="frmparameter"  id="frmparameter" enctype="multipart/form-data">
                                <input type="hidden" value="AddApplicationFollowUp" name="action" id="action">
                                <input type="hidden" value="<?php echo $_REQUEST['token'] ?>" name="iAppId" id="iAppId">
                                <input type="hidden" value="<?php echo $rowfilter['applicatipnNo']; ?>" name="applicatipnNo" id="applicatipnNo">
                                <div class="form-body">
                                    <div class="form-group col-md-3">
                                        <label for="form_control_1">Call Status*</label>
                                        <select class="form-control" name="callStatus" id="callStatus" required="" onchange="checkCallStatus();">
                                            <!--                                            <option value="">Select Call Status</option>-->
                                            <option value="1">Connect</option>
                                            <option value="0">Not Contact</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="form_control_1">Disposition Name*</label>
                                        <div id="errordiv">
                                            <select name="disposition_name" class="form-control" id="disposition_name" required="" onchange="checkSubDispos();">
                                                <option value="">Select Disposition Name</option>
                                                <?php
                                                $filterDisPosition = mysqli_query($dbconn, "SELECT iDispoId,dispoDesc FROM `dispositionmaster` where dispoType=1 and masterDispoId=0");
                                                while ($rowDispostion = mysqli_fetch_array($filterDisPosition)) {
                                                    ?>
                                                    <option value="<?php echo $rowDispostion['iDispoId']; ?>"><?php echo $rowDispostion['dispoDesc']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group col-md-3" id="subDisPos">
                                        <label for="form_control_1">Sub Disposition Name*</label>
                                        <div id="subCategoryId">
                                            <select name="sub_disposition" id="sub_disposition" required="" class="form-control">
                                                <option value="">Select Sub Disposition Name</option>
                                                <?php
//                                                $filterSubDisPosition = mysqli_query($dbconn, "SELECT iDispoId,dispoDesc FROM `dispositionmaster` where masterDispoId!=0");
//                                                while ($rowSubDispostion = mysqli_fetch_array($filterSubDisPosition)) {
                                                ?>
                                                    <!--<option value="<?php // echo $rowSubDispostion['iDispoId'];       ?>"><?php // echo $rowSubDispostion['dispoDesc'];       ?></option>-->
                                                <?php // } ?>
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group col-md-3" id="FollowUpDate">
                                        <label for="form_control_1">Next Follow Up Date</label>
                                        <input type="text" id="datetimepicker" name="Date" class="form-control date-set" placeholder="Enter The Next Follow Up Date"/>
                                    </div>
                                    <div class="form-group col-md-3" style="display: none;" id="divPTPDate">
                                        <label for="form_control_1">PTP Date*</label>
                                        <input type="text" id="PTPDate" name="PTPDate" class="form-control date-set" placeholder="Enter The PTP Date"/>
                                    </div>
                                    <div class="form-group col-md-3" style="display:none" id="PTPAmount">
                                        <label for="form_control_1">PTP Amount*</label>
                                        <input type="text" id="PTP_Amount" name="PTP_Amount" class="form-control date-set" oninput="this.value = this.value.replace(/[^0-9.]/g, '')" placeholder="Enter The PTP Amount"/>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="form_control_1">Comment*</label>
                                        <textarea name="comment" id="comment" class="form-control" required=""></textarea>
                                    </div>
                                </div>
                                <div class="form-actions noborder">
                                    <input class="btn blue margin-top-20" type="submit" id="Btnmybtn"  value="Submit" name="submit">      
                                    <button type="button" class="btn blue margin-top-20" onClick="checkclose();">Cancel</button>
                                </div>
                            </form>
                        </div>
                        <div class="portlet light ">
                            <div class="portlet-title">
                                <div class="caption grey-gallery">
                                    <i class="icon-settings grey-gallery"></i>
                                    <span class="caption-subject bold uppercase">List Of Application Followup Details</span>
                                </div>
                            </div>
                            <div class="portlet-body">
                                <?php
                                $rowfilter['applicatipnNo'];
                                $date = date('1-m-Y');
                                $startDate = date('1-m-Y', strtotime('-1 months', strtotime($date)));

                                $filterstr = "SELECT iAppId,iEmpId,followupDate,mainDispoId,subDispoId,remark,strEntryDate,PTP_Amount,PTPDate FROM `applicationfollowup`  where applicatipnNo='" . $rowfilter['applicatipnNo'] . "' and STR_TO_DATE(strEntryDate,'%d-%m-%Y') >= STR_TO_DATE('" . $startDate . "','%d-%m-%Y') and STR_TO_DATE(strEntryDate,'%d-%m-%Y')<= CURRENT_DATE() order by  iAppLogId desc";
                                $resultfilter = mysqli_query($dbconn, $filterstr);
                                if (mysqli_num_rows($resultfilter) > 0) {
                                    $i = 1;
                                    ?>
                                    <table class="table table-bordered table-hover center table-responsive" width="100%" id="tableC">
                                        <thead class="tbg">
                                            <tr>
                                                <th class="pop_in_heading">Customer Name</th>
                                                <th class="pop_in_heading">Employee Name</th>
                                                <th class="pop_in_heading">Followup Date / PTP Date</th>
                                                <th class="pop_in_heading">Disposition</th>
                                                <th class="pop_in_heading">Sub Disposition</th>
                                                <th class="pop_in_heading">PTP Amount</th>
                                                <th class="pop_in_heading">Comment</th>
                                                <th class="pop_in_heading">Entry Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            while ($rowfilterLF = mysqli_fetch_array($resultfilter)) {
                                                $customerentry = "SELECT customerName FROM `application`  where isDelete='0'  and  istatus='1' and  iAppId='" . $rowfilterLF['iAppId'] . "'";
                                                $resultCustomer = mysqli_query($dbconn, $customerentry);
                                                $rowCustomer = mysqli_fetch_array($resultCustomer);
                                                ?>
                                                <tr>
                                                    <td>
                                                        <div class="form-group form-md-line-input "><?php
                                                            echo $rowCustomer['customerName'];
                                                            ?> 
                                                        </div>
                                                    </td> 
                                                    <td>
                                                        <div class="form-group form-md-line-input "><?php
                                                            $filterEmployee = mysqli_fetch_array(mysqli_query($dbconn, "SELECT empname FROM `employee` where employeeid='" . $rowfilterLF['iEmpId'] . "'"));
                                                            echo $filterEmployee['empname'];
                                                            ?> 
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-group form-md-line-input "><?php 
                                                        if(isset($rowfilterLF['followupDate']) && $rowfilterLF['followupDate'] != ""){
                                                            echo $rowfilterLF['followupDate'];
                                                        } else if (isset($rowfilterLF['PTPDate']) && $rowfilterLF['PTPDate'] != ""){
                                                            echo $rowfilterLF['PTPDate'];
                                                        } else {
                                                            echo "";
                                                        }
                                                        ?> 
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-group form-md-line-input "><?php
                                                            $filterMainDispo = mysqli_fetch_array(mysqli_query($dbconn, "SELECT dispoDesc FROM `dispositionmaster` where masterDispoId='0' and iDispoId='" . $rowfilterLF['mainDispoId'] . "'"));
                                                            echo $filterMainDispo['dispoDesc'];
                                                            ?> 
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-group form-md-line-input "><?php
                                                            $filterSubDispo = mysqli_fetch_array(mysqli_query($dbconn, "SELECT dispoDesc FROM `dispositionmaster` where masterDispoId!='0' and iDispoId='" . $rowfilterLF['subDispoId'] . "'"));
                                                            echo $filterSubDispo['dispoDesc'];
                                                            ?> 
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-group form-md-line-input "><?php echo $rowfilterLF['PTP_Amount']; ?> 
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-group form-md-line-input "><?php echo $rowfilterLF['remark']; ?> 
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-group form-md-line-input "><?php echo $rowfilterLF['strEntryDate']; ?> 
                                                        </div>
                                                    </td>
                                                </tr>
                                                <?php
                                            }
                                            ?>
                                        </tbody>
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

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<link rel="stylesheet" type="text/css" href="css/jquery.datetimepicker.min.css"/>
<script src="js/jquery.datetimepicker.js"></script>

<script type="text/javascript">
                                        function checkclose() {
                                            // window.close();
                                            window.location.href = "<?php echo $web_url; ?>Employee/AgentCRM.php";
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
                                                     fetchLastPTPDate();
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
                                                            // minDate: new Date(), //yesterday is minimum date
                                                            // maxDate: new Date(new Date().setDate(todayDate + 2)),
                                                            autoclose: true
                                                        }).attr('required', true)
                                                        // .attr('readonly', 'readonly');
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
                                                            // minDate: new Date(), //yesterday is minimum date
                                                            // maxDate: new Date(new Date().setDate(todayDate + 3)),
                                                            autoclose: true
                                                        }).attr('required', false);
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
                                                        // minDate: new Date(), //yesterday is minimum date
                                                        // maxDate: new Date(new Date().setDate(todayDate + 3)),
                                                        autoclose: true
                                                    }).attr('readonly', 'readonly');
                                                });
                                                $("#PTPAmount").hide();
                                                $("#PTP_Amount").attr('required', false);
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
                                                $("#PTPAmount").hide();
                                                $("#PTP_Amount").attr('required', false);
                                            }

                                            if (id == 12 || id == 21 || id == 25 || id == 30) {
                                                
                                                
                                                if(id==12){
                                                    $("#PTPAmount").show();
                                                    $("#PTP_Amount").attr('required', true);
                                                    
                                                    $('#divPTPDate').show();
                                                    $('#PTPDate').attr('required', true);
                                                    
                                                    $('#FollowUpDate').hide();
                                                    $('#Date').attr('required', false);
                                                } else {
                                                    $("#PTPAmount").hide();
                                                    $("#PTP_Amount").attr('required', false);
                                                    
                                                    $('#divPTPDate').show();
                                                    $('#PTPDate').attr('required', false);
                                                    
                                                    $('#FollowUpDate').hide();
                                                    $('#Date').attr('required', true);
                                                }
                                            } else if (id == 22) {
                                                $('#divPTPDate').hide();
                                                $('#PTPDate').attr('required', false);
                                                $('#FollowUpDate').show();
                                                $('#Date').attr('required', true);
                                                $("#PTPAmount").hide();
                                                $("#PTP_Amount").attr('required', false);
                                            } else {
                                                $('#FollowUpDate').show();
                                                $('#Date').attr('required', false);
                                                $('#divPTPDate').hide();
                                                $('#PTPDate').attr('required', false);
                                                $("#PTPAmount").hide();
                                                $("#PTP_Amount").attr('required', false);
                                            }
                                            var urlp = '<?php echo $web_url; ?>Employee/findSubDisposition.php?ID=' + id;
                                            $.ajax({
                                                type: "POST",
                                                url: urlp,
                                                success: function (data) {
                                                    if (data != 0) {
                                                        $('#subCategoryId').html(data);
                                                        $('#subDisPos').show();
                                                        console.log(data)    
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
                                                        window.location.href = "<?php echo $web_url; ?>Employee/AgentCRM.php";
                                                    } else {
                                                        $('#loading').css("display", "none");
                                                        alert('Invalid Request.');
                                                        window.location.href = "<?php echo $web_url; ?>Employee/AgentCRM.php";
                                                    }
                                                }
                                            });
                                        });
                                        
                                        function addFeedbackData(){
                                            var applicatipnNo = $('#applicatipnNo').val();
                                            var Feedback = $('#Feedback').val();
                                            var iAppId = $('#iAppId').val();
                                            $('#loading').css("display", "block");
                                            $.ajax({
                                                type: 'POST',
                                                url: 'querydata.php',
                                                data: {action : 'AddFeedBack', applicatipnNo: applicatipnNo, Feedback: Feedback,iAppId: iAppId},
                                                success: function (response) {
                                                    if (response == 1) {
                                                        console.log(response);
                                                        $('#loading').css("display", "none");
                                                        alert("Added Successfully.");
                                                    } else {
                                                        $('#loading').css("display", "none");
                                                        alert('Invalid Request.');
                                                    }
                                                }
                                            });
                                        };
                                        
                                        
                                        function fetchLastPTPDate() {
                                            var applicatipnNo = '<?php echo $rowfilter['applicatipnNo']; ?>';
                                            
                                            console.log('Fetching PTP data for:', applicatipnNo);
                                            
                                            $.ajax({
                                                type: 'POST',
                                                url: 'querydata.php',
                                                data: {
                                                    action: 'getLastPTPDate',
                                                    applicatipnNo: applicatipnNo
                                                },
                                                dataType: 'json', // Expect JSON response
                                                success: function(data) {
                                                    console.log('Response received:', data);
                                                    
                                                    if (data && data.success) {
                                                        // Auto-fill PTP date and amount from last record
                                                        if (data.ptpDate) {
                                                            $('#PTPDate').val(data.ptpDate);
                                                        }
                                                        if (data.ptpAmount) {
                                                            $('#PTP_Amount').val(data.ptpAmount);
                                                        }
                                                        
                                                        console.log('PTP data loaded successfully');
                                                    } else {
                                                        // Clear fields if no previous PTP record found
                                                        $('#PTPDate').val('');
                                                        $('#PTP_Amount').val('');
                                                        console.log('No previous PTP record found or invalid response');
                                                    }
                                                },
                                                error: function(xhr, status, error) {
                                                    console.log('AJAX Error:', status, error);
                                                    console.log('Response text:', xhr.responseText);
                                                    
                                                    // Try to parse as JSON anyway
                                                    try {
                                                        var data = JSON.parse(xhr.responseText);
                                                        if (data && data.success) {
                                                            $('#PTPDate').val(data.ptpDate);
                                                            //$('#PTP_Amount').val(data.ptpAmount);
                                                        }
                                                    } catch (e) {
                                                        console.log('Failed to parse error response');
                                                        // Clear fields on error
                                                        $('#PTPDate').val('');
                                                        //$('#PTP_Amount').val('');
                                                    }
                                                }
                                            });
                                        }
</script>   
</body>
</html>