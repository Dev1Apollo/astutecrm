<?php
ob_start();
include('../common.php');
include('IsLogin.php');
$connect = new connect();
include('User_Paging.php');

if ($_POST['action'] == 'ListUser') {
    $where = "where 1=1 ";

    if ($_SESSION['Designation'] == 5) {
        $filterstr = "SELECT * from warninglater where  warningForId='" . $_SESSION['EmployeeId'] . "'  and istatus='1' and isDelete='0'  order by STR_TO_DATE(strEntryDatetime,'%d-%m-%Y') desc";
        $countstr = "SELECT count(*) as TotalRow from warninglater where  warningForId='" . $_SESSION['EmployeeId'] . "'  and istatus='1' and isDelete='0'";
    } else {

        if ($_SESSION['Designation'] == 1)
            $where .= " and qualityanalistid='" . $_SESSION['EmployeeId'] . "'";
        else if ($_SESSION['Designation'] == 2)
            $where .= " and asstmanagerid='" . $_SESSION['EmployeeId'] . "'";
        else if ($_SESSION['Designation'] == 3)
            $where .= " and qualityanalistid='" . $_SESSION['EmployeeId'] . "'";
        else if ($_SESSION['Designation'] == 4)
            $where .= " and qualityanalistid='" . $_SESSION['EmployeeId'] . "'";
        else
            $where .= " and centralmanagerId='" . $_SESSION['EmployeeId'] . "'";
        $filterstr = "SELECT * from warninglater where  warningForId IN (select employeeId from employee  " . $where . " and istatus='1' and isDelete='0' ) and istatus='1' and isDelete='0'  ";
        $countstr = "SELECT count(*) as TotalRow from warninglater where  warningForId IN (select employeeId from employee  " . $where . " and istatus='1' and isDelete='0' ) and istatus='1' and isDelete='0' ";
    }
    if (isset($_REQUEST['fromDate']) && $_REQUEST['fromDate'] != '') {
        $filterstr .= " and STR_TO_DATE(strEntryDatetime,'%d-%m-%Y %T')>= STR_TO_DATE('" . $_REQUEST['fromDate'] . "','%d-%m-%Y')";
        $countstr .= " and STR_TO_DATE(strEntryDatetime,'%d-%m-%Y %T')>= STR_TO_DATE('" . $_REQUEST['fromDate'] . "','%d-%m-%Y')";
    }
    if (isset($_REQUEST['toDate']) && $_REQUEST['toDate'] != '') {
        $filterstr .= " and STR_TO_DATE(strEntryDatetime,'%d-%m-%Y %T') < STR_TO_DATE('" . $_REQUEST['toDate'] . "','%d-%m-%Y')";
        $countstr .= " and STR_TO_DATE(strEntryDatetime,'%d-%m-%Y %T')>= STR_TO_DATE('" . $_REQUEST['formDate'] . "','%d-%m-%Y')";
    }
    $resrowcount = mysqli_query($dbconn, $countstr);
    $resrowc = mysqli_fetch_array($resrowcount);
    $totalrecord = $resrowc['TotalRow'];
    $per_page = $cateperpaging;
    $total_pages = ceil($totalrecord / $per_page);
    $page = $_REQUEST['Page'] - 1;
    $startpage = $page * $per_page;
    $show_page = $page + 1;

     $filterstr = $filterstr . "order by STR_TO_DATE(strEntryDatetime,'%d-%m-%Y') desc  LIMIT $startpage, $per_page";
    echo $filterstr;
    exit;
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
                        <th class="pop_in_heading">Warning For </th>
                        <th class="pop_in_heading">Raise by</th>
                        <th class="pop_in_heading">Date & Time</th>
                        <th class="pop_in_heading">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;
                    while ($rowfilter = mysqli_fetch_array($resultfilter)) {
                        $raiseByDetail = mysqli_fetch_assoc(mysqli_query($dbconn, "select * from employee where employeeid=" . $rowfilter['raiseById']));
                        $warningFor = mysqli_fetch_assoc(mysqli_query($dbconn, "select * from employee where employeeid=" . $rowfilter['warningForId']));
                    ?>
                        <tr>
                            <td>
                                <div class="form-group form-md-line-input "><?php echo $i; ?>
                                </div>
                            </td>
                            <td>
                                <?php echo $warningFor['empname']; ?>
                            </td>
                            <!-- <td>
                                <?php echo $rowfilter['warningForUserType'] == '4' ? 'Tean Leader' : "Agent"; ?>
                            </td> -->
                            <td>
                                <?php echo $raiseByDetail['empname']; ?>
                            </td>
                            <td>
                                <?php echo $rowfilter['strEntryDatetime']; ?>
                            </td>
                            <td>
                                <a target="_blank" title="Download CAM Excel" href="<?php echo $web_url; ?>warninglater/<?php echo $rowfilter['warningFile']; ?>"><i class="fa fa-download" aria-hidden="true"></i></a>
                            </td>
                        <?php
                        $i++;
                    }
                        ?>
                        </tr>
                </tbody>
            </table>
        </div>
        <script src="<?php echo $web_url; ?>Employee/assets/global/plugins/datatables/datatables.js" type="text/javascript"></script>
        <script src="<?php echo $web_url; ?>Employee/assets/global/plugins/datatables/table-datatables-responsive.js" type="text/javascript"></script>
        <script>
            $(document).ready(function() {
                $('#tableC').DataTable({});
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