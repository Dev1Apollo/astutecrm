<?php
ob_start();
include('../common.php');
$connect = new connect();
include 'IsLogin.php';
include '../password_hash.php';
require('../spreadsheet-reader-master/SpreadsheetReader.php');
require_once '../spreadsheet-reader-master/php-excel-reader/excel_reader2.php';
ini_set('max_execution_time', 0);
$action = $_REQUEST['action'];

switch ($action) {
    case "uploadExcel":
        if (isset($_REQUEST['IMgallery'])) {
            $headerArray = array();
            $filename = trim($_REQUEST['IMgallery']);
            $file_path = 'temp/' . $filename;
            $Reader = new SpreadsheetReader($file_path);
            $Sheets = $Reader->Sheets();
            foreach ($Sheets as $Index => $Name) {
                $Reader->ChangeSheet($Index);
                $icount = 1;
                $ValCounter = 0;
                foreach ($Reader as $key => $slice) {
                    if ($ValCounter > 0) {
                        if ($key != 0) {
                            $userData = array(
                                "pincode" => $slice[0],
                                "partner" => $slice[1],
                                "city" => $slice[2],
                                "state" => $slice[3],
                                "zone" => $slice[4],
                                "address" => $slice[5],
                                "storeName" => $slice[6],
                                "SOname" => $slice[7],
                                "ASM" => $slice[8],
                                "contactNumber" => $slice[9],
                                "strEntryDate" => date('d-m-Y H:i:s'),
                                "strIP" => $_SERVER['REMOTE_ADDR']
                            );
                            $insert = $connect->insertrecord($dbconn, 'storelist', $userData);
                        }
                    }
                    $ValCounter++;
                }
            }
        }
        @unlink($file_path);
        echo $statusMsg = $insert ? '1' : '0';
        break;

    case "EmployeePerformance":
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
                        for ($icounter = 0; $icounter < count($slice); $icounter++) {
                            if (trim($slice[$icounter]) != "") {
                                $headerArray[$jCounterArray] = $slice[$icounter];
                                $jCounterArray++;
                                if (trim($slice[$icounter]) == "Date") {
                                    $iColumnCounter[0] = $icounter;
                                }
                                if (trim($slice[$icounter]) == "Login") {
                                    $iColumnCounter[1] = $icounter;
                                }
                                if (trim($slice[$icounter]) == "Bucket") {
                                    $iColumnCounter[2] = $icounter;
                                }
                                if (trim($slice[$icounter]) == "Attendance") {
                                    $iColumnCounter[3] = $icounter;
                                }
                                if (trim($slice[$icounter]) == "Login Time") {
                                    $iColumnCounter[4] = $icounter;
                                }
                                if (trim($slice[$icounter]) == "Logout Time") {
                                    $iColumnCounter[5] = $icounter;
                                }
                                if (trim($slice[$icounter]) == "Login hour") {
                                    $iColumnCounter[6] = $icounter;
                                }
                                if (trim($slice[$icounter]) == "Talk Time") {
                                    $iColumnCounter[7] = $icounter;
                                }
                                if (trim($slice[$icounter]) == "Pause Time") {
                                    $iColumnCounter[8] = $icounter;
                                }
                                if (trim($slice[$icounter]) == "Connect Call") {
                                    $iColumnCounter[9] = $icounter;
                                }
                                if (trim($slice[$icounter]) == "PU PTP") {
                                    $iColumnCounter[10] = $icounter;
                                }
                                if (trim($slice[$icounter]) == "DG PTP") {
                                    $iColumnCounter[11] = $icounter;
                                }
                                if (trim($slice[$icounter]) == "WK PTP") {
                                    $iColumnCounter[12] = $icounter;
                                }
                                if (trim($slice[$icounter]) == "PU Conv") {
                                    $iColumnCounter[13] = $icounter;
                                }
                                if (trim($slice[$icounter]) == "DG Conv") {
                                    $iColumnCounter[14] = $icounter;
                                }
                                if (trim($slice[$icounter]) == "WK Conv") {
                                    $iColumnCounter[15] = $icounter;
                                }
                                if (trim($slice[$icounter]) == "PU Conv %") {
                                    $iColumnCounter[16] = $icounter;
                                }
                                if (trim($slice[$icounter]) == "DG Conv %") {
                                    $iColumnCounter[17] = $icounter;
                                }
                                if (trim($slice[$icounter]) == "WK Conv %") {
                                    $iColumnCounter[18] = $icounter;
                                }
                                if (trim($slice[$icounter]) == "Penal Collected") {
                                    $iColumnCounter[19] = $icounter;
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
                                    $Reselisionloginid = mysqli_query($dbconn, "SELECT count(*)as countS,employee.* FROM employee  where isDelete='0' and elisionloginid='" . $Login . "'") or die(mysqli_error($dbconn));
                                    $elisionloginid = mysqli_fetch_array($Reselisionloginid);
                                    if ($elisionloginid['countS'] == 0) {
                                        $errorString .= "Row " . $RowCounter . " & Login =" . $Login . "  Not exists. <br/>";
                                    } else {
                                        $elisionloginidRow = $elisionloginid['elisionloginid'];
                                    }
                                }
                            }
                            if ($icounter == $iColumnCounter[2]) {
                                $bucket = $slice[$icounter];
                                if (trim($bucket) == "") {
                                    $errorString .= "Row " . $RowCounter . " & Bucket is blank. <br/>";
                                }
                                //                                else{
                                //                                    $filterstr = mysqli_query($dbconn, "Select count(*) as countRow FROM employeeperformance  where isDelete='0' and bucket in (1,'x','X') and elisionloginid='" . $slice[$iColumnCounter[1]] . "' and STR_TO_DATE(date,'%d-%M-%y')=STR_TO_DATE('" . $slice[$iColumnCounter[0]] . "','%d-%M-%y')");   
                                //                                    if(mysqli_num_rows($filterstr) == 2){
                                //                                        $errorString .= "Row " . $RowCounter . " & Data Already Exists. <br/>";
                                //                                    }
                                //                                } 
                            }
                        }
                    }
                    $ValCounter++;
                }
            }
            $Sql = "SELECT * FROM `formdetail` WHERE `formId`='1'";
            $result = mysqli_query($dbconn, $Sql);
            while ($row = mysqli_fetch_array($result)) {
                $excelcolumnname = $row['excelColumnName'];
                if (!in_array($excelcolumnname, $headerArray)) {
                    $errorString .= "Column Not found in excel " . $excelcolumnname . "<br/>";
                    @unlink($file_path);
                }
            }
            $statusMsg = $errorString ? $errorString : '0';
            if (trim($errorString) != "") {
                echo "Error : " . $errorString;
                @unlink($file_path);
                break;
            } else if ($statusMsg == 0) {
                $iCounterRow = 0;
                foreach ($Sheets as $Index => $Name) {
                    $Reader->ChangeSheet($Index);
                    if ($Reader != null) {
                        foreach ($Reader as $key => $slice) {
                            if ($iCounterRow > 0) {
                                if ($slice[$iColumnCounter[0]] == '' || $slice[$iColumnCounter[1]] == '') {
                                    @unlink($file_path);
                                    break;
                                } else {
                                    $result = mysqli_query($dbconn, "Select * FROM employeeperformance  where isDelete='0' and  bucket='" . strtolower($slice[$iColumnCounter[2]]) . "' and elisionloginid='" . $slice[$iColumnCounter[1]] . "' and STR_TO_DATE(date,'%d-%M-%y')=STR_TO_DATE('" . $slice[$iColumnCounter[0]] . "','%d-%M-%y')");
                                    if (mysqli_num_rows($result) == 0) {
                                        $filterstr = mysqli_query($dbconn, "Select * FROM employeeperformance  where isDelete='0' and  bucket='" . strtolower($slice[$iColumnCounter[2]]) . "' and elisionloginid='" . $slice[$iColumnCounter[1]] . "' and STR_TO_DATE(date,'%d-%M-%y')=STR_TO_DATE('" . $slice[$iColumnCounter[0]] . "','%d-%M-%y')");
                                        if (mysqli_num_rows($filterstr) == 0) {
                                            if ($slice[$iColumnCounter[4]] == "NA") {
                                                $LoginTime = "NA";
                                            } else {
                                                $LoginTime = date('H:i:s', strtotime($slice[$iColumnCounter[3]]));
                                            }
                                            if ($slice[$iColumnCounter[5]] == "NA") {
                                                $LogoutTime = "NA";
                                            } else {
                                                $LogoutTime = explode(" ", $slice[$iColumnCounter[5]]);
                                                //                                                $LogoutTime = date('H:i:s', strtotime($slice[$iColumnCounter[4]]));
                                            }
                                            $dataCustomer = array(
                                                "date" => $slice[$iColumnCounter[0]],
                                                "elisionloginid" => $slice[$iColumnCounter[1]],
                                                "bucket" => strtolower($slice[$iColumnCounter[2]]),
                                                "Attendance" => $slice[$iColumnCounter[3]],
                                                "LoginTime" => $LoginTime,
                                                "LogoutTime" => date('H:i:s', strtotime($LogoutTime[0])),
                                                "Loginhour" => date('H:i:s', strtotime($slice[$iColumnCounter[6]])),
                                                "TalkTime" => date('H:i:s', strtotime($slice[$iColumnCounter[7]])),
                                                "PauseTime" => date('H:i:s', strtotime($slice[$iColumnCounter[8]])),
                                                "ConnectCall" => $slice[$iColumnCounter[9]],
                                                "PU_PTP" => $slice[$iColumnCounter[10]],
                                                "DG_PTP" => $slice[$iColumnCounter[11]],
                                                "WK_PTP" => $slice[$iColumnCounter[12]],
                                                "PU_Conv" => $slice[$iColumnCounter[13]],
                                                "DG_Conv" => $slice[$iColumnCounter[14]],
                                                "WK_Conv" => $slice[$iColumnCounter[15]],
                                                "PU_Conv_per" => $slice[$iColumnCounter[16]],
                                                "DG_Conv_per" => $slice[$iColumnCounter[17]],
                                                "WK_Conv_per" => $slice[$iColumnCounter[18]],
                                                "PenalCollected" => $slice[$iColumnCounter[19]],
                                                'strEntryDate' => date('d-m-Y H:i:s'),
                                                'strIP' => $_SERVER['REMOTE_ADDR']
                                            );
                                            $insert = $connect->insertrecord($dbconn, "employeeperformance", $dataCustomer);
                                        } else {
                                            $userData = array(
                                                "PU_Conv" => $slice[13],
                                                "DG_Conv" => $slice[14],
                                                "WK_Conv" => $slice[15],
                                                "PU_Conv_per" => $slice[16],
                                                "DG_Conv_per" => $slice[17],
                                                "WK_Conv_per" => $slice[18],
                                                "PenalCollected" => $slice[19],
                                            );
                                            $where = " where elisionloginid='" . $slice[$iColumnCounter[1]] . "' and bucket='" . strtolower($slice[$iColumnCounter[2]]) . "' and date='" . $slice[$iColumnCounter[0]] . "'";
                                            $dealer_res = $connect->updaterecord($dbconn, 'employeeperformance', $userData, $where);
                                        }
                                    }
                                }
                            }
                            $iCounterRow++;
                        }
                    }
                }
                echo "Data Uploaded Successfully";
                @unlink($file_path);
            } else {
                echo $errorString;
                @unlink($file_path);
            }
        }
        @unlink($file_path);
        break;

    case "EmployeeAttendancePerformance":
        $Date = 0;
        $errorString = "";
        $iColumnCounter = array();
        $ValCounter = 0;
        $Login = 0;
        $RowCounter = 0;
        $jCounterArray = 0;
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
                        for ($icounter = 0; $icounter < count($slice); $icounter++) {
                            if (trim($slice[$icounter]) != "") {
                                $headerArray[$jCounterArray] = $slice[$icounter];
                                $jCounterArray++;
                                if (trim($slice[$icounter]) == "Date") {
                                    $iColumnCounter[0] = $icounter;
                                }
                                if (trim($slice[$icounter]) == "Login") {
                                    $iColumnCounter[1] = $icounter;
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
                                $Date = $slice[$icounter];
                                if (trim($Date) != "") {
                                    $AttendanceDate = mysqli_fetch_array(mysqli_query($dbconn, "SELECT count(*) as countL,employeeperformance.* FROM `employeeperformance`  where isDelete='0'  and  STR_TO_DATE(date,'%d-%M-%y')=STR_TO_DATE('" . $Date . "','%d-%M-%y')"));
                                    $AttendanceDateRow = $AttendanceDate['date'];
                                }
                            }
                            if ($icounter == $iColumnCounter[1]) {
                                $Login = $slice[$icounter];
                                if (trim($Login) != "") {
                                    $elisionloginid = mysqli_fetch_array(mysqli_query($dbconn, "SELECT count(*)as countS,employeeperformance.* FROM employeeperformance  where isDelete='0' and elisionloginid='" . $Login . "' and STR_TO_DATE(date,'%d-%M-%y')=STR_TO_DATE('" . $Date . "','%d-%M-%y')"));
                                    if ($elisionloginid['countS'] == 0) {
                                        $errorString .= "Row " . $RowCounter . " & Login =" . $Login . " and date " . $Date . " not exists. <br/>";
                                    } else {
                                        $elisionloginidRow = $elisionloginid['elisionloginid'];
                                    }
                                }
                            }
                        }
                    }
                    $ValCounter++;
                }
            }
            $Sql = "SELECT * FROM `formdetail` WHERE `formId`='2'";
            $result = mysqli_query($dbconn, $Sql);
            while ($row = mysqli_fetch_array($result)) {
                $excelcolumnname = $row['excelColumnName'];
                if (!in_array($excelcolumnname, $headerArray)) {
                    $errorString .= "Column Not found in excel " . $excelcolumnname . "<br/>";
                }
            }
            echo $statusMsg = $errorString ? $errorString : '0';
            if (trim($errorString) != "") {
                @unlink($file_path);
                break;
            } else if ($statusMsg == 0) {
                $iCounterRow = 0;
                foreach ($Sheets as $Index => $Name) {
                    $Reader->ChangeSheet($Index);
                    if ($Reader != null) {
                        foreach ($Reader as $key => $slice) {
                            if ($iCounterRow > 0) {
                                $dataCustomer = array(
                                    "PU_Conv" => $slice[$iColumnCounter[2]],
                                    "DG_Conv" => $slice[$iColumnCounter[3]],
                                    "WK_Conv" => $slice[$iColumnCounter[4]],
                                    "PU_Conv_per" => $slice[$iColumnCounter[5]],
                                    "DG_Conv_per" => $slice[$iColumnCounter[6]],
                                    "WK_Conv_per" => $slice[$iColumnCounter[7]],
                                    "PenalCollected" => $slice[$iColumnCounter[8]],
                                );
                                $where = " where elisionloginid='" . $slice[$iColumnCounter[1]] . "' and date='" . $slice[$iColumnCounter[0]] . "'";
                                $insert = $connect->updaterecord($dbconn, "employeeperformance", $dataCustomer, $where);
                            }
                            $iCounterRow++;
                        }
                    }
                }
                echo "Data Uploaded Successfully";
                @unlink($file_path);
            } else {
                echo $errorString;
                @unlink($file_path);
            }
        }
        @unlink($file_path);
        break;

    case "AxisBankBranchUploadExcel":
        if (isset($_REQUEST['IMgallery'])) {
            $headerArray = array();
            $filename = trim($_REQUEST['IMgallery']);
            $file_path = 'temp/' . $filename;
            $Reader = new SpreadsheetReader($file_path);
            $Sheets = $Reader->Sheets();
            foreach ($Sheets as $Index => $Name) {
                $Reader->ChangeSheet($Index);
                $icount = 1;
                $ValCounter = 0;
                foreach ($Reader as $key => $slice) {
                    if ($ValCounter > 0) {
                        if ($key != 0) {
                            $userData = array(
                                "strState" => $slice[0],
                                "strDistrict" => $slice[1],
                                "pincode" => $slice[2],
                                "strBranchName" => $slice[3],
                                "strAdress" => $slice[4],
                                "strEntryDate" => date('d-m-Y H:i:s'),
                                "strIP" => $_SERVER['REMOTE_ADDR']
                            );
                            $insert = $connect->insertrecord($dbconn, 'axisbankbranch', $userData);
                        }
                    }
                    $ValCounter++;
                }
            }
        }
        @unlink($file_path);
        echo $statusMsg = $insert ? '1' : '0';
        break;

    /*case "Addemployee":

        $hash_result = $connect->create_hash($_REQUEST['Password']);
        $hash_params = explode(":", $hash_result);

        $salt = $hash_params[HASH_SALT_INDEX];
        $hash = $hash_params[HASH_PBKDF2_INDEX];      
        if($_POST['designation']!=6){
            $centralmanager=$_SESSION['EmployeeId'];
        }
        $data = array(
            "empname" => $_POST['employeename'],
            "dojoin" => $_POST['dojoin'],
            "contactnumber" => $_POST['contactnumber'],
            "astutenumber" => $_POST['astutenumber'],
            "iProcessid" => $_POST['process'],
            "elisionloginid" => $_POST['elisionloginid'],
            "Password" => $hash,
            "strsalt" => $salt,
            "iteamleadid" => $_POST['iteamleadid'],
            "qualityanalistid" => $_POST['qualityanalistid'],
            "asstmanagerid" => $_POST['asstmanagerid'],
            "processmanager" => $_POST['processmanager'],
            "centralmanagerId" => $centralmanager,
            "trainerId" => $_POST['trainerId'],
            "strEntryDate" => date('d-m-Y H:i:s'),
            "strIP" => $_SERVER['REMOTE_ADDR']
        );

         $dealer_res = $connect->insertrecord($dbconn, 'employee', $data);
        $designation = $_POST['designation'];
        mysqli_query($dbconn, "INSERT INTO `employeedesignation`(iEmployeeId,iDesignationId,strEntryDate,strIP) VALUES ('" . $dealer_res . "','" . $designation . "', '" . date('d-m-Y H:i:s') . "', '" . $_SERVER['REMOTE_ADDR'] . "' ) ");
        
        echo $statusMsg = $dealer_res ? '1' : '0';
        break;*/
    case "Addemployee":

        $hash_result = $connect->create_hash($_REQUEST['Password']);
        $hash_params = explode(":", $hash_result);

        $salt = $hash_params[HASH_SALT_INDEX];
        $hash = $hash_params[HASH_PBKDF2_INDEX];      
        if($_POST['designation']!=6){
            $centralmanager=$_SESSION['EmployeeId'];
        }
        
        $managerTQid = isset($_POST['managerTQid']) ? (int)$_POST['managerTQid'] : 0;
        $managerOpsid = isset($_POST['managerOpsid']) ? (int)$_POST['managerOpsid'] : 0;
        $managerHRid = isset($_POST['managerHRid']) ? (int)$_POST['managerHRid'] : 0;
        $managerITid = isset($_POST['managerITid']) ? (int)$_POST['managerITid'] : 0;
        $managerMISid = isset($_POST['managerMISid']) ? (int)$_POST['managerMISid'] : 0;
        
        $data = array(
            "empname" => $_POST['employeename'],
            "dojoin" => $_POST['dojoin'],
            "contactnumber" => $_POST['contactnumber'],
            "astutenumber" => $_POST['astutenumber'],
            "iProcessid" => $_POST['process'],
            "elisionloginid" => $_POST['elisionloginid'],
            "Password" => $hash,
            "strsalt" => $salt,
            "iteamleadid" => $_POST['iteamleadid'],
            "qualityanalistid" => $_POST['qualityanalistid'],
            "asstmanagerid" => $_POST['asstmanagerid'],
            //"processmanager" => $_POST['processmanager'],
            "centralmanagerId" => $centralmanager,
            "trainerId" => $_POST['trainerId'],
            "managerTQid" => $managerTQid,
            "managerOpsid" => $managerOpsid,
            "managerHRid" => $managerHRid,
            "managerITid" => $managerITid,
            "managerMISid" => $managerMISid,
            "strEntryDate" => date('d-m-Y H:i:s'),
            "strIP" => $_SERVER['REMOTE_ADDR']
        );
        $dealer_res = $connect->insertrecord($dbconn, 'employee', $data);
        
        $designation = $_POST['designation'];
        mysqli_query($dbconn, "INSERT INTO `employeedesignation`(iEmployeeId,iDesignationId,strEntryDate,strIP) VALUES ('" . $dealer_res . "','" . $designation . "', '" . date('d-m-Y H:i:s') . "', '" . $_SERVER['REMOTE_ADDR'] . "' ) ");
        
        echo $statusMsg = $dealer_res ? '1' : '0';
        break;

        case "geteditprocessmanager":



            $resPM = mysqli_query($dbconn, "select * from `employee` INNER JOIN employeedesignation on employee.employeeid=employeedesignation.iEmployeeId  where employee.centralmanagerId=" . $_REQUEST['ID'] . " and employeedesignation.iDesignationId=3 and employee.isDelete=0 and employee.istatus=1");
            $data = '';
    
            if (mysqli_num_rows($resPM) > 0) {
                $data .= "<option value='' >Select Process Manager </option>\n";
    
                while ($result_PM =  mysqli_fetch_array($resPM)) {
                    if ($_REQUEST['PMID'] == $result_PM['employeeid']) {
                        $data .= "<option value='" . $result_PM['employeeid'] . "' selected>" . $result_PM['empname'] . "</option>";
                    } else {
                        $data .= "<option value='" . $result_PM['employeeid'] . "'>" . $result_PM['empname'] . "</option>";
                    }
                }
            }
            echo $data;
    
            break;
    
        case "geteditasstmanager":
    
            $resAM = mysqli_query($dbconn, "select * from `employee` INNER JOIN employeedesignation on employee.employeeid=employeedesignation.iEmployeeId  where employee.centralmanagerId=" . $_REQUEST['ID'] . " and employeedesignation.iDesignationId=2 and employee.isDelete=0 and employee.istatus=1");
            $data = '';
    
            if (mysqli_num_rows($resAM) > 0) {
                $data .= "<option value='' >Select AsstManager </option>\n";
    
                while ($result_AM =  mysqli_fetch_array($resAM)) {
                    if ($_REQUEST['AMID'] == $result_AM['employeeid']) {
                        $data .= "<option value='" . $result_AM['employeeid'] . "' selected>" . $result_AM['empname'] . "</option>";
                    } else {
                        $data .= "<option value='" . $result_AM['employeeid'] . "'>" . $result_AM['empname'] . "</option>";
                    }
                }
            }
           echo $data;
    
            break;
    
        case "geteditteamlead":
    
            //echo $_REQUEST['ID'];
            $resTL = mysqli_query($dbconn, "SELECT * FROM `employee` INNER JOIN employeedesignation on employee.employeeid=employeedesignation.iEmployeeId WHERE employee.centralmanagerId=" . $_REQUEST['ID'] . " and employeedesignation.iDesignationId=4 and employee.isDelete=0 and employee.istatus=1");
            $data = '';
    
            if (mysqli_num_rows($resTL) > 0) {
                $data .= "<option value='' >Select Team leader </option>\n";
    
                while ($result_TL =  mysqli_fetch_array($resTL)) {
    
                    if ($_REQUEST['TLID'] == $result_TL['employeeid']) {
                        $data .= "<option value='" . $result_TL['employeeid'] . "' selected>" . $result_TL['empname'] . "</option>";
                    } else {
                        $data .= "<option value='" . $result_TL['employeeid'] . "'>" . $result_TL['empname'] . "</option>";
                    }
                }
            }
            echo $data;
    
            break;
    
        case "geteditqualityanalist":
    
            //echo $_REQUEST['ID'];
    
            $resTL = mysqli_query($dbconn, "SELECT * FROM `employee` INNER JOIN employeedesignation on employee.employeeid=employeedesignation.iEmployeeId WHERE employee.centralmanagerId=" . $_REQUEST['ID'] . " and employeedesignation.iDesignationId=1 and employee.isDelete=0 and employee.istatus=1");
            $data = '';
    
            if (mysqli_num_rows($resTL) > 0) {
                $data .= "<option value='' >Select Quality Analist </option>\n";
    
                while ($result_TL =  mysqli_fetch_array($resTL)) {
                    if ($_REQUEST['QAID'] == $result_TL['employeeid']) {
                        $data .= "<option value='" . $result_TL['employeeid'] . "' selected>" . $result_TL['empname'] . "</option>";
                    } else {
                        $data .= "<option value='" . $result_TL['employeeid'] . "'>" . $result_TL['empname'] . "</option>";
                    }
                }
            }
            echo $data;
    
            break;

    case "Adddailyupdate":



        $Date = 0;

        $errorString = "";

        $iColumnCounter = array();

        $ValCounter = 0;

        $Login = 0;

        $RowCounter = 0;

        $jCounterArray = 0;

        $LoginTime = 0;



        if ($_POST['displayColumn'] <= 10) {

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

                        if (count($slice) <= 11) {

                            if ($ValCounter == 0) {

                                for ($icounter = 0; $icounter < count($slice); $icounter++) {

                                    $displayColumn = $_POST['displayColumn'] + 1;

                                    if ($displayColumn != count($slice)) {

                                        echo "Inputed Column Count and Excel Count Not Match";

                                        @unlink($file_path);

                                        exit;
                                    }

                                    if (trim($slice[$icounter]) != "") {

                                        $headerArray[$jCounterArray] = $slice[$icounter];

                                        $jCounterArray++;

                                        if (trim($slice[$icounter]) == "Login") {

                                            $iColumnCounter[0] = $icounter;
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

                                        $Login = $slice[$icounter];

                                        if (trim($Login) != "") {

                                            $Reselisionloginid = mysqli_query($dbconn, "SELECT count(*)as countS,employee.* FROM employee  where isDelete='0' and elisionloginid='" . $Login . "'") or die(mysqli_error($dbconn));

                                            $elisionloginid = mysqli_fetch_array($Reselisionloginid);

                                            if ($elisionloginid['countS'] == 0) {

                                                $errorString .= "Row " . $RowCounter . " & Login =" . $Login . "  Not exists. <br/>";
                                            } else {

                                                $elisionloginidRow = $elisionloginid['elisionloginid'];
                                            }
                                        }
                                    }
                                }
                            }
                        } else {

                            echo "Exceeds More Than Maximum Column In Excel";

                            @unlink($file_path);

                            exit;
                        }

                        $ValCounter++;
                    }
                }



                $statusMsg = $errorString ? $errorString : '0';

                if (trim($errorString) != "") {

                    echo "Error : " . $errorString;

                    @unlink($file_path);

                    break;
                } else if ($statusMsg == 0) {

                    $iCounterRow = 0;

                    foreach ($Sheets as $Index => $Name) {

                        $Reader->ChangeSheet($Index);

                        if ($Reader != null) {

                            foreach ($Reader as $key => $slice) {

                                if ($iCounterRow == 0) {

                                    echo "<pre>";

                                    $dataCustomer = array(

                                        "EntryDate" => $_POST['date'],

                                        "elisionloginid" => trim($slice[$iColumnCounter[0]]),

                                        "col1" => trim($slice[1]),

                                        "col2" => trim($slice[2]),

                                        "col3" => trim($slice[3]),

                                        "col4" => trim($slice[4]),

                                        "col5" => trim($slice[5]),

                                        "col6" => trim($slice[6]),

                                        "col7" => trim($slice[7]),

                                        "col8" => trim($slice[8]),

                                        "col9" => trim($slice[9]),

                                        "col10" => trim($slice[10]),

                                        "isHeader" => 1,

                                        "displayColumn" => trim($_POST['displayColumn']),

                                        "strEntryDate" => date('d-m-Y H:i:s'),

                                        "strIP" => $_SERVER['REMOTE_ADDR']

                                    );

                                    //                                        print_r($dataCustomer);

                                    $insert = $connect->insertrecord($dbconn, "dailyupdate", $dataCustomer);
                                }

                                if ($iCounterRow > 0) {

                                    if ($slice[$iColumnCounter[0]] == '') {

                                        @unlink($file_path);

                                        break;
                                    } else {

                                        $dataCustomer = array(

                                            "EntryDate" => $_POST['date'],

                                            "elisionloginid" => trim($slice[$iColumnCounter[0]]),

                                            "col1" => trim($slice[1]),

                                            "col2" => trim($slice[2]),

                                            "col3" => trim($slice[3]),

                                            "col4" => trim($slice[4]),

                                            "col5" => trim($slice[5]),

                                            "col6" => trim($slice[6]),

                                            "col7" => trim($slice[7]),

                                            "col8" => trim($slice[8]),

                                            "col9" => trim($slice[9]),

                                            "col10" => trim($slice[10]),

                                            "isHeader" => 0,

                                            "displayColumn" => trim($_POST['displayColumn']),

                                            "strEntryDate" => date('d-m-Y H:i:s'),

                                            "strIP" => $_SERVER['REMOTE_ADDR']

                                        );

                                        $insert = $connect->insertrecord($dbconn, "dailyupdate", $dataCustomer);
                                    }
                                }

                                $iCounterRow++;
                            }
                        }
                    }

                    echo "Data Uploaded Successfully";

                    @unlink($file_path);
                } else {

                    echo $errorString;

                    @unlink($file_path);
                }
            }
        } else {

            echo "Maximam 10 Column Allowed In Excel and In Dispaly";

            @unlink($file_path);

            exit;
        }

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

                        for ($icounter = 0; $icounter < count($slice); $icounter++) {

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

                                    $Reselisionloginid = mysqli_query($dbconn, "SELECT count(*)as countS,employee.* FROM employee  where isDelete='0' and elisionloginid='" . $Login . "'") or die(mysqli_error($dbconn));

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

                                    $IncentiveDate = mysqli_query($dbconn, "SELECT count(*)as countS,tldeshboardmaster.* FROM tldeshboardmaster  where isDelete='0' and elisionloginid = '" . $slice[$iColumnCounter[1]] . "' and date='" . $Date . "'") or die(mysqli_error($dbconn));

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

                    $ValCounter++;
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

                @unlink($file_path);
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

                        for ($icounter = 0; $icounter < count($slice); $icounter++) {

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

                                    $Reselisionloginid = mysqli_query($dbconn, "SELECT count(*)as countS,employee.* FROM employee  where isDelete='0' and elisionloginid='" . $Login . "'") or die(mysqli_error($dbconn));

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

                                    $IncentiveDate = mysqli_query($dbconn, "SELECT count(*)as countS,quality.* FROM quality  where isDelete='0' and elisionloginid = '" . $slice[$iColumnCounter[1]] . "' and date='" . $Date . "'") or die(mysqli_error($dbconn));

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

                    $ValCounter++;
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

                @unlink($file_path);
            }

            @unlink($file_path);

            echo $errorString;
        }

        @unlink($file_path);

        break;



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

                        for ($icounter = 0; $icounter < count($slice); $icounter++) {

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

                                    $Reselisionloginid = mysqli_query($dbconn, "SELECT count(*)as countS,employee.* FROM employee  where isDelete='0' and elisionloginid='" . $Login . "'") or die(mysqli_error($dbconn));

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

                                    $IncentiveDate = mysqli_query($dbconn, "SELECT count(*)as countS,incentivemaster.* FROM incentivemaster  where isDelete='0' and elisionloginid = '" . $slice[$iColumnCounter[1]] . "' and date='" . $Date . "'") or die(mysqli_error($dbconn));

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

                    $ValCounter++;
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







    /* case "AddPaidUpdate":
        // ajayelec_ajay_electro_medical
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
                        for ($icounter = 0; $icounter < count($slice); $icounter++) {
                            if (trim($slice[$icounter]) != "") {
                                $headerArray[$jCounterArray] = $slice[$icounter];
                                $jCounterArray++;
                                if (trim($slice[$icounter]) == "Loan Application No") {
                                    $iColumnCounter[0] = $icounter;
                                }
                                if (trim($slice[$icounter]) == "Paid Date") {
                                    $iColumnCounter[1] = $icounter;
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
                                $applicatipnNo = $slice[$icounter];
                                if (trim($applicatipnNo) != "") {
                                    $filterAgency = mysqli_query($dbconn, "SELECT count(*)as countS,application.* FROM application where isDelete='0' and applicatipnNo='" . $applicatipnNo . "' GROUP BY iAppId ORDER BY `application`.`iAppId` DESC limit 1") or die(mysqli_error($dbconn));
                                    $rowApplicatipnNo = mysqli_fetch_array($filterAgency);
                                    if ($rowApplicatipnNo['countS'] == 0) {
                                        $errorString .= "Row " . $RowCounter . " & Application =" . $applicatipnNo . "  Not exists. <br/>";
                                    }
                                    if ($rowApplicatipnNo['agentId'] == '') {
                                        $errorString .= "Row " . $RowCounter . " & Agent Not Assign. <br/>";
                                    }
                                }
                            }

                            if ($icounter == $iColumnCounter[1]) {
                                $applicatipnNo = $slice[$icounter];
                                if (trim($applicatipnNo) == "") {
                                    $errorString .= "Row " . $RowCounter . " & Paid Date =" . $applicatipnNo . " Not Exists. <br/>";
                                }
                            }
                        }
                    }

                    $ValCounter++;
                }
            }

            if (trim($iColumnCounter[0]) == '' || trim($iColumnCounter[1]) == '') {
                echo "Error : " . "Column Header Not Match";
                unlink($file_path);
                break;
            }

            if (trim($errorString) != "") {
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
                                if ($slice != null && $slice[$iColumnCounter[0]] != '' && $slice[$iColumnCounter[1]] != '') {
                                    $AgencyId = "";
                                    $agencyName = "";
                                    $filterAgency = mysqli_query($dbconn, "SELECT count(*)as countS,application.* FROM application where isDelete='0' and applicatipnNo='" . trim($slice[$iColumnCounter[0]]) . "' GROUP BY iAppId ORDER BY `application`.`iAppId` DESC") or die(mysqli_error($dbconn));
                                    $rowfilter = mysqli_fetch_array($filterAgency);
                                    if ($rowfilter['isPaid'] != 1) {
                                        $data = array(
                                            "isPaid" => '1',
                                            "PaidDate" => date($slice[$iColumnCounter[1]] . '-m-Y')
                                            //                                            "PaidDate" => date('d-m-Y', strtotime($slice[$iColumnCounter[1]]))
                                        );
                                        $where = "where applicatipnNo='" . trim($slice[$iColumnCounter[0]]) . "'";
                                        $Insertquality = $connect->updaterecord($dbconn, "application", $data, $where);
                                    } else {
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

        break; */
        
    case "AddPaidUpdate":

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
    
                                if ($header == "Paid Amount") {
                                    $iColumnCounter['paid_amount'] = $icounter;
                                }
    
                                if ($header == "Date") {
                                    $iColumnCounter['paid_date'] = $icounter;
                                }
    
                                $jCounterArray++;
                            }
                        }
                    } else {
                        $RowCounter = $key + 1; // Use actual Excel row number
    
                        $loanNumber  = trim($slice[$iColumnCounter['loan_number']] ?? '');
                        $paidAmount  = trim($slice[$iColumnCounter['paid_amount']] ?? '');
                        $paidDateRaw = trim($slice[$iColumnCounter['paid_date']] ?? '');
    
                        // Validation checks
                        if ($loanNumber == "") {
                            $errorString .= "Row $RowCounter: Loan Number is missing.<br/>";
                            continue;
                        }
    
                        if ($paidAmount == "" || !is_numeric($paidAmount)) {
                            $errorString .= "Row $RowCounter: Paid Amount is invalid.<br/>";
                            continue;
                        }
    
                        if ($paidDateRaw == "") {
                            $errorString .= "Row $RowCounter: Paid Date is missing.<br/>";
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
                            $errorString .= "Row $RowCounter: Loan Number '$loanNumber' not found.<br/>";
                            continue;
                        }
    
                        if (trim($app['agentId']) == '') {
                            $errorString .= "Row $RowCounter: Agent not assigned to application '$loanNumber'.<br/>";
                            continue;
                        }
    
                        if (trim($paidDateRaw) == '') {
                            $errorString .= "Row $RowCounter: Paid Date missing.<br/>";
                            continue;
                        }
                    }
    
                    $ValCounter++;
                }
            }
    
            // Check for missing headers
            if (!isset($iColumnCounter['loan_number']) || !isset($iColumnCounter['paid_amount']) || !isset($iColumnCounter['paid_date'])) {
                echo "Error: Required column headers are missing (Loan Number, Paid Amount, Date).";
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
                    $paidAmount  = trim($slice[$iColumnCounter['paid_amount']] ?? '');
                    // $paidDateRaw = trim($slice[$iColumnCounter['paid_date']] ?? '');
                    $paidDateRaw = trim($slice[$iColumnCounter['paid_date']] ?? '');
                    
                    // $paidDate    = date('Y-m-d', strtotime($paidDateRaw));
                    $paidDate = parseExcelDate($paidDateRaw);

                    if ($paidDate === null) {
                        die("Error: Invalid date format at row " . ($key + 1));
                    }
    
                    // Get latest application record
                    $result = mysqli_query($dbconn, "SELECT iAppId, isPaid 
                                                     FROM application 
                                                     WHERE isDelete='0' 
                                                       AND applicatipnNo='" . mysqli_real_escape_string($dbconn, $loanNumber) . "' 
                                                     ORDER BY iAppId DESC 
                                                     LIMIT 1") or die(mysqli_error($dbconn));
    
                    $app = mysqli_fetch_assoc($result);
                    $applicationId = $app['iAppId'];
    
                    // 1. Insert into payment history
                    // $insertQuery = "INSERT INTO application_payment_history (application_id, loan_number, paid_amount, paid_date) 
                    //                 VALUES ('$applicationId', '" . mysqli_real_escape_string($dbconn, $loanNumber) . "', 
                    //                         '" . mysqli_real_escape_string($dbconn, $paidAmount) . "', 
                    //                         '$paidDate')";
    
                    // mysqli_query($dbconn, $insertQuery) or die("Error inserting history at row $iCounterRow: " . mysqli_error($dbconn));
                    
                    // 1. Insert or Update payment history
                    $loanNumberEsc = mysqli_real_escape_string($dbconn, $loanNumber);
                    $paidAmountEsc = mysqli_real_escape_string($dbconn, $paidAmount);
                    
                    // Check if payment already exists
                    $checkPayment = mysqli_query($dbconn, "
                        SELECT id 
                        FROM application_payment_history 
                        WHERE application_id = '$applicationId' order by id desc
                        LIMIT 1
                    ") or die("Error checking payment at row $iCounterRow: " . mysqli_error($dbconn));
                    
                    if (mysqli_num_rows($checkPayment) > 0) {
                        // Record exists → Update
                        $payment = mysqli_fetch_assoc($checkPayment);
                        $paymentId = $payment['id'];
                    
                        $updateHistory = "
                            UPDATE application_payment_history 
                            SET paid_amount = '$paidAmountEsc', paid_date = '$paidDate' 
                            WHERE id = '$paymentId'
                        ";
                    
                        mysqli_query($dbconn, $updateHistory) or die("Error updating history at row $iCounterRow: " . mysqli_error($dbconn));
                    
                    } else {
                        // Record not found → Insert new
                        $insertQuery = "
                            INSERT INTO application_payment_history (application_id, loan_number, paid_amount, paid_date) 
                            VALUES ('$applicationId', '$loanNumberEsc', '$paidAmountEsc', '$paidDate')
                        ";
                        mysqli_query($dbconn, $insertQuery) or die("Error inserting history at row $iCounterRow: " . mysqli_error($dbconn));
                    }

    
                    // 2. Update application table only if not already paid
                    // if ($app['isPaid'] != 1) {
                    //     $updateQuery = "UPDATE application 
                    //                     SET isPaid = 1, 
                    //                         PaidDate = '$paidDate' 
                    //                     WHERE iAppId = '$applicationId' 
                    //                       AND isDelete = 0";
                    //     mysqli_query($dbconn, $updateQuery) or die("Error updating application at row $iCounterRow: " . mysqli_error($dbconn));
                    // }
                    
                    if ($app['isPaid'] != 1) {
                        $updateQuery = "
                            UPDATE application 
                            SET isPaid = 1, 
                                PaidDate = '$paidDate' 
                            WHERE iAppId = '$applicationId' 
                              AND isDelete = 0
                        ";
                        mysqli_query($dbconn, $updateQuery) or die("Error updating application at row $iCounterRow: " . mysqli_error($dbconn));
                    }
    
                    $iCounterRow++;
                }
            }
    
            echo "Payment history uploaded and application updated successfully.";
    
            @unlink($file_path);
        }
    
    break;






    case "AddWithdrawCase":



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

                        for ($icounter = 0; $icounter < count($slice); $icounter++) {

                            if (trim($slice[$icounter]) != "") {

                                $headerArray[$jCounterArray] = $slice[$icounter];

                                $jCounterArray++;

                                if (trim($slice[$icounter]) == "Loan Application No") {

                                    $iColumnCounter[0] = $icounter;
                                }

                                if (trim($slice[$icounter]) == "Reason") {

                                    $iColumnCounter[1] = $icounter;
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

                                $applicatipnNo = $slice[$icounter];

                                if (trim($applicatipnNo) != "") {

                                    $filterAgency = mysqli_query($dbconn, "SELECT count(*)as countS,application.* FROM application where isDelete='0' and applicatipnNo='" . $applicatipnNo . "'") or die(mysqli_error($dbconn));

                                    $rowApplicatipnNo = mysqli_fetch_array($filterAgency);

                                    if ($rowApplicatipnNo['countS'] == 0) {

                                        $errorString .= "Row " . $RowCounter . " & Application Number =" . $applicatipnNo . "  Not exists. <br/>";
                                    }
                                }
                            }
                        }
                    }

                    $ValCounter++;
                }
            }



            if (trim($iColumnCounter[0]) == '' || trim($iColumnCounter[1]) == '') {

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

                                if ($slice != null && $slice[$iColumnCounter[0]] != '' && $slice[$iColumnCounter[1]] != '') {

                                    $AgencyId = "";

                                    $agencyName = "";



                                    $data = array(

                                        "isWithdraw" => '1',

                                        "remark" => trim($slice[$iColumnCounter[1]])

                                    );

                                    $where = "where applicatipnNo='" . trim($slice[$iColumnCounter[0]]) . "'";

                                    $Insertquality = $connect->updaterecord($dbconn, "application", $data, $where);
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



    case "AddReassignAgent":



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

                        for ($icounter = 0; $icounter < count($slice); $icounter++) {

                            if (trim($slice[$icounter]) != "") {

                                $headerArray[$jCounterArray] = $slice[$icounter];

                                $jCounterArray++;

                                if (trim($slice[$icounter]) == "Loan Application No") {

                                    $iColumnCounter[0] = $icounter;
                                }

                                if (trim($slice[$icounter]) == "Agent ID") {

                                    $iColumnCounter[1] = $icounter;
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

                                    $Reselisionloginid = mysqli_query($dbconn, "SELECT count(*)as countS,employee.elisionloginid FROM employee  where isDelete='0' and elisionloginid='" . $Login . "'") or die(mysqli_error($dbconn));

                                    $elisionloginid = mysqli_fetch_array($Reselisionloginid);

                                    if ($elisionloginid['countS'] == 0) {

                                        $errorString .= "Row " . $RowCounter . " & Login =" . $Login . "  Not exists. <br/>";
                                    }
                                }
                            }

                            if ($icounter == $iColumnCounter[0]) {

                                $applicatipnNo = $slice[$icounter];

                                if (trim($applicatipnNo) != "") {



                                    $filterAgency = mysqli_query($dbconn, "SELECT count(*)as countS,application.applicatipnNo FROM application where isDelete='0' and applicatipnNo='" . $applicatipnNo . "' GROUP BY iAppId ORDER BY `application`.`iAppId` DESC limit 1") or die(mysqli_error($dbconn));

                                    $rowApplicatipnNo = mysqli_fetch_array($filterAgency);

                                    if ($rowApplicatipnNo['countS'] == 0) {

                                        $errorString .= "Row " . $RowCounter . " & Application Number =" . $applicatipnNo . "  Not exists. <br/>";
                                    }

                                    //                                    if ($rowApplicatipnNo['isPaid'] == 1) {

                                    //                                        $errorString .= "Row " . $RowCounter . " & Application Number =" . $applicatipnNo . "  Already Paid. <br/>";

                                    //                                    }

                                    //                                    if ($rowApplicatipnNo['isWithdraw'] == 1) {

                                    //                                        $errorString .= "Row " . $RowCounter . " & Application Number =" . $applicatipnNo . "  Already WithDraw. <br/>";

                                    //                                    }

                                }
                            }
                        }
                    }

                    $ValCounter++;
                }
            }



            if (trim($iColumnCounter[0]) == '' || trim($iColumnCounter[1]) == '') {

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

                                if ($slice != null && $slice[$iColumnCounter[0]] != '' && $slice[$iColumnCounter[1]] != '') {

                                    $AgencyId = "";

                                    $agencyName = "";

                                    $filterAgency = mysqli_query($dbconn, "SELECT application.applicatipnNo,application.isPaid FROM application where isDelete='0' and applicatipnNo='" . $applicatipnNo . "' GROUP BY iAppId ORDER BY `application`.`iAppId` DESC limit 1") or die(mysqli_error($dbconn));

                                    $rowApplicatipnNo = mysqli_fetch_array($filterAgency);

                                    if ($rowApplicatipnNo['isPaid'] != 1) {

                                        $data = array(

                                            "agentId" => trim($slice[$iColumnCounter[1]]),

                                            "isReassig" => '1'

                                        );

                                        $where = "where applicatipnNo='" . trim($slice[$iColumnCounter[0]]) . "'";

                                        $Insertquality = $connect->updaterecord($dbconn, "application", $data, $where);
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



    case "CRMSettting":



        if (isset($_POST['applicatipnNo'])) {

            $applicatipnNo = $_POST['applicatipnNo'];
        } else {

            $applicatipnNo = 0;
        }

        if (isset($_POST['customerName'])) {

            $customerName = $_POST['customerName'];
        } else {

            $customerName = 0;
        }

        if (isset($_POST['branch'])) {

            $branch = $_POST['branch'];
        } else {

            $branch = 0;
        }

        if (isset($_POST['state'])) {

            $state = $_POST['state'];
        } else {

            $state = 0;
        }
        
        if (isset($_POST['customerMobile'])) {

            $customerMobile = $_POST['customerMobile'];
        } else {

            $customerMobile = 0;
        }
        
        if (isset($_POST['customerAddress'])) {

            $customerAddress = $_POST['customerAddress'];
        } else {

            $customerAddress = 0;
        }

        if (isset($_POST['customerCity'])) {

            $customerCity = $_POST['customerCity'];
        } else {

            $customerCity = 0;
        }

        if (isset($_POST['customerZipcode'])) {

            $customerZipcode = $_POST['customerZipcode'];
        } else {

            $customerZipcode = 0;
        }

        if (isset($_POST['loanAmount'])) {

            $loanAmount = $_POST['loanAmount'];
        } else {

            $loanAmount = 0;
        }

        if (isset($_POST['EMIAmount'])) {

            $EMIAmount = $_POST['EMIAmount'];
        } else {

            $EMIAmount = 0;
        }

        if (isset($_POST['agencyName'])) {

            $agencyName = $_POST['agencyName'];
        } else {

            $agencyName = 0;
        }

        //        if(isset($_POST['agentId'])){

        //            $agentId = $_POST['agentId'];

        //        }else{

        //            $agentId = 0;

        //        }

        if (isset($_POST['FOSName'])) {

            $FOSName = $_POST['FOSName'];
        } else {

            $FOSName = 0;
        }





        if (isset($_POST['FOSContact'])) {

            $FOSContact = $_POST['FOSContact'];
        } else {

            $FOSContact = 0;
        }

        if (isset($_POST['LastCallDate'])) {

            $LastCallDate = $_POST['LastCallDate'];
        } else {

            $LastCallDate = 0;
        }

        if (isset($_POST['Lastdisposition'])) {

            $Lastdisposition = $_POST['Lastdisposition'];
        } else {

            $Lastdisposition = 0;
        }

        if (isset($_POST['FollowupDate'])) {

            $FollowupDate = $_POST['FollowupDate'];
        } else {

            $FollowupDate = 0;
        }

        if (isset($_POST['FollowupTime'])) {

            $FollowupTime = $_POST['FollowupTime'];
        } else {

            $FollowupTime = 0;
        }

        if (isset($_POST['Remark'])) {

            $Remark = $_POST['Remark'];
        } else {

            $Remark = 0;
        }

        if (isset($_POST['feedback'])) {

            $feedback = $_POST['feedback'];
        } else {

            $feedback = 0;
        }

        if (isset($_POST['bucket'])) {

            $bucket = $_POST['bucket'];
        } else {

            $bucket = 0;
        }

        $data = array(

            "applicatipnNo" => $applicatipnNo,

            "bucket" => $bucket,

            "customerName" => $customerName,

            "branch" => $branch,

            "state" => $state,
            
            "customerMobile" => $customerMobile,
            
            "customerAddress" => $customerAddress,

            "customerCity" => $customerCity,

            "customerZipcode" => $customerZipcode,

            "loanAmount" => $loanAmount,

            "EMIAmount" => $EMIAmount,

            "agencyName" => $agencyName,

            //            "agentId" => $agentId,

            "FOSName" => $FOSName,

            "FOSContact" => $FOSContact,

            "LastCallDate" => $LastCallDate,

            "Lastdisposition" => $Lastdisposition,

            "FollowupDate" => $FollowupDate,

            "FollowupTime" => $FollowupTime,

            "Remark" => $Remark,

            "feedback" => $feedback,

            "elisionloginid" => $_SESSION['elisionloginid'],

            "strEntryDate" => date('d-m-Y'),

            "strIP" => $_SERVER['REMOTE_ADDR']

        );

        $filterSetting = mysqli_query($dbconn, "SELECT * FROM `crmsetting` where elisionloginid='" . $_SESSION['elisionloginid'] . "' and iStatus=1 and isDelete=0");

        if (mysqli_num_rows($filterSetting) > 0) {

            //            echo "delete FROM `crmsetting` where elisionloginid ='" . $_SESSION['elisionloginid'] . "'";

            mysqli_query($dbconn, "delete FROM `crmsetting` where elisionloginid='" . $_SESSION['elisionloginid'] . "'");

            $dealer_res = $connect->insertrecord($dbconn, "crmsetting", $data);

            //            $where = "where elisionloginid =".$_SESSION['elisionloginid']."";

            //            $dealer_res = $connect->updaterecord($dbconn, "crmsetting", $data, $where);

        } else {

            $dealer_res = $connect->insertrecord($dbconn, "crmsetting", $data);
        }

        echo $dealer_res;

        break;



    /*case "Editemployee":



        $data = array(

            "empname" => $_POST['employeename'],

            "dojoin" => $_POST['dojoin'],

            "contactnumber" => $_POST['contactnumber'],

            "astutenumber" => $_POST['astutenumber'],

            "iProcessid" => $_POST['process'],

            "elisionloginid" => $_POST['elisionloginid'],

            "iteamleadid" => $_POST['iteamleadid'],

            "qualityanalistid" => $_POST['qualityanalistid'],

            "asstmanagerid" => $_POST['asstmanagerid'],

            "processmanager" => $_POST['processmanager'],

            "strEntryDate" => date('d-m-Y H:i:s'),

            "strIP" => $_SERVER['REMOTE_ADDR']

        );

        $where = ' where  employeeid=' . $_REQUEST['employeeid'];

        $dealer_res = $connect->updaterecord($dbconn, 'employee', $data, $where);



        $sql_res = mysqli_query($dbconn, "delete from employeedesignation where  iEmployeeId= " . $_REQUEST['employeeid'] . " ");

        $designation = $_POST['designation'];

        foreach ($designation as $key => $value) {

            if ($value > 0) {



                mysqli_query($dbconn, "INSERT INTO `employeedesignation`(iEmployeeId,iDesignationId,strEntryDate,strIP) VALUES ('" . $_REQUEST['employeeid'] . "','" . $value . "', '" . date('d-m-Y H:i:s') . "', '" . $_SERVER['REMOTE_ADDR'] . "' ) ");
            }
        }



        echo $statusMsg = $dealer_res ? '2' : '0';

        break;*/
        
        case "Editemployee":
        $managerTQid = isset($_POST['managerTQid']) ? (int)$_POST['managerTQid'] : 0;
        $managerOpsid = isset($_POST['managerOpsid']) ? (int)$_POST['managerOpsid'] : 0;
        $managerHRid = isset($_POST['managerHRid']) ? (int)$_POST['managerHRid'] : 0;
        $managerITid = isset($_POST['managerITid']) ? (int)$_POST['managerITid'] : 0;
        $managerMISid = isset($_POST['managerMISid']) ? (int)$_POST['managerMISid'] : 0;
        $processmanager = (isset($_POST['processmanager']) && $_POST['processmanager'] != '') ? $_POST['processmanager'] : 0;
        $qualityanalistid = (isset($_POST['qualityanalistid']) && $_POST['qualityanalistid'] != '') ? $_POST['qualityanalistid'] : 0;
        $iteamleadid = (isset($_POST['iteamleadid']) && $_POST['iteamleadid'] != "" ) ? $_POST['iteamleadid'] : 0;
        
        $asstmanagerid = (isset($_POST['asstmanagerid']) && $_POST['asstmanagerid'] != "" ) ? $_POST['asstmanagerid'] : 0;
        $designation = $_REQUEST['designation'];
        if($designation == 12){
                $trainerId = (int)$_POST['trainerId'];
                
                $asstmanagerid = 0;
                $iteamleadid = 0;
                $qualityanalistid = 0;
                $managerTQid = 0;
                $managerOpsid = 0;
                $managerHRid = 0;
                $managerITid = 0;
                $managerMISid = 0;
            } else if($designation == 5){
                $trainerId = 0;
                
                $asstmanagerid = 0;
                $iteamleadid = $_POST['iteamleadid'];
                $qualityanalistid = $_POST['qualityanalistid'];
                // $("#DivQualityAnalist").show();
                $managerTQid = 0;
                $managerOpsid = 0;
                $managerHRid = 0;
                $managerITid = 0;
                $managerMISid = 0;
            } else if($designation == 9){
                
                $trainerId = 0;
                
                $asstmanagerid = $_POST['asstmanagerid'];
                $iteamleadid = 0;
                $qualityanalistid = 0;
                $managerTQid = $_POST['managerTQid'];
                $managerOpsid = 0;
                $managerHRid = 0;
                $managerITid = 0;
                $managerMISid = 0;
            } else if($designation == 1){
                $trainerId = 0;
                
                $asstmanagerid = $_POST['asstmanagerid'];
                $iteamleadid = 0;
                $qualityanalistid = 0;
                $managerTQid = $_POST['managerTQid'];
                $managerOpsid = 0;
                $managerHRid = 0;
                $managerITid = 0;
                $managerMISid = 0;
            } else if($designation == 4){
                $trainerId = 0;
                
                $asstmanagerid = $_POST['asstmanagerid'];
                $iteamleadid = 0;
                $qualityanalistid = 0;
                $managerTQid = 0;
                $managerOpsid = $_POST['managerOpsid'];
                $managerHRid = 0;
                $managerITid = 0;
                $managerMISid = 0;
            } else if($designation == 18){
                $trainerId = 0;
                
                $asstmanagerid = $_POST['asstmanagerid'];
                $iteamleadid = 0;
                $qualityanalistid = 0;
                $managerTQid = 0;
                $managerOpsid = $_POST['managerOpsid'];
                $managerHRid = 0;
                $managerITid = 0;
                $managerMISid = 0;
            } else if($designation == 7){
                $trainerId = 0;
                
                $asstmanagerid = $_POST['asstmanagerid'];
                $iteamleadid = 0;
                $qualityanalistid = 0;
                $managerTQid = 0;
                $managerOpsid = 0;
                $managerHRid = $_POST['managerHRid'];
                $managerITid = 0;
                $managerMISid = 0;
            } else if($designation == 8){
                $trainerId = 0;
                
                $asstmanagerid = $_POST['asstmanagerid'];
                $iteamleadid = 0;
                $qualityanalistid = 0;
                $managerTQid = 0;
                $managerOpsid = 0;
                $managerHRid = 0;
                $managerITid = $_POST['managerITid'];
                $managerMISid = 0;
            } else if($designation == 10){
                $trainerId = 0;
                
                $asstmanagerid = $_POST['asstmanagerid'];
                $iteamleadid = 0;
                $qualityanalistid = 0;
                $managerTQid = 0;
                $managerOpsid = 0;
                $managerHRid = 0;
                $managerITid = 0;
                $managerMISid = $_POST['managerMISid'];
            } else if($designation == 11){
                $trainerId = 0;
                
                $asstmanagerid = $_POST['asstmanagerid'];
                $iteamleadid = 0;
                $qualityanalistid = 0;
                $managerTQid = 0;
                $managerOpsid = 0;
                $managerHRid = 0;
                $managerITid = 0;
                $managerMISid = $_POST['managerMISid'];
            } else if($designation == 2){
                $trainerId = 0;
                
                $asstmanagerid = 0;
                $iteamleadid = 0;
                $qualityanalistid = 0;
                $managerTQid = $_POST['managerTQid'];
                $managerOpsid = $_POST['managerOpsid'];
                $managerHRid = $_POST['managerHRid'];
                $managerITid = $_POST['managerITid'];
                $managerMISid = $_POST['managerMISid'];
            } else if($designation == 13){
                $trainerId = 0;
                
                $asstmanagerid = 0;
                $iteamleadid = 0;
                $qualityanalistid = 0;
                $managerTQid = 0;
                $managerOpsid = 0;
                $managerHRid = 0;
                $managerITid = 0;
                $managerMISid = 0;
            } else if($designation == 14){
                $trainerId = 0;
                
                $asstmanagerid = 0;
                $iteamleadid = 0;
                $qualityanalistid = 0;
                $managerTQid = 0;
                $managerOpsid = 0;
                $managerHRid = 0;
                $managerITid = 0;
                $managerMISid = 0;
            } else if($designation == 15){
                $trainerId = 0;
                
                $asstmanagerid = 0;
                $iteamleadid = 0;
                $qualityanalistid = 0;
                $managerTQid = 0;
                $managerOpsid = 0;
                $managerHRid = 0;
                $managerITid = 0;
                $managerMISid = 0;
            } else if($designation == 16){
                $trainerId = 0;
                
                $asstmanagerid = 0;
                $iteamleadid = 0;
                $qualityanalistid = 0;
                $managerTQid = 0;
                $managerOpsid = 0;
                $managerHRid = 0;
                $managerITid = 0;
                $managerMISid = 0;
            } else if($designation == 17){
                $trainerId = 0;
                
                $asstmanagerid = 0;
                $iteamleadid = 0;
                $qualityanalistid = 0;
                $managerTQid = 0;
                $managerOpsid = 0;
                $managerHRid = 0;
                $managerITid = 0;
                $managerMISid = 0;
            } else {
                $trainerId = 0;
                
                $asstmanagerid = 0;
                $iteamleadid = 0;
                $qualityanalistid = 0;
                $managerTQid = 0;
                $managerOpsid = 0;
                $managerHRid = 0;
                $managerITid = 0;
                $managerMISid = 0;
            }
        
        $data = array(
            "empname" => $_POST['employeename'],
            "dojoin" => $_POST['dojoin'],
            "contactnumber" => $_POST['contactnumber'],
            "astutenumber" => $_POST['astutenumber'],
            "iProcessid" => $_POST['process'],
            "elisionloginid" => $_POST['elisionloginid'],
            "iteamleadid" => $iteamleadid ?? 0,
            "qualityanalistid" => $qualityanalistid ?? 0,
            "asstmanagerid" => $asstmanagerid ?? 0,
            //"processmanager" => $_POST['processmanager'],
            "managerTQid" => $managerTQid ?? 0,
            "managerOpsid" => $managerOpsid ?? 0,
            "managerHRid" => $managerHRid ?? 0,
            "managerITid" => $managerITid ?? 0,
            "managerMISid" => $managerMISid ?? 0,
            "strEntryDate" => date('d-m-Y H:i:s'),
            "strIP" => $_SERVER['REMOTE_ADDR']
        );
        
        $where = ' where  employeeid=' . $_REQUEST['employeeid'];
        $dealer_res = $connect->updaterecord($dbconn, 'employee', $data, $where);

        $sql_res = mysqli_query($dbconn, "delete from employeedesignation where  iEmployeeId= " . $_REQUEST['employeeid'] . " ");
        $designation = $_POST['designation'];
        mysqli_query($dbconn, "INSERT INTO `employeedesignation`(iEmployeeId,iDesignationId,strEntryDate,strIP) VALUES ('" . $_REQUEST['employeeid'] . "','" . $designation . "', '" . date('d-m-Y H:i:s') . "', '" . $_SERVER['REMOTE_ADDR'] . "' ) ");
        // $designation = $_POST['designation'];
        // foreach ($designation as $key => $value) {
        //     if ($value > 0) {
        //         mysqli_query($dbconn, "INSERT INTO `employeedesignation`(iEmployeeId,iDesignationId,strEntryDate,strIP) VALUES ('" . $_REQUEST['employeeid'] . "','" . $value . "', '" . date('d-m-Y H:i:s') . "', '" . $_SERVER['REMOTE_ADDR'] . "' ) ");
        //     }
        // }
        echo $statusMsg = $dealer_res ? '2' : '0';
        break;
    
    case "UploadFollowupEntry":

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

            // ================= FIRST PASS: VALIDATION =================
            foreach ($Sheets as $Index => $Name) {
                $Reader->ChangeSheet($Index);

                foreach ($Reader as $key => $slice) {
                    if (empty(array_filter($slice))) continue; // skip empty rows

                    if ($ValCounter == 0) {
                        // Read Headers
                        for ($icounter = 0; $icounter < count($slice); $icounter++) {
                            $header = trim($slice[$icounter]);

                            if ($header != "") {
                                $headerArray[$jCounterArray] = $header;

                                if ($header == "Loan Number")              $iColumnCounter['loan_number'] = $icounter;
                                if ($header == "Disposition")              $iColumnCounter['disposition'] = $icounter;
                                if ($header == "Sub Disposition")          $iColumnCounter['sub_disposition'] = $icounter;
                                if ($header == "Follow Up/PTP Date")       $iColumnCounter['followup_ptp_date'] = $icounter;
                                if ($header == "PTP Amount")               $iColumnCounter['ptp_amount'] = $icounter;
                                if ($header == "Comment")                  $iColumnCounter['remark'] = $icounter;

                                $jCounterArray++;
                            }
                        }
                    } else {
                        $RowCounter = $key + 1;

                        $loanNumber     = trim($slice[$iColumnCounter['loan_number']] ?? '');
                        $disposition    = trim($slice[$iColumnCounter['disposition']] ?? '');
                        $subDisposition = trim($slice[$iColumnCounter['sub_disposition']] ?? '');
                        $followupRaw    = trim($slice[$iColumnCounter['followup_ptp_date']] ?? '');
                        $ptpamount      = trim($slice[$iColumnCounter['ptp_amount']] ?? '');

                        // ========== VALIDATION ==========
                        if ($loanNumber == "") {
                            $errorString .= "Row $RowCounter: Loan Number is required.<br/>";
                            continue;
                        }

                        if ($disposition == "") {
                            $errorString .= "Row $RowCounter: Disposition is required.<br/>";
                            continue;
                        }

                        if ($subDisposition == "") {
                            $errorString .= "Row $RowCounter: Sub Disposition is required.<br/>";
                            continue;
                        }

                        if (strtolower($disposition) == "promise to pay") {
                            if ($followupRaw == "") {
                                $errorString .= "Row $RowCounter: Follow Up/PTP Date required when Disposition is 'Promise to Pay'.<br/>";
                                continue;
                            }

                            if ($ptpamount == "") {
                                $errorString .= "Row $RowCounter: PTP Amount required when Disposition is 'Promise to Pay'.<br/>";
                                continue;
                            }
                            if (!is_numeric($ptpamount) || $ptpamount <= 0) {
                                $errorString .= "Row $RowCounter: PTP Amount must be a positive number when Disposition is 'Promise to Pay'.<br/>";
                                continue;
                            }
                        }

                        // Check if application exists
                        $result = mysqli_query($dbconn, "
                                SELECT iAppId, agentId 
                                FROM application 
                                WHERE isDelete='0' 
                                AND applicatipnNo='" . mysqli_real_escape_string($dbconn, $loanNumber) . "'
                                ORDER BY iAppId DESC 
                                LIMIT 1
                            ") or die(mysqli_error($dbconn));

                        $app = mysqli_fetch_assoc($result);

                        if (!$app) {
                            $errorString .= "Row $RowCounter: Application not found for Loan Number '$loanNumber'.<br/>";
                            continue;
                        }

                        if (trim($app['agentId']) == '') {
                            $errorString .= "Row $RowCounter: Agent not assigned for Loan Number '$loanNumber'.<br/>";
                            continue;
                        }
                    }

                    $ValCounter++;
                }
            }

            // Check for missing headers
            $requiredHeaders = ['loan_number', 'disposition', 'sub_disposition', 'followup_ptp_date'];
            foreach ($requiredHeaders as $header) {
                if (!isset($iColumnCounter[$header])) {
                    echo "Error: Missing required column header (" . ucwords(str_replace('_', ' ', $header)) . ").";
                    unlink($file_path);
                    break 2;
                }
            }

            // Validation errors
            if (!empty($errorString)) {
                echo "Error:<br/>" . $errorString;
                unlink($file_path);
                break;
            }

            // ================= SECOND PASS: INSERT FOLLOW-UP =================
            $iCounterRow = 0;
            foreach ($Sheets as $Index => $Name) {
                $Reader->ChangeSheet($Index);

                foreach ($Reader as $key => $slice) {
                    if (empty(array_filter($slice))) continue;
                    if ($iCounterRow == 0) {
                        $iCounterRow++;
                        continue;
                    }

                    $loanNumber     = trim($slice[$iColumnCounter['loan_number']] ?? '');
                    $disposition    = trim($slice[$iColumnCounter['disposition']] ?? '');
                    $subDisposition = trim($slice[$iColumnCounter['sub_disposition']] ?? '');
                    $followupRaw    = trim($slice[$iColumnCounter['followup_ptp_date']] ?? '');
                    $ptpAmount      = trim($slice[$iColumnCounter['ptp_amount']] ?? '');
                    $remark         = trim($slice[$iColumnCounter['remark']] ?? '');

                    // $commonDate = !empty($followupRaw) ? date('d-m-Y', strtotime($followupRaw)) : null;
                    //$commonDate = !empty($followupRaw) ? date('d-m-Y', strtotime($followupRaw)) : null;
                    $commonDate = null;
                    if (!empty($followupRaw)) {
                        // Try to parse normal date formats first
                        $dt = DateTime::createFromFormat('d-m-Y', $followupRaw)
                            ?: DateTime::createFromFormat('Y-m-d', $followupRaw)
                            ?: DateTime::createFromFormat('d/m/Y', $followupRaw);
                    
                        // If Excel sent a number (e.g., 45652)
                        if (!$dt && is_numeric($followupRaw)) {
                            $unixDate = ($followupRaw - 25569) * 86400; // Excel epoch offset
                            $dt = (new DateTime())->setTimestamp($unixDate);
                        }
                    
                        // Final formatted value
                        if ($dt) {
                            $commonDate = $dt->format('d-m-Y'); // your desired format
                        }
                    }
                    $ptpAmount  = ($ptpAmount != "" && is_numeric($ptpAmount)) ? $ptpAmount : 0;

                    // Get application info
                    $result = mysqli_query($dbconn, "
                            SELECT iAppId, agentId 
                            FROM application 
                            WHERE isDelete='0' 
                            AND applicatipnNo='" . mysqli_real_escape_string($dbconn, $loanNumber) . "'
                            ORDER BY iAppId DESC 
                            LIMIT 1
                        ") or die(mysqli_error($dbconn));

                    $app = mysqli_fetch_assoc($result);
                    if (!$app) continue;

                    $applicationId = $app['iAppId'];
                    $agentId       = $app['agentId'];

                    // Get employee iEmpId from employee table
                    $empQuery = mysqli_query($dbconn, "
                            SELECT employeeid 
                            FROM employee 
                            WHERE employeeid = '" . mysqli_real_escape_string($dbconn, $agentId) . "'
                            LIMIT 1
                        ") or die(mysqli_error($dbconn));
                    $emp = mysqli_fetch_assoc($empQuery);
                    $iEmpId = $emp ? $emp['employeeid'] : 0;

                    // Get dispoType from dispositionmaster
                    // $dispoQuery = mysqli_query($dbconn, "
                    //         SELECT dispoType 
                    //         FROM dispositionmaster 
                    //         WHERE masterDispoId = '" . mysqli_real_escape_string($dbconn, $disposition) . "'
                    //         LIMIT 1
                    //     ") or die(mysqli_error($dbconn));
                    // $dispo = mysqli_fetch_assoc($dispoQuery);
                    // $dispoType = $dispo ? $dispo['dispoType'] : '';
                    
                    // Get dispoType from dispositionmaster
                    $dispoQuery = mysqli_query($dbconn, "
                            SELECT dispoType,iDispoId
                            FROM dispositionmaster 
                            WHERE dispoDesc = '" . mysqli_real_escape_string($dbconn, $disposition) . "'
                            LIMIT 1
                        ") or die(mysqli_error($dbconn));
                    $dispo = mysqli_fetch_assoc($dispoQuery);
                    $dispoType = $dispo ? $dispo['dispoType'] : '';
                    $mainDispoId = $dispo ? $dispo['iDispoId'] : '';

                    $sub_dispoQuery = mysqli_query($dbconn, "
                            SELECT iDispoId
                            FROM dispositionmaster 
                            WHERE dispoDesc = '" . mysqli_real_escape_string($dbconn, $subDisposition) . "'
                            LIMIT 1
                        ") or die(mysqli_error($dbconn));
                    $sub_dispo = mysqli_fetch_assoc($sub_dispoQuery);
                    $subDispoId = $dispo ? $dispo['iDispoId'] : '';

                    // Determine which fields to fill
                    //$followupDate = $commonDate;
                    $followupDate = (strtolower($disposition) != "promise to pay") ? $commonDate : null;
                    $ptpDate = (strtolower($disposition) == "promise to pay") ? $commonDate : null;

                    // Insert into applicationfollowup
                    // '" . mysqli_real_escape_string($dbconn, $disposition) . "',
                    // '" . mysqli_real_escape_string($dbconn, $subDisposition) . "',
                    $insertQuery = "
                            INSERT INTO applicationfollowup 
                            (iAppId, applicatipnNo, iEmpId, dispoType, mainDispoId, subDispoId, followupDate, PTPDate, PTP_Amount, remark, strEntryDate, strIP)
                            VALUES (
                                '$applicationId',
                                '" . mysqli_real_escape_string($dbconn, $loanNumber) . "',
                                '$iEmpId',
                                '" . mysqli_real_escape_string($dbconn, $dispoType) . "',
                                
                                '" . mysqli_real_escape_string($dbconn, $mainDispoId) . "',
                                '" . mysqli_real_escape_string($dbconn, $subDispoId) . "',
                                " . ($followupDate ? "'$followupDate'" : "NULL") . ",
                                " . ($ptpDate ? "'$ptpDate'" : "NULL") . ",
                                '$ptpAmount',
                                '" . mysqli_real_escape_string($dbconn, $remark) . "',
                                '" . date('d-m-Y H:i:s') . "',
                                '" . $_SERVER['REMOTE_ADDR'] . "'
                            )
                        ";
                    
                    mysqli_query($dbconn, $insertQuery) or die("Error inserting follow-up at row $iCounterRow: " . mysqli_error($dbconn));
                    $followupId = mysqli_insert_id($dbconn);

                    // Update application
                    $updateApp = "
                            UPDATE application 
                            SET iAppLogId = '$followupId', isFollowDone = 1 
                            WHERE iAppId = '$applicationId'
                        ";
                    mysqli_query($dbconn, $updateApp) or die("Error updating application: " . mysqli_error($dbconn));

                    $iCounterRow++;
                }
            }

            echo "Follow-up records uploaded and applications updated successfully.";
            @unlink($file_path);
        }

        break;


    default:

        # code...

        echo "Page not Found";

        break;
}

function parseExcelDate($value) {
    // If numeric → Excel serial date
    if (is_numeric($value)) {
        $excelBase = \DateTime::createFromFormat('Y-m-d', '1899-12-30');
        return $excelBase->modify("+$value days")->format('Y-m-d');
    }

    $value = trim($value);

    // Try multiple date formats
    $formats = ['m-d-y', 'm-d-Y', 'd-m-Y', 'd-m-y', 'Y-m-d', 'd/m/Y', 'd/m/y', 'm/d/Y', 'm/d/y'];

    foreach ($formats as $fmt) {
        $dt = \DateTime::createFromFormat($fmt, $value);
        if ($dt && $dt->format($fmt) === $value) {
            return $dt->format('Y-m-d');
        }
    }

    // Fallback: let strtotime try
    $timestamp = strtotime($value);
    if ($timestamp !== false) {
        return date('Y-m-d', $timestamp);
    }

    return null; // invalid
}
