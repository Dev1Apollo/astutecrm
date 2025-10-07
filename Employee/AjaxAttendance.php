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
//    if ($_REQUEST['toDate'] != NULL && isset($_REQUEST['toDate']))
//        $where.=" and STR_TO_DATE(date, '%d-%M-%Y')<= STR_TO_DATE('" . $_REQUEST['toDate'] . "','%d-%M-%Y')";
    $whereEmp = "";
    if ($_REQUEST['EmployeeId'] != NULL && isset($_REQUEST['EmployeeId'])) {
        $whereEmp.=" and elisionloginid='" . $_REQUEST['EmployeeId'] . "'";
        $filterstr = "SELECT * FROM `employeeperformance` " . $where . $whereEmp . "  and isDelete='0' GROUP BY date,bucket order by STR_TO_DATE(date,'%d-%M-%Y'),employeeperformanceId asc";
    } else {
        $filterstr = "SELECT * FROM `employeeperformance` " . $where . " and elisionloginid='" . $_SESSION['elisionloginid'] . "'  and isDelete='0' GROUP BY date,bucket order by STR_TO_DATE(date,'%d-%M-%Y'),employeeperformanceId asc";
    }
    if ($_REQUEST['EmployeeId'] != NULL && isset($_REQUEST['EmployeeId'])) {
        $whereEmp.=" and elisionloginid='" . $_REQUEST['EmployeeId'] . "'";
        $countstr = "SELECT count(*) as TotalRow FROM `employeeperformance` " . $where . $whereEmp . " and isDelete='0'";
    } else {
        $whereEmp.=" and elisionloginid='" . $_SESSION['elisionloginid'] . "'";
        $countstr = "SELECT count(*) as TotalRow FROM `employeeperformance` " . $where . $whereEmp . " and isDelete='0'";
    }
//    $filterstr = "SELECT * FROM `employeeperformance` " . $where . " and elisionloginid='" . $_SESSION['elisionloginid'] . "'  and isDelete='0'  order by STR_TO_DATE(date,'%d-%m-%Y') asc";
//    $countstr = "SELECT count(*) as TotalRow FROM `employeeperformance` " . $where . " and elisionloginid='" . $_SESSION['elisionloginid'] . "' and isDelete='0'";

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
        <link href="<?php echo $web_url; ?>Employee/global/plugins/datatables/datatables.css" rel="stylesheet" type="text/css" />
        <div class="row">
            <div class="col-md-4">
                <table class="table table-striped table-bordered table-hover dt-responsive" style="width: 100%;" id="tableC">
                    <?php
                    $Present = 0;
                    $WeeklyOff = 0;
                    $Absent = 0;
                    $HalfDays = 0;
                    if ($_REQUEST['EmployeeId'] != NULL && isset($_REQUEST['EmployeeId'])) {
                        $whereEmp.=" and elisionloginid='" . $_REQUEST['EmployeeId'] . "'";
                        $filterAttendance = mysqli_query($dbconn, "SELECT COUNT(*) as RowTotal,employeeperformance.Attendance FROM `employeeperformance` " . $where . $whereEmp . "  and isDelete='0' GROUP BY employeeperformance.Attendance order by STR_TO_DATE(date,'%d-%m-%Y') asc ");
                    } else {
                        $filterAttendance = mysqli_query($dbconn, "SELECT COUNT(*) as RowTotal,employeeperformance.Attendance FROM `employeeperformance` " . $where . "  and elisionloginid='" . $_SESSION['elisionloginid'] . "' and isDelete='0' GROUP BY employeeperformance.Attendance order by STR_TO_DATE(date,'%d-%m-%Y') asc ");
                    }
                    while ($rowData = mysqli_fetch_array($filterAttendance)) {
                        if ($rowData['Attendance'] == 'P') {
                            $Present = $rowData['RowTotal'];
                        }
                        if ($rowData['Attendance'] == 'WO') {
                            $WeeklyOff = $rowData['RowTotal'];
                        }
                        if ($rowData['Attendance'] == 'A') {
                            $Absent = $rowData['RowTotal'];
                        }
                        if ($rowData['Attendance'] == 'HD') {
                            $HalfDays = $rowData['RowTotal'];
                        }
                    }
                    ?>
                    <tbody>
                        <tr class="border_top_1">
                            <td>Total Present Days</td> 
                            <td><?php echo $Present; ?></td>
                        </tr>
                        <tr>
                            <td>Total Weekly OFF</td> 
                            <td><?php echo $WeeklyOff; ?></td>
                        </tr>
                        <tr>
                            <td>Total Absent Days</td> 
                            <td><?php echo $Absent; ?></td>
                        </tr>
                        <tr>
                            <td>Total Half Days</td> 
                            <td><?php echo $HalfDays; ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-md-8">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover dt-responsive" id="tableC">
                        <thead class="tbg">
                            <tr>
                                <th class="pop_in_heading">Date</th>
                                <th class="pop_in_heading">Bucket</th>
                                <th class="pop_in_heading">Attendance</th>
                                <th class="pop_in_heading">Login Time</th>
                                <th class="pop_in_heading">Logout Time</th>
                                <th class="pop_in_heading">Login hour</th>
                                <th class="pop_in_heading">Talk Time</th>
                                <th class="pop_in_heading">Pause Time</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            while ($rowfilter = mysqli_fetch_array($resultfilter)) {
                                ?>
                                <tr>
                                    <td><?php echo $rowfilter['date']; ?> 
                                    </td> 
                                    <td><?php echo $rowfilter['bucket']; ?> 
                            </td>
                                    <td>
                                        <?php echo $rowfilter['Attendance']; ?> 
                                    </td>
                                    <td>
                                        <?php echo $rowfilter['LoginTime']; ?> 
                                    </td> 
                                    <td>
                                        <?php echo $rowfilter['LogoutTime']; ?> 
                                    </td> 
                                    <td>
                                        <?php echo $rowfilter['Loginhour']; ?> 
                                    </td>
                                    <td>
                                        <?php echo $rowfilter['TalkTime']; ?> 
                                    </td> 
                                    <td>
                                        <?php echo $rowfilter['PauseTime']; ?> 
                                    </td>
                                    <?php
                                }
                                ?>
                            </tr>
                        </tbody>
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