<?php
error_reporting(0);

include('../common.php');

include('IsLogin.php');

$connect = new connect();

include ('User_Paging.php');



if ($_POST['action'] == 'ListUser') {

    $where = "where 1=1 ";

    



   $filterstr = "SELECT *,(select empname from employee where employee.employeeid=complainticket.complainBy and isDelete=0)as empname ,(select categoryName FROM `ticketcategory` where isDelete='0' and istatus='1' and ticketCategoryId =complainticket.ticketCategoryId )as categoryName from complainticket where ticketStatus='1' and istatus='1' and isDelete='0'";
    $countstr = "SELECT * from complainticket where ticketStatus='1' and istatus='1' and isDelete='0'";
    $resrowcount = mysqli_query($dbconn, $countstr);
    $resrowc = mysqli_fetch_array($resrowcount);


   /*$countQuestion = "SELECT count(*) as TotalQuestion,SUM(questionMarks) as TotalMarks FROM `questionanswer` " . $where . "and isDelete='0' and istatus='1' ";    
    $resultrowcount = mysqli_fetch_array(mysqli_query($dbconn, $countQuestion));*/


   


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

                <tr>

                    <th class="all">Sr No.</th>
                    <th class="all">Complain By</th>
                    <th class="all">Ticket Category</th>
                    <th class="all">Ticket Id</th>
                    <th class="all">Complain</th>
                    <th class="all">Complain Date</th>
                    <th class="all">Status</th>
                    <th class="all">Solution</th>
                    <th class="all">Solution Date</th>
                   
                    </tr>    

        <!--                    <th class="none">Upload date & time</th>-->

                    <!-- <th class="desktop">Action</th> -->

               

            </thead>

            <tbody>

                <?php
                $i=1;
                 while ($rowfilter = mysqli_fetch_array($resultfilter)) {

                    ?>

                    <tr>

                        <td>

                            <div class="form-group form-md-line-input ">
                                <?php echo $i;?>
                            </div>

                        </td>

                        <td>

                            <div class="form-group form-md-line-input ">
                               <?php echo $rowfilter['empname']; ?>

                            </div>

                        </td>

                        <td>

                            <div class="form-group form-md-line-input ">
                               <?php echo $rowfilter['categoryName']; ?>

                            </div>

                        </td>

                        <td>

                            <div class="form-group form-md-line-input ">
                                <?php echo $rowfilter['ticketId']; ?>

                            </div>

                        </td>
                        <td>

                            <div class="form-group form-md-line-input ">
                               <?php echo $rowfilter['complainText']; ?>

                            </div>

                        </td>

                        <td>

                            <div class="form-group form-md-line-input ">
                                 <?php echo $rowfilter['complainDate']; ?>

                            </div>

                        </td>
                         <?php 
                            if ($rowfilter['ticketStatus']==0) {
                                $ticketStatus="Open";
                            }else{
                                $ticketStatus="Close";

                            }
                                $ticketStatus;
                            ?>
                        <td>

                            <div class="form-group form-md-line-input ">
                                <?php echo $ticketStatus; ?>

                            </div>

                        </td>
                        <td>

                            <div class="form-group form-md-line-input ">
                             <?php echo $rowfilter['solution']; ?> 

                            </div>

                        </td>
                        <td>

                        <div class="form-group form-md-line-input ">
                             <?php echo $rowfilter['closeDate']; ?>

                        </div>

                        </td>
                        

                        <!-- <td>

                            <div class="form-group form-md-line-input "> 
                                <a class="btn blue"  href="AddQuestionAnswer.php?id=<?php echo $rowfilter['examId'];?>"  title="Question & Answer"><i class="fa fa-question iconshowFirst"></i></a>

                                <a class="btn blue"  href="AssignExam.php?id=<?php echo $rowfilter['examId'];?>"  title="assign"><i class="fa fa-tasks iconshowFirst"></i></a>
                                <?php
                                if (  $rowfilter['TotalQuestion']> 0) {?>
                                    
                                <a class="btn blue" onclick="publishdta('<?php echo $rowfilter['examId']; ?>','<?= $rowfilter['TotalMarks']?>');"  title="Publish"><i class="fa fa-upload iconshowFirst"></i></a>
                                <?php }
                                ?>



                                <a class="btn blue" onClick="javascript: return setEditdata('<?php echo $rowfilter['examId']; ?>');"  title="Edit"><i class="fa fa-edit iconshowFirst"></i></a> 

                                <a  class="btn blue" onClick="javascript: return deletedata('Delete', '<?php echo $rowfilter['examId']; ?>');"   title="Delete"><i class="fa fa-trash-o iconshowFirst"></i></a>
                                <?php
                                $examStartDateTime = new DateTime(date('Y-m-d H:i:s',strtotime($rowfilter['examDateTime'])));
                                $CurrentDateTime = new DateTime(date('Y-m-d H:i:s'));
                    //if($examEndDateTime < $CurrentDateTime){

                                if ($examStartDateTime < $CurrentDateTime && $rowfilter['examEndDateTime'] != '')
                                 {

                                   ?>
                                    <a class="btn blue" href="listOfResult.php?id=<?php echo $rowfilter['examId'];?>" title="Result"><i class="fa fa-list-alt"></i>Result</a>
                                <?php }?>
                                
                            </div>

                        </td> -->

                    </tr>

                    <?php

                 $i++; }

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

    $where = ' where examId=' . $_REQUEST['ID'];

    $dealer_res = $connect->updaterecord($dbconn, 'exammaster', $data, $where);

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