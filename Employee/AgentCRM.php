<?php
ob_start();
error_reporting(E_ALL);

include_once '../common.php';
$connect = new connect();
include('IsLogin.php');
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title><?php echo $ProjectName; ?> | CRM </title>
        <?php include_once './include.php'; ?>
        <link href="<?php echo $web_url; ?>Employee/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo $web_url; ?>Employee/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.css" rel="stylesheet" type="text/css" />
        
        
    </head>
    <!-- END HEAD -->
    <body class="page-header-fixed page-sidebar-closed-hide-logo page-content-white page-md">
        <div class="page-wrapper">
            <?php include_once './header.php'; ?>
            <div style="display: none; z-index: 10060;" id="loading">
                <img id="loading-image" src="<?php echo $web_url; ?>Employee/images/loader.gif">
            </div>
            <!-- END SIDEBAR -->
            <!-- BEGIN CONTENT -->
            <div class="page-content-wrapper">
                <!-- BEGIN CONTENT BODY -->
                <div class="page-content">
                    <div class="page-bar">
                        <ul class="page-breadcrumb">
                            <li>
                                <a href="index.php">Home</a>
                                <i class="fa fa-circle"></i>
                            </li>
                            <li>
                                <span>CRM </span>
                            </li>
                        </ul>
                        <div class="page-toolbar">
                            <div id="dashboard-report-range" class="pull-right tooltips btn btn-sm" data-container="body" data-placement="bottom" data-original-title="Change dashboard date range">
                                <i class="icon-calendar"></i>&nbsp;
                                <span class="thin uppercase hidden-xs"></span>&nbsp;
                                <i class="fa fa-angle-down"></i>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    
                    
                    <div class="row">
                        <?php
                        $filterTeamLeader = mysqli_query($dbconn, "SELECT * FROM `employeedesignation` where iEmployeeId='" . $_SESSION['EmployeeId'] . "' and iDesignationId='4' and istatus='1' and isDelete='0'");
                        if (mysqli_num_rows($filterTeamLeader) > 0) {
                            $resultfilter = mysqli_query($dbconn, "SELECT * FROM `tldeshboardmaster` where iStatus=1 and isDelete=0 and elisionloginid='" . $_SESSION['elisionloginid'] . "' and MONTH(STR_TO_DATE(date,'%d-%M-%Y'))=MONTH(CURRENT_DATE()) and YEAR(STR_TO_DATE(date,'%d-%M-%Y'))=YEAR(CURRENT_DATE())");
                            if (mysqli_num_rows($resultfilter) > 0) {
                                ?>
                                <link href="<?php echo $web_url; ?>Employee/assets/global/plugins/datatables/datatables.css" rel="stylesheet" type="text/css" />
                                <div class="col-md-5">
                                    <div class="portlet light ">
                                        <!--<div class="portlet-title">
                                            <div class="caption grey-gallery">
                                                <i class="icon-settings grey-gallery"></i>
                                                <span class="caption-subject bold uppercase">TL Dashboard</span>
                                            </div>
                                        </div>-->
                                        <table class="table table-striped table-bordered table-hover dt-responsive" style="width: 100%;" id="tableC">
                                            <thead class="tbg">
                                                <tr>
                                                    <th class="pop_in_heading">Date</th>
                                                    <th class="pop_in_heading">Login </th>
                                                    <th class="pop_in_heading">Total Agents</th>
                                                    <th class="pop_in_heading">Attendance</th>
                                                    <th class="pop_in_heading">Login Hours Target</th>
                                                    <th class="pop_in_heading">Login Hours Delivered</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                while ($rowfilter = mysqli_fetch_array($resultfilter)) {
                                                    ?>
                                                    <tr>
                                                        <td>
                                                            <?php echo $rowfilter['date']; ?> 
                                                        </td> 
                                                        <td>
                                                            <?php echo $rowfilter['elisionloginid']; ?> 
                                                        </td>
                                                        <td>
                                                            <?php echo $rowfilter['totalAgent']; ?> 
                                                        </td> 
                                                        <td>
                                                            <?php echo $rowfilter['attendance']; ?> 
                                                        </td> 
                                                        <td>
                                                            <?php echo $rowfilter['loginHoursTarget']; ?> 
                                                        </td>
                                                        <td>
                                                            <?php echo $rowfilter['loginHoursDelivered']; ?> 
                                                        </td>
                                                    </tr>
                                                    <?php
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <?php
                            }
                        }
                        ?>
                </div>
                        <?php if ($_SESSION['Designation'] == 5) { ?>
                    <div class="row">
                            <div class="portlet light ">
                                <!--<div class="portlet-title">
                                    <div class="caption grey-gallery">
                                        <i class="icon-settings grey-gallery"></i>
                                        <span class="caption-subject bold uppercase">CRM Dashboard</span>
                                    </div>
                                </div>-->
                                <div class="portlet-body">
                                    <table class="table table-bordered table-hover center table-responsive" width="100%" id="tableC">
                                        <thead class="tbg">
                                            <tr>
                                                <th class="pop_in_heading" colspan="7"></th>
                                                <th class="pop_in_heading" colspan="3">MTD</th>
                                                <th class="pop_in_heading" colspan="5">FTD</th>
                                            </tr>
                                            <tr>
                                                <th class="pop_in_heading_1">Agent <br /> Name</th>
                                                <th class="pop_in_heading_1">Total <br /> Allocation</th>
                                                <th class="pop_in_heading_1">Unpaid <br />Count</th>
                                                <th class="pop_in_heading_1">Paid <br />Count</th>
                                                <th class="pop_in_heading_1">Paid <br />Amount</th>
                                                <th class="pop_in_heading_1">PTP <br />Count</th>
                                                <th class="pop_in_heading_1">PTP <br />Amount</th>
                                                
                                                
                                                <th class="pop_in_heading_1">Attempt</th>
                                                <th class="pop_in_heading_1">Connect</th>
                                                <th class="pop_in_heading_1">Zero <br />Dial</th>
                                                <!--<th class="pop_in_heading_1">Paid Count</th>-->
                                                <!--<th class="pop_in_heading_1">PTP</th>-->
        
                                                <th class="pop_in_heading_1">Attempt</th>
                                                <th class="pop_in_heading_1">Connect</th>
                                                <th class="pop_in_heading_1">Zero <br />dial</th>
                                                <th class="pop_in_heading_1">PTP <br />Count</th>
                                                <th class="pop_in_heading_1">PTP <br />Amount</th>
                                            </tr>
                                        </thead>                      
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <?php
                                                    $filterAgent = mysqli_fetch_array(mysqli_query($dbconn, "Select empname from employee where employeeid='" . $_SESSION['EmployeeId'] . "'"));
                                                    echo $filterAgent['empname'];
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    $filterTotalLeads = mysqli_fetch_array(mysqli_query($dbconn, "SELECT count(*) as `totalCount` FROM `application` where agentId='" . $_SESSION['elisionloginid'] . "' and isWithdraw='0'"));
                                                    echo $filterTotalLeads['totalCount'];
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    $filterTotalUnpaidLeads = mysqli_fetch_array(mysqli_query($dbconn, "SELECT count(*) as `totalCount` FROM `application` where agentId='" . $_SESSION['elisionloginid'] . "' and isWithdraw='0' and isPaid='0'"));
                                                    echo $filterTotalUnpaidLeads['totalCount'];
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    $filterTotalUnpaidLeads = mysqli_fetch_array(mysqli_query($dbconn, "SELECT count(*) as `totalCount` FROM `application` where agentId='" . $_SESSION['elisionloginid'] . "' and isWithdraw='0' and isPaid='1'"));
                                                    echo $filterTotalUnpaidLeads['totalCount'];
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    $filterTotalUnpaidLeads = mysqli_fetch_array(mysqli_query($dbconn, "SELECT sum(paid_amount) as `paid_amount` FROM `application` inner join application_payment_history on application.iAppId=application_payment_history.application_id where agentId='" . $_SESSION['elisionloginid'] . "' and application.isWithdraw='0' and application.isPaid='1'"));
                                                    echo $filterTotalUnpaidLeads['paid_amount'];
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    $filterTotalUnpaidLeads = mysqli_fetch_array(mysqli_query($dbconn, "SELECT count(*) as `totalCount` FROM application a LEFT JOIN applicationfollowup f ON a.iAppLogId = f.iAppLogId where a.agentId='" . $_SESSION['elisionloginid'] . "' and a.isWithdraw='0' and a.isPaid = 0 AND a.isDelete = 0 AND a.iStatus = 1  AND f.iAppLogId = (SELECT ff.iAppLogId FROM applicationfollowup ff WHERE ff.iAppLogId = a.iAppLogId ORDER BY STR_TO_DATE(ff.strEntryDate, '%d-%m-%Y') DESC LIMIT 1)  AND f.mainDispoId = 12"));
                                                    echo $filterTotalUnpaidLeads['totalCount'];
                                                    ?>
                                                </td>
                                                
                                                <td>
                                                    <?php
                                                    $filterTotalUnpaidLeads = mysqli_fetch_array(mysqli_query($dbconn, "SELECT sum(PTP_Amount) as `PTP_Amount` FROM `application` a LEFT JOIN applicationfollowup f ON a.iAppLogId = f.iAppLogId where a.agentId='" . $_SESSION['elisionloginid'] . "' and a.isWithdraw='0' and a.isPaid = 0 AND a.isDelete = 0 AND a.iStatus = 1  AND f.iAppLogId = (SELECT ff.iAppLogId FROM applicationfollowup ff WHERE ff.iAppLogId = a.iAppLogId ORDER BY STR_TO_DATE(ff.strEntryDate, '%d-%m-%Y') DESC LIMIT 1)  AND f.mainDispoId = 12"));
                                                    echo $filterTotalUnpaidLeads['PTP_Amount'] ?? 0;
                                                    ?>
                                                </td>
                                                <!---------------------------------- MTD ----------------------------------->
                                                <td>
                                                    <?php
                                                    $filterTotalAttemptLeads = mysqli_fetch_array(mysqli_query($dbconn, "SELECT count(*) as `totalCount` FROM `applicationfollowup` where iAppId IN (select iAppId from application where agentId='" . $_SESSION['elisionloginid'] . "' and isWithdraw='0') and MONTH(STR_TO_DATE(strEntryDate,'%d-%m-%Y'))=MONTH(CURRENT_DATE()) and YEAR(STR_TO_DATE(strEntryDate,'%d-%m-%Y'))=YEAR(CURRENT_DATE())"));
                                                    echo $filterTotalAttemptLeads['totalCount'];
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    $filterTotalConnectLeads = mysqli_fetch_array(mysqli_query($dbconn, "SELECT count(*) as `totalCount` FROM `applicationfollowup` where iAppId IN (select iAppId from application where agentId='" . $_SESSION['elisionloginid'] . "' and isWithdraw='0') and dispoType='1' and MONTH(STR_TO_DATE(strEntryDate,'%d-%m-%Y'))=MONTH(CURRENT_DATE()) and YEAR(STR_TO_DATE(strEntryDate,'%d-%m-%Y'))=YEAR(CURRENT_DATE())"));
                                                    echo $filterTotalConnectLeads['totalCount'];
                                                    ?>
                                                </td>
                                                <?php
                                                $filterTotalzeroDialLeads = mysqli_fetch_array(mysqli_query($dbconn, "SELECT count(*) as `totalCount` FROM `application` where iAppId NOT IN (select iAppId from applicationfollowup where MONTH(STR_TO_DATE(strEntryDate,'%d-%m-%Y'))=MONTH(CURRENT_DATE()) and YEAR(STR_TO_DATE(strEntryDate,'%d-%m-%Y'))=YEAR(CURRENT_DATE())) and agentId='" . $_SESSION['elisionloginid'] . "' and isWithdraw='0' and isPaid='0'"));
                                                if ($filterTotalzeroDialLeads['totalCount'] == 0) {
                                                    echo '<td>';
                                                    echo $filterTotalzeroDialLeads['totalCount'];
                                                    echo "</td>";
                                                } else {
                                                    echo '<td style="background-color: red">';
                                                    echo $filterTotalzeroDialLeads['totalCount'];
                                                    echo "</td>";
                                                }
                                                ?>
                                                <!--<td>
                                                    <?php
                                                    // $filterTotalPaidLeads = mysqli_fetch_array(mysqli_query($dbconn, "SELECT count(*) as `totalCount` FROM `application` where agentId='" . $_SESSION['elisionloginid'] . "' and isWithdraw='0' and isPaid='1' and MONTH(STR_TO_DATE(strEntryDate,'%d-%m-%Y'))=MONTH(CURRENT_DATE()) and YEAR(STR_TO_DATE(strEntryDate,'%d-%m-%Y'))=YEAR(CURRENT_DATE())"));
                                                    // echo $filterTotalPaidLeads['totalCount'];
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    // $filterTotalPTPLeads = mysqli_fetch_array(mysqli_query($dbconn, "SELECT count(*) as `totalCount` FROM `applicationfollowup` where iAppId IN (select iAppId from application where agentId='" . $_SESSION['elisionloginid'] . "' and isWithdraw='0') and  PTPDate <>'' and MONTH(STR_TO_DATE(strEntryDate,'%d-%m-%Y'))=MONTH(CURRENT_DATE()) and YEAR(STR_TO_DATE(strEntryDate,'%d-%m-%Y'))=YEAR(CURRENT_DATE())"));
                                                    // echo $filterTotalPTPLeads['totalCount'];
                                                    ?>
                                                </td>-->
                                                <!---------------------------------- FTD ----------------------------------->
                                                <td>
                                                    <?php
                                                    $filterTodaysAttemptLeads = mysqli_fetch_array(mysqli_query($dbconn, "SELECT count(*) as `totalCount` FROM `applicationfollowup` where iAppId IN (select iAppId from application where agentId='" . $_SESSION['elisionloginid'] . "' and isWithdraw='0') and MONTH(STR_TO_DATE(strEntryDate,'%d-%m-%Y'))=MONTH(CURRENT_DATE()) and YEAR(STR_TO_DATE(strEntryDate,'%d-%m-%Y'))=YEAR(CURRENT_DATE()) and STR_TO_DATE(strEntryDate,'%d-%m-%Y') = CURRENT_DATE()"));
                                                    echo $filterTodaysAttemptLeads['totalCount'];
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    $filterTodaysConnectLeads = mysqli_fetch_array(mysqli_query($dbconn, "SELECT count(*) as `totalCount` FROM `applicationfollowup` where iAppId IN (select iAppId from application where agentId='" . $_SESSION['elisionloginid'] . "' and isWithdraw='0') and dispoType='1' and MONTH(STR_TO_DATE(strEntryDate,'%d-%m-%Y'))=MONTH(CURRENT_DATE()) and YEAR(STR_TO_DATE(strEntryDate,'%d-%m-%Y'))=YEAR(CURRENT_DATE()) and STR_TO_DATE(strEntryDate,'%d-%m-%Y') = CURRENT_DATE()"));
                                                    echo $filterTodaysConnectLeads['totalCount'];
                                                    ?>
                                                </td>
                                                <?php
                                                $filterTodaysZeroDialLeads = mysqli_fetch_array(mysqli_query($dbconn, "SELECT count(*) as `totalCount` FROM `application` where iAppId NOT IN (select iAppId from applicationfollowup where MONTH(STR_TO_DATE(strEntryDate,'%d-%m-%Y'))=MONTH(CURRENT_DATE()) and YEAR(STR_TO_DATE(strEntryDate,'%d-%m-%Y'))=YEAR(CURRENT_DATE()) and STR_TO_DATE(strEntryDate,'%d-%m-%Y') = CURRENT_DATE()) and agentId='" . $_SESSION['elisionloginid'] . "' and isWithdraw='0' and isPaid='0' "));
                                                if ($filterTodaysZeroDialLeads['totalCount'] == 0) {
                                                    echo '<td>';
                                                    echo $filterTodaysZeroDialLeads['totalCount'];
                                                    echo "</td>";
                                                } else {
                                                    echo '<td style="background-color: red">';
                                                    echo $filterTodaysZeroDialLeads['totalCount'];
                                                    echo "</td>";
                                                }
                                                ?>
                                                <td>
                                                    <?php
                                                    $filterTodaysPTPLeads = mysqli_fetch_array(mysqli_query($dbconn, "SELECT count(*) AS todayPTPCount FROM application a LEFT JOIN applicationfollowup f ON a.iAppLogId = f.iAppLogId WHERE a.agentId = '" . $_SESSION['elisionloginid'] . "' AND a.isWithdraw = 0 AND a.isPaid = 0 AND a.isDelete = 0 AND a.iStatus = 1 AND f.iAppLogId = (SELECT ff.iAppLogId FROM applicationfollowup ff WHERE ff.iAppLogId = a.iAppLogId ORDER BY STR_TO_DATE(ff.strEntryDate, '%d-%m-%Y') DESC LIMIT 1) AND f.mainDispoId = 12 AND STR_TO_DATE(f.strEntryDate, '%d-%m-%Y') = CURRENT_DATE();"));
                                                    echo $filterTodaysPTPLeads['todayPTPCount'];
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    $filterTodaysPTPLeads = mysqli_fetch_array(mysqli_query($dbconn, "SELECT ifnull(SUM(f.PTP_Amount),0) AS todayPTPAmount FROM application a LEFT JOIN applicationfollowup f ON a.iAppLogId = f.iAppLogId WHERE a.agentId = '" . $_SESSION['elisionloginid'] . "' AND a.isWithdraw = 0 AND a.isPaid = 0 AND a.isDelete = 0 AND a.iStatus = 1 AND f.iAppLogId = (SELECT ff.iAppLogId FROM applicationfollowup ff WHERE ff.iAppLogId = a.iAppLogId ORDER BY STR_TO_DATE(ff.strEntryDate, '%d-%m-%Y') DESC LIMIT 1) AND f.mainDispoId = 12 AND STR_TO_DATE(f.strEntryDate, '%d-%m-%Y') = CURRENT_DATE();"));
                                                    echo $filterTodaysPTPLeads['todayPTPAmount'];
                                                    ?>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                        <?php
                        if ($_SESSION['Designation'] == 4) {
                        $filterTL = mysqli_query($dbconn, "Select elisionloginid,empname from employee where iteamleadid='" . $_SESSION['EmployeeId'] . "'");
                        ?>
                    <div class="row">
                            <div class="portlet light ">
                                <div class="portlet-title">
                                    <div class="caption grey-gallery">
                                        <i class="icon-settings grey-gallery"></i>
                                        <span class="caption-subject bold uppercase">TL Dashboard</span>
                                    </div>
                                </div>
                                <div class="portlet-body">
                                    <table class="table table-bordered table-hover center table-responsive" width="100%" id="tableC">
                                        <thead class="tbg">
                                            <!--<tr>
                                                <th class="pop_in_heading" colspan="3"></th>
                                                <th class="pop_in_heading" colspan="5">MTD</th>
                                                <th class="pop_in_heading" colspan="4">FTD</th>
                                            </tr>
                                            <tr>
                                                <th class="pop_in_heading_1">Agent Name</th>
                                                <th class="pop_in_heading_1">Total Leads</th>
                                                <th class="pop_in_heading_1">Unresolved Leads</th>
                                                <th class="pop_in_heading_1">Total Attempt</th>
                                                <th class="pop_in_heading_1">Total Connect</th>
                                                <th class="pop_in_heading_1">0 Dial</th>
                                                <th class="pop_in_heading_1">Paid</th>
                                                <th class="pop_in_heading_1">PTP</th>
        
                                                <th class="pop_in_heading_1">Attempt</th>
                                                <th class="pop_in_heading_1">Connect</th>
                                                <th class="pop_in_heading_1">0 dial</th>
                                                <th class="pop_in_heading_1">PTP</th>
                                            </tr>-->
                                            <tr>
                                                <th class="pop_in_heading" colspan="7"></th>
                                                <th class="pop_in_heading" colspan="3">MTD</th>
                                                <th class="pop_in_heading" colspan="5">FTD</th>
                                            </tr>
                                            <tr>
                                                <th class="pop_in_heading_1">Agent <br /> Name</th>
                                                <th class="pop_in_heading_1">Total <br /> Allocation</th>
                                                <th class="pop_in_heading_1">Unpaid <br />Count</th>
                                                <th class="pop_in_heading_1">Paid <br />Count</th>
                                                <th class="pop_in_heading_1">Paid <br />Amount</th>
                                                <th class="pop_in_heading_1">PTP <br />Count</th>
                                                <th class="pop_in_heading_1">PTP <br />Amount</th>
                                                
                                                
                                                <th class="pop_in_heading_1">Attempt</th>
                                                <th class="pop_in_heading_1">Connect</th>
                                                <th class="pop_in_heading_1">Zero <br />Dial</th>
                                                <!--<th class="pop_in_heading_1">Paid Count</th>-->
                                                <!--<th class="pop_in_heading_1">PTP</th>-->
        
                                                <th class="pop_in_heading_1">Attempt</th>
                                                <th class="pop_in_heading_1">Connect</th>
                                                <th class="pop_in_heading_1">Zero <br />dial</th>
                                                <th class="pop_in_heading_1">PTP <br />Count</th>
                                                <th class="pop_in_heading_1">PTP <br />Amount</th>
                                            </tr>
                                        </thead>   
                                        <tbody>
                                            <?php
                                            $addData = array();
                                            while ($rowEmployee = mysqli_fetch_array($filterTL)) {
                                                ?>
                                                
                                                
                                                    <td>
                                                        <?php
                                                        echo $rowEmployee['empname'];
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <?php
                                                        $filterTotalLeads = mysqli_fetch_array(mysqli_query($dbconn, "SELECT count(*) as `totalCount` FROM `application` where agentId='" . $rowEmployee['elisionloginid'] . "' and isWithdraw='0'"));
                                                        echo $filterTotalLeads['totalCount'];
                                                        $addData[0]+=$filterTotalLeads['totalCount'];
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <?php
                                                        $filterTotalUnpaidLeads = mysqli_fetch_array(mysqli_query($dbconn, "SELECT count(*) as `totalCount` FROM `application` where agentId='" . $rowEmployee['elisionloginid'] . "' and isWithdraw='0' and isPaid='0'"));
                                                        echo $filterTotalUnpaidLeads['totalCount'];
                                                        $addData[1]+=$filterTotalUnpaidLeads['totalCount'];
                                                        ?>
                                                    </td>
                                                    
                                                    <td>
                                                        <?php
                                                        $filterTotalUnpaidLeads = mysqli_fetch_array(mysqli_query($dbconn, "SELECT count(*) as `totalCount` FROM `application` where agentId='" . $rowEmployee['elisionloginid'] . "' and isWithdraw='0' and isPaid='1'"));
                                                        echo $filterTotalUnpaidLeads['totalCount'];
                                                        $addData[11]+=$filterTotalUnpaidLeads['totalCount'];
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <?php
                                                        $filterTotalUnpaidLeads = mysqli_fetch_array(mysqli_query($dbconn, "SELECT sum(paid_amount) as `paid_amount` FROM `application` inner join application_payment_history on application.iAppId=application_payment_history.application_id where agentId='" . $rowEmployee['elisionloginid'] . "' and application.isWithdraw='0' and application.isPaid='1'"));
                                                        echo $filterTotalUnpaidLeads['paid_amount'];
                                                        $addData[12]+=$filterTotalUnpaidLeads['paid_amount'];
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <?php
                                                        $filterTotalUnpaidLeads = mysqli_fetch_array(mysqli_query($dbconn, "SELECT count(*) as `totalCount` FROM application a LEFT JOIN applicationfollowup f ON a.iAppLogId = f.iAppLogId where a.agentId='" . $rowEmployee['elisionloginid'] . "' and a.isWithdraw='0' and a.isPaid = 0 AND a.isDelete = 0 AND a.iStatus = 1  AND f.iAppLogId = (SELECT ff.iAppLogId FROM applicationfollowup ff WHERE ff.iAppLogId = a.iAppLogId ORDER BY STR_TO_DATE(ff.strEntryDate, '%d-%m-%Y') DESC LIMIT 1)  AND f.mainDispoId = 12"));
                                                        echo $filterTotalUnpaidLeads['totalCount'];
                                                        $addData[13]+=$filterTotalUnpaidLeads['totalCount'];
                                                        ?>
                                                    </td>
                                                    
                                                    <td>
                                                        <?php
                                                        $filterTotalUnpaidLeads = mysqli_fetch_array(mysqli_query($dbconn, "SELECT sum(PTP_Amount) as `PTP_Amount` FROM `application` a LEFT JOIN applicationfollowup f ON a.iAppLogId = f.iAppLogId where a.agentId='" . $rowEmployee['elisionloginid'] . "' and a.isWithdraw='0' and a.isPaid = 0 AND a.isDelete = 0 AND a.iStatus = 1  AND f.iAppLogId = (SELECT ff.iAppLogId FROM applicationfollowup ff WHERE ff.iAppLogId = a.iAppLogId ORDER BY STR_TO_DATE(ff.strEntryDate, '%d-%m-%Y') DESC LIMIT 1)  AND f.mainDispoId = 12"));
                                                        echo $filterTotalUnpaidLeads['PTP_Amount'] ?? 0;
                                                        $addData[14]+=$filterTotalUnpaidLeads['PTP_Amount'];
                                                        ?>
                                                    </td>
                                                    
                                                    <!---------------------------------- MTD ----------------------------------->
                                                    <td>
                                                        <?php
                                                        $filterTotalAttemptLeads = mysqli_fetch_array(mysqli_query($dbconn, "SELECT count(*) as `totalAttemptCount` FROM `applicationfollowup` where iAppId IN (select iAppId from application where agentId='" . $rowEmployee['elisionloginid'] . "' and isWithdraw='0') and MONTH(STR_TO_DATE(strEntryDate,'%d-%m-%Y'))=MONTH(CURRENT_DATE()) and YEAR(STR_TO_DATE(strEntryDate,'%d-%m-%Y'))=YEAR(CURRENT_DATE())"));
                                                        echo $filterTotalAttemptLeads['totalAttemptCount']; 
                                                        $addData[2]+=$filterTotalAttemptLeads['totalAttemptCount'];
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <?php
                                                        $filterTotalConnectLeads = mysqli_fetch_array(mysqli_query($dbconn, "SELECT count(*) as `totalCount` FROM `applicationfollowup` where iAppId IN (select iAppId from application where agentId='" . $rowEmployee['elisionloginid'] . "' and isWithdraw='0') and dispoType='1' and MONTH(STR_TO_DATE(strEntryDate,'%d-%m-%Y'))=MONTH(CURRENT_DATE()) and YEAR(STR_TO_DATE(strEntryDate,'%d-%m-%Y'))=YEAR(CURRENT_DATE())"));
                                                        echo $filterTotalConnectLeads['totalCount'];
                                                        $addData[3]+=$filterTotalConnectLeads['totalCount'];
                                                        ?>
                                                    </td>
                                                    <?php
                                                    $filterTotalzeroDialLeads = mysqli_fetch_array(mysqli_query($dbconn, "SELECT count(*) as `totalCount` FROM `application` where iAppId NOT IN (select iAppId from applicationfollowup where MONTH(STR_TO_DATE(strEntryDate,'%d-%m-%Y'))=MONTH(CURRENT_DATE()) and YEAR(STR_TO_DATE(strEntryDate,'%d-%m-%Y'))=YEAR(CURRENT_DATE())) and agentId='" . $rowEmployee['elisionloginid'] . "' and isWithdraw='0' and isPaid='0'"));
                                                    if ($filterTotalzeroDialLeads['totalCount'] == 0) {
                                                        echo '<td>';
                                                        echo $filterTotalzeroDialLeads['totalCount'];
                                                        $addData[4]+=$filterTotalzeroDialLeads['totalCount'];
                                                        echo "</td>";
                                                    } else {
                                                        echo '<td style="background-color: red">';
                                                        echo $filterTotalzeroDialLeads['totalCount'];
                                                        $addData[4]+=$filterTotalzeroDialLeads['totalCount'];
                                                        echo "</td>";
                                                    }
                                                    ?>
                                                    <!---------------------------------- FTD ----------------------------------->
                                                    
                                                    <td>
                                                        <?php
                                                        $filterTodaysAttemptLeads = mysqli_fetch_array(mysqli_query($dbconn, "SELECT count(*) as `totalCount` FROM `applicationfollowup` where iAppId IN (select iAppId from application where agentId='" . $rowEmployee['elisionloginid'] . "' and isWithdraw='0') and MONTH(STR_TO_DATE(strEntryDate,'%d-%m-%Y'))=MONTH(CURRENT_DATE()) and YEAR(STR_TO_DATE(strEntryDate,'%d-%m-%Y'))=YEAR(CURRENT_DATE()) and STR_TO_DATE(strEntryDate,'%d-%m-%Y') = CURRENT_DATE()"));
                                                        echo $filterTodaysAttemptLeads['totalCount'];
                                                        $addData[8]+=$filterTodaysAttemptLeads['totalCount'];
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <?php
                                                        $filterTodaysConnectLeads = mysqli_fetch_array(mysqli_query($dbconn, "SELECT count(*) as `totalCount` FROM `applicationfollowup` where iAppId IN (select iAppId from application where agentId='" . $rowEmployee['elisionloginid'] . "' and isWithdraw='0') and dispoType='1' and MONTH(STR_TO_DATE(strEntryDate,'%d-%m-%Y'))=MONTH(CURRENT_DATE()) and YEAR(STR_TO_DATE(strEntryDate,'%d-%m-%Y'))=YEAR(CURRENT_DATE()) and STR_TO_DATE(strEntryDate,'%d-%m-%Y') = CURRENT_DATE()"));
                                                        echo $filterTodaysConnectLeads['totalCount'];
                                                        $addData[9]+=$filterTodaysConnectLeads['totalCount'];
                                                        ?>
                                                    </td>
                                                    <?php
                                                    $filterTodaysZeroDialLeads = mysqli_fetch_array(mysqli_query($dbconn, "SELECT count(*) as `totalCount` FROM `application` where iAppId NOT IN (select iAppId from applicationfollowup where MONTH(STR_TO_DATE(strEntryDate,'%d-%m-%Y'))=MONTH(CURRENT_DATE()) and YEAR(STR_TO_DATE(strEntryDate,'%d-%m-%Y'))=YEAR(CURRENT_DATE()) and STR_TO_DATE(strEntryDate,'%d-%m-%Y') = CURRENT_DATE()) and agentId='" . $rowEmployee['elisionloginid'] . "' and isWithdraw='0' and isPaid='0' "));
                                                    if ($filterTodaysZeroDialLeads['totalCount'] == 0) {
                                                        echo '<td>';
                                                        echo $filterTodaysZeroDialLeads['totalCount'];
                                                        $addData[10]+=$filterTodaysZeroDialLeads['totalCount'];
                                                        echo "</td>";
                                                    } else {
                                                        echo '<td style="background-color: red">';
                                                        echo $filterTodaysZeroDialLeads['totalCount'];
                                                        $addData[10]+=$filterTodaysZeroDialLeads['totalCount'];
                                                        echo "</td>";
                                                    }
                                                    ?>
                                                    <td>
                                                        <?php
                                                        $filterTodaysPTPLeads = mysqli_fetch_array(mysqli_query($dbconn, "SELECT count(*) AS todayPTPCount FROM application a LEFT JOIN applicationfollowup f ON a.iAppLogId = f.iAppLogId WHERE a.agentId = '" . $rowEmployee['elisionloginid'] . "' AND a.isWithdraw = 0 AND a.isPaid = 0 AND a.isDelete = 0 AND a.iStatus = 1 AND f.iAppLogId = (SELECT ff.iAppLogId FROM applicationfollowup ff WHERE ff.iAppLogId = a.iAppLogId ORDER BY STR_TO_DATE(ff.strEntryDate, '%d-%m-%Y') DESC LIMIT 1) AND f.mainDispoId = 12 AND STR_TO_DATE(f.strEntryDate, '%d-%m-%Y') = CURRENT_DATE();"));
                                                        echo $filterTodaysPTPLeads['todayPTPCount'];
                                                        $addData[15]+=$filterTodaysPTPLeads['todayPTPCount'];
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <?php
                                                        $filterTodaysPTPLeads = mysqli_fetch_array(mysqli_query($dbconn, "SELECT ifnull(SUM(f.PTP_Amount),0) AS todayPTPAmount FROM application a LEFT JOIN applicationfollowup f ON a.iAppLogId = f.iAppLogId WHERE a.agentId = '" . $rowEmployee['elisionloginid'] . "' AND a.isWithdraw = 0 AND a.isPaid = 0 AND a.isDelete = 0 AND a.iStatus = 1 AND f.iAppLogId = (SELECT ff.iAppLogId FROM applicationfollowup ff WHERE ff.iAppLogId = a.iAppLogId ORDER BY STR_TO_DATE(ff.strEntryDate, '%d-%m-%Y') DESC LIMIT 1) AND f.mainDispoId = 12 AND STR_TO_DATE(f.strEntryDate, '%d-%m-%Y') = CURRENT_DATE();"));
                                                        echo $filterTodaysPTPLeads['todayPTPAmount'];
                                                        $addData[16]+=$filterTodaysPTPLeads['todayPTPAmount'];
                                                        ?>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                        
                                        <tr>
                                            <th class="pop_in_heading" colspan="1"><b>Total</b></th>
                                            <th class="pop_in_heading" colspan="1"><?php echo $addData[0]; ?></th>
                                            <th class="pop_in_heading" colspan="1"><?php echo $addData[1]; ?></th>
                                            <th class="pop_in_heading" colspan="1"><?php echo $addData[11]; ?></th>
                                            <th class="pop_in_heading" colspan="1"><?php echo $addData[12]; ?></th>
                                            <th class="pop_in_heading" colspan="1"><?php echo $addData[13]; ?></th>
                                            <th class="pop_in_heading" colspan="1"><?php echo $addData[14]; ?></th>
                                            
                                            <th class="pop_in_heading" colspan="1"><?php echo $addData[2]; ?></th>
                                            <th class="pop_in_heading" colspan="1"><?php echo $addData[3]; ?></th>
                                            <th class="pop_in_heading" colspan="1"><?php echo $addData[4]; ?></th>
                                            
                                            <!--<th class="pop_in_heading" colspan="1"><?php echo $addData[5]; ?></th>-->
                                            <!--<th class="pop_in_heading" colspan="1"><?php echo $addData[6]; ?></th>-->
                                            <!--<th class="pop_in_heading" colspan="1"><?php echo $addData[7]; ?></th>-->
                                            <th class="pop_in_heading" colspan="1"><?php echo $addData[8]; ?></th>
                                            <th class="pop_in_heading" colspan="1"><?php echo $addData[9]; ?></th>                            
                                            <th class="pop_in_heading" colspan="1"><?php echo $addData[10]; ?></th>
                                            <th class="pop_in_heading" colspan="1"><?php echo $addData[15]; ?></th>
                                            <th class="pop_in_heading" colspan="1"><?php echo $addData[16]; ?></th>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                    <?php
                    if ($_SESSION['Designation'] == 2) {
                        $filterAM = mysqli_query($dbconn, "SELECT iteamleadid FROM `employee` WHERE asstmanagerid='" . $_SESSION['EmployeeId'] . "' AND iteamleadid!=0 GROUP BY iteamleadid");
                        ?>
                        <div class="row">
                            <div class="portlet light ">
                                <div class="portlet-title">
                                    <div class="caption grey-gallery">
                                        <i class="icon-settings grey-gallery"></i>
                                        <span class="caption-subject bold uppercase">TL wise Dashboard</span>
                                    </div>
                                </div>
                                <div class="portlet-body">
                                    <table class="table table-bordered table-hover center table-responsive" width="100%" id="tableC">
                                        <thead class="tbg">
                                            <tr>
                                                <th class="pop_in_heading" colspan="3"></th>
                                                <th class="pop_in_heading" colspan="5">MTD</th>
                                                <th class="pop_in_heading" colspan="4">FTD</th>
                                            </tr>
                                            <tr>
                                                <th class="pop_in_heading_1">Agent Name</th>
                                                <th class="pop_in_heading_1">Total Leads</th>
                                                <th class="pop_in_heading_1">Unresolved Leads</th>
                                                <th class="pop_in_heading_1">Total Attempt</th>
                                                <th class="pop_in_heading_1">Total Connect</th>
                                                <th class="pop_in_heading_1">0 Dial</th>
                                                <th class="pop_in_heading_1">Paid</th>
                                                <th class="pop_in_heading_1">PTP</th>
        
                                                <th class="pop_in_heading_1">Attempt</th>
                                                <th class="pop_in_heading_1">Connect</th>
                                                <th class="pop_in_heading_1">0 dial</th>
                                                <th class="pop_in_heading_1">PTP</th>
                                            </tr>
                                        </thead>   
                                        <tbody>
                                            <?php
                                            $addData = array();
                                            while ($rowEmployee = mysqli_fetch_array($filterAM)) {
        //                                                    echo "SELECT count(*) as `totalCount` FROM `application` where application.agentId in (SELECT employee.elisionloginid from employee WHERE employee.iteamleadid in  ('" . $rowEmployee['iteamleadid'] . "')) and isWithdraw='0'";
                                                ?>
                                                <tr>
                                                    <td>
                                                        <a value="="  title="APPLICATION FOLLOWUP" onclick="window.open('<?php echo $web_url; ?>Employee/ViewTLAgentDetails.php?token=<?php echo $rowEmployee['iteamleadid']; ?>', 'popUpWindow', 'height=500,width=1250,left=100,top=100,resizable=yes,scrollbars=yes,toolbar=yes,menubar=no,location=no,directories=no,status=yes');">
                                                            <?php
                                                            $filterAgent = mysqli_fetch_array(mysqli_query($dbconn, "select empname FROM `employee` where employeeid='" . $rowEmployee['iteamleadid'] . "' "));
                                                            echo $filterAgent['empname'];
                                                            ?>
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <?php
                                                        $filterTotalLeads = mysqli_fetch_array(mysqli_query($dbconn, "SELECT count(*) as `totalCount` FROM `application` where application.agentId in (SELECT employee.elisionloginid from employee WHERE employee.iteamleadid in ('" . $rowEmployee['iteamleadid'] . "')) and isWithdraw='0'"));
                                                        echo $filterTotalLeads['totalCount'];
                                                        $addData[0]+=$filterTotalLeads['totalCount'];
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <?php
                                                        $filterTotalUnpaidLeads = mysqli_fetch_array(mysqli_query($dbconn, "SELECT count(*) as `totalCount` FROM `application` where application.agentId in (SELECT employee.elisionloginid from employee WHERE employee.iteamleadid in ('" . $rowEmployee['iteamleadid'] . "' )) and isWithdraw='0' and isPaid='0'"));
                                                        echo $filterTotalUnpaidLeads['totalCount'];
                                                        $addData[1]+=$filterTotalUnpaidLeads['totalCount'];
                                                        ?>
                                                    </td>
                                                    <!---------------------------------- MTD ----------------------------------->
                                                    <td>
                                                        <?php
                                                        $filterTotalAttemptLeads = mysqli_fetch_array(mysqli_query($dbconn, "SELECT count(*) as `totalCount` FROM `applicationfollowup` where iAppId IN (select iAppId from application where application.agentId in (SELECT employee.elisionloginid from employee WHERE employee.iteamleadid in ('" . $rowEmployee['iteamleadid'] . "')) and isWithdraw='0') and MONTH(STR_TO_DATE(strEntryDate,'%d-%m-%Y'))=MONTH(CURRENT_DATE()) and YEAR(STR_TO_DATE(strEntryDate,'%d-%m-%Y'))=YEAR(CURRENT_DATE())"));
                                                        echo $filterTotalAttemptLeads['totalCount'];
                                                        $addData[2]+=$filterTotalAttemptLeads['totalCount'];
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <?php
                                                        $filterTotalConnectLeads = mysqli_fetch_array(mysqli_query($dbconn, "SELECT count(*) as `totalCount` FROM `applicationfollowup` where iAppId IN (select iAppId from application where application.agentId in (SELECT employee.elisionloginid from employee WHERE employee.iteamleadid in ('" . $rowEmployee['iteamleadid'] . "')) and isWithdraw='0') and dispoType='1' and MONTH(STR_TO_DATE(strEntryDate,'%d-%m-%Y'))=MONTH(CURRENT_DATE()) and YEAR(STR_TO_DATE(strEntryDate,'%d-%m-%Y'))=YEAR(CURRENT_DATE())"));
                                                        echo $filterTotalConnectLeads['totalCount'];
                                                        $addData[3]+=$filterTotalConnectLeads['totalCount'];
                                                        ?>
                                                    </td>
        
                                                    <?php
                                                    $filterTotalzeroDialLeads = mysqli_fetch_array(mysqli_query($dbconn, "SELECT count(*) as `totalCount` FROM `application` where iAppId NOT IN ( select iAppId from applicationfollowup where MONTH(STR_TO_DATE(strEntryDate,'%d-%m-%Y'))=MONTH(CURRENT_DATE()) and YEAR(STR_TO_DATE(strEntryDate,'%d-%m-%Y'))=YEAR(CURRENT_DATE()))  and application.agentId in (SELECT employee.elisionloginid from employee WHERE employee.iteamleadid in ('" . $rowEmployee['iteamleadid'] . "')) and isWithdraw='0' and isPaid='0'"));
                                                    if ($filterTotalzeroDialLeads['totalCount'] == 0) {
                                                        echo '<td>';
                                                        echo $filterTotalzeroDialLeads['totalCount'];
                                                        $addData[4]+=$filterTotalzeroDialLeads['totalCount'];
                                                        echo "</td>";
                                                    } else {
                                                        echo '<td style="background-color: red">';
                                                        echo $filterTotalzeroDialLeads['totalCount'];
                                                        $addData[4]+=$filterTotalzeroDialLeads['totalCount'];
                                                        echo "</td>";
                                                    }
                                                    ?>
                                                    <td>
                                                        <?php
                                                        $filterTotalPaidLeads = mysqli_fetch_array(mysqli_query($dbconn, "SELECT count(*) as `totalCount` FROM `application` where application.agentId in (SELECT employee.elisionloginid from employee WHERE employee.iteamleadid in ('" . $rowEmployee['iteamleadid'] . "')) and isWithdraw='0' and isPaid='1' and MONTH(STR_TO_DATE(strEntryDate,'%d-%m-%Y'))=MONTH(CURRENT_DATE()) and YEAR(STR_TO_DATE(strEntryDate,'%d-%m-%Y'))=YEAR(CURRENT_DATE())"));
                                                        echo $filterTotalPaidLeads['totalCount'];
                                                        $addData[5]+=$filterTotalPaidLeads['totalCount'];
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <?php
                                                        $filterTotalPTPLeads = mysqli_fetch_array(mysqli_query($dbconn, "SELECT count(*) as `totalCount` FROM `applicationfollowup` where iAppId IN (select iAppId from application where application.agentId in (SELECT employee.elisionloginid from employee WHERE employee.iteamleadid in ('" . $rowEmployee['iteamleadid'] . "')) and isWithdraw='0') and  PTPDate <>'' and MONTH(STR_TO_DATE(strEntryDate,'%d-%m-%Y'))=MONTH(CURRENT_DATE()) and YEAR(STR_TO_DATE(strEntryDate,'%d-%m-%Y'))=YEAR(CURRENT_DATE())"));
                                                        echo $filterTotalPTPLeads['totalCount'];
                                                        $addData[6]+=$filterTotalPTPLeads['totalCount'];
                                                        ?>
                                                    </td>
                                                    <!---------------------------------- FTD ----------------------------------->
                                                    <td>
                                                        <?php
                                                        $filterTodaysAttemptLeads = mysqli_fetch_array(mysqli_query($dbconn, "SELECT count(*) as `totalCount` FROM `applicationfollowup` where iAppId IN (select iAppId from application where application.agentId in (SELECT employee.elisionloginid from employee WHERE employee.iteamleadid in ('" . $rowEmployee['iteamleadid'] . "')) and isWithdraw='0') and MONTH(STR_TO_DATE(strEntryDate,'%d-%m-%Y'))=MONTH(CURRENT_DATE()) and YEAR(STR_TO_DATE(strEntryDate,'%d-%m-%Y'))=YEAR(CURRENT_DATE()) and STR_TO_DATE(strEntryDate,'%d-%m-%Y') = CURRENT_DATE()"));
                                                        echo $filterTodaysAttemptLeads['totalCount'];
                                                        $addData[7]+=$filterTodaysAttemptLeads['totalCount'];
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <?php
                                                        $filterTodaysConnectLeads = mysqli_fetch_array(mysqli_query($dbconn, "SELECT count(*) as `totalCount` FROM `applicationfollowup` where iAppId IN (select iAppId from application where application.agentId in (SELECT employee.elisionloginid from employee WHERE employee.iteamleadid in ('" . $rowEmployee['iteamleadid'] . "')) and isWithdraw='0') and dispoType='1' and MONTH(STR_TO_DATE(strEntryDate,'%d-%m-%Y'))=MONTH(CURRENT_DATE()) and YEAR(STR_TO_DATE(strEntryDate,'%d-%m-%Y'))=YEAR(CURRENT_DATE()) and STR_TO_DATE(strEntryDate,'%d-%m-%Y') = CURRENT_DATE()"));
                                                        echo $filterTodaysConnectLeads['totalCount'];
                                                        $addData[8]+=$filterTodaysConnectLeads['totalCount'];
                                                        ?>
                                                    </td>
        
                                                    <?php
                                                    $filterTodaysZeroDialLeads = mysqli_fetch_array(mysqli_query($dbconn, "SELECT count(*) as `totalCount` FROM `application` where iAppId NOT IN ( select iAppId from applicationfollowup where MONTH(STR_TO_DATE(strEntryDate,'%d-%m-%Y'))=MONTH(CURRENT_DATE()) and YEAR(STR_TO_DATE(strEntryDate,'%d-%m-%Y'))=YEAR(CURRENT_DATE()) and STR_TO_DATE(strEntryDate,'%d-%m-%Y') = CURRENT_DATE())  and application.agentId in (SELECT employee.elisionloginid from employee WHERE employee.iteamleadid in ('" . $rowEmployee['iteamleadid'] . "')) and isWithdraw='0' and isPaid='0'"));
                                                    if ($filterTodaysZeroDialLeads['totalCount'] == 0) {
                                                        echo '<td>';
                                                        echo $filterTodaysZeroDialLeads['totalCount'];
                                                        $addData[9]+=$filterTodaysZeroDialLeads['totalCount'];
                                                        echo "</td>";
                                                    } else {
                                                        echo '<td style="background-color: red">';
                                                        echo $filterTodaysZeroDialLeads['totalCount'];
                                                        $addData[9]+=$filterTodaysZeroDialLeads['totalCount'];
                                                        echo "</td>";
                                                    }
                                                    ?>
                                                    <td>
                                                        <?php
                                                        $filterTodaysPTPLeads = mysqli_fetch_array(mysqli_query($dbconn, "SELECT count(*) as `totalCount` FROM `applicationfollowup` where iAppId IN (select iAppId from application where agentId='" . $rowEmployee['iteamleadid'] . "' and isWithdraw='0') and  PTPDate <>'' and MONTH(STR_TO_DATE(strEntryDate,'%d-%m-%Y'))=MONTH(CURRENT_DATE()) and YEAR(STR_TO_DATE(strEntryDate,'%d-%m-%Y'))=YEAR(CURRENT_DATE()) and STR_TO_DATE(strEntryDate,'%d-%m-%Y') = CURRENT_DATE()"));
                                                        echo $filterTodaysPTPLeads['totalCount'];
                                                        $addData[10]+=$filterTodaysPTPLeads['totalCount'];
                                                        ?>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                        <tr>
                                            <th class="pop_in_heading" colspan="1"><b>Total</b></th>
                                            <th class="pop_in_heading" colspan="1"><?php echo $addData[0]; ?></th>
                                            <th class="pop_in_heading" colspan="1"><?php echo $addData[1]; ?></th>
                                            <th class="pop_in_heading" colspan="1"><?php echo $addData[2]; ?></th>
                                            <th class="pop_in_heading" colspan="1"><?php echo $addData[3]; ?></th>
                                            <th class="pop_in_heading" colspan="1"><?php echo $addData[4]; ?></th>
                                            <th class="pop_in_heading" colspan="1"><?php echo $addData[5]; ?></th>
                                            <th class="pop_in_heading" colspan="1"><?php echo $addData[6]; ?></th>
                                            <th class="pop_in_heading" colspan="1"><?php echo $addData[7]; ?></th>
                                            <th class="pop_in_heading" colspan="1"><?php echo $addData[8]; ?></th>
                                            <th class="pop_in_heading" colspan="1"><?php echo $addData[9]; ?></th>                            
                                            <th class="pop_in_heading" colspan="1"><?php echo $addData[10]; ?></th>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                    
                    <!-- END DASHBOARD STATS 1-->
                    <div class="portlet light " style="" id="SLID">
                        <div class="portlet-title">
                            <div class="caption font-red-sunglo">
                                <span class="caption-subject bold uppercase">List of Allocation</span>
                            </div>
                            <?php if ($_SESSION['Designation'] == 6) { ?>
                                <a href="<?php echo $web_url; ?>Employee/AddCRM.php" class="btn blue pull-right margin-bottom-20" style="float: right;" title="ADD CRM"><i class="fa fa-upload"></i> </a>
                                <?php
                            }
                            if ($_SESSION['Designation'] == 4 || $_SESSION['Designation'] == 2) {
                                ?>
                                <a href="TLFollowupEmployeeDetails.php" class="btn green pull-right margin-bottom-20" style="margin-right: 20px; margin-left: 10px;" title="Employee"><i class="fa fa-file-excel-o"></i> Employee Follow Up details</a>
                                <a href="TLFeedbackReport.php" class="btn green pull-right margin-bottom-20" style="margin-left: 20px; margin-left: 10px;" title="Employee"><i class="fa fa-file-excel-o"></i> Employee Feedback Report</a>
                            <?php } ?>
                        </div>
                        
                        
                    
                        <div class="portlet-body form">
                            <div class="row">
                                <!-- <form  role="form"  method="POST"  action="" name="frmSearch"  id="frmSearch" enctype="multipart/form-data">
                                    <input type="hidden" name="Designation" id="Designation" value="<?php echo $_SESSION['Designation']; ?>">
                                    <?php if ($_SESSION['Designation'] == 4 || $_SESSION['Designation'] == 2) { ?>
                                        <div class="form-group col-md-3">
                                        <?php } else { ?>
                                            <div class="form-group col-md-3">
                                            <?php } ?>
                                            <select name="strfilter" id="strfilter" class="form-control" required="">
                                                <option value="">Select Filter Criteria</option>
                                                <option value="applicatipnNo">Loan Application No</option>
                                                <option value="customerName">Customer Name</option>
                                                <option value="CustomSearch">Custom Search</option>
                                                <option value="TotalAttempt">Total Attempt</option>
                                                <option value="TotalConnect">Total Connect</option>
                                                <option value="state">State</option>
                                                <option value="agencyName">Agency Name</option>
                                                <option value="customerCity">City</option>
                                                <option value="customerZipcode">Pincode</option>
                                                <option value="followupDate">Follow-up Date</option>
                                                <option value="followupTime">Follow-up Time</option>
                                                <option value="LastCallDate">Last Call Date</option>
                                                <option value="Lastdisposition">Last disposition</option>
                                            </select>
                                        </div>

                                        <div class="form-group col-md-3" id="DivDate">
                                            <input type="text" value="" name="filterValue" class="form-control" id="filterValue" placeholder="Search Filter Value" required/>
                                        </div>
                                        <span id="DivLastCallDate" style="display: none;">
                                            <div class="form-group col-md-2" >
                                                <input type="text" value="" name="formdate" class="form-control" id="formdate" placeholder="Enter From Date" required/>
                                            </div>
                                            <div class="form-group col-md-2" >
                                                <input type="text" value="" name="todate" class="form-control" id="todate" placeholder="Enter To Date" required/>
                                            </div>
                                        </span>

                                        <?php
                                        if ($_SESSION['Designation'] == 4 || $_SESSION['Designation'] == 2) {
                                            $filterTeamLeader = mysqli_query($dbconn, "SELECT * FROM `employeedesignation` where iEmployeeId='" . $_SESSION['EmployeeId'] . "' and iDesignationId='4' and istatus='1' and isDelete='0'");
                                            if (mysqli_num_rows($filterTeamLeader) > 0) {
                                                ?>
                                                <div class="form-group col-md-3">
                                                    <select name="EmployeeId" id="EmployeeId" class="form-control"> 
                                                        <option value="">Select Employee</option>
                                                        <option value="<?php echo $_SESSION['elisionloginid']; ?>"><?php echo $_SESSION['EmployeeName']; ?></option>
                                                        <?php
                                                        $filterEmployee = mysqli_query($dbconn, "SELECT * FROM `employee` where iteamleadid='" . $_SESSION['EmployeeId'] . "' order by empname asc");
                                                        while ($rowEmployee = mysqli_fetch_array($filterEmployee)) {
                                                            ?>
                                                            <option value="<?php echo $rowEmployee['elisionloginid']; ?>"><?php echo $rowEmployee['empname']; ?></option>
                                                        <?php }
                                                        ?>
                                                    </select>
                                                </div>
                                                <?php
                                            }
                                        }
                                        ?>
                                        <div class="form-group col-md-2">
                                            <a href="#" class="btn blue pull-left" onclick="PageLoadData(1);">Search</a>
                                            <?php if ($_SESSION['Designation'] == 4 || $_SESSION['Designation'] == 2) { ?>
                                            <a onclick="exportToExcel();" href="#" target="_blank" class="btn green  margin-bottom-20" style="margin-right: 20px; margin-left: 10px;" title="Employee"><i class="fa fa-file-excel-o"></i></a>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </form> -->
                                <form  role="form"  method="POST"  action="" name="frmSearch"  id="frmSearch" enctype="multipart/form-data">
                                    <input type="hidden" name="Designation" id="Designation" value="<?php echo $_SESSION['Designation']; ?>">
                                    <div class="form-group col-md-3">
                                        <!--<label for="form_control_1">Disposition Name*</label>-->
                                        <div id="errordiv">
                                            <select name="disposition_name" class="form-control" id="disposition_name" onchange="checkSubDispos();">
                                                <option value="">Select Disposition Name</option>
                                                <?php
                                                //$filterDisPosition = mysqli_query($dbconn, "SELECT iDispoId,dispoDesc FROM `dispositionmaster` where dispoType=1 and masterDispoId=0");
                                                $filterDisPosition = mysqli_query($dbconn, "SELECT iDispoId,dispoDesc FROM `dispositionmaster` where masterDispoId=0");
                                                while ($rowDispostion = mysqli_fetch_array($filterDisPosition)) {
                                                    ?>
                                                    <option value="<?php echo $rowDispostion['iDispoId']; ?>"><?php echo $rowDispostion['dispoDesc']; ?></option>
                                                <?php } ?>
                                                <option value="1000">Broken PTP</option>
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group col-md-3" style="display: none" id="subDisPos">
                                        <!--<label for="form_control_1">Sub Disposition Name*</label>-->
                                        <div id="subCategoryId">
                                            <select name="sub_disposition" id="sub_disposition" class="form-control">
                                                <option value="">Select Sub Disposition Name</option>
                                                <?php
//                                                $filterSubDisPosition = mysqli_query($dbconn, "SELECT iDispoId,dispoDesc FROM `dispositionmaster` where masterDispoId!=0");
//                                                while ($rowSubDispostion = mysqli_fetch_array($filterSubDisPosition)) {
                                                ?>
                                                    <!--<option value="<?php // echo $rowSubDispostion['iDispoId'];       ?>"><?php // echo $rowSubDispostion['dispoDesc'];       ?></option>-->
                                                <?php // } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <input type="type" name="textSearch" id="textSearch" placeholder="Search Cust. Name / Loan No." value="<?= $_REQUEST['textSearch'] ?? ''; ?>" class="form-control"> 
                                    </div>
                                    <?php
                                        if ($_SESSION['Designation'] == 4 || $_SESSION['Designation'] == 2) {
                                            $filterTeamLeader = mysqli_query($dbconn, "SELECT * FROM `employeedesignation` where iEmployeeId='" . $_SESSION['EmployeeId'] . "' and iDesignationId='4' and istatus='1' and isDelete='0'");
                                            if (mysqli_num_rows($filterTeamLeader) > 0) {
                                                ?>
                                                <div class="form-group col-md-3">
                                                    <select name="EmployeeId" id="EmployeeId" class="form-control"> 
                                                        <option value="">Select Employee</option>
                                                        <option value="<?php echo $_SESSION['elisionloginid']; ?>"><?php echo $_SESSION['EmployeeName']; ?></option>
                                                        <?php
                                                        $filterEmployee = mysqli_query($dbconn, "SELECT * FROM `employee` where iteamleadid='" . $_SESSION['EmployeeId'] . "' order by empname asc");
                                                        while ($rowEmployee = mysqli_fetch_array($filterEmployee)) {
                                                            ?>
                                                            <option value="<?php echo $rowEmployee['elisionloginid']; ?>"><?php echo $rowEmployee['empname']; ?></option>
                                                        <?php }
                                                        ?>
                                                    </select>
                                                </div>
                                                <?php
                                            }
                                        } else { ?>
                                            <input type="hidden" name="EmployeeId" id="EmployeeId" value="<?= $_SESSION['EmployeeId']; ?>" class="form-control"> 
                                        <?php }
                                        ?>
                                    <div class="form-group col-md-4">
                                        <!--<a href="#" class="btn blue pull-left" onclick="PageLoadData(1);">Search</a>-->
                                        <!--<input button="reset" class="btn blue pull-left"  value="Reset">-->
                                        <a class="btn blue" href="#" id="Btnmybtn" onclick="PageLoadData(1);">Search</a>
                                        <button type="reset" class="btn blue" onclick="clearData();">Reset</button>
                                    </div>
                                    
                                </form>
                            </div>
                            <div class="row"
                                 <div id="PlaceUsersDataHere">
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- END CONTENT BODY -->
                </div>
                <!-- END CONTENT -->
                <!-- BEGIN QUICK SIDEBAR -->
                <a href="javascript:;" class="page-quick-sidebar-toggler">
                    <i class="icon-login"></i>
                </a>
                <!-- END QUICK SIDEBAR -->
            </div>
            <!-- END CONTAINER -->
            <!-- BEGIN FOOTER -->
            <?php include_once './footer.php'; ?>
            <!-- END FOOTER -->
        </div>
        <!-- BEGIN CORE PLUGINS -->
        <?php include_once './footerjs.php'; ?>
        <script src="<?php echo $web_url; ?>Employee/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js" type="text/javascript"></script>
        <script src="<?php echo $web_url; ?>Employee/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js" type="text/javascript"></script>
        <script type="text/javascript"> 
        $(document).ready(function() {
            initializeSorting();
        });

                                        $(function () {
                                            $("#strfilter").change(function () {
                                                var strfilter = $(this).val();
                                                $("#DivDate").html();
                                                if (strfilter === 'LastCallDate' || strfilter === 'Lastdisposition' || strfilter === 'TotalAttempt' || strfilter === 'TotalConnect' || strfilter === 'applicatipnNo' || strfilter === 'customerCity' || strfilter === 'customerZipcode' || strfilter === 'state' || strfilter === 'agencyName' || strfilter === 'customerName') {
//                                                            var Designation = $('#Designation').val();
//                                                            var EmployeeId = $('#EmployeeId').val();
//                                                            + '&Designation=' + Designation + '&EmployeeId=' + EmployeeId
                                                    var urlp = '<?php echo $web_url; ?>Employee/findFilterValue.php?strfilter=' + strfilter;
                                                    $.ajax({
                                                        type: 'POST',
                                                        url: urlp,
                                                        success: function (data) {
                                                            if (data == 0) {
                                                                $('#errordiv').html('');
                                                            } else {
                                                                $('#DivDate').html(data);
                                                                $('#subDisPos').show();
                                                                $('#LoginID').val('');
                                                            }
                                                        }
                                                    }).error(function () {
                                                        alert('An error occured');
                                                    });
                                                }

                                                if (strfilter === 'followupDate') {
                                                    $("#filterValue").datepicker({
                                                        format: 'dd-mm-yyyy',
                                                        autoclose: true,
                                                        todayHighlight: true,
                                                        defaultDate: "now"
                                                    });

                                                } else if (strfilter === 'followupTime') {
                                                    $('#DivDate').show();
                                                    $('#DivLastCallDate').hide();
                                                    $("#filterValue").datetimepicker({
                                                        format: 'dd-mm-yyyy hh:ii:ss',
                                                        autoclose: true,
                                                        todayHighlight: true,
                                                        defaultDate: "now"
                                                    });

                                                } else if (strfilter === 'LastCallDate') {
                                                    $('#DivDate').show();
                                                    $('#DivLastCallDate').show();
                                                    $("#formdate").datepicker({
                                                        format: 'dd-mm-yyyy',
                                                        autoclose: true,
                                                        todayHighlight: true,
                                                        defaultDate: "now"
                                                    });

                                                    $("#todate").datepicker({
                                                        format: 'dd-mm-yyyy',
                                                        autoclose: true,
                                                        todayHighlight: true,
                                                        defaultDate: "now"
                                                    });
                                                } else {
                                                    $('#DivDate').show();
                                                    $('#DivLastCallDate').hide();
                                                    $("#DivDate").html('<input type="text" value="" name="filterValue" class="form-control" id="filterValue" placeholder="Search Filter Value" required/>');
                                                    return true;
                                                }
                                            });
                                        });

                                        function clearData(){
                                           window.location.href=""; 
                                        }
                                        
                                        var currentSortField = '';
                                        var currentSortOrder = 'asc';
                                        
                                        function sortTable(field) {
                                            // Toggle sort order if clicking the same field
                                            if (currentSortField === field) {
                                                currentSortOrder = currentSortOrder === 'asc' ? 'desc' : 'asc';
                                            } else {
                                                currentSortField = field;
                                                currentSortOrder = 'asc';
                                            }
                                            
                                            // Reload data with sorting
                                            PageLoadData(1);
                                            // Update UI indicators
                                            updateSortIndicators(field,currentSortOrder);
                                            
                                        }
                                        
                                        function updateSortIndicators() {
                                                console.log('Updating indicators - Field:', currentSortField, 'Order:', currentSortOrder);
                                            // Remove all sorting classes first
                                            $('.sortable').removeClass('asc desc');
                                            
                                            // Add appropriate class to current sorted column
                                            $('.sortable').each(function() {
                                                var $this = $(this);
                                                var onclickAttr = $this.attr('onclick');
                                                if (onclickAttr && onclickAttr.includes("sortTable('loanAmount')")) {
                                                    $this.addClass(currentSortOrder);
                                                                console.log('Added class', currentSortOrder, 'to POS Amount header');
                                                }
                                            });
                                            
                                        }

                                        
                                        function initializeSorting() {
                                            // Check if we have any existing sort parameters
                                            <?php if (isset($_REQUEST['sort_field']) && $_REQUEST['sort_field'] == 'loanAmount') { ?>
                                                currentSortField = 'loanAmount';
                                                currentSortOrder = '<?php echo isset($_REQUEST['sort_order']) ? $_REQUEST['sort_order'] : 'asc'; ?>';
                                                updateSortIndicators();
                                            <?php } ?>
                                        }

                                        function PageLoadData(Page) {
                                            // var strfilter = $('#strfilter').val();
                                            // var filterValue = $('#filterValue').val();
                                            // var fromdate = $('#formdate').val();
                                            // var todate = $('#todate').val();
                                            var EmployeeId = $('#EmployeeId').val();
                                            var disposition_name = $('#disposition_name').val();
                                            var sub_disposition = $('#sub_disposition').val();
                                            var textSearch =  $("#textSearch").val();
                                            
                                            $('#loading').css("display", "block");
                                            $.ajax({
                                                type: "POST",
                                                url: "<?php echo $web_url; ?>Employee/AjaxAgentCRM.php",
                                                //data: {action: 'ListUser', Page: Page, strfilter: strfilter, filterValue: filterValue, EmployeeId: EmployeeId, fromdate: fromdate, todate: todate},
                                                data: {action: 'ListUser', Page: Page, EmployeeId: EmployeeId, sub_disposition: sub_disposition, disposition_name: disposition_name,sort_field: currentSortField,sort_order: currentSortOrder, textSearch: textSearch},
                                                success: function (msg) {
                                                    $('#SLID').show();
                                                    $('#loading').css("display", "none");
                                                    $("#PlaceUsersDataHere").html(msg);
                                                }
                                            });
                                        }// end of filter
                                        PageLoadData(1);

                                        function exportToExcel() {
                                            var strfilter = $('#strfilter').val();
                                            var filterValue = $('#filterValue').val();
                                            var EmployeeId = $('#EmployeeId').val();
                                            var fromdate = $('#formdate').val();
                                            var todate = $('#todate').val();
                                            var textSearch =  $("#textSearch").val();
                                            var strURL = 'TLEmployeeCRMExcel.php?strfilter=' + strfilter + '&todate=' + todate + '&fromdate='+ fromdate + '&filterValue=' + filterValue + '&EmployeeId=' + EmployeeId + '&textSearch=' + textSearch;
                                            window.open(strURL,'_blank');
                                        }
                                        
                                        
                                        function checkSubDispos() {
                                            var id = $('#disposition_name').val();
                                            if (id == 12) {
                                                if(id==12){
                                                    $('#subDisPos').show();
                                                } else {
                                                    $('#subDisPos').hide();
                                                }
                                             
                                                //var urlp = '<?php echo $web_url; ?>Employee/findSubDisposition.php?ID=' + id;
                                                var urlp = '<?php echo $web_url; ?>Employee/findNewSubDisposition.php?ID=' + id;
                                                $.ajax({
                                                    type: "POST",
                                                    url: urlp,
                                                    success: function (data) {
                                                        if (data != 0) {
                                                            
                                                            $('#subCategoryId').html(data);
                                                        } else {
                                                            $('#subDisPos').hide();
                                                        }
                                                        // if (id == 19 || id == 20 || id == 26) {
                                                        //     $('#FollowUpDate').hide();
                                                        //     $('#Date').attr('required', false);
                                                        // }
                                                    }
                                                });
                                            } else {
                                                $('#subDisPos').hide();
                                            }
                                        }
        </script>
    </body>

</html>