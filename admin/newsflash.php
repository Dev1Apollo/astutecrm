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
        <title><?php echo $ProjectName; ?> | News</title>
        <?php include_once './include.php'; ?>
           <link href="<?php echo $web_url; ?>admin/assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo $web_url; ?>admin/assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.css" rel="stylesheet" type="text/css" />
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
                                <span>News</span>
                            </li>
                        </ul>

                        <div class="page-content-inner">

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="portlet light ">
                                        <div class="portlet-title">
                                            <div class="caption font-red-sunglo">
                                                <i class="icon-settings font-red-sunglo"></i>
                                                <span class="caption-subject bold uppercase" id="News">Add News</span>
                                            </div>
                                        </div>
                                        <div class="portlet-body form">
                                            <form  role="form"  method="POST"  action="" name="frmparameter"  id="frmparameter" enctype="multipart/form-data">
                                                <input type="hidden" value="AddNews" name="action" id="action">
                                                <div class="form-body">
                                                    <div class="row">
                                                        <div class="style-msg  errormsg col_half">
                                                            <div class="alert alert-success" id="errorDIV" style="display: none;"></div>
                                                        </div>
                                                        <div class="col_half col_last">
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="form_control_1">News</label>
                                                        <input name="news" id="news"  class="form-control" placeholder="Enter Name" required="" type="text">
                                                    </div>
                                                    
                                                    
                                                     <div class="form-group">
                                                        <label for="form_control_1">From Date</label>
                                                        <input type="text" id="from" name="from" class="form-control date-picker" placeholder="Enter The From Date"/>
                                                    </div>
                                                    
                                                     <div class="form-group">
                                                        <label for="form_control_1">To Date</label>
                                                        <input type="text" id="to" name="to" class="form-control date-picker" placeholder="Enter The From Date"/>
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
                                                <span class="caption-subject bold uppercase">List of News</span>
                                            </div>
                                        </div>
                                        <div class="portlet-body form">
                                            <div class="col-md-6 pull-right">
                                                <form  role="form"  method="POST"  action="" name="frmSearch"  id="frmSearch" enctype="multipart/form-data">
                                                    <div class="form-group col-md-9">
                                                        <input type="text" value="" name="Search_Txt" class="form-control" id="Search_Txt" placeholder="Search  Name " required/>

                                                    </div>
                                                    <div class="form-actions  col-md-3">
                                                        <a href="#" class="btn blue pull-right" onclick="PageLoadData(1);">Search</a>
                                                    </div>
                                                </form>
                                            </div>
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
                                                        $(document).ready(function () {
                                                            $("#from").datepicker({
                                                                format: 'dd-mm-yyyy',
                                                                autoclose: true,
                                                                todayHighlight: true,
                                                                defaultDate: "now",
                                                            });
                                                             $("#to").datepicker({
                                                                format: 'dd-mm-yyyy',
                                                                autoclose: true,
                                                                todayHighlight: true,
                                                                defaultDate: "now",
                                                            });
                                                        });
        </script>
        <script src="<?php echo $web_url; ?>admin/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js" type="text/javascript"></script>

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
                        if (response == 1)
                        {
                            $('#loading').css("display", "none");
                            $("#Btnmybtn").attr('disabled', 'disabled');
                            alert('Added Sucessfully.');
                            window.location.href = '';
                        } else if (response == 2)
                        {
                            $('#loading').css("display", "none");
                            $("#Btnmybtn").attr('disabled', 'disabled');
                            alert('Edited Sucessfully.');
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

            function setEditdata(id)
            {
                $('#errorDIV').css('display', 'none');
                $('#errorDIV').html('');
                $('#loading').css("display", "block");
                $.ajax({
                    type: 'POST',
                    url: '<?php echo $web_url;?>admin/querydata.php',
                    data: {action: "GetAdminNews", ID: id},
                    success: function (response) {
                     //   alert(response);
                        document.getElementById("News").innerHTML = "EDIT News";
                        $('#loading').css("display", "none");
                        var json = JSON.parse(response);
                        $('#news').val(json.news);
                         $('#from').val(json.startdate);
                          $('#to').val(json.enddate);
                        $('#action').val('EditNews');
                        $('<input>').attr('type', 'hidden').attr('name', 'newflashid').attr('value', json.newflashid).attr('id', 'newflashid').appendTo('#frmparameter');
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
                        url: "<?php echo $web_url;?>admin/Ajaxnewsflash.php",
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
                    url: "<?php echo $web_url;?>admin/Ajaxnewsflash.php",
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