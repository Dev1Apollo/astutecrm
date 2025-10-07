<?php
   ob_start();
   error_reporting(E_ALL);
   include_once '../common.php';
   $connect = new connect();
   include('IsLogin.php');
   
   $filterstr = "select examTitle,(select count(*) from questionanswer q where  q.examId=e.examId and isDelete='0' and istatus='1') as TotalQuestion,(Select Sum(questionMarks) from questionanswer q1 where q1.examId=e.examId and isDelete='0' and istatus='1' )as TotalMarks from exammaster e where  e.examId='".$_REQUEST['id']."' and e.isDelete='0'";
        $resultfilter = mysqli_query($dbconn, $filterstr);
        $rowfilter = mysqli_fetch_array($resultfilter);
   ?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8" />
      <title><?php echo $ProjectName; ?> |Upload Question Answer</title>
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
                        <a href="CreateExam.php">Create Exam</a>
                        <i class="fa fa-circle"></i>
                     </li>
                     <li>
                        <span>Upload Question Answer</span>
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
                  <!--                         <div class="portlet-title">
                     <div class="caption font-red-sunglo">
                         <span class="caption-subject bold uppercase">Create Exam</span>
                     </div>
                     </div>
                     -->                        
                  <div class="portlet-body form">
                      <div class="row">

                                <div class="col-md-6">

                                    <div class="portlet light ">
                                        <div class="f_tab_main">
                                 
                                 <input type="hidden" name="examId" id="examId" value="<?php echo $_REQUEST['id']; ?>">
                                 <div class="f_tab_content">
                                    <!-- <div id="PlaceUsersDataHere">
                                       </div> -->
                                    <form  role="form"  method="POST"  action="" name="frmuploadExcel"  id="frmuploadExcel" enctype="multipart/form-data" class="margin-bottom-40">
                                       <input type="hidden" value="UploadQuestionAnswerExcel" name="action" id="action">
                                       <input type="hidden" value="<?=$_REQUEST['id'];?>" name="examId" id="examId">
                                       <div class="form-body">
                                          <div class="row">
                                             <div class="form-group form-md-line-input has-warning col-md-12">
                                                <div>
                                                   <div class="form-group">
                                                      <label for="exampleInputFile1">Exam Question and Answer Excel file</label><br />
                                                      <input type="file"  id="gallery" name="gallery" class="btn red" required=""/>
                                                      <input type="hidden" name="galeryID" ID="galeryID" />
                                                   </div>
                                                   <div id="ImageGallery" style="display:none;">  </div>
                                                </div>
                                             </div>
                                             <div class="form-group form-md-line-input col-md-12">
                                                <input class="btn blue" type="submit" id="Btnmybtn"  value="Submit" name="submit"> 
                                                <div style="display: none;" id="loading"><img src="<?php echo $web_url ?>images/loader.gif"></div>
                                             </div>
                                          </div>
                                       </div>
                                    </form>
                                 </div>
                              </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                        <h4 style="color : #f03f2a; font-weight: bold" id="errorlog">
                                        </h4>
                                    </div>
                            </div>
                  </div>
               </div>
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
      
<script type="text/javascript">
         $('#frmuploadExcel').submit(function (e) {
             e.preventDefault();
             var $form = $(this);
             $('#loading').css("display", "block");
             $.ajax({
                 type: 'POST',
                 url: 'UploadQuestionAnswerQuerydata.php',
                 data: $('#frmuploadExcel').serialize(),
                 success: function (response) {
                    // alert(response);
                    console.log(response);
                    $("#Btnmybtn").attr('disabled', 'disabled');
                    $('#loading').css("display", "none");
                    $("#errorlog").html(response);
                    //  if (response == 1) {
                    //      $('#loading').css("display", "none");
                    //      alert('Record uploaded succefully');
                    //      //window.location.href = 'assigned.php';
                    //  }else {
                    //         $('#loading').css("display", "none");
                    //         $("#Btnmybtn").attr('disabled', 'disabled');
                    //         alert('Invalid Request.');
                    //       // window.location.href = '';
                    //     }
                 }
             });
         });
      </script>
      <script type="text/javascript">
         $(document).ready(function ()
         {                
             $("#gallery").on('change', function ()
             {     
                 var galeryID = 0;
                 galeryID = galeryID + 1;
                 $("#galeryID").val(galeryID);
                 $("#ImageGallery").html('<img src="<?php echo $web_url; ?>admin/images/input-spinner.gif" alt="Uploading...."/>');
                 var formData = new FormData($('form#frmuploadExcel')[0]);
                 $.ajax({
                     type: "POST",
                     url: "uploadExcelTemp.php",
                     processData: false,
                     contentType: false,
                     data: formData,
                     success: function (msg) {
                        // alert(msg);
                         $("#ImageGallery").show();
                         $("#ImageGallery").html(msg);
                     },
                 });
             });
         });
      </script>
   </body>
</html>