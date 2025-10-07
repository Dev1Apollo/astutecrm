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
        <meta charset="utf-8">
        <link rel="shortcut icon" href="images/favicon.png">
        <title> <?php echo $ProjectName ?> |Upload Excel</title>
        <?php include_once './include.php'; ?>     
        <link href="assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker.css" rel="stylesheet" type="text/css" />
    </head> 
    <body class="page-container-bg-solid page-boxed">
        <?php
        include('header.php');
        ?>
        <div style="display: none; z-index: 10060;" id="loading">
            <img id="loading-image" src="<?php echo $web_url; ?>admin/images/loader1.gif">
        </div>
        <div class="page-container">        
            <div class="page-content-wrapper">
                <div class="page-content">
                    <div class="container">                    
                        <ul class="page-breadcrumb breadcrumb">
                            <li>
                                <a href="index.php">Home</a>
                                <i class="fa fa-circle"></i>
                            </li>
                            <li>
                                <span>Add Employee Attendance </span>
                            </li>
                        </ul>
                        <div class="page-content-inner">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="portlet light ">
                                        <div class="portlet-title">
                                            <div class="caption font-red-sunglo">
                                                <i class="icon-settings font-red-sunglo"></i>
                                                <span class="caption-subject bold uppercase"> Employee Attendance </span>
                                            </div>
<!--                                            <a href="upload_Employee_Attendance_Performance.php" class="btn green pull-right margin-bottom-20" style="margin-left:10px;" title="Employee Performance"><i class="fa fa-upload"></i></a>-->
                                            <a href="upload_Employee_Performance.php" class="btn blue pull-right margin-bottom-20" style="margin-left:10px;" title="Employee Attendance"><i class="fa fa-upload"></i></a>

                                        </div>
                                        <form role="form" method="POST" action="" name="frmparameter" id="frmparameter" enctype="multipart/form-data">
                                            <div class="form-body">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group col-md-3">
                                                            <label for="form_control_1">Performance Month</label>
                                                            <select name="Date" id="Date" class="form-control date-picker"> 
                                                                <option value="">Select Month</option>
                                                                <?php
                                                                $filterPerformance = mysqli_query($dbconn, "select * from employeeperformance GROUP by DATE_FORMAT(STR_TO_DATE(date,'%d-%M-%Y'), '%b-%y') ORDER BY STR_TO_DATE(date,'%d-%M-%Y') DESC limit 3");
                                                                while ($row = mysqli_fetch_array($filterPerformance)) {
                                                                    $monthYear = date('M-y', strtotime($row['date']));
                                                                    ?>
                                                                    <option value="<?php echo $row['date']; ?>" ><?php echo $monthYear; ?></option>    
                                                                    <?php
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
<!--                                                        <div class="form-group col-md-3">
                                                            <label for="form_control_1">To Date</label>
                                                            <input name="toDate" id="toDate" class="form-control date-picker" placeholder="Enter Your To Date" type="text">
                                                        </div>-->
                                                        <div class="form-group col-md-3">
                                                            <a href="#" class="btn blue margin-top-20" onclick="PageLoadData(1);">Search</a>
                                                            <button type="reset" class="btn blue margin-top-20" onclick="return checkClear();">Clear</button>
                                                        </div>
                                                    </div>
                                                </div>
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
        <?php include_once './footer.php'; ?>
        <script src="assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js" type="text/javascript"></script>
        <script type="text/javascript">
                                                                function checkClear() {
                                                                    window.location.href = '';
                                                                }
                                                                $(document).ready(function () {
//                                                                    $('#fromDate').datepicker({
//                                                                        format: 'dd-MM-yyyy',
//                                                                        autoclose: true,
//                                                                        todayHighlight: true,
//                                                                        defaultDate: "now",
//                                                                        endDate: "now"
//                                                                    });
//                                                                    $('#toDate').datepicker({
//                                                                        format: 'dd-MM-yyyy',
//                                                                        autoclose: true,
//                                                                        todayHighlight: true,
//                                                                        defaultDate: "now",
//                                                                        endDate: "now"
//                                                                    });
                                                                });

                                                                function PageLoadData(Page) {
                                                                    var Date = $('#Date').val();
//                                                                    var toDate = $('#toDate').val();
                                                                    $('#loading').css("display", "block");
                                                                    $.ajax({
                                                                        type: "POST",
                                                                        url: "<?php echo $web_url; ?>admin/AjaxPerformance.php",
                                                                        data: {action: 'ListUser', Page: Page, Date: Date},
                                                                        success: function (msg) {
                                                                            $("#PlaceUsersDataHere").html(msg);
                                                                            $('#loading').css("display", "none");
                                                                        }
                                                                    });
                                                                }// end of filter
                                                                //        PageLoadData(1);

        </script>
    </body>
</html>