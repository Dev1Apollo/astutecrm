<?php
ob_start();
include('../common.php');
include('IsLogin.php');
$connect = new connect();
include ('User_Paging.php');

if ($_POST['action'] == 'ListUser') {
    $where = "where 1=1 ";
    
     $filterstr = "SELECT em.examId,em.examTitle,em.examDateTime,em.examDuration,em.examEndDateTime,em.Marks,em.iPassingMarks,eau.isAutoSubmit,
   (select count(*) from questionanswer q where q.examId=em.examId and isDelete='0' and istatus='1') as TotalQuestion,

(SELECT COUNT(*) FROM `questionanswer` QAUA WHERE QAUA.questionId NOT IN (SELECT questionId FROM usertablesubmit us WHERE QAUA.examId=us.examId and us.userId='" . $_SESSION['EmployeeId'] . "' and QAUA.isDelete=0 and QAUA.questionId=us.questionId) and QAUA.examId=em.examId and QAUA.isDelete=0 ) as unattempQuestion,

 IFNULL((SELECT sum(QA.questionMarks) FROM usertablesubmit USANS INNER JOIN questionanswer QA WHERE USANS.examId=QA.examId AND USANS.questionId=QA.questionId AND USANS.selectAnswer=QA.rightAnswer AND USANS.userId='" . $_SESSION['EmployeeId'] . "' and QA.isDelete=0 and USANS.examId=em.examid),0) AS obtainMarks
     FROM exammaster em inner join `examassigneduser` eau on em.examid=eau.examid where em.isdelete=0 and em.ispublished=1 and userId='" . $_SESSION['EmployeeId'] . "' order by STR_TO_DATE('%d-%m-%Y',examDateTime) asc";
    //and STR_TO_DATE(em.examEndDateTime,'%d-%m-%Y %H:%i:%s') <= STR_TO_DATE('".date('d-m-Y H:i:s')."','%d-%m-%Y %H:%i:%s') 
    $countstr = "SELECT count(*) as TotalRow FROM exammaster em inner join `examassigneduser` eau on em.examid=eau.examid where em.isdelete=0 and em.ispublished=1 and userId='" . $_SESSION['EmployeeId'] . "'  and STR_TO_DATE(em.examEndDateTime,'%d-%m-%Y %H:%i:%s') <= STR_TO_DATE('".date('d-m-Y H:i:s')."','%d-%m-%Y %H:%i:%s')";

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
        <link href="<?php echo $web_url; ?>Employee/assets/global/plugins/datatables/datatables.css" rel="stylesheet" type="text/css" />
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover dt-responsive" width="100%" id="tableC">
                <thead class="tbg">
                    <tr>
                        <th class="pop_in_heading">Exam Name</th>
                        
                        <th class="pop_in_heading">Exam Start Date Time </th>
                        <th class="pop_in_heading">Exam Duration</th>
                        <th class="pop_in_heading">Exam End Date Time</th>
                        <th class="pop_in_heading">Maximum Mark</th>
                        <th class="pop_in_heading">Obtain Mark</th>
                        <th class="pop_in_heading">Passing Marks</th>
                        <th class="pop_in_heading">Result</th>
                        
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($rowfilter = mysqli_fetch_array($resultfilter)) {
                        ?>
                        <tr>
                            <td><?php echo $rowfilter['examTitle']; ?> 
                            </td> 
                            <td>
                                <?php echo $rowfilter['examDateTime']; ?> 
                            </td> 
                    
                            <td>
                                <?php echo $rowfilter['examDuration']; ?> 
                            </td> 
                            <td>
                                <?php echo $rowfilter['examEndDateTime']; ?> 
                            </td> 
                            <td>
                                <?php echo $rowfilter['Marks']; ?> 
                            </td> 
                            <td>
                                <?php echo $rowfilter['obtainMarks']; ?> 
                            </td>
                            <?php
                            if ($rowfilter['TotalQuestion']==$rowfilter['unattempQuestion'] &&$rowfilter['isAutoSubmit']==0) {
                                $result="Unattempted Exam";
                            }else{

                                    $result=$rowfilter['obtainMarks'];

                                    if ($result>=$rowfilter['iPassingMarks'] ) {
                                        $result= "Pass";
                                    }else{
                                        $result="Fail";
                                    }}
                                    $result;?>
                              <td>
                                <?php echo $rowfilter['iPassingMarks']; ?> 
                            </td>
                            <td>

                            <div class="form-group form-md-line-input "><?php echo $result; ?> 
                            </div>
                             </td>

                            <?php
                        }
                        ?>
                    </tr>
                </tbody>
            </table>
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
?>
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
<script type="text/javascript">
    
</script>  