<?php
error_reporting(0);
include('../common.php');
include('IsLogin.php');
$connect = new connect();
include ('User_Paging.php');

if ($_POST['action'] == 'ListUser') {
    $where = "where 1=1";
    $date = date('d-m-Y');
//    $where .= " and agentId='".$_SESSION['elisionloginid']."'";
    if (isset($_REQUEST['formDate']) && $_REQUEST['formDate'] != '') {
        $where.=" and STR_TO_DATE(PaidDate,'%d-%m-%Y')>= STR_TO_DATE('" . $_REQUEST['formDate'] . "','%d-%m-%Y')";
    }
    if (isset($_REQUEST['toDate']) && $_REQUEST['toDate'] != '') {
        $where.=" and STR_TO_DATE(PaidDate,'%d-%m-%Y')<=STR_TO_DATE('" . $_REQUEST['toDate'] . "','%d-%m-%Y')";
    }
    if (isset($_REQUEST['applicatipnNo']) && $_REQUEST['applicatipnNo'] != '') {
        $where.=" and application.applicatipnNo  like '" . $_REQUEST['applicatipnNo'] . "' ";
    }
    if ($_SESSION['Designation'] == 4) {
        if ($_REQUEST['EmployeeId'] != NULL && isset($_REQUEST['EmployeeId'])) {
            $whereEmp.=" and application.agentId='" . $_REQUEST['EmployeeId'] . "'";
        } else {
            $whereEmp.=" and application.agentId in (select elisionloginid from employee where iteamleadid='" . $_SESSION['EmployeeId'] . "')";
        }
    } else {
        $whereEmp .= " and agentId='" . $_SESSION['elisionloginid'] . "'";
    }
    $filterstr = "SELECT * FROM `application` inner join application_payment_history on  application.iAppId=application_payment_history.application_id " . $where . $whereEmp . " and application.isPaid=1 and application.isDelete='0'  and  application.iStatus='1' order by iAppId desc";
    $countstr = "SELECT count(*) as TotalRow FROM `application` inner join application_payment_history on  application.iAppId=application_payment_history.application_id  " . $where . $whereEmp . " and application.isPaid=1 and application.isDelete='0' and  application.istatus='1' ";
    
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
        <link href="<?php echo $web_url; ?>Employee/global/plugins/datatables/datatables.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo $web_url; ?>Employee/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css" rel="stylesheet" type="text/css" />
        <script src="<?php echo $web_url; ?>Employee/global/plugins/datatables/datatables.js" type="text/javascript"></script>
        <script src="<?php echo $web_url; ?>Employee/global/plugins/datatables/table-datatables-responsive.js" type="text/javascript"></script>

        <table class="table table-bordered table-hover center table-responsive" width="100%" id="tableC">
            <thead class="tbg">
                <tr>
                    <th class="pop_in_heading">Loan Application No</th>
                    <th class="pop_in_heading">Customer Name</th>
                    <!--<th class="pop_in_heading">Customer City</th>-->
                    <th class="pop_in_heading">POS Amount</th>
                    <th class="pop_in_heading">Paid Amount</th>
                    <th class="pop_in_heading">Paid Date</th>
                    <!--<th class="pop_in_heading">EMI Amount</th>-->
                    <!--<th class="pop_in_heading">Agency Name</th>-->
                    <!--<th class="pop_in_heading">FOS Name</th>-->
                    <!--<th class="pop_in_heading">FOS Contact</th>-->
                </tr>
            </thead>
            <tbody>
                <?php
                while ($rowfilter = mysqli_fetch_array($resultfilter)) {
                    ?>
                    <tr>
            <!--                        <td>
                            <div class="form-group form-md-line-input "><?php // echo $rowfilter['agentId'];   ?> 
                            </div>
                        </td> -->
                        <td>
                            <div class="form-group form-md-line-input "><?php echo $rowfilter['applicatipnNo']; ?>                           
                            </div>
                        </td>
                        <td>
                            <div class="form-group form-md-line-input "><?php echo $rowfilter['customerName']; ?>                           
                            </div>
                        </td>
                        <!--<td>
                            <div class="form-group form-md-line-input "><?php echo $rowfilter['customerCity']; ?>                           
                            </div>
                        </td>-->
                        <td>
                            <div class="form-group form-md-line-input "><?php echo $rowfilter['loanAmount']; ?>                           
                            </div>
                        </td>
                        <td>
                            <div class="form-group form-md-line-input "><?php echo $rowfilter['paid_amount']; ?>                           
                            </div>
                        </td>
                        <td>
                            <div class="form-group form-md-line-input "><?php echo date('d-m-Y',strtotime($rowfilter['PaidDate'])); ?>
                            </div>
                        </td>
                        <!--<td>
                            <div class="form-group form-md-line-input "><?php echo $rowfilter['EMIAmount']; ?>                           
                            </div>
                        </td>
                        <td>
                            <div class="form-group form-md-line-input "><?php echo $rowfilter['agencyName']; ?> 
                            </div>
                        </td>
                        <td>
                            <div class="form-group form-md-line-input "><?php echo $rowfilter['FOSName']; ?>                           
                            </div>
                        </td>
                        <td>
                            <div class="form-group form-md-line-input "><?php echo $rowfilter['FosNumber']; ?> 
                            </div>
                        </td>-->
                    </tr>
                    <?php
                }
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