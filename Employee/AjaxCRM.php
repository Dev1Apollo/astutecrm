<?php
error_reporting(0);
include('../common.php');
include('IsLogin.php');
$connect = new connect();
include ('User_Paging.php');

if ($_POST['action'] == 'ListUser') {
    $where = "where 1=1";
    $date = date('d-m-Y');
    $whereDate = " ";

    if (isset($_REQUEST['strfilter']) && $_REQUEST['strfilter'] != '') {
        if (isset($_REQUEST['filterValue']) && $_REQUEST['filterValue']) {
            if ($_REQUEST['strfilter'] == 'TotalAttempt') {
                $where.=" and applicationfollowup.iAppId in (select iAppId from applicationfollowup GROUP BY iAppId HAVING count(*) = '" . trim($_REQUEST['filterValue']) . "' )";
            } else if ($_REQUEST['strfilter'] == 'TotalConnect') {
                $where.=" and applicationfollowup.iAppId in (select iAppId from applicationfollowup where dispoType='1' GROUP BY iAppId HAVING count(*) = '" . trim($_REQUEST['filterValue']) . "' )";
            } else if ($_REQUEST['strfilter'] == 'Lastdisposition') {
//                $where.=" and applicationfollowup.iAppId in (select iAppId from applicationfollowup as af where af.iAppLogId=applicationfollowup.iAppLogId and mainDispoId='" . $_REQUEST['filterValue'] . "' GROUP BY iAppId order by iAppLogId desc)";
                $where.=" and applicationfollowup.mainDispoId='" . $_REQUEST['filterValue'] . "'";
            } else if ($_REQUEST['strfilter'] == 'followupDate') {
//                $where.=" and application.iAppId in (select iAppId from applicationfollowup where STR_TO_DATE(followupDate,'%d-%m-%Y') = STR_TO_DATE('" . trim($_REQUEST['filterValue']) . "','%d-%m-%Y'))";
                $where.=" and  STR_TO_DATE(followupDate,'%d-%m-%Y') = STR_TO_DATE('" . trim($_REQUEST['filterValue']) . "','%d-%m-%Y')";
            } else if ($_REQUEST['strfilter'] == 'followupTime') {
//                $where.=" and application.iAppId in (select iAppId from applicationfollowup where STR_TO_DATE(followupDate,'%d-%m-%Y %h') = STR_TO_DATE('" . trim($_REQUEST['filterValue']) . "','%d-%m-%Y %h'))";
                $where.=" and STR_TO_DATE(followupDate,'%d-%m-%Y %h') = STR_TO_DATE('" . trim($_REQUEST['filterValue']) . "','%d-%m-%Y %h')";
            } else if ($_REQUEST['strfilter'] == 'CustomSearch') {
                $where.=" and (application.customerName  like '%" . trim($_REQUEST['filterValue']) . "%' OR application.applicatipnNo like '%" . trim($_REQUEST['filterValue']) . "%' OR application.customerZipcode like '%" . trim($_REQUEST['filterValue']) . "%' OR application.customerCity like '%" . trim($_REQUEST['filterValue']) . "%' OR application.agencyName like '%" . trim($_REQUEST['filterValue']) . "%' OR application.state like '%" . trim($_REQUEST['filterValue']) . "%')";
            } else if ($_REQUEST['strfilter'] == 'LastCallDate') {
                if (isset($_REQUEST['fromdate']) && $_REQUEST['fromdate'] != "") {
                    $whereDate .= " and STR_TO_DATE(applicationfollowup.strEntryDate,'%d-%m-%Y') >= STR_TO_DATE('" . trim($_REQUEST['fromdate']) . "','%d-%m-%Y')";
                }
                if (isset($_REQUEST['todate']) && $_REQUEST['todate'] != "") {
                    $whereDate .= " and STR_TO_DATE(applicationfollowup.strEntryDate,'%d-%m-%Y') <= STR_TO_DATE('" . trim($_REQUEST['todate']) . "','%d-%m-%Y')";
                }
                if ($_REQUEST['strfilter'] == 'LastCallDate') {
                    $whereDate .=" and applicationfollowup.iAppId in (select iAppId from applicationfollowup where mainDispoId='" . $_REQUEST['filterValue'] . "' GROUP BY iAppId order by iAppLogId desc)";
                }
                $where.=" and application.iAppId in (select iAppId from applicationfollowup " . $whereDate . ")";
            } else {
                $where.=" and application." . $_REQUEST['strfilter'] . " like '%" . trim($_REQUEST['filterValue']) . "%'";
            }
        }
    }

    if ($_SESSION['Designation'] == 4) {
        if ($_REQUEST['EmployeeId'] != NULL && isset($_REQUEST['EmployeeId'])) {
            $whereEmp.=" and agentId='" . $_REQUEST['EmployeeId'] . "'";
        } else {
            $whereEmp.=" and agentId in (select elisionloginid from employee where iteamleadid='" . $_SESSION['EmployeeId'] . "')";
        }
    } else if ($_SESSION['Designation'] == 6) {
        $whereEmp.=" and agentId in (select elisionloginid from employee)";
    } else {
        $whereEmp.=" and agentId='" . $_SESSION['elisionloginid'] . "'";
    }

//    $filterstr = "SELECT application.iAppId,application.bucket,application.isEmiPending,application.applicatipnNo,application.customerName,application.branch,application.state,application.customerAddress,application.customerCity, "
//            . "application.customerZipcode,application.loanAmount,application.EMIAmount,application.agencyName,application.FOSName,application.customerAddress,application.FosNumber, "
//            . "applicationfollowup.strEntryDate,applicationfollowup.mainDispoId,applicationfollowup.followupDate,applicationfollowup.PTPDate,applicationfollowup.remark "
//            . " FROM `application` LEFT JOIN (select * from applicationfollowup where applicationfollowup.iAppLogId in (select max(applicationfollowup.iAppLogId) from applicationfollowup group by applicationfollowup.iAppId)) as "
//            . "applicationfollowup ON application.iAppId=applicationfollowup.iAppId  " . $where . $whereEmp . " and bucket!='' and isWithdraw=0 and isPaid=0 and isDelete='0'  and  iStatus='1'  ORDER BY STR_TO_DATE(`applicationfollowup`.`strEntryDate`,'%d-%m-%Y') ASC";

    $filterstr = "SELECT application.iAppId,application.bucket,application.isEmiPending,application.applicatipnNo,application.customerName,application.branch,application.state,application.customerAddress,application.customerCity, "
            . "application.customerZipcode,application.loanAmount,application.EMIAmount,application.agencyName,application.FOSName,application.customerAddress,application.FosNumber, application.customerMobile, "
            . "applicationfollowup.strEntryDate,applicationfollowup.mainDispoId,applicationfollowup.followupDate,applicationfollowup.PTPDate,applicationfollowup.remark "
            . " FROM `application` LEFT JOIN "
            . "applicationfollowup ON application.iAppLogId=applicationfollowup.iAppLogId  " . $where . $whereEmp . "  and isWithdraw=0 and isPaid=0 and isDelete='0'  and  iStatus='1'  ORDER BY STR_TO_DATE(`applicationfollowup`.`strEntryDate`,'%d-%m-%Y') ASC";

//    $filterstr = "SELECT application.iAppId,application.bucket,application.isEmiPending,application.applicatipnNo,application.customerName,application.branch,application.state,application.customerAddress,application.customerCity, "
//    . "application.customerZipcode,application.loanAmount,application.EMIAmount,application.agencyName,application.FOSName,application.customerAddress,application.FosNumber, "
//    . "applicationfollowup.followupDate,applicationfollowup.PTPDate,applicationfollowup.dispoType,applicationfollowup.remark,applicationfollowup.strEntryDate,applicationfollowup.mainDispoId,applicationfollowup.iAppLogId "
//    . " FROM `application` LEFT JOIN (select max(applicationfollowup.iAppLogId) as iAppLogId,applicationfollowup.iAppId,applicationfollowup.followupDate,applicationfollowup.PTPDate,applicationfollowup.dispoType,applicationfollowup.remark,applicationfollowup.strEntryDate,applicationfollowup.mainDispoId from applicationfollowup group by applicationfollowup.iAppId ORDER BY applicationfollowup.iAppLogId DESC) as "
//    . "applicationfollowup ON application.iAppId=applicationfollowup.iAppId  " . $where . $whereEmp . "  and isWithdraw=0 and isPaid=0 and isDelete='0'  and  iStatus='1'  ORDER BY STR_TO_DATE(`applicationfollowup`.`strEntryDate`,'%d-%m-%Y') ASC";

    $countstr = "SELECT count(*) as TotalRow FROM `application` LEFT JOIN (select max(applicationfollowup.iAppLogId) as AppLogId,applicationfollowup.strEntryDate,applicationfollowup.mainDispoId,applicationfollowup.followupDate,applicationfollowup.PTPDate,applicationfollowup.remark,applicationfollowup.iAppId from applicationfollowup group by applicationfollowup.iAppLogId) as applicationfollowup ON application.iAppId=applicationfollowup.iAppId " . $where . $whereEmp . " and bucket!='' and isDelete='0' and  istatus='1' and isWithdraw=0 and isPaid=0";

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
        $filterSetting = mysqli_query($dbconn, "SELECT * FROM `crmsetting` where elisionloginid ='" . $_SESSION['elisionloginid'] . "'");
        ?>  
        <link href="<?php echo $web_url; ?>Employee/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css" rel="stylesheet" type="text/css"/>
        <script src="<?php echo $web_url; ?>Employee/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>
        <link href="<?php echo $web_url; ?>Employee/global/plugins/datatables/datatables.min.css" rel="stylesheet" type="text/css"/>
        <script src="<?php echo $web_url; ?>Employee/global/plugins/datatables/datatables.min.js" type="text/javascript"></script>
        <!--        <link href="<?php // echo $web_url;  ?>Employee/global/plugins/datatables/datatables.css" rel="stylesheet" type="text/css" />
                <link href="<?php // echo $web_url;  ?>Employee/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css" rel="stylesheet" type="text/css" />
                <script src="<?php // echo $web_url;  ?>Employee/global/plugins/datatables/datatables.js" type="text/javascript"></script>
                <script src="<?php // echo $web_url;  ?>Employee/global/plugins/datatables/table-datatables-responsive.js" type="text/javascript"></script>-->

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
                            if ($rowSetting['bucket'] == '1') {
                                echo '<th class="pop_in_heading">Bucket</th>';
                            }
                            if ($rowSetting['customerName'] == 1) {
                                echo '<th class="pop_in_heading">Customer Name</th><th class="pop_in_heading">Total Attempt</th>
                            <th class="pop_in_heading">Total Connect</th>';
                            }
                            if ($rowSetting['branch'] == 1) {
                                echo '<th class="pop_in_heading">Branch</th>';
                            }
                            if ($rowSetting['state'] == 1) {
                                echo '<th class="pop_in_heading">State</th>';
                            }
                            
                            if ($rowSetting['customerMobile'] == 1) {
                                echo '<th class="pop_in_heading">Mobile</th>';
                            }
                            if ($rowSetting['customerAddress'] == 1) {
                                echo '<th class="pop_in_heading">Address</th>';
                            }
                            if ($rowSetting['customerCity'] == 1) {
                                echo '<th class="pop_in_heading">City</th>';
                            }
                            if ($rowSetting['customerZipcode'] == 1) {
                                echo '<th class="pop_in_heading">Zip Code</th>';
                            }
                            if ($rowSetting['loanAmount'] == 1) {
                                echo '<th class="pop_in_heading">Loan Amount</th>';
                            }
                            if ($rowSetting['EMIAmount'] == 1) {
                                echo '<th class="pop_in_heading">EMI Amount</th>';
                            }
                            if ($rowSetting['agencyName'] == 1) {
                                echo '<th class="pop_in_heading">Agency Name</th>';
                                echo '<th class="pop_in_heading">Paid Status</th>';
                            }
                            if ($rowSetting['agentId'] == 1) {
                                echo '<th class="pop_in_heading">Agent Id</th>';
                            }
                            if ($rowSetting['FOSName'] == 1) {
                                echo '<th class="pop_in_heading">FOS Name</th>';
                            }
                            if ($rowSetting['FOSContact'] == 1) {
                                echo '<th class="pop_in_heading">FOS Contact</th>';
                            }
                            if ($rowSetting['LastCallDate'] == 1) {
                                echo '<th class="pop_in_heading">Last Call Date</th>';
                            }
                            if ($rowSetting['Lastdisposition'] == 1) {
                                echo '<th class="pop_in_heading">Last disposition</th>';
                            }
                            if ($rowSetting['FollowupDate'] == 1) {
                                echo '<th class="pop_in_heading">Follow-up / PTP Date</th>';
                            }
                            if ($rowSetting['FollowupTime'] == 1) {
                                echo '<th class="pop_in_heading">Follow-up / PTP Time</th>';
                            }
                            if ($rowSetting['Remark'] == 1) {
                                echo '<th class="pop_in_heading">Remark</th>';
                            }
                        } else {
                            ?>
                            <th class="pop_in_heading">Loan App No</th>
                            <th class="pop_in_heading">Bucket</th>
                            <th class="pop_in_heading">Customer Name</th>
                            <th class="pop_in_heading">Total Attempt</th>
                            <th class="pop_in_heading">Total Connect</th>
                            <th class="pop_in_heading">Branch</th>
                            <th class="pop_in_heading">State</th>
                            <th class="pop_in_heading">Mobile</th>
                            <th class="pop_in_heading">Address</th>
                            <th class="pop_in_heading">City</th>
                            <th class="pop_in_heading">Zip Code</th>
                            <th class="pop_in_heading">Loan Amount</th>
                            <th class="pop_in_heading">EMI Amount</th>
                            <th class="pop_in_heading">Agency Name</th>
                            <th class="pop_in_heading">Paid Status</th>
                            <th class="pop_in_heading">FOS Name</th>
                            <th class="pop_in_heading">FOS Contact</th>
                            <th class="pop_in_heading">Last Call Date</th>
                            <th class="pop_in_heading">Last disposition</th>
                            <th class="pop_in_heading">Follow-up / PTP Date</th>
                            <th class="pop_in_heading">Follow-up / PTP Time</th>
                            <th class="pop_in_heading">Remark</th>
                        <?php } ?>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($rowfilter = mysqli_fetch_array($resultfilter)) {

//                        $filterFollowUp = mysqli_fetch_array(mysqli_query($dbconn, "Select followupDate,PTPDate,dispoType,mainDispoId,strEntryDate,remark from applicationfollowup where iAppId='" . $rowfilter['iAppId'] . "' ORDER BY STR_TO_DATE(`applicationfollowup`.`strEntryDate`,'%d-%m-%Y') DESC LIMIT 1"));
                        if ($rowfilter['followupDate'] != "") {
                            $date = explode(" ", $rowfilter['followupDate']);
                        } else if ($rowfilter['PTPDate'] != '') {
                            $date = explode(" ", $rowfilter['PTPDate']);
                        } else {
                            $date = array("", "");
                        }

                        $filterTotalAttempt = mysqli_fetch_array(mysqli_query($dbconn, "Select count(*) totalAttempt from applicationfollowup where iAppId='" . $rowfilter['iAppId'] . "'"));
                        $filterTotalconnect = mysqli_fetch_array(mysqli_query($dbconn, "Select count(*) totalConnect from applicationfollowup where iAppId='" . $rowfilter['iAppId'] . "' and dispoType='1'"));
                        echo "<tr>";

                        $filterDataSetting = mysqli_query($dbconn, "SELECT * FROM `crmsetting` where elisionloginid ='" . $_SESSION['elisionloginid'] . "'");
                        if (mysqli_num_rows($filterDataSetting) == 1) {
                            $rowSetting = mysqli_fetch_array($filterDataSetting);
                            if ($rowSetting['applicatipnNo'] == '1') {
                                ?>
                            <td>
                                <div class="form-group form-md-line-input ">
                                    <?php echo $rowfilter['applicatipnNo']; ?>
                                </div>
                            </td>
                            <?php
                        }if ($rowSetting['bucket'] == '1') {
                            ?>
                            <td>
                                <div class="form-group form-md-line-input ">
                                    <?php echo $rowfilter['bucket']; ?>
                                </div>
                            </td>
                            <?php
                        }
                        if ($rowSetting['customerName'] == 1) {
                            ?>
                            <td>
                                <div class="form-group form-md-line-input ">
                                    <?php echo $rowfilter['customerName']; ?>
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
                        if ($rowSetting['branch'] == 1) {
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
                        
                        if ($rowSetting['customerMobile'] == 1) {
                            ?>
                            <td>
                                <div class="form-group form-md-line-input ">
                                    <?php echo $rowfilter['customerMobile']; ?>
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
                        }
                        if ($rowSetting['loanAmount'] == 1) {
                            ?>
                            <td>
                                <div class="form-group form-md-line-input ">
                                    <?php echo $rowfilter['loanAmount']; ?>
                                </div>
                            </td>
                            <?php
                        }
                        if ($rowSetting['EMIAmount'] == 1) {
                            ?>
                            <td>
                                <div class="form-group form-md-line-input ">
                                    <?php echo $rowfilter['EMIAmount']; ?>
                                </div>
                            </td>
                            <?php
                        }
                        if ($rowSetting['agencyName'] == 1) {
                            ?>
                            <td>
                                <div class="form-group form-md-line-input ">
                                    <?php echo $rowfilter['agencyName']; ?> 
                                </div>
                            </td>
                            <td>
                                <div class="form-group form-md-line-input ">
                                    <?php
                                    if ($rowfilter['isEmiPending'] == 1) {
                                        echo "One Emi Pending";
                                    } else {
                                        echo "";
                                    }
                                    ?> 
                                </div>
                            </td>
                            <?php
                        }
                        if ($rowSetting['FOSName'] == 1) {
                            ?>
                            <td>
                                <div class="form-group form-md-line-input ">
                                    <?php echo $rowfilter['FOSName']; ?> 
                                </div>
                            </td>
                            <?php
                        }
                        if ($rowSetting['FOSContact'] == 1) {
                            ?>
                            <td>
                                <div class="form-group form-md-line-input ">
                                    <?php echo $rowfilter['FosNumber']; ?> 
                                </div>
                            </td>
                            <?php
                        }
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
                    } else {
                        ?> 
                        <td>
                            <div class="form-group form-md-line-input ">
                                <?php echo $rowfilter['applicatipnNo']; ?>
                            </div>
                        </td>
                        <td>
                            <div class="form-group form-md-line-input ">
                                <?php echo $rowfilter['bucket']; ?>
                            </div>
                        </td>
                        <td>
                            <div class="form-group form-md-line-input ">
                                <?php echo $rowfilter['customerName']; ?>
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
                        <td>
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
                                <?php echo $rowfilter['customerMobile']; ?>
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
                        </td>
                        <td>
                            <div class="form-group form-md-line-input ">
                                <?php echo $rowfilter['loanAmount']; ?>
                            </div>
                        </td>
                        <td>
                            <div class="form-group form-md-line-input ">
                                <?php echo $rowfilter['EMIAmount']; ?>
                            </div>
                        </td>
                        <td>
                            <div class="form-group form-md-line-input ">
                                <?php echo $rowfilter['agencyName']; ?>  
                            </div>
                        </td>
                        <td>
                            <div class="form-group form-md-line-input ">
                                <?php
                                if ($rowfilter['isEmiPending'] == 1) {
                                    echo "One Emi Pending";
                                } else {
                                    echo "";
                                }
                                ?> 
                            </div>
                        </td>
                        <td>
                            <div class="form-group form-md-line-input ">
                                <?php echo $rowfilter['FOSName']; ?>
                            </div>
                        </td>
                        <td>
                            <div class="form-group form-md-line-input ">
                                <?php echo $rowfilter['FosNumber']; ?> 
                            </div>
                        </td>
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