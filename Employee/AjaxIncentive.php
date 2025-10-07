<?php
error_reporting(0);
include('../common.php');
include('IsLogin.php');
$connect = new connect();
include ('User_Paging.php');

if ($_POST['action'] == 'ListUser') {
    $where = "where 1=1 ";

    if ($_REQUEST['Date'] != NULL && isset($_REQUEST['Date']))
        $where.=" and MONTH(STR_TO_DATE(date,'%d-%M-%Y'))= MONTH(STR_TO_DATE('" . $_REQUEST['Date'] . "','%d-%M-%Y'))";

    $whereEmp = "";
    if ($_REQUEST['EmployeeId'] != NULL && isset($_REQUEST['EmployeeId'])) {
        $whereEmp.=" and elisionloginid='" . $_REQUEST['EmployeeId'] . "'";
        $filterstr = "SELECT * FROM `incentivemaster` " . $where . $whereEmp . "  and isDelete='0'  order by incentiveId asc";
    } else {
        $filterstr = "SELECT * FROM `incentivemaster` " . $where . " and elisionloginid='" . $_SESSION['elisionloginid'] . "'  and isDelete='0'  order by incentiveId asc";
    }
    if ($_REQUEST['EmployeeId'] != NULL && isset($_REQUEST['EmployeeId'])) {
        $whereEmp.=" and elisionloginid='" . $_REQUEST['EmployeeId'] . "'";
        $countstr = "SELECT count(*) as TotalRow FROM `incentivemaster` " . $where . $whereEmp . " and isDelete='0'";
    } else {
        $countstr = "SELECT count(*) as TotalRow FROM `incentivemaster` " . $where . " and elisionloginid='".$_SESSION['elisionloginid']."' and isDelete='0'";
    }

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
        <div class="row">

            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover dt-responsive" id="tableC">
                        <thead class="tbg">
                            <tr>
                                <th class="pop_in_heading">Date</th>
                                <th class="pop_in_heading">Login Id</th>
                                <th class="pop_in_heading">Incentive Scheme</th>
                                <th class="pop_in_heading">Incentive earned</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $book = array();
                            while ($rowfilter = mysqli_fetch_array($resultfilter)) {
                                $book[0]+=$rowfilter['incentiveEarned'];
                                ?>
                                <tr>
                                    <td><?php echo $rowfilter['date']; ?> 
                                    </td> 
                                    <td>
                                        <?php echo $rowfilter['elisionloginid']; ?> 
                                    </td>
                                    <td>
                                        <?php echo $rowfilter['incentiveScheme']; ?> 
                                    </td> 
                                    <td>
                                        <?php echo $rowfilter['incentiveEarned']; ?> 
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>

                        </tbody>
                        <tr style="background-color:#3f4296;">
                            <td class="pop_in_heading" colspan="1"><b>Total</b></td>
                            <td class="pop_in_heading" colspan="1"></td>
                            <td class="pop_in_heading" colspan="1"></td>
                            <td class="pop_in_heading" colspan="1"><?= $book[0]; ?></td>
                        </tr>
                    </table>
                </div>
            </div>
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