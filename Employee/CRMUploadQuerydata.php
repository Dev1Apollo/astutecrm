<?php

ob_start();
error_reporting(E_ALL);
include('../common.php');
$connect = new connect();
include 'IsLogin.php';
include '../password_hash.php';

//ini_set('memory_limit', '3G');
ini_set('max_execution_time', 0);
//set_time_limit(6000);

require('../spreadsheet-reader-master/SpreadsheetReader.php');
require_once '../spreadsheet-reader-master/php-excel-reader/excel_reader2.php';

$action = $_REQUEST['action'];

switch ($action) {

    case "AddCRM":

    /************ behavior toggles ************/
    $REQUIRE_MOBILE         = false;   // set true if Mobile Number must be present
    $TREAT_DUPLICATE_AS_ERR = true;    // true: duplicate Loan Number -> worngapplication
    /******************************************/

    $ErrorEntry   = 0;
    $SuccessEntry = 0;

    if (!isset($_REQUEST['IMgallery']) || trim($_REQUEST['IMgallery']) === '') {
        echo "Error: No file selected.";
        break;
    }

    $filename  = trim($_REQUEST['IMgallery']);
    $file_path = 'temp/' . $filename;

    if (!file_exists($file_path)) {
        echo "Error: File not found.";
        break;
    }

    

    $Reader = new SpreadsheetReader($file_path);
    $Sheets = $Reader->Sheets();

    // ---------- 1) PRE-FLIGHT: HEADER VALIDATION ----------
    $headerMapped = false;
    $colIdx = []; // [0]=Loan Number, [1]=Customer Name, [2]=POS Amount, [3]=Mobile Number, [4]=Agent ID

    foreach ($Sheets as $Index => $Name) {
        $Reader->ChangeSheet($Index);

        foreach ($Reader as $rowNum => $row) {
            if (!is_array($row)) $row = (array)$row;

            // normalize to strings
            for ($i = 0; $i < count($row); $i++) {
                if (is_string($row[$i])) $row[$i] = trim($row[$i]);
            }

            // find the first non-empty row and treat as header
            $allEmpty = true;
            foreach ($row as $cell) {
                if (!empty($cell) && $cell !== null) { $allEmpty = false; break; }
            }
            if ($allEmpty) { continue; }

            // map headers (case-insensitive)
            $map = ['loan number'=>0, 'customer name'=>1, 'pos amount'=>2, 'mobile number'=>3, 'agent id'=>4];
            $found = [];

            for ($i = 0; $i < count($row); $i++) {
                $label = strtolower(trim((string)$row[$i]));
                if (isset($map[$label])) {
                    $found[$map[$label]] = $i;
                }
            }

            // must have at least Loan Number, Customer Name, Agent ID
            $required = [0=>'Loan Number', 1=>'Customer Name', 4=>'Agent ID'];
            $missing  = [];
            foreach ($required as $key => $name) {
                if (!array_key_exists($key, $found)) $missing[] = $name;
            }

            if (!empty($missing)) {
                // header error -> count it and abort (no inserts)
                $ErrorEntry++;
                echo "Error: Missing required column header(s): " . implode(", ", $missing);
                echo "<br /> Error Count: " . (int)$ErrorEntry;
                echo "<br /> Success Count: " . (int)$SuccessEntry;
                @unlink($file_path);
                break 3; // exit row loop, sheet loop, and switch-case
            }

            // header OK; store indices and flag
            $colIdx = $found;         // may not include optional [2],[3] if not present
            $headerMapped = true;
            break 2; // leave preflight loops; proceed to data pass
        }
    }

    // If no non-empty sheet/row was found at all
    if (!$headerMapped) {
        $ErrorEntry++;
        echo "Error: No header row found.";
        echo "<br /> Error Count: " . (int)$ErrorEntry;
        echo "<br /> Success Count: " . (int)$SuccessEntry;
        @unlink($file_path);
        break;
    }

    // ---------- 2) DATA PASS ----------
    foreach ($Sheets as $Index => $Name) {
        $Reader->ChangeSheet($Index);
        $isHeaderRowSeen = false;

        foreach ($Reader as $rowNum => $row) {
            if (!is_array($row)) $row = (array)$row;
            for ($i = 0; $i < count($row); $i++) {
                if (is_string($row[$i])) $row[$i] = trim($row[$i]);
            }

            // Skip blank rows
            $allEmpty = true;
            foreach ($row as $cell) {
                if (!empty($cell) && $cell !== null) { $allEmpty = false; break; }
            }
            if ($allEmpty) continue;

            // First non-empty row in this sheet is header; skip it once
            if (!$isHeaderRowSeen) { $isHeaderRowSeen = true; continue; }

            // Extract using mapped indices (with defaults if optional columns missing)
            $loanNumber   = isset($colIdx[0]) ? (string)($row[$colIdx[0]] ?? '') : '';
            $customerName = isset($colIdx[1]) ? (string)($row[$colIdx[1]] ?? '') : '';
            $posAmountRaw = isset($colIdx[2]) ?        ($row[$colIdx[2]] ?? '') : '';
            $mobileRaw    = isset($colIdx[3]) ?        ($row[$colIdx[3]] ?? '') : '';
            $agentId      = isset($colIdx[4]) ? (string)($row[$colIdx[4]] ?? '') : '';

            $loanNumber   = trim($loanNumber);
            $customerName = trim($customerName);
            $agentId      = trim($agentId);

            // normalize POS amount
            $posAmount = 0;
            if ($posAmountRaw !== '' && $posAmountRaw !== null) {
                if (is_string($posAmountRaw)) {
                    $posAmount = (float)str_replace([',',' '],['',''], $posAmountRaw);
                } else {
                    $posAmount = (float)$posAmountRaw;
                }
            }

            // normalize Mobile (keep digits; avoid scientific notation)
            $mobileNumber = '';
            if ($mobileRaw !== '' && $mobileRaw !== null) {
                if (is_numeric($mobileRaw) && !is_string($mobileRaw)) {
                    $mobileNumber = number_format((float)$mobileRaw, 0, '.', '');
                } else {
                    $mobileNumber = preg_replace('/\D+/', '', (string)$mobileRaw);
                }
            }

            // validate row
            $rowErrors = [];
            if ($loanNumber === '')   { $rowErrors[] = "Loan Number is blank."; }
            if ($customerName === '') { $rowErrors[] = "Customer Name is blank."; }
            // if ($REQUIRE_MOBILE && $mobileNumber === '') { $rowErrors[] = "Mobile Number is blank."; }
            if ($mobileNumber === '' || strlen($mobileNumber) !== 10 || !ctype_digit($mobileNumber)) {
                $rowErrors[] = "Mobile Number is invalid. It must be a 10-digit number.";
            }
            $posAmount = 0;
            if ($posAmountRaw !== '' && $posAmountRaw !== null) {
                if (is_string($posAmountRaw)) {
                    $cleaned = str_replace([',', ' '], ['', ''], $posAmountRaw);
                    if (preg_match('/^\d+(\.\d+)?$/', $cleaned)) {
                        $posAmount = (float)$cleaned;
                    } else {
                        $posAmount = 'INVALID';
                    }
                } else {
                    $posAmount = (float)$posAmountRaw;
                }
            }
            
            if (!is_numeric($posAmount) || $posAmount === 'INVALID' || $posAmount < 0) {
                $rowErrors[] = "POS Amount is invalid. It must be a numeric value.";
            }

            if ($agentId === '') {
                $rowErrors[] = "Agent ID is blank.";
            } else {
                $q = mysqli_query($dbconn,
                    "SELECT COUNT(*) AS cnt FROM employee inner join employeedesignation on employee.employeeid=employeedesignation.iEmployeeId WHERE employeedesignation.iDesignationId=5 AND elisionloginid='" . mysqli_real_escape_string($dbconn, $agentId) . "' and employee.istatus=1 and employee.isDelete=0"
                ) or die(mysqli_error($dbconn));
                $r = mysqli_fetch_assoc($q);
                if ((int)$r['cnt'] === 0) {
                    $rowErrors[] = "Agent ID '{$agentId}' not found.";
                }
            }

            // duplicate policy
            if ($TREAT_DUPLICATE_AS_ERR && $loanNumber !== '') {
                $qDup = mysqli_query($dbconn,
                    "SELECT iAppId FROM application 
                     WHERE isDelete='0' AND applicatipnNo='" . mysqli_real_escape_string($dbconn, $loanNumber) . "'
                     ORDER BY iAppId DESC LIMIT 1"
                ) or die(mysqli_error($dbconn));
                if (mysqli_num_rows($qDup) > 0) {
                    $rowErrors[] = "Loan Number '{$loanNumber}' already exists.";
                }
            }

            if (!empty($rowErrors)) {
                // push to worngapplication
                $ErrorEntry++;
                $connect->insertrecord($dbconn, "worngapplication", [
                    "applicatipnNo"   => $loanNumber,
                    "bucket"          => "",
                    "customerName"    => $customerName,
                    "branch"          => "",
                    "state"           => "",
                    "customerAddress" => "",
                    "customerCity"    => "",
                    "customerZipcode" => "",
                    "loanAmount"      => $posAmount,     // POS Amount stored in loanAmount
                    // uncomment next line only if you actually have this column:
                    // "posAmount"       => $posAmount,
                    "EMIAmount"       => "",
                    "agencyName"      => "",
                    "agencyId"        => 0,
                    "FOSName"         => "",
                    "customerMobile"  => $mobileNumber,
                    "FosNumber"       => "",  // keep legacy field name for compatibility
                    // uncomment next line only if you actually have this column:
                    // "mobileNumber"    => $mobileNumber,
                    "FOSId"           => 0,
                    "agentId"         => $agentId,
                    "uploadId"        => trim($_SESSION['EmployeeId'] ?? 0),
                    "isEmiPending"    => 0,
                    "isRollBack"      => 0,
                    "strEntryDate"    => date("d-m-Y H:i:s"),
                    "strIP"           => $_SERVER['REMOTE_ADDR'] ?? '',
                    "ErrorLog"        => implode(" ", $rowErrors),
                ]);
                continue;
            }

            // good row -> insert into application
            $connect->insertrecord($dbconn, "application", [
                "applicatipnNo"   => $loanNumber,
                "bucket"          => "",
                "customerName"    => $customerName,
                "branch"          => "",
                "state"           => "",
                "customerAddress" => "",
                "customerCity"    => "",
                "customerZipcode" => "",
                "loanAmount"      => $posAmount,     // POS Amount saved as loanAmount
                // uncomment if the table has it:
                // "posAmount"       => $posAmount,
                "EMIAmount"       => "",
                "agencyName"      => "",
                "agencyId"        => 0,
                "FOSName"         => "",
                "customerMobile"  => $mobileNumber,
                "FosNumber"       => "",
                // uncomment if the table has it:
                // "mobileNumber"    => $mobileNumber,
                "FOSId"           => 0,
                "agentId"         => $agentId,
                "uploadId"        => trim($_SESSION['EmployeeId'] ?? 0),
                "isEmiPending"    => 0,
                "isRollBack"      => 0,
                "strEntryDate"    => date("d-m-Y H:i:s"),
                "strIP"           => $_SERVER['REMOTE_ADDR'] ?? '',
            ]);
            $SuccessEntry++;
        }
    }

    echo "Error Count: " . (int)$ErrorEntry;
    echo "<br /> Success Count: " . (int)$SuccessEntry;

    @unlink($file_path);
    break;



    default:
        echo "Page not Found";
        break;
}
