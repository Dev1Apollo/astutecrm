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
                    <!-- END DASHBOARD STATS 1-->
                    
                    <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="portlet light ">
                                                            <!--<div class="portlet-title">
                                                                <div class="caption grey-gallery">
                                                                    <i class="icon-settings grey-gallery"></i>
                                                                    <span class="caption-subject bold uppercase">Lead Detail</span>
                                                                </div>
                                                            </div>-->
                                                            <div class="portlet-body">
                                                                <table class="table table-bordered table-hover center table-responsive" width="100%" id="tableC">
                                                                    <thead class="tbg">
                                                                        <tr>
                                                                            <th class="pop_in_heading" colspan="6"></th>
                                                                            <th class="pop_in_heading" colspan="3">MTD</th>
                                                                            <th class="pop_in_heading" colspan="5">FTD</th>
                                                                        </tr>
                                                                        <tr>
                                                                            <!--<th class="pop_in_heading">Total Leads</th>
                                                                            <th class="pop_in_heading">Unresolved  Leads</th>
                                                                            <th class="pop_in_heading">Connected</th>
                                                                            <th class="pop_in_heading">Not Connected</th>
                                                                            <th class="pop_in_heading">PTP</th>
                                                                            <th class="pop_in_heading">Follow-up</th>-->
                                                                            
                                                                            <th class="pop_in_heading_1">Total <br /> Allocation</th>
                                                                            <th class="pop_in_heading_1">Unpaid <br />Count</th>
                                                                            <th class="pop_in_heading_1">Paid <br />Count</th>
                                                                            <th class="pop_in_heading_1">Paid <br />Amount</th>
                                                                            <th class="pop_in_heading_1">PTP <br />Count</th>
                                                                            <th class="pop_in_heading_1">PTP <br />Amount</th>
                                                                            
                                                                            <th class="pop_in_heading_1">Attempt</th>
                                                                            <th class="pop_in_heading_1">Connect</th>
                                                                            <th class="pop_in_heading_1">Zero <br />Dial</th>
                                                                            
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
                                                                                    if ($_SESSION['Designation'] == 6) {
                                                                                        $totalLeat = mysqli_fetch_array(mysqli_query($dbconn, "SELECT count(*) as `totalCount` FROM `application`"));
                                                                                        echo $totalLeat['totalCount'];
                                                                                    } else if ($_SESSION['Designation'] == 4) {
                                                                                        $totalLeat = mysqli_fetch_array(mysqli_query($dbconn, "SELECT count(*) as `totalCount` FROM `application` where agentId in (SELECT elisionloginid FROM employee where employee.iteamleadid='" . $_SESSION['EmployeeId'] . "')"));
                                                                                        echo $totalLeat['totalCount'];
                                                                                    } else {
                                                                                        $totalLeat = mysqli_fetch_array(mysqli_query($dbconn, "SELECT count(*) as `totalCount` FROM `application` where agentId='" . $_SESSION['elisionloginid'] . "'"));
                                                                                        echo $totalLeat['totalCount'];
                                                                                    }
                                                                                ?>
                                                                            </td>
                                                                            <!--<td>
                                                                                <?php
                                                                                    if ($_SESSION['Designation'] == 6) {
                                                                                        $FreshLeads = mysqli_fetch_array(mysqli_query($dbconn, "SELECT count(*) as `totalCount` FROM `application` WHERE  isWithdraw=0"));
                                                                                        echo $FreshLeads['totalCount'];
                                                                                    } else if ($_SESSION['Designation'] == 4) {
                                                                                        $FreshLeads = mysqli_fetch_array(mysqli_query($dbconn, "SELECT count(*) as `totalCount` FROM `application` where isWithdraw=0 and agentId in (SELECT elisionloginid FROM employee where employee.iteamleadid='" . $_SESSION['EmployeeId'] . "')"));
                                                                                        echo $FreshLeads['totalCount'];
                                                                                    } else {
                                                                                        $FreshLeads = mysqli_fetch_array(mysqli_query($dbconn, "SELECT count(*) as `totalCount` FROM `application` where isWithdraw=0 and agentId='" . $_SESSION['elisionloginid'] . "'"));
                                                                                        echo $FreshLeads['totalCount'];
                                                                                    }
                                                                                ?>
                                                                            </td>-->
                                                                            <td>
                                                                                <?php
                                                                                    if ($_SESSION['Designation'] == 6) {
                                                                                        $filterTotalUnpaidLeads = mysqli_fetch_array(mysqli_query($dbconn, "SELECT count(*) as `totalCount` FROM `application` WHERE  isPaid=0 and isWithdraw=0"));
                                                                                        echo $filterTotalUnpaidLeads['totalCount'];
                                                                                    } else if ($_SESSION['Designation'] == 4) {
                                                                                        $filterTotalUnpaidLeads = mysqli_fetch_array(mysqli_query($dbconn, "SELECT count(*) as `totalCount` FROM `application` where isPaid=0 and isWithdraw=0 and agentId in (SELECT elisionloginid FROM employee where employee.iteamleadid='" . $_SESSION['EmployeeId'] . "')"));
                                                                                        echo $filterTotalUnpaidLeads['totalCount'];
                                                                                    } else {
                                                                                        $filterTotalUnpaidLeads = mysqli_fetch_array(mysqli_query($dbconn, "SELECT count(*) as `totalCount` FROM `application` where isPaid=0 and isWithdraw=0 and agentId='" . $_SESSION['elisionloginid'] . "'"));
                                                                                        echo $filterTotalUnpaidLeads['totalCount'];
                                                                                    }
                                                                                ?>
                                                                            </td>
                                                                            
                                                                            <td>
                                                                                <?php
                                                                                    if ($_SESSION['Designation'] == 6) {
                                                                                        $filterTotalPaidLeads = mysqli_fetch_array(mysqli_query($dbconn, "SELECT count(*) as `totalCount` FROM `application` WHERE  isPaid=1 and isWithdraw=0"));
                                                                                        echo $filterTotalPaidLeads['totalCount'];
                                                                                    } else if ($_SESSION['Designation'] == 4) {
                                                                                        $filterTotalPaidLeads = mysqli_fetch_array(mysqli_query($dbconn, "SELECT count(*) as `totalCount` FROM `application` where isPaid=1 and isWithdraw=0 and agentId in (SELECT elisionloginid FROM employee where employee.iteamleadid='" . $_SESSION['EmployeeId'] . "')"));
                                                                                        echo $filterTotalPaidLeads['totalCount'];
                                                                                    } else {
                                                                                        $filterTotalPaidLeads = mysqli_fetch_array(mysqli_query($dbconn, "SELECT count(*) as `totalCount` FROM `application` where isPaid=1 and isWithdraw=0 and agentId='" . $_SESSION['elisionloginid'] . "'"));
                                                                                        echo $filterTotalPaidLeads['totalCount'];
                                                                                    }
                                                                                ?>
                                                                            </td>
                                                                            
                                                                            <td>
                                                                                <?php
                                                                                    if ($_SESSION['Designation'] == 6) {
                                                                                        $filterTotalPaidAmts = mysqli_fetch_array(mysqli_query($dbconn, "SELECT sum(paid_amount) as `paid_amount` FROM `application` inner join application_payment_history on application.iAppId=application_payment_history.application_id where application.isWithdraw='0' and application.isPaid='1'"));
                                                                                        echo $filterTotalPaidAmts['paid_amount'];
                                                                                    } else if ($_SESSION['Designation'] == 4) {
                                                                                        $filterTotalPaidAmts = mysqli_fetch_array(mysqli_query($dbconn, "SELECT sum(paid_amount) as `paid_amount` FROM `application` inner join application_payment_history on application.iAppId=application_payment_history.application_id where and application.isWithdraw='0' and application.isPaid='1 and agentId in (SELECT elisionloginid FROM employee where employee.iteamleadid='" . $_SESSION['EmployeeId'] . "')"));
                                                                                        echo $filterTotalPaidAmts['paid_amount'];
                                                                                    } else {
                                                                                        $filterTotalPaidAmts = mysqli_fetch_array(mysqli_query($dbconn, "SELECT sum(paid_amount) as `paid_amount` FROM `application` inner join application_payment_history on application.iAppId=application_payment_history.application_id where and application.isWithdraw='0' and application.isPaid='1 and agentId='" . $_SESSION['elisionloginid'] . "'"));
                                                                                        echo $filterTotalPaidAmts['paid_amount'];
                                                                                    }
                                                                                ?>
                                                                            </td>
                                                                            
                                                                            <td>
                                                                                <?php
                                                                                    if ($_SESSION['Designation'] == 6) {
                                                                                        $Connected = mysqli_fetch_array(mysqli_query($dbconn, "SELECT count(*) as `totalCount` FROM application a LEFT JOIN applicationfollowup f ON a.iAppLogId = f.iAppLogId where a.isWithdraw='0' and a.isPaid = 0 AND a.isDelete = 0 AND a.iStatus = 1  AND f.iAppLogId = (SELECT ff.iAppLogId FROM applicationfollowup ff WHERE ff.iAppLogId = a.iAppLogId ORDER BY STR_TO_DATE(ff.strEntryDate, '%d-%m-%Y') DESC LIMIT 1)  AND f.mainDispoId = 12"));
                                                                                        echo $Connected['totalCount'];
                                                                                    } else if ($_SESSION['Designation'] == 4) {
                                                                                        $Connected = mysqli_fetch_array(mysqli_query($dbconn, "SELECT count(*) as `totalCount` FROM application a LEFT JOIN applicationfollowup f ON a.iAppLogId = f.iAppLogId where a.isWithdraw='0' and a.isPaid = 0 AND a.isDelete = 0 AND a.iStatus = 1  AND agentId in (SELECT elisionloginid FROM employee where employee.iteamleadid='" . $_SESSION['EmployeeId'] . "') AND f.iAppLogId = (SELECT ff.iAppLogId FROM applicationfollowup ff WHERE ff.iAppLogId = a.iAppLogId ORDER BY STR_TO_DATE(ff.strEntryDate, '%d-%m-%Y') DESC LIMIT 1)  AND f.mainDispoId = 12"));
                                                                                        echo $Connected['totalCount'];
                                                                                    } else {
                                                                                        $Connected = mysqli_fetch_array(mysqli_query($dbconn, "SELECT count(*) as `totalCount` FROM application a LEFT JOIN applicationfollowup f ON a.iAppLogId = f.iAppLogId where a.isWithdraw='0' and a.isPaid = 0 AND a.isDelete = 0 AND a.iStatus = 1  AND agentId='" . $_SESSION['elisionloginid'] . "' AND f.iAppLogId = (SELECT ff.iAppLogId FROM applicationfollowup ff WHERE ff.iAppLogId = a.iAppLogId ORDER BY STR_TO_DATE(ff.strEntryDate, '%d-%m-%Y') DESC LIMIT 1)  AND f.mainDispoId = 12"));
                                                                                        echo $Connected['totalCount'];
                                                                                    }
                                                                                ?>
                                                                            </td>
                                                                            
                                                                            
                                                                            
                                                                            
                                                                            <td>
                                                                                <?php
                                                                                    // $NotConnected = mysqli_fetch_array(mysqli_query($dbconn, "SELECT count(*) as `totalCount` FROM `application` WHERE isFollowDone=1 and iAppId IN (select iAppId from applicationfollowup where dispoType=0)"));
                                                                                    // echo $NotConnected['totalCount'];
                                                                                    // if ($_SESSION['Designation'] == 6) {
                                                                                    //     $NotConnected = mysqli_fetch_array(mysqli_query($dbconn, "SELECT count(*) as `totalCount` FROM `application` WHERE isFollowDone=1 and iAppId IN (select iAppId from applicationfollowup where dispoType=0)"));
                                                                                    //     echo $NotConnected['totalCount'];
                                                                                    // } else if ($_SESSION['Designation'] == 4) {
                                                                                    //     $NotConnected = mysqli_fetch_array(mysqli_query($dbconn, "SELECT count(*) as `totalCount` FROM `application` where isFollowDone=1 and iAppId IN (select iAppId from applicationfollowup where dispoType=0) and agentId in (SELECT elisionloginid FROM employee where employee.iteamleadid='" . $_SESSION['EmployeeId'] . "')"));
                                                                                    //     echo $NotConnected['totalCount'];
                                                                                    // } else {
                                                                                    //     $NotConnected = mysqli_fetch_array(mysqli_query($dbconn, "SELECT count(*) as `totalCount` FROM `application` where isFollowDone=1 and iAppId IN (select iAppId from applicationfollowup where dispoType=0) and agentId='" . $_SESSION['elisionloginid'] . "'"));
                                                                                    //     echo $NotConnected['totalCount'];
                                                                                    // }
                                                                                    
                                                                                    if ($_SESSION['Designation'] == 6) {
                                                                                        $PTP_Amount = mysqli_fetch_array(mysqli_query($dbconn, "SELECT sum(PTP_Amount) as `PTP_Amount` FROM application a LEFT JOIN applicationfollowup f ON a.iAppLogId = f.iAppLogId where a.isWithdraw='0' and a.isPaid = 0 AND a.isDelete = 0 AND a.iStatus = 1  AND f.iAppLogId = (SELECT ff.iAppLogId FROM applicationfollowup ff WHERE ff.iAppLogId = a.iAppLogId ORDER BY STR_TO_DATE(ff.strEntryDate, '%d-%m-%Y') DESC LIMIT 1)  AND f.mainDispoId = 12"));
                                                                                        echo $PTP_Amount['PTP_Amount'];
                                                                                    } else if ($_SESSION['Designation'] == 4) {
                                                                                        $PTP_Amount = mysqli_fetch_array(mysqli_query($dbconn, "SELECT sum(PTP_Amount) as `PTP_Amount` FROM application a LEFT JOIN applicationfollowup f ON a.iAppLogId = f.iAppLogId where a.isWithdraw='0' and a.isPaid = 0 AND a.isDelete = 0 AND a.iStatus = 1  AND agentId in (SELECT elisionloginid FROM employee where employee.iteamleadid='" . $_SESSION['EmployeeId'] . "') AND f.iAppLogId = (SELECT ff.iAppLogId FROM applicationfollowup ff WHERE ff.iAppLogId = a.iAppLogId ORDER BY STR_TO_DATE(ff.strEntryDate, '%d-%m-%Y') DESC LIMIT 1)  AND f.mainDispoId = 12"));
                                                                                        echo $PTP_Amount['PTP_Amount'];
                                                                                    } else {
                                                                                        $PTP_Amount = mysqli_fetch_array(mysqli_query($dbconn, "SELECT sum(PTP_Amount) as `PTP_Amount` FROM application a LEFT JOIN applicationfollowup f ON a.iAppLogId = f.iAppLogId where a.isWithdraw='0' and a.isPaid = 0 AND a.isDelete = 0 AND a.iStatus = 1  AND agentId='" . $_SESSION['elisionloginid'] . "' AND f.iAppLogId = (SELECT ff.iAppLogId FROM applicationfollowup ff WHERE ff.iAppLogId = a.iAppLogId ORDER BY STR_TO_DATE(ff.strEntryDate, '%d-%m-%Y') DESC LIMIT 1)  AND f.mainDispoId = 12"));
                                                                                        echo $PTP_Amount['PTP_Amount'];
                                                                                    }
                                                                                ?>
                                                                            </td>
                                                                            <td>
                                                                                <?php
                                                                                    if ($_SESSION['Designation'] == 6) {
                                                                                        $PTP = mysqli_fetch_array(mysqli_query($dbconn, "SELECT count(*) as `totalCount` FROM `applicationfollowup` where iAppId IN (select iAppId from application where isWithdraw='0') and MONTH(STR_TO_DATE(strEntryDate,'%d-%m-%Y'))=MONTH(CURRENT_DATE()) and YEAR(STR_TO_DATE(strEntryDate,'%d-%m-%Y'))=YEAR(CURRENT_DATE())"));
                                                                                        echo $PTP['totalCount'];
                                                                                        
                                                                                    } else if ($_SESSION['Designation'] == 4) {
                                                                                        $PTP = mysqli_fetch_array(mysqli_query($dbconn, "SELECT count(*) as `totalCount` FROM `applicationfollowup` where iAppId IN (select iAppId from application where isWithdraw='0') and MONTH(STR_TO_DATE(strEntryDate,'%d-%m-%Y'))=MONTH(CURRENT_DATE()) and YEAR(STR_TO_DATE(strEntryDate,'%d-%m-%Y'))=YEAR(CURRENT_DATE()) and agentId in (SELECT elisionloginid FROM employee where employee.iteamleadid='" . $_SESSION['EmployeeId'] . "')"));
                                                                                        echo $PTP['totalCount'];
                                                                                    } else {
                                                                                        $PTP = mysqli_fetch_array(mysqli_query($dbconn, "SELECT count(*) as `totalCount` FROM `applicationfollowup` where iAppId IN (select iAppId from application where isWithdraw='0') and MONTH(STR_TO_DATE(strEntryDate,'%d-%m-%Y'))=MONTH(CURRENT_DATE()) and YEAR(STR_TO_DATE(strEntryDate,'%d-%m-%Y'))=YEAR(CURRENT_DATE()) and agentId='" . $_SESSION['elisionloginid'] . "'"));
                                                                                        echo $PTP['totalCount'];
                                                                                    }
                                                                                ?>
                                                                            </td>
                                                                            <td>
                                                                                <?php
                                                                                    if ($_SESSION['Designation'] == 6) {
                                                                                        $FollowConnect = mysqli_fetch_array(mysqli_query($dbconn, "SELECT count(*) as `totalCount` FROM `applicationfollowup` where iAppId IN (select iAppId from application where isWithdraw='0') and dispoType='1' and MONTH(STR_TO_DATE(strEntryDate,'%d-%m-%Y'))=MONTH(CURRENT_DATE()) and YEAR(STR_TO_DATE(strEntryDate,'%d-%m-%Y'))=YEAR(CURRENT_DATE())"));
                                                                                        echo $FollowConnect['totalCount'];
                                                                                    } else if ($_SESSION['Designation'] == 4) {
                                                                                        $FollowConnect = mysqli_fetch_array(mysqli_query($dbconn, "SELECT count(*) as `totalCount` FROM `applicationfollowup` where iAppId IN (select iAppId from application where isWithdraw='0' and agentId in (SELECT elisionloginid FROM employee where employee.iteamleadid='" . $_SESSION['EmployeeId'] . "')) and dispoType='1' and MONTH(STR_TO_DATE(strEntryDate,'%d-%m-%Y'))=MONTH(CURRENT_DATE()) and YEAR(STR_TO_DATE(strEntryDate,'%d-%m-%Y'))=YEAR(CURRENT_DATE())"));
                                                                                        echo $FollowConnect['totalCount'];
                                                                                    } else {
                                                                                        $FollowConnect = mysqli_fetch_array(mysqli_query($dbconn, "SELECT count(*) as `totalCount` FROM `applicationfollowup` where iAppId IN (select iAppId from application where agentId='" . $_SESSION['elisionloginid'] . "' and isWithdraw='0') and dispoType='1' and MONTH(STR_TO_DATE(strEntryDate,'%d-%m-%Y'))=MONTH(CURRENT_DATE()) and YEAR(STR_TO_DATE(strEntryDate,'%d-%m-%Y'))=YEAR(CURRENT_DATE())"));
                                                                                        echo $FollowConnect['totalCount'];
                                                                                    }
                                                                                ?>
                                                                            </td>
                                                                            
                                                                            <td>
                                                                                <?php
                                                                                    if ($_SESSION['Designation'] == 6) {
                                                                                        $ZeroDeal = mysqli_fetch_array(mysqli_query($dbconn, "SELECT count(*) as `totalCount` FROM `application` where iAppId NOT IN (select iAppId from applicationfollowup where MONTH(STR_TO_DATE(strEntryDate,'%d-%m-%Y'))=MONTH(CURRENT_DATE()) and YEAR(STR_TO_DATE(strEntryDate,'%d-%m-%Y'))=YEAR(CURRENT_DATE())) and isWithdraw='0' and isPaid='0'"));
                                                                                        echo $ZeroDeal['totalCount'];
                                                                                    } else if ($_SESSION['Designation'] == 4) {
                                                                                        $ZeroDeal = mysqli_fetch_array(mysqli_query($dbconn, "SELECT count(*) as `totalCount` FROM `application` where iAppId NOT IN (select iAppId from applicationfollowup where MONTH(STR_TO_DATE(strEntryDate,'%d-%m-%Y'))=MONTH(CURRENT_DATE()) and YEAR(STR_TO_DATE(strEntryDate,'%d-%m-%Y'))=YEAR(CURRENT_DATE())) and isWithdraw='0' and isPaid='0' and agentId in (SELECT elisionloginid FROM employee where employee.iteamleadid='" . $_SESSION['EmployeeId'] . "') "));
                                                                                        //$ZeroDeal = mysqli_fetch_array(mysqli_query($dbconn, "SELECT count(*) as `totalCount` FROM `applicationfollowup` where iAppId IN (select iAppId from application where isWithdraw='0' and agentId in (SELECT elisionloginid FROM employee where employee.iteamleadid='" . $_SESSION['EmployeeId'] . "')) and dispoType='1' and MONTH(STR_TO_DATE(strEntryDate,'%d-%m-%Y'))=MONTH(CURRENT_DATE()) and YEAR(STR_TO_DATE(strEntryDate,'%d-%m-%Y'))=YEAR(CURRENT_DATE())"));
                                                                                        echo $ZeroDeal['totalCount'];
                                                                                    } else {
                                                                                        $ZeroDeal = mysqli_fetch_array(mysqli_query($dbconn, "SELECT count(*) as `totalCount` FROM `application` where iAppId NOT IN (select iAppId from applicationfollowup where MONTH(STR_TO_DATE(strEntryDate,'%d-%m-%Y'))=MONTH(CURRENT_DATE()) and YEAR(STR_TO_DATE(strEntryDate,'%d-%m-%Y'))=YEAR(CURRENT_DATE())) and agentId='" . $_SESSION['elisionloginid'] . "' and isWithdraw='0' and isPaid='0'"));
                                                                                        echo $ZeroDeal['totalCount'];
                                                                                    }
                                                                                ?>
                                                                            </td>
                                                                            
                                                                            <td>
                                                                                <?php
                                                                                    if ($_SESSION['Designation'] == 6) {
                                                                                        $FTDAttempt = mysqli_fetch_array(mysqli_query($dbconn, "SELECT count(*) as `totalCount` FROM `applicationfollowup` where iAppId IN (select iAppId from application where isWithdraw='0') and MONTH(STR_TO_DATE(strEntryDate,'%d-%m-%Y'))=MONTH(CURRENT_DATE()) and YEAR(STR_TO_DATE(strEntryDate,'%d-%m-%Y'))=YEAR(CURRENT_DATE()) and STR_TO_DATE(strEntryDate,'%d-%m-%Y') = CURRENT_DATE()"));
                                                                                        echo $FTDAttempt['totalCount'];
                                                                                    } else if ($_SESSION['Designation'] == 4) {
                                                                                        $FTDAttempt = mysqli_fetch_array(mysqli_query($dbconn, "SELECT count(*) as `totalCount` FROM `applicationfollowup` where iAppId IN (select iAppId from application where isWithdraw='0'  and agentId in (SELECT elisionloginid FROM employee where employee.iteamleadid='" . $_SESSION['EmployeeId'] . "')) and MONTH(STR_TO_DATE(strEntryDate,'%d-%m-%Y'))=MONTH(CURRENT_DATE()) and YEAR(STR_TO_DATE(strEntryDate,'%d-%m-%Y'))=YEAR(CURRENT_DATE()) and STR_TO_DATE(strEntryDate,'%d-%m-%Y') = CURRENT_DATE()"));
                                                                                        echo $FTDAttempt['totalCount'];
                                                                                    } else {
                                                                                        $FTDAttempt = mysqli_fetch_array(mysqli_query($dbconn, "SELECT count(*) as `totalCount` FROM `applicationfollowup` where iAppId IN (select iAppId from application where agentId='" . $_SESSION['elisionloginid'] . "' and isWithdraw='0') and MONTH(STR_TO_DATE(strEntryDate,'%d-%m-%Y'))=MONTH(CURRENT_DATE()) and YEAR(STR_TO_DATE(strEntryDate,'%d-%m-%Y'))=YEAR(CURRENT_DATE()) and STR_TO_DATE(strEntryDate,'%d-%m-%Y') = CURRENT_DATE()"));
                                                                                        echo $FTDAttempt['totalCount'];
                                                                                    }
                                                                                ?>
                                                                            </td>
                                                                            
                                                                            <td>
                                                                                <?php
                                                                                    if ($_SESSION['Designation'] == 6) {
                                                                                        $FTDConnect = mysqli_fetch_array(mysqli_query($dbconn, "SELECT count(*) as `totalCount` FROM `applicationfollowup` where iAppId IN (select iAppId from application where isWithdraw='0') and dispoType='1' and MONTH(STR_TO_DATE(strEntryDate,'%d-%m-%Y'))=MONTH(CURRENT_DATE()) and YEAR(STR_TO_DATE(strEntryDate,'%d-%m-%Y'))=YEAR(CURRENT_DATE()) and STR_TO_DATE(strEntryDate,'%d-%m-%Y') = CURRENT_DATE()"));
                                                                                        echo $FTDConnect['totalCount'];
                                                                                    } else if ($_SESSION['Designation'] == 4) {
                                                                                        $FTDConnect = mysqli_fetch_array(mysqli_query($dbconn, "SELECT count(*) as `totalCount` FROM `applicationfollowup` where iAppId IN (select iAppId from application where isWithdraw='0'  and agentId in (SELECT elisionloginid FROM employee where employee.iteamleadid='" . $_SESSION['EmployeeId'] . "')) and MONTH(STR_TO_DATE(strEntryDate,'%d-%m-%Y'))=MONTH(CURRENT_DATE()) and YEAR(STR_TO_DATE(strEntryDate,'%d-%m-%Y'))=YEAR(CURRENT_DATE()) and STR_TO_DATE(strEntryDate,'%d-%m-%Y') = CURRENT_DATE() "));
                                                                                        echo $FTDConnect['totalCount'];
                                                                                    } else {
                                                                                        $FTDConnect = mysqli_fetch_array(mysqli_query($dbconn, "SELECT count(*) as `totalCount` FROM `applicationfollowup` where iAppId IN (select iAppId from application where agentId='" . $_SESSION['elisionloginid'] . "' and isWithdraw='0') and dispoType='1' and MONTH(STR_TO_DATE(strEntryDate,'%d-%m-%Y'))=MONTH(CURRENT_DATE()) and YEAR(STR_TO_DATE(strEntryDate,'%d-%m-%Y'))=YEAR(CURRENT_DATE()) and STR_TO_DATE(strEntryDate,'%d-%m-%Y') = CURRENT_DATE()"));
                                                                                        echo $FTDConnect['totalCount'];
                                                                                    }
                                                                                ?>
                                                                            </td>
                                                                            <td>
                                                                                <?php
                                                                                    if ($_SESSION['Designation'] == 6) {
                                                                                        $FTDZeroDeal = mysqli_fetch_array(mysqli_query($dbconn, "SELECT count(*) as `totalCount` FROM `application` where iAppId NOT IN (select iAppId from applicationfollowup where MONTH(STR_TO_DATE(strEntryDate,'%d-%m-%Y'))=MONTH(CURRENT_DATE()) and YEAR(STR_TO_DATE(strEntryDate,'%d-%m-%Y'))=YEAR(CURRENT_DATE()) and STR_TO_DATE(strEntryDate,'%d-%m-%Y') = CURRENT_DATE())  and isWithdraw='0' and isPaid='0' "));
                                                                                        echo $FTDZeroDeal['totalCount'];
                                                                                    } else if ($_SESSION['Designation'] == 4) {
                                                                                        $FTDZeroDeal = mysqli_fetch_array(mysqli_query($dbconn, "SELECT count(*) as `totalCount` FROM `application` where iAppId NOT IN (select iAppId from applicationfollowup where MONTH(STR_TO_DATE(strEntryDate,'%d-%m-%Y'))=MONTH(CURRENT_DATE()) and YEAR(STR_TO_DATE(strEntryDate,'%d-%m-%Y'))=YEAR(CURRENT_DATE()) and STR_TO_DATE(strEntryDate,'%d-%m-%Y') = CURRENT_DATE())  and isWithdraw='0' and isPaid='0' and agentId in (SELECT elisionloginid FROM employee where employee.iteamleadid='" . $_SESSION['EmployeeId'] . "') "));
                                                                                        echo $FTDZeroDeal['totalCount'];
                                                                                    } else {
                                                                                        $FTDZeroDeal = mysqli_fetch_array(mysqli_query($dbconn, "SELECT count(*) as `totalCount` FROM `application` where iAppId NOT IN (select iAppId from applicationfollowup where MONTH(STR_TO_DATE(strEntryDate,'%d-%m-%Y'))=MONTH(CURRENT_DATE()) and YEAR(STR_TO_DATE(strEntryDate,'%d-%m-%Y'))=YEAR(CURRENT_DATE()) and STR_TO_DATE(strEntryDate,'%d-%m-%Y') = CURRENT_DATE()) and agentId='" . $_SESSION['elisionloginid'] . "' and isWithdraw='0' and isPaid='0' "));
                                                                                        echo $FTDZeroDeal['totalCount'];
                                                                                    }
                                                                                ?>
                                                                            </td>
                                                                            
                                                                            <td>
                                                                                <?php
                                                                                    if ($_SESSION['Designation'] == 6) {
                                                                                        $FTDPTPCount = mysqli_fetch_array(mysqli_query($dbconn, "SELECT count(*) AS todayPTPCount FROM application a LEFT JOIN applicationfollowup f ON a.iAppLogId = f.iAppLogId WHERE a.isWithdraw = 0 AND a.isPaid = 0 AND a.isDelete = 0 AND a.iStatus = 1 AND f.iAppLogId = (SELECT ff.iAppLogId FROM applicationfollowup ff WHERE ff.iAppLogId = a.iAppLogId ORDER BY STR_TO_DATE(ff.strEntryDate, '%d-%m-%Y') DESC LIMIT 1) AND f.mainDispoId = 12 AND STR_TO_DATE(f.strEntryDate, '%d-%m-%Y') = CURRENT_DATE()"));
                                                                                        echo $FTDPTPCount['todayPTPCount'];
                                                                                    } else if ($_SESSION['Designation'] == 4) {
                                                                                        $FTDPTPCount = mysqli_fetch_array(mysqli_query($dbconn, "SELECT count(*) AS todayPTPCount FROM application a LEFT JOIN applicationfollowup f ON a.iAppLogId = f.iAppLogId WHERE a.isWithdraw = 0 AND a.isPaid = 0 AND a.isDelete = 0 AND a.iStatus = 1 AND f.iAppLogId = (SELECT ff.iAppLogId FROM applicationfollowup ff WHERE ff.iAppLogId = a.iAppLogId ORDER BY STR_TO_DATE(ff.strEntryDate, '%d-%m-%Y') DESC LIMIT 1) AND f.mainDispoId = 12 AND STR_TO_DATE(f.strEntryDate, '%d-%m-%Y') = CURRENT_DATE() and agentId in (SELECT elisionloginid FROM employee where employee.iteamleadid='" . $_SESSION['EmployeeId'] . "') "));
                                                                                        echo $FTDPTPCount['todayPTPCount'];
                                                                                    } else {
                                                                                        $FTDPTPCount = mysqli_fetch_array(mysqli_query($dbconn, "SELECT count(*) AS todayPTPCount FROM application a LEFT JOIN applicationfollowup f ON a.iAppLogId = f.iAppLogId WHERE a.agentId = '" . $_SESSION['elisionloginid'] . "' AND a.isWithdraw = 0 AND a.isPaid = 0 AND a.isDelete = 0 AND a.iStatus = 1 AND f.iAppLogId = (SELECT ff.iAppLogId FROM applicationfollowup ff WHERE ff.iAppLogId = a.iAppLogId ORDER BY STR_TO_DATE(ff.strEntryDate, '%d-%m-%Y') DESC LIMIT 1) AND f.mainDispoId = 12 AND STR_TO_DATE(f.strEntryDate, '%d-%m-%Y') = CURRENT_DATE();"));
                                                                                        echo $FTDPTPCount['todayPTPCount'];
                                                                                    }
                                                                                ?>
                                                                            </td>
                                                                            <td>
                                                                                <?php
                                                                                    if ($_SESSION['Designation'] == 6) {
                                                                                        $FTDPTP_Amount = mysqli_fetch_array(mysqli_query($dbconn, "SELECT ifnull(SUM(f.PTP_Amount),0) AS todayPTPAmount FROM application a LEFT JOIN applicationfollowup f ON a.iAppLogId = f.iAppLogId WHERE a.isWithdraw = 0 AND a.isPaid = 0 AND a.isDelete = 0 AND a.iStatus = 1 AND f.iAppLogId = (SELECT ff.iAppLogId FROM applicationfollowup ff WHERE ff.iAppLogId = a.iAppLogId ORDER BY STR_TO_DATE(ff.strEntryDate, '%d-%m-%Y') DESC LIMIT 1) AND f.mainDispoId = 12 AND STR_TO_DATE(f.strEntryDate, '%d-%m-%Y') = CURRENT_DATE()"));
                                                                                        echo $FTDPTP_Amount['todayPTPAmount'];
                                                                                    } else if ($_SESSION['Designation'] == 4) {
                                                                                        $FTDPTP_Amount = mysqli_fetch_array(mysqli_query($dbconn, "SELECT ifnull(SUM(f.PTP_Amount),0) AS todayPTPAmount FROM application a LEFT JOIN applicationfollowup f ON a.iAppLogId = f.iAppLogId WHERE a.isWithdraw = 0 AND a.isPaid = 0 AND a.isDelete = 0 AND a.iStatus = 1 AND f.iAppLogId = (SELECT ff.iAppLogId FROM applicationfollowup ff WHERE ff.iAppLogId = a.iAppLogId ORDER BY STR_TO_DATE(ff.strEntryDate, '%d-%m-%Y') DESC LIMIT 1) AND f.mainDispoId = 12 AND STR_TO_DATE(f.strEntryDate, '%d-%m-%Y') = CURRENT_DATE() and agentId in (SELECT elisionloginid FROM employee where employee.iteamleadid='" . $_SESSION['EmployeeId'] . "')"));
                                                                                        echo $FTDPTP_Amount['todayPTPAmount'];
                                                                                    } else {
                                                                                        $FTDPTP_Amount = mysqli_fetch_array(mysqli_query($dbconn, "SELECT ifnull(SUM(f.PTP_Amount),0) AS todayPTPAmount FROM application a LEFT JOIN applicationfollowup f ON a.iAppLogId = f.iAppLogId WHERE a.agentId = '" . $_SESSION['elisionloginid'] . "' AND a.isWithdraw = 0 AND a.isPaid = 0 AND a.isDelete = 0 AND a.iStatus = 1 AND f.iAppLogId = (SELECT ff.iAppLogId FROM applicationfollowup ff WHERE ff.iAppLogId = a.iAppLogId ORDER BY STR_TO_DATE(ff.strEntryDate, '%d-%m-%Y') DESC LIMIT 1) AND f.mainDispoId = 12 AND STR_TO_DATE(f.strEntryDate, '%d-%m-%Y') = CURRENT_DATE()"));
                                                                                        echo $FTDPTP_Amount['todayPTPAmount'];
                                                                                    }
                                                                                ?>
                                                                            </td>
                                                                            
                                                                            
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                    
                    <div class="portlet light " style="" id="SLID">
                        <div class="portlet-title">
                            <div class="caption font-red-sunglo">
                                <span class="caption-subject bold uppercase">List of CRM</span>
                            </div>
                            <?php if ($_SESSION['Designation'] == 6) { ?>
                                <a href="<?php echo $web_url; ?>Employee/AddCRM.php" class="btn blue pull-right margin-bottom-20" style="float: right;" title="ADD CRM"><i class="fa fa-upload"></i> </a>
                                <a href="CNEmployeeFollowup.php" class="btn green pull-right margin-bottom-20" style="margin-right: 15px;" title="Employee"><i class="fa fa-eye"></i> Employee Followup Details</a>
                                <a href="CNFeedbackReport.php" class="btn green pull-right margin-bottom-20" style="margin-right: 20px;" title="Employee"><i class="fa fa-file-excel-o"></i> Employee Feedback Report</a>
                            <?php } ?>
                        </div>
                        <div class="portlet-body form">
                            <!--<div class="row">
                                <form  role="form"  method="POST"  action="" name="frmSearch"  id="frmSearch" enctype="multipart/form-data">
                                    <input type="hidden" name="Designation" id="Designation" value="<?php echo $_SESSION['Designation']; ?>">
                                    <?php if ($_SESSION['Designation'] == 4) { ?>
                                        <div class="form-group col-md-3">
                                        <?php } else { ?>
                                            <div class="form-group  col-md-3">
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
                                        if ($_SESSION['Designation'] == 4) {
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
                                            <?php if ($_SESSION['Designation'] == 4) { ?>
                                                <a onclick="exportToExcel();" href="#" class="btn green  margin-bottom-20" target="_blank" style="margin-right: 20px; margin-left: 10px;" title="Employee"><i class="fa fa-file-excel-o"></i></a>
                                            <?php } 
                                            if ( $_SESSION['Designation'] == 6){?>
                                                <a onclick="exportToEmployeeData();" href="#" class="btn green  margin-bottom-20" style="margin-right: 20px; margin-left: 10px;" title="Employee"><i class="fa fa-file-excel-o"></i></a>
                                                <?php }
                                            ?>
                                        </div>
                                    </div>
                                </form>
                            </div>-->
                            <div class="row">
                                <div id="PlaceUsersDataHere">
                                </div>
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
    <script type="text/javascript">
                                                    $(function () {
                                                        $("#strfilter").change(function () {
                                                            var strfilter = $(this).val();
                                                            $("#DivDate").html();
                                                            if (strfilter === 'LastCallDate' || strfilter === 'Lastdisposition' || strfilter === 'TotalAttempt' || strfilter === 'TotalConnect' ||strfilter === 'applicatipnNo' || strfilter === 'customerCity' || strfilter === 'customerZipcode' || strfilter === 'state' || strfilter === 'agencyName' || strfilter === 'customerName') {
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

                                                    function PageLoadData(Page) {
                                                        var strfilter = $('#strfilter').val();
                                                        var filterValue = $('#filterValue').val();
                                                        var fromdate = $('#formdate').val();
                                                        var todate = $('#todate').val();
                                                        var EmployeeId = $('#EmployeeId').val();

                                                        $('#loading').css("display", "block");
                                                        $.ajax({
                                                            type: "POST",
                                                            url: "<?php echo $web_url; ?>Employee/AjaxCRM.php",
                                                            data: {action: 'ListUser', Page: Page, strfilter: strfilter, filterValue: filterValue, EmployeeId: EmployeeId, fromdate: fromdate, todate: todate},
                                                            success: function (msg) {
                                                                $('#SLID').show();
                                                                $('#loading').css("display", "none");
                                                                $("#PlaceUsersDataHere").html(msg);
                                                            }
                                                        });
                                                    }// end of filter
//                                                    PageLoadData(1);

                                                    function exportToEmployeeData() {
                                                        var strfilter = $('#strfilter').val();
                                                        var filterValue = $('#filterValue').val();
                                                        var fromdate = $('#formdate').val();
                                                        var todate = $('#todate').val();
                                                        var EmployeeId = $('#EmployeeId').val();
                                                        var strURL = 'CRMExcel.php?strfilter=' + strfilter + '&filterValue=' + filterValue + '&fromdate=' + fromdate + '&todate=' + todate + '&EmployeeId=' +EmployeeId;
//                                                        strURL += strURL.attr('href');
                                                        window.open(strURL,'_blank');
                                                    }

    </script>   
</body>

</html>