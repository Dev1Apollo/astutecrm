<?php
error_reporting(0);
include('../common.php');
include('IsLogin.php');
$connect = new connect();
include ('User_Paging.php');

if ($_POST['action'] == 'ListUser') {
    $where = "where 1=1 ";

    if ($_POST['PinCode'] != '') {
        $where.=" and  pincode='" . $_POST['PinCode'] . "'";
    }
//    if ($_POST['Partner'] != '') {
//        $where.=" and  partner like '%$_POST[Partner]%'";
//    }
//    if ($_POST['City'] != '') {
//        $where.=" and  city like '%$_POST[City]%'";
//    }
//    if ($_POST['State'] != '') {
//        $where.=" and  state like '%$_POST[State]%'";
//    }
//    if ($_POST['Zone'] != '') {
//        $where.=" and  zone like '%$_POST[Zone]%'";
//    }
//    if ($_POST['StoreName'] != '') {
//        $where.=" and  storeName like '%$_POST[StoreName]%'";
//    }
//    if ($_POST['SOName'] != '') {
//        $where.=" and  SOname like '%$_POST[SOName]%'";
//    }
//    if ($_POST['ASM'] != '') {
//        $where.=" and  ASM  like '%$_POST[ASM]%'";
//    }
//    if ($_POST['ContactNumber'] != '') {
//        $where.=" and  contactNumber like '%$_POST[ContactNumber]%'";
//    }
    if ($_POST['Address'] != '') {
        $where.=" and  address like '%$_POST[Address]%'";
    }

    $filterstr = "SELECT * FROM `storelist`  " . $where . " and isDelete='0'  order by  storeListId desc";
    $countstr = "SELECT count(*) as TotalRow FROM `storelist`   " . $where . " and isDelete='0'  order by  storeListId desc";

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
        <link href="<?php echo $web_url; ?>Employee/assets/global/plugins/datatables/datatables.css" rel="stylesheet" type="text/css" />
        <div class="table-responsive">
        <table class="table table-striped table-bordered table-hover dt-responsive" width="100%" id="tableC">
            <thead class="tbg">
                <tr>
                    <th class="pop_in_heading">PIN Code</th>
                    <th class="pop_in_heading">Circle</th>
                     <th class="pop_in_heading">CITY</th>
                    <th class="pop_in_heading">STATE</th>
                   
                    <th class="pop_in_heading">Retailer Number</th>
                    <th class="pop_in_heading">Shop Name</th>
                    <th class="pop_in_heading">Full Address</th>
<!--                    <th class="pop_in_heading">SO Name</th>
                    <th class="pop_in_heading">ASM</th>
                    <th class="pop_in_heading">Contact Number</th>
                    <th class="pop_in_heading">Entry Date</th>-->
                </tr>
            </thead>
            <tbody>
                <?php
                while ($rowfilter = mysqli_fetch_array($resultfilter)) {
                    ?>
                   <tr>
                        <td><?php echo $rowfilter['pincode']; ?> 
                        </td> 
                        <td>
                            <?php echo $rowfilter['partner']; ?> 
                        </td>
                     
                        <td>
                            <?php echo $rowfilter['state']; ?> 
                        </td>
                           <td>
                            <?php echo $rowfilter['city']; ?> 
                        </td> 
                        <td>
                            <?php echo $rowfilter['zone']; ?> 
                        </td> 
                        <td>
                            <?php echo $rowfilter['address']; ?> 
                        </td> 
                        <td>
                            <?php echo $rowfilter['storeName']; ?> 
                        </td> 
<!--                        <td>
                            <?php echo $rowfilter['SOname']; ?> 
                        </td> 
                        <td>
                            <?php echo $rowfilter['ASM']; ?> 
                        </td>
                        <td>
                            <?php echo $rowfilter['contactNumber']; ?> 
                        </td>
                        <td>
                            <?php echo $rowfilter['strEntryDate']; ?> 
                        </td>-->
                        <?php
                    }
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
    $dealer_res = $connect->updaterecord($dbconn,'storelist', $data, $where);
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
    function CheckAll()
    {
        if ($('#check_listall').is(":checked"))
        {
            // alert('cheked');
            $('input[type=checkbox]').each(function () {
                $(this).prop('checked', true);
            });
        } else
        {
            //alert('cheked fail');
            $('input[type=checkbox]').each(function () {
                $(this).prop('checked', false);
            });
        }
    }
</script>  

