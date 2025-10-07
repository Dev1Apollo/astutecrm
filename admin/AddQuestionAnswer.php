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

        <title><?php echo $ProjectName; ?> | Question Answer Master </title>

        <?php include_once './include.php'; ?>

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

                                <span>Question Answer</span>

                            </li>

                        </ul>



                        <div class="page-content-inner">



                            <div class="row">

                                <div class="col-md-12">

                                    <div class="portlet light ">

                                        <div class="portlet-title">

                                            <div class="caption font-red-sunglo">

                                                <i class="icon-settings font-red-sunglo"></i>

                                                <span class="caption-subject bold uppercase" id="FAQ">Add Question Answer</span>

                                            </div>

                                        </div>

                                        <div class="portlet-body form">

                                            <form  role="form"  method="POST"  action="" name="frmquestion"  id="frmquestion" enctype="multipart/form-data">

                                                <input type="hidden" value="Addquestion" name="action" id="action">
                                                <input type="hidden" name="examId" id="examId" value="<?php echo $_REQUEST['id']; ?>">
                                                <div class="form-body">
                                                    <div class="row">
                                                        <div class="col-md-4">Exam Name: <?php echo $rowfilter['examTitle']; ?></div>
                                                        <div class="col-md-4">Total Question:<?php echo $rowfilter['TotalQuestion']; ?>
                                                        </div>
                                                        <div class="col-md-4">Total Marks: <?= isset($rowfilter['TotalMarks']) ? $rowfilter['TotalMarks'] : 0; ?></div>
                                                    </div>
                                                    <div class="row">

                                                        <div class="style-msg  errormsg col_half">

                                                            <div class="alert alert-success" id="errorDIV" style="display: none;"></div>

                                                        </div>

                                                        <div class="col_half col_last">

                                                        </div>

                                                    </div>

                                                    <div class="form-group col-md-12">

                                                        <label for="form_control_1">Question</label>

                                                        <input name="question" id="question"  class="form-control" placeholder="Enter Question" required="" type="text">

                                                    </div>
                                                    <div class="form-group col-md-3">

                                                        <label for="answer1">Option 1</label>

                                                        <input name="option1" class="form-control" id="option1"required="" type="text">
                                                    </div>
                                                    <div class="form-group col-md-3">
                                                        <label for="option2">Option 2</label>

                                                        <input name="option2" class="form-control" id="option2" required="" type="text">
                                                        </div>
                                                    <div class="form-group col-md-3">
                                                        <label for="option3">Option 3</label>

                                                        <input name="option3" class="form-control" id="option3"  required="" type="text">
                                                    </div>
                                                    <div class="form-group col-md-3">
                                                        <label for="option4">Option 4</label>

                                                        <input name="option4" class="form-control" id="option4" required="" type="text">

                                                    </div>
                                                    <div class="form-group col-md-3">

                                                        <label for="form_control_1">Question Marks</label>
                                                        <input type="number" data-decimal="2" oninput="enforceNumberValidation(this)" step="any" min="0.01" class="form-control" id="questionMarks" name="questionMarks" value="1" placeholder="Enter questionMarks" required="" >
                                                     <!--    
                                                     <input type="text" name="questionMarks" class="form-control" id="questionMarks"  data-decimal="2" onchange="checkmarks()" required="" >
 -->
                                                    </div>
                                                    <div class="form-group col-md-3">
                                                        <label for="form_control_1">Right answer</label>

                                                        <select name="rightAnswer" class="form-control" id="rightAnswer" required="">
                                                          <option value="">Select Right Answer</option>
                                                          <option value="1">Option 1</option>
                                                          <option value="2">Option 2</option>
                                                          <option value="3">Option 3</option>
                                                          <option value="4">Option 4</option>
                                                        </select>

                                                    </div>
                                                    
                                                </div>

                                                <div class="form-actions noborder">

                                                    <input class="btn blue margin-top-25" type="submit" id="Btnmybtn"  value="Submit" name="submit">      

                                                    <button type="button" class="btn blue margin-top-25" onClick="checkclose();">Cancel</button>

                                                </div>

                                            </form>

                                        </div>

                                    </div>

                                </div>



                                <div class="col-md-12">

                                    <div class="portlet light ">

                                        <div class="portlet-title">

                                            <div class="caption font-red-sunglo">

                                                <i class="icon-settings font-red-sunglo"></i>

                                                <span class="caption-subject bold uppercase">List of Question Answer</span>

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



            $('#frmquestion').submit(function (e) {

                e.preventDefault();

                var $form = $(this);

                $('#loading').css("display", "block");

                $.ajax({

                    type: 'POST',

                    url: '<?php echo $web_url;?>admin/querydata.php',

                    data: $('#frmquestion').serialize(),

                    success: function (response) {

                        console.log(response);

                        //$("#Btnmybtn").attr('disabled', 'disabled');

                        if (response == 1) {

                            $('#loading').css("display", "none");

                            $("#Btnmybtn").attr('disabled', 'disabled');

                            alert('Added Question Answer Sucessfully.');

                            window.location.href = '';

                        } else if (response == 2) {

                            $('#loading').css("display", "none");

                            $("#Btnmybtn").attr('disabled', 'disabled');

                            alert('Edited Question Answer Sucessfully.');

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

                    url: '<?php echo $web_url;?>admin/querydata.php',

                    data: {action: "GetQuestionAnswer", ID: id},

                    success: function (response) {

                        document.getElementById("FAQ").innerHTML = "EDIT Question Answer";

                        $('#loading').css("display", "none");

                        var json = JSON.parse(response);

                        $('#question').val(json.question);
                        $('#option1').val(json.option1);
                        $('#option2').val(json.option2);
                        $('#option3').val(json.option3);
                        $('#option4').val(json.option4);
                        $('#rightAnswer').val(json.rightAnswer);
                        $('#questionMarks').val(json.questionMarks);

                        $('#action').val('EditQuestion');

                        $('<input>').attr('type', 'hidden').attr('name','questionId').attr('value',json.questionId).attr('id','questionId').appendTo('#frmquestion');

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

                        url: "<?php echo $web_url;?>admin/AjaxQuestionAnswer.php",

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

                    url: "<?php echo $web_url;?>admin/AjaxQuestionAnswer.php",

                    data: {action: 'ListUser', Page: Page, examId: examId},

                    success: function (msg) {

                        $("#PlaceUsersDataHere").html(msg);

                        $('#loading').css("display", "none");

                    },

                });

            }// end of filter

            PageLoadData(1);

                     function enforceNumberValidation(ele) {
    if ($(ele).data('decimal') != null) {
        // found valid rule for decimal
        var decimal = parseInt($(ele).data('decimal')) || 0;
        var val = $(ele).val();
        if (decimal > 0) {
            var splitVal = val.split('.');
            if (splitVal.length == 2 && splitVal[1].length > decimal) {
                // user entered invalid input
                $(ele).val(splitVal[0] + '.' + splitVal[1].substr(0, decimal));
            }
        } else if (decimal == 0) {
            // do not allow decimal place
            var splitVal = val.split('.');
            if (splitVal.length > 1) {
                // user entered invalid input
                $(ele).val(splitVal[0]); // always trim everything after '.'
            }
        }
    }
}

// function checkmarks(){

//     var questionMarks = $("#questionMarks").val();
//     if(questionMarks > 0){
//         return true;
//     } else {
//         $("#questionMarks").val('');
//         alert("Negative Marks not Allowed");
//         return false;
//     }
// }

        </script>

    </body>

</html>