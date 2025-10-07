<?php
ob_start();
error_reporting(0);
include_once '../common.php';
$connect = new connect();
include('IsLogin.php');
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title><?php echo $ProjectName; ?> |Dashboard  </title>
        <?php include_once './include.php'; ?>
    </head>
    <!-- END HEAD -->
    <body class="page-header-fixed page-sidebar-closed-hide-logo page-content-white page-md">
        <div class="page-wrapper">
            <?php include_once './header.php'; ?>
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
                                <span>Dashboard</span>
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
                    <div class="clearfix">
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
                                            <div class="portlet-title">
                                                <div class="caption grey-gallery">
                                                    <i class="icon-settings grey-gallery"></i>
                                                    <span class="caption-subject bold uppercase">TL Dashboard</span>
                                                </div>
                                            </div>
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
                                    <!--<div class="col-md-4"></div>-->
                                    <?php
                                }
                            }
                            ?>
                        </div>
                        <!--                        <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="portlet light ">
                                                            <div class="portlet-title">
                                                                <div class="caption grey-gallery">
                                                                    <i class="icon-settings grey-gallery"></i>
                                                                    <span class="caption-subject bold uppercase">Lead Detail</span>
                                                                </div>
                                                            </div>
                                                            <div class="portlet-body">
                                                                <table class="table table-bordered table-hover center table-responsive" width="100%" id="tableC">
                                                                    <thead class="tbg">
                                                                        <tr>
                                                                            <th class="pop_in_heading">Total Leads</th>
                                                                            <th class="pop_in_heading">Unresolved  Leads</th>
                                                                            <th class="pop_in_heading">Connected</th>
                                                                            <th class="pop_in_heading">Not Connected</th>
                                                                            <th class="pop_in_heading">PTP</th>
                                                                            <th class="pop_in_heading">Follow-up</th>
                                                                        </tr>
                                                                    </thead>                      
                                                                    <tbody>
                                                                        <tr>
                                                                            <td>
                        <?php
//                                                        if ($_SESSION['Designation'] == 6) {
//                                                            $totalLeat = mysqli_fetch_array(mysqli_query($dbconn, "SELECT count(*) as `totalCount` FROM `application`"));
//                                                            echo $totalLeat['totalCount'];
//                                                        } else if ($_SESSION['Designation'] == 4) {
//                                                            $totalLeat = mysqli_fetch_array(mysqli_query($dbconn, "SELECT count(*) as `totalCount` FROM `application` where agentId in (SELECT elisionloginid FROM employee where employee.iteamleadid='" . $_SESSION['EmployeeId'] . "')"));
//                                                            echo $totalLeat['totalCount'];
//                                                        } else {
//                                                            $totalLeat = mysqli_fetch_array(mysqli_query($dbconn, "SELECT count(*) as `totalCount` FROM `application` where agentId='" . $_SESSION['elisionloginid'] . "'"));
//                                                            echo $totalLeat['totalCount'];
//                                                        }
                        ?>
                                                                            </td>
                                                                            <td>
                        <?php
//                                                        if ($_SESSION['Designation'] == 6) {
//                                                            $FreshLeads = mysqli_fetch_array(mysqli_query($dbconn, "SELECT count(*) as `totalCount` FROM `application` WHERE  isPaid=0 and isWithdraw=0"));
//                                                            echo $FreshLeads['totalCount'];
//                                                        } else if ($_SESSION['Designation'] == 4) {
//                                                            $FreshLeads = mysqli_fetch_array(mysqli_query($dbconn, "SELECT count(*) as `totalCount` FROM `application` where isPaid=0 and isWithdraw=0 and agentId in (SELECT elisionloginid FROM employee where employee.iteamleadid='" . $_SESSION['EmployeeId'] . "')"));
//                                                            echo $FreshLeads['totalCount'];
//                                                        } else {
//                                                            $FreshLeads = mysqli_fetch_array(mysqli_query($dbconn, "SELECT count(*) as `totalCount` FROM `application` where isPaid=0 and isWithdraw=0 and agentId='" . $_SESSION['elisionloginid'] . "'"));
//                                                            echo $FreshLeads['totalCount'];
//                                                        }
                        ?>
                                                                            </td>
                                                                            <td>
                        <?php
