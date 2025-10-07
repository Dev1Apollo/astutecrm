<?php
error_reporting(0);
include('../common.php');
include('IsLogin.php');
$connect = new connect();
include ('User_Paging.php');

if ($_POST['action'] == 'ListUser') {
    $where = "WHERE 1=1";
    
    // Date filter
    if(isset($_REQUEST['formDate']) && $_REQUEST['formDate'] != ''){
        $where .= " AND STR_TO_DATE(applicationfollowup.strEntryDate, '%d-%m-%Y') >= STR_TO_DATE('" . mysqli_real_escape_string($dbconn, $_REQUEST['formDate']) . "', '%d-%m-%Y')";
    }
    
    if(isset($_REQUEST['toDate']) && $_REQUEST['toDate'] != ''){
        $where .= " AND STR_TO_DATE(applicationfollowup.strEntryDate, '%d-%m-%Y') <= STR_TO_DATE('" . mysqli_real_escape_string($dbconn, $_REQUEST['toDate']) . "', '%d-%m-%Y')";
    }

    // Employee filter based on designation
    $whereEmp = "";
    if ($_SESSION['Designation'] == 4) { // Team Leader
        if ($_REQUEST['EmployeeId'] != NULL && isset($_REQUEST['EmployeeId'])) {
            $whereEmp = " AND application.agentId='" . mysqli_real_escape_string($dbconn, $_REQUEST['EmployeeId']) . "'";
        } else {
            $whereEmp = " AND application.agentId IN (SELECT elisionloginid FROM employee WHERE iteamleadid='" . $_SESSION['EmployeeId'] . "')";
        }
    } else if ($_SESSION['Designation'] == 6) { // Central Manager
        // if ($_REQUEST['EmployeeId'] != NULL && isset($_REQUEST['EmployeeId'])) {
        //     $whereEmp = " AND application.agentId='" . mysqli_real_escape_string($dbconn, $_REQUEST['EmployeeId']) . "'";
        // } 
        // else {
        //     $whereEmp = " AND application.agentId IN (SELECT elisionloginid FROM employee WHERE asstmanagerid='" . $_SESSION['EmployeeId'] . "')";
        // }
    } else { // Regular Employee
        $whereEmp = " AND applicationfollowup.agentId='" . $_SESSION['elisionloginid'] . "'";
    }

 $orderBy = "ORDER BY 
                CASE 
                    WHEN STR_TO_DATE(applicationfollowup.PTPDate, '%d-%m-%Y') = CURDATE() THEN 0
                    ELSE 1
                END,
                STR_TO_DATE(applicationfollowup.strEntryDate, '%d-%m-%Y') ASC";
    // Main query for entry-wise report
    $filterstr = "SELECT 
                    application.iAppId,
                    application.applicatipnNo,
                    application.customerName,
                    application.customerMobile,
                    application.loanAmount,
                    applicationfollowup.strEntryDate,
                    applicationfollowup.mainDispoId,
                    applicationfollowup.subDispoId,
                    applicationfollowup.PTP_Amount,
                    applicationfollowup.followupDate,
                    applicationfollowup.PTPDate,
                    applicationfollowup.remark,
                    employee.empname as AgentName
                FROM applicationfollowup 
                INNER JOIN application ON application.iAppId = applicationfollowup.iAppId
                LEFT JOIN employee ON employee.elisionloginid = application.agentId
                $where $whereEmp 
                AND application.isWithdraw=0 
                AND application.isPaid=0 
                AND application.isDelete='0'  
                AND application.iStatus='1' ". 
                $orderBy;
    
    // Count query
    $countstr = "SELECT COUNT(*) as TotalRow 
                FROM applicationfollowup 
                INNER JOIN application ON application.iAppId = applicationfollowup.iAppId
                $where $whereEmp 
                AND application.isWithdraw=0 
                AND application.isPaid=0 
                AND application.isDelete='0'  
                AND application.iStatus='1'";

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
        <style>
            .sortable {
                cursor: pointer;
                position: relative;
                padding-right: 25px !important;
                transition: all 0.3s ease;
            }
            
            .sortable:hover {
                background-color: #2c2f7c !important;
            }
            
            .sortable.asc:after {
                content: '▲' !important;
                position: absolute !important;
                right: 8px !important;
                top: 50% !important;
                transform: translateY(-50%) !important;
                font-size: 12px !important;
                color: #fff !important;
                font-weight: bold !important;
            }
            
            .sortable.desc:after {
                content: '▼' !important;
                position: absolute !important;
                right: 8px !important;
                top: 50% !important;
                transform: translateY(-50%) !important;
                font-size: 12px !important;
                color: #fff !important;
                font-weight: bold !important;
            }
            
            th.pop_in_heading.sortable {
                background-color: #3f4296 !important;
                font-weight: 600 !important;
                padding-right: 25px !important;
            }
        </style>
        <div class="table-responsive">
            <table class="table table-bordered table-hover center table-responsive" width="100%" id="tableC">
                <thead class="tbg">
                    <tr>
                        <!--<th class="pop_in_heading">Entry Date</th>-->
                        <th class="pop_in_heading">Loan App No</th>
                        <th class="pop_in_heading">Customer Name</th>
                        <th class="pop_in_heading">Customer Mobile</th>
                        <th class="pop_in_heading">Agent Name</th>
                        <th class="pop_in_heading">POS Amount</th>
                        <th class="pop_in_heading">Disposition</th>
                        <th class="pop_in_heading">Sub Disposition</th>
                        <th class="pop_in_heading">PTP Amount</th>
                        <th class="pop_in_heading">Follow-up Date / PTP Date</th>
                        <th class="pop_in_heading">Disposition Date</th>
                        <th class="pop_in_heading">Remark</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($rowfilter = mysqli_fetch_array($resultfilter)) {
                        // Format dates
                        $entryDate = $rowfilter['strEntryDate'] ? date('d-m-Y', strtotime($rowfilter['strEntryDate'])) : '';
                        
                        if ($rowfilter['followupDate'] != "") {
                            $followupDate = date('d-m-Y H:i:s', strtotime($rowfilter['followupDate']));
                        } else {
                            $followupDate = '';
                        }
                        
                        if ($rowfilter['PTPDate'] != '') {
                            $ptpDate = date('d-m-Y H:i:s', strtotime($rowfilter['PTPDate']));
                        } else {
                            $ptpDate = '';
                        }

                        // Get disposition name
                        $dispositionName = '-';
                        if ($rowfilter['mainDispoId']) {
                            $filterDisPosition = mysqli_fetch_array(mysqli_query($dbconn, "SELECT dispoDesc FROM dispositionmaster WHERE iDispoId='" . $rowfilter['mainDispoId'] . "'"));
                            $dispositionName = $filterDisPosition['dispoDesc'] ?? '-';
                        }
                        $subdispositionName = '-';
                        if ($rowfilter['subDispoId']) {
                            $filterDisPosition = mysqli_fetch_array(mysqli_query($dbconn, "SELECT dispoDesc FROM dispositionmaster WHERE iDispoId='" . $rowfilter['subDispoId'] . "'"));
                            $subdispositionName = $filterDisPosition['dispoDesc'] ?? '-';
                        }

                        echo "<tr>";
                        ?> 
                        <!--<td>-->
                        <!--    <div class="form-group form-md-line-input">-->
                        <!--        <?php echo $entryDate; ?>-->
                        <!--    </div>-->
                        <!--</td>-->
                        <td>
                            <div class="form-group form-md-line-input">
                                <?php echo $rowfilter['applicatipnNo']; ?>    
                            </div>
                        </td>
                        <td>
                            <div class="form-group form-md-line-input">
                                <?php echo $rowfilter['customerName']; ?>
                            </div>
                        </td>
                        <td>
                            <div class="form-group form-md-line-input">
                                <?php echo $rowfilter['customerMobile']; ?>
                            </div>
                        </td>
                        <td>
                            <div class="form-group form-md-line-input">
                                <?php echo $rowfilter['AgentName'] ?? '-'; ?>
                            </div>
                        </td>
                        
                        <td>
                            <div class="form-group form-md-line-input">
                                <?php echo $rowfilter['loanAmount']; ?>
                            </div>
                        </td>
                        
                        <td>
                            <div class="form-group form-md-line-input">
                                <?php echo $dispositionName; ?>
                            </div>
                        </td>
                        <td>
                            <div class="form-group form-md-line-input">
                                <?php echo $subdispositionName; ?>
                            </div>
                        </td>
                        
                        <td>
                            <div class="form-group form-md-line-input">
                                <?php echo $rowfilter['PTP_Amount'] ?: '-'; ?>
                            </div>
                        </td>
                        <td>
                            <div class="form-group form-md-line-input">
                                
                                <?php echo $followupDate ? explode(' ', $followupDate)[0] : ($ptpDate ? explode(' ', $ptpDate)[0] : '-'); ?>
                            </div>
                        </td>
                        <td>
                            <div class="form-group form-md-line-input">
                                <?php echo $entryDate; ?>
                            </div>
                        </td>
                        <td>
                            <div class="form-group form-md-line-input">
                                <?php echo $rowfilter['remark'] ?: '-'; ?>
                            </div>
                        </td>
                        <?php
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <?php
    } else {
        ?>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12 padding-5 bottom-border-verydark">
                <div class="alert alert-info clearfix profile-information padding-all-10 margin-all-0 backgroundDark">
                    <h1 class="font-white text-center">No Data Found!</h1>
                </div>   
            </div>
        </div>
        <?php
    }
}

if ($totalrecord > $per_page) {
    ?>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12 padding-5 bottom-border-verydark" style="text-align: center;">
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
