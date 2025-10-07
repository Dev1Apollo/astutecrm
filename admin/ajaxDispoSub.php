<?php
error_reporting(0);
include('../common.php');
include('IsLogin.php');
$connect = new connect();
include ('User_Paging.php');


if ($_POST['action'] == 'ListUser') {
    $where = "where 1=1 ";
    if (isset($_REQUEST['Search_Txt'])) {
        if ($_POST['Search_Txt'] != '') {

            $where.=" and  dispoDesc like '%".trim($_POST[Search_Txt])."%'";
        }
    }

    $filterstr = "SELECT *,(select dispoDesc from dispositionmaster where dispositionmaster.iDispoId=a.masterDispoId) as `masterDispo` FROM `dispositionmaster` as `a`  " . $where . " and a.masterDispoId!=0 order by  a.iDispoId desc";
    $countstr = "SELECT count(*) as TotalRow FROM `dispositionmaster` " . $where . " and masterDispoId!=0 ";

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
        <table class="table table-bordered table-hover center table-responsive" width="100%" id="tableC">
            <thead class="tbg">
                <tr>


                    <th class="all">Disposition Type</th>
                   <th class="none">Mian Disposition</th>
                   <th class="none">Sub Disposition</th>
                    
                    <th class="desktop">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($rowfilter = mysqli_fetch_array($resultfilter)) {
                    ?>
                    <tr>
                        <td>
                            <div class="form-group form-md-line-input "><?php  echo $rowfilter['dispoType']=1?'Connect':'Not Connect'; ?> 
                            </div>
                        </td>
                        <td>
                            <div class="form-group form-md-line-input "><?php  echo $rowfilter['masterDispo']; ?> 
                            </div>
                        </td>
                        <td>
                            <div class="form-group form-md-line-input "><?php  echo $rowfilter['dispoDesc']; ?> 
                            </div>
                        </td>
                    

                        <td>
                            <div class="form-group form-md-line-input "> 

                                <a class="btn blue" onClick="javascript: return setEditdata('<?php echo $rowfilter['iDispoId']; ?>');"  title="Edit"><i class="fa fa-edit iconshowFirst"></i></a> 

                                <a  class="btn blue" onClick="javascript: return deletedata('Delete', '<?php echo $rowfilter['iDispoId']; ?>');"   title="Delete"><i class="fa fa-trash-o iconshowFirst"></i></a>
                            </div>
                        </td>

                        <?php
                    }
                    ?>

                </tr>
            </tbody>
        </table>
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
    $connect->deleterecord($dbconn,"dispositionmaster"," where iDispoId=".$_REQUEST['ID']);
}
?>