//                                                        if ($_SESSION['Designation'] == 6) {
//                                                            $Connected = mysqli_fetch_array(mysqli_query($dbconn, "SELECT count(*) as `totalCount` FROM `application` WHERE isFollowDone=1 and iAppId IN (select iAppId from applicationfollowup where dispoType=1)"));
//                                                            echo $Connected['totalCount'];
//                                                        } else if ($_SESSION['Designation'] == 4) {
//                                                            $Connected = mysqli_fetch_array(mysqli_query($dbconn, "SELECT count(*) as `totalCount` FROM `application` where isFollowDone=1 and iAppId IN (select iAppId from applicationfollowup where dispoType=1) and agentId in (SELECT elisionloginid FROM employee where employee.iteamleadid='" . $_SESSION['EmployeeId'] . "')"));
//                                                            echo $Connected['totalCount'];
//                                                        } else {
//                                                            $Connected = mysqli_fetch_array(mysqli_query($dbconn, "SELECT count(*) as `totalCount` FROM `application` where isFollowDone=1 and iAppId IN (select iAppId from applicationfollowup where dispoType=1) and agentId='" . $_SESSION['elisionloginid'] . "'"));
//                                                            echo $Connected['totalCount'];
//                                                        }
                        ?>
                                                                            </td>
                                                                            <td>
                        <?php
//                                                        $NotConnected = mysqli_fetch_array(mysqli_query($dbconn, "SELECT count(*) as `totalCount` FROM `application` WHERE isFollowDone=1 and iAppId IN (select iAppId from applicationfollowup where dispoType=0)"));
//                                                        echo $NotConnected['totalCount'];
//                                                        if ($_SESSION['Designation'] == 6) {
//                                                            $NotConnected = mysqli_fetch_array(mysqli_query($dbconn, "SELECT count(*) as `totalCount` FROM `application` WHERE isFollowDone=1 and iAppId IN (select iAppId from applicationfollowup where dispoType=0)"));
//                                                            echo $NotConnected['totalCount'];
//                                                        } else if ($_SESSION['Designation'] == 4) {
//                                                            $NotConnected = mysqli_fetch_array(mysqli_query($dbconn, "SELECT count(*) as `totalCount` FROM `application` where isFollowDone=1 and iAppId IN (select iAppId from applicationfollowup where dispoType=0) and agentId in (SELECT elisionloginid FROM employee where employee.iteamleadid='" . $_SESSION['EmployeeId'] . "')"));
//                                                            echo $NotConnected['totalCount'];
//                                                        } else {
//                                                            $NotConnected = mysqli_fetch_array(mysqli_query($dbconn, "SELECT count(*) as `totalCount` FROM `application` where isFollowDone=1 and iAppId IN (select iAppId from applicationfollowup where dispoType=0) and agentId='" . $_SESSION['elisionloginid'] . "'"));
//                                                            echo $NotConnected['totalCount'];
//                                                        }
                        ?>
                                                                            </td>
                                                                            <td>
                        <?php
//                                                        $PTP = mysqli_fetch_array(mysqli_query($dbconn, "SELECT count(*) as `totalCount` FROM `application` WHERE isFollowDone=1 and iAppId IN (select iAppId from applicationfollowup where dispoType=1 and PTPDate IS NOT NULL)"));
//                                                        echo $PTP['totalCount'];
//                                                        if ($_SESSION['Designation'] == 6) {
//                                                            $PTP = mysqli_fetch_array(mysqli_query($dbconn, "SELECT count(*) as `totalCount` FROM `application` WHERE isFollowDone=1 and iAppId IN (select iAppId from applicationfollowup where dispoType=1 and PTPDate IS NOT NULL)"));
//                                                            echo $PTP['totalCount'];
//                                                        } else if ($_SESSION['Designation'] == 4) {
//                                                            $PTP = mysqli_fetch_array(mysqli_query($dbconn, "SELECT count(*) as `totalCount` FROM `application` where isFollowDone=1 and iAppId IN (select iAppId from applicationfollowup where dispoType=1 and PTPDate IS NOT NULL) and agentId in (SELECT elisionloginid FROM employee where employee.iteamleadid='" . $_SESSION['EmployeeId'] . "')"));
//                                                            echo $PTP['totalCount'];
//                                                        } else {
//                                                            $PTP = mysqli_fetch_array(mysqli_query($dbconn, "SELECT count(*) as `totalCount` FROM `application` where isFollowDone=1 and iAppId IN (select iAppId from applicationfollowup where dispoType=1 and PTPDate IS NOT NULL) and agentId='" . $_SESSION['elisionloginid'] . "'"));
//                                                            echo $PTP['totalCount'];
//                                                        }
                        ?>
                                                                            </td>
                                                                            <td>
                        <?php
