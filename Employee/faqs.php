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
        <title><?php echo $ProjectName; ?> | Knowledge Tree </title>
        <?php include_once './include.php'; ?>
    </head>
    <!-- END HEAD -->
    <body class="page-header-fixed page-sidebar-closed-hide-logo page-content-white page-md">
        <div class="page-wrapper">
            <?php include_once './header.php'; ?>
            <div style="display: none; z-index: 10060;" id="loading">
                <img id="loading-image" src="<?php echo $web_url; ?>Employee/images/loader.gif">
            </div>
            <!-- END SIDEBAR -->
            <!-- BEGIN CONTENT -->
            <div class="page-content-wrapper">
                <!-- BEGIN CONTENT BODY -->
                <div class="page-content">
                    <div class="page-bar">
                        <ul class="page-breadcrumb">
                            <li>
                                <a href="index.php">Home</a>
                                <i class="fa fa-circle"></i>
                            </li>
                            <li>
                                <span>Knowledge Tree</span>
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
                    <!-- END DASHBOARD STATS 1-->
                    <div class="portlet light ">
                        <div class="portlet-title">
                            <div class="caption font-red-sunglo">
                                <span class="caption-subject bold uppercase">Search Knowledge Tree</span>
                            </div>
                        </div>
                        <div class="portlet-body form">
                            <form  role="form"  method="POST"  action="" name="frmparameter"  id="frmparameter" enctype="multipart/form-data">
                                <div class="form-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group col-md-3">
                                                <label for="form_control_1">Language</label>
<!--                                                <input name="language" id="language" class="form-control"  placeholder="Enter Your Question" type="text" >-->
                                                <select id="language" name="language" class="form-control">
                                                    <option value="">Select Language</option>
                                                    <?php
                                                        $filterLanguage = mysqli_query($dbconn, "Select * from language where iStatus='1' and isDelete='0' order by language asc");
                                                        while($rowLanguage = mysqli_fetch_array($filterLanguage)){
                                                            echo "<option value='".$rowLanguage['languageid']."'>".$rowLanguage['language']."</option>";
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="form_control_1">FAQ</label>
                                                <input name="strfaq" id="strfaq" class="form-control"  placeholder="Enter Your Question" type="text" >
                                            </div>
                                            <div class="form-group col-md-3">
                                                <a class="btn blue margin-top-20"  onclick="PageLoadData(1);">Search</a>
                                                <button type="button" class="btn blue margin-top-20" onClick="return checkClear();">Clear</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="portlet light " style="" id="SLID">
                        <div class="portlet-title">
                            <div class="caption font-red-sunglo">
                                <i class="icon-settings font-red-sunglo"></i>
                                <span class="caption-subject bold uppercase">List of Knowledge Tree</span>
                            </div>
                        </div>
                        <div class="portlet-body form">
                            <div id="PlaceUsersDataHere"> 
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END CONTENT BODY -->
            </div>
            <!-- END CONTENT -->
            <!-- BEGIN QUICK SIDEBAR -->
            <a href="javascript:;" class="page-quick-sidebar-toggler">
                <i class="icon-login"></i>
            </a>
            <!-- END QUICK SIDEBAR -->
        </div>
        <!-- END CONTAINER -->
        <!-- BEGIN FOOTER -->
        <?php include_once './footer.php'; ?>
        <!-- END FOOTER -->
    </div>
    <!-- BEGIN CORE PLUGINS -->
    <?php include_once './footerjs.php'; ?>
    <script type="text/javascript">

        function checkClear() {
            $('#strfaq').val('');
            return false;
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
                    url: "<?php echo $web_url; ?>Employee/AjaxFAQList.php",
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
            var strfaq = $('#strfaq').val();
            var language = $('#language').val();
            $('#loading').css("display", "block");
            $.ajax({
                type: "POST",
                url: "<?php echo $web_url; ?>Employee/AjaxFAQList.php",
                data: {action: 'ListUser', Page: Page, language: language,strfaq: strfaq},
                success: function (msg) {
                    $('#SLID').show();
                    $('#loading').css("display", "none");
                    $("#PlaceUsersDataHere").html(msg);
                },
            });
        }// end of filter
        PageLoadData(1);

    </script>
</body>

</html>