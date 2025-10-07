<!-- BEGIN HEADER -->

<div class="page-header navbar navbar-fixed-top">

    <!-- BEGIN HEADER INNER -->

    <div class="page-header-inner ">

        <!-- BEGIN LOGO -->

        <div class="page-logo">

            <a href="index.php">

                <img src="images/logo.png" alt="logo" class="logo-default" /> </a>

            <div class="menu-toggler sidebar-toggler">

                <span></span>

            </div>

        </div>

        <!-- END LOGO -->

        <!-- BEGIN RESPONSIVE MENU TOGGLER -->

        <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse">

            <span></span>

        </a>

        <!-- END RESPONSIVE MENU TOGGLER -->

        <!-- BEGIN TOP NAVIGATION MENU -->

        <div class="top-menu">

            <ul class="nav navbar-nav pull-right">

                <li class="dropdown dropdown-user">

                    <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">

                        <span class="username username-hide-on-mobile"> <i class="fa fa-user fa-2x"></i> <?php echo $_SESSION['EmployeeName']; ?> </span>

                        <i class="fa fa-angle-down"></i>

                    </a>

                    <ul class="dropdown-menu dropdown-menu-default">

                        <li>

                            <a href="<?php echo $web_url; ?>Employee/change_password.php">

                                <i class="icon-lock"></i> Change Password </a>

                        </li>

                        <li>

                            <a href="<?php echo $web_url; ?>Employee/CRMTableCloumn.php">

                                <i class="icon-lock"></i> CRM Setting </a>

                        </li>

                        <li>

                            <a href="<?php echo $web_url; ?>Employee/Logout.php">

                                <i class="icon-key"></i> Log Out </a>

                        </li>

                    </ul>

                </li>

            </ul>

        </div>

        <!-- END TOP NAVIGATION MENU -->

    </div>

    <!-- END HEADER INNER -->

</div>

<!-- END HEADER -->

<!-- BEGIN HEADER & CONTENT DIVIDER -->

<div class="clearfix"> </div>

<!-- END HEADER & CONTENT DIVIDER -->

<!-- BEGIN CONTAINER -->

