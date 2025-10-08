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
        $where .= " AND STR_TO_DATE(ra.strEntryDate, '%d-%m-%Y') >= STR_TO_DATE('" . mysqli_real_escape_string($dbconn, $_REQUEST['formDate']) . "', '%d-%m-%Y')";
    }
    
    if(isset($_REQUEST['toDate']) && $_REQUEST['toDate'] != ''){
        $where .= " AND STR_TO_DATE(ra.strEntryDate, '%d-%m-%Y') <= STR_TO_DATE('" . mysqli_real_escape_string($dbconn, $_REQUEST['toDate']) . "', '%d-%m-%Y')";
    }

    // Application No filter
    if(isset($_REQUEST['applicatipnNo']) && $_REQUEST['applicatipnNo'] != ''){
        $where .= " AND ra.applicatipnNo LIKE '%" . mysqli_real_escape_string($dbconn, $_REQUEST['applicatipnNo']) . "%'";
    }

    // Employee filter
    if(isset($_REQUEST['EmployeeId']) && $_REQUEST['EmployeeId'] != ''){
        $where .= " AND ra.agentId = '" . mysqli_real_escape_string($dbconn, $_REQUEST['EmployeeId']) . "'";
    } else {
        // For regular employees, show only their cases
        if ($_SESSION['Designation'] != 4 && $_SESSION['Designation'] != 6) {
            $where .= " AND ra.agentId = '" . $_SESSION['elisionloginid'] . "'";
        }
    }

    // Main query for removed cases
    $filterstr = "SELECT 
                    ra.*,
                    e.empname as AgentName
                FROM remove_application ra 
                LEFT JOIN employee e ON ra.agentId = e.elisionloginid
                $where 
                ORDER BY STR_TO_DATE(ra.strEntryDate, '%d-%m-%Y') DESC, ra.id DESC";
    
    // Count query
    $countstr = "SELECT COUNT(*) as TotalRow 
                FROM remove_application ra 
                $where";

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
        ?>  
        <div class="mb-3">
            <button class="btn btn-danger btn-sm" id="delete_selected" style="margin-bottom:10px;">
                <i class="fa fa-trash"></i> Delete Selected
            </button>
            <button class="btn btn-danger btn-sm" id="delete_all" style="margin-bottom:10px;">
                <i class="fa fa-trash"></i> Delete All
            </button>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered table-hover table-striped" width="100%" id="tableC">
                <thead class="tbg">
                    <tr>
                        <th class="pop_in_heading" style="text-align:center;"><input type="checkbox" id="select_all"></th>
                        <th class="pop_in_heading">#</th>
                        <th class="pop_in_heading">Loan App No</th>
                        <th class="pop_in_heading">Customer Name</th>
                        <th class="pop_in_heading">Customer Mobile</th>
                        <th class="pop_in_heading">Agent Name</th>
                        <th class="pop_in_heading">Loan Amount</th>
                        <th class="pop_in_heading">Bucket</th>
                        <th class="pop_in_heading">Branch</th>
                        <th class="pop_in_heading">State</th>
                        <th class="pop_in_heading">Remove Date</th>
                        <th class="pop_in_heading">Remarks</th>
                        <th class="pop_in_heading">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;
                    while ($rowfilter = mysqli_fetch_array($resultfilter)) {
                        // Format remove date
                        $removeDate = $rowfilter['strEntryDate'] ? date('d-m-Y', strtotime($rowfilter['strEntryDate'])) : '-';
                        
                        echo "<tr>";
                        ?> 
                        <td style="text-align:center;">
                            <input type="checkbox" class="case_checkbox" value="<?php echo $rowfilter['iAppId']; ?>">
                        </td>
                        <td style="text-align: center;"><?php echo $i; ?></td>
                        <td>
                            <div class="form-group form-md-line-input">
                                <a value="="  title="APPLICATION FOLLOWUP" href="<?php echo $web_url; ?>Employee/viewApplicationFollowup.php?token=<?php echo $rowfilter['iAppId']; ?>">
                                <?php echo $rowfilter['applicatipnNo']; ?>
                                </a>
                            </div>
                        </td>
                        <td>
                            <div class="form-group form-md-line-input">
                                <a value="="  title="APPLICATION FOLLOWUP" href="<?php echo $web_url; ?>Employee/viewApplicationFollowup.php?token=<?php echo $rowfilter['iAppId']; ?>">
                                <?php echo $rowfilter['customerName']; ?>
                                </a>
                            </div>
                        </td>
                        <td>
                            <div class="form-group form-md-line-input">
                                <?php echo $rowfilter['customerMobile']; ?>
                            </div>
                        </td>
                        <td>
                            <div class="form-group form-md-line-input">
                                <?php echo $rowfilter['AgentName'] ?: $rowfilter['agentId']; ?>
                            </div>
                        </td>
                        <td style="text-align: right;">
                            <div class="form-group form-md-line-input">
                                <?php echo $rowfilter['loanAmount'] ?: '-'; ?>
                            </div>
                        </td>
                        <td>
                            <div class="form-group form-md-line-input">
                                <?php echo $rowfilter['bucket'] ?: '-'; ?>
                            </div>
                        </td>
                        <td>
                            <div class="form-group form-md-line-input">
                                <?php echo $rowfilter['branch'] ?: '-'; ?>
                            </div>
                        </td>
                        <td>
                            <div class="form-group form-md-line-input">
                                <?php echo $rowfilter['state'] ?: '-'; ?>
                            </div>
                        </td>
                        <td style="text-align: center;">
                            <div class="form-group form-md-line-input">
                                <?php echo $removeDate; ?>
                            </div>
                        </td>
                        <td>
                            <div class="form-group form-md-line-input">
                                <?php echo $rowfilter['remark'] ?: '-'; ?>
                            </div>
                        </td>
                        <td style="text-align: center;">
                            <button class="btn btn-sm green" onclick="restoreCase(<?php echo $rowfilter['iAppId']; ?>, '<?php echo $rowfilter['applicatipnNo']; ?>')" title="Restore Case">
                                <i class="fa fa-refresh"></i> Restore
                            </button>
                        </td>
                        <?php
                        echo "</tr>";
                        $i++;
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
                    <h1 class="font-white text-center">No Removed Cases Found!</h1>
                </div>   
            </div>
        </div>
        <?php
    }
}

