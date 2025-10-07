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
      <title><?php echo $ProjectName; ?> |Assign user</title>
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
                        <span>Assigned User</span>
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
                                            <div class="f_tab_link">
                                                <a href="AssignExam.php?id=<?php echo $_REQUEST['id'];?>" class="f_tab_link_active">Assign User</a>
                                                <a href="BulkAssignExam.php?id=<?php echo $_REQUEST['id'];?>" class="f_tab_link_active" >Bulk Assign User</a>
                                                <a href="assigned.php?id=<?php echo $_REQUEST['id'];?>">Assigned User</a>
                                            </div>
                                            <input type="hidden" value="<?=$_REQUEST['id'];?>" name="examId" id="examId">
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

                            alert('Added Language Sucessfully.');

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

                                    function CheckAll()
                                    {

                                        if ($('#check_listall').is(":checked"))
                                        {
                                            // alert('cheked');
                                            $('input[type=checkbox]').each(function () {
                                                $(this).prop('checked', true);
                                            });
                                        } else
                                        {
                                            //alert('cheked fail');
                                            $('input[type=checkbox]').each(function () {
                                                $(this).prop('checked', false);
                                            });
                                        }
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

                        url: "<?php echo $web_url;?>Employee/Ajaxassigned.php",

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

                var examId = $('#examId').val();

                $('#loading').css("display", "block");

                $.ajax({

                    type: "POST",

                    url: "<?php echo $web_url;?>Employee/Ajaxassigned.php",

                    data: {action: 'ListUser', Page: Page, examId: examId},

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