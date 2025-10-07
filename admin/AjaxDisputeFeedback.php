<?php
error_reporting(0);

include('../common.php');

include('IsLogin.php');

$connect = new connect();

include ('User_Paging.php');



if ($_POST['action'] == 'ListUser') {

    $where = "where 1=1 ";

    



   $filterstr = "SELECT *,(select empname from employee where employee.employeeid=complainticket.complainBy and isDelete=0)as empname from complainticket where ticketStatus='0' and istatus='1' and isDelete='0'";
    $countstr = "SELECT * from complainticket where complainBy='".$_SESSION['EmployeeId']."' and istatus='1' and isDelete='0'";
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

                
                <tr >

                    <th class="all">Sr No.</th>
                    <th class="all">Feedback To</th>
                    <!-- <th class="all">Ticket Id</th> -->
                    <th class="all">Feedback Comment</th>
                    <th class="all">Feedback Date</th>
                    <th class="all">Status By</th>
                    
                    <th class="all">Status</th>
                    <th class="desktop" >Action</th>
                </tr>

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
                            <?php echo $rowfilter['FeedbBackTo']; ?>

                            </div>

                        </td>

                      
                        <td>
                            
                            <div class="form-group form-md-line-input ">
                               <?php echo $rowfilter['comment']; ?>

                            </div>

                        </td>

                        <td>

                            <div class="form-group form-md-line-input ">
                              <?php echo $rowfilter['strEntryDate']; ?> 
                            </div>

                        </td>
                        <td>

                            <div class="form-group form-md-line-input ">
                              <?php echo $rowfilter['StatusBy']; ?> 
                            </div>

                        </td>
                                <?php 
                               
                            if ($rowfilter['status']=="1") {
                                $status="Feedback";
                            }elseif($rowfilter['status']=="2"){
                                $status="Dispute";

                            }else{
                                $status="Close";
                            }
                                $status;
                            ?> 
                        <td>

                            <div class="form-group form-md-line-input ">
                                 <?php echo $status; ?> 

                            </div>

                        </td>
                        <td>

                            <div class="form-group form-md-line-input ">
                 <?php 
                               
                            if ($rowfilter['complainBy'] != $rowfilter['statusby']) {
                                ?>
                                <a onclick="response('<?php echo $rowfilter['feedbackId']; ?>');"  title="Resloved" style="font-size:12px;"><strong> Response </strong></a>
                                <a  class="btn blue" onClick="javascript: return acceptdata('Accept', '<?php echo $rowfilter['feedbackId']; ?>');"   title="Accept"><i class="fa fa-check iconshowFirst"></i></a>
                       <?php } ?>  
                       <a  class="btn blue" onClick="javascript: return acceptdata('Accept', '<?php echo $rowfilter['feedbackId']; ?>');"   title="Accept"><i class="fa fa-eye"></i></a>   
                            </div>

                        </td>


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