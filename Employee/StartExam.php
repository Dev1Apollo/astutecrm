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
        <title><?php echo $ProjectName; ?> | Start Exam </title>
        <?php include_once './include.php'; ?>
        <link href="<?php echo $web_url; ?>Employee/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo $web_url; ?>Employee/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.css" rel="stylesheet" type="text/css" />
        <style type="text/css">
            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box
            }

            body {
                background-color: #333
            }

            .container {
                /*background-color: #555;*/
                background-color: #fff;
                /*color: #ddd;*/
                color: #4e4e4e;
                border-radius: 10px;
                padding: 20px;
                font-family: 'Montserrat', sans-serif;
                /*max-width: 700px*/
                max-width: 90%
            }

            .container>p {
                font-size: 32px
            }

            .question {
                width: 75%
            }

            .options {
                position: relative;
                padding-left: 40px
            }

            #options label {
                display: block;
                margin-bottom: 15px;
                font-size: 14px;
                cursor: pointer
            }

            .options input {
                opacity: 0
            }

            .checkmark {
                position: absolute;
                top: -1px;
                left: 0;
                height: 25px;
                width: 25px;
                /*background-color: #555;*/
                background-color: #fff;
                /*border: 1px solid #ddd;*/
                border: 1px solid #525252;
                border-radius: 50%
            }

            .options input:checked~.checkmark:after {
                display: block
            }

            .options .checkmark:after {
                content: "";
                width: 10px;
                height: 10px;
                display: block;
                background: white;
                position: absolute;
                top: 50%;
                left: 50%;
                border-radius: 50%;
                transform: translate(-50%, -50%) scale(0);
                transition: 300ms ease-in-out 0s
            }
            label {
                color: #4e4e4e !important;
                font-size: 11px !important;
            }
            .options input[type="radio"]:checked~.checkmark {
                background: #21bf73;
                transition: 300ms ease-in-out 0s
            }

            .options input[type="radio"]:checked~.checkmark:after {
                transform: translate(-50%, -50%) scale(1)
            }

            .btn-primary {
                background-color: #555;
                color: #ddd;
                border: 1px solid #ddd
            }

            .btn-primary:hover {
                background-color: #21bf73;
                border: 1px solid #21bf73
            }

            .btn-success {
                padding: 5px 25px;
                background-color: #21bf73
            }

            @media(max-width:576px) {
                .question {
                    width: 100%;
                    word-spacing: 2px
                }
            }
        </style>
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
                                <span>Exam </span>
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
                        <div class="portlet-title">
                            <div class="caption font-red-sunglo">
                                <span class="caption-subject bold uppercase">Exam Question</span>
                            </div>
                        </div>
                        <div class="portlet-body form">
                            <div class="row">
                                <input type="hidden" name="token" id="token" value="<?= $_REQUEST['token']?>">
                                <div id="PlaceUsersDataHere">
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
    <script src="<?php echo $web_url; ?>Employee/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js" type="text/javascript"></script>

    <script type="text/javascript">

    $(function () {
        if ($("#option1").is(":checked")) {
           alert($("#option1").is(":checked"));
        }
    });
    function ValidateCheck()
    {
        var tStatus =false;
        if ($("#option1").is(":checked")) {
         tStatus=true;
        }
        if ($("#option2").is(":checked")) {
         tStatus=true;
        }
        if ($("#option3").is(":checked")) {
         tStatus=true;
        }
        if ($("#option4").is(":checked")) {
         tStatus=true;
        }
        if(tStatus ==false)
        {
            alert('Sorry, you cannot skip the question.');
        }
        return tStatus;
    }
    function ExamPageLoadData(Page) {
        var tStatus =true;
        if(Page > 1)
        {
            tStatus=ValidateCheck();
        }
        if(tStatus)
        {
        var token = $("#token").val();
        $('#loading').css("display", "block");
        $.ajax({
            type: "POST",
            url: "<?php echo $web_url; ?>Employee/AjaxStartExam.php",
            data: {action: 'ListUser', Page: Page,token: token},
            success: function (msg) {
                $('#SLID').show();
                $('#loading').css("display", "none");
                $("#PlaceUsersDataHere").html(msg);
            }
        });
        }
    }
    ExamPageLoadData(1);

    function setAnswer(questionId,examId,AnsVal){
        //$('#loading').css("display", "block");
        $.ajax({
            type: "POST",
            url: "<?php echo $web_url; ?>Employee/AjaxStartExam.php",
            data: {action: 'SubmitQuestionsAnswer', questionId: questionId,examId: examId,AnsVal:AnsVal},
            success: function (msg) {
                if(msg == 2){
                    alert("Sorry,Time Out.");
                    window.location.href="Exam.php";
                } else {
                    //alert("Invaild Request.");
                    //$('#loading').css("display", "none");
                    //window.location.href="<?php echo $web_url; ?>Employee/StartExam.php?token="+examId;
                }
            }
        });
    }
    

    function FinalSubmit(examId){
        $('#loading').css("display", "block");
        $.ajax({
            type: "POST",
            url: "<?php echo $web_url; ?>Employee/AjaxStartExam.php",
            data: {action: 'FinalSubmit',examId: examId},
            success: function (msg) {
                if(msg > 0){
                    alert("Exam Sumbitted Successfully.");
                    window.location.href="<?php echo $web_url; ?>Employee/Exam.php";
                } else {
                    alert("Invaild Request.");
                    window.location.href="<?php echo $web_url; ?>Employee/StartExam.php?token="+examId;
                }
                $('#loading').css("display", "none");
                //$("#PlaceUsersDataHere").html(msg);
            }
        });
    }
    </script>   

</body>
</html>