<?php

$MasterEntry = array("State.php", "Location.php","Language.php","agency.php", "product.php", "bkt.php");

$employeePerformance = array("employeePerformance.php","upload_Employee_Attendance_Performance.php")

?>

<div class="page-header">

    <div class="page-header-top">

        <div class="container">

            <div class="page-logo">

                <a href="<?php echo $web_url; ?>admin/index.php">

                    <img src="<?php echo $web_url; ?>admin/assets/images/logo.png" width="145px" alt="logo" class="logo-default">

                </a>

            </div>

            <a href="javascript:;" class="menu-toggler"></a>          

        </div>

    </div>

    <div class="page-header-menu">

        <div class="container">

            <div class="hor-menu">

                <ul class="nav navbar-nav">

                    <?php

                    if (isset($_SESSION['AdminName'])) {

                        if ($_SESSION['AdminType'] == 1) {

                            ?>

                            <li class="menu-dropdown classic-menu-dropdown <?php

                            if (in_array(basename($_SERVER['REQUEST_URI']), $MasterEntry)) {

                                echo

                                'active';

                            }

                            ?>">

                                <a href="#">Master Entry</a>

                                <ul class="dropdown-menu pull-left">

                                    <li>

                                        <a href="<?php echo $web_url; ?>admin/process.php" class="nav-link">

                                            Process

                                        </a>

                                    </li> 

                                    <li>

                                        <a href="<?php echo $web_url; ?>admin/agency.php" class="nav-link">

                                           Agency

                                        </a>

                                    </li> 

                                    <li>

                                        <a href="<?php echo $web_url; ?>admin/fos.php" class="nav-link">

                                          FOS

                                        </a>

                                    </li>

                                    <li>

                                        <a href="<?php echo $web_url; ?>admin/dispositionMain.php" class="nav-link">

                                         Main Disposition

                                        </a>

                                    </li> 

                                    <li>

                                        <a href="<?php echo $web_url; ?>admin/dispositionSub.php" class="nav-link">

                                         Sub Disposition

                                        </a>

                                    </li> 

                                    <li>

                                        <a href="<?php echo $web_url; ?>admin/Language.php" class="nav-link">

                                            Language Master

                                        </a>

                                    </li>

                                    <li>

                                        <a href="<?php echo $web_url; ?>admin/Exam.php" class="nav-link">

                                            Create Exam

                                        </a>

                                    </li>
                                     <li>

                                    <a href="<?php echo $web_url; ?>admin/ticketCategory.php" class="nav-link">

                                    Ticket Category

                                    </a>     
                                    <li>

                                    <a href="<?php echo $web_url; ?>admin/pendingTicket.php" class="nav-link">

                                    Ticket

                                    </a>

                                    </li>                                

                                    <li>

                                        <a href="<?php echo $web_url; ?>admin/faq.php" class="nav-link">

                                            FAQ

                                        </a>

                                    </li>    

                                    <li>

                                        <a href="<?php echo $web_url; ?>admin/faqanswerhead.php" class="nav-link">

                                            FAQ Answer Head

                                        </a>

                                    </li>  

                                    <li>

                                        <a href="<?php echo $web_url; ?>admin/faqanswer.php" class="nav-link">

                                            FAQ Answer

                                        </a>

                                    </li> 

                                    <li>

                                        <a href="<?php echo $web_url; ?>admin/newsflash.php" class="nav-link">

                                            News Flash

                                        </a>

                                    </li> 

                                    <li>

                                        <a href="<?php echo $web_url; ?>admin/ExcelFormMaster.php" class="nav-link">

                                            Excel Form Master

                                        </a>

                                    </li>

                                    <li>

                                        <a href="<?php echo $web_url; ?>admin/FeedbackMaster.php" class="nav-link">

                                            Feedback Master

                                        </a>

                                    </li>
                                    <li>
                                        <a href="<?php echo $web_url; ?>admin/categoryFeedback.php" class="nav-link">

                                            Feedback Category

                                        </a>

                                    </li>

                                    <!-- <li>

                                        <a href="#" class="nav-link">

                                            Online Feedback

                                        </a>

                                    </li> -->
                                </ul>

                            </li>

                            <li class="menu-dropdown classic-menu-dropdown  <?php

                            if (basename($_SERVER['REQUEST_URI']) == 'employee.php') {

                                echo 'active';

                            }

                            ?>">

                                <a href="<?php echo $web_url; ?>admin/employee.php"> Employee </a>

                            </li>

                            

<!--                            <li class="menu-dropdown classic-menu-dropdown <?php

//                            if (in_array(basename($_SERVER['REQUEST_URI']), $employeePerformance)) {

//                                echo

//                                'active';

//                            }

                            ?>">

                                <a href="employeePerformance.php">Employee Performance</a>

                                <ul class="dropdown-menu pull-left">

                                    <li>

                                        <a href="<?php // echo $web_url; ?>admin/upload_Employee_Performance.php" class="nav-link">

                                            Employee Attendance

                                        </a>

                                    </li>

                                    <li>

                                        <a href="<?php // echo $web_url; ?>admin/upload_Employee_Attendance_Performance.php" class="nav-link">

                                            Update Employee Performance

                                        </a>

                                    </li>

                                </ul>

                            </li>-->

                            <li class="menu-dropdown classic-menu-dropdown  <?php

                            if (basename($_SERVER['REQUEST_URI']) == 'employeePerformance.php') {

                                echo 'active';

                            }

                            ?>">

                                <a href="<?php  echo $web_url; ?>admin/employeePerformance.php"> Employee Performance </a>

                            </li>

                            <li class="menu-dropdown classic-menu-dropdown  <?php

                            if (basename($_SERVER['REQUEST_URI']) == 'dailyupdate.php') {

                                echo 'active';

                            }

                            ?>">

                                <a href="<?php echo $web_url; ?>admin/dailyupdate.php"> Daily Update </a>

                            </li>

                            <li class="menu-dropdown classic-menu-dropdown  <?php

                            if (basename($_SERVER['REQUEST_URI']) == 'Incentive.php') {

                                echo 'active';

                            }

                            ?>">

                                <a href="<?php  echo $web_url; ?>admin/Incentive.php"> Incentive </a>

                            </li>

                            <li class="menu-dropdown classic-menu-dropdown  <?php

                            if (basename($_SERVER['REQUEST_URI']) == 'Quality.php') {

                                echo 'active';

                            }

                            ?>">

                                <a href="<?php  echo $web_url; ?>admin/Quality.php"> Quality  </a>

                            </li>

                            <li class="menu-dropdown classic-menu-dropdown  <?php

                            if (basename($_SERVER['REQUEST_URI']) == 'TLdeshboard.php') {

                                echo 'active';

                            }

                            ?>">

                                <a href="<?php  echo $web_url; ?>admin/TLdeshboard.php"> TL Dashboard  </a>

                            </li>

                            <li class="menu-dropdown classic-menu-dropdown  <?php

                            if (basename($_SERVER['REQUEST_URI']) == 'CRM.php') {

                                echo 'active';

                            }

                            ?>">

                                <a href="<?php  echo $web_url; ?>admin/CRM.php"> CRM </a>

                            </li>

                            <li class="menu-dropdown classic-menu-dropdown  <?php

                            if (basename($_SERVER['REQUEST_URI']) == 'StoreLocator.php') {

                                echo 'active';

                            }

                            ?>">

                                <a href="<?php echo $web_url; ?>admin/StoreLocator.php">Store Locator</a>

                            </li>

                            <li class="menu-dropdown classic-menu-dropdown  <?php

                            if (basename($_SERVER['REQUEST_URI']) == 'AxisBankBranch.php') {

                                echo 'active';

                            }

                            ?>">

                                <a href="<?php echo $web_url; ?>admin/AxisBankBranch.php">Axis Bank Branch</a>

                            </li>
                           


                            <?php

                        }

                    }

                    ?>

                </ul>

            </div>

            <div class="hor-menu pull-right">

                <ul class="nav navbar-nav">

                    <li class="menu-dropdown classic-menu-dropdown active">

                        <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">

                            <i class="fa fa-user"></i>

                            <span class="username username-hide-mobile"><?php echo $_SESSION['AdminName']; ?></span>

                        </a>

                        <ul class="dropdown-menu pull-right">

                            <li>

                                <a href="<?php echo $web_url; ?>admin/ChangePassword.php">

                                    <i class="icon-lock"></i>Change Password 

                                </a>

                            </li>

                            <li>

                                <a href="<?php echo $web_url; ?>admin/Logout.php">

                                    <i class="icon-key"></i>Log Out 

                                </a>

                            </li>

                        </ul>

                    </li>

                </ul>

            </div>

        </div>

    </div>

</div>



