<?php
ob_start();
include('../common.php');
include('IsLogin.php');
$connect = new connect();
include ('User_Paging.php');


if ($_POST['action'] == 'ListUser') {

    $where = "where 1=1 ";

    if (isset($_REQUEST['process'])) {

        if ($_POST['process'] != '') {

            $where.=" and  ep.iProcessId =".$_POST['process']."";

        }

    }
    
    if (isset($_REQUEST['designationid'])) {

        if ($_POST['designationid'] != '') {

            $where.=" and  ed.iDesignationId =".$_POST['designationid']."";

        }

    }

    $filterstr = "SELECT * FROM `employee` e inner join employeedesignation ed on e.employeeid=ed.iEmployeeId inner join employeeprocess ep on e.employeeid=ep.iEmployeeId ".$where." and ed.iDesignationId in (5,4,1,9,12,18) and e.isDelete=0 and e.istatus=1 and e.employeeid not in (SELECT userId FROM `examassigneduser` where examId ='".$_REQUEST['examId']."') ORDER BY e.empname ASC";

    $countstr = "SELECT count(*) as TotalRow FROM `employee` e inner join employeedesignation ed on e.employeeid=ed.iEmployeeId inner join employeeprocess ep on e.employeeid=ep.iEmployeeId ".$where." and ed.iDesignationId in (5,4,1,9,12,18) and e.isDelete=0 and e.istatus=1 and e.employeeid not in (SELECT userId FROM `examassigneduser`where examId ='".$_REQUEST['examId']."')";



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


                         <th class="all" style="color: #fff;">
                                 <div class="md-checkbox">
                                <input type="checkbox"  onclick="javascript:CheckAll();" id="check_listall" class="md-check" value="">
                                    <label for="check_listall">
                                        <span></span>
                                        <span class="check"></span>
                                        <span class="box"></span>
                                    </label>
                                </div>
                        </th>


                     <th class="all" style="color: #fff;">Sr.No</th>

                     <th class="desktop" style="color: #fff;">User Name</th>

                   

                </tr>

            </thead>

            <tbody>

                <?php

                while ($rowfilter = mysqli_fetch_array($resultfilter)) {

                    ?>

                    <tr>
                        <td> <div class="form-group form-md-line-input "> <input type="checkbox" name="empid[]" value="<?php echo $rowfilter['employeeid'];?>" class="multiCheckBox"></div></td>

                        <td>

                            <div class="form-group form-md-line-input ">
                            <?php echo $i;?></div>

                        </td>

                        <td>

                            <div class="form-group form-md-line-input "><?php echo $rowfilter['empname']; ?> 

                            </div>

                        </td>


                        
                        


                        <?php

                   $i++; }

                    ?>



             
    
</tr>
</tbody>
</table>
<input type="hidden" name="counter" value="<?=$i?>">
<input class="btn blue margin-top-20" type="submit"  value="Submit" name="submit"> 
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