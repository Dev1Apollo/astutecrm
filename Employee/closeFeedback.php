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
      <title><?php echo $ProjectName; ?> |Closed Feedback</title>
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
                        <span>Closed Feedback</span>
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

                                <div class="col-md-12">

                                    <div class="portlet light ">
                                        <div class="f_tab_main">
                                            <div class="f_tab_link" style="border-bottom: 1px solid;color: #3f4296;">
                                     <a href="onlineFeedback.php" class="f_tab_link_active" >Post Feedback</a>
                                     <a href="TlDisputeFeedback.php" class="f_tab_link_active" >Pending Feedback</a>
                                   
                                     <a href="closeFeedback.php" >Closed Feedback</a>
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
                                            
                                            <div class="f_tab_content">
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
      <div id="myModal" class="modal">  

                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                           <h5 class="modal-title" id="Course">Closed Feedback</h5>
                           <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                           <span aria-hidden="true">&times;</span>
                           </button>
                        </div>
                        <form id="frmresloved" name="frmresloved" method="post" enctype="multipart/form-data">
                          <input type="hidden" value="" name="feedbackId" id="feedbackId">
                           <div class="modal-body" id="historyfeedbackData">
                           </div>
                           <div class="modal-footer">
                              
                              
                              <button type="button" class="btn btn-danger" data-dismiss="modal" onclick="checkclose();">Close</button>
                           </div>
                        </form>
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

              
            function checkclose() {

                window.location.href = '';

            }
               
            function ChatHistory(feedbackId){
               
                $('#feedbackId').val(feedbackId);
                historyData(feedbackId);
                var modal = document.getElementById("myModal");
                 modal.style.display = "block";
            }

            function PageLoadData(Page) {

                $('#loading').css("display", "block");

                $.ajax({

                    type: "POST",

                    url: "<?php echo $web_url;?>Employee/AjaxCloseFeedback.php",

                    data: {action: 'ListUser',Page:Page,},

                    success: function (msg) {

                        $("#PlaceUsersDataHere").html(msg);

                        $('#loading').css("display", "none");

                    },

                });

            }// end of filter

            PageLoadData(1);


            function historyData(feedbackId) {

                

                $('#loading').css("display", "block");
               // var feedbackId = $('#feedbackId').val();
                
               // alert(feedbackId);
                $.ajax({

                    type: "POST",

                    url: "<?php echo $web_url;?>Employee/AjaxHistoryFeedbackEmployee.php",

                    data: {action: 'ListUser',feedbackId:feedbackId},

                    success: function (msg) {

                        $("#historyfeedbackData").html(msg);

                        $('#loading').css("display", "none");

                    },

                });

            }


        </script>


   </body>
</html>