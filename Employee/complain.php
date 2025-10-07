<?php
   ob_start();
   error_reporting(E_ALL);
   include_once '../common.php';
   $connect = new connect();
   include('IsLogin.php');
   
    $employee = "SELECT * FROM `employee` where  employeeid ='".$_SESSION['EmployeeId']."' and isAutoSubmit=1";
       $rowemployee = mysqli_query($dbconn,$employee);
   ?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8" />
      <title><?php echo $ProjectName; ?> | Complain</title>
      <?php include_once './include.php'; ?>
      <link href="<?php echo $web_url; ?>Employee/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker.css" rel="stylesheet" type="text/css" />
      <link href="<?php echo $web_url; ?>Employee/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.css" rel="stylesheet" type="text/css" />
      <!-- 
         <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css"> -->
   </head>
   <body class="page-header-fixed page-sidebar-closed-hide-logo page-content-white page-md">
      <div class="page-wrapper">
         <?php include_once './header.php'; ?>
         <div style="display: none; z-index: 10060;" id="loading">
            <img id="loading-image" src="<?php echo $web_url; ?>Employee/images/loader.gif">
         </div>
         <div class="page-content-wrapper">
            <div class="page-content" style=" min-height: 800px; ">
               <div class="page-bar">
                  <ul class="page-breadcrumb">
                     <li>
                        <a href="index.php">Home</a>
                        <i class="fa fa-circle"></i>
                     </li>
                     <li>
                        <span>Ticket </span>
                     </li>
                  </ul>
               </div>
               <div class="row">
                  <div class="col-lg-12 mb-3">
                     <div class="f-pull-right">
                        <div class="form-group">
                           <div class="portlet-title">
                              <div class="caption font-red-sunglo f-pull-right" style="float: left; ">
                                 <span class="caption-subject bold uppercase" style="color:#3f4296 ;font-size: 16px">List of Ticket</span>
                              </div>
                           </div>
                           <button type="button" id="ModelBtn" class="btn btn-primary f-pull-right" style="float: right; margin-top: -5px;"><i class="fa fa-plus"></i> Add New</button>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="clearfix"></div>
               <div class="portlet light " style="" id="SLID">
                  <div class="portlet-body form">
                     <div class="row">
                        <div class="col-md-12">
                           <div class="portlet light ">
                              <div class="f_tab_main">
                                 <div class="f_tab_link">
                                    <a href="complain.php" >Pending Ticket</a>
                                    <a href="closeComplain.php" class="f_tab_link_active" class="f_tab_link_active">Closed Ticket</a>
                                 </div>
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
    
      <div id="myModal" class="modal">
         <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
               <div class="modal-header">
                  <h5 class="modal-title" id="Course">Complain</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                  </button>
               </div>
               <form id="frmcourse" name="frmcourse" method="post" enctype="multipart/form-data">
                  <div class="modal-body">
                     <input type="hidden" value="Addcomplain" name="action" id="action">
                     <div class="row">

                        <div class="form-group col-md-8">
                           <label for="form_control_1">Ticket Category</label>
                           <div id="errordiv">
                              <?php
                                 $queryCom = "SELECT * FROM `ticketcategory`  where isDelete='0'  and  istatus='1' order by  ticketCategoryId asc";
                                 
                                 $resultCom = mysqli_query($dbconn, $queryCom);
                                 
                                 echo '<select class="form-control" name="ticketCategoryId" id="ticketCategoryId" required="">';
                                 
                                 echo "<option value='' >Select Ticket Category</option>";
                                 
                                 while ($rowCom = mysqli_fetch_array($resultCom)) {
                                 
                                     echo "<option value='" . $rowCom ['ticketCategoryId'] . "'>" . $rowCom ['categoryName'] . "</option>";
                                 
                                 }
                                 
                                 echo "</select>";
                                 
                                 ?>
                           </div>
                        </div>
                        <div class="form-group col-md-8">
                           <label for="recipient-name" class="form-control-label">Floor Asset<span>*</span></label>
                           <input name="floorAsset" id="floorAsset"  class="form-control" placeholder="Enter Floor Asset" type="text" required="">
                        </div>
                        <div class="form-group col-md-6">
                           <label for="recipient-name" class="form-control-label">Post Complain<span>*</span></label>
                           <textarea name="complainText" id="complainText" cols="60" rows="5" required=""></textarea>
                        </div>
                     </div>
                  </div>
                  <div class="modal-footer">
                     <button type="submit" name="submit" id="submit"  class="btn btn-primary">Submit</button>
                     <div id="updatebtn" style="display: none;">
                        <button type="submit" name="submit"  class="btn btn-primary">Update</button>
                     </div>
                     <button type="button" class="btn btn-danger" data-dismiss="modal" onclick="checkclose();">Close</button>
                  </div>
               </form>
            </div>
         </div>
      </div>

      <a href="javascript:;" class="page-quick-sidebar-toggler">
      <i class="icon-login"></i>
      </a>
      
      <?php include_once './footer.php'; ?>
      
      <?php include_once './footerjs.php'; ?>
      <script src="<?php echo $web_url; ?>Employee/assets\jquery-1.8.0.min.js" type="text/javascript"></script>
      <script>
         // Get the modal
         //document.getElementById('id01').style.display='none';
         
         //var modal = document.getElementById('id01');
         
         // When the user clicks anywhere outside of the modal, close it
         window.onclick = function(event) {
           // if (event.target == modal) {
           //   modal.style.display = "none";
           // }
           
         }
         $("#ModelBtn").click(function (){
           var modal = document.getElementById("myModal");
            modal.style.display = "block";
         });
      </script>
      <script>
         /*jQuery.noConflict();
         (function($) {
             $(function() {
                 // More code using $ as alias to jQuery
                 $('#addBtn').click(function() {
                     $('#exampleModal3').modal('show');
                 });
             });
         })(jQuery);*/
      </script>
      <script type="text/javascript">
         function checkclose() {
              window.location.href = '';
          }
         
         $('#frmcourse').submit(function(e) {
             var action = $('#action').val();            
             $('#loading').css("display", "block");
             $.ajax({
                 type: 'POST',
                 url: 'querydata.php',
                 data: $('#frmcourse').serialize(),
                 success: function(response) {
                     console.log(response);
                     
                     if (response == 1) {
                        
                         $('#loading').css("display", "none");
                         $("#Btnmybtn").attr('disabled', 'disabled');
                         alert('Added Sucessfully.');
                         window.location.href = '';
                     }else  {
                         $('#loading').css("display", "none");
                         $("#Btnmybtn").attr('disabled', 'disabled');
                         alert('Invalid Request.');
                         window.location.href = '';
                     }
                     
                     PageLoadData(1);
                 return false;
                 }
             });
             
         
              return false;
         });
          
         
         
         function PageLoadData(Page) {
         $('#loading').css("display", "block");
         $.ajax({
             type: "POST",
             url: "<?php echo $web_url; ?>Employee/AjaxComplain.php",
             data: {action: 'ListUser', Page: Page},
             success: function (msg) {
                 $('#SLID').show();
                 $('#loading').css("display", "none");
                 $("#PlaceUsersDataHere").html(msg);
             }
         });
         }
         PageLoadData(1);
         
      </script>   
   </body>
</html>