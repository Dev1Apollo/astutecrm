<?php
error_reporting(0);

include('../common.php');

include('IsLogin.php');

$connect = new connect();

include ('User_Paging.php');





if ($_POST['action'] == 'ListUser') {

    

    $where = "where 1=1 ";




 $filterstr = "SELECT *, (select empname from employee where employee.employeeid=onlinefeedback.agentId and isDelete=0)as complainByName,

    (select categoryName FROM `feedbackcategory` where isDelete='0' and istatus='1' and feedbackCategoryId=onlinefeedback.feedbackCategoryId)as categoryName

     FROM historyfeedback LEFT JOIN onlinefeedback ON historyfeedback.feedbackId=onlinefeedback.feedbackId WHERE historyfeedback.istatus='1' and historyfeedback.isDelete='0' and historyfeedback.status!=3 ORDER BY historyfeedback.feedbackId";

    $countstr = "SELECT count(*) as TotalRow FROM `onlinefeedback` " . $where . " and isDelete='0' and  istatus='1' ";



    $resrowcount = mysqli_query($dbconn,$countstr);

    $resrowc = mysqli_fetch_array($resrowcount);

    $totalrecord = $resrowc['TotalRow'];

    $per_page = $cateperpaging;

    $total_pages = ceil($totalrecord / $per_page);

    $page = $_REQUEST['Page'] - 1;

    $startpage = $page * $per_page;

    $show_page = $page + 1;







    $filterstr = $filterstr . " LIMIT $startpage, $per_page";

// echo $filterstr;





    $resultfilter = mysqli_query($dbconn,$filterstr);

    if (mysqli_num_rows($resultfilter) > 0) {

        $i = 1;

        ?>  

        <link href="<?php echo $web_url;?>admin/assets/global/plugins/datatables/datatables.css" rel="stylesheet" type="text/css" />

        <link href="<?php echo $web_url;?>admin/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css" rel="stylesheet" type="text/css" />

        <script src="<?php echo $web_url;?>admin/assets/global/plugins/datatables/datatables.js" type="text/javascript"></script>



        <script src="<?php echo $web_url;?>admin/assets/global/plugins/datatables/table-datatables-responsive.js" type="text/javascript"></script>

        <table class="table table-bordered table-hover center table-responsive" width="100%" id="tableC">
            <thead class="tbg">
                <tr style="background: #3f4296;">
                    <th class="all"style="color: #fff;">FeedBack Category</th>
                    <th class="all"style="color: #fff;">Agent Name</th>
                    <th class="all"style="color: #fff;">Comment</th>
                    <th class="none"style="color: #fff;">Feedback date & time</th>
                    <th class="desktop" style="color: #fff;">Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($rowfilter = mysqli_fetch_array($resultfilter)) {
                    ?>
                    <tr>
                        <td>
                            <div class="form-group form-md-line-input "><?php echo $rowfilter['categoryName']; ?> 
                            </div>
                        </td>
                        <td>
                            <div class="form-group form-md-line-input "><?php echo $rowfilter['complainByName']; ?> 
                            </div>
                        </td>
                        <td>
                            <div class="form-group form-md-line-input "><?php echo $rowfilter['comment']; ?> 
                            </div>
                        </td>
                        <td>
                            <div class="form-group form-md-line-input "><?php echo $rowfilter['statusDate']; ?> 
                            </div>
                        </td>
                        <td>
                            <?php
                            if ($rowfilter['status']==2) {
                                $status="Dispute";
                            }elseif($rowfilter['status']==3) {
                               $status="Close";
                            }else{
                                $status="Feedback";
                            }
                            ?>
                            <div class="form-group form-md-line-input "><?php echo $status; ?> 
                            </div>
                        </td>
                        <?php
                    }
                    ?>
                </tr>
            </tbody>
        </table>
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
if ($_REQUEST['action'] == 'Delete') {
    $data = array(
        "isDelete" => '1',
        "strEntryDate" =>date('d-m-Y H:i:s')
    );
    $where = ' where feedbackId=' . $_REQUEST['ID'];
    $dealer_res = $connect->deleterecord($dbconn,'onlinefeedback',$where);
    // $dealer_res = $connect->updaterecord($dbconn,'onlinefeedback', $data, $where);
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

