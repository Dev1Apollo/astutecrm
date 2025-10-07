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
      <title><?php echo $ProjectName; ?> |Online Feedback</title>
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
                        <span>Post Feedback</span>
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
                        <div class="col-md-12">
                           <div class="portlet light ">
                               <div class="f_tab_main">
                                  <div class="f_tab_link" style="border-bottom: 1px solid;color: #3f4296;">
                                    <a href="onlineFeedback.php" >Post Feedback</a>
                                    <a href="TlDisputeFeedback.php" class="f_tab_link_active" > Pending Feedback</a> 
                                    <a href="closeFeedback.php" class="f_tab_link_active">Closed Feedback</a>
                                    <?php
                                        if(!empty($_SESSION)){
                                            if($_SESSION['Designation'] == 6 || $_SESSION['Designation'] == 1 || $_SESSION['Designation'] == 9){
                                    ?>
                                    <a href="FeedbackReport.php" class="f_tab_link_active">Feedback Report</a>
                                    <?php } if($_SESSION['Designation'] == 6){ ?>
                                    <a href="FeedbackDelete.php" class="f_tab_link_active">Delete Feedback</a>
                                    <?php } 
                                    }
                                    ?>
                                  </div>
                                  <div class="row" style="border-bottom: 1px solid #3f4296;">
                                     <div class="col-md-6" style="border-right: 1px solid #3f4296;">
                                        <div class="portlet light ">
                                           <div class="portlet-title">
                                              <div class="caption font-red-sunglo">
                                                 <i class="icon-settings font-red-sunglo"></i>
                                                 <span class="caption-subject bold uppercase" id="onlineFeedback">Add Post Feedback </span>

                                              </div>
                                              
                                           </div>
                                           <div class="portlet-body form">
                                              <form  role="form"  method="POST"  action="" name="frmparameter"  id="frmparameter" enctype="multipart/form-data">
                                                 <input type="hidden" value="AddOnlineFeedback" name="action" id="action">
                                                 <div class="form-body">
                                                    <div class="row">
                                                       <div class="style-msg  errormsg col_half">
                                                          <div class="alert alert-success" id="errorDIV" style="display: none;"></div>
                                                       </div>
                                                       <div class="col_half col_last">
                                                       </div>
                                                    </div>
                                                    <div class="form-group">
                                                       <label for="form_control_1">Feedback Category</label>
                                                       <div id="errordiv">
                                                          <?php
                                                             $queryCom = "SELECT * FROM `feedbackcategory`  where isDelete='0'  and  istatus='1' order by  feedbackCategoryId asc";
                                                             
                                                             $resultCom = mysqli_query($dbconn, $queryCom);
                                                             
                                                             echo '<select class="form-control" name="feedbackCategoryId" id="feedbackCategoryId" required="">';
                                                             
                                                             echo "<option value='' >Select Feedback Category</option>";
                                                             
                                                             while ($rowCom = mysqli_fetch_array($resultCom)) {
                                                             
                                                                 echo "<option value='" . $rowCom ['feedbackCategoryId'] . "'>" . $rowCom ['categoryName'] . "</option>";
                                                             
                                                             }
                                                            
                                                             echo "</select>";
                                                             
                                                             ?>
                                                       </div>
                                                    </div>
                                                    <div class="form-group ">
                                                       <label for="form_control_1">Feedback</label>
                                                       <input name="comment" id="comment"  class="form-control" placeholder="Enter comment" required="" type="text">
                                                    </div>
                                                    <div class="form-group">
                                                       <label for="form_control_1">Employee</label>
                                                       <div id="errordiv">
                                                         
                                                          <?php
                                                          $where = '1=1';
                                                          if($_SESSION['Designation'] == 6){
                                                            $where .= " and ed.iDesignationId not in (8,10,11) and centralmanagerId='". $_SESSION['EmployeeId']."' ";
                                                          } else if($_SESSION['Designation'] == 3){
                                                            $where .= 
                                                            " and ed.iDesignationId not in (1,3,6,8,10,11) and centralmanagerId='".$_SESSION['CentralManagerID']."' ";
                                                          } else if($_SESSION['Designation'] == 2){
                                                            $where .= " and ed.iDesignationId not in (1,3,6,2,7,8,11,10) and centralmanagerId='".$_SESSION['CentralManagerID']."' ";
                                                          } else if($_SESSION['Designation'] == 7){
                                                            $where .= " and ed.iDesignationId not in (1,3,6,2,7,8,11,10) and centralmanagerId='".$_SESSION['CentralManagerID']."' ";
                                                          } else if($_SESSION['Designation'] == 4){
                                                            $where .= " and ed.iDesignationId not in (3,6,2,7,1,4,8,11,10,9) and centralmanagerId='".$_SESSION['CentralManagerID']."' ";
                                                          } else if($_SESSION['Designation'] == 1){
                                                            $where .= " and ed.iDesignationId not in (3,6,2,4,7,1,8,11,10,9) and centralmanagerId='".$_SESSION['CentralManagerID']."' ";
                                                          } else if($_SESSION['Designation'] == 9){
                                                            $where .= " and ed.iDesignationId not in (3,6,2,4,7,1,8,11,10,9) and centralmanagerId='".$_SESSION['CentralManagerID']."' ";
                                                          } else if($_SESSION['Designation'] == 13){
                                                            $where .= " and ed.iDesignationId in (1,9) and centralmanagerId='".$_SESSION['CentralManagerID']."' and e.managerTQid='".$_SESSION['EmployeeId']."'";
                                                          }
                                                          //$queryCom = "SELECT employeeid,empname FROM `employee` e inner join employeedesignation ed on e.employeeid=ed.iEmployeeId where ".$where." and e.isDelete=0 and e.istatus=1 and centralmanagerId='".$_SESSION['CentralManagerID']."' ORDER BY `e`.`empname` ASC ";
                                                            $queryCom = "SELECT employeeid,empname FROM `employee` e INNER join employeedesignation ed on e.employeeid=ed.iEmployeeId where ".$where."  and e.isDelete=0 and e.istatus=1 ORDER BY empname ASC ";
                                                             
                                                             $resultCom = mysqli_query($dbconn, $queryCom);
                                                             
                                                             echo '<select class="form-control" name="employeeid" id="employeeid" required="">';
                                                             
                                                             echo "<option value='' >Select Employee</option>";
                                                             
                                                             while ($rowCom = mysqli_fetch_array($resultCom)) {
                                                             
                                                                 echo "<option value='" . $rowCom ['employeeid'] . "'>" . $rowCom ['empname'] . "</option>";
                                                             
                                                             }
                                                             
                                                             echo "</select>";
                                                             
                                                             ?>
                                                       </div>
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
                                     <!--<div class="col-md-6" >
                                        <div class="portlet light ">
                                           <div class="portlet-title">
                                              <div class="caption font-red-sunglo">
                                                 <i class="icon-settings font-red-sunglo"></i>
                                                 <span class="caption-subject bold uppercase" id="onlineFeedback">Add Post Bulk Feedback </span>

                                              </div>
                                              
                                           </div>
                                           <div class="portlet-body form">
                                              <form  role="form"  method="POST"  action="" name="frmuploadExcel"  id="frmuploadExcel" enctype="multipart/form-data" >
                                                 <input type="hidden" value="BulkFeedbackExcel" name="action" id="action">
                                                 <div class="form-body">
                                                    <div class="row">
                                                       <div class="style-msg  errormsg col_half">
                                                          <div class="alert alert-success" id="errorDIV" style="display: none;"></div>
                                                       </div>
                                                       <div class="col_half col_last">
                                                       </div>
                                                    </div>
                                                    <div>
                                                   <div class="form-group">
                                                      <label for="exampleInputFile1">Excel file</label><br />
                                                      <input type="file"  id="gallery" name="gallery" class="btn red" required=""/>
                                                      <input type="hidden" name="galeryID" ID="galeryID" />
                                                   </div>
                                                   <div id="ImageGallery" style="display:none;">  </div>
                                                </div>
                                                 </div>

                                                 <div class="form-actions noborder">
                                                    <input class="btn blue margin-top-20" type="submit" id="Btnmybtn"  value="Submit" name="submit">      
                                                    <button type="button" class="btn blue margin-top-20" onClick="checkclose();">Cancel</button>
                                                 </div>
                                              </form>
                                              <div id="responseMsg"></div>
                                           </div>
                                        </div>
                                     </div>-->
                         
              
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
    </body>
  
      <a href="javascript:;" class="page-quick-sidebar-toggler">
      <i class="icon-login"></i>
      </a>
      </div>
      <?php include_once './footer.php'; ?>
      </div>
      <?php include_once './footerjs.php'; ?>
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
         // $("#ModelBtn").click(function (){
         //   var modal = document.getElementById("myModal");
         //    modal.style.display = "block";
         // });
      </script>
   <script type="text/javascript">
         function checkclose() {
         
             window.location.href = '';
         
         }
         
         
         // $(document).ready(function() {
         //            $("#employeeid").select2();
         //        });
         
         //        function selectAll() {
         //            $("#employeeid > option").prop("selected", true);
         //            $("#employeeid").trigger("change");
         //        }
         
         //        function deselectAll() {
         //            $("#employeeid > option").prop("selected", false);
         //            $("#employeeid").trigger("change");
         //        }
         
         
         
         
         
         $('#frmuploadExcel').submit(function (e) {
         
        
         
             e.preventDefault();
         
             var $form = $(this);
         
             $('#loading').css("display", "block");
         
             $.ajax({
         
                 type: 'POST',
         
                 url: '<?php echo $web_url;?>Employee/querydata.php',
         
                 data: $('#frmuploadExcel').serialize(),
         
                 success: function (response) {
                     console.log(response);
                    // alert(response);
                     //$("#Btnmybtn").attr('disabled', 'disabled');
                      $('#loading').css("display", "none");
                     $("#responseMsg").html(response);
                     // if (response == 1)
                     // {
                     //     $('#loading').css("display", "none");
                     //     $("#Btnmybtn").attr('disabled', 'disabled');
                     //     alert('Added Sucessfully.');
                     //     window.location.href = '';
                     // } else if (response == 2){
                     //      $('#loading').css("display", "none");
                     //     $("#Btnmybtn").attr('disabled', 'disabled');
                     //     alert('Feedback Category Not Match.');
                     //     window.location.href = '';
                     // }else{
                     //     $('#loading').css("display", "none");
                     //     $("#Btnmybtn").attr('disabled', 'disabled');
                     //     alert('Invalid Request.');
                     //     window.location.href = '';
         
                     // }
         
                 }
         
         
         
             });
         
         });       
            $('#frmparameter').submit(function (e) {
         
         
         
             e.preventDefault();
         
             var $form = $(this);
         
             $('#loading').css("display", "block");
         
             $.ajax({
         
                 type: 'POST',
         
                 url: '<?php echo $web_url;?>Employee/querydata.php',
         
                 data: $('#frmparameter').serialize(),
         
                 success: function (response) {
                     console.log(response);
                     //$("#Btnmybtn").attr('disabled', 'disabled');
                     if (response == 1)
                     {
                         $('#loading').css("display", "none");
                         $("#Btnmybtn").attr('disabled', 'disabled');
                         alert('Added Sucessfully.');
                         window.location.href = '';
                     } else
                     {
                         $('#loading').css("display", "none");
                         $("#Btnmybtn").attr('disabled', 'disabled');
                         alert('Invalid Request.');
                         window.location.href = '';
         
                     }
         
                 }
         
         
         
             });
         
         });      
         
         function PageLoadData(Page) {
         
             var Search_Txt = $('#Search_Txt').val();  
         
            // $('#loading').css("display", "block");
         
             $.ajax({
         
                 type: "POST",
         
                 url: "<?php echo $web_url;?>Employee/AjaxOnlineFeedback.php",
         
                 data: {action: 'ListUser', Page: Page, Search_Txt: Search_Txt},
         
                 success: function (msg) {
         
         
         
                     $("#PlaceUsersDataHere").html(msg);
         
                     $('#loading').css("display", "none");
         
                 },
         
             });
         
         }// end of filter
         
         PageLoadData(1);
         
         
         
         
         
         
         
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