// Restore case functionality
if ($_POST['action'] == 'restoreCase') {
    $appId = intval($_POST['appId']);
    $appNo = mysqli_real_escape_string($dbconn, $_POST['appNo']);
    
    // Start transaction
    mysqli_begin_transaction($dbconn);
    
    try {
        // Check if application exists in remove_application table
        $checkQuery = "SELECT * FROM remove_application WHERE iAppId = $appId";
        $checkResult = mysqli_query($dbconn, $checkQuery);
        
        if (mysqli_num_rows($checkResult) > 0) {
            $removedData = mysqli_fetch_array($checkResult);
            
            // Insert back into application table
            $insertQuery = "INSERT INTO application (
                iAppId, applicatipnNo, bucket, customerName, branch, state, customerMobile, 
                customerAddress, customerCity, customerZipcode, loanAmount, EMIAmount, 
                agencyName, agencyId, FOSName, FosNumber, FOSId, agentId, iStatus, isDelete, 
                strEntryDate, strIP, uploadId, isFollowDone, isWithdraw, isPaid, PaidDate, 
                isReassig, isEmiPending, isRollBack, remark, iAppLogId
            ) VALUES (
                " . $removedData['iAppId'] . ",
                '" . mysqli_real_escape_string($dbconn, $removedData['applicatipnNo']) . "',
                '" . mysqli_real_escape_string($dbconn, $removedData['bucket']) . "',
                '" . mysqli_real_escape_string($dbconn, $removedData['customerName']) . "',
                '" . mysqli_real_escape_string($dbconn, $removedData['branch']) . "',
                '" . mysqli_real_escape_string($dbconn, $removedData['state']) . "',
                '" . mysqli_real_escape_string($dbconn, $removedData['customerMobile']) . "',
                '" . mysqli_real_escape_string($dbconn, $removedData['customerAddress']) . "',
                '" . mysqli_real_escape_string($dbconn, $removedData['customerCity']) . "',
                '" . mysqli_real_escape_string($dbconn, $removedData['customerZipcode']) . "',
                '" . mysqli_real_escape_string($dbconn, $removedData['loanAmount']) . "',
                '" . mysqli_real_escape_string($dbconn, $removedData['EMIAmount']) . "',
                '" . mysqli_real_escape_string($dbconn, $removedData['agencyName']) . "',
                " . $removedData['agencyId'] . ",
                '" . mysqli_real_escape_string($dbconn, $removedData['FOSName']) . "',
                '" . mysqli_real_escape_string($dbconn, $removedData['FosNumber']) . "',
                " . $removedData['FOSId'] . ",
                '" . mysqli_real_escape_string($dbconn, $removedData['agentId']) . "',
                1, 0,
                '" . mysqli_real_escape_string($dbconn, $removedData['strEntryDate']) . "',
                '" . mysqli_real_escape_string($dbconn, $removedData['strIP']) . "',
                " . $removedData['uploadId'] . ",
                " . $removedData['isFollowDone'] . ",
                " . $removedData['isWithdraw'] . ",
                " . $removedData['isPaid'] . ",
                '" . mysqli_real_escape_string($dbconn, $removedData['PaidDate']) . "',
                " . $removedData['isReassig'] . ",
                " . $removedData['isEmiPending'] . ",
                " . $removedData['isRollBack'] . ",
                '" . mysqli_real_escape_string($dbconn, $removedData['remark']) . "',
                " . $removedData['iAppLogId'] . "
            )";
            
            if (mysqli_query($dbconn, $insertQuery)) {
                // Delete from remove_application table
                $deleteQuery = "DELETE FROM remove_application WHERE iAppId = $appId";
                if (mysqli_query($dbconn, $deleteQuery)) {
                    mysqli_commit($dbconn);
                    echo json_encode(['success' => true, 'message' => 'Case restored successfully!']);
                } else {
                    throw new Exception('Error deleting from remove_application table');
                }
            } else {
                throw new Exception('Error inserting into application table');
            }
        } else {
            throw new Exception('Case not found in removed cases!');
        }
    } catch (Exception $e) {
        mysqli_rollback($dbconn);
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
    exit;
}

