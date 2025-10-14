<?php
error_reporting(0);
include('../common.php');
include('IsLogin.php');
$connect = new connect();
include ('User_Paging.php');

if ($_POST['action'] == 'ListUser') {
    $where = "where 1=1";
    $whereDate = " where 1=1 ";
    
    if(isset($_REQUEST['disposition_name']) && $_REQUEST['disposition_name'] != ''){
        if($_REQUEST['disposition_name'] == 1000){
                $where .= " AND STR_TO_DATE(applicationfollowup.PTPDate, '%d-%m-%Y') < CURRENT_DATE()";
        } else {
            $where .= " AND applicationfollowup.mainDispoId = '" . intval($_REQUEST['disposition_name']) . "'";
        }
    }
    
    if (isset($_REQUEST['textSearch']) &&  $_REQUEST['textSearch']) {
        $where.=" and (application.customerName  like '%" . trim($_REQUEST['textSearch']) . "%' OR application.applicatipnNo like '%" . trim($_REQUEST['textSearch']) . "%')";
    }
    
    if(isset($_REQUEST['sub_disposition']) && $_REQUEST['sub_disposition'] != ''){
        $where .= " AND applicationfollowup.subDispoId = '" . intval($_REQUEST['sub_disposition']) . "'";
    }
    
    
    if(isset($_REQUEST['zeroDialType']) && $_REQUEST['zeroDialType'] != '') {
        $zeroDialType = $_REQUEST['zeroDialType'];
        
        if($zeroDialType == 'MTD') {
            // Month-to-Date zero dial - leads with no followup in current month
            $where .= " AND application.iAppId NOT IN (
                SELECT iAppId FROM applicationfollowup 
                WHERE MONTH(STR_TO_DATE(strEntryDate,'%d-%m-%Y'))=MONTH(CURRENT_DATE()) 
                AND YEAR(STR_TO_DATE(strEntryDate,'%d-%m-%Y'))=YEAR(CURRENT_DATE())
            )";
        } else if($zeroDialType == 'FTD') {
            // Today's zero dial - leads with no followup today
            $where .= " AND application.iAppId NOT IN (
                SELECT iAppId FROM applicationfollowup 
                WHERE MONTH(STR_TO_DATE(strEntryDate,'%d-%m-%Y'))=MONTH(CURRENT_DATE()) 
                AND YEAR(STR_TO_DATE(strEntryDate,'%d-%m-%Y'))=YEAR(CURRENT_DATE())
                AND STR_TO_DATE(strEntryDate,'%d-%m-%Y') = CURRENT_DATE()
            )";
        }
        
        // Also add a marker to show this is a zero dial view
        $where .= " AND application.isWithdraw=0 AND application.isPaid=0";
    }
