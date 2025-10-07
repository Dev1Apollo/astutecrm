

<?php
   ob_start();
   include_once '../common.php';
   $connect = new connect();
   include('IsLogin.php');
   ?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8" />
      <title><?php echo $ProjectName; ?> | Exam </title>
      <?php include_once './include.php'; ?>
      <link href="<?php echo $web_url; ?>Employee/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker.css" rel="stylesheet" type="text/css" />
      <link href="<?php echo $web_url; ?>Employee/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.css" rel="stylesheet" type="text/css" />
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
                     <li>
                        <a href="index.php">Home</a>
                        <i class="fa fa-circle"></i>
                     </li>
                     <li>
                        <span>Exam </span>
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
               <div class="portlet light " style="" id="SLID">
                  <div class="portlet-body form">
                     <div class="row">
                        <div class="row">
                           <div class="col-md-4">
                              <div class="portlet light ">
                                 <div class="portlet-title">
                                    <div class="caption font-red-sunglo">
                                       <i class="icon-settings font-red-sunglo"></i>
                                       <span class="caption-subject bold uppercase" id="FAQ">Add Exam</span>
                                    </div>
                                 </div>
                                 <div class="portlet-body form">
                                    <form  role="form"  method="POST"  action="" name="frmexam"  id="frmexam" enctype="multipart/form-data">
                                       <input type="hidden" value="AddExam" name="action" id="action">
                                       <div class="form-body">
                                          <div class="row">
                                             <div class="style-msg  errormsg col_half">
                                                <div class="alert alert-success" id="errorDIV" style="display: none;"></div>
                                             </div>
                                             <div class="col_half col_last">
                                             </div>
                                          </div>
                                          <div class="form-group">
                                             <label for="form_control_1">Exam Title</label>
                                             <input name="examTitle" id="examTitle"  class="form-control" placeholder="Enter Exam Title" required="" type="text">
                                          </div>
                                       </div>
                                       <div class="form-actions noborder">
                                          <input class="btn blue margin-top-20" type="submit" id="Btnmybtn"  value="Submit" name="submit">      
                                          <button type="button" class="btn blue margin-top-20" onClick="checkclose();">Cancel</button>
                                       </div>
                                    </form>
                                 </div>
                              </div>
                           </div>
                           <div class="col-md-8">
                              <div class="portlet light ">
                                 <div class="portlet-title">
                                    <div class="caption font-red-sunglo">
                                       <i class="icon-settings font-red-sunglo"></i>
                                       <span class="caption-subject bold uppercase">List of Exam Master</span>
                                    </div>
                                 </div>
                                 <div class="portlet-body form">
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
       <div id="myModal" class="modal">              
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                           <h5 class="modal-title" id="Course">Publish Exam</h5>
                           <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                           <span aria-hidden="true">&times;</span>
                           </button>
                        </div>
                        <form id="frmPublishExam" name="frmPublishExam" method="post" enctype="multipart/form-data">
                           <div class="modal-body">
                              <input type="hidden" value="AddPublish" name="action" id="action">
                            <input type="hidden" value="0" name="examId" id="examId">
                            <input type="hidden" name="TotalMarks" id="TotalMarks">          
                              <div class="row">

                              <div class="form-group col-md-4">
                                 <label for="form_control_1" class="form-control-label">Exam Start Date & Time</label>
                                 <input name="examDateTime" id="examDateTime"  class="form-control" placeholder="Exam star date and time" type="text" required="">
                              </div>

                              <div class="form-group col-md-4">
                                 <label for="form_control_1" class="form-control-label">Exam Duration Time in Minute</label>
                                 <input name="examDuration" id="examDuration"  class="form-control" placeholder="Exam Duration Time" type="text" required="">
                              </div>

                              <div class="form-group col-md-4">
                                 <label for="form_control_1" class="form-control-label">Exam End Date & Time</label>
                                 <input name="examEndDateTime" id="examEndDateTime" onchange="Endtime();" class="form-control" placeholder="Exam End date and time" type="text" required="">
                              </div>
                              <div class="form-group col-md-4">
                                 <label for="form_control_1" class="form-control-label">Exam Passing Marks</label>
                                 <input name="PassingMarks" id="PassingMarks" min="0.01"  class="form-control" placeholder="Enter Passing Marks" type="text" required="">
                              </div>

                              </div>

                           </div>
                           <div class="modal-footer">
                              <button type="submit" name="submit" id="submit"  class="btn btn-primary">Submit</button>
                              
                              <button type="button" class="btn btn-danger" data-dismiss="modal" onclick="checkclose();">Close</button>
                           </div>
                        </form>
                    </div>
                </div>
        </div>
      </div>
      <a href="javascript:;" class="page-quick-sidebar-toggler">
      <i class="icon-login"></i>
      </a>
      </div>
      <?php include_once './footer.php'; ?>
      </div>
      <?php include_once './footerjs.php'; ?>
      <script src="<?php echo $web_url; ?>Employee/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js" type="text/javascript"></script>
      <link href="<?php echo $web_url;?>Employee/assets\global\plugins\bootstrap-datetimepicker\css\bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css"/>
      <script src="<?php echo $web_url;?>Employee/assets\global\plugins\bootstrap-datetimepicker\js\bootstrap-datetimepicker.min.js"></script>
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
                    var tStatus = SetEndDate(examDateTime,examDuration);
                    //alert (endDate);
                    var examEndDateTime = $('#examEndDateTime').val();
                    
                    // alert(examEndDateTime);
                    if(tStatus == false){
                        alert('Exam End Date Time should be Greater than or equal to Exam Duration Time');
                        $('#examEndDateTime').val('');
                        return true;
                    } else {
                        return false;
                    }
            }
            function toValidDate(datestring){
    return datestring.replace(/(\d{2})(\/)(\d{2})/, "$3$2$1");   
}
function ConvrtToDateManual(dateobj)
{
    var arrDateFrom = dateobj.split(" ");
                var arrFromDate = arrDateFrom[0].split("-");
                var arrFromTime = arrDateFrom[1].split(":");
                return new Date(arrFromDate[2], arrFromDate[1]-1, arrFromDate[0], arrFromTime[0], arrFromTime[1], 0, 0);
}
            function SetEndDate(start_date,duration){ // start_date = "05-25-2017 05:00"
                //var duration = 30;
                //M/d/yyyy h: mm tt.
                var startDateTime =ConvrtToDateManual(start_date);
                startDateTime.setMinutes( startDateTime.getMinutes() * 1 + duration * 1);
               //alert(startDateTime);
                var EndDateOfExam = $('#examEndDateTime').val();
                var EndDateOfExam = ConvrtToDateManual(EndDateOfExam);
              //alert(EndDateOfExam);
              if(startDateTime.getTime() <= EndDateOfExam.getTime())
              {
                return true;
              }
              else
              {
               return false;
              }

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
                 url: '<?php echo $web_url; ?>Employee/querydata.php',
                 data: $('#frmPublishExam').serialize(),
                 success: function (response) {
                     console.log(response);
                  
                  if (response == 1) {
                     $('#loading').css("display", "none");
                     $("#Btnmybtn").attr('disabled', 'disabled');
                     alert('Publish Exam Sucessfully.');
                     window.location.href = '<?php echo $web_url; ?>Employee/CreateExam.php';
         
         
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
         
             url: '<?php echo $web_url;?>Employee/querydata.php',
         
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
         
             url: '<?php echo $web_url;?>Employee/querydata.php',
         
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
         
                 url: "<?php echo $web_url;?>Employee/AjaxCreateExam.php",
         
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
         
             url: "<?php echo $web_url;?>Employee/AjaxCreateExam.php",
         
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