<div class="page-container">

    <!-- BEGIN SIDEBAR -->

    <div class="page-sidebar-wrapper">

        <div class="page-sidebar navbar-collapse">

            <?php
            if (isset($_SESSION['Designation'])) {
                if ($_SESSION['Designation'] != 6 && $_SESSION['Designation'] != 7 && $_SESSION['Designation'] != 8 && $_SESSION['Designation'] != 9 && $_SESSION['Designation'] != 10 && $_SESSION['Designation'] != 11) {

            ?>

                    <ul class="page-sidebar-menu page-sidebar-menu-closed page-header-fixed " data-keep-expanded="true" data-auto-scroll="true" data-slide-speed="200" style="padding-top: 20px">

                        <li class="sidebar-toggler-wrapper hide">

                            <div class="sidebar-toggler">

                                <span></span>

                            </div>

                        </li>

                        <li class="<?php

                                    if (basename($_SERVER['REQUEST_URI']) == 'index.php') {

                                        echo 'start active open';
                                    }

                                    ?> nav-item start active open">

                            <a href="index.php" class="nav-link nav-toggle">

                                <i class="icon-home"></i>

                                <span class="title">Dashboard</span>

                            </a>

                        </li>

                        <li class="<?php

                                    if (basename($_SERVER['REQUEST_URI']) == 'dailyupdate.php') {

                                        echo 'start active open';
                                    }

                                    ?> nav-item">

                            <a href="<?php echo $web_url; ?>Employee/dailyupdate.php" class="nav-link nav-toggle">

                                <i class="icon-puzzle"></i>

                                <span class="title"> Daily Update </span>

                            </a>

                        </li>

                        <li class="<?php

                                    if (basename($_SERVER['REQUEST_URI']) == 'faqs.php') {

                                        echo 'start active open';
                                    }

                                    ?> nav-item  ">

                            <a href="<?php echo $web_url; ?>Employee/faqs.php" class="nav-link nav-toggle">

                                <i class="icon-puzzle"></i>

                                <span class="title">Knowledge Tree</span>

                            </a>

                            <?php if ($_SESSION['Designation'] == 4 || $_SESSION['Designation'] == 2 || $_SESSION['Designation'] == 3) { ?>
                        </li>

                        <li class="<?php

                                    if (basename($_SERVER['REQUEST_URI']) == 'storelocater.php') {

                                        echo 'start active open';
                                    }

                                    ?> nav-item  ">

                            <a href="<?php echo $web_url; ?>Employee/storelocater.php" class="nav-link nav-toggle">

                                <i class="icon-puzzle"></i>

                                <span class="title">Airtel Outlet</span>

                            </a>

                        </li>

                        <li class="<?php

                                    if (basename($_SERVER['REQUEST_URI']) == 'AxisBankBranch.php') {

                                        echo 'start active open';
                                    }

                                    ?> nav-item  ">

                            <a href="<?php echo $web_url; ?>Employee/AxisBankBranch.php" class="nav-link nav-toggle">

                                <i class="icon-puzzle"></i>

                                <span class="title">Axis Bank Branch</span>

                            </a>

                        </li>

                        <li class="<?php

                                    if (basename($_SERVER['REQUEST_URI']) == 'opso.php') {

                                        echo 'start active open';
                                    }

                                    ?> nav-item  ">

                            <a href="<?php echo $web_url; ?>Employee/opso.php" class="nav-link nav-toggle">

                                <i class="icon-puzzle"></i>

                                <span class="title">OPSO</span>

                            </a>

                        </li>
                    <?php } ?>

                    <li class="<?php

                                if (basename($_SERVER['REQUEST_URI']) == 'Performance.php') {

                                    echo 'start active open';
                                }

                                ?> nav-item  ">

                        <a href="<?php echo $web_url; ?>Employee/Performance.php" class="nav-link nav-toggle">

                            <i class="icon-puzzle"></i>

                            <span class="title">Performance</span>

                        </a>

                    </li>

                    <li class="<?php

                                if (basename($_SERVER['REQUEST_URI']) == 'attendance.php') {

                                    echo 'start active open';
                                }

                                ?> nav-item  ">

                        <a href="<?php echo $web_url; ?>Employee/attendance.php" class="nav-link nav-toggle">

                            <i class="icon-puzzle"></i>

                            <span class="title">Attendance</span>

                        </a>

                    </li>

                    <li class="<?php

                                if (basename($_SERVER['REQUEST_URI']) == 'QualityScore.php') {

                                    echo 'start active open';
                                }

                                ?> nav-item  ">

                        <a href="<?php echo $web_url; ?>Employee/QualityScore.php" class="nav-link nav-toggle">

                            <i class="icon-puzzle"></i>

                            <span class="title">Quality Score</span>

                        </a>

                    </li>

                    <li class="<?php

                                if (basename($_SERVER['REQUEST_URI']) == 'Incentive.php') {

                                    echo 'start active open';
                                }

                                ?> nav-item  ">

                        <a href="<?php echo $web_url; ?>Employee/Incentive.php" class="nav-link nav-toggle">

                            <i class="icon-puzzle"></i>

                            <span class="title">Incentive</span>

                        </a>

                    </li>

                    <?php if ($_SESSION['Designation'] == 4 || $_SESSION['Designation'] == 2) { ?>

                        <li class="<?php

                                    if (basename($_SERVER['REQUEST_URI']) == 'AgentCRM.php') {

                                        echo 'start active open';
                                    }

                                    ?> nav-item f_hover ">

                            <a href="<?php echo $web_url; ?>Employee/AgentCRM.php" class="nav-link nav-toggle">

                                <i class="icon-puzzle"></i>

                                <span class="title">CRM</span>

                            </a>

                            <ul class="hover_menu_3">

                                <li><a href="<?php echo $web_url; ?>Employee/AgentCRM.php">CRM</a></li>

                                <!--<li><a href="<?php echo $web_url; ?>Employee/TLandAMReassignAgent.php">Reassign Agent</a></li>-->
                                 <?php if ($_SESSION['Designation'] == 4) { ?>
                                <li><a href="<?php echo $web_url; ?>Employee/PaidUpdation.php">Paid updation</a></li>
                                <li><a href="<?php echo $web_url; ?>Employee/RemovedCase.php">Remove Case</a></li>
                                <li><a href="<?php echo $web_url; ?>Employee/EntryWiseReport.php">Entry Wise Report</a></li>
                                <li><a href="<?php echo $web_url; ?>Employee/LastDispositionWiseReport.php">Last Disposition Wise Report</a></li>
                                <li><a href="<?php echo $web_url; ?>Employee/AgentPTPReport.php">Agents Wise PTP Report</a></li>
                                <?php } ?>

                            </ul>

                        </li>

                    <?php } else { ?>

                        <li class="<?php

                                    if (basename($_SERVER['REQUEST_URI']) == 'AgentCRM.php') {

                                        echo 'start active open';
                                    }

                                    ?> nav-item  ">

                            <a href="<?php echo $web_url; ?>Employee/AgentCRM.php" class="nav-link nav-toggle">

                                <i class="icon-puzzle"></i>

                                <span class="title">CRM</span>

                            </a>

                        </li>

                    <?php } ?>

                    <li class="<?php

                                if (basename($_SERVER['REQUEST_URI']) == 'AgentPaidCase.php') {

                                    echo 'start active open';
                                }

                                ?> nav-item  ">

                        <a href="<?php echo $web_url; ?>Employee/AgentPaidCase.php" class="nav-link nav-toggle">

                            <i class="icon-puzzle"></i>

                            <span class="title">Paid Cases</span>

                        </a>

                    </li>
                    <li class="<?php

                                if (basename($_SERVER['REQUEST_URI']) == 'Exam.php') {

                                    echo 'start active open';
                                }

                                ?> nav-item  ">

                        <a href="<?php echo $web_url; ?>Employee/Exam.php" class="nav-link nav-toggle">

                            <i class="icon-puzzle"></i>

                            <span class="title">Exam</span>

                        </a>

                    </li>

                    <?php if ($_SESSION['Designation'] == 1 || $_SESSION['Designation'] == 2 || $_SESSION['Designation'] == 3 || $_SESSION['Designation'] == 4 || $_SESSION['Designation'] == 13) { ?>

                        <li class="<?php

                                    if (basename($_SERVER['REQUEST_URI']) == 'onlineFeedback.php') {

                                        echo 'start active open';
                                    }

                                    ?> nav-item  ">

                            <a href="<?php echo $web_url; ?>Employee/onlineFeedback.php" class="nav-link nav-toggle">

                                <i class="icon-puzzle"></i>

                                <span class="title"> Feedback</span>

                            </a>

                        </li>
                        <li class="<?php

                                    if (basename($_SERVER['REQUEST_URI']) == 'complain.php') {

                                        echo 'start active open';
                                    }

                                    ?> nav-item  ">

                            <a href="<?php echo $web_url; ?>Employee/complain.php" class="nav-link nav-toggle">

                                <i class="icon-puzzle"></i>

                                <span class="title">Ticket</span>

                            </a>

                        </li>

                    <?php } else { ?>
                        <li class="<?php

                                    if (basename($_SERVER['REQUEST_URI']) == 'complain.php') {

                                        echo 'start active open';
                                    }

                                    ?> nav-item  ">

                            <a href="<?php echo $web_url; ?>Employee/receivedFeedback.php" class="nav-link nav-toggle">

                                <i class="icon-puzzle"></i>

                                <span class="title">Feedback</span>

                            </a>

                        </li>
                    <?php } ?>
                    <?php if (in_array($_SESSION['Designation'], array(1, 2, 3, 4, 5, 6, 7))) { ?>

                        <li class="<?php

                                    if (basename($_SERVER['REQUEST_URI']) == 'warningLater.php') {

                                        echo 'start active open';
                                    }

                                    ?> nav-item  ">

                            <a href="<?php echo $web_url; ?>Employee/warningLater.php" class="nav-link nav-toggle">

                                <i class="icon-puzzle"></i>

                                <span class="title"> Warning Later</span>

                            </a>

                        </li>
                    <?php } ?>
                    <?php if ($_SESSION['Designation'] == 4) { ?>
                        <!--<li class="<?php if (basename($_SERVER['REQUEST_URI']) == 'EntryWiseReport.php') {
                                    echo 'start active open';
                                } ?> nav-item f_hover ">
                            <a href="<?php echo $web_url; ?>Employee/EntryWiseReport.php" class="nav-link nav-toggle">
                                <i class="icon-puzzle"></i>
                                <span class="title">Reports</span>
                            </a>
                            <ul class="hover_menu_2">
                                <li><a href="<?php echo $web_url; ?>Employee/EntryWiseReport.php">Entry Wise</a></li>
                                <li><a href="<?php echo $web_url; ?>Employee/LastDispositionWiseReport.php">Last Disposition Wise</a></li>
                                <li><a href="<?php echo $web_url; ?>Employee/AgentPTPReport.php">Agents Wise PTP</a></li>
                            </ul>
                        </li>-->
                        <!--<li class="<?php
                                    if (basename($_SERVER['REQUEST_URI']) == 'RemovedCase.php') {
                                        echo 'start active open';
                                    } ?> nav-item  ">
                            <a href="<?php echo $web_url; ?>Employee/RemovedCase.php" class="nav-link nav-toggle">
                                <i class="icon-puzzle"></i>
                                <span class="title"> Remove Case</span>
                            </a>
                        </li>-->
                        <?php } ?>
                    </ul>

                <?php } ?>

                <?php if ($_SESSION['Designation'] == 6) {

                ?>

                    <ul class="page-sidebar-menu page-sidebar-menu-closed page-header-fixed " data-keep-expanded="true" data-auto-scroll="true" data-slide-speed="200" style="padding-top: 20px">

                        <li class="sidebar-toggler-wrapper hide">

                            <div class="sidebar-toggler">

                                <span></span>

                            </div>

                        </li>

                        <li class="<?php

                                    if (basename($_SERVER['REQUEST_URI']) == 'index.php') {

                                        echo 'start active open';
                                    }

                                    ?> nav-item start active open">

                            <a href="index.php" class="nav-link nav-toggle">

                                <i class="icon-home"></i>

                                <span class="title">Dashboard</span>

                            </a>

                        </li>
                        <li class="<?php

                                    if (basename($_SERVER['REQUEST_URI']) == 'warningLater.php') {

                                        echo 'start active open';
                                    }

                                    ?> nav-item  ">

                            <a href="<?php echo $web_url; ?>Employee/warningLater.php" class="nav-link nav-toggle">

                                <i class="icon-puzzle"></i>

                                <span class="title"> Warning Later</span>

                            </a>

                        </li>
                        <li class="<?php

                                    if (basename($_SERVER['REQUEST_URI']) == 'employee.php') {

                                        echo 'start active open';
                                    }

                                    ?> nav-item  ">

                            <a href="<?php echo $web_url; ?>Employee/employee.php" class="nav-link nav-toggle">

                                <i class="icon-puzzle"></i>

                                <span class="title">Employee</span>

                            </a>

                        </li>

                        <li class="<?php

                                    if (basename($_SERVER['REQUEST_URI']) == 'dailyupdate.php') {

                                        echo 'start active open';
                                    }

                                    ?> nav-item  ">

                            <a href="<?php echo $web_url; ?>Employee/dailyupdate.php" class="nav-link nav-toggle">

                                <i class="icon-puzzle"></i>

                                <span class="title">Daily Update</span>

                            </a>

                        </li>

                        <li class="<?php

                                    if (basename($_SERVER['REQUEST_URI']) == 'faqs.php') {

                                        echo 'start active open';
                                    }

                                    ?> nav-item  ">

                            <a href="<?php echo $web_url; ?>Employee/faqs.php" class="nav-link nav-toggle">

                                <i class="icon-puzzle"></i>

                                <span class="title">Knowledge Tree</span>

                            </a>

                        </li>

                        <li class="<?php

                                    if (basename($_SERVER['REQUEST_URI']) == 'storelocater.php') {

                                        echo 'start active open';
                                    }

                                    ?> nav-item  ">

                            <a href="<?php echo $web_url; ?>Employee/storelocater.php" class="nav-link nav-toggle">

                                <i class="icon-puzzle"></i>

                                <span class="title"> Airtel Outlet </span>

                            </a>

                        </li>

                        <li class="<?php

                                    if (basename($_SERVER['REQUEST_URI']) == 'AxisBankBranch.php') {

                                        echo 'start active open';
                                    }

                                    ?> nav-item  ">

                            <a href="<?php echo $web_url; ?>Employee/AxisBankBranch.php" class="nav-link nav-toggle">

                                <i class="icon-puzzle"></i>

                                <span class="title">Axis Bank Branch</span>

                            </a>

                        </li>

                        <li class="<?php

                                    if (basename($_SERVER['REQUEST_URI']) == 'opso.php') {

                                        echo 'start active open';
                                    }

                                    ?> nav-item  ">

                            <a href="<?php echo $web_url; ?>Employee/opso.php" class="nav-link nav-toggle">

                                <i class="icon-puzzle"></i>

                                <span class="title">OPSO</span>

                            </a>

                        </li>

                        <li class="<?php

                                    if (basename($_SERVER['REQUEST_URI']) == 'employeePerformance.php') {

                                        echo 'start active open';
                                    }

                                    ?> nav-item  ">

                            <a href="<?php echo $web_url; ?>Employee/employeePerformance.php" class="nav-link nav-toggle">

                                <i class="icon-puzzle"></i>

                                <span class="title">Performance</span>

                            </a>

                        </li>

                        <li class="<?php

                                    if (basename($_SERVER['REQUEST_URI']) == 'employeeAttendance.php') {

                                        echo 'start active open';
                                    }

                                    ?> nav-item  ">

                            <a href="<?php echo $web_url; ?>Employee/employeeAttendance.php" class="nav-link nav-toggle">

                                <i class="icon-puzzle"></i>

                                <span class="title">Attendance</span>

                            </a>

                        </li>





                        <li class="<?php

                                    if (basename($_SERVER['REQUEST_URI']) == 'QualityScore.php') {

                                        echo 'start active open';
                                    }

                                    ?> nav-item  ">

                            <a href="<?php echo $web_url; ?>Employee/QualityScore.php" class="nav-link nav-toggle">

                                <i class="icon-puzzle"></i>

                                <span class="title">Quality Score</span>

                            </a>

                        </li>

                        <li class="<?php

                                    if (basename($_SERVER['REQUEST_URI']) == 'Incentive.php') {

                                        echo 'start active open';
                                    }

                                    ?> nav-item  ">

                            <a href="<?php echo $web_url; ?>Employee/Incentive.php" class="nav-link nav-toggle">

                                <i class="icon-puzzle"></i>

                                <span class="title">Incentive</span>

                            </a>

                        </li>

                        <li class="<?php

                                    if (basename($_SERVER['REQUEST_URI']) == 'CRM.php') {

                                        echo 'start active open';
                                    }

                                    ?> nav-item f_hover ">

                            <a href="<?php echo $web_url; ?>Employee/CRM.php" class="nav-link nav-toggle">

                                <i class="icon-puzzle"></i>

                                <span class="title">CRM</span>

                            </a>

                            <ul class="hover_menu_2">

                                <li><a href="<?php echo $web_url; ?>Employee/CRM.php">Upload CRM</a></li>

                                <!--<li><a href="<?php echo $web_url; ?>Employee/ReassignAgent.php">Reassign Agent</a></li>-->

                                <!--<li><a href="<?php echo $web_url; ?>Employee/WithdrawCase.php">Withdraw Case</a></li>-->

                                <li><a href="<?php echo $web_url; ?>Employee/PaidUpdation.php">Paid updation</a></li>
                                <li><a href="<?php echo $web_url; ?>Employee/RemovedCase.php">Remove Case</a></li>
                                <li><a href="<?php echo $web_url; ?>Employee/EntryWiseReport.php">Entry Wise Report</a></li>
                                <li><a href="<?php echo $web_url; ?>Employee/LastDispositionWiseReport.php">Last Disposition Wise Report</a></li>
                                <li><a href="<?php echo $web_url; ?>Employee/AgentPTPReport.php">Agents Wise PTP Report</a></li>

                            </ul>

                        </li>

                        <li class="<?php

                                    if (basename($_SERVER['REQUEST_URI']) == 'WrongCrm.php') {

                                        echo 'start active open';
                                    }

                                    ?> nav-item  ">

                            <a href="<?php echo $web_url; ?>Employee/WrongCrm.php" class="nav-link nav-toggle">

                                <i class="icon-puzzle"></i>

                                <span class="title">Error Upload CRM </span>

                            </a>

                        </li>

                        <li class="<?php

                                    if (basename($_SERVER['REQUEST_URI']) == 'TLdeshboard.php') {

                                        echo 'start active open';
                                    }

                                    ?> nav-item  ">

                            <a href="<?php echo $web_url; ?>Employee/TLdeshboard.php" class="nav-link nav-toggle">

                                <i class="icon-puzzle"></i>

                                <span class="title"> TL Dashboard </span>

                            </a>

                        </li>

                        <li class="<?php

                                    if (basename($_SERVER['REQUEST_URI']) == 'ArchiveData.php') {

                                        echo 'start active open';
                                    }

                                    ?> nav-item  ">

                            <a href="<?php echo $web_url; ?>Employee/ArchiveData.php" class="nav-link nav-toggle">

                                <i class="icon-puzzle"></i>

                                <span class="title">Archive Data</span>

                            </a>

                        </li>
                        <li class="<?php

                                    if (basename($_SERVER['REQUEST_URI']) == 'CreateExam.php') {

                                        echo 'start active open';
                                    }

                                    ?> nav-item  ">

                            <a href="<?php echo $web_url; ?>Employee/CreateExam.php" class="nav-link nav-toggle">

                                <i class="icon-puzzle"></i>

                                <span class="title">Create Exam</span>

                            </a>

                        </li>
                        <li class="<?php

                                    if (basename($_SERVER['REQUEST_URI']) == 'complain.php') {

                                        echo 'start active open';
                                    }

                                    ?> nav-item  ">

                            <a href="<?php echo $web_url; ?>Employee/complain.php" class="nav-link nav-toggle">

                                <i class="icon-puzzle"></i>

                                <span class="title">Ticket</span>

                            </a>

                        </li>
                        <li class="<?php

                                    if (basename($_SERVER['REQUEST_URI']) == 'onlineFeedback.php') {

                                        echo 'start active open';
                                    }

                                    ?> nav-item  ">

                            <a href="<?php echo $web_url; ?>Employee/onlineFeedback.php" class="nav-link nav-toggle">

                                <i class="icon-puzzle"></i>

                                <span class="title"> Feedback</span>

                            </a>

                        </li>
                        <?php if ($_SESSION['Designation'] == 6) { ?>
                        <!--<li class="<?php if (basename($_SERVER['REQUEST_URI']) == 'EntryWiseReport.php') {
                                    echo 'start active open';
                                } ?> nav-item f_hover ">
                            <a href="<?php echo $web_url; ?>Employee/EntryWiseReport.php" class="nav-link nav-toggle">
                                <i class="icon-puzzle"></i>
                                <span class="title">Reports</span>
                            </a>
                            <ul class="hover_menu_2">
                                <li><a href="<?php echo $web_url; ?>Employee/EntryWiseReport.php">Entry Wise</a></li>
                                <li><a href="<?php echo $web_url; ?>Employee/LastDispositionWiseReport.php">Last Disposition Wise</a></li>
                                <li><a href="<?php echo $web_url; ?>Employee/AgentPTPReport.php">Agents Wise PTP </a></li>
                            </ul>
                        </li>-->
                        <!--<li class="<?php
                                    if (basename($_SERVER['REQUEST_URI']) == 'RemovedCase.php') {
                                        echo 'start active open';
                                    } ?> nav-item  ">
                            <a href="<?php echo $web_url; ?>Employee/RemovedCase.php" class="nav-link nav-toggle">
                                <i class="icon-puzzle"></i>
                                <span class="title"> Removed Case</span>
                            </a>
                        </li>-->
                        <?php } ?>

                    </ul>

                <?php }

                ?>

                <?php if ($_SESSION['Designation'] == 7) {

                ?>

                    <ul class="page-sidebar-menu page-sidebar-menu-closed page-header-fixed " data-keep-expanded="true" data-auto-scroll="true" data-slide-speed="200" style="padding-top: 20px">

                        <li class="sidebar-toggler-wrapper hide">

                            <div class="sidebar-toggler">

                                <span></span>

                            </div>

                        </li>

                        <li class="<?php

                                    if (basename($_SERVER['REQUEST_URI']) == 'index.php') {

                                        echo 'start active open';
                                    }

                                    ?> nav-item start active open">

                            <a href="index.php" class="nav-link nav-toggle">

                                <i class="icon-home"></i>

                                <span class="title">Dashboard</span>

                            </a>

                        </li>

                        <li class="<?php

                                    if (basename($_SERVER['REQUEST_URI']) == 'warningLater.php') {

                                        echo 'start active open';
                                    }

                                    ?> nav-item  ">

                            <a href="<?php echo $web_url; ?>Employee/warningLater.php" class="nav-link nav-toggle">

                                <i class="icon-puzzle"></i>

                                <span class="title"> Warning Later</span>

                            </a>

                        </li>



                        <li class="<?php

                                    if (basename($_SERVER['REQUEST_URI']) == 'complain.php') {

                                        echo 'start active open';
                                    }

                                    ?> nav-item  ">

                            <a href="<?php echo $web_url; ?>Employee/complain.php" class="nav-link nav-toggle">

                                <i class="icon-puzzle"></i>

                                <span class="title">Ticket</span>

                            </a>

                        </li>


                        <li class="<?php

                                    if (basename($_SERVER['REQUEST_URI']) == 'onlineFeedback.php') {

                                        echo 'start active open';
                                    }

                                    ?> nav-item  ">

                            <a href="<?php echo $web_url; ?>Employee/onlineFeedback.php" class="nav-link nav-toggle">

                                <i class="icon-puzzle"></i>

                                <span class="title"> Feedback</span>

                            </a>

                        </li>
                    
                    </ul>

                <?php }

                ?>

                <!--  <?php if ($_SESSION['Designation'] == 1) {

                        ?>

                <ul class="page-sidebar-menu page-sidebar-menu-closed page-header-fixed " data-keep-expanded="true" data-auto-scroll="true" data-slide-speed="200" style="padding-top: 20px">

                    
 
                    <li class="<?php

                                if (basename($_SERVER['REQUEST_URI']) == 'complain.php') {

                                    echo 'start active open';
                                }

                                ?> nav-item  ">

                        <a href="<?php echo $web_url; ?>Employee/complain.php" class="nav-link nav-toggle">

                        <i class="icon-puzzle"></i> 

                        <span class="title">Ticket</span>

                        </a>

                    </li>

                    
                    <li class="<?php

                                if (basename($_SERVER['REQUEST_URI']) == 'onlineFeedback.php') {

                                    echo 'start active open';
                                }

                                ?> nav-item  ">

                            <a href="<?php echo $web_url; ?>Employee/onlineFeedback.php" class="nav-link nav-toggle">

                                <i class="icon-puzzle"></i> 

                                <span class="title"> Feedback</span>

                            </a>

                    </li>

                    
                </ul>

            <?php }

            ?> -->

                <?php if ($_SESSION['Designation'] == 8) {

                ?>

                    <ul class="page-sidebar-menu page-sidebar-menu-closed page-header-fixed " data-keep-expanded="true" data-auto-scroll="true" data-slide-speed="200" style="padding-top: 20px">

                        <li class="sidebar-toggler-wrapper hide">

                            <div class="sidebar-toggler">

                                <span></span>

                            </div>

                        </li>

                        <li class="<?php

                                    if (basename($_SERVER['REQUEST_URI']) == 'index.php') {

                                        echo 'start active open';
                                    }

                                    ?> nav-item start active open">

                            <a href="index.php" class="nav-link nav-toggle">

                                <i class="icon-home"></i>

                                <span class="title">Dashboard</span>

                            </a>

                        </li>




                        <li class="<?php

                                    if (basename($_SERVER['REQUEST_URI']) == 'TicketPending.php') {

                                        echo 'start active open';
                                    }

                                    ?> nav-item  ">

                            <a href="<?php echo $web_url; ?>Employee/TicketPending.php" class="nav-link nav-toggle">

                                <i class="icon-puzzle"></i>

                                <span class="title">Ticket</span>

                            </a>

                        </li>

                    </ul>

                <?php }

                ?>

                <?php if ($_SESSION['Designation'] == 9) {

                ?>

                    <ul class="page-sidebar-menu page-sidebar-menu-closed page-header-fixed " data-keep-expanded="true" data-auto-scroll="true" data-slide-speed="200" style="padding-top: 20px">

                        <li class="sidebar-toggler-wrapper hide">

                            <div class="sidebar-toggler">

                                <span></span>

                            </div>

                        </li>

                        <li class="<?php

                                    if (basename($_SERVER['REQUEST_URI']) == 'index.php') {

                                        echo 'start active open';
                                    }

                                    ?> nav-item start active open">

                            <a href="index.php" class="nav-link nav-toggle">

                                <i class="icon-home"></i>

                                <span class="title">Dashboard</span>

                            </a>

                        </li>




                        <li class="<?php

                                    if (basename($_SERVER['REQUEST_URI']) == 'complain.php') {

                                        echo 'start active open';
                                    }

                                    ?> nav-item  ">

                            <a href="<?php echo $web_url; ?>Employee/complain.php" class="nav-link nav-toggle">

                                <i class="icon-puzzle"></i>

                                <span class="title">Ticket</span>

                            </a>

                        </li>
                        <li class="<?php

                                    if (basename($_SERVER['REQUEST_URI']) == 'onlineFeedback.php') {

                                        echo 'start active open';
                                    }

                                    ?> nav-item  ">

                            <a href="<?php echo $web_url; ?>Employee/onlineFeedback.php" class="nav-link nav-toggle">

                                <i class="icon-puzzle"></i>

                                <span class="title"> Feedback</span>

                            </a>

                        </li>
                        <li class="<?php

                                    if (basename($_SERVER['REQUEST_URI']) == 'CreateExam.php') {

                                        echo 'start active open';
                                    }

                                    ?> nav-item  ">

                            <a href="<?php echo $web_url; ?>Employee/CreateExam.php" class="nav-link nav-toggle">

                                <i class="icon-puzzle"></i>

                                <span class="title">Create Exam</span>

                            </a>

                        </li>
                        <li class="<?php

                                    if (basename($_SERVER['REQUEST_URI']) == 'Exam.php') {

                                        echo 'start active open';
                                    }

                                    ?> nav-item  ">

                            <a href="<?php echo $web_url; ?>Employee/Exam.php" class="nav-link nav-toggle">

                                <i class="icon-puzzle"></i>

                                <span class="title">Exam</span>

                            </a>

                        </li>
                    </ul>

                <?php }

                ?>

                <?php if ($_SESSION['Designation'] == 10) {

                ?>

                    <ul class="page-sidebar-menu page-sidebar-menu-closed page-header-fixed " data-keep-expanded="true" data-auto-scroll="true" data-slide-speed="200" style="padding-top: 20px">

                        <li class="sidebar-toggler-wrapper hide">

                            <div class="sidebar-toggler">

                                <span></span>

                            </div>

                        </li>

                        <li class="<?php

                                    if (basename($_SERVER['REQUEST_URI']) == 'index.php') {

                                        echo 'start active open';
                                    }

                                    ?> nav-item start active open">

                            <a href="index.php" class="nav-link nav-toggle">

                                <i class="icon-home"></i>

                                <span class="title">Dashboard</span>

                            </a>

                        </li>




                        <li class="<?php

                                    if (basename($_SERVER['REQUEST_URI']) == 'complain.php') {

                                        echo 'start active open';
                                    }

                                    ?> nav-item  ">

                            <a href="<?php echo $web_url; ?>Employee/complain.php" class="nav-link nav-toggle">

                                <i class="icon-puzzle"></i>

                                <span class="title">Ticket</span>

                            </a>

                        </li>

                    </ul>

                <?php }

                ?>

                <?php if ($_SESSION['Designation'] == 11) {

                ?>

                    <ul class="page-sidebar-menu page-sidebar-menu-closed page-header-fixed " data-keep-expanded="true" data-auto-scroll="true" data-slide-speed="200" style="padding-top: 20px">

                        <li class="sidebar-toggler-wrapper hide">

                            <div class="sidebar-toggler">

                                <span></span>

                            </div>

                        </li>

                        <li class="<?php

                                    if (basename($_SERVER['REQUEST_URI']) == 'index.php') {

                                        echo 'start active open';
                                    }

                                    ?> nav-item start active open">

                            <a href="index.php" class="nav-link nav-toggle">

                                <i class="icon-home"></i>

                                <span class="title">Dashboard</span>

                            </a>

                        </li>




                        <li class="<?php

                                    if (basename($_SERVER['REQUEST_URI']) == 'complain.php') {

                                        echo 'start active open';
                                    }

                                    ?> nav-item  ">

                            <a href="<?php echo $web_url; ?>Employee/complain.php" class="nav-link nav-toggle">

                                <i class="icon-puzzle"></i>

                                <span class="title">Ticket</span>

                            </a>

                        </li>
                        <li class="<?php

                                    if (basename($_SERVER['REQUEST_URI']) == 'employee.php') {

                                        echo 'start active open';
                                    }

                                    ?> nav-item  ">

                            <a href="<?php echo $web_url; ?>Employee/employee.php" class="nav-link nav-toggle">

                                <i class="icon-puzzle"></i>

                                <span class="title">Employee</span>

                            </a>

                        </li>
                    </ul>

                <?php }

                if ($_SESSION['Designation'] == 12) {

                ?>

                    <ul class="page-sidebar-menu page-sidebar-menu-closed page-header-fixed " data-keep-expanded="true" data-auto-scroll="true" data-slide-speed="200" style="padding-top: 20px">

                        <li class="sidebar-toggler-wrapper hide">

                            <div class="sidebar-toggler">

                                <span></span>

                            </div>

                        </li>

                        <li class="<?php

                                    if (basename($_SERVER['REQUEST_URI']) == 'index.php') {

                                        echo 'start active open';
                                    }

                                    ?> nav-item start active open">

                            <a href="index.php" class="nav-link nav-toggle">

                                <i class="icon-home"></i>

                                <span class="title">Dashboard</span>

                            </a>

                        </li>




                        <li class="<?php

                                    if (basename($_SERVER['REQUEST_URI']) == 'Exam.php') {

                                        echo 'start active open';
                                    }

                                    ?> nav-item  ">

                            <a href="<?php echo $web_url; ?>Employee/Exam.php" class="nav-link nav-toggle">

                                <i class="icon-puzzle"></i>

                                <span class="title">Exam</span>

                            </a>

                        </li>

                    </ul>

            <?php }
            }
            ?>
            
            
            <!-- END SIDEBAR MENU -->

            <!-- END SIDEBAR MENU -->

        </div>

        <!-- END SIDEBAR -->

    </div>