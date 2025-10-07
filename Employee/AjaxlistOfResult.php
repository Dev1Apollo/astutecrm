<?php

error_reporting(0);

include('../common.php');

include('IsLogin.php');

$connect = new connect();

include ('User_Paging.php');


if ($_POST['action'] == 'ListUser') {

    $where = "where 1=1 ";

/*$filterstr = "SELECT e.empname,examassigneduser.examUserId,(select count(*) from questionanswer q where q.examId=examassigneduser.examId and isDelete='0' and istatus='1') as TotalQuestion,
(select count(*) from usertablesubmit us where us.userId=examassigneduser.userId and us.examId=examassigneduser.examId and us.userId=e.employeeid) as attendedQuestion,
(SELECT COUNT(*) FROM `questionanswer` QAUA WHERE QAUA.questionId NOT IN (SELECT questionId FROM usertablesubmit us WHERE QAUA.examId=us.examId and us.userId=examassigneduser.userId and QAUA.isDelete=0 and QAUA.questionId=us.questionId) and QAUA.examId=examassigneduser.examId and QAUA.isDelete=0 ) as unattempQuestion,
(SELECT COUNT(*) FROM usertablesubmit USANS INNER JOIN questionanswer QA WHERE USANS.examId=QA.examId AND USANS.questionId=QA.questionId AND USANS.selectAnswer=QA.rightAnswer AND USANS.userId=examassigneduser.userId and QA.isDelete=0 and USANS.examId='".$_POST['examId']."') AS RIGHTANSWER,
(SELECT COUNT(*) FROM usertablesubmit USANS INNER JOIN questionanswer QA WHERE USANS.examId=QA.examId AND USANS.questionId=QA.questionId AND USANS.selectAnswer!=QA.rightAnswer AND USANS.userId=examassigneduser.userId and USANS.examId='".$_POST['examId']."') AS WRONGANSWER,
IFNULL((SELECT sum(QA.questionMarks) FROM usertablesubmit USANS INNER JOIN questionanswer QA WHERE USANS.examId=QA.examId AND USANS.questionId=QA.questionId AND USANS.selectAnswer=QA.rightAnswer AND USANS.userId=examassigneduser.userId and QA.isDelete=0 and USANS.examId='".$_POST['examId']."' ),0) AS obtainMarks, 
(select (exam.iPassingMarks) from exammaster exam where exam.examId=examassigneduser.examId) as passingMarks 
FROM `employee` e inner join employeedesignation ed on e.employeeid=ed.iEmployeeId inner join  examassigneduser on examassigneduser.userId=e.employeeid where ed.iDesignationId=5 and e.isDelete=0 and e.istatus=1 and examassigneduser.examId='".$_POST['examId']."'";*/
    $filterstr = "SELECT e.empname,examassigneduser.examUserId,(select count(*) from questionanswer q where q.examId=examassigneduser.examId and isDelete='0' and istatus='1') as TotalQuestion,
    (select count(*) from usertablesubmit us where us.userId=examassigneduser.userId and us.examId=examassigneduser.examId and us.userId=e.employeeid) as attendedQuestion,
    (SELECT COUNT(*) FROM `questionanswer` QAUA WHERE QAUA.questionId NOT IN (SELECT questionId FROM usertablesubmit us WHERE QAUA.examId=us.examId and us.userId=examassigneduser.userId and QAUA.isDelete=0 and QAUA.questionId=us.questionId) and QAUA.examId=examassigneduser.examId and QAUA.isDelete=0 ) as unattempQuestion,
    (SELECT COUNT(*) FROM usertablesubmit USANS INNER JOIN questionanswer QA WHERE USANS.examId=QA.examId AND USANS.questionId=QA.questionId AND USANS.selectAnswer=QA.rightAnswer AND USANS.userId=examassigneduser.userId and QA.isDelete=0 and USANS.examId='".$_POST['examId']."') AS RIGHTANSWER,
    (SELECT COUNT(*) FROM usertablesubmit USANS INNER JOIN questionanswer QA WHERE USANS.examId=QA.examId AND USANS.questionId=QA.questionId AND USANS.selectAnswer!=QA.rightAnswer AND USANS.userId=examassigneduser.userId and USANS.examId='".$_POST['examId']."') AS WRONGANSWER,
    IFNULL((SELECT sum(QA.questionMarks) FROM usertablesubmit USANS INNER JOIN questionanswer QA WHERE USANS.examId=QA.examId AND USANS.questionId=QA.questionId AND USANS.selectAnswer=QA.rightAnswer AND USANS.userId=examassigneduser.userId and QA.isDelete=0 and USANS.examId='".$_POST['examId']."' ),0) AS obtainMarks, 
    (select (exam.iPassingMarks) from exammaster exam where exam.examId=examassigneduser.examId) as passingMarks 
    FROM `employee` e inner join employeedesignation ed on e.employeeid=ed.iEmployeeId inner join  examassigneduser on examassigneduser.userId=e.employeeid where e.istatus=1 and examassigneduser.examId='".$_POST['examId']."'";
    // e.isDelete=0 and 
     $resultfilter = mysqli_query($dbconn, $filterstr);
     $rowfilter = mysqli_fetch_array($resultfilter);

    // $filterstr = "SELECT * FROM `questionanswer` " . $where . "  and isDelete='0' and istatus='1' order by questionId desc";  e.isDelete=0 and

    // $countstr = "SELECT count(*) as TotalRow FROM `employee` e inner join employeedesignation ed on e.employeeid=ed.iEmployeeId where ed.iDesignationId=5 and e.isDelete=0 and e.istatus=1 and e.employeeid in (SELECT userId FROM `examassigneduser`)";
    $countstr = "SELECT count(*) as TotalRow FROM `employee` e inner join employeedesignation ed on e.employeeid=ed.iEmployeeId where  e.istatus=1 and e.employeeid in (SELECT userId FROM `examassigneduser` where examassigneduser.examId='".$_POST['examId']."')";



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
        <link href="<?php echo $web_url; ?>admin/assets/global/plugins/datatables/datatables.css" rel="stylesheet" type="text/css" />

        <link href="<?php echo $web_url; ?>admin/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css" rel="stylesheet" type="text/css" />

        <script src="<?php echo $web_url; ?>admin/assets/global/plugins/datatables/datatables.js" type="text/javascript"></script>

        <script src="<?php echo $web_url; ?>admin/assets/global/plugins/datatables/table-datatables-responsive.js" type="text/javascript"></script>

        <table class="table table-bordered table-hover center table-responsive" width="100%" id="tableC">

            <thead class="tbg">

                <tr style="background: #3f4296;">

                    <th class="all"style="color: #fff;">Sr No.</th>
                    <th class="all"style="color: #fff;">Employee Name</th>
                    <th class="all"style="color: #fff;">Total Question</th>
                    <th class="all"style="color: #fff;">Attempted Question</th>
                    <th class="all"style="color: #fff;">Unattempted Question</th>
                    <th class="all"style="color: #fff;">Right answer</th>
                    <th class="all"style="color: #fff;">Wrong Answer</th>
                    <th class="all"style="color: #fff;">Obtain Marks</th>
                    <th class="all"style="color: #fff;">Passing Marks</th>
                    <th class="all"style="color: #fff;">Result</th>


                </tr>

            </thead>

            <tbody>

                <?php
                $i=1; 

                while ($rowfilter = mysqli_fetch_array($resultfilter)) {
                        

                    ?>

                    <tr>

                        <td>

                            <div class="form-group form-md-line-input "><?php echo $i;?> 
                            </div>
                        </td>
                        
                        <td>

                            <div class="form-group form-md-line-input "><?php echo $rowfilter['empname']; ?> 
                            </div>
                        </td>
                        <td>

                            <div class="form-group form-md-line-input "><?php echo $rowfilter['TotalQuestion']; ?> 
                            </div>
                        </td>
                        
                        <td>

                            <div class="form-group form-md-line-input ">
                                 <?= isset($rowfilter['attendedQuestion']) ? $rowfilter['attendedQuestion'] : 0; ?>
                            </div>
                        </td>
                        <td>

                            <div class="form-group form-md-line-input "><?php echo $rowfilter['unattempQuestion']; ?> 
                            </div>
                        </td>
                        <td>

                            <div class="form-group form-md-line-input ">
                                <?= isset($rowfilter['RIGHTANSWER']) ? $rowfilter['RIGHTANSWER'] : 0; ?>

                            </div>
                        </td>
                        <td>

                            <div class="form-group form-md-line-input ">
                                <?= isset($rowfilter['WRONGANSWER']) ? $rowfilter['WRONGANSWER'] : 0; ?>

                            </div>
                        </td>
                        
                        <td>

                            <div class="form-group form-md-line-input "><?php echo $rowfilter['obtainMarks']; ?>
                            </div>
                        </td>
                        <td>
                            <?php
                            if ($rowfilter['TotalQuestion']==$rowfilter['unattempQuestion'] &&$rowfilter['isAutoSubmit']==0) {
                                $result="Unattempted Exam";
                            }else{
                $result=$rowfilter['obtainMarks'];

                if ($result>=$rowfilter['passingMarks'] ) {
                    $result= "Pass";
                }else{
                    $result="Fail";
                }}
                $result;?>
                            <div class="form-group form-md-line-input ">
                                  <?= isset($rowfilter['passingMarks']) ? $rowfilter['passingMarks'] : 0; ?>

                            </div>
                        </td>
                        <td>

                            <div class="form-group form-md-line-input "><?php echo $result; ?> 
                            </div>
                        </td>

                      

                    </tr>

                    <?php

              $i++;  }

                ?>

            </tbody>

        </table>

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

    $where = ' where questionId=' . $_REQUEST['ID'];

    $dealer_res = $connect->updaterecord($dbconn, 'questionanswer', $data, $where);

}



if ($totalrecord > $per_page) {

    ?>

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