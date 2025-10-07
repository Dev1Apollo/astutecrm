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

        <title><?php echo $ProjectName; ?> | Closed Ticket </title>

        <?php include_once './include.php'; ?>
        <style type="text/css">
            /* The Modal (background) */
.modal {
  display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 1; /* Sit on top */
  padding-top: 100px; /* Location of the box */
  left: 0;
  top: 0;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  overflow: auto; /* Enable scroll if needed */
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
}

/* Modal Content */
.modal-content {
  position: relative;
  background-color: #fefefe;
  margin: auto;
  padding: 0;
  border: 1px solid #888;
  width: 80%;
  box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2),0 6px 20px 0 rgba(0,0,0,0.19);
  -webkit-animation-name: animatetop;
  -webkit-animation-duration: 0.4s;
  animation-name: animatetop;
  animation-duration: 0.4s
}
        </style>

    </head>

    <body class="page-container-bg-solid page-boxed">

        <?php include_once './header.php'; ?>

        <div style="display: none; z-index: 10060;" id="loading">

            <img id="loading-image" src="<?php echo $web_url;?>admin/images/loader1.gif">

        </div>

        <div class="page-container">        

            <div class="page-content-wrapper">

             

                <div class="page-content">

                    <div class="container">

                        <ul class="page-breadcrumb breadcrumb">

                            <li>

                                <a href="<?php echo $web_url;?>admin/index.php">Home</a>

                                <i class="fa fa-circle"></i>

                            </li>



                            <li>

                                <span>Closed Ticket</span>

                            </li>

                        </ul>



                                <div class="col-md-100%">

                                    <div class="portlet light ">

                                        <div class="portlet-title">

                                            <div class="caption font-red-sunglo">

                                                <i class="icon-settings font-red-sunglo"></i>
                                                <span class="caption-subject bold uppercase">List of Closed Ticket</span>
                                                <span class="caption-subject bold uppercase"></span>

                                            </div>

                                        </div>

                                        <div class="portlet-body form">

                                        <div class="portlet light ">
                                        <div class="f_tab_main">
                                            <div class="f_tab_link">
                                                <a href="pendingTicket.php" class="f_tab_link_active">Pending Ticket</a>
                                                <a href="closedticket.php">Closed Ticket</a>
                                            </div>
                                            <!-- <?=$_REQUEST['id'];?> -->
                                            <input type="hidden" value="" name="examId" id="examId">
                                            <div class="f_tab_content">
                                                    <div id="PlaceUsersDataHere"></div>

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

        </div>
   

        <?php include_once './footer.php'; ?>

 <link href="<?php echo $web_url;?>admin/assets\global\plugins\bootstrap-datetimepicker\css\bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css"/>
