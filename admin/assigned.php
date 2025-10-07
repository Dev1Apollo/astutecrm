<?php

error_reporting(0);

include('../common.php');

include('IsLogin.php');

$connect = new connect();


        ?>
<!DOCTYPE html>



<html lang="en">



    <head>

        <meta charset="utf-8" />

        <title><?php echo $ProjectName; ?> | Assigned User</title>

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

                                <a href="<?php echo $web_url;?>admin/Exam.php">Create Exam</a>
                                <i class="fa fa-circle"></i>
                            </li>


                            <li>

                                <span>Assigned User</span>

                            </li>

                        </ul>



                        <div class="page-content-inner">



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

        <?php include_once './footer.php'; ?>

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

                    url: '<?php echo $web_url;?>admin/querydata.php',

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

                        url: "<?php echo $web_url;?>admin/Ajaxassigned.php",

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

                    url: "<?php echo $web_url;?>admin/Ajaxassigned.php",

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