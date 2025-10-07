<?php
   ob_start();
   error_reporting(E_ALL);
   include_once '../common.php';
   $connect = new connect();
   include('IsLogin.php');
   
  $filterstr = "select *,(Select Sum(questionMarks) from questionanswer q1 where q1.examId=e.examId and isDelete='0' and istatus='1' )as TotalMarks from exammaster e where  e.examId='".$_REQUEST['id']."' and e.isDelete='0'";
     $resultfilter = mysqli_query($dbconn, $filterstr);
     $rowfilter = mysqli_fetch_array($resultfilter);   ?>
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
                                <span>List Of Result</span>
                    
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

                                        <div class="portlet-title">

                                            <div class="caption font-red-sunglo">

                                                <i class="icon-settings font-red-sunglo"></i>

                                                <span class="caption-subject bold uppercase" id="FAQ">Click Here Result List Of Excel</span>
                                                <a class="btn blue" href="resultList.php?id=<?php echo $_REQUEST['id']; ?>" title="Result"><i class="fa fa-list-alt"></i>Result</a>

                                            </div>
                                        </div>
                                         <div class="portlet-title">

                                            
                                            <div class="caption font-red-sunglo">

                                                <i class="icon-settings font-red-sunglo"></i>

                                                <span class="caption-subject bold uppercase" id="FAQ">Download Result Details in Excel</span>
                                                
                                                <a class="btn blue" href="resultDetailseXcle.php?id=<?php echo $_REQUEST['id']; ?>" title="Result"><i class="fa fa-list-alt"></i>Result Details</a>

                                            </div>
                                        </div>
                                        <div class="portlet-title">

                                             <div class="row">
                                                        <div class="col-md-4"><strong>Exam Name:</strong><?php echo $rowfilter['examTitle']; ?></div>
                                                        <div class="col-md-4"> Exam Date : <strong><?= date('d-m-Y',strtotime($rowfilter['examDateTime'])) ?></strong></div>
                                                        <div class="col-md-4"><strong>Total Marks:</strong> <?= isset($rowfilter['TotalMarks']) ? $rowfilter['TotalMarks'] : 0; ?></div>
                                                        <div class="col-md-4"><strong>Exam Start Time:</strong><?php echo date('H:i:s',strtotime($rowfilter['examDateTime'])); ?>
                                                        </div>
                                                        <div class="col-md-4"><strong>Exam Duration Time :</strong><?php echo $rowfilter['examDuration']; ?>  Minute
                                                        </div>
                                                        <div class="col-md-4"><strong>Exam End Date & Time:</strong><?php echo $rowfilter['examEndDateTime']; ?>
                                                        </div>

                                                    </div>
                                            
                                        </div>

                                        <div class="portlet-body form">

                                            <form  role="form"  method="POST"  action="" name="frmquestion"  id="frmquestion" enctype="multipart/form-data">
                                             <input type="hidden" name="examId" id="examId" value="<?php echo $_REQUEST['id']; ?>">        
                                               
                                              

                                            </form>

                                        </div>

                                    </div>

                                </div>



                                <div class="col-md-12">

                                    <div class="portlet light ">

                                        <div class="portlet-title">

                                            <div class="caption font-red-sunglo">

                                                <i class="icon-settings font-red-sunglo"></i>

                                                <span class="caption-subject bold uppercase">List of Result</span>

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
   
   
   

   function PageLoadData(Page) {
   
   var examId = $('#examId').val();
   
   $('#loading').css("display", "block");
   
   $.ajax({
   
   type: "POST",
   
   url: "<?php echo $web_url;?>Employee/AjaxlistOfResult.php",
   
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