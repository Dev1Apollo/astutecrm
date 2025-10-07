<?php

ob_start();
error_reporting(0);
include('../common.php');
$connect = new connect();
include 'IsLogin.php';
include 'password_hash.php';

require('../spreadsheet-reader-master/SpreadsheetReader.php');
require_once '../spreadsheet-reader-master/php-excel-reader/excel_reader2.php';
$action = $_REQUEST['action'];

switch ($action) {

    case "AddEmployeeIncentiveData":

        $Date = 0;
        $errorString = "";
        $iColumnCounter = array();
        $ValCounter = 0;
        $Login = 0;
        $RowCounter = 0;
        $jCounterArray = 0;
        $LoginTime = 0;

        if (isset($_REQUEST['IMgallery'])) {
            $headerArray = array();
            $filename = trim($_REQUEST['IMgallery']);
            $file_path = 'temp/' . $filename;
            $Reader = new SpreadsheetReader($file_path);
            $Sheets = $Reader->Sheets();

            foreach ($Sheets as $Index => $Name) {
                $Reader->ChangeSheet($Index);
                $col1Value = "";
                foreach ($Reader as $key => $slice) {
                    if ($ValCounter == 0) {
                        for ($icounter = 0; $icounter < count($slice); $icounter ++) {
                            if (trim($slice[$icounter]) != "") {
                                $headerArray[$jCounterArray] = $slice[$icounter];
                                $jCounterArray++;
                                if (trim($slice[$icounter]) == "Date") {
                                    $iColumnCounter[0] = $icounter;
                                }
                                if (trim($slice[$icounter]) == "Elision Login Id") {
                                    $iColumnCounter[1] = $icounter;
                                }
                                if (trim($slice[$icounter]) == "Incentive Scheme") {
                                    $iColumnCounter[2] = $icounter;
                                }
                                if (trim($slice[$icounter]) == "Incentive Earned") {
                                    $iColumnCounter[3] = $icounter;
                                }
                            }
                        }
                    } else {
                        $RowCounter = $ValCounter + 1;
                        for ($icounter = 0; $icounter < count($slice); $icounter++) {
                            if ($icounter == 0) {
                                $col1Value = $slice[$icounter];
                            }
                            if ($icounter == $iColumnCounter) {
                                $iColumnCnt = $slice[$icounter];
                            }
                            if ($icounter == $iColumnCounter[1]) {
                                $Login = $slice[$icounter];
                                if (trim($Login) != "") {
                                    $Reselisionloginid = mysqli_query($dbconn, "SELECT count(*)as countS,employee.* FROM employee  where isDelete='0' and elisionloginid='" . $Login . "'") OR die(mysqli_error($dbconn));
                                    $elisionloginid = mysqli_fetch_array($Reselisionloginid);
                                    if ($elisionloginid['countS'] == 0) {
                                        $errorString .= "Row " . $RowCounter . " & Login =" . $Login . "  Not exists. <br/>";
                                    } else {
                                        $elisionloginidRow = $elisionloginid['elisionloginid'];
                                    }
                                }
                            }
                            if ($icounter == $iColumnCounter[0]) {
                                $Date = $slice[$icounter];
                                if (trim($Date) != "") {
//                                    echo "SELECT count(*)as countS,incentivemaster.* FROM incentivemaster  where isDelete='0' and elisionloginid = '".$slice[$iColumnCounter[1]]."' and date like '%" . $Date . "%'";
                                    $IncentiveDate = mysqli_query($dbconn, "SELECT count(*)as countS,incentivemaster.* FROM incentivemaster  where isDelete='0' and elisionloginid = '" . $slice[$iColumnCounter[1]] . "' and date='" . $Date . "'") OR die(mysqli_error($dbconn));
                                    $rowIncentiveDate = mysqli_fetch_array($IncentiveDate);
                                    if ($rowIncentiveDate['countS'] > 0) {
                                        $errorString .= "Row " . $RowCounter . " & Date =" . $Date . "  already exists. <br/>";
                                    } else {
                                        $elisionloginidRow = $rowIncentiveDate['date'];
                                    }
                                }
                            }
                        }
                    }
                    $ValCounter ++;
                }
            }

            if (trim($iColumnCounter[0]) == '' || trim($iColumnCounter[1]) == '' || trim($iColumnCounter[2]) == '' || trim($iColumnCounter[3]) == '') {
                echo "Error : " . "Column Header Not Match";
                unlink($file_path);
                break;
            } else if (trim($errorString) != "") {
                echo "Error : " . $errorString;
                unlink($file_path);
                break;
            } else {
                $iCounterRow = 0;
                foreach ($Sheets as $Index => $Name) {
                    $Reader->ChangeSheet($Index);
                    if ($Reader != null) {
                        foreach ($Reader as $key => $slice) {
                            if ($iCounterRow > 0) {
                                if ($slice != null && $slice[$iColumnCounter[0]] != '' && $slice[$iColumnCounter[1]] != '' && $slice[$iColumnCounter[2]] != '' && $slice[$iColumnCounter[3]] != '') {
                                    $data = array(
                                        "date" => trim($slice[$iColumnCounter[0]]),
                                        "incentiveScheme" => trim($slice[$iColumnCounter[2]]),
                                        "incentiveEarned" => trim($slice[$iColumnCounter[3]]),
                                        "elisionloginid" => trim($slice[$iColumnCounter[1]]),
                                        "strEntryDate" => date("d-m-Y H:i:s"),
                                        "strIP" => $_SERVER['REMOTE_ADDR']
                                    );
                                    $InsertIncentive = $connect->insertrecord($dbconn, "incentivemaster", $data);
                                }
                            }
                            $iCounterRow++;
                        }
                    }
                }
                echo "Data Uploaded Successfully";
            }
            @unlink($file_path);
            echo $errorString;
        }
        @unlink($file_path);
        break;

    case "AddEmployeeQualityData":

        $Date = 0;
        $errorString = "";
        $iColumnCounter = array();
        $ValCounter = 0;
        $Login = 0;
        $RowCounter = 0;
        $jCounterArray = 0;
        $LoginTime = 0;

        if (isset($_REQUEST['IMgallery'])) {
            $headerArray = array();
            $filename = trim($_REQUEST['IMgallery']);
            $file_path = 'temp/' . $filename;
            $Reader = new SpreadsheetReader($file_path);
            $Sheets = $Reader->Sheets();

            foreach ($Sheets as $Index => $Name) {
                $Reader->ChangeSheet($Index);
                $col1Value = "";
                foreach ($Reader as $key => $slice) {
                    if ($ValCounter == 0) {
                        for ($icounter = 0; $icounter < count($slice); $icounter ++) {
                            if (trim($slice[$icounter]) != "") {
                                $headerArray[$jCounterArray] = $slice[$icounter];
                                $jCounterArray++;
                                if (trim($slice[$icounter]) == "Date") {
                                    $iColumnCounter[0] = $icounter;
                                }
                                if (trim($slice[$icounter]) == "Elision Login Id") {
                                    $iColumnCounter[1] = $icounter;
                                }
                                if (trim($slice[$icounter]) == "No. of Call Audited") {
                                    $iColumnCounter[2] = $icounter;
                                }
                                if (trim($slice[$icounter]) == "Audit Score") {
                                    $iColumnCounter[3] = $icounter;
                                }
                                if (trim($slice[$icounter]) == "Auditor") {
                                    $iColumnCounter[4] = $icounter;
                                }
                                if (trim($slice[$icounter]) == "Remark") {
                                    $iColumnCounter[5] = $icounter;
                                }
                            }
                        }
                    } else {
                        $RowCounter = $ValCounter + 1;
                        for ($icounter = 0; $icounter < count($slice); $icounter++) {
                            if ($icounter == 0) {
                                $col1Value = $slice[$icounter];
                            }
                            if ($icounter == $iColumnCounter) {
                                $iColumnCnt = $slice[$icounter];
                            }
                            if ($icounter == $iColumnCounter[1]) {
                                $Login = $slice[$icounter];
                                if (trim($Login) != "") {
                                    $Reselisionloginid = mysqli_query($dbconn, "SELECT count(*)as countS,employee.* FROM employee  where isDelete='0' and elisionloginid='" . $Login . "'") OR die(mysqli_error($dbconn));
                                    $elisionloginid = mysqli_fetch_array($Reselisionloginid);
                                    if ($elisionloginid['countS'] == 0) {
                                        $errorString .= "Row " . $RowCounter . " & Login =" . $Login . "  Not exists. <br/>";
                                    } else {
                                        $elisionloginidRow = $elisionloginid['elisionloginid'];
                                    }
                                }
                            }
                            if ($icounter == $iColumnCounter[0]) {
                                $Date = $slice[$icounter];
                                if (trim($Date) != "") {
//                                    echo "SELECT count(*)as countS,incentivemaster.* FROM incentivemaster  where isDelete='0' and elisionloginid = '".$slice[$iColumnCounter[1]]."' and date like '%" . $Date . "%'";
                                    $IncentiveDate = mysqli_query($dbconn, "SELECT count(*)as countS,quality.* FROM quality  where isDelete='0' and elisionloginid = '" . $slice[$iColumnCounter[1]] . "' and date='" . $Date . "'") OR die(mysqli_error($dbconn));
                                    $rowIncentiveDate = mysqli_fetch_array($IncentiveDate);
                                    if ($rowIncentiveDate['countS'] > 0) {
                                        $errorString .= "Row " . $RowCounter . " & Date =" . $Date . "  already exists. <br/>";
                                    } else {
                                        $elisionloginidRow = $rowIncentiveDate['date'];
                                    }
                                }
                            }
                        }
                    }
                    $ValCounter ++;
                }
            }

            if (trim($iColumnCounter[0]) == '' || trim($iColumnCounter[1]) == '' || trim($iColumnCounter[2]) == '' || trim($iColumnCounter[3]) == '') {
                echo "Error : " . "Column Header Not Match";
                unlink($file_path);
                break;
            } else if (trim($errorString) != "") {
                echo "Error : " . $errorString;
                unlink($file_path);
                break;
            } else {
                $iCounterRow = 0;
                foreach ($Sheets as $Index => $Name) {
                    $Reader->ChangeSheet($Index);
                    if ($Reader != null) {
                        foreach ($Reader as $key => $slice) {
                            if ($iCounterRow > 0) {
                                if ($slice != null && $slice[$iColumnCounter[0]] != '' && $slice[$iColumnCounter[1]] != '' && $slice[$iColumnCounter[2]] != '' && $slice[$iColumnCounter[3]] != '') {
                                    $data = array(
                                        "date" => trim($slice[$iColumnCounter[0]]),
                                        "callAudited" => trim($slice[$iColumnCounter[2]]),
                                        "auditScore" => trim($slice[$iColumnCounter[3]]),
                                        "auditor" => trim($slice[$iColumnCounter[4]]),
                                        "Remark" => trim($slice[$iColumnCounter[5]]),
                                        "elisionloginid" => trim($slice[$iColumnCounter[1]]),
                                        "strEntryDate" => date("d-m-Y H:i:s"),
                                        "strIP" => $_SERVER['REMOTE_ADDR']
                                    );
                                    $Insertquality = $connect->insertrecord($dbconn, "quality", $data);
                                }
                            }
                            $iCounterRow++;
                        }
                    }
                }
                echo "Data Uploaded Successfully";
            }
            @unlink($file_path);
            echo $errorString;
        }
        @unlink($file_path);
        break;

    case "AddEmployeeTLDashboardData":

        $Date = 0;
        $errorString = "";
        $iColumnCounter = array();
        $ValCounter = 0;
        $Login = 0;
        $RowCounter = 0;
        $jCounterArray = 0;
        $LoginTime = 0;

        if (isset($_REQUEST['IMgallery'])) {
            $headerArray = array();
            $filename = trim($_REQUEST['IMgallery']);
            $file_path = 'temp/' . $filename;
            $Reader = new SpreadsheetReader($file_path);
            $Sheets = $Reader->Sheets();

            foreach ($Sheets as $Index => $Name) {
                $Reader->ChangeSheet($Index);
                $col1Value = "";
                foreach ($Reader as $key => $slice) {
                    if ($ValCounter == 0) {
                        for ($icounter = 0; $icounter < count($slice); $icounter ++) {
                            if (trim($slice[$icounter]) != "") {
                                $headerArray[$jCounterArray] = $slice[$icounter];
                                $jCounterArray++;
                                if (trim($slice[$icounter]) == "Date") {
                                    $iColumnCounter[0] = $icounter;
                                }
                                if (trim($slice[$icounter]) == "TL Login Id") {
                                    $iColumnCounter[1] = $icounter;
                                }
                                if (trim($slice[$icounter]) == "Total Agents") {
                                    $iColumnCounter[2] = $icounter;
                                }
                                if (trim($slice[$icounter]) == "Attendance") {
                                    $iColumnCounter[3] = $icounter;
                                }
//                                if (trim($slice[$icounter]) == "Login Hours Target") {
//                                    $iColumnCounter[4] = $icounter;
//                                }
                                if (trim($slice[$icounter]) == "Login Hours Delivered") {
                                    $iColumnCounter[4] = $icounter;
                                }
                            }
                        }
                    } else {
                        $RowCounter = $ValCounter + 1;
                        for ($icounter = 0; $icounter < count($slice); $icounter++) {
                            if ($icounter == 0) {
                                $col1Value = $slice[$icounter];
                            }
                            if ($icounter == $iColumnCounter) {
                                $iColumnCnt = $slice[$icounter];
                            }
                            if ($icounter == $iColumnCounter[1]) {
                                $Login = $slice[$icounter];
                                if (trim($Login) != "") {
                                    $Reselisionloginid = mysqli_query($dbconn, "SELECT count(*)as countS,employee.* FROM employee  where isDelete='0' and elisionloginid='" . $Login . "'") OR die(mysqli_error($dbconn));
                                    $elisionloginid = mysqli_fetch_array($Reselisionloginid);
                                    if ($elisionloginid['countS'] == 0) {
                                        $errorString .= "Row " . $RowCounter . " & Login =" . $Login . "  Not exists. <br/>";
                                    } else {
                                        $elisionloginidRow = $elisionloginid['elisionloginid'];
                                    }
                                }
                            }
                            if ($icounter == $iColumnCounter[0]) {
                                $Date = $slice[$icounter];
                                if (trim($Date) != "") {
//                                    echo "SELECT count(*)as countS,incentivemaster.* FROM incentivemaster  where isDelete='0' and elisionloginid = '".$slice[$iColumnCounter[1]]."' and date like '%" . $Date . "%'";
                                    $IncentiveDate = mysqli_query($dbconn, "SELECT count(*)as countS,tldeshboardmaster.* FROM tldeshboardmaster  where isDelete='0' and elisionloginid = '" . $slice[$iColumnCounter[1]] . "' and date='" . $Date . "'") OR die(mysqli_error($dbconn));
                                    $rowIncentiveDate = mysqli_fetch_array($IncentiveDate);
                                    if ($rowIncentiveDate['countS'] > 0) {
                                        $errorString .= "Row " . $RowCounter . " & Date =" . $Date . "  already exists. <br/>";
                                    } else {
                                        $elisionloginidRow = $rowIncentiveDate['date'];
                                    }
                                }
                            }
                        }
                    }
                    $ValCounter ++;
                }
            }

            if (trim($iColumnCounter[0]) == '' || trim($iColumnCounter[1]) == '' || trim($iColumnCounter[2]) == '' || trim($iColumnCounter[3]) == '') {
                echo "Error : " . "Column Header Not Match";
                unlink($file_path);
                break;
            } else if (trim($errorString) != "") {
                echo "Error : " . $errorString;
                unlink($file_path);
                break;
            } else {
                $iCounterRow = 0;
                foreach ($Sheets as $Index => $Name) {
                    $Reader->ChangeSheet($Index);
                    if ($Reader != null) {
                        foreach ($Reader as $key => $slice) {

                            if ($iCounterRow > 0) {
                                if ($slice != null && $slice[$iColumnCounter[0]] != '' && $slice[$iColumnCounter[1]] != '' && $slice[$iColumnCounter[2]] != '' && $slice[$iColumnCounter[3]] != '') {
                                    $loginHoursTarget = trim($slice[$iColumnCounter[2]]) * 208;
                                    $data = array(
                                        "date" => trim($slice[$iColumnCounter[0]]),
                                        "totalAgent" => trim($slice[$iColumnCounter[2]]),
                                        "attendance" => trim($slice[$iColumnCounter[3]]),
                                        "loginHoursTarget" => $loginHoursTarget,
                                        "loginHoursDelivered" => trim($slice[$iColumnCounter[4]]),
                                        "elisionloginid" => trim($slice[$iColumnCounter[1]]),
                                        "strEntryDate" => date("d-m-Y H:i:s"),
                                        "strIP" => $_SERVER['REMOTE_ADDR']
                                    );

                                    $Insertquality = $connect->insertrecord($dbconn, "tldeshboardmaster", $data);
                                }
                            }
                            $iCounterRow++;
                        }
                    }
                }
                echo "Data Uploaded Successfully";
            }
            @unlink($file_path);
            echo $errorString;
        }
        @unlink($file_path);
        break;

    case "AddCRM":

        $Date = 0;
        $errorString = "";
        $iColumnCounter = array();
        $ValCounter = 0;
        $Login = 0;
        $RowCounter = 0;
        $jCounterArray = 0;
        $LoginTime = 0;

        if (isset($_REQUEST['IMgallery'])) {
            $headerArray = array();
            $filename = trim($_REQUEST['IMgallery']);
            $file_path = 'temp/' . $filename;
            $Reader = new SpreadsheetReader($file_path);
            $Sheets = $Reader->Sheets();

            foreach ($Sheets as $Index => $Name) {
                $Reader->ChangeSheet($Index);
                $col1Value = "";
                foreach ($Reader as $key => $slice) {
                    if ($ValCounter == 0) {
                        for ($icounter = 0; $icounter < count($slice); $icounter ++) {
                            if (trim($slice[$icounter]) != "") {
                                $headerArray[$jCounterArray] = $slice[$icounter];
                                $jCounterArray++;
                                if (trim($slice[$icounter]) == "Loan Application No") {
                                    $iColumnCounter[0] = $icounter;
                                }
                                if (trim($slice[$icounter]) == "Bkt") {
                                    $iColumnCounter[1] = $icounter;
                                }
                                if (trim($slice[$icounter]) == "Customer Name") {
                                    $iColumnCounter[2] = $icounter;
                                }
                                if (trim($slice[$icounter]) == "Branch") {
                                    $iColumnCounter[3] = $icounter;
                                }
                                if (trim($slice[$icounter]) == "State") {
                                    $iColumnCounter[4] = $icounter;
                                }
                                if (trim($slice[$icounter]) == "Customer  Address") {
                                    $iColumnCounter[5] = $icounter;
                                }
                                if (trim($slice[$icounter]) == "Customer  City") {
                                    $iColumnCounter[6] = $icounter;
                                }
                                if (trim($slice[$icounter]) == "Customer  Zip Code") {
                                    $iColumnCounter[7] = $icounter;
                                }
                                if (trim($slice[$icounter]) == "Loan Amount") {
                                    $iColumnCounter[8] = $icounter;
                                }
                                if (trim($slice[$icounter]) == "EMI Amount") {
                                    $iColumnCounter[9] = $icounter;
                                }
                                if (trim($slice[$icounter]) == "Agency Name") {
                                    $iColumnCounter[10] = $icounter;
                                }
                                if (trim($slice[$icounter]) == "FOS Name") {
                                    $iColumnCounter[11] = $icounter;
                                }
                                if (trim($slice[$icounter]) == "FOS Contact") {
                                    $iColumnCounter[12] = $icounter;
                                }
                                if (trim($slice[$icounter]) == "Agent ID") {
                                    $iColumnCounter[13] = $icounter;
                                }
                            }
                        }
                    } else {
                        $RowCounter = $ValCounter + 1;
                        for ($icounter = 0; $icounter < count($slice); $icounter++) {
                            if ($icounter == 0) {
                                $col1Value = $slice[$icounter];
                            }
                            if ($icounter == $iColumnCounter) {
                                $iColumnCnt = $slice[$icounter];
                            }
                            if ($icounter == $iColumnCounter[0]) {
                                $Bukect = $slice[1];
                                if ($Bukect == '1') {
                                    $applicatipnNo = $slice[$icounter];
                                    if (trim($applicatipnNo) != "") {
                                        $filterApplicatipnNo = mysqli_query($dbconn, "SELECT * FROM application  where isPaid!=1 and bucket='1' and isWithdraw!=1 and  isDelete='0' and applicatipnNo='" . $applicatipnNo . "' GROUP BY iAppId ORDER BY `application`.`iAppId` DESC limit 1") OR die(mysqli_error($dbconn));
                                        $rowApplication = mysqli_fetch_array($filterApplicatipnNo);
                                        if (mysqli_num_rows($filterApplicatipnNo) > 0) {

                                            $errorString .= "Row " . $RowCounter . " & Load Applicaton Number =" . $applicatipnNo . "  Already exists. <br/>";
                                        } else {
                                            $AgencyRow = $rowApplication['applicatipnNo'];
                                        }
                                    } else {
                                        //error application number cannot be blank
                                        $errorString .= "Row " . $RowCounter . " & Load Applicaton Number is blank exists. <br/>";
                                    }
                                } else if ($Bukect == 'x' || $Bukect == 'X' || $Bukect == '0') {
                                    $applicatipnNo = $slice[$icounter];
                                    if (trim($applicatipnNo) != "") {
                                        $filterApplicatipnNo = mysqli_query($dbconn, "SELECT * FROM application  where  isWithdraw!=1 and  isDelete='0' and applicatipnNo='" . $applicatipnNo . "' GROUP BY iAppId ORDER BY `application`.`iAppId` DESC limit 1") OR die(mysqli_error($dbconn));
                                        $rowApplication = mysqli_fetch_array($filterApplicatipnNo);
                                        if (mysqli_num_rows($filterApplicatipnNo) > 0) {

                                            $errorString .= "Row " . $RowCounter . " & Load Applicaton Number =" . $applicatipnNo . "  Already exists. <br/>";
                                        } else {
                                            $AgencyRow = $rowApplication['applicatipnNo'];
                                        }
                                    } else {
                                        //error application number cannot be blank
                                        $errorString .= "Row " . $RowCounter . " & Load Applicaton Number is blank exists. <br/>";
                                    }
                                }
//                                $applicatipnNo = $slice[$icounter];
//                                if (trim($applicatipnNo) != "") {
//                                    $filterApplicatipnNo = mysqli_query($dbconn, "SELECT * FROM application  where isPaid!=1 and bucket!='X' and isWithdraw!=1 and  isDelete='0' and applicatipnNo='" . $applicatipnNo . "' GROUP BY iAppId ORDER BY `application`.`iAppId` DESC limit 1") OR die(mysqli_error($dbconn));
//                                    $rowApplication = mysqli_fetch_array($filterApplicatipnNo);
//                                    if (mysqli_num_rows($filterApplicatipnNo) > 0) {
//                                        $errorString .= "Row " . $RowCounter . " & Load Applicaton Number =" . $applicatipnNo . "  Already exists. <br/>";
//                                    }
////                                    else if ($rowApplication['isPaid'] == 1){
////                                        $errorString .= "Row " . $RowCounter . " & Load Applicaton Number =" . $applicatipnNo . "  Already Paid. <br/>";
////                                    } 
////                                    else if ($rowApplication['isWithdraw'] == 1 || $rowApplication['isWithdraw'] == 0){
////                                        $AgencyRow = $rowApplication['applicatipnNo'];
////                                    } 
//                                    else {
//                                        $AgencyRow = $rowApplication['applicatipnNo'];
//                                    }
//                                }
                            }

                            if ($icounter == $iColumnCounter[1]) {
                                $Bukect = $slice[$icounter];
                                if (trim($Bukect) == "") {
                                    $errorString .= "Row " . $RowCounter . " & Bukect =" . $Bukect . "  not exists. <br/>";
                                }
                            }

                            if ($icounter == $iColumnCounter[13]) {
                                $Login = $slice[$icounter];
                                if (trim($Login) != "") {
                                    $Reselisionloginid = mysqli_query($dbconn, "SELECT count(*)as countS,employee.* FROM employee  where isDelete='0' and elisionloginid='" . $Login . "'") OR die(mysqli_error($dbconn));
                                    $elisionloginid = mysqli_fetch_array($Reselisionloginid);
                                    if ($elisionloginid['countS'] == 0) {
                                        $errorString .= "Row " . $RowCounter . " & Login =" . $Login . "  Not exists. <br/>";
                                    } else {
                                        $elisionloginidRow = $elisionloginid['elisionloginid'];
                                    }
                                }
                            }

                            if ($icounter == $iColumnCounter[10]) {
                                $AgencyName = $slice[$icounter];
                                if (trim($AgencyName) != "") {
                                    $filterAgency = mysqli_query($dbconn, "SELECT count(*)as countS,agency.* FROM agency  where isDelete='0' and agencyname='" . $AgencyName . "'") OR die(mysqli_error($dbconn));
                                    $rowAgency = mysqli_fetch_array($filterAgency);
                                    if ($rowAgency['countS'] == 0) {
                                        $errorString .= "Row " . $RowCounter . " & Agency Name =" . $AgencyName . "  Not exists. <br/>";
                                    } else {
                                        $AgencyRow = $rowAgency['agencyname'];
                                    }
                                }
                            }

//                            if ($icounter == $iColumnCounter[11]) {
//                                $FOSName = $slice[$icounter];
//                                if (trim($FOSName) != "") {
//                                    $filterFOSName = mysqli_query($dbconn, "SELECT count(*)as countS,fosuser.* FROM fosuser  where isDelete='0' and loginId='" . $FOSName . "'") OR die(mysqli_error($dbconn));
//                                    $rowFOSName = mysqli_fetch_array($filterFOSName);
//                                    if ($rowFOSName['countS'] == 0) {
//                                        $errorString .= "Row " . $RowCounter . " & FOS User =" . $FOSName . "  Not exists. <br/>";
//                                    } else {
//                                        $FOSNameRow = $rowFOSName['employeename'];
//                                    }
//                                }
//                            }
                        }
                    }
                    $ValCounter ++;
                }
            }


            if (trim($iColumnCounter[0]) == '' || trim($iColumnCounter[13]) == '' || trim($iColumnCounter[2]) == '' || trim($iColumnCounter[3]) == '' || trim($iColumnCounter[4]) == '') {
                echo "Error : " . "Column Header Not Match";
                unlink($file_path);
                break;
            } else if (trim($errorString) != "") {
                echo "Error : " . $errorString;
                unlink($file_path);
                break;
            } else {
                $iCounterRow = 0;
                foreach ($Sheets as $Index => $Name) {
                    $Reader->ChangeSheet($Index);
                    if ($Reader != null) {
                        foreach ($Reader as $key => $slice) {
                            if ($iCounterRow > 0) {
                                if ($slice != null && $slice[$iColumnCounter[0]] != '' && $slice[$iColumnCounter[2]] != '' && $slice[$iColumnCounter[3]] != '' && $slice[$iColumnCounter[13]] != '') {
                                    $AgencyId = "";
                                    $agencyName = "";
                                    if ($slice[$iColumnCounter[10]] == '') {
                                        $agencyName = "";
                                        $AgencyId = 0;
                                    } else {
                                        $filterstr = mysqli_query($dbconn, "Select * FROM agency  where isDelete='0' and  agencyname like '" . trim($slice[$iColumnCounter[10]]) . "' ");
                                        if (mysqli_num_rows($filterstr) > 0) {
                                            $rowAgencyId = mysqli_fetch_array($filterstr);
                                            $AgencyId = $rowAgencyId['Agencyid'];
                                        }
                                        $agencyName = $slice[$iColumnCounter[10]];
                                    }

                                    $FOSName = "";
                                    $FOSId = 0;
                                    if ($slice[$iColumnCounter[11]] == '') {
                                        $FOSName = "";
                                        $FOSId = 0;
                                    } else {
                                        $filterstr = mysqli_query($dbconn, "SELECT * FROM `fosuser` where isDelete='0' and employeename like '" . trim($slice[$iColumnCounter[11]]) . "' ");
                                        if (mysqli_num_rows($filterstr) > 0) {
                                            $rowfosIdId = mysqli_fetch_array($filterstr);
                                            $FOSId = $rowfosIdId['fosId'];
                                        }
                                        $FOSName = $slice[$iColumnCounter[11]];
                                    }

                                    $filterApplicatipnNo = mysqli_query($dbconn, "SELECT * FROM application  where isDelete='0'  and applicatipnNo='" . trim($slice[$iColumnCounter[0]]) . "' GROUP BY iAppId ORDER BY `application`.`iAppId` DESC limit 1") OR die(mysqli_error($dbconn));
                                    $rowApplication = mysqli_fetch_array($filterApplicatipnNo);
                                    if ($rowApplication['isWithdraw'] == 1) {

                                        $data = array(
                                            "isWithdraw" => '0',
                                            "agentId" => trim($slice[$iColumnCounter[13]]),
                                            "strEntryDate" => date("d-m-Y H:i:s"),
                                            "strIP" => $_SERVER['REMOTE_ADDR']
                                        );
                                        $where = "where iAppId='" . $rowApplication['iAppId'] . "'";
                                        $UpdateApplication = $connect->updaterecord($dbconn, "application", $data, $where);
                                    } else {
                                        if ($rowApplication['isPaid'] == 1 && $rowApplication['bucket'] == 1) {
                                            $isEmiPending = 1;
                                        } else {
                                            $isEmiPending = 0;
                                        }
                                        if ($rowApplication['isEmiPending'] == 1) {
                                            $isRollBack = 1;
                                        } else {
                                            $isRollBack = 0;
                                        }
//                                        if ($rowApplication['isPaid'] != 1) {
                                        $customerAddress = trim($slice[$iColumnCounter[5]]);
                                        $customerAddress = trim($customerAddress, ',');
                                        $data = array(
                                            "applicatipnNo" => trim($slice[$iColumnCounter[0]]),
                                            "bucket" => strtolower(trim($slice[$iColumnCounter[1]])),
                                            "customerName" => trim($slice[$iColumnCounter[2]]),
                                            "branch" => trim($slice[$iColumnCounter[3]]),
                                            "state" => trim($slice[$iColumnCounter[4]]),
                                            "customerAddress" => $customerAddress,
                                            "customerCity" => trim($slice[$iColumnCounter[6]]),
                                            "customerZipcode" => trim($slice[$iColumnCounter[7]]),
                                            "loanAmount" => trim($slice[$iColumnCounter[8]]),
                                            "EMIAmount" => trim($slice[$iColumnCounter[9]]),
                                            "agencyName" => trim($agencyName),
                                            "agencyId" => trim($AgencyId),
                                            "FOSName" => trim($FOSName),
                                            "FosNumber" => trim($slice[$iColumnCounter[12]]),
                                            "FOSId" => trim($FOSId),
                                            "agentId" => trim($slice[$iColumnCounter[13]]),
                                            "uploadId" => trim($_SESSION['EmployeeId']),
                                            "isEmiPending" => $isEmiPending,
                                            "isRollBack" => $isRollBack,
                                            //"uploadId" => trim($_SESSION['AdminId']),
                                            "strEntryDate" => date("d-m-Y H:i:s"),
                                            "strIP" => $_SERVER['REMOTE_ADDR']
                                        );
                                        $Insertquality = $connect->insertrecord($dbconn, "application", $data);
//                                        }
                                    }
                                }
                            }
                            $iCounterRow++;
                        }
                    }
                }
                echo "Data Uploaded Successfully";
            }
            @unlink($file_path);
            echo $errorString;
        }
        @unlink($file_path);
        break;

    default:
# code...
        echo "Page not Found";
        break;
}
?>