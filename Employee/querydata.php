<?php
ob_start();
error_reporting(0);
include('../common.php');
$connect = new connect();
include 'IsLogin.php';
include '../password_hash.php';
require('../spreadsheet-reader-master/SpreadsheetReader.php');
require_once '../spreadsheet-reader-master/php-excel-reader/excel_reader2.php';


$action = $_REQUEST['action'];
switch ($action) {
    case "UserProfileChangePassword":
        $hash_result = create_hash($_POST['oldpassword']);
        $hash_params = explode(":", $hash_result);
        $salt = $hash_params[HASH_SALT_INDEX];
        $hash = $hash_params[HASH_PBKDF2_INDEX];
        $existsmail = "SELECT * FROM employee where employeeid='" . $_SESSION['EmployeeId'] . "'";
        $result = mysqli_query($dbconn, $existsmail);
        $num_rows = mysqli_num_rows($result);
        $row = mysqli_fetch_array($result);
        if ($num_rows >= 1) {
            $good_hash = PBKDF2_HASH_ALGORITHM . ":" . PBKDF2_ITERATIONS . ":" . $row['strsalt'] . ":" . $row['Password'];
            $oldpassword = mysqli_real_escape_string($dbconn, $_REQUEST['oldpassword']);
            if (validate_password($_REQUEST['oldpassword'], $good_hash)) {
                $hash_result = create_hash($_REQUEST['password']);
                $hash_params = explode(":", $hash_result);
                $salt = $hash_params[HASH_SALT_INDEX];
                $hash = $hash_params[HASH_PBKDF2_INDEX];
                $getItems1 = mysqli_query($dbconn, "update employee SET Password = '" . $hash . "', strsalt = '" . $salt . "' where employeeid='" . $_SESSION['EmployeeId'] . "'");
                echo "Sucess";
            } else {
                echo "OldNot";
            }
        } else {
            echo "ID not found";
        }
        break;

    case "AddApplicationFollowUp":
        if (isset($_POST['disposition_name'])) {
            $disposition_name = $_POST['disposition_name'];
        } else {
            $disposition_name = '0';
        }
        if (isset($_POST['sub_disposition']) && $_POST['sub_disposition'] != '') {
            $sub_disposition = $_POST['sub_disposition'];
        } else {
            $sub_disposition = '0';
        }

        if (isset($_POST['Date']) && $_POST['Date'] != '') {
            $followupDate = $_POST['Date'];
        } else {
            $followupDate = "";
        }

        $data = array(
            "iAppId" => $_POST['iAppId'],
            "applicatipnNo" => $_POST['applicatipnNo'],
            "iEmpId" => $_SESSION['EmployeeId'],
            "dispoType" => $_POST['callStatus'],
            "mainDispoId" => $disposition_name,
            "subDispoId" => $sub_disposition,
            "followupDate" => $_POST['Date'],
            "PTPDate" => $_POST['PTPDate'],
            "PTP_Amount" => isset($_POST['PTP_Amount']) && $_POST['PTP_Amount'] != "" ? $_POST['PTP_Amount'] : 0,
            "remark" => $_POST['comment'],
            "strEntryDate" => date('d-m-Y H:i:s'),
            "strIP" => $_SERVER['REMOTE_ADDR']
        );
        
        $deal_res = $connect->insertrecord($dbconn, 'applicationfollowup', $data);
        $AppData = array(
            "iAppLogId" => $deal_res,
            "isFollowDone" => 1
        );
        $where = "Where iAppId=" . $_POST['iAppId'];
        $deal = $connect->updaterecord($dbconn, 'application', $AppData, $where);
        $status = $deal_res ? '1' : '0';
        echo $status;
        break;

    case "AddFeedBack":
        $filterfeedbackCheck = mysqli_query($dbconn, "select * from customerfeedback where applicatipnNo = '" . $_POST['applicatipnNo'] . "' ");
        $data = array(
            "applicatipnNo" => $_POST['applicatipnNo'],
            "iFeedbackId" => $_POST['Feedback'],
            "iAppId" => $_POST['iAppId'],
            "enterBy" => $_SESSION['EmployeeId'],
            "elisionloginid" => $_SESSION['elisionloginid'],
            "strEntryDate" => date('d-m-Y'),
            "strIP" => $_SERVER['REMOTE_ADDR']
        );
        if (mysqli_num_rows($filterfeedbackCheck) == 1) {
            $where = "Where applicatipnNo = '" . $_POST['applicatipnNo'] . "'";
            $deal_res = $connect->updaterecord($dbconn, "customerfeedback", $data, $where);
        } else {
            $deal_res = $connect->insertrecord($dbconn, "customerfeedback", $data);
        }

        $status = $deal_res ? '1' : '0';
        echo $status;
        break;

    case "Addcomplain":
        $data = array(
            "ticketCategoryId" => $_POST['ticketCategoryId'],
            "floorAsset" => $_POST['floorAsset'],
            "complainText" => $_POST['complainText'],
            "complainBy" => $_SESSION['EmployeeId'],
            "complainDate" => date('d-m-Y H:i:s'),
            // "ticketId"=>
            "strEntryDate" => date('d-m-Y H:i:s'),
            "strIP" => $_SERVER['REMOTE_ADDR']
        );
        $dealer_res = $connect->insertrecord($dbconn, 'complainticket', $data);
        $ticketId = "TC-" . $dealer_res . "-" . date('dmy');
        $data1 = array(
            "ticketId" => $ticketId,
        );
        $where = ' where  complainId =' . $dealer_res;
        $dealer = $connect->updaterecord($dbconn, 'complainticket', $data1, $where);
        echo $statusMsg = $dealer_res ? '1' : '0';
        break;

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
        //print_r($data);exit;
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
        $empid = $_REQUEST['empid'];
        $dealer_res = 0;
        for ($iCounter = 0; $iCounter < sizeof($_REQUEST['empid']); $iCounter++) {
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
                            $sql = mysqli_query($dbconn, "SELECT e.employeeid,eau.examId,eau.userId FROM `employee` as e inner join employeedesignation ed on e.employeeid=ed.iEmployeeId left join examassigneduser as eau on e.employeeid=eau.userId where ed.iDesignationId in (5,4,1,9,12,18) and centralmanagerId='" . $_SESSION['EmployeeId'] . "' and e.isDelete=0 and e.elisionloginid=" . $slice[0] . "");
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
        $iteamleadid = 0;
        $asstmanagerid = 0;
        $processmanager = 0;
        $dealer_res = 0;
        if ($_SESSION['Designation'] == 6) {
            $sql = mysqli_fetch_array(mysqli_query($dbconn, "SELECT * from employee WHERE employeeid='" . $_POST['employeeid'] . "'"));
            $iteamleadid = $sql['iteamleadid'];
            $asstmanagerid = $sql['asstmanagerid'];
            $processmanager = $sql['processmanager'];
            $data = array(
                "feedbackCategoryId" => $_POST['feedbackCategoryId'],
                "agentId" => $_POST['employeeid'],
                "tLId" => $iteamleadid,
                "AMId" => $asstmanagerid,
                "PMId" => $processmanager,
                "comment" => $_POST['comment'],
                "status" => 1,
                "statusDate" => date('d-m-Y H:i:s'),
                "complainby" => $_SESSION['EmployeeId'],
                "statusby" => $_SESSION['EmployeeId'],
                "strEntryDate" => date('d-m-Y H:i:s'),
                "strIP" => $_SERVER['REMOTE_ADDR']
            );
            $dealer_res = $connect->insertrecord($dbconn, 'onlinefeedback', $data);
            $historydata = array(
                "feedbackId" => $dealer_res,
                "historyComment" => $_POST['comment'],
                "status" => 1,
                "statusby" => $_SESSION['EmployeeId'],
                "strEntryDate" => date('d-m-Y H:i:s'),
                "strIP" => $_SERVER['REMOTE_ADDR']
            );
            $dealer_res2 = $connect->insertrecord($dbconn, 'historyfeedback', $historydata);
        } elseif ($_SESSION['Designation'] == 3) {
            $sql = mysqli_fetch_array(mysqli_query($dbconn, "SELECT * from employee WHERE employeeid='" . $_POST['employeeid'] . "'"));
            $iteamleadid = $sql['iteamleadid'];
            $asstmanagerid = $sql['asstmanagerid'];
            $data = array(
                "feedbackCategoryId" => $_POST['feedbackCategoryId'],
                "agentId" => $_POST['employeeid'],
                "tLId" => $iteamleadid,
                "AMId" => $asstmanagerid,
                "PMId" => $processmanager,
                "comment" => $_POST['comment'],
                "status" => 1,
                "statusDate" => date('d-m-Y H:i:s'),
                "complainby" => $_SESSION['EmployeeId'],
                "statusby" => $_SESSION['EmployeeId'],
                "strEntryDate" => date('d-m-Y H:i:s'),
                "strIP" => $_SERVER['REMOTE_ADDR']
            );
            $dealer_res = $connect->insertrecord($dbconn, 'onlinefeedback', $data);
            $historydata = array(
                "feedbackId" => $dealer_res,
                "historyComment" => $_POST['comment'],
                "status" => 1,
                "statusby" => $_SESSION['EmployeeId'],
                "strEntryDate" => date('d-m-Y H:i:s'),
                "strIP" => $_SERVER['REMOTE_ADDR']
            );
            $dealer_res2 = $connect->insertrecord($dbconn, 'historyfeedback', $historydata);
        } elseif ($_SESSION['Designation'] == 2 || $_SESSION['Designation'] == 7) {
            $sql = mysqli_fetch_array(mysqli_query($dbconn, "SELECT * from employee WHERE employeeid='" . $_POST['employeeid'] . "'"));
            $iteamleadid = $sql['iteamleadid'];

            $data = array(
                "feedbackCategoryId" => $_POST['feedbackCategoryId'],
                "agentId" => $_POST['employeeid'],
                "tLId" => $iteamleadid,
                "AMId" => $asstmanagerid,
                "PMId" => $processmanager,
                "comment" => $_POST['comment'],
                "status" => 1,
                "statusDate" => date('d-m-Y H:i:s'),
                "complainby" => $_SESSION['EmployeeId'],
                "statusby" => $_SESSION['EmployeeId'],
                "strEntryDate" => date('d-m-Y H:i:s'),
                "strIP" => $_SERVER['REMOTE_ADDR']
            );

            $dealer_res = $connect->insertrecord($dbconn, 'onlinefeedback', $data);

            $historydata = array(
                "feedbackId" => $dealer_res,
                "historyComment" => $_POST['comment'],
                "status" => 1,
                "statusby" => $_SESSION['EmployeeId'],
                "strEntryDate" => date('d-m-Y H:i:s'),
                "strIP" => $_SERVER['REMOTE_ADDR']
            );
            $dealer_res2 = $connect->insertrecord($dbconn, 'historyfeedback', $historydata);
        } elseif ($_SESSION['Designation'] == 1 || $_SESSION['Designation'] == 9) {
            $sql = mysqli_fetch_array(mysqli_query($dbconn, "SELECT * from employee WHERE employeeid='" . $_POST['employeeid'] . "'"));
            $iteamleadid = $sql['iteamleadid'];

            $data = array(
                "feedbackCategoryId" => $_POST['feedbackCategoryId'],
                "agentId" => $_POST['employeeid'],
                "tLId" => $iteamleadid,
                "AMId" => $asstmanagerid,
                "PMId" => $processmanager,
                "comment" => $_POST['comment'],
                "status" => 1,
                "statusDate" => date('d-m-Y H:i:s'),
                "complainby" => $_SESSION['EmployeeId'],
                "statusby" => $_SESSION['EmployeeId'],
                "strEntryDate" => date('d-m-Y H:i:s'),
                "strIP" => $_SERVER['REMOTE_ADDR']
            );

            $dealer_res = $connect->insertrecord($dbconn, 'onlinefeedback', $data);

            $historydata = array(
                "feedbackId" => $dealer_res,
                "historyComment" => $_POST['comment'],
                "status" => 1,
                "statusby" => $_SESSION['EmployeeId'],
                "strEntryDate" => date('d-m-Y H:i:s'),
                "strIP" => $_SERVER['REMOTE_ADDR']
            );
            $dealer_res2 = $connect->insertrecord($dbconn, 'historyfeedback', $historydata);
        } else {
            
            $data = array(
                "feedbackCategoryId" => $_POST['feedbackCategoryId'],
                "agentId" => $_POST['employeeid'],
                "tLId" => $iteamleadid,
                "AMId" => $asstmanagerid,
                "PMId" => $processmanager,
                "comment" => $_POST['comment'],
                "status" => 1,
                "statusDate" => date('d-m-Y H:i:s'),
                "complainby" => $_SESSION['EmployeeId'],
                "statusby" => $_SESSION['EmployeeId'],
                "strEntryDate" => date('d-m-Y H:i:s'),
                "strIP" => $_SERVER['REMOTE_ADDR']
            );
            $dealer_res = $connect->insertrecord($dbconn, 'onlinefeedback', $data);

            $historydata = array(
                "feedbackId" => $dealer_res,
                "historyComment" => $_POST['comment'],
                "status" => 1,
                "statusby" => $_SESSION['EmployeeId'],
                "strEntryDate" => date('d-m-Y H:i:s'),
                "strIP" => $_SERVER['REMOTE_ADDR']
            );
            $dealer_res2 = $connect->insertrecord($dbconn, 'historyfeedback', $historydata);
        }
        echo $statusMsg = $dealer_res ? '1' : '0';

        break;

    case "Respond":

        $data = array(
            "feedbackId" => $_POST['feedbackId'],
            "historyComment" => $_POST["comment"],
            "status" => 2,
            "statusby" => $_SESSION['EmployeeId'],
            "strEntryDate" => date('d-m-Y H:i:s'),
            "strIP" => $_SERVER['REMOTE_ADDR']

        );
        $dealer_res = $connect->insertrecord($dbconn, 'historyfeedback', $data);

        $dataFeedback = array(
            "status" => 2,
            "statusby" => $_SESSION['EmployeeId'],
            "statusDate" => date('d-m-Y H:i:s'),

            "strIP" => $_SERVER['REMOTE_ADDR']
        );
        $where = ' where  feedbackId=' . $_POST['feedbackId'];

        $dealer_res2 = $connect->updaterecord($dbconn, 'onlinefeedback', $dataFeedback, $where);

        echo $statusMsg = $dealer_res ? '1' : '0';
        break;

    case "Dispute":

        $data = array(
            "feedbackId" => $_POST['feedbackId'],
            "historyComment" => $_POST["comment"],
            "status" => 2,
            "statusby" => $_SESSION['EmployeeId'],
            "strEntryDate" => date('d-m-Y H:i:s'),
            "strIP" => $_SERVER['REMOTE_ADDR']

        );
        $dealer_res = $connect->insertrecord($dbconn, 'historyfeedback', $data);

        $dataFeedback = array(
            "status" => 2,
            "statusby" => $_SESSION['EmployeeId'],
            "statusDate" => date('d-m-Y H:i:s'),

            "strIP" => $_SERVER['REMOTE_ADDR']
        );
        $where = ' where  feedbackId=' . $_POST['feedbackId'];

        $dealer_res2 = $connect->updaterecord($dbconn, 'onlinefeedback', $dataFeedback, $where);

        echo $statusMsg = $dealer_res ? '1' : '0';
        break;

    case "BulkFeedbackExcel":
        $Date = 0;
        $errorString = "";
        $iColumnCounter = array();
        $ValCounter = 0;
        $Login = 0;
        $RowCounter = 0;
        $jCounterArray = 0;
        $LoginTime = 0;
        $iteamleadid = 0;
        $asstmanagerid = 0;
        $processmanager = 0;

        $where = '1=1';
        if ($_SESSION['Designation'] == 6) {
            $where .= " and ed.iDesignationId not in (6,8) and centralmanagerId='" . $_SESSION['EmployeeId'] . "' ";
        } else if ($_SESSION['Designation'] == 3) {
            $where .=
                " and ed.iDesignationId not in (3,6,8) and centralmanagerId='" . $_SESSION['CentralManagerID'] . "' ";
        } else if ($_SESSION['Designation'] == 2) {
            $where .= " and ed.iDesignationId not in (3,6,2,7,8,11,10) and centralmanagerId='" . $_SESSION['CentralManagerID'] . "' ";
        } else if ($_SESSION['Designation'] == 7) {
            $where .= " and ed.iDesignationId not in (3,6,2,7,8,11,10)and centralmanagerId='" . $_SESSION['CentralManagerID'] . "' ";
        } else if ($_SESSION['Designation'] == 4) {
            $where .= " and ed.iDesignationId not in (3,6,2,7,1,4,8,11,10,9)and centralmanagerId='" . $_SESSION['CentralManagerID'] . "' ";
        } else if ($_SESSION['Designation'] == 1) {
            $where .= " and ed.iDesignationId not in (3,6,2,4,7,1,8,11,10,9)and centralmanagerId='" . $_SESSION['CentralManagerID'] . "' ";
        } else if ($_SESSION['Designation'] == 9) {
            $where .= " and ed.iDesignationId not in (3,6,2,4,7,1,8,11,10,9)and centralmanagerId='" . $_SESSION['CentralManagerID'] . "' ";
        }

        if (isset($_REQUEST['IMgallery'])) {

            $headerArray = array();

            $filename = trim($_REQUEST['IMgallery']);

            $file_path = 'temp/' . $filename;

            $Reader = new SpreadsheetReader($file_path);

            $Sheets = $Reader->Sheets();

            foreach ($Sheets as $Index => $Name) {

                $Reader->ChangeSheet($Index);

                $icount = 1;

                $ValCounter = 1;

                foreach ($Reader as $key => $slice) {
                    if ($ValCounter > 1) {
                        $RowCounter = $ValCounter;

                        if ($key != 0) {
                            $strerror = "";
                            if ($_SESSION['Designation'] == 6) { //Central Manager
                                $CM = mysqli_fetch_array(mysqli_query($dbconn, "SELECT * from employee WHERE elisionloginid=" . $slice[0] . ""));

                                $FC = mysqli_fetch_array(mysqli_query($dbconn, "SELECT *,count(*) as catValue FROM `feedbackcategory` WHERE isDelete=0 and categoryName='" . $slice[1] . "' "));


                                if ($FC['catValue'] != 1) {
                                    $strerror .= "Row " . $RowCounter . "->  Feedback Category " . $slice[1] . " is Not Match. <br/>";
                                }
                                $sql = mysqli_fetch_array(mysqli_query($dbconn, "SELECT * FROM `employee` e INNER join employeedesignation ed on e.employeeid=ed.iEmployeeId where " . $where . "  and e.isDelete=0 and e.istatus=1 and elisionloginid=" . $slice[0] . " ORDER BY empname ASC "));
                                "SELECT * FROM `employee` e INNER join employeedesignation ed on e.employeeid=ed.iEmployeeId where " . $where . "  and e.isDelete=0 and e.istatus=1 and elisionloginid=" . $slice[0] . " ORDER BY empname ASC ";
                                if ($cm['centralmanagerId'] == $sql['centralmanagerId']) {
                                    if ($sql['iDesignationId'] == 6 || $sql['iDesignationId'] == "") {
                                        if ($CM['employeeid'] == "") {
                                            $strerror .= "Row " . $RowCounter . "->  Elisionloginid " . $slice[0] . " is Not Match. <br/>";
                                        }
                                        $strerror .= "Row " . $RowCounter . "->" . $slice[0] . " Employee Designation Dose Not Match. <br/>";
                                    }
                                }
                                // echo "employeeid=".$CM['employeeid'] ."\n <br>". 
                                // "feedbackCategoryId=".$FC['feedbackCategoryId']."\n <br>". 
                                //  "centralmanagerId=".$CM['centralmanagerId']."\n<br>".
                                //   "iDesignationId=".$sql['iDesignationId']."\n<br>";
                                if ($CM['employeeid'] != "" && $FC['feedbackCategoryId'] != "" && $CM['centralmanagerId'] != "" && $sql['iDesignationId'] != "" && $sql['iDesignationId'] != 6 && $sql['iDesignationId'] != 8) {

                                    $agentId = $CM['employeeid'];
                                    $iteamleadid = $CM['iteamleadid'];
                                    $asstmanagerid = $CM['asstmanagerid'];
                                    $processmanager = $CM['processmanager'];
                                    $userData = array(
                                        "agentId" => $agentId,
                                        "feedbackCategoryId" => $FC['feedbackCategoryId'],
                                        "tLId" => $iteamleadid,
                                        "AMId" => $asstmanagerid,
                                        "PMId" => $processmanager,
                                        "comment" => $slice[2],
                                        "status" => 1,
                                        "statusDate" => date('d-m-Y H:i:s'),
                                        "complainby" => $_SESSION['EmployeeId'],
                                        "statusby" => $_SESSION['EmployeeId'],
                                        "strEntryDate" => date('d-m-Y H:i:s'),
                                        "strIP" => $_SERVER['REMOTE_ADDR']
                                    );

                                    $insert = $connect->insertrecord($dbconn, 'onlinefeedback', $userData);

                                    $historydata = array(
                                        "feedbackId" => $insert,
                                        "historyComment" => $slice[2],
                                        "status" => 1,
                                        "statusby" => $_SESSION['EmployeeId'],
                                        "strEntryDate" => date('d-m-Y H:i:s'),
                                        "strIP" => $_SERVER['REMOTE_ADDR']
                                    );
                                    $dealer_res2 = $connect->insertrecord($dbconn, 'historyfeedback', $historydata);
                                }
                            } elseif ($_SESSION['Designation'] == 3) { //Process Manager
                                $CM = mysqli_fetch_array(mysqli_query($dbconn, "SELECT * from employee WHERE elisionloginid=" . $slice[0] . ""));

                                $FC = mysqli_fetch_array(mysqli_query($dbconn, "SELECT *,count(*) as catValue FROM `feedbackcategory` WHERE isDelete=0 and categoryName='" . $slice[1] . "' "));


                                if ($FC['catValue'] != 1) {
                                    $strerror .= "Row " . $RowCounter . "->  Feedback Category " . $slice[1] . " is Not Match. <br/>";
                                }
                                $sql = mysqli_fetch_array(mysqli_query($dbconn, "SELECT * FROM `employee` e INNER join employeedesignation ed on e.employeeid=ed.iEmployeeId where " . $where . "  and e.isDelete=0 and e.istatus=1 and elisionloginid=" . $slice[0] . " ORDER BY empname ASC "));

                                if ($cm['centralmanagerId'] == $sql['centralmanagerId']) {
                                    if ($sql['iDesignationId'] != 6 || $sql['iDesignationId'] != 3 && $sql['iDesignationId'] != 8) {
                                        if ($CM['employeeid'] == "") {
                                            $strerror .= "Row " . $RowCounter . "->  Elisionloginid " . $slice[0] . " is Not Match. <br/>";
                                        }
                                        $strerror .= "Row " . $RowCounter . "->" . $slice[0] . " Employee Designation Dose Not Match. <br/>";
                                    }
                                }


                                // echo "employeeid=".$CM['employeeid'] ."\n <br>". 
                                // "feedbackCategoryId=".$FC['feedbackCategoryId']."\n <br>". 
                                //  "centralmanagerId=".$CM['centralmanagerId']."\n<br>".
                                //   "iDesignationId=".$sql['iDesignationId']."\n<br>";
                                if ($CM['employeeid'] != "" && $FC['feedbackCategoryId'] != "" && $CM['centralmanagerId'] != "" && $sql['iDesignationId'] != 6 && $sql['iDesignationId'] != 3 && $sql['iDesignationId'] != 8 && $sql['iDesignationId'] != "") {

                                    $agentId = $CM['employeeid'];
                                    $iteamleadid = $CM['iteamleadid'];
                                    $asstmanagerid = $CM['asstmanagerid'];

                                    $userData = array(
                                        "agentId" => $agentId,
                                        "feedbackCategoryId" => $FC['feedbackCategoryId'],
                                        "tLId" => $iteamleadid,
                                        "AMId" => $asstmanagerid,
                                        "PMId" => $processmanager,
                                        "comment" => $slice[2],
                                        "status" => 1,
                                        "statusDate" => date('d-m-Y H:i:s'),
                                        "complainby" => $_SESSION['EmployeeId'],
                                        "statusby" => $_SESSION['EmployeeId'],
                                        "strEntryDate" => date('d-m-Y H:i:s'),
                                        "strIP" => $_SERVER['REMOTE_ADDR']
                                    );

                                    $insert = $connect->insertrecord($dbconn, 'onlinefeedback', $userData);

                                    $historydata = array(
                                        "feedbackId" => $insert,
                                        "historyComment" => $slice[2],
                                        "status" => 1,
                                        "statusby" => $_SESSION['EmployeeId'],
                                        "strEntryDate" => date('d-m-Y H:i:s'),
                                        "strIP" => $_SERVER['REMOTE_ADDR']
                                    );
                                    $dealer_res2 = $connect->insertrecord($dbconn, 'historyfeedback', $historydata);
                                }
                            } elseif ($_SESSION['Designation'] == 2 || $_SESSION['Designation'] == 7) { //Assistant Manager,HR
                                $CM = mysqli_fetch_array(mysqli_query($dbconn, "SELECT * from employee WHERE elisionloginid=" . $slice[0] . ""));

                                $FC = mysqli_fetch_array(mysqli_query($dbconn, "SELECT *,count(*) as catValue FROM `feedbackcategory` WHERE isDelete=0 and categoryName='" . $slice[1] . "' "));


                                if ($FC['catValue'] != 1) {
                                    $strerror .= "Row " . $RowCounter . "->  Feedback Category " . $slice[1] . " is Not Match. <br/>";
                                }
                                $sql = mysqli_fetch_array(mysqli_query($dbconn, "SELECT * FROM `employee` e INNER join employeedesignation ed on e.employeeid=ed.iEmployeeId where " . $where . "  and e.isDelete=0 and e.istatus=1 and elisionloginid=" . $slice[0] . " ORDER BY empname ASC "));

                                if ($cm['centralmanagerId'] == $sql['centralmanagerId']) {
                                    if ($sql['iDesignationId'] != 6 && $sql['iDesignationId'] != 3 && $sql['iDesignationId'] != 8 && $sql['iDesignationId'] != 2 && $sql['iDesignationId'] != 7 && $sql['iDesignationId'] != 10 && $sql['iDesignationId'] != 11) {
                                        if ($CM['employeeid'] == "") {
                                            $strerror .= "Row " . $RowCounter . "->  Elisionloginid " . $slice[0] . " is Not Match. <br/>";
                                        }
                                        $strerror .= "Row " . $RowCounter . "->" . $slice[0] . " Employee Designation Dose Not Match. <br/>";
                                    }
                                }

                                if ($CM['employeeid'] != "" && $FC['feedbackCategoryId'] != "" && $CM['centralmanagerId'] != "" && $sql['iDesignationId'] != 6 && $sql['iDesignationId'] != 3 && $sql['iDesignationId'] != 8 && $sql['iDesignationId'] != 2 && $sql['iDesignationId'] != 7 && $sql['iDesignationId'] != 10 && $sql['iDesignationId'] != 11 && $sql['iDesignationId'] != "") {

                                    $agentId = $CM['employeeid'];
                                    $iteamleadid = $CM['iteamleadid'];

                                    $userData = array(
                                        "agentId" => $agentId,
                                        "feedbackCategoryId" => $FC['feedbackCategoryId'],
                                        "tLId" => $iteamleadid,
                                        "AMId" => $asstmanagerid,
                                        "PMId" => $processmanager,
                                        "comment" => $slice[2],
                                        "status" => 1,
                                        "statusDate" => date('d-m-Y H:i:s'),
                                        "complainby" => $_SESSION['EmployeeId'],
                                        "statusby" => $_SESSION['EmployeeId'],
                                        "strEntryDate" => date('d-m-Y H:i:s'),
                                        "strIP" => $_SERVER['REMOTE_ADDR']
                                    );

                                    $insert = $connect->insertrecord($dbconn, 'onlinefeedback', $userData);

                                    $historydata = array(
                                        "feedbackId" => $insert,
                                        "historyComment" => $slice[2],
                                        "status" => 1,
                                        "statusby" => $_SESSION['EmployeeId'],
                                        "strEntryDate" => date('d-m-Y H:i:s'),
                                        "strIP" => $_SERVER['REMOTE_ADDR']
                                    );
                                    $dealer_res2 = $connect->insertrecord($dbconn, 'historyfeedback', $historydata);
                                }
                            } elseif ($_SESSION['Designation'] == 4 || $_SESSION['Designation'] == 1 || $_SESSION['Designation'] == 9) { //Assistant Manager,HR
                                $CM = mysqli_fetch_array(mysqli_query($dbconn, "SELECT * from employee WHERE elisionloginid=" . $slice[0] . ""));

                                $FC = mysqli_fetch_array(mysqli_query($dbconn, "SELECT *,count(*) as catValue FROM `feedbackcategory` WHERE isDelete=0 and categoryName='" . $slice[1] . "' "));


                                if ($FC['catValue'] != 1) {
                                    $strerror .= "Row " . $RowCounter . "->  Feedback Category " . $slice[1] . " is Not Match. <br/>";
                                }
                                $sql = mysqli_fetch_array(mysqli_query($dbconn, "SELECT * FROM `employee` e INNER join employeedesignation ed on e.employeeid=ed.iEmployeeId where " . $where . "  and e.isDelete=0 and e.istatus=1 and elisionloginid=" . $slice[0] . " ORDER BY empname ASC "));

                                if ($cm['centralmanagerId'] == $sql['centralmanagerId']) {
                                    if ($sql['iDesignationId'] != 6 && $sql['iDesignationId'] != 3 && $sql['iDesignationId'] != 8 && $sql['iDesignationId'] != 2 && $sql['iDesignationId'] != 7 && $sql['iDesignationId'] != 10 && $sql['iDesignationId'] != 11 && $sql['iDesignationId'] != 4 && $sql['iDesignationId'] != 1 && $sql['iDesignationId'] != 9) {
                                        if ($CM['employeeid'] == "") {
                                            $strerror .= "Row " . $RowCounter . "->  Elisionloginid " . $slice[0] . " is Not Match. <br/>";
                                        }
                                        $strerror .= "Row " . $RowCounter . "->" . $slice[0] . " Employee Designation Dose Not Match. <br/>";
                                    }
                                }

                                if ($CM['employeeid'] != "" && $FC['feedbackCategoryId'] != "" && $CM['centralmanagerId'] != "" && $sql['iDesignationId'] == 5 && $sql['iDesignationId'] != "") {

                                    $agentId = $CM['employeeid'];


                                    $userData = array(
                                        "agentId" => $agentId,
                                        "feedbackCategoryId" => $FC['feedbackCategoryId'],
                                        "tLId" => $iteamleadid,
                                        "AMId" => $asstmanagerid,
                                        "PMId" => $processmanager,
                                        "comment" => $slice[2],
                                        "status" => 1,
                                        "statusDate" => date('d-m-Y H:i:s'),
                                        "complainby" => $_SESSION['EmployeeId'],
                                        "statusby" => $_SESSION['EmployeeId'],
                                        "strEntryDate" => date('d-m-Y H:i:s'),
                                        "strIP" => $_SERVER['REMOTE_ADDR']
                                    );

                                    $insert = $connect->insertrecord($dbconn, 'onlinefeedback', $userData);

                                    $historydata = array(
                                        "feedbackId" => $insert,
                                        "historyComment" => $slice[2],
                                        "status" => 1,
                                        "statusby" => $_SESSION['EmployeeId'],
                                        "strEntryDate" => date('d-m-Y H:i:s'),
                                        "strIP" => $_SERVER['REMOTE_ADDR']
                                    );
                                    $dealer_res2 = $connect->insertrecord($dbconn, 'historyfeedback', $historydata);
                                }
                            }
                        }
                        echo $strerror;
                    }

                    $ValCounter++;
                }
            }
        }

        @unlink($file_path);

        echo $statusMsg = "Added Successfully...";

        break;

    case "AcceptData":


        $datahistory = array(

            "status" => 3,
            "feedbackId" => $_REQUEST['ID'],
            "statusby" => $_SESSION['EmployeeId'],
            "historyComment" => "Accept " . $_SESSION['EmployeeName'],
            "strEntryDate" => date('d-m-Y H:i:s'),
            "strIP" => $_SERVER['REMOTE_ADDR']

        );


        $dealer_res = $connect->insertrecord($dbconn, 'historyfeedback', $datahistory);

        $data = array(

            "status" => 3,
            "statusby" => $_SESSION['EmployeeId'],
            "statusDate" => date('d-m-Y H:i:s'),
            "strIP" => $_SERVER['REMOTE_ADDR']
        );

        $where = ' where feedbackId=' . $_REQUEST['ID'];

        $dealer_res_1 = $connect->updaterecord($dbconn, 'onlinefeedback', $data, $where);

        echo $statusMsg = $dealer_res ? '1' : '0';
        break;

        case "addWarning":
            $filename = trim($_REQUEST['IMgallery']);
            $datahistory = array(

                "warningForId" => $_REQUEST['warningForId'],
                "warningForUserType" => $_REQUEST['warningfor'],
                "raiseById" => $_SESSION['EmployeeId'],
                "warningFile" => $filename,
                "strEntryDatetime" => date('d-m-Y H:i:s'),
                "strIP" => $_SERVER['REMOTE_ADDR']
    
            );
       
            $dealer_res = $connect->insertrecord($dbconn, 'warninglater', $datahistory);
            break;

        case 'getLastPTPDate':
            $applicatipnNo = mysqli_real_escape_string($dbconn, $_POST['applicatipnNo']);

            // Query to get the last PTP record for this application
            $query = "SELECT PTP_Amount, PTPDate 
                      FROM applicationfollowup 
                      WHERE applicatipnNo = '$applicatipnNo' 
                       -- AND mainDispoId = 12  -- Promise to Pay disposition ID
                       -- AND PTPDate IS NOT NULL 
                        -- AND PTPDate != ''
                      ORDER BY iAppLogId DESC 
                      LIMIT 1";
            
            $result = mysqli_query($dbconn, $query);
    
            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                echo json_encode([
                    'success' => true,
                    'ptpDate' => $row['PTPDate'],
                    'ptpAmount' => $row['PTP_Amount']
                ]);
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => 'No previous PTP record found'
                ]);
            }
            break;
            
    default:

        echo "Page not Found";

        break;
}
