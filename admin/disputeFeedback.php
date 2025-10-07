

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
      <title><?php echo $ProjectName; ?> |Dispute Feedback </title>
      <?php include_once './include.php'; ?>
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
      <link href="./bootstrap.css" rel="stylesheet" type="text/css" />
   </head>
   <body class="page-container-bg-solid page-boxed">
      <?php include_once './header.php'; ?>
      <div style="display: none; z-index: 10060;" id="loading">
         <img id="loading-image" src="<?php echo $web_url; ?>admin/images/loader1.gif">
      </div>
      <div class="page-container">
         <div class="page-content-wrapper">
            <div class="page-content">
               <div class="container">
                  <ul class="page-breadcrumb breadcrumb">
                     <li>
                        <a href="<?php echo $web_url; ?>admin/index.php">Home</a>
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
                                       <a href="onlineFeedback.php" class="f_tab_link_active" >Online Feedback</a>
                                       <a href="disputeFeedback.php"  >Dispute Feedback</a>
                                       <a href="" class="f_tab_link_active">Close Feedback</a>
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
      <?php include_once './footer.php'; ?>
      <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
      <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet"/>
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
         
                 url: '<?php echo $web_url; ?>admin/querydata.php',
         
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
         
                 url: "<?php echo $web_url; ?>admin/AjaxOnliefeedback.php",
         
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

