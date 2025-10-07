<?php
error_reporting(0);
include('../common.php');
include('IsLogin.php');
$connect = new connect();
include ('User_Paging.php');


if ($_POST['action'] == 'ListUser') {

    $where = "where 1=1 ";

    if ($_POST['PinCode'] != '') {
        $where.=" and  pincode='" . trim($_POST['PinCode']) . "'";
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
        $where.=" and strAdress like '%". trim($_POST[Address])."%'";
    }


    $filterstr = "SELECT * FROM `axisbankbranch`  " . $where . " and isDelete='0'  order by  iAxisBankBranchId desc";
    $countstr = "SELECT count(*) as TotalRow FROM `axisbankbranch`   " . $where . " and isDelete='0'";


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
        $i = 1;
        ?>  
        <link href="<?php echo $web_url; ?>admin/assets/global/plugins/datatables/datatables.css" rel="stylesheet" type="text/css" />
        <table class="table table-striped table-bordered table-hover dt-responsive" width="100%" id="tableC">
            <thead class="tbg">
                <tr>
                    <th></th>
                    <th class="desktop">State</th>      
                    <th class="desktop">District</th>
                    <th class="desktop">Pin Code</th>       
                    <th class="desktop">Branch Name</th>
                    <th class="desktop">Address</th>
                    <th class="none">Entry Date</th>
                    <th class="desktop">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($rowfilter = mysqli_fetch_array($resultfilter)) {
                    ?>
                    <tr>
                        <td></td>
                        <td>
                            <div class="form-group form-md-line-input "><?php echo $rowfilter['strState']; ?> 
                            </div>
                        </td> 
                        <td>
                            <div class="form-group form-md-line-input "><?php echo $rowfilter['strDistrict']; ?> 
                            </div>
                        </td>
                        <td>
                            <div class="form-group form-md-line-input "><?php echo $rowfilter['pincode']; ?> 
                            </div>
                        </td> 

                        <td>
                            <div class="form-group form-md-line-input "><?php echo $rowfilter['strBranchName']; ?> 
                            </div>
                        </td>
                        <td>
                            <div class="form-group form-md-line-input "><?php echo $rowfilter['strAdress']; ?> 
                            </div>
                        </td> 
                        <td>
                            <div class="form-group form-md-line-input "><?php echo $rowfilter['strEntryDate']; ?> 
                            </div>
                        </td> 
                        <td style="width: 20%">
                            <div class="form-group form-md-line-input">
                                <a  class="btn blue" href="<?php echo $web_url; ?>admin/EditAxisBankBranch.php?token=<?php echo $rowfilter['iAxisBankBranchId']; ?>" title="Edit"><i class="fa fa-edit iconshowFirst"></i></i></a>
                                <a  class="btn blue" onClick="javascript: return deletedata('Delete', '<?php echo $rowfilter['iAxisBankBranchId']; ?>');"   title="Delete"><i class="fa fa-trash-o iconshowFirst"></i></a>
                            </div>
                        </td>

                        <?php
                    }
                    ?>

                </tr>
            </tbody>
        </table>
        <script src="<?php echo $web_url; ?>admin/assets/global/plugins/datatables/datatables.js" type="text/javascript"></script>
        <script src="<?php echo $web_url; ?>admin/assets/global/plugins/datatables/table-datatables-responsive.js" type="text/javascript"></script>
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



<?php

function rrmdir($dir) {
    if (is_dir($dir)) {
        $objects = scandir($dir);
        foreach ($objects as $object) {
            if ($object != "." && $object != "..") {
                if (filetype($dir . "/" . $object) == "dir")
                    rrmdir($dir . "/" . $object);
                else
                    unlink($dir . "/" . $object);
            }
        }
        reset($objects);
        rmdir($dir);
    }
}
?>								  

