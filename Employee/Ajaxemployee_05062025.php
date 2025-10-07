<?php
error_reporting(0);
include('../common.php');
include('IsLogin.php');
$connect = new connect();
include ('User_Paging.php');

if ($_POST['action'] == 'ListUser') {
    $where = "where 1=1";
    if (isset($_REQUEST['Search_Txt'])) {
        if ($_POST['Search_Txt'] != '') {
            $where.=" and  empname like '%$_POST[Search_Txt]%'";
        }
    }

    $filterstr = "SELECT * FROM `employee`  " . $where . " and isDelete='0'  and  istatus='1' order by elisionloginid asc";
    $countstr = "SELECT count(*) as TotalRow FROM `employee`  " . $where . " and isDelete='0' and  istatus='1' ";

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

        <table class="table table-striped table-bordered table-hover dt-responsive" width="100%" id="tableC">
            <thead class="tbg">
                <tr>
                    <th class="pop_in_heading">Name</th>
                    <th class="pop_in_heading">Designation</th>
                    <th class="pop_in_heading">Date Of Join</th>
                    <th class="pop_in_heading">Contact Number</th>
                    <th class="pop_in_heading">Astute Number</th> 
                    <th class="pop_in_heading">Process</th> 
                    <th class="pop_in_heading">Elision Login Id</th> 
                    <th class="pop_in_heading">Team Lead</th> 
                    <th class="pop_in_heading">Quality Analist</th> 
                    <th class="pop_in_heading">AsstManager</th> 
                    <th class="pop_in_heading">Process Manager</th> 
                    <th class="pop_in_heading">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($rowfilter = mysqli_fetch_array($resultfilter)) {
                    ?>
                    <tr>
                        <td>
                            <div class="form-group form-md-line-input "><?php echo $rowfilter['empname']; ?> 
                            </div>
                        </td> 
                        <td>
                            <div class="form-group form-md-line-input "><?php 
                                $filterDesignation = mysqli_fetch_array(mysqli_query($dbconn, "select designation.designation from employeedesignation inner join designation on designation.designationid = employeedesignation.iDesignationId where iEmployeeId='".$rowfilter['employeeid']."' "));
                                echo $filterDesignation['designation'];
                            ?> 
                            </div>
                        </td>
                        <td>
                            <div class="form-group form-md-line-input "><?php echo $rowfilter['dojoin']; ?>                           
                            </div>
                        </td>
                        <td>
                            <div class="form-group form-md-line-input "><?php echo $rowfilter['contactnumber']; ?> 
                            </div>
                        </td>
                        <td>
                            <div class="form-group form-md-line-input "><?php echo $rowfilter['astutenumber']; ?> 
                            </div>
                        </td>
                        <td>
                            <?php
                            $Process = mysqli_fetch_array(mysqli_query($dbconn, "SELECT * FROM `processmaster`  where isDelete='0'  and  istatus='1' and processmasterid='" . $rowfilter['iProcessid'] . "' "));
                            ?>
                            <div class="form-group form-md-line-input "><?php echo $Process['processname']; ?> 
                            </div>
                        </td>
                        <td>
                            <div class="form-group form-md-line-input "><?php echo $rowfilter['elisionloginid']; ?> 
                            </div>
                        </td>
                        <td>
                            <?php
                            $teamlead = mysqli_fetch_array(mysqli_query($dbconn, "SELECT * FROM `employee`  where isDelete='0'  and  istatus='1' and employeeid='" . $rowfilter['iteamleadid'] . "' "));
                            ?>
                            <div class="form-group form-md-line-input "><?php echo $teamlead['empname']; ?> 
                            </div>
                        </td>
                        <?php
                        $qualityanalist = mysqli_fetch_array(mysqli_query($dbconn, "SELECT * FROM `employee`  where isDelete='0'  and  istatus='1' and employeeid='" . $rowfilter['qualityanalistid'] . "' "));
                        ?>
                        <td>
                            <div class="form-group form-md-line-input "><?php echo $qualityanalist['empname']; ?> 
                            </div>
                        </td>
                        <?php
                        $asstmanagerid = mysqli_fetch_array(mysqli_query($dbconn, "SELECT * FROM `employee`  where isDelete='0'  and  istatus='1' and employeeid='" . $rowfilter['asstmanagerid'] . "' "));
                        ?>
                        <td>
                            <div class="form-group form-md-line-input "><?php echo $asstmanagerid['empname']; ?> 
                            </div>
                        </td>
                        <?php
                        $processmanager = mysqli_fetch_array(mysqli_query($dbconn, "SELECT * FROM `employee`  where isDelete='0'  and  istatus='1' and employeeid='" . $rowfilter['processmanager'] . "' "));
                        ?>
                        <td>
                            <div class="form-group form-md-line-input "><?php echo $processmanager['empname']; ?> 
                            </div>
                        </td>
                        <td style="width: 20%">
                            <div class="form-group form-md-line-input">
                                <!--<a  class="btn blue" href="<?php echo $web_url; ?>Employee/employeeChangePassword.php?token=<?php // echo $rowfilter['employeeid']; ?>" title="Change Password"><i class="fa-key fa"></i></a>-->
                                <a  class="btn blue" href="<?php echo $web_url; ?>Employee/Editemployee.php?token=<?php echo $rowfilter['employeeid']; ?>" title="Edit"><i class="fa fa-edit iconshowFirst"></i></i></a>
                                <a  class="btn blue" onClick="javascript: return deletedata('Delete', '<?php echo $rowfilter['employeeid']; ?>');"   title="Delete"><i class="fa fa-trash-o iconshowFirst"></i></a>
                            </div>
                        </td>
                        <?php
                    }
                    ?>
                </tr>
            </tbody>
        </table>
        <script src="<?php echo $web_url; ?>Employee/global/plugins/datatables/datatables.js" type="text/javascript"></script>
        <script src="<?php echo $web_url; ?>Employee/global/plugins/datatables/table-datatables-responsive.js" type="text/javascript"></script>
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
    $where = ' where employeeid=' . $_REQUEST['ID'];
    $dealer_res = $connect->updaterecord($dbconn, 'employee', $data, $where);
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