<?php
error_reporting(E_ALL);
include('../common.php');
include('IsLogin.php');
$connect = new connect();
include('User_Paging.php');

if ($_POST['action'] == 'ListUser') {
   $where = "WHERE 1=1";
    
    // Date filter
    if (!empty($_REQUEST['formDate'])) {
        $where .= " AND STR_TO_DATE(application.strEntryDate, '%d-%m-%Y') >= STR_TO_DATE('" . $_REQUEST['formDate'] . "', '%d-%m-%Y')";
    }
    if (!empty($_REQUEST['toDate'])) {
        $where .= " AND STR_TO_DATE(application.strEntryDate, '%d-%m-%Y') <= STR_TO_DATE('" . $_REQUEST['toDate'] . "', '%d-%m-%Y')";
    }
    
    $where .= " AND application.isWithdraw=0 AND application.isPaid=0 AND application.isDelete='0' AND application.iStatus='1'";

    // Application No filter
    // if (!empty($_REQUEST['applicatipnNo'])) {
    //     $where .= " AND application.applicatipnNo LIKE '%" . mysqli_real_escape_string($dbconn, $_REQUEST['applicatipnNo']) . "%'";
    // }

    // ✅ Modified query to include follow-up details
    $filterstr = "SELECT 
        application.iAppId,
        application.bucket,
        application.isEmiPending,
        application.applicatipnNo,
        application.customerName,
        application.branch,
        application.state,
        application.customerAddress,
        application.customerCity,
        application.agencyId,
        application.customerZipcode,
        application.loanAmount,
        application.EMIAmount,
        application.agencyName,
        application.FOSName,
        application.customerMobile,
        applicationfollowup.strEntryDate,
        applicationfollowup.mainDispoId,
        applicationfollowup.followupDate,
        applicationfollowup.PTPDate,
        applicationfollowup.PTP_Amount,
        applicationfollowup.remark,
        (select employee.empname from employee where employee.elisionloginid=application.agentId) as employeeName
    FROM application
    LEFT JOIN applicationfollowup 
        ON application.iAppId = applicationfollowup.iAppId
    $where
    ORDER BY STR_TO_DATE(application.strEntryDate, '%d-%m-%Y') DESC, application.iAppId DESC ";
    
    // Count total
    $countstr = "SELECT COUNT(DISTINCT application.iAppId) AS TotalRow FROM application  LEFT JOIN applicationfollowup ON application.iAppId = applicationfollowup.iAppId $where";
    
    $resrowcount = mysqli_query($dbconn, $countstr);
    $resrowc = mysqli_fetch_array($resrowcount);
    $totalrecord = $resrowc['TotalRow'];
    //$totalrecord = mysqli_fetch_array($resrowcount)['TotalRow'];

    $per_page = $cateperpaging;
    $total_pages = ceil($totalrecord / $per_page);
    $page = $_REQUEST['Page'] - 1;
    $startpage = $page * $per_page;
    $show_page = $page + 1;

    $filterstr .= " LIMIT $startpage, $per_page";
    $resultfilter = mysqli_query($dbconn, $filterstr);
    if (!$resultfilter) {
        die("SQL Error: " . mysqli_error($dbconn) . "<br>Query: " . $filterstr);
    }
    if (mysqli_num_rows($resultfilter) > 0) {
        
        ?>
        <div class="table-responsive">
            <table class="table table-bordered table-hover table-striped">
                <thead class="tbg">
                    <tr>
                        <th class="pop_in_heading">#</th>
                        <th class="pop_in_heading">Loan App No</th>
                        <th class="pop_in_heading">Customer Name</th>
                        <th class="pop_in_heading">Customer Mobile</th>
                        <th class="pop_in_heading">Total Attempt</th>
                        <th class="pop_in_heading">Total Connect</th>
                        <th class="pop_in_heading">POS Amount</th>
                        <th class="pop_in_heading">Last Call Date</th>
                        <th class="pop_in_heading">Last Disposition</th>
                        <th class="pop_in_heading">PTP Amount</th>
                        <th class="pop_in_heading">Follow-up / PTP Date</th>
                        <th class="pop_in_heading">Follow-up / PTP Time</th>
                        <th class="pop_in_heading">Remark</th>
                        <th class="pop_in_heading">Agent Name</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;
                    while ($rowfilter = mysqli_fetch_array($resultfilter)) {
                        
                        $lastCall = $rowfilter['strEntryDate'] ? date('d-m-Y H:i', strtotime($rowfilter['strEntryDate'])) : '-';
                        if (isset($rowfilter['followupDate']) && $rowfilter['followupDate'] != "") {
                            $date = explode(" ", $rowfilter['followupDate']);
                        } else if (isset($rowfilter['PTPDate']) && $rowfilter['PTPDate'] != '') {
                            $date = explode(" ", $rowfilter['PTPDate']);
                        } else {
                            $date = array("", "");
                        }
                        
                        $LastDisposition = '-';
                        if (!empty($rowfilter['mainDispoId'])) {
                            $resDispo = mysqli_query($dbconn, "SELECT dispoDesc FROM dispositionmaster WHERE iDispoId='" . $rowfilter['mainDispoId'] . "' LIMIT 1");
                            if ($resDispo && mysqli_num_rows($resDispo) > 0) {
                                $dispoRow = mysqli_fetch_array($resDispo);
                                $LastDisposition = $dispoRow['dispoDesc'];
                            }
                        }
                        
                                
                        echo "<tr>
                                <td>$i</td>
                                <td>{$rowfilter['applicatipnNo']}</td>
                                <td>{$rowfilter['customerName']}</td>
                                <td>{$rowfilter['customerMobile']}</td>
                                <td style='text-align:center;'>{$rowfilter['TotalAttempt']}</td>
                                <td style='text-align:center;'>{$rowfilter['TotalConnect']}</td>
                                <td style='text-align:right;'>{$rowfilter['loanAmount']}</td>
                                <td>{$lastCall}</td>
                                <td>{$LastDisposition}</td>
                                <td style='text-align:right;'>{$rowfilter['PTP_Amount']}</td>
                                <td>{$date['0']}</td>
                                <td>{$date['1']}</td>
                                <td>{$rowfilter['remark']}</td>
                                <td>{$rowfilter['employeeName']}</td>
                              </tr>";
                        $i++;
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <?php
        if ($totalrecord > $per_page) {
            echo '<div class="row">
                <div class="col-lg-12 col-md-12  col-xs-12 col-sm-12 padding-5 bottom-border-verydark" style="text-align: center;">
                    <div class="form-actions noborder">
                        <div class="pagination text-center">' . paginate('', $show_page, $total_pages) . '</div>
                         </div>
                </div>
            </div>';
        }
    
    } else {
        echo '<div class="alert alert-info text-center"><h4>No Assigned Cases Found!</h4></div>';
    }
}
?>