//     if (isset($_REQUEST['strfilter']) && $_REQUEST['strfilter'] != '') {
//         if (isset($_REQUEST['filterValue']) && $_REQUEST['filterValue']) {
//             if ($_REQUEST['strfilter'] == 'TotalAttempt') {
//                 $where.=" and applicationfollowup.iAppId in (select iAppId from applicationfollowup GROUP BY iAppId HAVING count(*) = '" . trim($_REQUEST['filterValue']) . "' )";
//             } else if ($_REQUEST['strfilter'] == 'TotalConnect') {
//                 $where.=" and applicationfollowup.iAppId in (select iAppId from applicationfollowup where dispoType='1' GROUP BY iAppId HAVING count(*) = '" . trim($_REQUEST['filterValue']) . "' )";
//             } else if ($_REQUEST['strfilter'] == 'followupDate') {
//                 $where.=" and STR_TO_DATE(followupDate,'%d-%m-%Y') = STR_TO_DATE('" . trim($_REQUEST['filterValue']) . "','%d-%m-%Y')";
//             } else if ($_REQUEST['strfilter'] == 'followupTime') {
//                 $where.=" and STR_TO_DATE(followupDate,'%d-%m-%Y %h') = STR_TO_DATE('" . trim($_REQUEST['filterValue']) . "','%d-%m-%Y %h')";
//             } else if ($_REQUEST['strfilter'] == 'Lastdisposition') {
//                 $where.=" and mainDispoId='" . $_REQUEST['filterValue'] . "'";
// //                $filterDispo = mysqli_fetch_array(mysqli_query($dbconn, "select * from dispositionmaster where dispoDesc like '%" . trim($_REQUEST['filterValue']) . "%'"));
// //                $where.=" and application.iAppId in (select MAX(iAppLogId) AS iAppLogId from applicationfollowup where mainDispoId = '" . $_REQUEST['filterValue'] . "' order by iAppLogId desc)";
//             } else if ($_REQUEST['strfilter'] == 'CustomSearch') {
//                 $where.=" and (application.customerName  like '%" . trim($_REQUEST['filterValue']) . "%' OR application.applicatipnNo like '%" . trim($_REQUEST['filterValue']) . "%' OR application.customerZipcode like '%" . trim($_REQUEST['filterValue']) . "%' OR application.customerCity like '%" . trim($_REQUEST['filterValue']) . "%' OR application.agencyName like '%" . trim($_REQUEST['filterValue']) . "%' OR application.state like '%" . trim($_REQUEST['filterValue']) . "%')";
//             } else if ($_REQUEST['strfilter'] == 'LastCallDate') {
//                 if (isset($_REQUEST['fromdate']) && $_REQUEST['fromdate'] != "") {
//                     $whereDate .= " and STR_TO_DATE(applicationfollowup.strEntryDate,'%d-%m-%Y') >= STR_TO_DATE('" . trim($_REQUEST['fromdate']) . "','%d-%m-%Y')";
//                 }
//                 if (isset($_REQUEST['todate']) && $_REQUEST['todate'] != "") {
//                     $whereDate .= " and STR_TO_DATE(applicationfollowup.strEntryDate,'%d-%m-%Y') <= STR_TO_DATE('" . trim($_REQUEST['todate']) . "','%d-%m-%Y')";
//                 }
//                 if ($_REQUEST['strfilter'] == 'LastCallDate') {
//                     $whereDate .=" and mainDispoId='" . $_REQUEST['filterValue'] . "'";
//                 }
//                 $where.=" and application.iAppId in (select iAppId from applicationfollowup " . $whereDate . ")";
//             } else {
//                 $where.=" and application." . $_REQUEST['strfilter'] . " like '%" . trim($_REQUEST['filterValue']) . "%'";
//             }
//         } else {
//             if ($_REQUEST['strfilter'] == 'TotalAttempt') {
//                 $where.=" and application.iAppId Not in (select iAppId from applicationfollowup)";
//             } else if ($_REQUEST['strfilter'] == 'TotalConnect') {
//                 $where.=" and application.iAppId Not in (select iAppId from applicationfollowup)";
//             }
//         }
//     }
    
    $orderBy = "ORDER BY 
                CASE 
                    WHEN STR_TO_DATE(applicationfollowup.PTPDate, '%d-%m-%Y') = CURDATE() THEN 0
                    ELSE 1
                END,
                STR_TO_DATE(applicationfollowup.strEntryDate, '%d-%m-%Y') ASC";
    
    // if(isset($_REQUEST['sort_field']) && $_REQUEST['sort_field'] == 'loanAmount') {
    //     $sortOrder = (isset($_REQUEST['sort_order']) && $_REQUEST['sort_order'] == 'desc') ? 'DESC' : 'ASC';
    //     $orderBy = "ORDER BY CAST(application.loanAmount AS UNSIGNED) $sortOrder";
    // } 
    
    if(isset($_REQUEST['sort_field'])) {
        $sortOrder = (isset($_REQUEST['sort_order']) && $_REQUEST['sort_order'] == 'desc') ? 'DESC' : 'ASC';
        if($_REQUEST['sort_field'] == 'loanAmount') {
            $orderBy = "ORDER BY CAST(application.loanAmount AS UNSIGNED) $sortOrder";
        } else if($_REQUEST['sort_field'] == 'LastCallDate') {
            $orderBy = "ORDER BY STR_TO_DATE(applicationfollowup.strEntryDate, '%d-%m-%Y') $sortOrder";
        }
    }
    
    if ($_SESSION['Designation'] == 4) {
        if ($_REQUEST['EmployeeId'] != NULL && isset($_REQUEST['EmployeeId'])) {
            $whereEmp.=" and agentId='" . $_REQUEST['EmployeeId'] . "'";
        } else {
            $whereEmp.=" and agentId in (select elisionloginid from employee where iteamleadid='" . $_SESSION['EmployeeId'] . "')";
        }
    } else if ($_SESSION['Designation'] == 2) {
        if ($_REQUEST['EmployeeId'] != NULL && isset($_REQUEST['EmployeeId'])) {
            $whereEmp.=" and agentId='" . $_REQUEST['EmployeeId'] . "'";
        } else {
            $whereEmp.=" and agentId in (select elisionloginid from employee where asstmanagerid='" . $_SESSION['EmployeeId'] . "')";
        }
    } else {
        $whereEmp.=" and agentId='" . $_SESSION['elisionloginid'] . "'";
    }
//    $filterstr = "SELECT * FROM `application`  " . $where . $whereEmp . " and isWithdraw=0 and isPaid=0 and isDelete='0'  and  iStatus='1' order by iAppId desc";
        $filterstr = "SELECT application.iAppId,application.bucket,application.isEmiPending,application.applicatipnNo,application.customerName,application.branch,application.state,application.customerAddress,application.customerCity, application.agencyId, "
            . "application.customerZipcode,application.loanAmount,application.EMIAmount,application.agencyName,application.FOSName,application.customerAddress,application.FosNumber, application.customerMobile,"
            . "applicationfollowup.strEntryDate,applicationfollowup.mainDispoId,applicationfollowup.followupDate,applicationfollowup.PTPDate,applicationfollowup.PTP_Amount,applicationfollowup.remark,applicationfollowup.subDispoId "
            . " FROM `application` LEFT JOIN "
            . "applicationfollowup ON application.iAppLogId=applicationfollowup.iAppLogId  " . $where . $whereEmp . " and isWithdraw=0 and isPaid=0 and isDelete='0'  and  iStatus='1'"  
            . $orderBy;
        
            // ORDER BY 
            //     CASE 
            //         WHEN STR_TO_DATE(applicationfollowup.PTPDate, '%d-%m-%Y') = CURDATE() THEN 0
            //         ELSE 1
            //     END,
            //     STR_TO_DATE(applicationfollowup.strEntryDate, '%d-%m-%Y') ASC";
            //ORDER BY STR_TO_DATE(`applicationfollowup`.`strEntryDate`,'%d-%m-%Y') ASC";
            // and bucket!='' 

    /******** Last Running Query 07-01-2020 *******/
    
