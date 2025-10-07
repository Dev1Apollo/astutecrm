<?php
error_reporting(0);
include('../common.php');
include('IsLogin.php');
$connect = new connect();
include ('User_Paging.php');

if ($_POST['action'] == 'ListUser') {
    $where = "where 1=1 ";

    if ($_REQUEST['Date'] != NULL && isset($_REQUEST['Date']))
        $where.=" and DATE_FORMAT(STR_TO_DATE(strEntryDate,'%d-%m-%Y'),'%m')= DATE_FORMAT(STR_TO_DATE('" . $_REQUEST['Date'] . "','%d-%m-%Y'),'%m') and DATE_FORMAT(STR_TO_DATE(strEntryDate,'%d-%m-%Y'),'%Y')= DATE_FORMAT(STR_TO_DATE('" . $_REQUEST['Date'] . "','%d-%m-%Y'),'%Y')";

//    $whereEmp = "";
//    if ($_REQUEST['EmployeeId'] != NULL && isset($_REQUEST['EmployeeId'])) {
//        $whereEmp.=" and elisionloginid='" . $_REQUEST['EmployeeId'] . "'";
//        $filterstr = "SELECT * FROM `employeeperformance` " . $where . $whereEmp . "  and isDelete='0' GROUP BY date,bucket order by STR_TO_DATE(date,'%d-%M-%Y'),employeeperformanceId asc";
//    } else {
//        $filterstr = "SELECT * FROM `employeeperformance` " . $where . " and elisionloginid='" . $_SESSION['elisionloginid'] . "'  and isDelete='0' GROUP BY date,bucket order by STR_TO_DATE(date,'%d-%M-%Y'),employeeperformanceId asc";
//    }
//    if ($_REQUEST['EmployeeId'] != NULL && isset($_REQUEST['EmployeeId'])) {
//        $whereEmp.=" and elisionloginid='" . $_REQUEST['EmployeeId'] . "'";
    $filterstr = "SELECT count(*) as TotalRow FROM `application` " . $where . " and isDelete='0'";
//    } else {
//        $whereEmp.=" and elisionloginid='" . $_SESSION['elisionloginid'] . "'";
//        $countstr = "SELECT count(*) as TotalRow FROM `employeeperformance` " . $where . $whereEmp . " and isDelete='0'";
//    }
//    $filterstr = "SELECT * FROM `employeeperformance` " . $where . " and elisionloginid='" . $_SESSION['elisionloginid'] . "'  and isDelete='0'  order by STR_TO_DATE(date,'%d-%m-%Y') asc";
//    $countstr = "SELECT count(*) as TotalRow FROM `employeeperformance` " . $where . " and elisionloginid='" . $_SESSION['elisionloginid'] . "' and isDelete='0'";
//    $resrowcount = mysqli_query($dbconn, $countstr);
//    $resrowc = mysqli_fetch_array($resrowcount);
//    $totalrecord = $resrowc['TotalRow'];
//    $per_page = $cateperpaging;
//    $total_pages = ceil($totalrecord / $per_page);
//    $page = $_REQUEST['Page'] - 1;
//    $startpage = $page * $per_page;
//    $show_page = $page + 1;
//    echo $filterstr = $filterstr . " LIMIT $startpage, $per_page";

    $resultfilter = mysqli_query($dbconn, $filterstr);
    if (mysqli_num_rows($resultfilter) > 0) {
        $i = 1;
        ?>  
        <link href="<?php echo $web_url; ?>Employee/global/plugins/datatables/datatables.css" rel="stylesheet" type="text/css" />
        <div class="row">
            <div class="col-md-8">
                <div class="form-group">
                    <label>Total Records : </label>
                    <?php
                    $rowfilter = mysqli_fetch_array($resultfilter);
                    echo $rowfilter['TotalRow'];
                    ?>
                </div>
                <a class="btn blue" onClick="javascript: return deletedata('Delete', '<?php echo $_REQUEST['Date']; ?>');"   title="Move To">Move</a>
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

    // echo "FormDate". $_REQUEST['ID'];
    $query = mysqli_query($dbconn, "INSERT INTO `colleted_application`(`iAppId`,`applicatipnNo`,`bucket`, `customerName`, `branch`, `state`, `customerAddress`, `customerCity`, `customerZipcode`, `loanAmount`, `EMIAmount`, `agencyName`, `agencyId`, `FOSName`, `FosNumber`, `FOSId`, `agentId`, `iStatus`, `isDelete`, `strEntryDate`, `strIP`, `uploadId`, `isFollowDone`, `isWithdraw`, `isPaid`, `PaidDate`, `isReassig`,`isEmiPending`,`isRollBack`,`remark`,`iAppLogId`) select * FROM application where Month(STR_TO_DATE(strEntryDate,'%d-%m-%Y %H:%i:%s'))= Month(STR_TO_DATE('" . $_REQUEST['ID'] . "','%d-%m-%Y %H:%i:%s')) and Year(STR_TO_DATE(strEntryDate,'%d-%m-%Y %H:%i:%s'))= Year(STR_TO_DATE('" . $_REQUEST['ID'] . "','%d-%m-%Y %H:%i:%s')) ");
    if ($query) {
        $delete = mysqli_query($dbconn, "DELETE FROM `application` WHERE month(STR_TO_DATE(strEntryDate,'%d-%m-%Y %H:%i:%s'))= Month(STR_TO_DATE('" . $_REQUEST['ID'] . "','%d-%m-%Y %H:%i:%s')) and Year(STR_TO_DATE(strEntryDate,'%d-%m-%Y %H:%i:%s'))= Year(STR_TO_DATE('" . $_REQUEST['ID'] . "','%d-%m-%Y %H:%i:%s')) ");
    }
}
?>