<script src="<?php echo $web_url;?>admin/assets\global\plugins\bootstrap-datetimepicker\js\bootstrap-datetimepicker.min.js"></script>

    <script type="text/javascript">
                $(document).ready(function () {
                    var date = new Date();
                    $("#examDateTime").datetimepicker({
                        format: "dd-mm-yyyy hh:ii",
                        autoclose: true,
                        todayHighlight: true,
                        startDate: date
                    });
                    $("#examEndDateTime").datetimepicker({
                        format: "dd-mm-yyyy hh:ii",
                        autoclose: true,
                        todayHighlight: true,
                        startDate: date
                    });
                });  

            function checkclose() {

                window.location.href = '';

            }
            function Endtime() {
                    var examDateTime = $('#examDateTime').val();
                    var examDuration = $('#examDuration').val();
                    var endDate = SetEndDate(examDateTime,examDuration);
                    
                    var examEndDateTime = $('#examEndDateTime').val();
                 /*   alert(endDate);
                    alert(examEndDateTime);*/
                    if(endDate >= examEndDateTime){
                        alert('Exam End Date Time should be Greater than or equal to Exam Duration Time');
                        $('#examEndDateTime').val('');
                        return true;
                    } else {
                        return false;
                    }
            }
                
            function SetEndDate(start_date,duration){ 

                var my_date_format  = function(start_date){
                    var d           = new Date(Date.parse(start_date.replace(/-/g, "/")));
                    var month       = ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12'];
                    var date        = d.getFullYear() + "-" + month[d.getMonth()] + "-" + d.getDate();
                    var time        = d.getHours()+":"+d.getMinutes();
                    var date_time   = date + " " + time;
                    return (date_time);  
                };

                var date_time   = my_date_format(start_date);
                    d2              = new Date ( date_time );
                    d2.setTime(d2.getTime() + (duration * 60 * 1000));

                var date_new    = new Date(d2);
                    yr              = date_new.getFullYear();
                    month           = date_new.getMonth() < 10 ? '0' + (date_new.getMonth() + 1)  : (date_new.getMonth() + 1);
                    day             = date_new.getDate()  < 10 ? '0' + date_new.getDate()  : date_new.getDate();
                    minutes         = date_new.getMinutes()  < 10 ? '0' + date_new.getMinutes()  : date_new.getMinutes();
                    hours           = date_new.getHours()  < 10 ? '0' + date_new.getHours()  : date_new.getHours();
                    time            = hours + ":" + minutes;
                    return newDate         =  month + '-' + day + '-'  +  yr + ' ' + time;
                
            }

            function mark() {

                var Status = true;
                var TotalMarks = $('#TotalMarks').val() * 1;
                var PassingMarks = $('#PassingMarks').val() * 1;
                
                if (TotalMarks < PassingMarks) {
                    alert( 'Passing Marks enter should be less than Total Marks' );
                    return false;
                } else {
                    return true;
                }
            }
             $('#frmPublishExam').submit(function (e) {
                e.preventDefault();
                
                
                if(mark()){
                    $('#loading').css("display", "block");
                    $.ajax({
                        type: 'POST',
                        url: '<?php echo $web_url; ?>admin/querydata.php',
                        data: $('#frmPublishExam').serialize(),
                        success: function (response) {
                            console.log(response);
                         
                         if (response == 1) {
                            $('#loading').css("display", "none");
                            $("#Btnmybtn").attr('disabled', 'disabled');
                            alert('Publish Exam Sucessfully.');
                            window.location.href = '<?php echo $web_url; ?>admin/Exam.php';


                            }else {

                                $('#loading').css("display", "none");
                                $("#Btnmybtn").attr('disabled', 'disabled');
                                alert('Invalid Request.');
                                window.location.href = '';
                            }  
                        }
                    });
                }
            });

            $('#frmexam').submit(function (e) {

                e.preventDefault();
                
                $('#loading').css("display", "block");

                $.ajax({

                    type: 'POST',

                    url: '<?php echo $web_url;?>admin/querydata.php',

                    data: $('#frmexam').serialize(),

                    success: function (response) {

                        console.log(response);
                        
                        //$("#Btnmybtn").attr('disabled', 'disabled');

                        if (response == 1) {

                            $('#loading').css("display", "none");

                            $("#Btnmybtn").attr('disabled', 'disabled');

                            alert('Added Exam Sucessfully.');

                            window.location.href = '';

                        } else if (response == 2) {

                            $('#loading').css("display", "none");

                            $("#Btnmybtn").attr('disabled', 'disabled');

                            alert('Edited Exam Sucessfully.');

                            window.location.href = '';

                        } else {

                            $('#loading').css("display", "none");

                            $("#Btnmybtn").attr('disabled', 'disabled');

                            alert('Invalid Request.');

                            window.location.href = '';

                        }

                    }

                });
                return false;

            });

            

            function publishdta(examId,TotalMarks){
                $('#examId').val(examId);
                $('#TotalMarks').val(TotalMarks);
                var modal = document.getElementById("myModal");
                 modal.style.display = "block";
            }
            function setEditdata(id)

            {

                $('#errorDIV').css('display', 'none');

                $('#errorDIV').html('');

                $('#loading').css("display", "block");

                $.ajax({

                    type: 'POST',

                    url: '<?php echo $web_url;?>admin/querydata.php',

                    data: {action: "GetAdminExammaster", ID: id},

                    success: function (response) {

                        document.getElementById("FAQ").innerHTML = "EDIT Exam";

                        $('#loading').css("display", "none");

                        var json = JSON.parse(response);

                        $('#examTitle').val(json.examTitle);

                        $('#action').val('EditExam');

                        $('<input>').attr('type', 'hidden').attr('name', 'examId').attr('value', json.examId).attr('id', 'examId').appendTo('#frmexam');

                    }

                });

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

                        url: "<?php echo $web_url;?>admin/AjaxExam.php",

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

                

                $('#loading').css("display", "block");

                $.ajax({

                    type: "POST",

                    url: "<?php echo $web_url;?>admin/Ajaxclosedticket.php",

                    data: {action: 'ListUser',Page:Page,},

                    success: function (msg) {

                        $("#PlaceUsersDataHere").html(msg);

                        $('#loading').css("display", "none");

                    },

                });

            }// end of filter

            PageLoadData(1);





        </script>

    </body>

</html>