//    $filterstr = "SELECT application.iAppId,application.bucket,application.isEmiPending,application.applicatipnNo,application.customerName,application.branch,application.state,application.customerAddress,application.customerCity, "
//            . "application.customerZipcode,application.loanAmount,application.EMIAmount,application.agencyName,application.FOSName,application.customerAddress,application.FosNumber, "
//            . "applicationfollowup.strEntryDate,applicationfollowup.mainDispoId,applicationfollowup.followupDate,applicationfollowup.PTPDate,applicationfollowup.remark "
//            . " FROM `application` LEFT JOIN (select applicationfollowup.iAppLogId as AppLogId,applicationfollowup.strEntryDate,applicationfollowup.mainDispoId,applicationfollowup.followupDate,applicationfollowup.PTPDate,applicationfollowup.remark,applicationfollowup.iAppId from applicationfollowup "
//            . "where applicationfollowup.iAppLogId in (select max(applicationfollowup.iAppLogId) from applicationfollowup group by applicationfollowup.iAppId)) as "
//            . " applicationfollowup ON application.iAppId=applicationfollowup.iAppId  " . $where . $whereEmp . " and bucket!='' and isWithdraw=0 and isPaid=0 and isDelete='0'  and  iStatus='1'  ORDER BY STR_TO_DATE(`applicationfollowup`.`strEntryDate`,'%d-%m-%Y') ASC";

