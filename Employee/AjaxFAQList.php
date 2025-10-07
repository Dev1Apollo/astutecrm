<?php

error_reporting(0);

include('../common.php');

include('IsLogin.php');

$connect = new connect();

include ('User_Paging.php');



if ($_POST['action'] == 'ListUser') {



    $where = " 1=1 ";



    if ($_POST['strfaq'] != '') {

        $where.=" and  strfaq like '%$_POST[strfaq]%'";

    }

    if ($_POST['language'] != '') {

        $where.=" and  language = '$_POST[language]'";

    }



    $filterstr = "SELECT * FROM `faq` where " . $where . " and isDelete='0'  and istatus=1 order by  faqid desc";

    $countstr = "SELECT count(*) as TotalRow FROM `faq` where  " . $where . " and isDelete='0' and istatus=1";



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

                    <th class="pop_in_heading">No</th>

                    <th class="pop_in_heading">Knowledge Tree</th>

                </tr>

            </thead>

            <tbody>

                <?php

                while ($rowfilter = mysqli_fetch_array($resultfilter)) {

                    $i++;

                    ?>

                    <tr>

                        <td><?php echo $i; ?> 

<!--                            <div class="form-group form-md-line-input ">

                            </div>-->

                        </td> 

                        <td>

                            <a href="<?php echo $web_url; ?>Employee/faq_answer_detail.php?token=<?php echo $rowfilter['faqid']; ?>" ><?php echo $rowfilter['strfaq']; ?>

<!--                                <div class="form-group form-md-line-input "> 

                                </div>-->

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