<?php
error_reporting(0);
include('../common.php');
include('IsLogin.php');
$connect = new connect();
include ('User_Paging.php');

if ($_POST['action'] == 'ListUser') {
    $where = "where 1=1";
    if (isset($_REQUEST['formDate']) && $_REQUEST['formDate'] != '') {
        $where.=" and STR_TO_DATE(applicationfollowup.strEntryDate,'%d-%m-%Y')>= STR_TO_DATE('" . $_REQUEST['formDate'] . "','%d-%m-%Y')";
    } else {
        $where.=" and STR_TO_DATE(applicationfollowup.strEntryDate,'%d-%m-%Y')>= STR_TO_DATE('" . $date . "','%d-%m-%Y')";
    }
    if (isset($_REQUEST['toDate']) && $_REQUEST['toDate'] != '') {
        $where.=" and STR_TO_DATE(applicationfollowup.strEntryDate,'%d-%m-%Y')<=STR_TO_DATE('" . $_REQUEST['toDate'] . "','%d-%m-%Y')";
    }
    $whereEmp = "";
    if ($_SESSION['Designation'] == 4) {
        $whereEmp.=" and agentId in (select elisionloginid from employee where iteamleadid='" . $_SESSION['EmployeeId'] . "')";
    } else {
        $whereEmp.=" and agentId='" . $_SESSION['elisionloginid'] . "'";
    }

    $filterstr = "SELECT * FROM `application` inner join applicationfollowup on applicationfollowup.iAppId=application.iAppId  " . $where . $whereEmp . " and application.isPaid=0 and application.isWithdraw=0 and application.isDelete='0'  and  application.istatus='1' order by STR_TO_DATE(applicationfollowup.strEntryDate,'%d-%m-%Y') DESC";
    $countstr = "SELECT count(*) as TotalRow FROM `application` inner join applicationfollowup on applicationfollowup.iAppId=application.iAppId " . $where . $whereEmp . " and application.isWithdraw=0 and application.isPaid=0 and application.isDelete='0' and  application.iStatus='1' ";

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
                        <th class="pop_in_heading">Loan App No</th>
                        <th class="pop_in_heading">Bucket</th>
                        <th class="pop_in_heading">Customer Name</th>
                        <th class="pop_in_heading">Branch</th>
                        <th class="pop_in_heading">State</th>
                        <th class="pop_in_heading">Address</th>
                        <th class="pop_in_heading">City</th>
                        <th class="pop_in_heading">Zip Code</th>
                        <th class="pop_in_heading">Loan Amount</th>
                        <th class="pop_in_heading">EMI Amount</th>
                        <th class="pop_in_heading">Agency Name</th>
                        <th class="pop_in_heading">Paid Status</th>
                        <th class="pop_in_heading">FOS Name</th>
                        <th class="pop_in_heading">FOS Contact</th>
                        <th class="pop_in_heading">Last Call Date</th>
                        <th class="pop_in_heading">Last disposition</th>
                        <th class="pop_in_heading">Follow-up / PTP Date</th>
                        <th class="pop_in_heading">Follow-up / PTP Time</th>
                        <th class="pop_in_heading">Remark</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($rowfilter = mysqli_fetch_array($resultfilter)) {
                        $filterFollowUp = mysqli_fetch_array(mysqli_query($dbconn, "Select * from applicationfollowup where iAppId='" . $rowfilter['iAppId'] . "' ORDER BY iAppLogId DESC LIMIT 1"));
                        if ($filterFollowUp['followupDate'] != "") {
                            $date = explode(" ", $filterFollowUp['followupDate']);
                        } else if ($filterFollowUp['PTPDate'] != '') {
                            $date = explode(" ", $filterFollowUp['PTPDate']);
                        } else {
                            $date = array("", "");
                        }
                        ?>
                        <tr>
                            <td>
                                <div class="form-group form-md-line-input ">
                                    <?php echo $rowfilter['applicatipnNo']; ?>
                                </div>
                            </td>
                            <td>
                                <div class="form-group form-md-line-input ">
                                    <?php echo $rowfilter['bucket']; ?>
                                </div>
                            </td>
                            <td>
                                <div class="form-group form-md-line-input ">
                                    <?php echo $rowfilter['customerName']; ?>
                                </div>
                            </td>
                            <td>
                                <div class="form-group form-md-line-input ">
                                    <?php echo $rowfilter['branch']; ?>
                                </div>
                            </td>
                            <td>
                                <div class="form-group form-md-line-input ">
                                    <?php echo $rowfilter['state']; ?>
                                </div>
                            </td>
                            <td>
                                <div class="form-group form-md-line-input ">
                                    <?php echo $rowfilter['customerAddress']; ?>
                                </div>
                            </td>
                            <td>
                                <div class="form-group form-md-line-input ">
                                    <?php echo $rowfilter['customerCity']; ?> 
                                </div>
                            </td>
                            <td>
                                <div class="form-group form-md-line-input ">
                                    <?php echo $rowfilter['customerZipcode']; ?>
                                </div>
                            </td>
                            <td>
                                <div class="form-group form-md-line-input ">
                                    <?php echo $rowfilter['loanAmount']; ?>
                                </div>
                            </td>
                            <td>
                                <div class="form-group form-md-line-input ">
                                    <?php echo $rowfilter['EMIAmount']; ?>
                                </div>
                            </td>
                            <td>
                                <div class="form-group form-md-line-input ">
                                    <?php echo $rowfilter['agencyName']; ?>  
                                </div>
                            </td>
                            <td>
                                <div class="form-group form-md-line-input ">
                                    <?php
                                    if ($rowfilter['isEmiPending'] == 1) {
                                        echo "One Emi Pending";
                                    } else {
                                        echo "";
                                    }
                                    ?>
                                </div>
                            </td>
                            <td>
                                <div class="form-group form-md-line-input ">
                                    <?php echo $rowfilter['FOSName']; ?>
                                </div>
                            </td>
                            <td>
                                <div class="form-group form-md-line-input ">
                                    <?php echo $rowfilter['FosNumber']; ?> 
                                </div>
                            </td>
                            <td>
                                <div class="form-group form-md-line-input ">
                                    <?php echo $date[0]; ?> 
                                </div>
                            </td>
                            <td>
                                <div class="form-group form-md-line-input ">
                                    <?php
                                    $filterDisPosition = mysqli_fetch_array(mysqli_query($dbconn, "Select dispoDesc from dispositionmaster where iDispoId='" . $filterFollowUp['mainDispoId'] . "'"));
                                    echo $filterDisPosition['dispoDesc'];
                                    ?> 
                                </div>
                            </td>
                            <td>
                                <div class="form-group form-md-line-input ">
                                    <?php echo $date[0]; ?> 
                                </div>
                            </td>
                            <td>
                                <div class="form-group form-md-line-input ">
                                    <?php echo $date[1]; ?>
                                </div>
                            </td>
                            <td>
                                <div class="form-group form-md-line-input ">
                                    <?php echo $filterFollowUp['remark']; ?>
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