//    echo $filterstr = "SELECT application.iAppId,application.bucket,application.isEmiPending,application.applicatipnNo,application.customerName,application.branch,application.state,application.customerAddress,application.customerCity, "
//            . "application.customerZipcode,application.loanAmount,application.EMIAmount,application.agencyName,application.FOSName,application.customerAddress,application.FosNumber,"
//            . "applicationfollowup.followupDate,applicationfollowup.PTPDate,applicationfollowup.dispoType,applicationfollowup.remark,applicationfollowup.strEntryDate,applicationfollowup.mainDispoId,applicationfollowup.iAppLogId "
//            . " FROM `application` LEFT JOIN (select max(applicationfollowup.iAppLogId) as iAppLogId,applicationfollowup.iAppId,applicationfollowup.followupDate,applicationfollowup.PTPDate,applicationfollowup.dispoType,applicationfollowup.remark,applicationfollowup.strEntryDate,applicationfollowup.mainDispoId from applicationfollowup group by applicationfollowup.iAppId ORDER BY applicationfollowup.iAppLogId DESC) as "
//            . "applicationfollowup ON application.iAppId=applicationfollowup.iAppId  " . $where . $whereEmp . " and bucket!='' and isWithdraw=0 and isPaid=0 and isDelete='0'  and  iStatus='1'  ORDER BY applicationfollowup.iAppLogId DESC";
    //$countstr = "SELECT count(*) as TotalRow FROM `application` LEFT JOIN (select max(applicationfollowup.iAppLogId) as AppLogId,applicationfollowup.strEntryDate,applicationfollowup.mainDispoId,applicationfollowup.followupDate,applicationfollowup.PTPDate,applicationfollowup.remark,applicationfollowup.iAppId,applicationfollowup.subDispoId from applicationfollowup group by applicationfollowup.iAppLogId) as applicationfollowup ON application.iAppId=applicationfollowup.iAppId " . $where . $whereEmp . " and isWithdraw=0 and isPaid=0 and isDelete='0' and  iStatus='1' ";
    $countstr = "SELECT count(*) as TotalRow FROM `application` LEFT JOIN applicationfollowup ON application.iAppLogId=applicationfollowup.iAppLogId  " . $where . $whereEmp . " and isWithdraw=0 and isPaid=0 and isDelete='0'  and  iStatus='1'";
    //and bucket!='' 

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
        $crmSetting = "SELECT * FROM `crmsetting` where elisionloginid ='" . $_SESSION['elisionloginid'] . "'";
        $filterSetting = mysqli_query($dbconn, $crmSetting);
        ?>  
        <!--<link href="<?php echo $web_url; ?>Employee/global/plugins/datatables/datatables.css" rel="stylesheet" type="text/css" />-->
        <!--<link href="<?php echo $web_url; ?>Employee/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css" rel="stylesheet" type="text/css" />-->
        <!--<script src="<?php echo $web_url; ?>Employee/global/plugins/datatables/datatables.js" type="text/javascript"></script>-->
        <!--<script src="<?php echo $web_url; ?>Employee/global/plugins/datatables/table-datatables-responsive.js" type="text/javascript"></script>-->
        <style>
            .sortable {
                cursor: pointer;
                position: relative;
                padding-right: 25px !important;
                /*background: linear-gradient(90deg, #f8f9fa 95%, #e9ecef 95%) !important;*/
                transition: all 0.3s ease;
            }
            
            .sortable:hover {
                /*background: linear-gradient(90deg, #e3f2fd 95%, #bbdefb 95%) !important;*/
            }
            
            .sortable.asc:after {
                content: '▲' !important;
                position: absolute !important;
                right: 5px !important;
                font-size: 12px !important;
                color: #fff !important;
                font-weight: bold !important;
            }
            
            .sortable.desc:after {
                content: '▼' !important;
                position: absolute !important;
                right: 5px !important;
                bottom:5px!important;
                font-size: 12px !important;
                color: #fff !important;
                font-weight: bold !important;
               
            }
            
            .sortable {
                border: 1px solid transparent;
                 
            }
            
            .sortable:hover {
                border: 1px solid #2196F3;
            }
            
            th.pop_in_heading.sortable {
                background-color:#3f4296 !important;
                font-weight: 600 !important;
                padding-right:15px!important;
            }
            </style>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover center table-responsive" width="100%" id="tableC">
                            <thead class="tbg">
                                <tr>
                                    <?php
                                    if (mysqli_num_rows($filterSetting) == 1) {
                                        $rowSetting = mysqli_fetch_array($filterSetting);
                                        if ($rowSetting['applicatipnNo'] == '1') {
                                            echo '<th class="pop_in_heading">Loan App No</th>';
                                        }
                                        // if ($rowSetting['bucket'] == '1') {
                                        //     echo '<th class="pop_in_heading">Bucket</th>';
                                        // }
                                        if ($rowSetting['customerName'] == 1) {
                                            echo '<th class="pop_in_heading">Customer <br /> Name</th>';
                                            echo '<th class="pop_in_heading">Total <br /> Attempt</th>';
                                            echo '<th class="pop_in_heading">Customer <br /> Mobile</th>';
                                            echo '<th class="pop_in_heading">Total <br />Connect</th>';
                                        }
                                        // if ($rowSetting['branch'] == 1) {
                                        //     echo '<th class="pop_in_heading">Branch</th>';
                                        // }
                                        // if ($rowSetting['state'] == 1) {
                                        //     echo '<th class="pop_in_heading">State</th>';
                                        // }
                                        // if ($rowSetting['customerAddress'] == 1) {
                                        //     echo '<th class="pop_in_heading">Address</th>';
                                        // }
                                        // if ($rowSetting['customerCity'] == 1) {
                                        //     echo '<th class="pop_in_heading">City</th>';
                                        // }
                                        // if ($rowSetting['customerZipcode'] == 1) {
                                        //     echo '<th class="pop_in_heading">Zip Code</th>';
                                        // }
                                        if ($rowSetting['loanAmount'] == 1) {
                                            echo '<th class="pop_in_heading sortable" onclick="sortTable(\'loanAmount\')">POS <br /> Amount</th>';
                                        }
                                        // if ($rowSetting['EMIAmount'] == 1) {
                                        //     echo '<th class="pop_in_heading">EMI Amount</th>';
                                        // }
                                        if ($rowSetting['agencyName'] == 1) {
                                           // echo '<th class="pop_in_heading">Agency Name</th>';
                                            //echo '<th class="pop_in_heading">Paid Status</th>';
                                        }
                                        // if ($rowSetting['agentId'] == 1) {
                                        //     echo '<th class="pop_in_heading">Agent Id</th>';
                                        // }
                                        // if ($rowSetting['FOSName'] == 1) {
                                        //     echo '<th class="pop_in_heading">FOS Name</th>';
                                        // }
            
                                        // if ($rowSetting['FOSContact'] == 1) {
                                        //     echo '<th class="pop_in_heading">FOS Contact</th>';
                                        // }
                                        if ($rowSetting['LastCallDate'] == 1) {
                                            echo '<th class="pop_in_heading sortable" onclick="sortTable(\'LastCallDate\')">Last <br /> Call Date</th>';
                                        }
                                        if ($rowSetting['Lastdisposition'] == 1) {
                                            echo '<th class="pop_in_heading">Last <br /> Disposition</th>';
                                        }
                                        if ($rowSetting['Lastdisposition'] == 1) {
                                            echo '<th class="pop_in_heading">Last Sub<br /> Disposition</th>';
                                        }
                                        if ($rowSetting['loanAmount'] == 1) {
                                            echo '<th class="pop_in_heading">PTP <br /> Amount</th>';
                                        }
                                        
                                        if ($rowSetting['FollowupDate'] == 1) {
                                            echo '<th class="pop_in_heading">Follow-up / <br /> PTP Date</th>';
                                        }
                                        if ($rowSetting['FollowupTime'] == 1) {
                                            echo '<th class="pop_in_heading">Follow-up / <br /> PTP Time</th>';
                                        }
                                        if ($rowSetting['Remark'] == 1) {
                                            echo '<th class="pop_in_heading">Remark</th>';
                                        }
                                        // if ($rowSetting['feedback'] == 1) {
                                        //     echo '<th class="pop_in_heading">Feedback</th>';
                                        // }
                                    } else {
                                        ?>
                                        <th class="pop_in_heading">Loan App No</th>
                                        <!--<th class="pop_in_heading">Bucket</th>-->
                                        <th class="pop_in_heading">Customer <br /> Name</th>
                                        <th class="pop_in_heading">Customer Mobile</th>
                                        <th class="pop_in_heading">Total <br /> Attempt</th>
                                        <th class="pop_in_heading">Total <br /> Connect</th>
                                        <!--<th class="pop_in_heading">Branch</th>-->
                                        <!--<th class="pop_in_heading">State</th>-->
                                        <!--<th class="pop_in_heading">Address</th>-->
                                        <!--<th class="pop_in_heading">City</th>-->
                                        <!--<th class="pop_in_heading">Zip Code</th>-->
                                        <th class="pop_in_heading sortable" onclick="sortTable('loanAmount')">POS <br /> Amount</th>
                                        
                                        
                            <!--<th class="pop_in_heading">EMI Amount</th>-->
                            <!--<th class="pop_in_heading">Agency Name</th>-->
                            <!--<th class="pop_in_heading">Paid Status</th>-->
                            <!--<th class="pop_in_heading">Agent Id</th>-->
                            <!--<th class="pop_in_heading">FOS Name</th>-->
                            <!--<th class="pop_in_heading">FOS Contact</th>-->
                            <th class="pop_in_heading sortable" onclick="sortTable('LastCallDate')">Last <br /> Call Date</th>
                            <th class="pop_in_heading">Last <br /> Disposition</th>
                            <th class="pop_in_heading">Last Sub<br /> Disposition</th>
                            <th class="pop_in_heading">PTP <br /> Amount</th>
                            <th class="pop_in_heading">Follow-up / <br />PTP Date</th>
                            <th class="pop_in_heading">Follow-up /<br /> PTP Time</th>
                            <th class="pop_in_heading">Remark</th>
                            <!--<th class="pop_in_heading">Feedback</th>-->
                        <?php } ?>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($rowfilter = mysqli_fetch_array($resultfilter)) {
//                        $filterFollowUp = mysqli_fetch_array(mysqli_query($dbconn, "Select followupDate,PTPDate,dispoType,remark,mainDispoId,strEntryDate from applicationfollowup where iAppId='" . $rowfilter['iAppId'] . "' ORDER BY STR_TO_DATE(`applicationfollowup`.`strEntryDate`,'%d-%m-%Y') DESC LIMIT 1"));
                        if ($rowfilter['followupDate'] != "") {
                            $date = explode(" ", $rowfilter['followupDate']);
                        } else if ($rowfilter['PTPDate'] != '') {
                            $date = explode(" ", $rowfilter['PTPDate']);
                        } else {
                            $date = array("", "");
                        }
//                        if ($filterFollowUp['followupDate'] != "") {
//                            $date = explode(" ", $filterFollowUp['followupDate']);
//                        } else if ($rowfilter['PTPDate'] != '') {
//                            $date = explode(" ", $filterFollowUp['PTPDate']);
//                        } else {
//                            $date = array("", "");
//                        }

                        $filterTotalAttempt = mysqli_fetch_array(mysqli_query($dbconn, "Select count(*) totalAttempt from applicationfollowup where iAppId='" . $rowfilter['iAppId'] . "'"));
                        $filterTotalconnect = mysqli_fetch_array(mysqli_query($dbconn, "Select count(*) totalConnect from applicationfollowup where iAppId='" . $rowfilter['iAppId'] . "' and dispoType='1'"));
                        echo "<tr>";

                        $filterDataSetting = mysqli_query($dbconn, $crmSetting);
                        if (mysqli_num_rows($filterDataSetting) == 1) {
                            $rowSetting = mysqli_fetch_array($filterDataSetting);
                            if ($rowSetting['applicatipnNo'] == '1') {
                                ?>
                            <td>
                                <div class="form-group form-md-line-input ">
                                    <!--<a value="="  title="APPLICATION FOLLOWUP" onclick="window.open('<?php echo $web_url; ?>Employee/AddApplicationFollowup.php?token=<?php echo $rowfilter['iAppId']; ?>', 'popUpWindow', 'height=500,width=1250,left=100,top=100,resizable=yes,scrollbars=yes,toolbar=yes,menubar=no,location=no,directories=no,status=yes');">
                                        <?php echo $rowfilter['applicatipnNo']; ?> </a>-->
                                    <a value="="  title="APPLICATION FOLLOWUP" style="font-size: 12px;" href="<?php echo $web_url; ?>Employee/AddApplicationFollowup.php?token=<?php echo $rowfilter['iAppId']; ?>">
                                        <?php echo $rowfilter['applicatipnNo']; ?></a>
                                </div>
                            </td>
                            <?php
                        }
                        // if ($rowSetting['bucket'] == '1') {
                        ?>
                                <!--<td>
                                    <div class="form-group form-md-line-input ">
                                       <a value="="  title="APPLICATION FOLLOWUP" onclick="window.open('<?php echo $web_url; ?>Employee/AddApplicationFollowup.php?token=<?php echo $rowfilter['iAppId']; ?>', 'popUpWindow', 'height=500,width=1250,left=100,top=100,resizable=yes,scrollbars=yes,toolbar=yes,menubar=no,location=no,directories=no,status=yes');">
                                            <?php echo $rowfilter['bucket']; ?> </a>
                        //         </div>
                        //     </td>-->
                        <?php
                        // }
                        if ($rowSetting['customerName'] == 1) {
                            ?>
                            <td>
                                <div class="form-group form-md-line-input ">
                                    <!--<a value="="  title="APPLICATION FOLLOWUP" onclick="window.open('<?php echo $web_url; ?>Employee/AddApplicationFollowup.php?token=<?php echo $rowfilter['iAppId']; ?>', 'popUpWindow', 'height=500,width=1250,left=100,top=100,resizable=yes,scrollbars=yes,toolbar=yes,menubar=no,location=no,directories=no,status=yes');">-->
                                    <!--    <?php echo $rowfilter['customerName']; ?></a>-->
                                    <a value="="  title="APPLICATION FOLLOWUP" style="font-size: 12px;" href="<?php echo $web_url; ?>Employee/AddApplicationFollowup.php?token=<?php echo $rowfilter['iAppId']; ?>">
                                    <?php echo $rowfilter['customerName']; ?></a>
                                </div>
                            </td>
                            <td>
                                <div class="form-group form-md-line-input ">
                                    <?php echo $rowfilter['customerMobile']; ?>
                                </div>
                            </td>
                            <td>
                                <div class="form-group form-md-line-input ">
                                    <?php echo $filterTotalAttempt['totalAttempt']; ?>
                                </div>
                            </td>
                            <td>
                                <div class="form-group form-md-line-input ">
                                    <?php echo $filterTotalconnect['totalConnect']; ?>
                                </div>
                            </td>
                            <?php
                        }
                        /*if ($rowSetting['branch'] == 1) {
                            ?>
                            <td>
                                <div class="form-group form-md-line-input ">
                                    <?php echo $rowfilter['branch']; ?>
                                </div>
                            </td>
                        <?php } if ($rowSetting['state'] == 1) {
                            ?>
                            <td>
                                <div class="form-group form-md-line-input ">
                                    <?php echo $rowfilter['state']; ?> 
                                </div>
                            </td>
                            <?php
                        }
                        if ($rowSetting['customerAddress'] == 1) {
                            ?>
                            <td>
                                <div class="form-group form-md-line-input ">
                                    <?php echo $rowfilter['customerAddress']; ?>
                                </div>
                            </td>
                            <?php
                        }
                        if ($rowSetting['customerCity'] == 1) {
                            ?>
                            <td>
                                <div class="form-group form-md-line-input ">
                                    <?php echo $rowfilter['customerCity']; ?> 
                                </div>
                            </td>
                            <?php
                        }
                        if ($rowSetting['customerZipcode'] == 1) {
                            ?>
                            <td>
                                <div class="form-group form-md-line-input ">
                                    <?php echo $rowfilter['customerZipcode']; ?>
                                </div>
                            </td>
                            <?php
                        }*/
                        if ($rowSetting['loanAmount'] == 1) {
                            ?>
                            <td>
                                <div class="form-group form-md-line-input ">
                                    <?php echo $rowfilter['loanAmount']; ?>
                                </div>
                            </td>
                            <?php
                        }
                        /*if ($rowSetting['EMIAmount'] == 1) {
                            ?>
                            <td>
                                <div class="form-group form-md-line-input ">
                                    <?php echo $rowfilter['EMIAmount']; ?>
                                </div>
                            </td>
                            <?php
                        }*/
                        /*if ($rowSetting['agencyName'] == 1) {
                            ?>
                            <!--<td>
                                <div class="form-group form-md-line-input ">
                                    <?php echo $rowfilter['agencyName']; ?> 
                                </div>
                            </td>-->
                            <!--<td>
                                <div class="form-group form-md-line-input ">
                                    <?php
                                    if ($rowfilter['isEmiPending'] == 1) {
                                        echo "One Emi Pending";
                                    } else {
                                        echo "";
                                    }
                                    ?> 
                                </div>
                            </td>-->
                            <!--<td>
                                <div class="form-group form-md-line-input ">
                                    <?php echo $rowfilter['agencyId']; ?> 
                                </div>
                            </td>-->
                            <?php
                        } */
                        
                        /*if ($rowSetting['FOSName'] == 1) {
                            ?>
                            // <td>
                            //     <div class="form-group form-md-line-input ">
                            //         <?php echo $rowfilter['FOSName']; ?> 
                            //     </div>
                            // </td>
                            <?php
                        }
                        if ($rowSetting['FOSContact'] == 1) {
                            ?>
                            // <td>
                            //     <div class="form-group form-md-line-input ">
                            //         <?php echo $rowfilter['FosNumber']; ?> 
                            //     </div>
                            // </td>
                            <?php
                        }*/
                        if ($rowSetting['LastCallDate'] == 1) {
                            ?>
                            <td>
                                <div class="form-group form-md-line-input ">
                                    <?php
                                    if ($rowfilter['strEntryDate'] != '') {
                                        echo date('d-m-Y', strtotime($rowfilter['strEntryDate']));
                                    } else {
                                        echo "";
                                    }
                                    ?> 
                                </div>
                            </td>
                            <?php
                        }
                        if ($rowSetting['Lastdisposition'] == 1) {
                            ?>
                            <td>
                                <div class="form-group form-md-line-input ">
                                    <?php
                                    $filterDisPosition = mysqli_fetch_array(mysqli_query($dbconn, "Select dispoDesc from dispositionmaster where iDispoId='" . $rowfilter['mainDispoId'] . "'"));
                                    echo $filterDisPosition['dispoDesc'];
                                    ?> 
                                </div>
                            </td>
                            <?php
                        }
                        if ($rowSetting['Lastdisposition'] == 1) {
                        ?>
                            <td>
                                <div class="form-group form-md-line-input ">
                                    <?php
                                    $filterSubDisPosition = mysqli_fetch_array(mysqli_query($dbconn, "Select dispoDesc from dispositionmaster where iDispoId='" . $rowfilter['subDispoId'] . "'"));
                                    echo $filterSubDisPosition['dispoDesc'];
                                    ?>
                                </div>
                            </td>
                        <?php
                        }
                         if ($rowSetting['loanAmount'] == 1) {
                            ?>
                            <td>
                                <div class="form-group form-md-line-input ">
                                    <?php echo $rowfilter['PTP_Amount']; ?>
                                </div>
                            </td>
                            <?php
                        }
                        if ($rowSetting['FollowupDate'] == 1) {
                            ?>
                            <td>
                                <div class="form-group form-md-line-input ">
                                    <?php echo $date[0]; ?> 
                                </div>
                            </td>
                            <?php
                        }
                        if ($rowSetting['FollowupTime'] == 1) {
                            ?>
                            <td>
                                <div class="form-group form-md-line-input ">
                                    <?php echo $date[1]; ?>
                                </div>
                            </td>
                            <?php
                        }
                        if ($rowSetting['Remark'] == 1) {
                            ?>
                            <td>
                                <div class="form-group form-md-line-input ">
                                    <?php echo $rowfilter['remark']; ?>
                                </div>
                            </td>
                            <?php
                        }
                        /*if ($rowSetting['feedback'] == 1) {
                            ?>
                            <td>
                                <div class="form-group form-md-line-input ">
                                    <?php
                                    $filteragentFeedback = mysqli_fetch_array(mysqli_query($dbconn, "SELECT * FROM `customerfeedback` inner join feedback on feedback.iFeedbackId=customerfeedback.iFeedbackId  where applicatipnNo='" . $rowfilter['applicatipnNo'] . "'"));
                                    echo $filteragentFeedback['strfeedbackName'];
                                    ?>
                                </div>
                            </td>
                            <?php
                        }*/
                    } else {
                        ?> 
                        <td>
                            <div class="form-group form-md-line-input ">
                                <!--<a value="="  title="APPLICATION FOLLOWUP" onclick="window.open('<?php echo $web_url; ?>Employee/AddApplicationFollowup.php?token=<?php echo $rowfilter['iAppId']; ?>', 'popUpWindow', 'height=500,width=1250,left=100,top=100,resizable=yes,scrollbars=yes,toolbar=yes,menubar=no,location=no,directories=no,status=yes');">
                                    <?php echo $rowfilter['applicatipnNo']; ?> </a>-->
                                <a value="="  title="APPLICATION FOLLOWUP" style="font-size: 12px;" href="<?php echo $web_url; ?>Employee/AddApplicationFollowup.php?token=<?php echo $rowfilter['iAppId']; ?>">
                                    <?php echo $rowfilter['applicatipnNo']; ?></a>
                            </div>
                        </td>
                        <!--<td>-->
                        <!--    <div class="form-group form-md-line-input ">-->
                        <!--        <a value="="  title="APPLICATION FOLLOWUP" onclick="window.open('<?php echo $web_url; ?>Employee/AddApplicationFollowup.php?token=<?php echo $rowfilter['iAppId']; ?>', 'popUpWindow', 'height=500,width=1250,left=100,top=100,resizable=yes,scrollbars=yes,toolbar=yes,menubar=no,location=no,directories=no,status=yes');">-->
                        <!--            <?php echo $rowfilter['bucket']; ?> </a>-->
                        <!--    </div>-->
                        <!--</td>-->
                        <td>
                            <div class="form-group form-md-line-input ">
                                <!--<a value="="  title="APPLICATION FOLLOWUP" onclick="window.open('<?php echo $web_url; ?>Employee/AddApplicationFollowup.php?token=<?php echo $rowfilter['iAppId']; ?>', 'popUpWindow', 'height=500,width=1250,left=100,top=100,resizable=yes,scrollbars=yes,toolbar=yes,menubar=no,location=no,directories=no,status=yes');">
                                    <?php echo $rowfilter['customerName']; ?></a>-->
                            <a value="="  title="APPLICATION FOLLOWUP" style="font-size: 12px;" href="<?php echo $web_url; ?>Employee/AddApplicationFollowup.php?token=<?php echo $rowfilter['iAppId']; ?>">
                                <?php echo $rowfilter['customerName']; ?></a>
                            </div>
                        </td>
                        <td>
                            <div class="form-group form-md-line-input ">
                                <?php echo $rowfilter['customerMobile']; ?>
                            </div>
                        </td>
                        <td>
                            <div class="form-group form-md-line-input ">
                                <?php echo $filterTotalAttempt['totalAttempt']; ?>
                            </div>
                        </td>
                        <td>
                            <div class="form-group form-md-line-input ">
                                <?php echo $filterTotalconnect['totalConnect']; ?>
                            </div>
                        </td>
                        <!--<td>
                            <div class="form-group form-md-line-input ">
                                <?php echo $rowfilter['branch']; ?>
                            </div>
                        </td>
                        <td>
                            <div class="form-group form-md-line-input ">
                                <?php echo $rowfilter['state']; ?>
                            </div>
                        </td>
                        <td>
                            <div class="form-group form-md-line-input ">
                                <?php echo $rowfilter['customerAddress']; ?>
                            </div>
                        </td>
                        <td>
                            <div class="form-group form-md-line-input ">
                                <?php echo $rowfilter['customerCity']; ?> 
                            </div>
                        </td>
                        <td>
                            <div class="form-group form-md-line-input ">
                                <?php echo $rowfilter['customerZipcode']; ?>
                            </div>
                        </td>-->
                        <td>
                            <div class="form-group form-md-line-input ">
                                <?php echo $rowfilter['loanAmount']; ?>
                            </div>
                        </td>
                        <!--<td>
                            <div class="form-group form-md-line-input ">
                                <?php echo $rowfilter['EMIAmount']; ?>
                            </div>
                        </td>-->
                        <!--<td>
                            <div class="form-group form-md-line-input ">
                                <?php echo $rowfilter['agencyName']; ?>  
                            </div>
                        </td>-->
                        <!--<td>
                            <div class="form-group form-md-line-input ">
                                <?php
                                // if ($rowfilter['isEmiPending'] == 1) {
                                //     echo "One Emi Pending";
                                // } else {
                                //     echo "";
                                // }
                                ?> 
                            </div>
                        </td>-->
                        <!--<td>-->
                        <!--    <div class="form-group form-md-line-input ">-->
                        <!--        <?php echo $rowfilter['agencyId']; ?>  -->
                        <!--    </div>-->
                        <!--</td>-->
                        <!--<td>
                            <div class="form-group form-md-line-input ">
                                <?php echo $rowfilter['FOSName']; ?>
                            </div>
                        </td>-->
                        
                        <!--<td>
                            <div class="form-group form-md-line-input ">
                                <?php echo $rowfilter['FosNumber']; ?> 
                            </div>
                        </td>-->
                        <td>
                            <div class="form-group form-md-line-input ">
                                <?php
                                if ($rowfilter['strEntryDate'] != '') {
                                    echo date('d-m-Y', strtotime($rowfilter['strEntryDate']));
                                } else {
                                    echo "";
                                }
                                ?> 
                            </div>
                        </td>
                        <td>
                            <div class="form-group form-md-line-input ">
                                <?php
                                $filterDisPosition = mysqli_fetch_array(mysqli_query($dbconn, "Select dispoDesc from dispositionmaster where iDispoId='" . $rowfilter['mainDispoId'] . "'"));
                                echo $filterDisPosition['dispoDesc'];
                                ?> 
                            </div>
                        </td>
                        <td>
                                <div class="form-group form-md-line-input ">
                                    <?php
                                    $filterSubDisPosition = mysqli_fetch_array(mysqli_query($dbconn, "Select dispoDesc from dispositionmaster where iDispoId='" . $rowfilter['subDispoId'] . "'"));
                                    echo $filterSubDisPosition['dispoDesc'];
                                    ?>
                                </div>
                            </td>
                        <td>
                            <div class="form-group form-md-line-input ">
                                <?php echo $rowfilter['PTP_Amount']; ?>
                            </div>
                        </td>
                        <td>
                            <div class="form-group form-md-line-input ">
                                <?php echo $date[0]; ?> 
                            </div>
                        </td>
                        <td>
                            <div class="form-group form-md-line-input ">
                                <?php echo $date[1]; ?>
                            </div>
                        </td>
                        <td>
                            <div class="form-group form-md-line-input ">
                                <?php echo $rowfilter['remark']; ?>
                            </div>
                        </td>
                        <!--<td>
                            <div class="form-group form-md-line-input ">
                                <?php
                                $filteragentFeedback = mysqli_fetch_array(mysqli_query($dbconn, "SELECT * FROM `customerfeedback` inner join feedback on feedback.iFeedbackId=customerfeedback.iFeedbackId  where applicatipnNo='" . $rowfilter['applicatipnNo'] . "'"));
                                echo $filteragentFeedback['strfeedbackName'];
                                ?>
                            </div>
                        </td>-->
                        <?php
                    }
                    echo "</tr>";
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