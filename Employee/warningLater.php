<?php
ob_start();
include_once '../common.php';
$connect = new connect();
include('IsLogin.php');

$employee = "SELECT * FROM `employee` where  employeeid ='" . $_SESSION['EmployeeId'] . "' and isAutoSubmit=1";
$rowemployee = mysqli_query($dbconn, $employee);
?>
<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="utf-8" />
   <title><?php echo $ProjectName; ?> | Warning Later</title>
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
                     <span>Warning Later </span>
                  </li>
               </ul>
            </div>
            <div class="row">
               <div class="col-lg-12 mb-3">
                  <div class="f-pull-right">
                     <div class="form-group">
                        <div class="portlet-title">
                           <div class="caption font-red-sunglo f-pull-right" style="float: left; ">
                              <span class="caption-subject bold uppercase" style="color:#3f4296 ;font-size: 16px">List of Warning Later</span>
                           </div>
                        </div>
                        <?php
                        if ($_SESSION['Designation'] != 5) { ?>
                           <a href="addwarning.php" type="button" class="btn btn-primary f-pull-right" style="float: right; margin-top: -5px;"><i class="fa fa-plus"></i> Initiate Warning</a>
                        <?php }
                        
                        ?>

                     </div>
                  </div>
               </div>
            </div>
            <div class="clearfix"></div>
            <div class="portlet light ">
               <div class="portlet-body form">
                  <div class="row">

                     <form role="form" method="POST" action="" name="frmSearch" id="frmSearch" enctype="multipart/form-data">

                        <div class="form-group  col-md-3">

                           <input type="text" value="" name="formDate" class="form-control" id="formDate" placeholder="Search Form Date" required />

                        </div>

                        <div class="form-group col-md-3">

                           <input type="text" value="" name="toDate" class="form-control" id="toDate" placeholder="Search To Date" required />

                        </div>

                        <div class="form-group col-md-3">

                           <a href="#" class="btn blue pull-left" onclick="PageLoadData(1);">Search</a>
                         <?php  if (in_array($_SESSION['Designation'], array(3, 6, 7))) {
                        ?>
                           <a onclick="exportData();" type="button" class="btn btn-primary f-pull-right" style="float: right; margin-top: -5px;"> Export </a>
                        <?php
                        } ?>
                        </div>

                     </form>
                     <div class="row">
                        <div class="col-md-12">
                           <div class="portlet light ">
                              <div class="f_tab_main">
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
         $("#ModelBtn").click(function() {
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
      <script src="<?php echo $web_url; ?>Employee/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js" type="text/javascript"></script>
      <script type="text/javascript">
         function checkclose() {
            window.location.href = '';
         }

         $(document).ready(function() {

            $("#formDate").datepicker({

               format: 'dd-mm-yyyy',

               autoclose: true,

               todayHighlight: true,

               defaultDate: "now",

            });

            $("#toDate").datepicker({

               format: 'dd-mm-yyyy',

               autoclose: true,

               todayHighlight: true,

               defaultDate: "now",

            });

         });

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
                  } else {
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
            var fromDate = $('#formDate').val();
            var toDate = $('#toDate').val();

            $.ajax({
               type: "POST",
               url: "<?php echo $web_url; ?>Employee/ajaxWarningLater.php",
               data: {
                  action: 'ListUser',
                  Page: Page,
                  fromDate: fromDate,
                  toDate: toDate
               },
               success: function(msg) {

                  $('#loading').css("display", "none");
                  $("#PlaceUsersDataHere").html(msg);
               }
            });
         }
         PageLoadData(1);

         function exportData() {

            var fromDate = $('#formDate').val();
            var toDate = $('#toDate').val();
           
            var strURL = 'warningLaterExcel.php?toDate=' + toDate + '&formDate=' + fromDate;
            window.open(strURL, '_blank');

         }
      </script>
</body>

</html>