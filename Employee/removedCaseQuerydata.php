<?php
ob_start();
include('../common.php');
$connect = new connect();
include 'IsLogin.php';
include '../password_hash.php';
require('../spreadsheet-reader-master/SpreadsheetReader.php');
require_once ('../spreadsheet-reader-master/php-excel-reader/excel_reader2.php');
ini_set('max_execution_time', 0);
$action = $_REQUEST['action'];

switch ($action) {
    
    case "uploadedRemovedCase":

        $errorString = "";
        $iColumnCounter = array();
        $ValCounter = 0;
        $jCounterArray = 0;

        if (isset($_REQUEST['IMgallery'])) {

            $headerArray = array();
            $filename = trim($_REQUEST['IMgallery']);
            $file_path = 'temp/' . $filename;
            $Reader = new SpreadsheetReader($file_path);
            $Sheets = $Reader->Sheets();

            // First Pass: Validate & Collect Errors
            foreach ($Sheets as $Index => $Name) {
                $Reader->ChangeSheet($Index);

                foreach ($Reader as $key => $slice) {

                    // Skip empty rows
                    if (empty(array_filter($slice))) {
                        continue;
                    }

                    if ($ValCounter == 0) {
                        // Read headers
                        for ($icounter = 0; $icounter < count($slice); $icounter++) {
                            $header = trim($slice[$icounter]);

                            if ($header != "") {
                                $headerArray[$jCounterArray] = $header;

                                if ($header == "Loan Number") {
                                    $iColumnCounter['loan_number'] = $icounter;
                                }

                                $jCounterArray++;
                            }
                        }
                    } else {
                        $RowCounter = $key + 1; // Use actual Excel row number

                        $loanNumber  = trim($slice[$iColumnCounter['loan_number']] ?? '');

                        // Validation checks
                        if ($loanNumber == "") {
                            $errorString .= "Row $RowCounter: Loan Application No is missing.<br/>";
                            continue;
                        }

                        // Check if application exists
                        $result = mysqli_query($dbconn, "SELECT count(*) as countS, application.* 
                                                         FROM application 
                                                         WHERE isDelete='0' 
                                                           AND applicatipnNo='" . mysqli_real_escape_string($dbconn, $loanNumber) . "' 
                                                         GROUP BY iAppId 
                                                         ORDER BY iAppId DESC 
                                                         LIMIT 1") or die(mysqli_error($dbconn));

                        $app = mysqli_fetch_assoc($result);

                        if (!$app || $app['countS'] == 0) {
                            $errorString .= "Row $RowCounter: Loan Application No '$loanNumber' not found.<br/>";
                            continue;
                        }

                        if (trim($app['agentId']) == '') {
                            $errorString .= "Row $RowCounter: Agent not assigned to application '$loanNumber'.<br/>";
                            continue;
                        }

                        // Check if user has permission to remove this case
                        if (!hasPermission($app['agentId'])) {
                            $errorString .= "Row $RowCounter: Permission denied for application '$loanNumber'.<br/>";
                            continue;
                        }

                        // Check if already removed
                        $checkRemoved = mysqli_query($dbconn, "SELECT * FROM remove_application WHERE applicatipnNo='" . mysqli_real_escape_string($dbconn, $loanNumber) . "'");
                        if (mysqli_num_rows($checkRemoved) > 0) {
                            $errorString .= "Row $RowCounter: Application '$loanNumber' is already removed.<br/>";
                            continue;
                        }
                    }

                    $ValCounter++;
                }
            }

            // Check for missing headers
            if (!isset($iColumnCounter['loan_number'])) {
                echo "Error: Required column header is missing (Loan Application No).";
                unlink($file_path);
                break;
            }

            // Output validation errors if any
            if (!empty($errorString)) {
                echo "Error:<br/>" . $errorString;
                unlink($file_path);
                break;
            }

            // Second Pass: Insert and Update
            $iCounterRow = 0;
            foreach ($Sheets as $Index => $Name) {
                $Reader->ChangeSheet($Index);

                foreach ($Reader as $key => $slice) {
                    // Skip empty rows
                    if (empty(array_filter($slice))) {
                        continue;
                    }

                    if ($iCounterRow == 0) {
                        $iCounterRow++;
                        continue;
                    }

                    $loanNumber  = trim($slice[$iColumnCounter['loan_number']] ?? '');

                    // Get latest application record
                    $result = mysqli_query($dbconn, "SELECT * 
                                                     FROM application 
                                                     WHERE isDelete='0' 
                                                       AND applicatipnNo='" . mysqli_real_escape_string($dbconn, $loanNumber) . "' 
                                                     ORDER BY iAppId DESC 
                                                     LIMIT 1") or die(mysqli_error($dbconn));

                    $app = mysqli_fetch_assoc($result);
                    $applicationId = $app['iAppId'];

                    // Start transaction
                    mysqli_begin_transaction($dbconn);

                    try {
                        // Prepare data with proper NULL handling
                        $applicatipnNo = !empty($app['applicatipnNo']) ? "'" . mysqli_real_escape_string($dbconn, $app['applicatipnNo']) . "'" : "NULL";
                        $bucket = !empty($app['bucket']) ? "'" . mysqli_real_escape_string($dbconn, $app['bucket']) . "'" : "NULL";
                        $customerName = !empty($app['customerName']) ? "'" . mysqli_real_escape_string($dbconn, $app['customerName']) . "'" : "NULL";
                        $branch = !empty($app['branch']) ? "'" . mysqli_real_escape_string($dbconn, $app['branch']) . "'" : "NULL";
                        $state = !empty($app['state']) ? "'" . mysqli_real_escape_string($dbconn, $app['state']) . "'" : "NULL";
                        $customerMobile = !empty($app['customerMobile']) ? "'" . mysqli_real_escape_string($dbconn, $app['customerMobile']) . "'" : "NULL";
                        $customerAddress = !empty($app['customerAddress']) ? "'" . mysqli_real_escape_string($dbconn, $app['customerAddress']) . "'" : "NULL";
                        $customerCity = !empty($app['customerCity']) ? "'" . mysqli_real_escape_string($dbconn, $app['customerCity']) . "'" : "NULL";
                        $customerZipcode = !empty($app['customerZipcode']) ? "'" . mysqli_real_escape_string($dbconn, $app['customerZipcode']) . "'" : "NULL";
                        $loanAmount = !empty($app['loanAmount']) ? "'" . mysqli_real_escape_string($dbconn, $app['loanAmount']) . "'" : "NULL";
                        $EMIAmount = !empty($app['EMIAmount']) ? "'" . mysqli_real_escape_string($dbconn, $app['EMIAmount']) . "'" : "NULL";
                        $agencyName = !empty($app['agencyName']) ? "'" . mysqli_real_escape_string($dbconn, $app['agencyName']) . "'" : "NULL";
                        $agencyId = !empty($app['agencyId']) ? $app['agencyId'] : "0";
                        $FOSName = !empty($app['FOSName']) ? "'" . mysqli_real_escape_string($dbconn, $app['FOSName']) . "'" : "NULL";
                        $FosNumber = !empty($app['FosNumber']) ? "'" . mysqli_real_escape_string($dbconn, $app['FosNumber']) . "'" : "NULL";
                        $FOSId = !empty($app['FOSId']) ? $app['FOSId'] : "0";
                        $agentId = !empty($app['agentId']) ? "'" . mysqli_real_escape_string($dbconn, $app['agentId']) . "'" : "NULL";
                        $strIP = !empty($_SERVER['REMOTE_ADDR']) ? "'" . $_SERVER['REMOTE_ADDR'] . "'" : "NULL";
                        $uploadId = !empty($app['uploadId']) ? $app['uploadId'] : "0";
                        $PaidDate = !empty($app['PaidDate']) ? "'" . mysqli_real_escape_string($dbconn, $app['PaidDate']) . "'" : "NULL";
                        $remark = !empty($app['remark']) ? "'" . mysqli_real_escape_string($dbconn, $app['remark']) . "'" : "NULL";
                        $iAppLogId = !empty($app['iAppLogId']) ? $app['iAppLogId'] : "0";

                        // 1. Insert into remove_application table
                        $insertQuery = "INSERT INTO remove_application (
                            iAppId, applicatipnNo, bucket, customerName, branch, state, customerMobile, 
                            customerAddress, customerCity, customerZipcode, loanAmount, EMIAmount, 
                            agencyName, agencyId, FOSName, FosNumber, FOSId, agentId, iStatus, isDelete, 
                            strEntryDate, strIP, uploadId, isFollowDone, isWithdraw, isPaid, PaidDate, 
                            isReassig, isEmiPending, isRollBack, remark, iAppLogId
                        ) VALUES (
                            " . $app['iAppId'] . ",
                            $applicatipnNo,
                            $bucket,
                            $customerName,
                            $branch,
                            $state,
                            $customerMobile,
                            $customerAddress,
                            $customerCity,
                            $customerZipcode,
                            $loanAmount,
                            $EMIAmount,
                            $agencyName,
                            $agencyId,
                            $FOSName,
                            $FosNumber,
                            $FOSId,
                            $agentId,
                            1, 0,
                            '" . date('d-m-Y H:i:s') . "',
                            $strIP,
                            $uploadId,
                            " . $app['isFollowDone'] . ",
                            " . $app['isWithdraw'] . ",
                            " . $app['isPaid'] . ",
                            $PaidDate,
                            " . $app['isReassig'] . ",
                            " . $app['isEmiPending'] . ",
                            " . $app['isRollBack'] . ",
                            $remark,
                            $iAppLogId
                        )";

                        mysqli_query($dbconn, $insertQuery) or die("Error inserting into remove_application at row $iCounterRow: " . mysqli_error($dbconn));

                        // 2. Delete from application table
                        $deleteQuery = "DELETE FROM application WHERE iAppId = '$applicationId' AND isDelete = 0";
                        mysqli_query($dbconn, $deleteQuery) or die("Error deleting from application at row $iCounterRow: " . mysqli_error($dbconn));

                        mysqli_commit($dbconn);

                    } catch (Exception $e) {
                        mysqli_rollback($dbconn);
                        $errorString .= "Row $iCounterRow: Database error for application '$loanNumber'.<br/>";
                        continue;
                    }

                    $iCounterRow++;
                }
            }

            echo "Removed cases uploaded successfully. Total cases processed: " . ($iCounterRow - 1);

            @unlink($file_path);
        }

    break;
        
    default:
        echo "Page not Found";
        break;
}

function hasPermission($caseAgentId) {
    global $dbconn;
    
    // Team Leaders and Managers can remove any case in their team
    if ($_SESSION['Designation'] == 4 || $_SESSION['Designation'] == 6) {
        if ($_SESSION['Designation'] == 4) {
            // Team Leader - check if case belongs to their team
            $teamCheck = mysqli_query($dbconn, "SELECT * FROM employee WHERE elisionloginid = '$caseAgentId' AND iteamleadid = '" . $_SESSION['EmployeeId'] . "'");
            return mysqli_num_rows($teamCheck) > 0;
        } else if ($_SESSION['Designation'] == 6) {
            // Manager - check if case belongs to their team
            // $teamCheck = mysqli_query($dbconn, "SELECT * FROM employee WHERE elisionloginid = '$caseAgentId' AND asstmanagerid = '" . $_SESSION['EmployeeId'] . "'");
            // return mysqli_num_rows($teamCheck) > 0;
            return 1;
        }
    } else {
        // Regular employees can only remove their own cases
        return $caseAgentId == $_SESSION['elisionloginid'];
    }
    
    return false;
}
?>