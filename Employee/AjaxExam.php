<?php
error_reporting(E_ALL);
include('../common.php');
include('IsLogin.php');
$connect = new connect();
include ('User_Paging.php');

if ($_POST['action'] == 'ListUser') {
    $where = "where 1=1 ";
    
    $filterstr = "SELECT em.examId,em.examTitle,em.examDateTime,em.examDuration,em.examEndDateTime,em.Marks,em.iPassingMarks,eau.isAutoSubmit FROM exammaster em inner join `examassigneduser` eau on em.examid=eau.examid where em.isdelete=0 and em.ispublished=1 and userId='" . $_SESSION['EmployeeId'] . "'  and  STR_TO_DATE(em.examEndDateTime,'%d-%m-%Y %H:%i:%s') >= STR_TO_DATE('".date('d-m-Y H:i:s')."','%d-%m-%Y %H:%i:%s') order by STR_TO_DATE('%d-%m-%Y',examDateTime) asc";
    $countstr = "SELECT count(*) as TotalRow FROM exammaster em inner join `examassigneduser` eau on em.examid=eau.examid where em.isdelete=0 and em.ispublished=1 and userId='" . $_SESSION['EmployeeId'] . "'   and  STR_TO_DATE(em.examEndDateTime,'%d-%m-%Y %H:%i:%s') >= STR_TO_DATE('".date('d-m-Y H:i:s')."','%d-%m-%Y %H:%i:%s') and eau.isAutosubmit=0";

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
                        <th class="pop_in_heading">Exam Mark</th>
                       
                        <th class="pop_in_heading">Action</th>
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
                            <!-- <td>
                                <?php echo $rowfilter['iPassingMarks']; ?> 
                            </td>  -->
                             <td>
                                <?php
                                //date_default_timezone_set('Europe/London');
                                $d1 = new DateTime(date('Y-m-d H:i:s',strtotime($rowfilter['examEndDateTime'])));
                                $d2 = new DateTime(date('Y-m-d H:i:s'));

                                $d3 = new DateTime(date('Y-m-d H:i:s',strtotime($rowfilter['examDateTime']))); 
                                if($d3 >= $d2) { ?>
                                    <a onclick="ExamStartTime();" title="Start Exam"><i class="fa fa-check-square-o" aria-hidden="true"></i>
                                    </a>
                                 <?php } else if($d1 < $d2){ ?>
                                    <a onclick="ExamTimeOver();" title="Start Exam"><i class="fa fa-check-square-o" aria-hidden="true"></i>
                                    </a>
                                <?php } else { ?>
                                    <a href="<?php echo $web_url; ?>Employee/StartExam.php?token=<?php echo $rowfilter['examId']; ?>" title="Start Exam"><i class="fa fa-check-square-o" aria-hidden="true"></i>
                                    </a>
                                <?php } ?>
                                
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