<?php

error_reporting(0);

include('../common.php');

include('IsLogin.php');

$connect = new connect();

include ('User_Paging.php');



if ($_POST['action'] == 'ListUser') {

    $where = "where 1=1 ";

 $filterstr =" SELECT *,(select empname from employee where employee.employeeid=historyfeedback.statusby and isDelete=0)as complainByName  FROM historyfeedback WHERE feedbackId='".$_REQUEST['feedbackId']."' ORDER by historyFeedbackId ASC";
   





    

// echo $filterstr;





    $resultfilter = mysqli_query($dbconn,$filterstr);

    //if (mysqli_num_rows($resultfilter) > 0) {
        //echo "welcome";
        $i = 1;

        ?>  

   
  <form  role="form"  method="POST"  action="" name="frmparameter"  id="frmparameter" enctype="multipart/form-data">
   <!-- <input type="hidden" value="AddAssignExam" name="action" id="action">
   <input type="hidden" value="<?=$_REQUEST['examId'];?>" name="examId" id="examId">
    -->    
     <table class="table table-bordered table-hover center table-responsive" width="100%" id="tableC">

            <thead class="tbg">

                <tr style="background: #3f4296;">

                    <th class="all"style="color: #fff;">Sr No.</th>
                    <th class="all"style="color: #fff;">Feedback By</th>
                    <!-- <th class="all"style="color: #fff;">Ticket Id</th> -->
                    <th class="all"style="color: #fff;">Feedback Comment</th>
                    <th class="all"style="color: #fff;">Feedback Comment Date & Time</th>
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
                            <?php echo $rowfilter['complainByName']; ?>

                            </div>

                        </td>

                      
                        <td>

                            <div class="form-group form-md-line-input ">
                               <?php echo $rowfilter['historyComment']; ?>

                            </div>

                        </td>

                        <td>

                            <div class="form-group form-md-line-input ">
                               <?php echo $rowfilter['strEntryDate']; ?>

                            </div>

                        </td>


                    </tr>

                    <?php

                 $i++; }

                ?>

            </tbody>

        </table>
</form>
 <?php

        

         if ($totalrecord > $per_page) { ?>

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



        <?php

            //} else {

        ?>
<!-- 
        <div class="row">

            <div class="col-lg-12 col-md-12  col-xs-12 col-sm-12 padding-5 bottom-border-verydark">

                <div class="alert alert-info clearfix profile-information padding-all-10 margin-all-0 backgroundDark">

                    <h1 class="font-white text-center"> No Data Found ! </h1>

                </div>   

            </div>

        </div>
 -->
        <?php

    //}

}


?>

