<?php
ob_start();
include('../common.php');

include('IsLogin.php');

$connect = new connect();

include ('User_Paging.php');



if ($_POST['action'] == 'ListUser') {



    $where = "where 1=1 ";

    $date = date('d-m-Y');

    $whereEmp = "";

    if ($_REQUEST['EmployeeId'] != NULL && isset($_REQUEST['EmployeeId'])) {

        $whereEmp.=" and elisionloginid='" . $_REQUEST['EmployeeId'] . "'";

    }else{

        $whereEmp.=" and elisionloginid='" . $_SESSION['elisionloginid'] . "'";

    }

    

    if (isset($_REQUEST['formDate']) && $_REQUEST['formDate'] != '') {

        $where.=" and STR_TO_DATE(EntryDate,'%d-%m-%Y')>= STR_TO_DATE('" . $_REQUEST['formDate'] . "','%d-%m-%Y')";

    } else {

        $where.=" and STR_TO_DATE(EntryDate,'%d-%m-%Y')>= STR_TO_DATE('" . $date . "','%d-%m-%Y')";

    }

    if (isset($_REQUEST['toDate']) && $_REQUEST['toDate'] != '') {

        $where.=" and STR_TO_DATE(EntryDate,'%d-%m-%Y')<=STR_TO_DATE('" . $_REQUEST['toDate'] . "','%d-%m-%Y')";

    } 

//    else {

//        $where.=" and STR_TO_DATE(EntryDate,'%d-%m-%Y')<=STR_TO_DATE('" . $date . "','%d-%m-%Y')";

//    }



    $filterstr = "SELECT * FROM `dailyupdate`  " . $where . $whereEmp. " and isDelete='0'  and istatus=1 order by dailyupdateid  desc";

    $countstr = "SELECT count(*) as TotalRow, max(displayColumn) as MaxCount FROM `dailyupdate`   " . $where . $whereEmp." and isDelete='0' and istatus=1";



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

        $i = 0;

        ?>

        <link href="<?php echo $web_url; ?>Employee/global/plugins/datatables/datatables.css" rel="stylesheet" type="text/css" />

        <link href="<?php echo $web_url; ?>Employee/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css" rel="stylesheet" type="text/css" />

        <script src="<?php echo $web_url; ?>Employee/global/plugins/datatables/datatables.js" type="text/javascript"></script>

        <script src="<?php echo $web_url; ?>Employee/global/plugins/datatables/table-datatables-responsive.js" type="text/javascript"></script>

        <?php

        while ($rowUpdate = mysqli_fetch_array($resultfilter)) {

            $timestamp = strtotime($rowUpdate['date']);

            $day = date('l', $timestamp);

            

            ?>

            <table class="table table-bordered table-hover center table-responsive" width="100%" id="tableC">

                <thead class="tbg">

                    <tr class="bg_color_tr">

                        <th class="all">Elision id</th>

                        <?php

                        $filterHeader =  mysqli_fetch_array(mysqli_query($dbconn, "SELECT * FROM `dailyupdate`  " . $where . " and isHeader=1  and isDelete='0'  and istatus=1 order by dailyupdateid  desc"));

                        

                        if($filterHeader['isHeader'] == 1){

                            ?>

                            <th class="desktop"><?php echo $filterHeader['col1'] ?></th>

                            <th class="desktop"><?php echo $filterHeader['col2'] ?></th>

                            <th class="desktop"><?php echo $filterHeader['col3'] ?></th>

                            <th class="desktop"><?php echo $filterHeader['col4'] ?></th>

                            <th class="desktop"><?php echo $filterHeader['col5'] ?></th>

                            <th class="desktop"><?php echo $filterHeader['col6'] ?></th>

                            <th class="desktop"><?php echo $filterHeader['col7'] ?></th>

                            <th class="desktop"><?php echo $filterHeader['col8'] ?></th>

                            <th class="desktop"><?php echo $filterHeader['col9'] ?></th>

                            <th class="desktop"><?php echo $filterHeader['col10'] ?></th>

                        <?php // } 

                        }?>

                            

                        <th class="desktop">Entry Date</th>                  

                    </tr>

                </thead>

                <tbody>

                    <?php

//                    while ($rowfilter = mysqli_fetch_array($resultfilter)) {

                        print_r($rowfilter);

                        ?>

                        <tr>

                            <td>

                                <div class="form-group form-md-line-input "><?php echo $rowUpdate['elisionloginid']; ?> 

                                </div>

                            </td>

                            <?php

                            if($filterHeader['isHeader'] == 0){

                                ?>

                                <td>

                                    <div class="form-group form-md-line-input "><?php echo $rowUpdate['col1']; ?>

                                    </div>

                                </td>

                                <td>

                                    <div class="form-group form-md-line-input "><?php echo $rowUpdate['col2']; ?>

                                    </div>

                                </td>

                                <td>

                                    <div class="form-group form-md-line-input "><?php echo $rowUpdate['col3']; ?>

                                    </div>

                                </td>

                                <td>

                                    <div class="form-group form-md-line-input "><?php echo $rowUpdate['col4']; ?>

                                    </div>

                                </td>

                                <td>

                                    <div class="form-group form-md-line-input "><?php echo $rowUpdate['col5']; ?>

                                    </div>

                                </td>

                                <td>

                                    <div class="form-group form-md-line-input "><?php echo $rowUpdate['col6']; ?>

                                    </div>

                                </td>

                                <td>

                                    <div class="form-group form-md-line-input "><?php echo $rowUpdate['col7']; ?>

                                    </div>

                                </td>

                                <td>

                                    <div class="form-group form-md-line-input "><?php echo $rowUpdate['col8']; ?>

                                    </div>

                                </td>

                                <td>

                                    <div class="form-group form-md-line-input "><?php echo $rowUpdate['col9']; ?>

                                    </div>

                                </td>

                                <td>

                                    <div class="form-group form-md-line-input "><?php echo $rowUpdate['col10']; ?>

                                    </div>

                                </td>

                            <?php } ?>

                            <td>

                                <div class="form-group form-md-line-input "><?php echo $rowUpdate['EntryDate']; ?> 

                                </div>

                            </td>   

                            <?php

//                        }

                        ?>

                    </tr>

                </tbody>

            </table>

            <?php

        }

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