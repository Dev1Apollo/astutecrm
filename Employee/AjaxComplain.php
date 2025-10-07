<?php
error_reporting(E_ALL);
include('../common.php');
include('IsLogin.php');
$connect = new connect();
include ('User_Paging.php');

if ($_POST['action'] == 'ListUser') {
    $where = "where 1=1 ";
    
    $filterstr = "SELECT *,(select categoryName FROM `ticketcategory` where isDelete='0' and istatus='1' and ticketCategoryId =complainticket.ticketCategoryId )as categoryName from complainticket where complainBy='".$_SESSION['EmployeeId']."' and istatus='1' and isDelete='0' and ticketStatus='0' order by ticketId desc";
    $countstr = "SELECT count(*) as TotalRow FROM complainticket where complainBy='".$_SESSION['EmployeeId']."' and istatus='1' and isDelete='0'";

    $resrowcount = mysqli_query($dbconn, $countstr);
    $resrowc = mysqli_fetch_array($resrowcount);
    $totalrecord = $resrowc['TotalRow'];
    $per_page = $cateperpaging;
    $total_pages = ceil($totalrecord / $per_page);
    $page = $_REQUEST['Page'] - 1;
    $startpage = $page * $per_page;
    $show_page = $page + 1;

    $filterstr = $filterstr . " LIMIT $startpage, $per_page";
    $resultfilter = mysqli_query($dbconn, $filterstr);

    if (mysqli_num_rows($resultfilter) > 0) {
        $i = 1;
        ?>  
        <link href="<?php echo $web_url; ?>Employee/assets/global/plugins/datatables/datatables.css" rel="stylesheet" type="text/css" />
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover dt-responsive" width="100%" id="tableC">
                <thead class="tbg">
                    <tr>
                        <th class="pop_in_heading">Sr NO.</th>
                        <th class="pop_in_heading">Ticket Category </th>
                        <th class="pop_in_heading">Ticket Id </th>
                        <th class="pop_in_heading">Floor Asset</th>
                        <th class="pop_in_heading">Complain</th>
                        <th class="pop_in_heading">Complain Date & Time</th>
                        <th class="pop_in_heading">Status</th>
                   

                        <!-- <th class="pop_in_heading">Exam End Time</th>
                        <th class="pop_in_heading">Exam Mark</th>
                        <th class="pop_in_heading">Exam Passing Marks</th> -->
                        <!-- <th class="pop_in_heading">Action</th> -->
                    </tr>
                </thead>
                <tbody>
                    <?php
                     $i=1;
                     while ($rowfilter = mysqli_fetch_array($resultfilter)) {
                        ?>
                        <tr>
                            <td>
                                <div class="form-group form-md-line-input "><?php echo $i;?> 
                                 </div>
                            </td> 
                            <td>
                                <?php echo $rowfilter['categoryName']; ?>
                            </td>
                            <td>
                                <?php echo $rowfilter['ticketId']; ?>
                            </td>
                            <td>
                                <?php echo $rowfilter['floorAsset']; ?>
                            </td> 
                            <td>
                                <div class="form-group form-md-line-input "><?php echo $rowfilter['complainText']; ?> 
                                </div>
                            </td> 
                            <td>
                                <div class="form-group form-md-line-input "><?php echo $rowfilter['complainDate']; ?> 
                                </div>
                            </td> 
                            <?php 
                            if ($rowfilter['ticketStatus']==0) {
                                $ticketStatus="Open";
                            }else{
                                $ticketStatus="Close";

                            }
                                $ticketStatus;
                            ?>
                            <td>
                                <div class="form-group form-md-line-input "><?php echo $ticketStatus; ?> 
                                </div>
                            </td> 

                            <?php
                        $i++; }
                        ?>
                    </tr>
                </tbody>
            </table>
        </div>
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
if ($_REQUEST['action'] == 'Delete') {
    $data = array(
        "isDelete" => '1',
        "strEntryDate" => date('d-m-Y H:i:s')
    );
    $where = ' where  	storeListId=' . $_REQUEST['ID'];
    $dealer_res = $connect->updaterecord($dbconn, 'storelist', $data, $where);
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
<script type="text/javascript">
    
</script>  