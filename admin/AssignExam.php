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

        <title><?php echo $ProjectName; ?> | Assign user </title>

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

                                <span>Assign user</span>

                            </li>

                        </ul>



                        <div class="page-content-inner">



                            <div class="row">

                                <div class="col-md-12">

                                    <div class="portlet light ">
                                        <div class="f_tab_main">
                                            <div class="f_tab_link">
                                                <a href="AssignExam.php?id=<?php echo $_REQUEST['id'];?>" >Assign User</a>
                                                <a href="BulkAssignExam.php?id=<?php echo $_REQUEST['id'];?>" class="f_tab_link_active" >Bulk Assign User</a>
                                                <a href="assigned.php?id=<?php echo $_REQUEST['id'];?>" class="f_tab_link_active">Assigned User</a>
                                            </div>
                                            <input type="hidden" name="examId" id="examId" value="<?php echo $_REQUEST['id']; ?>">
                                            <div class="f_tab_content">
                                                
                                                <!-- <div id="PlaceUsersDataHere">
                                                </div> -->

                                                <div class="portlet-body form col-md-12" >
                                        <form  role="form"  method="POST"  action="" name="frmSearch"  id="frmSearch" enctype="multipart/form-data">
                                                    <div class="form-group col-md-3">
                                                        <?php
                                                        $queryCom = "SELECT * FROM `designation`  where isDelete='0' and  istatus='1' and designationid in (5,4,1,9,12,18) order by  designationid asc";
                                                        $resultCom = mysqli_query($dbconn, $queryCom);
                                                        echo '<select class="form-control" name="designationid" id="designationid" required="" >';
                                                        echo "<option value='' >Select Designation</option>";
                                                        while ($rowCom = mysqli_fetch_array($resultCom)) {
                                                            echo "<option value='" . $rowCom ['designationid'] . "'>" . $rowCom ['designation'] . "</option>";
                                                        }
                                                        echo "</select>";
                                                        ?>
                                                    </div>
                                                    <div class="form-group col-md-3">
                                                        <?php
                                                        $queryCom = "SELECT * FROM `processmaster`  where isDelete='0'  and  istatus='1' order by  processmasterid asc";
                                                        $resultCom = mysqli_query($dbconn, $queryCom);
                                                        echo '<select class="form-control" name="process" id="process" required="" >';
                                                        echo "<option value='' >Select process</option>";
                                                        while ($rowCom = mysqli_fetch_array($resultCom)) {
                                                            echo "<option value='" . $rowCom ['processmasterid'] . "'>" . $rowCom ['processname'] . "</option>";
                                                        }
                                                        echo "</select>";
                                                        ?>
                                                    </div>
                                        
                                            <div class="col-md-3">
                                                    <button type="button" id="search" name="search"  class="btn blue" onclick="PageLoadData(1)">Search</button>
                                                
                                            </div>
                                        </form>


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



    function PageLoadData(Page) {

        var examId = $('#examId').val();
        var process = $('#process').val();
        var designationid = $("#designationid").val();
        $('#loading').css("display", "block");

        $.ajax({

            type: "POST",

            url: "<?php echo $web_url;?>admin/AjaxAssignExam.php",

            data: {action: 'ListUser', Page: Page, examId: examId, process:process,designationid: designationid},

            success: function (msg) {

                $("#PlaceUsersDataHere").html(msg);

                $('#loading').css("display", "none");

            },

        });

    }// end of filter

    //PageLoadData(1);



        </script>

    </body>

</html>