if ($_POST['action'] == 'multiDelete') {
    $ids = $_POST['ids'] ?? [];
    
    if (empty($ids)) {
        echo json_encode(['success' => false, 'message' => 'No cases selected!']);
        exit;
    }
    
    $idList = implode(',', array_map('intval', $ids));

    // Delete permanently from remove_application
    $deleteQuery = "DELETE FROM remove_application WHERE iAppId IN ($idList)";
    if (mysqli_query($dbconn, $deleteQuery)) {
        echo json_encode(['success' => true, 'message' => 'Selected cases deleted successfully!']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error deleting selected cases.']);
    }
    exit;
}

if ($_POST['action'] == 'deleteAll') {
    $deleteQuery = "DELETE FROM remove_application";
    if (mysqli_query($dbconn, $deleteQuery)) {
        echo json_encode(['success' => true, 'message' => 'All removed cases deleted successfully!']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error deleting all cases.']);
    }
    exit;
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
<script>
$(document).ready(function() {

    // Select all checkboxes
    $('#select_all').on('click', function() {
        $('.case_checkbox').prop('checked', this.checked);
    });

    // Delete selected cases
    $('#delete_selected').on('click', function() {
        var selected = [];
        $('.case_checkbox:checked').each(function() {
            selected.push($(this).val());
        });

        if (selected.length === 0) {
            alert('Please select at least one case to delete.');
            return;
        }

        if (!confirm('Are you sure you want to permanently delete the selected case(s)?')) {
            return;
        }

        $.ajax({
            url: 'AjaxRemovedCase.php', // replace with actual PHP file name
            type: 'POST',
            data: {
                action: 'multiDelete',
                ids: selected
            },
            success: function(response) {
                try {
                    var res = JSON.parse(response);
                    alert(res.message);
                    if (res.success) location.reload();
                } catch(e) {
                    console.error(e);
                    alert('Unexpected error occurred.');
                }
            }
        });
    });

});

$('#delete_all').on('click', function() {
    if (!confirm('Are you sure you want to delete ALL removed cases?')) return;

    $.ajax({
        url: 'AjaxRemovedCase.php',
        type: 'POST',
        data: { action: 'deleteAll' },
        success: function(response) {
            var res = JSON.parse(response);
            alert(res.message);
            if (res.success) location.reload();
        }
    });
});
</script>