<?php
error_reporting(0);
include('../common.php');
include('IsLogin.php');
$connect = new connect();
include ('User_Paging.php');

if ($_POST['action'] == 'ListUser') {
    $where = "where 1=1";
    
    if (isset($_REQUEST['searchFeedback']) && $_REQUEST['searchFeedback'] != '') {
        $where.=" and onlinefeedback.feedbackId='" . $_REQUEST['searchFeedback'] . "'";
    } 
    // else {
    //     $where.=" and STR_TO_DATE(customerfeedback.strEntryDate,'%d-%m-%Y')>= STR_TO_DATE('" . $date . "','%d-%m-%Y')";
    // }
    if (isset($_REQUEST['toDate']) && $_REQUEST['toDate'] != '') {
        $where.=" and STR_TO_DATE(onlinefeedback.strEntryDate,'%d-%m-%Y')<=STR_TO_DATE('" . $_REQUEST['toDate'] . "','%d-%m-%Y')";
    }
    
    $filterstr = "SELECT 
(select historyfeedback.strEntryDate from historyfeedback where historyfeedback.feedbackId=onlinefeedback.feedbackId ORDER by historyfeedback.historyFeedbackId asc limit 1) as RaisedDate,
(select employee.empname from employee where employee.employeeid=onlinefeedback.complainBy) as FeedbackFrom,
(select employee.empname from employee where employee.employeeid=onlinefeedback.agentId) as FeedbackTo,
(select employee.elisionloginid from employee where employee.employeeid=onlinefeedback.agentId) as elisionloginid,
(select tl.empname from employee inner join employee as tl on employee.iteamleadid=tl.employeeid where employee.employeeid=onlinefeedback.agentId) as AgentTl,
(select feedbackcategory.categoryName from feedbackcategory where feedbackcategory.feedbackCategoryId=onlinefeedback.feedbackCategoryId) as FeedbackCategory,
comment,
CASE 
	WHEN status = 1 THEN 'Pending'
    WHEN status = 2 THEN 'Disputed'
    WHEN status = 3 THEN 'Closed'
    ELSE 'Unknown'
END AS Status,
(select employee.empname from historyfeedback inner join employee on  historyfeedback.statusby=employee.employeeid where historyfeedback.feedbackId=onlinefeedback.feedbackId and historyfeedback.status=2 order by historyfeedback.historyFeedbackId desc limit 1) AS Disputedfrom,
(select historyfeedback.historyComment from historyfeedback where historyfeedback.feedbackId=onlinefeedback.feedbackId and historyfeedback.status=2 order by historyfeedback.historyFeedbackId desc limit 1) AS DisputedComment,
(select historyfeedback.strEntryDate from historyfeedback where historyfeedback.feedbackId=onlinefeedback.feedbackId and historyfeedback.status=2 order by historyfeedback.historyFeedbackId desc limit 1)  AS DisputedDate,
onlinefeedback.strEntryDate,statusDate,feedbackId
 FROM `onlinefeedback` " . $where . " and isDelete=0 and istatus=1 order by STR_TO_DATE(onlinefeedback.strEntryDate,'%d-%m-%Y') DESC";
    $countstr = "SELECT count(*) as TotalRow FROM `onlinefeedback` " . $where . " and isDelete=0 and istatus=1";

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
        <div class="table-responsive">
            <table class="table table-bordered table-hover center table-responsive" width="100%" id="tableC">
                <thead class="tbg">
                    <tr>
                        <th class="pop_in_heading">Sr. No.</th>
                        <th class="pop_in_heading">Feedback Id</th>
                        <th class="pop_in_heading">Raised Date</th>
                        <th class="pop_in_heading">Feedback From</th>
                        <th class="pop_in_heading">Feedback To</th>
                        
                        <th class="pop_in_heading">Elision Id</th>
                        <th class="pop_in_heading">Agent TL</th>
                        <th class="pop_in_heading">Feedback Category</th>
                        <th class="pop_in_heading">Feedback Comment</th>
                        <th class="pop_in_heading">Disputed</th>
                        <th class="pop_in_heading">Disputed From</th>
                        <th class="pop_in_heading">Disputed Date</th>
                        <th class="pop_in_heading">Disputed Comment</th>
                        <th class="pop_in_heading">Closed</th>
                        <th class="pop_in_heading">Closure Date</th>
                        <th class="pop_in_heading">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;
                    while ($rowfilter = mysqli_fetch_array($resultfilter)) {
                        ?>
                        <tr>
                            <td>
                                <div class="form-group form-md-line-input ">
                                    <?php echo $i; ?>
                                </div>
                            </td>
                            
                            <td>
                                <div class="form-group form-md-line-input ">
                                    <?php echo $rowfilter['feedbackId']; ?>
                                </div>
                            </td>
                            <td>
                                <div class="form-group form-md-line-input ">
                                    <?php echo $rowfilter['RaisedDate']; ?>
                                </div>
                            </td>
                            <td>
                                <div class="form-group form-md-line-input ">
                                    <?php echo $rowfilter['FeedbackFrom']; ?>
                                </div>
                            </td>
                            <td>
                                <div class="form-group form-md-line-input ">
                                   <?php echo $rowfilter['FeedbackTo']; ?>
                                </div>
                            </td>
                            
                            <td>
                                <div class="form-group form-md-line-input ">
                                   <?php echo $rowfilter['elisionloginid']; ?>
                                </div>
                            </td>
                            <td>
                                <div class="form-group form-md-line-input ">
                                   <?php echo $rowfilter['AgentTl']; ?>
                                </div>
                            </td>
                            <td>
                                <div class="form-group form-md-line-input ">
                                    <?php echo $rowfilter['FeedbackCategory']; ?>
                                </div>
                            </td>
                            
                            <td>
                                <div class="form-group form-md-line-input ">
                                   <?php echo $rowfilter['comment']; ?>
                                </div>
                            </td>
                            <td>
                                <div class="form-group form-md-line-input ">
                                    <?php if($rowfilter['DisputedComment'] != ''){
                                        echo "Yes";
                                    } else {
                                       echo "No";
                                    } ?>
                                </div>
                            </td>
                            <td>
                                <div class="form-group form-md-line-input ">
                                   <?php 
                                        echo $rowfilter['Disputedfrom']; 
                                    ?>
                                </div>
                            </td>
                            <td>
                                <div class="form-group form-md-line-input ">
                                    <?php 
                                        echo $rowfilter['DisputedDate']; 
                                    ?>
                                </div>
                            </td>
                            <td>
                                <div class="form-group form-md-line-input ">
                                    <?php echo $rowfilter['DisputedComment']; ?>
                                </div>
                            </td>
                            <td>
                                <div class="form-group form-md-line-input ">
                                    <?php 
                                    if($rowfilter['Status'] == 'Closed'){
                                        echo "Yes";
                                    } else {
                                       echo "No";
                                    } ?>
                                </div>
                            </td>
                            <td>
                                <div class="form-group form-md-line-input ">
                                    <?php if($rowfilter['Status'] == 'Closed'){
                                        echo $rowfilter['statusDate']; 
                                    } else {
                                       echo "-";
                                    } ?>
                                </div>
                            </td>
                            <td>
                                <div class="form-group form-md-line-input ">
                                     <a onclick="DeleteHistory('Delete','<?php echo $rowfilter['feedbackId']; ?>');"  title="Delete" style="font-size:25px;"><i class="fa fa-trash"></i></a>
                                </div>
                            </td>
                        </tr>
                        <?php
                        $i++;
                    }
                    ?>
                </tbody>
            </table>
        </div>
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
        "strEntryDate" =>date('d-m-Y H:i:s')
    );
    $where = ' where feedbackId=' . $_REQUEST['ID'];
    $dealer_res = $connect->deleterecord($dbconn,'onlinefeedback',$where);
    //$dealer_res = $connect->updaterecord($dbconn,'onlinefeedback', $data, $where);
    
    $where = ' where feedbackId=' . $_REQUEST['ID'];
    $dealer_res = $connect->deleterecord($dbconn,'historyfeedback',$where);
    //$dealer_res = $connect->updaterecord($dbconn,'historyfeedback', $data, $where);
    
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