//                                                        $Follow = mysqli_fetch_array(mysqli_query($dbconn, "SELECT count(*) as `totalCount` FROM `application` WHERE isFollowDone=1 and iAppId IN (select iAppId from applicationfollowup where dispoType=1 and followupDate IS NOT NULL)"));
//                                                        echo $Follow['totalCount'];
//                                                        if ($_SESSION['Designation'] == 6) {
//                                                            $Follow = mysqli_fetch_array(mysqli_query($dbconn, "SELECT count(*) as `totalCount` FROM `application` WHERE isFollowDone=1 and iAppId IN (select iAppId from applicationfollowup where dispoType=1 and followupDate IS NOT NULL)"));
//                                                            echo $Follow['totalCount'];
//                                                        } else if ($_SESSION['Designation'] == 4) {
//                                                            $Follow = mysqli_fetch_array(mysqli_query($dbconn, "SELECT count(*) as `totalCount` FROM `application` where isFollowDone=1 and iAppId IN (select iAppId from applicationfollowup where dispoType=1 and followupDate IS NOT NULL) and agentId in (SELECT elisionloginid FROM employee where employee.iteamleadid='" . $_SESSION['EmployeeId'] . "')"));
//                                                            echo $Follow['totalCount'];
//                                                        } else {
//                                                            $Follow = mysqli_fetch_array(mysqli_query($dbconn, "SELECT count(*) as `totalCount` FROM `application` where isFollowDone=1 and iAppId IN (select iAppId from applicationfollowup where dispoType=1 and followupDate IS NOT NULL) and agentId='" . $_SESSION['elisionloginid'] . "'"));
//                                                            echo $Follow['totalCount'];
//                                                        }
                        ?>
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>-->
                        <?php if ($_SESSION['Designation'] == 5) { ?>
                            <div class="row">
                                <div class="portlet light ">
                                    <div class="portlet-title">
                                        <div class="caption grey-gallery">
                                            <i class="icon-settings grey-gallery"></i>
                                            <span class="caption-subject bold uppercase">CRM Dashboard</span>
                                        </div>
                                    </div>
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
                                                while ($rowEmployee = mysqli_fetch_array($filterTL)) {
                                                    ?>
                                                    <tr>
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
                                                        <!---------------------------------- MTD ----------------------------------->
                                                        <td>
                                                            <?php
                                                            $filterTotalAttemptLeads = mysqli_fetch_array(mysqli_query($dbconn, "SELECT count(*) as `totalCount` FROM `applicationfollowup` where iAppId IN (select iAppId from application where agentId='" . $rowEmployee['elisionloginid'] . "' and isWithdraw='0') and MONTH(STR_TO_DATE(strEntryDate,'%d-%m-%Y'))=MONTH(CURRENT_DATE()) and YEAR(STR_TO_DATE(strEntryDate,'%d-%m-%Y'))=YEAR(CURRENT_DATE())"));
                                                            echo $filterTotalAttemptLeads['totalCount'];
                                                            $addData[2]+=$filterTotalAttemptLeads['totalCount'];
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
                                                        $filterTotalzeroDialLeads = mysqli_fetch_array(mysqli_query($dbconn, "SELECT count(*) as `totalCount` FROM `application` where iAppId NOT IN ( select iAppId from applicationfollowup where MONTH(STR_TO_DATE(strEntryDate,'%d-%m-%Y'))=MONTH(CURRENT_DATE()) and YEAR(STR_TO_DATE(strEntryDate,'%d-%m-%Y'))=YEAR(CURRENT_DATE())) and agentId='" . $rowEmployee['elisionloginid'] . "' and isWithdraw='0' and isPaid='0'"));
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
                                                            $filterTotalPaidLeads = mysqli_fetch_array(mysqli_query($dbconn, "SELECT count(*) as `totalCount` FROM `application` where agentId='" . $rowEmployee['elisionloginid'] . "' and isWithdraw='0' and isPaid='1' and MONTH(STR_TO_DATE(strEntryDate,'%d-%m-%Y'))=MONTH(CURRENT_DATE()) and YEAR(STR_TO_DATE(strEntryDate,'%d-%m-%Y'))=YEAR(CURRENT_DATE())"));
                                                            echo $filterTotalPaidLeads['totalCount'];
                                                            $addData[5]+=$filterTotalPaidLeads['totalCount'];
                                                            ?>
                                                        </td>
                                                        <td>
                                                            <?php
                                                            $filterTotalPTPLeads = mysqli_fetch_array(mysqli_query($dbconn, "SELECT count(*) as `totalCount` FROM `applicationfollowup` where iAppId IN (select iAppId from application where agentId='" . $rowEmployee['elisionloginid'] . "' and isWithdraw='0') and  PTPDate <>'' and MONTH(STR_TO_DATE(strEntryDate,'%d-%m-%Y'))=MONTH(CURRENT_DATE()) and YEAR(STR_TO_DATE(strEntryDate,'%d-%m-%Y'))=YEAR(CURRENT_DATE())"));
                                                            echo $filterTotalPTPLeads['totalCount'];
                                                            $addData[6]+=$filterTotalPTPLeads['totalCount'];
                                                            ?>
                                                        </td>
                                                        <!---------------------------------- FTD ----------------------------------->
                                                        <td>
                                                            <?php
                                                            $filterTodaysAttemptLeads = mysqli_fetch_array(mysqli_query($dbconn, "SELECT count(*) as `totalCount` FROM `applicationfollowup` where iAppId IN (select iAppId from application where agentId='" . $rowEmployee['elisionloginid'] . "' and isWithdraw='0') and MONTH(STR_TO_DATE(strEntryDate,'%d-%m-%Y'))=MONTH(CURRENT_DATE()) and YEAR(STR_TO_DATE(strEntryDate,'%d-%m-%Y'))=YEAR(CURRENT_DATE()) and STR_TO_DATE(strEntryDate,'%d-%m-%Y') = CURRENT_DATE()"));
                                                            echo $filterTodaysAttemptLeads['totalCount'];
                                                            $addData[7]+=$filterTodaysAttemptLeads['totalCount'];
                                                            ?>
                                                        </td>
                                                        <td>
                                                            <?php
                                                            $filterTodaysConnectLeads = mysqli_fetch_array(mysqli_query($dbconn, "SELECT count(*) as `totalCount` FROM `applicationfollowup` where iAppId IN (select iAppId from application where agentId='" . $rowEmployee['elisionloginid'] . "' and isWithdraw='0') and dispoType='1' and MONTH(STR_TO_DATE(strEntryDate,'%d-%m-%Y'))=MONTH(CURRENT_DATE()) and YEAR(STR_TO_DATE(strEntryDate,'%d-%m-%Y'))=YEAR(CURRENT_DATE()) and STR_TO_DATE(strEntryDate,'%d-%m-%Y') = CURRENT_DATE()"));
                                                            echo $filterTodaysConnectLeads['totalCount'];
                                                            $addData[8]+=$filterTodaysConnectLeads['totalCount'];
                                                            ?>
                                                        </td>

                                                        <?php
                                                        $filterTodaysZeroDialLeads = mysqli_fetch_array(mysqli_query($dbconn, "SELECT count(*) as `totalCount` FROM `application` where iAppId NOT IN ( select iAppId from applicationfollowup where MONTH(STR_TO_DATE(strEntryDate,'%d-%m-%Y'))=MONTH(CURRENT_DATE()) and YEAR(STR_TO_DATE(strEntryDate,'%d-%m-%Y'))=YEAR(CURRENT_DATE()) and STR_TO_DATE(strEntryDate,'%d-%m-%Y') = CURRENT_DATE()) and agentId='" . $rowEmployee['elisionloginid'] . "' and isWithdraw='0' and isPaid='0'"));
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
                                                            $filterTodaysPTPLeads = mysqli_fetch_array(mysqli_query($dbconn, "SELECT count(*) as `totalCount` FROM `applicationfollowup` where iAppId IN (select iAppId from application where agentId='" . $rowEmployee['elisionloginid'] . "' and isWithdraw='0') and  PTPDate <>'' and MONTH(STR_TO_DATE(strEntryDate,'%d-%m-%Y'))=MONTH(CURRENT_DATE()) and YEAR(STR_TO_DATE(strEntryDate,'%d-%m-%Y'))=YEAR(CURRENT_DATE()) and STR_TO_DATE(strEntryDate,'%d-%m-%Y') = CURRENT_DATE()"));
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
                    </div>
                    <script src="<?php echo $web_url; ?>Employee/assets/global/plugins/datatables/datatables.js" type="text/javascript"></script>
                    <script src="<?php echo $web_url; ?>Employee/assets/global/plugins/datatables/table-datatables-responsive.js" type="text/javascript"></script>
                    <script>
                                                                $(document).ready(function () {
                                                                    $('#tableC').DataTable({
                                                                    });
                                                                });
                    </script>
                </div>
                <!-- END DASHBOARD STATS 1-->
            </div>
            <!-- END CONTENT BODY -->
        </div>
        <!-- END CONTENT -->
        <!-- BEGIN QUICK SIDEBAR -->
        <a href="javascript:;" class="page-quick-sidebar-toggler">
            <i class="icon-login"></i>
        </a>
        <!-- END QUICK SIDEBAR -->
        <!-- END CONTAINER -->
        <!-- BEGIN FOOTER -->
        <?php include_once './footer.php'; ?>
        <!-- END FOOTER -->
    </div>
    <!-- BEGIN CORE PLUGINS -->
    <?php include_once './footerjs.php'; ?>
</body>
</html>