

<?php
   error_reporting(0);
   include('../common.php');
   include('IsLogin.php');
   $connect = new connect();
   ?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8" />
      <title><?php echo $ProjectName; ?> |Bulk Assign User</title>
      <?php include_once './include.php'; ?>
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
                        <a href="<?php echo $web_url;?>admin/Exam.php">Create Exam</a>
                        <i class="fa fa-circle"></i>
                     </li>
                     <li>
                        <span>Bulk Assign User</span>
                     </li>
                  </ul>
                  <div class="page-content-inner">
                     <div class="row">
                        <div class="col-md-12">
                           <div class="portlet light ">
                              <div class="f_tab_main">
                                 <div class="f_tab_link">
                                    <a href="AssignExam.php?id=<?php echo $_REQUEST['id'];?>" class="f_tab_link_active">Assign User</a>
                                    <a href="BulkAssignExam.php?id=<?php echo $_REQUEST['id'];?>" >Bulk Assign User</a>
                                    <a href="assigned.php?id=<?php echo $_REQUEST['id'];?>" class="f_tab_link_active">Assigned User</a>
                                 </div>
                                 <input type="hidden" name="examId" id="examId" value="<?php echo $_REQUEST['id']; ?>">
                                 <div class="f_tab_content">
                                    <!-- <div id="PlaceUsersDataHere">
                                       </div> -->
                                    <form  role="form"  method="POST"  action="" name="frmuploadExcel"  id="frmuploadExcel" enctype="multipart/form-data" class="margin-bottom-40">
                                       <input type="hidden" value="BulkAssignExcel" name="action" id="action">
                                       <input type="hidden" value="<?=$_REQUEST['id'];?>" name="examId" id="examId">
                                       <div class="form-body">
                                          <div class="row">
                                             <div class="form-group form-md-line-input has-warning col-md-12">
                                                <div>
                                                   <div class="form-group">
                                                      <label for="exampleInputFile1">Excel file</label><br />
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
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <?php include_once './footer.php'; ?>
      <script type="text/javascript">
         $('#frmuploadExcel').submit(function (e) {
         
         
         
             e.preventDefault();
         
             var $form = $(this);
         
             $('#loading').css("display", "block");
         
             $.ajax({
         
                 type: 'POST',
         
                 url: 'querydata.php',
         
                 data: $('#frmuploadExcel').serialize(),
         
                 success: function (response) {
         
                    // alert(response);
         
                     if (response == 1) {
         
                         $('#loading').css("display", "none");
         
                         alert('Record uploaded succefully');
         
                         window.location.href = 'assigned.php';
         
                     }else {

                            $('#loading').css("display", "none");

                            $("#Btnmybtn").attr('disabled', 'disabled');

                            alert('Invalid Request.');

                            window.location.href = '';
         
         
                        }
         
         
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

