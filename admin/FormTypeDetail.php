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
        <title><?php echo $ProjectName; ?> | Form Type Detail</title>
        <?php include_once './include.php'; ?>
    </head>
    <body class="page-container-bg-solid page-boxed">
        <?php include_once './header.php'; ?>
        <div style="display: none; z-index: 10060;" id="loading">
            <img id="loading-image" src="<?php echo $web_url; ?>admin/images/loader1.gif">
        </div>
        <div class="page-container">        
            <div class="page-content-wrapper">
                <!--                <div class="page-head">
                                    <div class="container">
                                        <div class="page-title">
                                            <h1>Dashboard
                                                <small>dashboard</small>
                                            </h1>
                                        </div>                    
                                    </div>
                                </div>-->
                <div class="page-content">
                    <div class="container">
                        <ul class="page-breadcrumb breadcrumb">
                            <li>
                                <a href="<?php echo $web_url; ?>admin/index.php">Home</a>
                                <i class="fa fa-circle"></i>
                            </li>
                            <li>
                                <a href="<?php echo $web_url; ?>admin/ExcelFormMaster.php">Form Type</a>
                                <i class="fa fa-circle"></i>
                            </li>
                            <li>
                                <span>Form Type Detail</span>
                            </li>
                        </ul>

                        <div class="page-content-inner">

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="portlet light ">
                                        <div class="portlet-title">
                                            <div class="caption font-red-sunglo">
                                                <i class="icon-settings font-red-sunglo"></i>
                                                <span class="caption-subject bold uppercase" id="editFormType">Add Form Type Detail</span>
                                            </div>
                                        </div>
                                        <div class="portlet-body form">
                                            <form  role="form"  method="POST"  action="" name="frmparameter"  id="frmparameter" enctype="multipart/form-data">
                                                <input type="hidden" value="AddFormTypeDetail" name="action" id="action">
                                                <input type="hidden" value="<?php echo $_REQUEST['token']; ?>" name="formId" id="formId">
                                                <div class="form-body">

                                                    <div class="form-group">
                                                        <label for="form_control_1">Excel Column Name</label>
                                                        <input type="text"  id="excelColumnName"  name="excelColumnName" class="form-control" placeholder="Enter the Excel Column Name" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="form_control_1">Database Column Name</label>
                                                        <select  id="dbColumnName"  name="dbColumnName" class="form-control" placeholder="Enter the Database Column Name" required>
                                                            <option value=''>Select Database Column</option>
                                                            <option value='date'>date</option>
                                                            <option value='elisionloginid'>elisionloginid</option>
                                                            <option value='Attendance'>Attendance</option>
                                                            <option value='LoginTime'>LoginTime</option>
                                                            <option value='LogoutTime'>LogoutTime</option>
                                                            <option value='Loginhour'>Loginhour</option>
                                                            <option value='TalkTime'>TalkTime</option>
                                                            <option value='PauseTime'>PauseTime</option>
                                                            <option value='ConnectCall'>ConnectCall</option>
                                                            <option value='PU_PTP'>PU_PTP</option>
                                                            <option value='DG_PTP'>DG_PTP</option>
                                                            <option value='WK_PTP'>WK_PTP</option>
                                                            <option value='PU_Conv'>PU_Conv</option>
                                                            <option value='DG_Conv'>DG_Conv</option>
                                                            <option value='WK_Conv'>WK_Conv</option>
                                                            <option value='PU_Conv_per'>PU_Conv_per</option>
                                                            <option value='DG_Conv_per'>DG_Conv_per</option>
                                                            <option value='WK_Conv_per'>WK_Conv_per</option>
                                                            <option value='PenalCollected'>PenalCollected</option>
                                                     </select>
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
                                                <span class="caption-subject bold uppercase">List of Form Type Detail</span>
                                            </div>
                                        </div>
                                        <div class="portlet-body form">
                                            <div class="col-md-6 pull-left"><?php
                                                $form = mysqli_fetch_array(mysqli_query($dbconn,"SELECT * FROM `formtype`  where   formId='" . $_REQUEST['token'] . "'"));
                                                echo 'Form Type:<strong>' . $form['formName'] . '</strong>';
                                                ?></div>
                                            <div class="col-md-6 pull-right">
                                                <form  role="form"  method="POST"  action="" name="frmSearch"  id="frmSearch" enctype="multipart/form-data">
                                                    <div class="form-group col-md-9">
                                                        <input type="text" value="" name="Search_Txt" class="form-control" id="Search_Txt" placeholder="Search Excel Column Name" required/>

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




            function checkclose() {
                window.location.href = '<?php echo $web_url; ?>admin/ExcelFormMaster.php';
            }



            $('#frmparameter').submit(function (e) {

                e.preventDefault();
                var $form = $(this);
                $('#loading').css("display", "block");
                $.ajax({
                    type: 'POST',
                    url: '<?php echo $web_url; ?>admin/querydata.php',
                    data: $('#frmparameter').serialize(),
                    success: function (response) {
                        console.log(response);
                        //$("#Btnmybtn").attr('disabled', 'disabled');
                        if (response == 1)
                        {
                            $('#loading').css("display", "none");
                            $("#Btnmybtn").attr('disabled', 'disabled');
                            alert(' Added Sucessfully.');
                            window.location.href = '';
                        } else if (response == 2)
                        {
                            $('#loading').css("display", "none");
                            $("#Btnmybtn").attr('disabled', 'disabled');
                            alert(' Edited Sucessfully.');
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
                    url: '<?php echo $web_url; ?>admin/querydata.php',
                    data: {action: "GetAdminFormTypeDetail", ID: id},
                    success: function (response) {
                        document.getElementById("editFormType").innerHTML = "EDIT Form Type Detail";
                        $('#loading').css("display", "none");
                        var json = JSON.parse(response);
                        $('#excelColumnName').val(json.excelColumnName);
                        $('#dbColumnName').val(json.dbColumnName);
                        $('#action').val('EditFormTypeDetail');
                        $('<input>').attr('type', 'hidden').attr('name', 'formDetailId').attr('value', json.formDetailId).attr('id', 'formDetailId').appendTo('#frmparameter');
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
                        url: "<?php echo $web_url; ?>admin/AjaxFormTypeDetail.php",
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
                var formId = $('#formId').val();

                $('#loading').css("display", "block");
                $.ajax({
                    type: "POST",
                    url: "<?php echo $web_url; ?>admin/AjaxFormTypeDetail.php",
                    data: {action: 'ListUser', Page: Page, Search_Txt: Search_Txt, formId: formId},
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
