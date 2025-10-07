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
                                <span> List of FAQ Answer</span>
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
                    <div class="portlet light " style="" id="SLID">
                        <div class="portlet-title">
                            <div class="caption font-red-sunglo">
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
</body>
</html>