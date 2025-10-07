<?php

error_reporting(0);

include('../common.php');

include('IsLogin.php');

$connect = new connect();

include ('User_Paging.php');




if ($_POST['action'] == 'ListUser') {

    $where = "where 1=1 ";



   $filterstr = "SELECT *,(select empname from employee where employee.employeeid=complainticket.complainBy and isDelete=0)as empname,(select categoryName FROM `ticketcategory` where isDelete='0' and istatus='1' and ticketCategoryId =complainticket.ticketCategoryId )as categoryName from complainticket where ticketStatus='1' and istatus='1' and isDelete='0' ORDER by STR_TO_DATE(closeDate,'%d-%m-%Y') DESC";
    $countstr = "SELECT * from complainticket where ticketStatus='1' and istatus='1' and isDelete='0'";
    $resrowcount = mysqli_query($dbconn, $countstr);
    $resrowc = mysqli_fetch_array($resrowcount);



    $resrowcount = mysqli_query($dbconn,$countstr);

    $resrowc = mysqli_fetch_array($resrowcount);

    $totalrecord = $resrowc['TotalRow'];

    $per_page = $cateperpaging;

    $total_pages = ceil($totalrecord / $per_page);

    $page = $_REQUEST['Page'] - 1;

    $startpage = $page * $per_page;

    $show_page = $page + 1;







    $filterstr = $filterstr . " LIMIT $startpage, $per_page";

// echo $filterstr;





    $resultfilter = mysqli_query($dbconn,$filterstr);

    if (mysqli_num_rows($resultfilter) > 0) {

        $i = 1;

        ?>  

   
  <form  role="form"  method="POST"  action="" name="frmparameter"  id="frmparameter" enctype="multipart/form-data">
   <input type="hidden" value="AddAssignExam" name="action" id="action">
   <input type="hidden" value="<?=$_REQUEST['examId'];?>" name="examId" id="examId">
        <table class="table table-bordered table-hover center table-responsive" width="100%" id="tableC">

            <thead class="tbg">

                <tr style="background: #3f4296;">

                    <th class="all"style="color: #fff;">Sr No.</th>
                    <th class="all"style="color: #fff;">Complain By</th>
                    <th class="all"style="color: #fff;">Ticket Category</th>
                    <th class="all"style="color: #fff;">Ticket Id</th>
                    <th class="all"style="color: #fff;">Floor Asset</th>
                    <th class="all"style="color: #fff;">Complain</th>
                    <th class="all"style="color: #fff;">Complain Date</th>
                    <th class="all"style="color: #fff;">Status</th>
                    <th class="all"style="color: #fff;">Solution</th>
                    <th class="all"style="color: #fff;">Solution Date</th>
                   
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
                               <?php echo $rowfilter['floorAsset']; ?>

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
                                $ticketStatus="Closed";

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
                    </tr>

                    <?php

                 $i++; }

                ?>

            </tbody>

        </table>

</form>

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

?>

<script type="text/javascript">
    
                                    function CheckAll()
                                    {

                                        if ($('#check_listall').is(":checked"))
                                        {
                                            // alert('cheked');
                                            $('input[type=checkbox]').each(function () {
                                                $(this).prop('checked', true);
                                            });
                                        } else
                                        {
                                            //alert('cheked fail');
                                            $('input[type=checkbox]').each(function () {
                                                $(this).prop('checked', false);
                                            });
                                        }
                                    }

  


            $('#frmparameter').submit(function (e) {

                e.preventDefault();
              
                var $form = $(this);

                $('#loading').css("display", "block");
                $.ajax({
                    type: 'POST',
                    url: '<?php echo $web_url; ?>Employee/querydata.php',
                    data: $('#frmparameter').serialize(),
                    success: function (response) {
                        console.log(response);
                        if (response == 1) {
                            $('#loading').css("display", "none");
                            $("#Btnmybtn").attr('disabled', 'disabled');
                            alert('Added Assigned User Sucessfully.');
                            window.location.href = '';
                        }else {
                            $('#loading').css("display", "none");
                            $("#Btnmybtn").attr('disabled', 'disabled');
                            alert('Invalid Request.');
                            window.location.href = '';

                        }

                    }

                });

            });

</script>