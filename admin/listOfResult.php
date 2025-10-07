<?php

ob_start();

error_reporting(E_ALL);

include_once '../common.php';

$connect = new connect();

include('IsLogin.php');



    $filterstr = "select *,(Select Sum(questionMarks) from questionanswer q1 where q1.examId=e.examId and isDelete='0' and istatus='1' )as TotalMarks from exammaster e where  e.examId='".$_REQUEST['id']."' and e.isDelete='0'";
     $resultfilter = mysqli_query($dbconn, $filterstr);
     $rowfilter = mysqli_fetch_array($resultfilter);
?>
<!DOCTYPE html>

<html lang="en">

    <head>

        <meta charset="utf-8" />

        <title><?php echo $ProjectName; ?> | Question Answer Master </title>

        <?php include_once './include.php'; ?>
        <link href="<?php echo $web_url; ?>admin\assets\global\css\components-md.css" rel="stylesheet" type="text/css" />
    </head>

    <body class="page-container-bg-solid page-boxed">


        <?php include_once './header.php';
                ?>

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

                                <span>List Of Result</span>

                            </li>

                        </ul>



                        <div class="page-content-inner">



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

        <?php include_once './footer.php'; ?>

        <script type="text/javascript">

            

            function checkclose() {

                window.location.href = '';

            }





            

            function PageLoadData(Page) {

                var examId = $('#examId').val();

                $('#loading').css("display", "block");

                $.ajax({

                    type: "POST",

                    url: "<?php echo $web_url;?>admin/AjaxlistOfResult.php",
                   

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