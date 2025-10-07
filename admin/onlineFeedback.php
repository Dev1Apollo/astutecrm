

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
      <title><?php echo $ProjectName; ?> | FAQ Answer </title>
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
                     <span>Online Feedback</span>
                  </li>
               </ul>
               <div class="page-content-inner">
                  <div class="portlet-body form">
                     <div class="row">
                        <div class="col-md-12">
                           <div class="portlet light ">
                             <div class="f_tab_main">
                                    <div class="f_tab_link" style="border-bottom: 1px solid;color: #3f4296;">
                                       <a href="onlineFeedback.php" >Online Feedback</a>
                                       <a href="disputeFeedback.php" class="f_tab_link_active" >Dispute Feedback</a>
                                       <a href="" class="f_tab_link_active">Close Feedback</a>
                                    </div>
                                    <div class="row">
                                       <div class="col-md-4" style="border-right: 1px solid #3f4296;">
                                          <div class="portlet light ">
                                             <div class="portlet-title">
                                                <div class="caption font-red-sunglo">
                                                   <i class="icon-settings font-red-sunglo"></i>
                                                   <span class="caption-subject bold uppercase" id="onlineFeedback">Add Online Feedback </span>
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
                                                         <label for="form_control_1">Question</label>
                                                         <input name="comment" id="comment"  class="form-control" placeholder="Enter QuestionText" required="" type="text">
                                                      </div>
                                                      <div class="form-group">
                                                         <label for="form_control_1">Agent</label>
                                                         <div id="errordiv">
                                                            <!-- <button type="button" onclick="selectAll()">Select All</button>
                                                               <button type="button" onclick="deselectAll()">Deselect All</button> -->
                                                            <?php
                                                               $queryCom = "SELECT employeeid,empname FROM `employee` e inner join employeedesignation ed on e.employeeid=ed.iEmployeeId where ed.iDesignationId=5 and e.isDelete=0 and e.istatus=1 ORDER BY `e`.`empname` ASC ";
                                                               
                                                               $resultCom = mysqli_query($dbconn, $queryCom);
                                                               
                                                               echo '<select class="form-control" name="employeeid" id="employeeid" required="">';
                                                               
                                                               echo "<option value='' >Select Agent</option>";
                                                               
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
                                       <div class="col-md-8">
                                          <div class="portlet light ">
                                             <div class="portlet-title">
                                                <div class="caption font-red-sunglo">
                                                   <i class="icon-settings font-red-sunglo"></i>
                                                   <span class="caption-subject bold uppercase">List of Feedback</span>
                                                </div>
                                             </div>
                                             <div class="portlet-body form">
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
                  </div>
               </div>
            </div>
         </div>
      </div>
      <?php include_once './footer.php'; ?>
      <!-- <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
         <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet"/> -->
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
         
         
         
         
         
         $('#frmparameter').submit(function (e) {
         
         
         
             e.preventDefault();
         
             var $form = $(this);
         
             $('#loading').css("display", "block");
         
             $.ajax({
         
                 type: 'POST',
         
                 url: '<?php echo $web_url;?>admin/querydata.php',
         
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
         
             $('#loading').css("display", "block");
         
             $.ajax({
         
                 type: "POST",
         
                 url: "<?php echo $web_url;?>admin/AjaxOnlinefeedback.php",
         
                 data: {action: 'ListUser', Page: Page, Search_Txt: Search_Txt},
         
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

