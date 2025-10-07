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
        <title><?php echo $ProjectName; ?> | FAQ Answer List </title>
        <?php include_once './include.php'; ?>
    </head>
    <body class="page-container-bg-solid page-boxed">
        <?php include_once './header.php'; ?>
        <div style="display: none; z-index: 10060;" id="loading">
            <img id="loading-image" src="<?php echo $web_url; ?>Employee/images/loader1.gif">
        </div>
        <div class="page-container">        
            <div class="page-content-wrapper">
                <div class="page-content">
                    <div class="container">
                        <ul class="page-breadcrumb breadcrumb">
                            <li>
                                <a href="<?php echo $web_url; ?>Employee/index.php">Home</a>
                                <i class="fa fa-circle"></i>
                            </li>
                            <li>
                                <span>FAQ Answer List</span>
                            </li>
                        </ul>
                        <div class="page-content-inner">
                            <div class="col-md-12">

                                <div class="portlet light " style="display: none;" id="SLID">
                                    <div class="portlet-title">
                                        <div class="caption font-red-sunglo">
                                            <i class="icon-settings font-red-sunglo"></i>
                                            <span class="caption-subject bold uppercase">List of FAQ Answer</span>
                                        </div>
                                        <a href="javascript: history.go(-1)" class="btn blue pull-right" title="back">Go Back</a>
                                    </div>
                                    <div class="portlet-body form">
                                        <?php $faq = mysqli_fetch_array(mysqli_query($dbconn, "SELECT * FROM `faq` where faqid = " . $_REQUEST['token'] . " and isDelete=0 and istatus=1")); ?>                            
                                        <div class='table-responsive'> 
                                            <table style="border: 1px solid navy;" class='table table-bordered table-hover center table-responsive dt-responsive' width='100%' id='tableC'>
                                                <thead>
                                                    <tr style="border: 1px solid navy;">    
                                                        <th colspan="2" class="col-md-12 pop_in_heading"><?php echo $faq['strfaq']; ?></th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    <?php
                                                    $faqAnswer = mysqli_query($dbconn, "SELECT faqheadid,count(*)as cnt,(select faqanswerhead.strhead from faqanswerhead where faqanswerhead.faqanswerheadid = faqanswer.faqheadid) as strhead FROM `faqanswer` where faqid=" . $_REQUEST['token'] . " and isDelete=0 and istatus=1 group by faqheadid order by faqanswer.faqanswerid asc");

                                                    while ($strFaqAnswer = mysqli_fetch_array($faqAnswer)) {
                                                        //$faqHead = mysqli_fetch_array(mysqli_query($dbconn, "SELECT count(*) as cnt, strhead,faqanswerheadid FROM `faqanswerhead` where faqanswerheadid=" . $strFaqAnswer['faqheadid'] . " ORDER BY faqanswerheadid desc"));
                                                        ?>

                                                        <?php
                                                        $faqAns = mysqli_query($dbconn, "SELECT answer FROM `faqanswer` where faqheadid=" . $strFaqAnswer['faqheadid'] . "  and faqid=" . $_REQUEST['token'] . " and isDelete=0 and istatus=1 ");
                                                        $jCounter = 0;
                                                        while ($strFaqAns = mysqli_fetch_array($faqAns)) {
                                                            if ($jCounter == 0) {
                                                                ?>
                                                                <tr style="border: 1px solid navy;">
                                                                    <td valign="center" style="font-size: 15px; border: 1px solid navy; " rowspan="<?php echo $strFaqAnswer['cnt'] ?>"><strong><?php echo $strFaqAnswer['strhead'] ?></strong></td>
                                                                    <td style="font-size: 15px; border: 1px solid navy;"><?php echo $strFaqAns['answer'] ?></td>
                                                                </tr>
                                                            <?php } else { ?>
                                                                <tr style="border: 1px solid navy;">
                                                                    <td style="font-size: 15px; border: 1px solid navy;"><?php echo $strFaqAns['answer'] ?></td>
                                                                </tr>
                                                            <?php } ?>
                                                            <?php
                                                            $jCounter++;
                                                        }
                                                    }
                                                    ?>

                                                </tbody>
                                            </table>
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
                        url: "<?php echo $web_url; ?>Employee/AjaxFAQAnswerDetail.php",
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
//                var strfaq = $('#strfaq').val();
                $('#loading').css("display", "block");
                $.ajax({
                    type: "POST",
                    url: "<?php echo $web_url; ?>Employee/AjaxFAQAnswerDetail.php",
                    data: {action: 'ListUser', Page: Page},
                    success: function (msg) {
                        $('#SLID').show();
                        $("#PlaceUsersDataHere").html(msg);
                        $('#loading').css("display", "none");
                    },
                });
            }// end of filter
            PageLoadData(1);



        </script>
    </body>
</html>