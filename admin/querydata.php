<?php
//ob_start();
error_reporting(E_ALL);
include('../common.php');
$connect = new connect();
include 'IsLogin.php';
include 'password_hash.php';
require('../spreadsheet-reader-master/SpreadsheetReader.php');
require_once '../spreadsheet-reader-master/php-excel-reader/excel_reader2.php';

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
                                    }

                                    //                                    else {

                                    //                                        $elisionloginidRow = $elisionloginid['elisionloginid'];

                                    //                                    }

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

                    break;
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
                                            } else if ($slice[$iColumnCounter[4]] == '0:00:00') {

                                                $LoginTime = '0:00:00';
                                            } else {

                                                $LoginTime = date('h:i:s', strtotime($slice[$iColumnCounter[4]]));
                                            }



                                            if ($slice[$iColumnCounter[5]] == "NA") {

                                                $LogoutTime = "NA";
                                            } elseif ($slice[$iColumnCounter[5]] == '0:00:00') {

                                                $LogoutTime = "0:00:00";
                                            } else {

                                                //                                                $LogoutTime = explode(" ",$slice[$iColumnCounter[5]]);

                                                $LogoutTime = date('H:i:s', strtotime($slice[$iColumnCounter[5]]));
                                            }



                                            $dataCustomer = array(

                                                "date" => $slice[$iColumnCounter[0]],

                                                "elisionloginid" => $slice[$iColumnCounter[1]],

                                                "bucket" => strtolower($slice[$iColumnCounter[2]]),

                                                "Attendance" => $slice[$iColumnCounter[3]],

                                                "LoginTime" => $LoginTime,

                                                "LogoutTime" => $LogoutTime,

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

                                            //                                            print_r($dataCustomer);

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
            }
        }



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



    case "UserProfileChangePassword":

        $hash_result = create_hash($_POST['oldpassword']);

        $hash_params = explode(":", $hash_result);

        $salt = $hash_params[HASH_SALT_INDEX];

        $hash = $hash_params[HASH_PBKDF2_INDEX];

        $existsmail = "SELECT * FROM admin where id='" . $_SESSION['AdminId'] . "'";

        $result = mysqli_query($dbconn, $existsmail);

        $num_rows = mysqli_num_rows($result);

        $row = mysqli_fetch_array($result);



        if ($num_rows >= 1) {

            $good_hash = PBKDF2_HASH_ALGORITHM . ":" . PBKDF2_ITERATIONS . ":" . $row['salt'] . ":" . $row['password'];

            $oldpassword = $_REQUEST['oldpassword'];

            if (validate_password($_REQUEST['oldpassword'], $good_hash)) {

                $hash_result = create_hash($_REQUEST['password']);

                $hash_params = explode(":", $hash_result);

                $salt = $hash_params[HASH_SALT_INDEX];

                $hash = $hash_params[HASH_PBKDF2_INDEX];

                $getItems1 = mysqli_query($dbconn, "update admin SET password = '" . $hash . "', salt = '" . $salt . "' where id='" . $_SESSION['AdminId'] . "'");

                echo "Sucess";
            } else {

                echo "OldNot";
            }
        } else {

            echo "ID not found";
        }

        break;



    case "Addprocess":



        $data = array(

            "processname" => $_POST['process'],

            "strEntryDate" => date('d-m-Y H:i:s'),

            "strIP" => $_SERVER['REMOTE_ADDR']

        );

        $dealer_res = $connect->insertrecord($dbconn, 'processmaster', $data);

        echo $statusMsg = $dealer_res ? '1' : '0';

        break;



    case "GetAdminprocess":

        $filterstr = "SELECT * FROM `processmaster`  where  isDelete='0'  and  istatus='1' and  processmasterid =" . $_REQUEST['ID'] . "";

        $result = mysqli_query($dbconn, $filterstr);

        $row = mysqli_fetch_array($result);

        print_r(json_encode($row));

        break;



    case "Editprocess":



        $data = array(

            "processname" => $_REQUEST['process'],

            "strEntryDate" => date('d-m-Y H:i:s'),

            "strIP" => $_SERVER['REMOTE_ADDR']

        );

        $where = ' where  processmasterid=' . $_REQUEST['processmasterid'];

        $dealer_res = $connect->updaterecord($dbconn, 'processmaster', $data, $where);

        echo $statusMsg = $dealer_res ? '2' : '0';

        break;



    case "AddDispositionM":



        $data = array(

            "dispoType" => $_POST['dispoType'],

            "dispoDesc" => $_POST['dispo'],

            "dispoCode" => $_POST['dispoCode'],

            "strEntryDate" => date('d-m-Y H:i:s'),

            "strIP" => $_SERVER['REMOTE_ADDR']

        );

        $dealer_res = $connect->insertrecord($dbconn, 'dispositionmaster', $data);

        echo $statusMsg = $dealer_res ? '1' : '0';

        break;



    case "GetdispoMain":

        $filterstr = "SELECT * FROM `dispositionmaster`  where   iDispoId =" . $_REQUEST['ID'];

        $result = mysqli_query($dbconn, $filterstr);

        $row = mysqli_fetch_array($result);

        print_r(json_encode($row));

        break;



    case "EditDispositionM":



        $data = array(

            "dispoType" => $_POST['dispoType'],

            "dispoDesc" => $_POST['dispo'],

            "dispoCode" => $_POST['dispoCode']

        );

        $where = ' where  iDispoId=' . $_REQUEST['dispoid'];

        $dealer_res = $connect->updaterecord($dbconn, 'dispositionmaster', $data, $where);

        echo $statusMsg = $dealer_res ? '2' : '0';

        break;



    case "AddDispositionS":



        $data = array(

            "dispoType" => $_POST['dispoType'],

            "masterDispoId" => $_POST['masterDispo'],

            "dispoDesc" => $_POST['dispo'],

            "strEntryDate" => date('d-m-Y H:i:s'),

            "strIP" => $_SERVER['REMOTE_ADDR']

        );

        $dealer_res = $connect->insertrecord($dbconn, 'dispositionmaster', $data);

        echo $statusMsg = $dealer_res ? '1' : '0';

        break;



    case "GetdispoSub":

        $filterstr = "SELECT * FROM `dispositionmaster`  where   iDispoId =" . $_REQUEST['ID'];

        $result = mysqli_query($dbconn, $filterstr);

        $row = mysqli_fetch_array($result);

        print_r(json_encode($row));

        break;



    case "EditDispositionS":



        $data = array(

            "dispoType" => $_POST['dispoType'],

            "masterDispoId" => $_POST['masterDispo'],

            "dispoDesc" => $_POST['dispo'],

        );

        $where = ' where  iDispoId=' . $_REQUEST['dispoid'];

        $dealer_res = $connect->updaterecord($dbconn, 'dispositionmaster', $data, $where);

        echo $statusMsg = $dealer_res ? '2' : '0';

        break;



    case "AddFAQ":



        $data = array(

            "strfaq" => $_POST['FAQ'],

            "language" => $_POST['language'],

            "strEntryDate" => date('d-m-Y H:i:s'),

            "strIP" => $_SERVER['REMOTE_ADDR']

        );

        $dealer_res = $connect->insertrecord($dbconn, 'faq', $data);

        echo $statusMsg = $dealer_res ? '1' : '0';

        break;



    case "GetAdminFAQ":

        $filterstr = "SELECT * FROM `faq`  where  isDelete='0'  and  istatus='1' and   	faqid =" . $_REQUEST['ID'] . "";

        $result = mysqli_query($dbconn, $filterstr);

        $row = mysqli_fetch_array($result);

        print_r(json_encode($row));

        break;



    case "EditFAQ":



        $data = array(

            "strfaq" => $_POST['FAQ'],

            "language" => $_POST['language'],

            "strEntryDate" => date('d-m-Y H:i:s'),

            "strIP" => $_SERVER['REMOTE_ADDR']

        );

        $where = ' where  faqid=' . $_REQUEST['faqid'];

        $dealer_res = $connect->updaterecord($dbconn, 'faq', $data, $where);

        echo $statusMsg = $dealer_res ? '2' : '0';

        break;



    case "AddFAQanswerhead":



        $data = array(

            "strhead" => $_POST['FAQAnswerHead'],

            "strEntryDate" => date('d-m-Y H:i:s'),

            "strIP" => $_SERVER['REMOTE_ADDR']

        );

        $dealer_res = $connect->insertrecord($dbconn, 'faqanswerhead', $data);

        echo $statusMsg = $dealer_res ? '1' : '0';

        break;



    case "GetAdminFAQAnswerHead":

        $filterstr = "SELECT * FROM `faqanswerhead`  where  isDelete='0'  and  istatus='1' and  faqanswerheadid =" . $_REQUEST['ID'] . "";

        $result = mysqli_query($dbconn, $filterstr);

        $row = mysqli_fetch_array($result);

        print_r(json_encode($row));

        break;



    case "EditFAQAnswerHead":



        $data = array(

            "strhead" => $_REQUEST['FAQAnswerHead'],

            "strEntryDate" => date('d-m-Y H:i:s'),

            "strIP" => $_SERVER['REMOTE_ADDR']

        );

        $where = ' where  faqanswerheadid =' . $_REQUEST['faqanswerheadid'];

        $dealer_res = $connect->updaterecord($dbconn, 'faqanswerhead', $data, $where);

        echo $statusMsg = $dealer_res ? '2' : '0';

        break;



    case "AddFAQanswer":



        $data = array(

            "faqid" => $_POST['faqid'],

            "faqheadid" => $_POST['faqheadid'],

            "language" => $_POST['language'],

            "answer" => $_POST['answer'],

            "strEntryDate" => date('d-m-Y H:i:s'),

            "strIP" => $_SERVER['REMOTE_ADDR']

        );

        $dealer_res = $connect->insertrecord($dbconn, 'faqanswer', $data);

        echo $statusMsg = $dealer_res ? '1' : '0';

        break;



    case "GetAdminFAQAnswer":



        $filterstr = "SELECT * FROM `faqanswer`  where  isDelete='0'  and  istatus='1' and  faqanswerid =" . $_REQUEST['ID'] . "";

        $result = mysqli_query($dbconn, $filterstr);

        $row = mysqli_fetch_array($result);

        print_r(json_encode($row));

        break;



    case "EditFAQAnswer":



        $data = array(

            "faqid" => $_POST['faqid'],

            "faqheadid" => $_POST['faqheadid'],

            "language" => $_POST['language'],

            "answer" => $_POST['answer'],

            "strEntryDate" => date('d-m-Y H:i:s'),

            "strIP" => $_SERVER['REMOTE_ADDR']

        );

        $where = ' where  faqanswerid =' . $_REQUEST['faqanswerid'];

        $dealer_res = $connect->updaterecord($dbconn, 'faqanswer', $data, $where);

        echo $statusMsg = $dealer_res ? '2' : '0';



        break;



    case "EditStoreLocator":

        $data = array(

            "pincode" => $_POST['PinCode'],

            "partner" => $_POST['Partner'],

            "city" => $_POST['City'],

            "state" => $_POST['State'],

            "zone" => $_POST['Zone'],

            "address" => $_POST['Address'],

            "storeName" => $_POST['StoreName'],

            "SOname" => $_POST['SOName'],

            "ASM" => $_POST['ASM'],

            "contactNumber" => $_POST['ContactNumber']

        );

        $where = ' where  storeListId=' . $_REQUEST['storeListId'];

        $dealer_res = $connect->updaterecord($dbconn, 'storelist', $data, $where);



        echo $statusMsg = $dealer_res ? '2' : '0';

        break;



    case "EditAxisBankBranch":

        $data = array(

            "strState" => $_POST['strState'],

            "strDistrict" => $_POST['strDistrict'],

            "pincode" => $_POST['pincode'],

            "strBranchName" => $_POST['strBranchName'],

            "strAdress" => $_POST['strAdress']

        );

        $where = ' where  iAxisBankBranchId=' . $_REQUEST['iAxisBankBranchId'];

        $dealer_res = $connect->updaterecord($dbconn, 'axisbankbranch', $data, $where);



        echo $statusMsg = $dealer_res ? '2' : '0';

        break;



    case "AddNews":



        $data = array(

            "news" => $_POST['news'],

            "startdate" => $_POST['from'],

            "enddate" => $_POST['to'],

            "designationid" => '0',

            "employeeid" => '0',

            "strEntryDate" => date('d-m-Y H:i:s'),

            "strIP" => $_SERVER['REMOTE_ADDR']

        );

        $dealer_res = $connect->insertrecord($dbconn, 'newflash', $data);

        echo $statusMsg = $dealer_res ? '1' : '0';

        break;



    case "GetAdminNews":

        $filterstr = "SELECT * FROM `newflash`  where  isDelete='0'  and  istatus='1' and  newflashid =" . $_REQUEST['ID'] . "";

        $result = mysqli_query($dbconn, $filterstr);

        $row = mysqli_fetch_array($result);

        print_r(json_encode($row));

        break;



    case "EditNews":



        $data = array(

            "news" => $_POST['news'],

            "startdate" => $_POST['from'],

            "enddate" => $_POST['to'],

            "designationid" => '0',

            "employeeid" => '0',

            "strEntryDate" => date('d-m-Y H:i:s'),

            "strIP" => $_SERVER['REMOTE_ADDR']

        );

        $where = ' where  newflashid =' . $_REQUEST['newflashid'];

        $dealer_res = $connect->updaterecord($dbconn, 'newflash', $data, $where);

        echo $statusMsg = $dealer_res ? '2' : '0';

        break;



    /*case "Addemployee":



        $hash_result = create_hash($_REQUEST['Password']);

        $hash_params = explode(":", $hash_result);

        $salt = $hash_params[HASH_SALT_INDEX];

        $hash = $hash_params[HASH_PBKDF2_INDEX];
        $processmanager = 0;
        $asstmanagerid = 0;
        $iteamleadid = 0;
        $qualityanalistid = 0;

        if (isset($_POST['centralmanager']) && $_POST['centralmanager'] != '') {

            $centralmanager = $_POST['centralmanager'];
        } else {

            $centralmanager = '0';
        }
        if (isset($_POST['processmanager']) && $_POST['processmanager'] != '') {

            $processmanager = $_POST['processmanager'];
        } else {

            $processmanager = '0';
        }
        if (isset($_POST['qualityanalistid']) && $_POST['qualityanalistid'] != '') {

            $qualityanalistid = $_POST['qualityanalistid'];
        } else {

            $qualityanalistid = '0';
        }

        if (isset($_POST['asstmanagerid']) && $_POST['asstmanagerid'] != '') {

            $asstmanagerid = $_POST['asstmanagerid'];
            $result_AM = mysqli_fetch_array(mysqli_query($dbconn, "SELECT processmanager FROM `employee` WHERE iteamleadid=0 and employeeid=" . $asstmanagerid . " and centralmanagerId='" . $_POST['centralmanager'] . "'"));
            $processmanager = $result_AM['processmanager'];
        } else {

            $asstmanagerid = '0';
        }
        if (isset($_POST['iteamleadid']) && $_POST['iteamleadid'] != '') {

            $iteamleadid = $_POST['iteamleadid'];
            $result_TL = mysqli_fetch_array(mysqli_query($dbconn, "SELECT * FROM `employee` WHERE iteamleadid=0 and employeeid=" . $iteamleadid . " and centralmanagerId='" . $_POST['centralmanager'] . "'"));
            $processmanager = $result_TL['processmanager'];
            $asstmanagerid = $result_TL['asstmanagerid'];
        } else {

            $iteamleadid = '0';
        }
        
        if(isset($_POST['trainerId']) && ($_POST['trainerId'] != '' )) {
            $trainerId = '0';
        } else {
            $trainerId = $_POST['trainerId'];
            $result_TL = mysqli_fetch_array(mysqli_query($dbconn, "SELECT * FROM `employee` WHERE iteamleadid=0 and employeeid=" . $trainerId . " "));
            $centralmanager = $result_TL['centralmanagerId'];
            $processmanager = $result_TL['processmanager'];
            $asstmanagerid = $result_TL['asstmanagerid'];
        }

        $elisionloginid = mysqli_query($dbconn, "SELECT * FROM `employee` WHERE elisionloginid='" . $_POST['elisionloginid'] . "' and istatus=1 and isDelete=0");
        if (mysqli_num_rows($elisionloginid) == 0) {
            $data = array(
                "empname" => $_POST['employeename'],
                "dojoin" => $_POST['dojoin'],
                "contactnumber" => $_POST['contactnumber'],
                "astutenumber" => $_POST['astutenumber'],
                "iProcessid" => 0,
                "elisionloginid" => $_POST['elisionloginid'],
                "Password" => $hash,
                "strsalt" => $salt,
                "iteamleadid" => $iteamleadid,
                "qualityanalistid" => $qualityanalistid,
                "asstmanagerid" => $asstmanagerid,
                "processmanager" => $processmanager,
                "centralmanagerId" => $centralmanager,
                "trainerId" => $trainerId,
                "strEntryDate" => date('d-m-Y H:i:s'),
                "strIP" => $_SERVER['REMOTE_ADDR']
            );

            $dealer_res = $connect->insertrecord($dbconn, 'employee', $data);
            $designation = $_POST['designation'];
            foreach ($designation as $key => $value) {
                if ($value > 0) {
                    mysqli_query($dbconn, "INSERT INTO `employeedesignation`(iEmployeeId,iDesignationId,strEntryDate,strIP) VALUES ('" . $dealer_res . "','" . $value . "', '" . date('d-m-Y H:i:s') . "', '" . $_SERVER['REMOTE_ADDR'] . "' ) ");
                }
            }
            $process = $_POST['process'];
            foreach ($process as $key => $value) {
                if ($value > 0) {
                    mysqli_query($dbconn, "INSERT INTO `employeeprocess`(iEmployeeId,iProcessId,strEntryDate,strIP) VALUES ('" . $dealer_res . "','" . $value . "', '" . date('d-m-Y H:i:s') . "', '" . $_SERVER['REMOTE_ADDR'] . "' ) ");
                }
            }
            echo $statusMsg = $dealer_res ? '1' : '0';
        } else {
            echo $dealer_res = 2;
        }

        break;*/

    case "Addemployee":
        $hash_result = create_hash($_REQUEST['Password']);
        $hash_params = explode(":", $hash_result);
        $salt = $hash_params[HASH_SALT_INDEX];
        $hash = $hash_params[HASH_PBKDF2_INDEX];
        $processmanager = 0;
        $asstmanagerid = 0;
        $iteamleadid = 0;
        $qualityanalistid = 0;
        $centralmanager = '0';
        // Set values from request if they exist
        $managerTQid = isset($_POST['managerTQid']) ? (int)$_POST['managerTQid'] : 0;
        $managerOpsid = isset($_POST['managerOpsid']) ? (int)$_POST['managerOpsid'] : 0;
        $managerHRid = isset($_POST['managerHRid']) ? (int)$_POST['managerHRid'] : 0;
        $managerITid = isset($_POST['managerITid']) ? (int)$_POST['managerITid'] : 0;
        $managerMISid = isset($_POST['managerMISid']) ? (int)$_POST['managerMISid'] : 0;
            
        if (isset($_POST['centralmanager']) && $_POST['centralmanager'] != '') {
            $centralmanager = $_POST['centralmanager'];
        } else {
            $centralmanager = '0';
        }
        if (isset($_POST['processmanager']) && $_POST['processmanager'] != '') {
            $processmanager = $_POST['processmanager'];
        } else {
            $processmanager = '0';
        }
        if (isset($_POST['qualityanalistid']) && $_POST['qualityanalistid'] != '') {
            $qualityanalistid = $_POST['qualityanalistid'];
        } else {
            $qualityanalistid = '0';
        }
        if (isset($_POST['asstmanagerid']) && $_POST['asstmanagerid'] != '') {
            $asstmanagerid = $_POST['asstmanagerid'];
            $result_AM = mysqli_fetch_array(mysqli_query($dbconn, "SELECT processmanager FROM `employee` WHERE iteamleadid=0 and employeeid=" . $asstmanagerid . " and centralmanagerId='" . $_POST['centralmanager'] . "'"));
            $processmanager = $result_AM['processmanager'];
            // $managerTQid = $result_AM['managerTQid'];
            // $managerOpsid = $result_AM['managerOpsid'];
            // $managerHRid = $result_AM['managerHRid'];
            // $managerITid = $result_AM['managerITid'];
            // $managerMISid = $result_AM['managerMISid'];
        } else {
            $asstmanagerid = '0';
        }
        if (isset($_POST['iteamleadid']) && $_POST['iteamleadid'] != '') {
            $iteamleadid = $_POST['iteamleadid'];
            $result_TL = mysqli_fetch_array(mysqli_query($dbconn, "SELECT * FROM `employee` WHERE iteamleadid=0 and employeeid=" . $iteamleadid . " and centralmanagerId='" . $_POST['centralmanager'] . "'"));
            $processmanager = $result_TL['processmanager'];
            $asstmanagerid = $result_TL['asstmanagerid'];
            // $managerTQid = $result_TL['managerTQid'];
            // $managerOpsid = $result_TL['managerOpsid'];
            // $managerHRid = $result_TL['managerHRid'];
            // $managerITid = $result_TL['managerITid'];
            // $managerMISid = $result_TL['managerMISid'];
        } else {
            $iteamleadid = '0';
        }
        $trainerId = '0';
        
        if(isset($_POST['trainerId']) && ((int)$_POST['trainerId'] == ''|| (int)$_POST['trainerId'] == 0)) {
            $trainerId = '0';
        } else {
            $trainerId = (int)$_POST['trainerId'];
            $result_TL = mysqli_fetch_array(mysqli_query($dbconn, "SELECT * FROM `employee` WHERE iteamleadid=0 and employeeid=" . $trainerId . " "));
            $centralmanager = $result_TL['centralmanagerId'];
            $processmanager = $result_TL['processmanager'] ?? 0;
            $asstmanagerid = $result_TL['asstmanagerid'] ?? 0;
            $managerTQid = $result_TL['managerTQid'] ?? 0;
            $managerOpsid = $result_TL['managerOpsid'] ?? 0;
            $managerHRid = $result_TL['managerHRid'] ?? 0;
            $managerITid = $result_TL['managerITid'] ?? 0;
            $managerMISid = $result_TL['managerMISid'] ?? 0;
        }
        
        
        $elisionloginid = mysqli_query($dbconn, "SELECT * FROM `employee` WHERE elisionloginid='" . $_POST['elisionloginid'] . "' and istatus=1 and isDelete=0");
        if (mysqli_num_rows($elisionloginid) == 0) {
            $data = array(
                "empname" => $_POST['employeename'],
                "dojoin" => $_POST['dojoin'],
                "contactnumber" => $_POST['contactnumber'],
                "astutenumber" => $_POST['astutenumber'],
                "iProcessid" => 0,
                "elisionloginid" => $_POST['elisionloginid'],
                "Password" => $hash,
                "strsalt" => $salt,
                "iteamleadid" => $iteamleadid,
                "qualityanalistid" => $qualityanalistid,
                "asstmanagerid" => $asstmanagerid,
                "processmanager" => $processmanager,
                "centralmanagerId" => $centralmanager ?? 0,
                "trainerId" => $trainerId,
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
            foreach ($designation as $key => $value) {
                if ($value > 0) {
                    mysqli_query($dbconn, "INSERT INTO `employeedesignation`(iEmployeeId,iDesignationId,strEntryDate,strIP) VALUES ('" . $dealer_res . "','" . $value . "', '" . date('d-m-Y H:i:s') . "', '" . $_SERVER['REMOTE_ADDR'] . "' ) ");
                }
            }
            $process = $_POST['process'];
            foreach ($process as $key => $value) {
                if ($value > 0) {
                    mysqli_query($dbconn, "INSERT INTO `employeeprocess`(iEmployeeId,iProcessId,strEntryDate,strIP) VALUES ('" . $dealer_res . "','" . $value . "', '" . date('d-m-Y H:i:s') . "', '" . $_SERVER['REMOTE_ADDR'] . "' ) ");
                }
            }
            echo $statusMsg = $dealer_res ? '1' : '0';
        } else {
            echo $dealer_res = 2;
        }

    break;

    case "employeeChangePassword":

        $hash_result = create_hash($_REQUEST['password']);

        $hash_params = explode(":", $hash_result);

        $salt = $hash_params[HASH_SALT_INDEX];

        $hash = $hash_params[HASH_PBKDF2_INDEX];

        $getItems1 = mysqli_query($dbconn, "update employee SET Password = '" . $hash . "', strsalt = '" . $salt . "' where employeeid ='" . $_POST['employeeid'] . "'");

        echo "Sucess";

        break;



    /*case "Editemployee":
        
        $processmanager = 0;
        $asstmanagerid = 0;
        $iteamleadid = 0;
        $qualityanalistid = 0;

        if (isset($_POST['centralmanager']) && $_POST['centralmanager'] != '') {
            $centralmanager = $_POST['centralmanager'];
        } else {
            $centralmanager = '0';
        }
        if (isset($_POST['processmanager']) && $_POST['processmanager'] != '') {
            $processmanager = $_POST['processmanager'];
        } else {
            $processmanager = '0';
        }
        if (isset($_POST['qualityanalistid']) && $_POST['qualityanalistid'] != '') {
            $qualityanalistid = $_POST['qualityanalistid'];
        } else {
            $qualityanalistid = '0';
        }
        
        if (isset($_POST['asstmanagerid']) && $_POST['asstmanagerid'] != '') {
            $asstmanagerid = $_POST['asstmanagerid'];
            $result_AM = mysqli_fetch_array(mysqli_query($dbconn, "SELECT processmanager FROM `employee` WHERE iteamleadid=0 and employeeid=" . $asstmanagerid . " and centralmanagerId='" . $_POST['centralmanager'] . "'"));
            $processmanager = $result_AM['processmanager'];
        } else {
            $asstmanagerid = '0';
        }
        if (isset($_POST['iteamleadid']) && $_POST['iteamleadid'] != '') {
            $iteamleadid = $_POST['iteamleadid'];
            $result_TL = mysqli_fetch_array(mysqli_query($dbconn, "SELECT * FROM `employee` WHERE iteamleadid=0 and employeeid=" . $iteamleadid . " and centralmanagerId='" . $_POST['centralmanager'] . "'"));
            $processmanager = $result_TL['processmanager'];
            $asstmanagerid = $result_TL['asstmanagerid'];
        } else {
            $iteamleadid = '0';
        }
        if (isset($_POST['trainerId']) && $_POST['trainerId'] != '') {

            $trainerId = $_POST['trainerId'];
            $result_TL = mysqli_fetch_array(mysqli_query($dbconn, "SELECT * FROM `employee` WHERE iteamleadid=0 and employeeid=" . $trainerId . " "));
            $centralmanager = $result_TL['centralmanagerId'] ?? '';
            $processmanager = $result_TL['processmanager'] ?? '';
            $asstmanagerid = $result_TL['asstmanagerid'] ?? '';
        } else {

            $trainerId = '0';
        }
        
        $sql_res = mysqli_query($dbconn, "delete from employeedesignation where  iEmployeeId= " . $_REQUEST['employeeid'] . " ");
        $designation = $_POST['designation'];
        mysqli_query($dbconn, "INSERT INTO `employeedesignation`(iEmployeeId,iDesignationId,strEntryDate,strIP) VALUES ('" . $_REQUEST['employeeid'] . "','" . $designation . "', '" . date('d-m-Y H:i:s') . "', '" . $_SERVER['REMOTE_ADDR'] . "' ) ");

        $sql = mysqli_query($dbconn, "delete from employeeprocess where  iEmployeeId= " . $_REQUEST['employeeid'] . " ");

        $process = $_POST['process'];
        //$process = $_POST['process'];
        
        foreach ($process as $key => $value) {
            if ($value > 0) {
                mysqli_query($dbconn, "INSERT INTO `employeeprocess`(iEmployeeId,iProcessId,strEntryDate,strIP) VALUES ('" . $_REQUEST['employeeid'] . "','" . $value . "', '" . date('d-m-Y H:i:s') . "', '" . $_SERVER['REMOTE_ADDR'] . "' ) ");
            }
        }
        
        if ($designation != $_REQUEST['DesignationId']) {
            if ($_REQUEST['DesignationId'] == 4) {
                $TLDesignationId = mysqli_query($dbconn, "UPDATE `employee` SET `iteamleadid` = '0' WHERE `employee`.`iteamleadid` = '" . $_REQUEST['employeeid'] . "'");
            }
            if ($_REQUEST['DesignationId'] == 1) {
                $QADesignationId = mysqli_query($dbconn, "UPDATE `employee` SET `qualityanalistid` = '0' WHERE `employee`.`qualityanalistid` = '" . $_REQUEST['employeeid'] . "'");
            }
            if ($_REQUEST['DesignationId'] == 2) {
                $AMDesignationId = mysqli_query($dbconn, "UPDATE `employee` SET `asstmanagerid` = '0' WHERE `employee`.`asstmanagerid` = '" . $_REQUEST['employeeid'] . "'");
            }
            if ($_REQUEST['DesignationId'] == 3) {
                $PMDesignationId = mysqli_query($dbconn, "UPDATE `employee` SET `processmanager` = '0' WHERE `employee`.`processmanager` = '" . $_REQUEST['employeeid'] . "'");
            }
        }

        if ($designation == 6) {
            //echo "CM";
            $iteamleadid = '0';
            $qualityanalistid = '0';
            $asstmanagerid = '0';
            $processmanager = '0';
            $centralmanager = '0';
        } elseif ($designation == 3) {
            //echo "PM";
            $iteamleadid = '0';
            $qualityanalistid = '0';
            $processmanager = '0';
            $asstmanagerid = '0';
        } elseif ($designation == 2 || $designation == 7 || $designation == 10 || $designation == 11 || $designation == 8) {
            //echo "AM";
            $iteamleadid = '0';
            $qualityanalistid = '0';
            $asstmanagerid = '0';
        } elseif ($designation == 4 || $designation == 1 || $designation == 9) {
            //echo "TL";
            $iteamleadid = '0';
            $qualityanalistid = '0';
        } else {
            //echo "Agent";
            $iteamleadid;
            $qualityanalistid;
            $asstmanagerid;
            $processmanager;
            $centralmanager;
        }

        
        $data = array(
            "empname" => $_POST['employeename'],
            "dojoin" => $_POST['dojoin'],
            "contactnumber" => $_POST['contactnumber'],
            "astutenumber" => $_POST['astutenumber'],
            "iProcessid" => 0,
            "elisionloginid" => $_POST['elisionloginid'],
            "iteamleadid" => $iteamleadid,
            "qualityanalistid" => $qualityanalistid,
            "asstmanagerid" => $asstmanagerid,
            "processmanager" => $processmanager,
            "centralmanagerId" => $centralmanager,
            "trainerId" => $trainerId,
            "strEntryDate" => date('d-m-Y H:i:s'),
            "strIP" => $_SERVER['REMOTE_ADDR']
        );
        $where = ' where  employeeid=' . $_REQUEST['employeeid'];
        $dealer_res = $connect->updaterecord($dbconn, 'employee', $data, $where);
        //echo "delete from employeedesignation where  iEmployeeId= " . $_REQUEST['employeeid'] . " ";
        echo $statusMsg = $dealer_res ? '2' : '0';
        //echo 2;
        break;*/
        
    case "Editemployee":
        
        $processmanager=0;
        $asstmanagerid=0;
        $iteamleadid=0;
        // $qualityanalistid=0;
        $managerTQid = isset($_POST['managerTQid']) ? (int)$_POST['managerTQid'] : 0;
        $managerOpsid = isset($_POST['managerOpsid']) ? (int)$_POST['managerOpsid'] : 0;
        $managerHRid = isset($_POST['managerHRid']) ? (int)$_POST['managerHRid'] : 0;
        $managerITid = isset($_POST['managerITid']) ? (int)$_POST['managerITid'] : 0;
        $managerMISid = isset($_POST['managerMISid']) ? (int)$_POST['managerMISid'] : 0;
        $centralmanager = (isset($_POST['centralmanager']) && $_POST['centralmanager'] != '') ? $_POST['centralmanager'] : 0;
        $processmanager = (isset($_POST['processmanager']) && $_POST['processmanager'] != '') ? $_POST['processmanager'] : 0;
        $qualityanalistid = (isset($_POST['qualityanalistid']) && $_POST['qualityanalistid'] != '') ? $_POST['qualityanalistid'] : 0;
        // print_r($_POST);
        /*if(isset($_POST['centralmanager']) && $_POST['centralmanager'] != '')
        {
            $centralmanager = $_POST['centralmanager'];
        }else{
            $centralmanager = '0';
        }*/
        // if(isset($_POST['processmanager']) && $_POST['processmanager'] != '')
        // {
        //     $processmanager = $_POST['processmanager'];
        // }else{
        //     $processmanager = '0';
        // }
        /*if(isset($_POST['qualityanalistid']) && $_POST['qualityanalistid'] != '')
        {
            $qualityanalistid = $_POST['qualityanalistid'];
        }else{
            $qualityanalistid = '0';
        }*/
        if(isset($_POST['asstmanagerid']) && $_POST['asstmanagerid'] != '')
        {
            $asstmanagerid = $_POST['asstmanagerid'];
            $result_AM = mysqli_fetch_array(mysqli_query($dbconn,"SELECT processmanager FROM `employee` WHERE iteamleadid=0 and employeeid=".$asstmanagerid." and centralmanagerId='".$_POST['centralmanager']."'"));
            $processmanager=$result_AM['processmanager'];
        } else {
            $asstmanagerid = '0';
        }
        if(isset($_POST['iteamleadid']) && $_POST['iteamleadid'] != '')
        {
            $iteamleadid = $_POST['iteamleadid'];
            $result_TL = mysqli_fetch_array(mysqli_query($dbconn,"SELECT * FROM `employee` WHERE iteamleadid=0 and employeeid=".$iteamleadid." and centralmanagerId='".$_POST['centralmanager']."'"));
            $processmanager=$result_TL['processmanager'];
            $asstmanagerid=$result_TL['asstmanagerid'];
        }else{
            $iteamleadid = '0';
        }
        
        $sql_res = mysqli_query($dbconn, "delete from employeedesignation where  iEmployeeId= " . $_REQUEST['employeeid'] . " ");
        $designation = $_POST['designation'];
        mysqli_query($dbconn, "INSERT INTO `employeedesignation`(iEmployeeId,iDesignationId,strEntryDate,strIP) VALUES ('" . $_REQUEST['employeeid'] . "','" . $designation . "', '" . date('d-m-Y H:i:s') . "', '" . $_SERVER['REMOTE_ADDR'] . "' ) ");
        $sql = mysqli_query($dbconn, "delete from employeeprocess where  iEmployeeId= " . $_REQUEST['employeeid'] . " ");
        $process = $_POST['process'];
        //$process = $_POST['process'];
        foreach ($process as $key => $value) {
            if ($value > 0) {
                mysqli_query($dbconn, "INSERT INTO `employeeprocess`(iEmployeeId,iProcessId,strEntryDate,strIP) VALUES ('" . $_REQUEST['employeeid'] . "','" . $value . "', '" . date('d-m-Y H:i:s') . "', '" . $_SERVER['REMOTE_ADDR'] . "' ) ");
            }
        }

        if ($designation!=$_REQUEST['DesignationId']) {
            if ($_REQUEST['DesignationId']==4) {
            $TLDesignationId=mysqli_query($dbconn,"UPDATE `employee` SET `iteamleadid` = '0' WHERE `employee`.`iteamleadid` = '" . $_REQUEST['employeeid'] . "'");
            }
            if ($_REQUEST['DesignationId']==1) {
            $QADesignationId=mysqli_query($dbconn,"UPDATE `employee` SET `qualityanalistid` = '0' WHERE `employee`.`qualityanalistid` = '" . $_REQUEST['employeeid'] . "'");
            }
            if ($_REQUEST['DesignationId']==2) {
            $AMDesignationId=mysqli_query($dbconn,"UPDATE `employee` SET `asstmanagerid` = '0' WHERE `employee`.`asstmanagerid` = '" . $_REQUEST['employeeid'] . "'");
            }
            if ($_REQUEST['DesignationId']==3) {
            $PMDesignationId=mysqli_query($dbconn,"UPDATE `employee` SET `processmanager` = '0' WHERE `employee`.`processmanager` = '" . $_REQUEST['employeeid'] . "'");
            }
        }
        if(isset($_POST['trainerId']) && ($_POST['trainerId'] != '')) {
            if($_POST['trainerId'] != 0){
                $trainerId = (int)$_POST['trainerId'];
                $result_TL = mysqli_fetch_array(mysqli_query($dbconn, "SELECT * FROM `employee` WHERE iteamleadid=0 and employeeid=" . $trainerId . " "));
                $centralmanager = $result_TL['centralmanagerId'];
                $processmanager = $result_TL['processmanager'];
                $asstmanagerid = $result_TL['asstmanagerid'];
                $managerTQid = $result_TL['managerTQid'];
                $managerOpsid = $result_TL['managerOpsid'];
                $managerHRid = $result_TL['managerHRid'];
                $managerITid = $result_TL['managerITid'];
                $managerMISid = $result_TL['managerMISid'];
            }
        } else {
            $trainerId = '0';
        }
        
        
        /*if ($designation==6) {
            //echo "CM";
            $iteamleadid= '0';
            $qualityanalistid= '0';
            $asstmanagerid= '0';
            $processmanager= '0';
            $centralmanager= '0';
        }elseif ($designation==3) {
            //echo "PM";
            $iteamleadid= '0';
            $qualityanalistid= '0';
            $processmanager= '0';
            $asstmanagerid= '0';
        }elseif ($designation==2 || $designation==7 || $designation==10 || $designation==11 || $designation==8) {
            //echo "AM";
            $iteamleadid= '0';
            $qualityanalistid= '0';
            $asstmanagerid= '0';
        }elseif ($designation==4 || $designation==1 || $designation==9) {
            //echo "TL";
            $iteamleadid= '0';
            $qualityanalistid= '0';
        }else{
            //echo "Agent";
            $iteamleadid;
            $qualityanalistid;
            $asstmanagerid;
            $processmanager;
            $centralmanager;
        }*/


        $data = array(
            "empname" => $_POST['employeename'],
            "dojoin" => $_POST['dojoin'],
            "contactnumber" => $_POST['contactnumber'],
            "astutenumber" => $_POST['astutenumber'],
            "iProcessid" => 0,
            "elisionloginid" => $_POST['elisionloginid'],
            "trainerId" => $trainerId ?? 0,
            "iteamleadid" => $iteamleadid ?? 0,
            "qualityanalistid" => $qualityanalistid ?? 0,
            "asstmanagerid" => $asstmanagerid ?? 0,
            "processmanager" => $processmanager ?? 0,
            "centralmanagerId" => $centralmanager ?? 0,
            "managerTQid" => $managerTQid ?? 0,
            "managerOpsid" => $managerOpsid ?? 0,
            "managerHRid" => $managerHRid ?? 0,
            "managerITid" => $managerITid ?? 0,
            "managerMISid" => $managerMISid ?? 0,
            "strEntryDate" => date('d-m-Y H:i:s'),
            "strIP" => $_SERVER['REMOTE_ADDR']
        );
        // print_r($data);
        // exit;
        $where = ' where  employeeid='.$_REQUEST['employeeid'];
        $dealer_res = $connect->updaterecord($dbconn, 'employee', $data, $where);
        echo 2;
        //echo "delete from employeedesignation where  iEmployeeId= " . $_REQUEST['employeeid'] . " ";
        //echo $statusMsg = $dealer_res ? '2' : '0';
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

                $ValCounter = 0;

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

                                        //                                        print_r($dataCustomer);

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

            echo "Inputed Column Count and Excel Count Not Match";

            @unlink($file_path);

            exit;
        }

        break;



    case "Editdailyupdate":



        $data = array(

            "laguageid" => $_POST['languageid'],

            "message" => $_POST['message'],

            "date" => $_POST['date'],

            "designationid" => '0',

            "employeeid" => '0',

            "strEntryDate" => date('d-m-Y H:i:s'),

            "strIP" => $_SERVER['REMOTE_ADDR']

        );

        $where = ' where  dailyupdateid =' . $_REQUEST['dailyupdateid'];

        $dealer_res = $connect->updaterecord($dbconn, 'dailyupdate', $data, $where);



        echo $statusMsg = $dealer_res ? '2' : '0';

        break;



    case "AddFormType":

        $data = array(

            "formName" => $_POST['FormType'],

            "strEntryDate" => date('d-m-Y H:i:s'),

            "strIP" => $_SERVER['REMOTE_ADDR']

        );

        $dealer_res = $connect->insertrecord($dbconn, 'formtype', $data);

        echo $statusMsg = $dealer_res ? '1' : '0';

        break;



    case "GetAdminFormType":

        $filterstr = "SELECT * FROM `formtype`  where  isDelete='0'  and  istatus='1' and  formId=" . $_REQUEST['ID'] . "";

        $result = mysqli_query($dbconn, $filterstr);

        $row = mysqli_fetch_array($result);

        print_r(json_encode($row));

        break;



    case "EditFormType":



        $data = array(

            "formName" => $_POST['FormType'],

            "strEntryDate" => date('d-m-Y H:i:s'),

            "strIP" => $_SERVER['REMOTE_ADDR']

        );

        $where = ' where  formId=' . $_REQUEST['formId'];

        $dealer_res = $connect->updaterecord($dbconn, 'formtype', $data, $where);

        echo $statusMsg = $dealer_res ? '2' : '0';

        break;



    case "AddFormTypeDetail":

        $data = array(

            "formId" => $_POST['formId'],

            "excelColumnName" => trim($_POST['excelColumnName']),

            "dbColumnName" => trim($_POST['dbColumnName'])

        );

        $dealer_res = $connect->insertrecord($dbconn, 'formdetail', $data);

        echo $statusMsg = $dealer_res ? '1' : '0';

        break;



    case "GetAdminFormTypeDetail":

        $filterstr = "SELECT * FROM `formdetail`  where  formDetailId=" . $_REQUEST['ID'] . "";

        $result = mysqli_query($dbconn, $filterstr);

        $row = mysqli_fetch_array($result);

        print_r(json_encode($row));

        break;



    case "EditFormTypeDetail":



        $data = array(

            "formId" => $_POST['formId'],

            "excelColumnName" => trim($_POST['excelColumnName']),

            "dbColumnName" => trim($_POST['dbColumnName'])

        );

        $where = ' where  formDetailId=' . $_REQUEST['formDetailId'];

        $dealer_res = $connect->updaterecord($dbconn, 'formdetail', $data, $where);

        echo $statusMsg = $dealer_res ? '2' : '0';

        break;



    case "AddLanguage":



        $data = array(

            "language" => $_POST['language'],

            "strEntryDate" => date('d-m-Y H:i:s'),

            "strIP" => $_SERVER['REMOTE_ADDR']

        );

        $dealer_res = $connect->insertrecord($dbconn, 'language', $data);

        echo $statusMsg = $dealer_res ? '1' : '0';

        break;



    case "GetAdminLanguage":

        $filterstr = "SELECT * FROM `language`  where  isDelete='0'  and  istatus='1' and languageid=" . $_REQUEST['ID'] . "";

        $result = mysqli_query($dbconn, $filterstr);

        $row = mysqli_fetch_array($result);

        print_r(json_encode($row));

        break;



    case "EditLanguage":



        $data = array(

            "language" => $_POST['language'],

            "strEntryDate" => date('d-m-Y H:i:s'),

            "strIP" => $_SERVER['REMOTE_ADDR']

        );

        $where = ' where languageid=' . $_REQUEST['languageid'];

        $dealer_res = $connect->updaterecord($dbconn, 'language', $data, $where);

        echo $statusMsg = $dealer_res ? '2' : '0';

        break;





    case "AddFeedback":



        $data = array(

            "strfeedbackName" => $_POST['strFeedback'],

            "strEntryDate" => date('d-m-Y H:i:s'),

            "strIP" => $_SERVER['REMOTE_ADDR']

        );

        $dealer_res = $connect->insertrecord($dbconn, 'feedback', $data);

        echo $statusMsg = $dealer_res ? '1' : '0';

        break;



    case "GetAdminFeedback":

        $filterstr = "SELECT * FROM `feedback`  where  isDelete='0' and iFeedbackId =" . $_REQUEST['ID'] . "";

        $result = mysqli_query($dbconn, $filterstr);

        $row = mysqli_fetch_array($result);

        print_r(json_encode($row));

        break;



    case "EditFeedback":



        $data = array(

            "strfeedbackName" => $_POST['strFeedback'],

            "strEntryDate" => date('d-m-Y H:i:s'),

            "strIP" => $_SERVER['REMOTE_ADDR']

        );

        $where = ' where  iFeedbackId=' . $_REQUEST['iFeedbackId'];

        $dealer_res = $connect->updaterecord($dbconn, 'feedback', $data, $where);

        echo $statusMsg = $dealer_res ? '2' : '0';

        break;

        //    case ""
    case "AddExam":


        $data = array(

            "examTitle" => $_POST['examTitle'],

            "strEntryDate" => date('d-m-Y H:i:s'),

            "strIP" => $_SERVER['REMOTE_ADDR']

        );

        $dealer_res = $connect->insertrecord($dbconn, 'exammaster', $data);

        echo $statusMsg = $dealer_res ? '1' : '0';

        break;

    case "EditExam":

        $data = array(

            "examTitle" => $_POST['examTitle'],

            "strEntryDate" => date('d-m-Y H:i:s'),

            "strIP" => $_SERVER['REMOTE_ADDR']

        );

        $where = ' where  examId=' . $_REQUEST['examId'];

        $dealer_res = $connect->updaterecord($dbconn, 'exammaster', $data, $where);

        echo $statusMsg = $dealer_res ? '2' : '0';

        break;

    case "AddPublish":

        $data = array(
            "examDateTime" => $_POST['examDateTime'],
            "examDuration" => $_POST['examDuration'],
            "examEndDateTime" => $_POST['examEndDateTime'],
            "iPassingMarks" => $_POST['PassingMarks'],
            "strEntryDate" => date('d-m-Y H:i:s'),
            "Marks" => $_POST["TotalMarks"],
            "ispublished" => 1,
            "enterBy" => $_SESSION['AdminId'],
            "strIP" => $_SERVER['REMOTE_ADDR']

        );
        $where = ' where  examId=' . $_POST['examId'];

        $dealer_res = $connect->updaterecord($dbconn, 'exammaster', $data, $where);

        echo $statusMsg = $dealer_res ? '1' : '0';

        break;

    case "GetAdminExammaster":

        $filterstr = "SELECT * FROM `exammaster`  where  isDelete='0'  and  istatus='1' and examId =" . $_REQUEST['ID'] . "";

        $result = mysqli_query($dbconn, $filterstr);

        $row = mysqli_fetch_array($result);

        print_r(json_encode($row));

        break;



    case "Addquestion":


        $data = array(
            "examId" => $_REQUEST['examId'],
            "question" => $_POST['question'],
            "option1" => $_POST['option1'],
            "option2" => $_POST['option2'],
            "option3" => $_POST['option3'],
            "option4" => $_POST['option4'],
            "rightAnswer" => $_POST['rightAnswer'],
            "questionMarks" => $_POST['questionMarks'],

            "strEntryDate" => date('d-m-Y H:i:s'),

            "strIP" => $_SERVER['REMOTE_ADDR']

        );

        $dealer_res = $connect->insertrecord($dbconn, 'questionanswer', $data);

        echo $statusMsg = $dealer_res ? '1' : '0';

        break;

    case "GetQuestionAnswer":

        $filterstr = "SELECT * FROM `questionanswer`  where  isDelete='0'  and  istatus='1' and questionId=" . $_REQUEST['ID'] . "";

        $result = mysqli_query($dbconn, $filterstr);

        $row = mysqli_fetch_array($result);

        print_r(json_encode($row));

        break;

    case "EditQuestion":

        $data = array(
            "question" => $_POST['question'],
            "option1" => $_POST['option1'],
            "option2" => $_POST['option2'],
            "option3" => $_POST['option3'],
            "option4" => $_POST['option4'],
            "rightAnswer" => $_POST['rightAnswer'],
            "questionMarks" => $_POST['questionMarks'],
            "strEntryDate" => date('d-m-Y H:i:s'),
            "strIP" => $_SERVER['REMOTE_ADDR']
        );
        $where = ' where  questionId=' . $_REQUEST['questionId'];
        $dealer_res = $connect->updaterecord($dbconn, 'questionanswer', $data, $where);

        echo $statusMsg = $dealer_res ? '2' : '0';

        break;

    case "AddAssignExam":

        //   $materialToUse = $_POST['materialToUse'];
        $empid = $_POST['empid'];

        //echo sizeof($_POST['empid']);
        $dealer_res = 0;
        for ($iCounter = 0; $iCounter < sizeof($_POST['empid']); $iCounter++) {
            //$empid[$iCounter];

            $data = array(
                "userId" => $empid[$iCounter],
                "examId" => $_REQUEST['examId'],
                "strEntryDate" => date('d-m-Y H:i:s'),
                "strIP" => $_SERVER['REMOTE_ADDR']
            );

            $dealer_res = $connect->insertrecord($dbconn, 'examassigneduser', $data);
        }
        echo $statusMsg = $dealer_res ? '1' : '0';


        break;

    case "AddTicketCategory":



        $data = array(

            "categoryName" => $_POST['categoryName'],

            "strEntryDate" => date('d-m-Y H:i:s'),

            "strIP" => $_SERVER['REMOTE_ADDR']

        );

        $dealer_res = $connect->insertrecord($dbconn, 'ticketcategory', $data);

        echo $statusMsg = $dealer_res ? '1' : '0';

        break;


    case "GetTicketCategory":

        $filterstr = "SELECT * FROM `ticketcategory`  where  isDelete='0' and ticketCategoryId  =" . $_REQUEST['ID'] . "";

        $result = mysqli_query($dbconn, $filterstr);

        $row = mysqli_fetch_array($result);

        print_r(json_encode($row));

        break;

    case "EditTicketCategory":

        $data = array(

            "categoryName" => $_POST['categoryName'],

            "strEntryDate" => date('d-m-Y H:i:s'),

            "strIP" => $_SERVER['REMOTE_ADDR']

        );

        $where = ' where  ticketCategoryId=' . $_REQUEST['ticketCategoryId'];

        $dealer_res = $connect->updaterecord($dbconn, 'ticketcategory', $data, $where);

        echo $statusMsg = $dealer_res ? '2' : '0';

        break;

    case "Addsolution":

        $data = array(

            "solution" => $_POST["solution"],
            "ticketStatus" => 1,
            "closeDate" => date('d-m-Y H:i:s'),

            "strIP" => $_SERVER['REMOTE_ADDR']

        );
        $where = ' where  complainId=' . $_POST['complainId'];

        $dealer_res = $connect->updaterecord($dbconn, ' complainticket', $data, $where);

        echo $statusMsg = $dealer_res ? '1' : '0';
        break;

    case "BulkAssignExcel":


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

                            $sql = mysqli_query($dbconn, "SELECT e.employeeid,eau.examId,eau.userId FROM `employee` as e inner join employeedesignation ed on e.employeeid=ed.iEmployeeId left join examassigneduser as eau on e.employeeid=eau.userId where ed.iDesignationId in (5,4,1,9,12,18) and e.isDelete=0 and e.elisionloginid=" . $slice[0] . "");

                            if (mysqli_num_rows($sql) > 0) {
                                $row = mysqli_fetch_array($sql);
                                if ($row["examId"] != "") {

                                    $ExamAssgin = mysqli_query($dbconn, "SELECT * from examassigneduser where userId='" . $row['employeeid'] . "' and examId='" . $_REQUEST['examId'] . "'");
                                    if (mysqli_num_rows($ExamAssgin) > 0) {
                                    } else {
                                        $userData = array(
                                            "userId" => $row['employeeid'],
                                            "examId" => $_REQUEST['examId'],
                                            "strEntryDate" => date('d-m-Y H:i:s'),
                                            "strIP" => $_SERVER['REMOTE_ADDR']
                                        );

                                        $insert = $connect->insertrecord($dbconn, 'examassigneduser', $userData);
                                    }
                                } else {
                                    $userData = array(
                                        "userId" => $row['employeeid'],
                                        "examId" => $_REQUEST['examId'],
                                        "strEntryDate" => date('d-m-Y H:i:s'),
                                        "strIP" => $_SERVER['REMOTE_ADDR']
                                    );

                                    $insert = $connect->insertrecord($dbconn, 'examassigneduser', $userData);
                                }
                            }
                        }
                    }

                    $ValCounter++;
                }
            }
        }

        @unlink($file_path);

        echo $statusMsg = $insert ? '1' : '0';

        break;

    case "AddCategoryFeedback":



        $data = array(

            "categoryName" => $_POST['categoryName'],

            "strEntryDate" => date('d-m-Y H:i:s'),

            "strIP" => $_SERVER['REMOTE_ADDR']

        );

        $dealer_res = $connect->insertrecord($dbconn, 'feedbackcategory', $data);

        echo $statusMsg = $dealer_res ? '1' : '0';

        break;


    case "GetCategoryFeedback":

        $filterstr = "SELECT * FROM `feedbackcategory`  where  isDelete='0' and feedbackCategoryId  =" . $_REQUEST['ID'] . "";

        $result = mysqli_query($dbconn, $filterstr);

        $row = mysqli_fetch_array($result);

        print_r(json_encode($row));

        break;

    case "EditCategoryFeedback":

        $data = array(

            "categoryName" => $_POST['categoryName'],

            "strEntryDate" => date('d-m-Y H:i:s'),

            "strIP" => $_SERVER['REMOTE_ADDR']

        );

        $where = ' where  feedbackCategoryId=' . $_REQUEST['feedbackCategoryId'];

        $dealer_res = $connect->updaterecord($dbconn, 'feedbackcategory', $data, $where);

        echo $statusMsg = $dealer_res ? '2' : '0';

        break;

    case "AddOnlineFeedback":
        // $employeeid=$_POST['employeeid'];
        // $chk="";
        // foreach ($employeeid as $chk1) {
        // $chk .=$chk1.",";
        // }

        $sql = mysqli_fetch_array(mysqli_query($dbconn, "SELECT iteamleadid from employee WHERE employeeid='" . $_POST['employeeid'] . "'"));

        $data = array(

            "feedbackCategoryId" => $_POST['feedbackCategoryId'],

            //"agentId" =>$chk,

            "agentId" => $_POST['employeeid'],
            "tLId" => $sql['iteamleadid'],
            "comment" => $_POST['comment'],
            "status" => 1,
            "statusDate" => date('d-m-Y H:i:s'),
            "complainby" => $_SESSION['AdminId'],
            "statusby" => $_SESSION['AdminId'],
            "strEntryDate" => date('d-m-Y H:i:s'),
            "strIP" => $_SERVER['REMOTE_ADDR']

        );

        $dealer_res = $connect->insertrecord($dbconn, 'onlinefeedback', $data);

        $historydata = array(
            "feedbackId" => $dealer_res,
            "historyComment" => $_POST['comment'],
            "status" => 1,
            "statusby" => $_SESSION['AdminId'],
            "strEntryDate" => date('d-m-Y H:i:s'),
            "strIP" => $_SERVER['REMOTE_ADDR']
        );
        $dealer_res2 = $connect->insertrecord($dbconn, 'historyfeedback', $historydata);

        echo $statusMsg = $dealer_res ? '1' : '0';

        break;

    case "getcentralmanager":


        $resCM = mysqli_query($dbconn, "select * from employee where centralmanagerId=" . $_REQUEST['ID'] . " and processmanager=0 and isDelete=0 and istatus=1");
        $data = '';

        if (mysqli_num_rows($resCM) > 0) {
            $data .= "<option value='' >Select Process Manager</option>\n";

            while ($result_PM =  mysqli_fetch_array($resCM)) {

                $data .= "<option value='" . $result_PM['employeeid'] . "'>" . $result_PM['empname'] . "</option>";
            }
        }
        echo $data;

        break;

    case "getasstmanager":

        $resAM = mysqli_query($dbconn, "select * from `employee` INNER JOIN employeedesignation on employee.employeeid=employeedesignation.iEmployeeId  where employee.centralmanagerId=" . $_REQUEST['ID'] . " and employeedesignation.iDesignationId=2 and employee.isDelete=0 and employee.istatus=1");
        $data = '';

        if (mysqli_num_rows($resAM) > 0) {
            $data .= "<option value='' >Select AsstManager </option>\n";

            while ($result_AM =  mysqli_fetch_array($resAM)) {

                $data .= "<option value='" . $result_AM['employeeid'] . "'>" . $result_AM['empname'] . "</option>";
            }
        }
        echo $data;

        break;

    case "getteamlead":

        //echo $_REQUEST['ID'];

        $resTL = mysqli_query($dbconn, "SELECT * FROM `employee` INNER JOIN employeedesignation on employee.employeeid=employeedesignation.iEmployeeId WHERE employee.centralmanagerId=" . $_REQUEST['ID'] . " and employeedesignation.iDesignationId=4 and employee.isDelete=0 and employee.istatus=1");
        $data = '';

        if (mysqli_num_rows($resTL) > 0) {
            $data .= "<option value='' >Select Team leader </option>\n";

            while ($result_TL =  mysqli_fetch_array($resTL)) {

                $data .= "<option value='" . $result_TL['employeeid'] . "'>" . $result_TL['empname'] . "</option>";
            }
        }
        echo $data;

        break;

    case "getqualityanalist":

        //echo $_REQUEST['ID'];

        $resTL = mysqli_query($dbconn, "SELECT * FROM `employee` INNER JOIN employeedesignation on employee.employeeid=employeedesignation.iEmployeeId WHERE employee.centralmanagerId=" . $_REQUEST['ID'] . " and employeedesignation.iDesignationId=1 and employee.isDelete=0 and employee.istatus=1");
        $data = '';

        if (mysqli_num_rows($resTL) > 0) {
            $data .= "<option value='' >Select Quality Analist </option>\n";

            while ($result_TL =  mysqli_fetch_array($resTL)) {

                $data .= "<option value='" . $result_TL['employeeid'] . "'>" . $result_TL['empname'] . "</option>";
            }
        }
        echo $data;

        break;

    case "geteditcentralmanager":


        $resCM = mysqli_query($dbconn, "select * from employee where centralmanagerId=" . $_REQUEST['ID'] . " and processmanager=0 and isDelete=0 and istatus=1");
        $data = '';

        if (mysqli_num_rows($resCM) > 0) {
            $data .= "<option value='' >Select Process Manager</option>\n";

            while ($result_PM =  mysqli_fetch_array($resCM)) {

                $data .= "<option value='" . $result_PM['employeeid'] . "'>" . $result_PM['empname'] . "</option>";
            }
        }
        echo $data;

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
    
    case "getManagerTQ":
        $resTQ = mysqli_query($dbconn, "SELECT * FROM `employee` INNER JOIN employeedesignation on employee.employeeid=employeedesignation.iEmployeeId 
                WHERE employee.centralmanagerId=".$_REQUEST['ID']." and employeedesignation.iDesignationId=13 and employee.isDelete=0 and employee.istatus=1");
        $data = '';
        if (mysqli_num_rows($resTQ) > 0) {
            $data .= "<option value='' >Select Manager T&Q</option>\n";
            while ($result_PM =  mysqli_fetch_array($resTQ)) {
                $data .= "<option value='" . $result_PM['employeeid'] . "'>" . $result_PM['empname'] . "</option>";
            }
        }
        echo $data;
        break;
    
    case "getManagerOps":
        $resCM = mysqli_query($dbconn, "SELECT * FROM `employee` INNER JOIN employeedesignation on employee.employeeid=employeedesignation.iEmployeeId 
                WHERE employee.centralmanagerId=".$_REQUEST['ID']." and employeedesignation.iDesignationId=14 and employee.isDelete=0 and employee.istatus=1");
        $data = '';
        if (mysqli_num_rows($resCM) > 0) {
            $data .= "<option value='' >Select Manager Ops</option>\n";
            while ($result_PM =  mysqli_fetch_array($resCM)) {
                $data .= "<option value='" . $result_PM['employeeid'] . "'>" . $result_PM['empname'] . "</option>";
            }
        }
        echo $data;
        break;
        
    case "getManagerHR":
        $resCM = mysqli_query($dbconn, "SELECT * FROM `employee` INNER JOIN employeedesignation on employee.employeeid=employeedesignation.iEmployeeId 
                WHERE employee.centralmanagerId=".$_REQUEST['ID']." and employeedesignation.iDesignationId=15 and employee.isDelete=0 and employee.istatus=1");
        $data = '';
        if (mysqli_num_rows($resCM) > 0) {
            $data .= "<option value='' >Select Manager HR</option>\n";
            while ($result_PM =  mysqli_fetch_array($resCM)) {
                $data .= "<option value='" . $result_PM['employeeid'] . "'>" . $result_PM['empname'] . "</option>";
            }
        }
        echo $data;
        break;
     
    case "getManagerIT":
        $resCM = mysqli_query($dbconn, "SELECT * FROM `employee` INNER JOIN employeedesignation on employee.employeeid=employeedesignation.iEmployeeId 
                WHERE employee.centralmanagerId=".$_REQUEST['ID']." and employeedesignation.iDesignationId=16 and employee.isDelete=0 and employee.istatus=1");
        $data = '';
        if (mysqli_num_rows($resCM) > 0) {
            $data .= "<option value='' >Select Manager IT</option>\n";
            while ($result_PM =  mysqli_fetch_array($resCM)) {
                $data .= "<option value='" . $result_PM['employeeid'] . "'>" . $result_PM['empname'] . "</option>";
            }
        }
        echo $data;
        break;
        
    case "getManagerMIS":
        $resCM = mysqli_query($dbconn, "SELECT * FROM `employee` INNER JOIN employeedesignation on employee.employeeid=employeedesignation.iEmployeeId 
                WHERE employee.centralmanagerId=".$_REQUEST['ID']." and employeedesignation.iDesignationId=17 and employee.isDelete=0 and employee.istatus=1");
        $data = '';
        if (mysqli_num_rows($resCM) > 0) {
            $data .= "<option value='' >Select Manager WFM/MIS</option>\n";
            while ($result_PM =  mysqli_fetch_array($resCM)) {
                $data .= "<option value='" . $result_PM['employeeid'] . "'>" . $result_PM['empname'] . "</option>";
            }
        }
        echo $data;
        break;
        
    
    
    case "getEditManagerTQ":
        $resTQ = mysqli_query($dbconn, "SELECT * FROM `employee` INNER JOIN employeedesignation on employee.employeeid=employeedesignation.iEmployeeId 
                WHERE employee.centralmanagerId=".$_REQUEST['ID']." and employeedesignation.iDesignationId=13 and employee.isDelete=0 and employee.istatus=1");
        $data = '';
        if (mysqli_num_rows($resTQ) > 0) {
            $data .= "<option value='' >Select Manager T&Q</option>\n";
            while ($result_PM =  mysqli_fetch_array($resTQ)) {
                if($result_PM['employeeid'] == $_REQUEST['TQId']){
                    $data .= "<option value='" . $result_PM['employeeid'] . "' selected>" . $result_PM['empname'] . "</option>";
                } else {
                    $data .= "<option value='" . $result_PM['employeeid'] . "'>" . $result_PM['empname'] . "</option>";
                }
            }
        }
        echo $data;
        break;
    
    case "getEditManagerOps":
        $resCM = mysqli_query($dbconn, "SELECT * FROM `employee` INNER JOIN employeedesignation on employee.employeeid=employeedesignation.iEmployeeId 
                WHERE employee.centralmanagerId=".$_REQUEST['ID']." and employeedesignation.iDesignationId=14 and employee.isDelete=0 and employee.istatus=1");
        $data = '';
        if (mysqli_num_rows($resCM) > 0) {
            $data .= "<option value='' >Select Manager Ops</option>\n";
            while ($result_PM =  mysqli_fetch_array($resCM)) {
                if($result_PM['employeeid'] == $_REQUEST['Opsid']){
                    $data .= "<option value='" . $result_PM['employeeid'] . "' selected>" . $result_PM['empname'] . "</option>";
                } else {
                    $data .= "<option value='" . $result_PM['employeeid'] . "'>" . $result_PM['empname'] . "</option>";
                }
            }
        }
        echo $data;
        break;
        
    case "getEditManagerHR":
        $resCM = mysqli_query($dbconn, "SELECT * FROM `employee` INNER JOIN employeedesignation on employee.employeeid=employeedesignation.iEmployeeId 
                WHERE employee.centralmanagerId=".$_REQUEST['ID']." and employeedesignation.iDesignationId=15 and employee.isDelete=0 and employee.istatus=1");
        $data = '';
        if (mysqli_num_rows($resCM) > 0) {
            $data .= "<option value='' >Select Manager HR</option>\n";
            while ($result_PM =  mysqli_fetch_array($resCM)) {
                if($result_PM['employeeid'] == $_REQUEST['HRid']){
                    $data .= "<option value='" . $result_PM['employeeid'] . "' selected>" . $result_PM['empname'] . "</option>";
                } else {
                    $data .= "<option value='" . $result_PM['employeeid'] . "'>" . $result_PM['empname'] . "</option>";
                }
            }
        }
        echo $data;
        break;
     
    case "getEditManagerIT":
        $resCM = mysqli_query($dbconn, "SELECT * FROM `employee` INNER JOIN employeedesignation on employee.employeeid=employeedesignation.iEmployeeId 
                WHERE employee.centralmanagerId=".$_REQUEST['ID']." and employeedesignation.iDesignationId=16 and employee.isDelete=0 and employee.istatus=1");
        $data = '';
        if (mysqli_num_rows($resCM) > 0) {
            $data .= "<option value='' >Select Manager IT</option>\n";
            while ($result_PM =  mysqli_fetch_array($resCM)) {
                if($result_PM['employeeid'] == $_REQUEST['ITId']){
                    $data .= "<option value='" . $result_PM['employeeid'] . "' selected>" . $result_PM['empname'] . "</option>";
                } else {
                    $data .= "<option value='" . $result_PM['employeeid'] . "'>" . $result_PM['empname'] . "</option>";
                }
            }
        }
        echo $data;
        break;
        
    case "getEditManagerMIS":
        $resCM = mysqli_query($dbconn, "SELECT * FROM `employee` INNER JOIN employeedesignation on employee.employeeid=employeedesignation.iEmployeeId 
                WHERE employee.centralmanagerId=".$_REQUEST['ID']." and employeedesignation.iDesignationId=17 and employee.isDelete=0 and employee.istatus=1");
        $data = '';
        if (mysqli_num_rows($resCM) > 0) {
            $data .= "<option value='' >Select Manager WFM/MIS</option>\n";
            while ($result_PM =  mysqli_fetch_array($resCM)) {
                if($result_PM['employeeid'] == $_REQUEST['MISId']){
                    $data .= "<option value='" . $result_PM['employeeid'] . "' selected>" . $result_PM['empname'] . "</option>";
                } else {
                    $data .= "<option value='" . $result_PM['employeeid'] . "'>" . $result_PM['empname'] . "</option>";
                }
            }
        }
        echo $data;
        break;
    
    
    default:


        echo "Page not Found";

        break;
}
