<?php
error_reporting(0);
include('../common.php');
include('IsLogin.php');
$connect = new connect();
include ('User_Paging.php');

if ($_POST['action'] == 'ListUser') {

    $where = "where 1=1 ";

    if ($_POST['strfaq'] != '') {
        $where.=" and  strfaq like '%$_POST[strfaq]%'";
    }

    $filterstr = "SELECT * FROM `faq`  " . $where . " and isDelete='0'  and istatus=1 order by  faqid desc";
    $countstr = "SELECT count(*) as TotalRow FROM `faq`   " . $where . " and isDelete='0' and istatus=1";

    $resrowcount = mysqli_query($dbconn, $countstr);
    $resrowc = mysqli_fetch_array($resrowcount);
    $totalrecord = $resrowc['TotalRow'];
    $per_page = $cateperpaging;
    $total_pages = ceil($totalrecord / $per_page);
    $page = $_REQUEST['Page'] - 1;
    $startpage = $page * $per_page;
    $show_page = $page + 1;



    $filterstr = $filterstr . " LIMIT $startpage, $per_page";
// echo $filterstr;


    $resultfilter = mysqli_query($dbconn, $filterstr);
    if (mysqli_num_rows($resultfilter) > 0) {
        $i = 0;
        ?>  
        <link href="<?php echo $web_url; ?>Employee/assets/global/plugins/datatables/datatables.css" rel="stylesheet" type="text/css" />

        <table class="table table-striped table-bordered table-hover dt-responsive" width="100%" id="tableC">

            <thead class="tbg">
                <tr>
                    <th class="all">
                        No
                    </th>
                    <th class="all">FAQ List</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($rowfilter = mysqli_fetch_array($resultfilter)) {
                    $i++;
                    ?>

                    <tr>
                        <td>
                            <div class="form-group form-md-line-input "><?php echo $i; ?> 
                            </div>

                        </td> 
                        <td>
                            <a href="<?php echo $web_url; ?>Employee/FAQAnnwerDetail.php?token=<?php echo $rowfilter['faqid']; ?>" >
                                <div class="form-group form-md-line-input "><?php echo $rowfilter['strfaq']; ?> 
                                </div>
                            </a>
                        </td> 
                    </tr>

                    <?php
                }
                ?>
                
        </tbody>
        </table>
        <script src="<?php echo $web_url; ?>Employee/assets/global/plugins/datatables/datatables.js" type="text/javascript"></script>
        <script src="<?php echo $web_url; ?>Employee/assets/global/plugins/datatables/table-datatables-responsive.js" type="text/javascript"></script>
        <script>
                                $(document).ready(function () {
                                    $('#tableC').DataTable({
                                    });
                                });
        </script>
        <?php
    } else {
        ?>
        <div class="row">
            <div class="col-lg-12 col-md-12  col-xs-12 col-sm-12 padding-5 bottom-border-verydark">
                <div class="alert alert-info clearfix profile-information padding-all-10 margin-all-0 backgroundDark">
                    <h1 class="font-white text-center"> No Data Found ! </h1>
                </div>   
            </div>
        </div>
        <?php
    }
}
?>
<?php if ($totalrecord > $per_page) { ?>
    <div class="row">
        <div class="col-lg-12 col-md-12  col-xs-12 col-sm-12 padding-5 bottom-border-verydark" style="text-align: center;">
            <div class="form-actions noborder">
                <?php
                echo '<div class="pagination">';
                if ($totalrecord > $per_page) {
                    echo paginate($reload = '', $show_page, $total_pages);
                }
                echo "</div>";
                ?>
            </div>
        </div>
    </div>
<?php } ?>

    

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title><?php echo $ProjectName; ?> | FAQ List </title>
        <?php include_once './include.php'; ?>
    </head>
    <body class="page-container-bg-solid page-boxed">

        <div style="display: none; z-index: 10060;" id="loading">
            <img id="loading-image" src="<?php echo $web_url; ?>Employee/images/loader1.gif">
        </div>
        <div class="page-container">        
            <div class="page-content-wrapper">
                <div class="page-content">
                    <div class="container">
                        <?php $faq = mysqli_fetch_array(mysqli_query($dbconn, "SELECT * FROM `faq` where faqid = " . $_REQUEST['token'] . " and isDelete=0 and istatus=1")); ?>                            
                        <div class='table-responsive'> 
                            <table class='table table-bordered table-hover center table-responsive dt-responsive' width='100%' id='tableC'>
                                <thead>
                                    <tr>    
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
                                                <tr>
                                                    <td valign="center" style="font-size: 15px;" rowspan="<?php echo $strFaqAnswer['cnt'] ?>"><?php echo $strFaqAnswer['strhead'] ?></td>
                                                    <td style="font-size: 15px"><?php echo $strFaqAns['answer'] ?></td>
                                                </tr>
                                            <?php } else { ?>
                                                <tr>
                                                    <td style="font-size: 15px"><?php echo $strFaqAns['answer'] ?></td>
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
    </body>
</html>