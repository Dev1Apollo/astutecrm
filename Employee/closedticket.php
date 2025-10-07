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

        <title><?php echo $ProjectName; ?> | Closed Ticket </title>

        <?php include_once './include.php'; ?>
        <style type="text/css">
            /* The Modal (background) */
.modal {
  display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 1; /* Sit on top */
  padding-top: 100px; /* Location of the box */
  left: 0;
  top: 0;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  overflow: auto; /* Enable scroll if needed */
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
}

/* Modal Content */
.modal-content {
  position: relative;
  background-color: #fefefe;
  margin: auto;
  padding: 0;
  border: 1px solid #888;
  width: 80%;
  box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2),0 6px 20px 0 rgba(0,0,0,0.19);
  -webkit-animation-name: animatetop;
  -webkit-animation-duration: 0.4s;
  animation-name: animatetop;
  animation-duration: 0.4s
}
        </style>

    </head>

    <body class="page-container-bg-solid page-boxed">

        <?php include_once './header.php'; ?>

        <div style="display: none; z-index: 10060;" id="loading">

            <img id="loading-image" src="<?php echo $web_url;?>admin/images/loader1.gif">

        </div>

        <div class="page-container">        

            <div class="page-content-wrapper">

             

                <div class="page-content">

                    <div class="container">

                        <ul class="page-breadcrumb breadcrumb">

                            <li>

                                <a href="<?php echo $web_url;?>admin/index.php">Home</a>

                                <i class="fa fa-circle"></i>

                            </li>



                            <li>

                                <span>Closed Ticket</span>

                            </li>

                        </ul>



                                <div class="col-md-100%">

                                    <div class="portlet light ">

                                        <div class="portlet-title">

                                            <div class="caption font-red-sunglo">

                                                <i class="icon-settings font-red-sunglo"></i>
                                                <span class="caption-subject bold uppercase">List of Closed Complain</span>
                                                <span class="caption-subject bold uppercase"></span>

                                            </div>

                                        </div>

                                        <div class="portlet-body form">

                                        <div class="portlet light ">
                                        <div class="f_tab_main">
                                            <div class="f_tab_link">
                                                <a href="pendingTicket.php" class="f_tab_link_active">Pending Ticket</a>
                                                <a href="closedticket.php">Closed Ticket</a>
                                            </div>
                                            <!-- <?=$_REQUEST['id'];?> -->
                                            <input type="hidden" value="" name="examId" id="examId">
                                            <div class="f_tab_content">
                                                    <div id="PlaceUsersDataHere"></div>

                                            </div>
                                        </div>
                                    </div>


                                        </div>

                                    </div>

                                </div>



                        



                        </div>

                    </div>

                </div>

            </div>

        </div>
      

        <?php include_once './footer.php'; ?>

 <link href="<?php echo $web_url;?>admin/assets\global\plugins\bootstrap-datetimepicker\css\bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css"/>
<script src="<?php echo $web_url;?>admin/assets\global\plugins\bootstrap-datetimepicker\js\bootstrap-datetimepicker.min.js"></script>

    <script type="text/javascript">
             



            function PageLoadData(Page) {

                

                $('#loading').css("display", "block");

                $.ajax({

                    type: "POST",

                    url: "<?php echo $web_url;?>admin/Ajaxclosedticket.php",

                    data: {action: 'ListUser',Page:Page,},

                    success: function (msg) {

                        $("#PlaceUsersDataHere").html(msg);

                        $('#loading').css("display", "none");

                    },

                });

            }// end of filter

            PageLoadData(1);





        </script>

    </body>

</html>