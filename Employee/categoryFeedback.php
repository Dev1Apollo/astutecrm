

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
      <title><?php echo $ProjectName; ?> |Pending Ticket</title>
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
                        <span>Category Feedback</span>
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
                                                        <div class="col-md-4">

                                    <div class="portlet light ">

                                        <div class="portlet-title">

                                            <div class="caption font-red-sunglo">

                                                <i class="icon-settings font-red-sunglo"></i>

                                                <span class="caption-subject bold uppercase" id="Feedback">Add Feedback Category</span>

                                            </div>

                                        </div>

                                        <div class="portlet-body form">

                                            <form  role="form"  method="POST"  action="" name="frmparameter"  id="frmparameter" enctype="multipart/form-data">

                                                <input type="hidden" value="AddCategoryFeedback" name="action" id="action">

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

                                                        <input name="categoryName" id="categoryName"  class="form-control" placeholder="Enter Feedback Name" required="" type="text">

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

                                                <span class="caption-subject bold uppercase">List of Category Feedback</span>

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

                        if (response == 1) {

                            $('#loading').css("display", "none");

                            $("#Btnmybtn").attr('disabled', 'disabled');

                            alert('Added Sucessfully.');

                            window.location.href = '';

                        } else if (response == 2) {

                            $('#loading').css("display", "none");

                            $("#Btnmybtn").attr('disabled', 'disabled');

                            alert('Edited Sucessfully.');

                            window.location.href = '';

                        } else {

                            $('#loading').css("display", "none");

                            $("#Btnmybtn").attr('disabled', 'disabled');

                            alert('Invalid Request.');

                            window.location.href = '';

                        }

                    }

                });

            });



            function setEditdata(id)

            {

                $('#errorDIV').css('display', 'none');

                $('#errorDIV').html('');

                $('#loading').css("display", "block");

                $.ajax({

                    type: 'POST',

                    url: '<?php echo $web_url;?>Employee/querydata.php',

                    data: {action: "GetCategoryFeedback", ID: id},

                    success: function (response) {

                        document.getElementById("Feedback").innerHTML = "EDIT Category Feedback";

                        $('#loading').css("display", "none");

                        var json = JSON.parse(response);

                        $('#categoryName').val(json.categoryName);

                        $('#action').val('EditCategoryFeedback');

                        $('<input>').attr('type', 'hidden').attr('name', 'feedbackCategoryId').attr('value', json.feedbackCategoryId).attr('id', 'feedbackCategoryId').appendTo('#frmparameter');

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

                        url: "<?php echo $web_url;?>Employee/AjaxCategoryFeedback.php",

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

                var Search_Txt = $('#Search_Txt').val();

                $('#loading').css("display", "block");

                $.ajax({

                    type: "POST",

                    url: "<?php echo $web_url;?>Employee/AjaxCategoryFeedback.php",

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

