<?php
ob_start();
error_reporting(E_ALL);
include('../common.php');
include('IsLogin.php');
$connect = new connect();
include ('Exam_Paging.php');

if ($_POST['action'] == 'ListUser') {
    $where = "where 1=1 ";
    
    //$filterstr = "SELECT em.examId,em.examTitle,em.examDateTime,em.examDuration,em.examEndDateTime,em.Marks,em.iPassingMarks FROM exammaster em inner join `examassigneduser` eau on em.examid=eau.examid where em.isdelete=0 and em.ispublished=1 and userId='" . $_SESSION['EmployeeId'] . "' order by STR_TO_DATE('%d-%m-%Y',examDateTime) asc";
    $filterstr = "SELECT q.questionId,q.examId,q.question,q.option1,option2,option3,option4,examTitle,q.questionMarks,examDateTime,examDuration,examEndDateTime,(select COUNT(*) from questionanswer qn where qn.examId=q.examId and qn.isDelete=0) as 'Total Question',(select SUM(questionMarks) from questionanswer que where que.examId=q.examId and que.isDelete=0) as 'Total Marks' FROM `questionanswer` q inner join exammaster em on q.examid=em.examId where em.isDelete=0 and q.isDelete=0 and em.examId='".$_REQUEST['token']."'";
    $countstr = "SELECT count(*) as TotalRow FROM `questionanswer` q inner join exammaster em on q.examid=em.examId where em.isDelete=0 and q.isDelete=0  and em.examId='".$_REQUEST['token']."'";

    $resrowcount = mysqli_query($dbconn, $countstr);
    $resrowc = mysqli_fetch_array($resrowcount);
    $totalrecord = $resrowc['TotalRow'];
    $per_page = 1;
    $total_pages = ceil($totalrecord / $per_page);
    $page = $_REQUEST['Page'] - 1;
    $startpage = $page * $per_page;
    $show_page = $page + 1;

    $filterstr = $filterstr . " LIMIT $startpage, $per_page";
    $resultfilter = mysqli_query($dbconn, $filterstr);

    /*$examStr = "SELECT * FROM `exammaster` where examId='".$row["examId"]."'";
    $rowStr = mysqli_query($dbconn,$examStr);
    $rowExamStr = mysqli_fetch_array($rowStr);*/
    /*$d1 = new DateTime(date('Y-m-d H:i:s',strtotime($rowExamStr['examEndDateTime'])));
    $d2 = new DateTime(date('Y-m-d H:i:s'));
    if($d1 < $d2){
        $data = array(
            "isAutoSubmit" => '1',
            "SubmitDateTime" => date('d-m-Y H:i:s')
        );
        $where = ' where examId=' . $_REQUEST['token'].' and userId='.$_SESSION['EmployeeId'];
        $dealer_res = $connect->updaterecord($dbconn, 'examassigneduser', $data, $where);
        //header("location: Exam.php");
        ?>
        <script type="text/javascript">
        window.location.href="Exam.php";
        </script>
        <?php
    } */
    $examassigneduser = "SELECT * FROM `examassigneduser` where examId='".$_REQUEST['token']."' and userId='".$_SESSION['EmployeeId']."' and isAutoSubmit=1";
    $rowExamAssignedUserStr = mysqli_query($dbconn,$examassigneduser);
    
    //$rowStr = mysqli_fetch_array($rowExamAssignedUserStr);
    if(mysqli_num_rows($rowExamAssignedUserStr) == 1){
        ?>
        <script type="text/javascript">
            alert("You have auto submitted your exam.");
            window.location.href="Exam.php";
        </script>
        <?php
    }
    if (mysqli_num_rows($resultfilter) > 0) {
        
        ?>  
        <link href="<?php echo $web_url; ?>Employee/assets/global/plugins/datatables/datatables.css" rel="stylesheet" type="text/css" />
        
        <div class="container mt-sm-5 my-1">
            <div class="question ml-sm-5 pl-sm-5 pt-2">
                <?php
                $questionId = "";
                $examId = "";
                $ExamStartDateTime = "";
                if($show_page == 1){
                    $filertStr = mysqli_query($dbconn,"select ExamStartDateTime from examassigneduser where examId='". $_REQUEST['token']."' and userId='".$_SESSION['EmployeeId']."'");
                    $rowcheck = mysqli_fetch_array($filertStr);
                    $ExamStartDateTime = $rowcheck['ExamStartDateTime'];
                    if($rowcheck['ExamStartDateTime'] == "" ){
                        $data = array(
                            "ExamStartDateTime" => date('d-m-Y H:i:s')
                        );
                        $where=' where examId=' . $_REQUEST['token'].' and userId='.$_SESSION['EmployeeId'];
                        $dealer_res=$connect->updaterecord($dbconn, 'examassigneduser', $data, $where);
                    }
                }
                while ($row = mysqli_fetch_array($resultfilter)) {  
                         //$ExamStartDateTime= date('d-m-Y H:i:s');               
                    $minutes_to_add = $row['examDuration'];
                 $UserEndTime = date("d-m-Y H:i:00", strtotime($ExamStartDateTime . "+ " . $minutes_to_add . " minutes"));
                 $userEndExamTime=new DateTime(date('Y-m-d H:i:s',strtotime($UserEndTime)));
                    $examEndDateTime = new DateTime(date('Y-m-d H:i:s',strtotime($row['examEndDateTime'])));
                    $CurrentDateTime = new DateTime(date('Y-m-d H:i:s'));

                    if ($userEndExamTime<=$examEndDateTime) {
                            $EndTime=$userEndExamTime;
                    }else {
                            $EndTime=$examEndDateTime;
                    }
                    //print_r($EndTime);
                    $EndTime;

                    if($EndTime < $CurrentDateTime){
                        $data = array(
                            "isAutoSubmit" => '1',
                            "SubmitDateTime" => date('d-m-Y H:i:s')
                        );
                        $where=' where examId=' . $row['examId'].' and userId='.$_SESSION['EmployeeId'];
                        $dealer_res=$connect->updaterecord($dbconn, 'examassigneduser', $data, $where);
                        ?>
                        <script type="text/javascript">
                            alert("Sorry,Time Out.");
                            window.location.href="Exam.php";
                        </script>
                        <?php
                    } 
                    $questionId = $row["questionId"];
                    $examId = $row["examId"];
                    $sql = "SELECT * FROM `usertablesubmit` where examId='".$row["examId"]."' and questionId='".$row["questionId"]."' and userId='".$_SESSION['EmployeeId']."'";
                    $query = mysqli_query($dbconn,$sql);
                    $answerStr = mysqli_fetch_array($query);
                    //echo $answerStr['selectAnswer'];
                    ?>
                    <div class="row">
                        <div class="col-md-4">
                            <p>Exam Name : <strong><?= $row["examTitle"]; ?></strong></p>
                        </div>
                        <div class="col-md-4">
                            <p>Total Question : <strong><?= $row["Total Question"]; ?></strong></p>
                        </div>
                    
                        <div class="col-md-4">
                            <p>Total Exam Marks : <strong><?= $row["Total Marks"]; ?></strong></p>
                        </div>
                        <div class="col-md-4">
                            <p>Exam Duration : <strong><?= $row["examDuration"]; ?></strong></p>
                        </div>
                        <div class="col-md-4">
                            <p>Exam Date : <strong><?= $row['examDateTime'];; ?></strong></p>
                        </div>
                       <!--  <div class="col-md-4">
                            <p>Exam Start Time : <strong><?= date('H:i:s',strtotime($row["examDateTime"])); ?></strong></p>
                        </div> -->
                        <div class="col-md-4">
                            <p>Exam End Time : <strong><?= $row['examEndDateTime']; ?></strong></p>
                        </div>
                    </div>
                    <div class="py-2 h5">
                        <b>Q <?= $show_page?>. <?= $row["question"];?> </b><b style="float: right;">Question Mark: <?= $row["questionMarks"];?> </b>
                    </div>
                    <div class="ml-md-3 ml-sm-3 pl-md-5 pt-sm-0 pt-3" id="options"> 

                        <label class="options"><?= $row["option1"];?> <input type="radio" name="option" id="option1" value="1" <?= isset($answerStr['selectAnswer']) && $answerStr['selectAnswer'] == 1 ? 'checked' : ''?> onclick="setAnswer(<?= $row['questionId']?>,<?= $row['examId']?>,1);"><span class="checkmark"></span> 
                        </label> 
                        <label class="options"><?= $row["option2"];?> <input type="radio" name="option" id="option2" value="2" <?= isset($answerStr['selectAnswer']) && $answerStr['selectAnswer'] == 2 ? 'checked' : ''?> onclick="setAnswer(<?= $row['questionId']?>,<?= $row['examId']?>,2);"> 
                            <span class="checkmark"></span> 
                        </label> 
                        <label class="options"><?= $row["option3"];?><input type="radio" name="option" id="option3" value="3" <?= isset($answerStr['selectAnswer']) && $answerStr['selectAnswer'] == 3 ? 'checked' : ''?> onclick="setAnswer(<?= $row['questionId']?>,<?= $row['examId']?>,3);"> 
                            <span class="checkmark"></span> 
                        </label> 
                        <label class="options"><?= $row["option4"];?> <input type="radio" name="option" id="option4" value="4" <?= isset($answerStr['selectAnswer']) && $answerStr['selectAnswer'] == 4 ? 'checked' : ''?> onclick="setAnswer(<?= $row['questionId']?>,<?= $row['examId']?>,4);"> 
                            <span class="checkmark"></span> 
                        </label> 
                    </div>
                <?php } ?>
                    <?php if ($totalrecord > $per_page) { ?>
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
                <button class="btn btn-success" onclick="FinalSubmit('<?= $examId ?>')">Submit Your Exam</button>
            </div>
        </div>
        <script src="<?php echo $web_url; ?>Employee/assets/global/plugins/datatables/datatables.js" type="text/javascript"></script>
        <script src="<?php echo $web_url; ?>Employee/assets/global/plugins/datatables/table-datatables-responsive.js" type="text/javascript"></script>
        <script>
            $(document).ready(function () {
                $('#tableC').DataTable({
                });
            });
        </script>
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
if ($_REQUEST['action'] == 'Delete') {
    $data = array(
        "isDelete" => '1',
        "strEntryDate" => date('d-m-Y H:i:s')
    );
    $where = ' where    storeListId=' . $_REQUEST['ID'];
    $dealer_res = $connect->updaterecord($dbconn, 'storelist', $data, $where);
}

if ($_REQUEST['action'] == 'FinalSubmit') {
    $data = array(
        "isAutoSubmit" => '1',
        "SubmitDateTime" => date('d-m-Y H:i:s')
    );
    $where = ' where examId=' . $_REQUEST['examId'].' and userId='.$_SESSION['EmployeeId'];
    echo $dealer_res = $connect->updaterecord($dbconn, 'examassigneduser', $data, $where);
    //echo $status = $deal_res ? '1' : '0';
    exit;
}

if ($_REQUEST['action'] == 'SubmitQuestionsAnswer') {
    $sql = mysqli_query($dbconn,"Select * from exammaster where examId='".$_REQUEST['examId']."'");
    $row = mysqli_fetch_array($sql);
    $filertStr = mysqli_query($dbconn,"select ExamStartDateTime from examassigneduser where examId='". $_REQUEST['examId']."' and userId='".$_SESSION['EmployeeId']."'");
    $rowcheck = mysqli_fetch_array($filertStr);
    $ExamStartDateTime = $rowcheck['ExamStartDateTime'];

    $minutes_to_add = $row['examDuration'];
    $UserEndTime = date("d-m-Y H:i:00", strtotime($ExamStartDateTime . "+ " . $minutes_to_add . " minutes"));
    $userEndExamTime=new DateTime(date('Y-m-d H:i:s',strtotime($UserEndTime)));
    $examEndDateTime = new DateTime(date('Y-m-d H:i:s',strtotime($row['examEndDateTime'])));
    $CurrentDateTime = new DateTime(date('Y-m-d H:i:s'));
    $EndTime = array();
    if ($userEndExamTime<=$examEndDateTime) {
            $EndTime=$userEndExamTime;
    }else {
            $EndTime=$examEndDateTime;
    }
    //print_r($EndTime);
    
         
    /*$examEndDateTime = new DateTime(date('Y-m-d H:i:s',strtotime($row['examEndDateTime'])));
    $CurrentDateTime = new DateTime(date('Y-m-d H:i:s'));*/
    if($EndTime < $CurrentDateTime){
        $data = array(
            "isAutoSubmit" => '1',
            "SubmitDateTime" => date('d-m-Y H:i:s')
        );
        $where=' where examId=' . $row['examId'].' and userId='.$_SESSION['EmployeeId'];
        $dealer_res=$connect->updaterecord($dbconn, 'examassigneduser', $data, $where);
      echo 2;
      exit;
    } else {
        $sql = "SELECT * FROM `usertablesubmit` where examId='".$_REQUEST['examId']."' and questionId='".$_REQUEST['questionId']."' and userId='".$_SESSION['EmployeeId']."'";
        $query = mysqli_query($dbconn,$sql);
        $data = array(
            "userId" => $_SESSION['EmployeeId'],
            "examId" => $_REQUEST['examId'],
            "questionId" => $_REQUEST['questionId'],
            "selectAnswer" => $_REQUEST['AnsVal'],
            "strEntryDate" => date('d-m-Y H:i:s'),
            "strIp" => $_SERVER['REMOTE_ADDR']
        );
        $status = 0;
        if(mysqli_num_rows($query) == 0){
            $insert = $connect->insertrecord($dbconn, 'usertablesubmit', $data); 
            $status = $insert ? '1' : '0';
        } else {
            $where = ' where examId=' . $_REQUEST['examId'].' and questionId='.$_REQUEST['questionId'].' and userId='.$_SESSION['EmployeeId'];
            $dealer_res = $connect->updaterecord($dbconn, 'usertablesubmit', $data, $where);
            $status = $dealer_res ? '1' : '0';
        }
        echo $status;
        exit;
    }
}
?>

<script type="text/javascript">
    function CheckAll()
    {
       if ($('#check_listall').is(":checked"))
        {
            $('input[type=checkbox]').each(function () {
                $(this).prop('checked', true);
            });
        } else
        {
            $('input[type=checkbox]').each(function () {
                $(this).prop('checked', false);
            });
        }
    }


</script>  