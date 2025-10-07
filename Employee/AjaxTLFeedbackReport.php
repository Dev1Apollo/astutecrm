<?php
error_reporting(0);
include('../common.php');
include('IsLogin.php');
$connect = new connect();
include ('User_Paging.php');

if ($_POST['action'] == 'ListUser') {
    $where = "where 1=1";
    if (isset($_REQUEST['formDate']) && $_REQUEST['formDate'] != '') {
        $where.=" and STR_TO_DATE(customerfeedback.strEntryDate,'%d-%m-%Y')>= STR_TO_DATE('" . $_REQUEST['formDate'] . "','%d-%m-%Y')";
    } else {
        $where.=" and STR_TO_DATE(customerfeedback.strEntryDate,'%d-%m-%Y')>= STR_TO_DATE('" . $date . "','%d-%m-%Y')";
    }
    if (isset($_REQUEST['toDate']) && $_REQUEST['toDate'] != '') {
        $where.=" and STR_TO_DATE(customerfeedback.strEntryDate,'%d-%m-%Y')<=STR_TO_DATE('" . $_REQUEST['toDate'] . "','%d-%m-%Y')";
    }
    $whereEmp = "";
    if ($_SESSION['Designation'] == 4) {
        $whereEmp.=" and enterBy in (select employee.employeeid from employee where iteamleadid='" . $_SESSION['EmployeeId'] . "')";
    } else if($_SESSION['Designation'] == 2){
        $whereEmp.=" and enterBy in (select employee.employeeid from employee where asstmanagerid='" . $_SESSION['EmployeeId'] . "')";
    }else {
        $whereEmp.=" and enterBy='" . $_SESSION['elisionloginid'] . "'";
    }

    $filterstr = "SELECT * FROM `customerfeedback` inner join feedback on feedback.iFeedbackId=customerfeedback.iFeedbackId  " . $where . $whereEmp . " order by STR_TO_DATE(customerfeedback.strEntryDate,'%d-%m-%Y') DESC";
    $countstr = "SELECT count(*) as TotalRow FROM `customerfeedback` inner join feedback on customerfeedback.iFeedbackId=feedback.iFeedbackId " . $where . $whereEmp . " ";

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
        <link href="<?php echo $web_url; ?>Employee/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css" rel="stylesheet" type="text/css" />
        <script src="<?php echo $web_url; ?>Employee/global/plugins/datatables/datatables.js" type="text/javascript"></script>
        <script src="<?php echo $web_url; ?>Employee/global/plugins/datatables/table-datatables-responsive.js" type="text/javascript"></script>
        <div class="table-responsive">
            <table class="table table-bordered table-hover center table-responsive" width="100%" id="tableC">
                <thead class="tbg">
                    <tr>
                        <th class="pop_in_heading">Load Application No</th>
                        <th class="pop_in_heading">Feedback</th>
                        <th class="pop_in_heading">Enter By</th>
                        <th class="pop_in_heading">Entry Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($rowfilter = mysqli_fetch_array($resultfilter)) {
                        ?>
                        <tr>
                            <td>
                                <div class="form-group form-md-line-input ">
                                    <?php echo $rowfilter['applicatipnNo']; ?>
                                </div>
                            </td>
                            <td>
                                <div class="form-group form-md-line-input ">
                                    <?php echo $rowfilter['strfeedbackName']; ?>
                                </div>
                            </td>
                            <td>
                                <div class="form-group form-md-line-input ">
                                    <?php
                                    $filterEmployee = mysqli_fetch_array(mysqli_query($dbconn, "Select empname from employee where employeeid='" . $rowfilter['enterBy'] . "' "));
                                    echo $filterEmployee['empname'];
                                    ?>
                                </div>
                            </td>
                            <td>
                                <div class="form-group form-md-line-input ">
            <?php echo $rowfilter['strEntryDate']; ?>
                                </div>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
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

if ($totalrecord > $per_page) {
    ?>
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