<?php

error_reporting(0);

include('../common.php');

include('IsLogin.php');

$connect = new connect();

include ('User_Paging.php');



if ($_POST['action'] == 'ListUser') {

    $where = "where 1=1 ";

     $filterstr = "SELECT *,(select examTitle from exammaster where exammaster.examId =questionanswer.examId) as `examTitle` FROM `questionanswer` where examId='".$_REQUEST['examId']."' and isDelete='0'";
     $resultfilter = mysqli_query($dbconn, $filterstr);
     $rowfilter = mysqli_fetch_array($resultfilter);

    // $filterstr = "SELECT * FROM `questionanswer` " . $where . "  and isDelete='0' and istatus='1' order by questionId desc";

    $countstr = "SELECT count(*) as TotalRow FROM `questionanswer` " . $where . " and examId='".$_REQUEST['examId']."' and isDelete='0' and istatus='1' ";



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

                <tr>

                    <th class="all">SR</th>
                    <th class="all">Question</th>
                    <th class="all">Option1</th>
                    <th class="all">Option2</th>
                    <th class="all">Option3</th>
                    <th class="all">Option4</th>
                    <th class="all">Right Answer</th>
                    <th class="all">Marks</th>

        <!--                    <th class="none">Upload date & time</th>-->

                    <th class="desktop">Action</th>

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

                            <div class="form-group form-md-line-input "><?php echo $rowfilter['question']; ?> 
                            </div>
                        </td>
                        <td>

                            <div class="form-group form-md-line-input "><?php echo $rowfilter['option1']; ?> 
                            </div>
                        </td>
                        <td>

                            <div class="form-group form-md-line-input "><?php echo $rowfilter['option2']; ?> 
                            </div>
                        </td>
                        <td>

                            <div class="form-group form-md-line-input "><?php echo $rowfilter['option3']; ?> 
                            </div>
                        </td>
                        <td>

                            <div class="form-group form-md-line-input "><?php echo $rowfilter['option4']; ?> 
                            </div>
                        </td>
                        <td>

                            <div class="form-group form-md-line-input ">Option <?php echo $rowfilter['rightAnswer']; ?> 
                            </div>
                        </td>
                        <td>

                            <div class="form-group form-md-line-input "><?php echo $rowfilter['questionMarks']; ?> 
                            </div>
                        </td>

                        <td>

                            <div class="form-group form-md-line-input "> 

                                <a class="btn blue" onClick="javascript: return setEditdata('<?php echo $rowfilter['questionId']; ?>');"  title="Edit"><i class="fa fa-edit iconshowFirst"></i></a> 

                                <a  class="btn blue" onClick="javascript: return deletedata('Delete', '<?php echo $rowfilter['questionId']; ?>');"   title="Delete"><i class="fa fa-trash-o iconshowFirst"></i></a>

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