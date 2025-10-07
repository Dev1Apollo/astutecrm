<?php
ob_start();
error_reporting(E_ALL);
include_once '../common.php';
$connect = new connect();
include('IsLogin.php');

$result = mysqli_query($dbconn,"SELECT * FROM `storelist` WHERE `storeListId`='" . $_REQUEST['token'] . "'");
if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_array($result);
} else {
    echo 'somthig going worng! try again';
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">

        <link rel="shortcut icon" href="images/favicon.png">
        <title> <?php echo $ProjectName ?> |Edit Store Locator</title>
        <?php include_once './include.php'; ?>       
    </head>

    <body class="page-container-bg-solid page-boxed">
        <?php
        include('header.php');
        ?>
        <div style="display: none; z-index: 10060;" id="loading">
            <img id="loading-image" src="<?php echo $web_url; ?>admin/images/loader1.gif">
        </div>
        <div class="page-container">        
            <!--            <div class="page-content-wrapper">
                            <div class="page-head">
                                <div class="container">
                                    <div class="page-title">
                                        <h1>Edit Category
                                        </h1>
                                    </div>
                                </div>
                            </div>-->
            <div class="page-content">
                <div class="container">                    
                    <ul class="page-breadcrumb breadcrumb">
                        <li>
                            <a href="<?php echo $web_url; ?>admin/index.php">Home</a>
                            <i class="fa fa-circle"></i>
                        </li>
                        <li>
                            <a href="<?php echo $web_url; ?>admin/StoreLocator.php">List Of Store Locator</a>
                            <i class="fa fa-circle"></i>
                        </li>
                        <li>
                            <span>Edit Store Locator</span>
                        </li>
                    </ul>

                    <div class="page-content-inner">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="portlet light ">
                                    <div class="portlet-title">
                                        <div class="caption font-red-sunglo">
                                            <i class="icon-settings font-red-sunglo"></i>
                                            <span class="caption-subject bold uppercase"> Edit Store Locator</span>
                                        </div>
                                    </div>
                                    <div class="portlet-body form">


                                        <form  role="form"  method="POST"  action="" name="frmparameter"  id="frmparameter" enctype="multipart/form-data">
                                            <input type="hidden" value="EditStoreLocator" name="action" id="action">
                                            <input type="hidden" value="<?php echo $row['storeListId'] ?>" name="storeListId" id="storeListId">
                                            <div class="form-body">


                                                <div class="form-group col-md-4">
                                                    <label for="form_control_1">Pin Code</label>
                                                    <input value="<?php echo $row['pincode'] ?>" name="PinCode" id="PinCode" pattern="[0-9]{6}" class="form-control" placeholder="Enter Your Pin Code" type="text" required="">
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label for="form_control_1">Partner Name</label>
                                                    <input value="<?php echo $row['partner'] ?>" name="Partner" id="Partner"  class="form-control" placeholder="Enter Your Partner Name" type="text" required="">
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label for="form_control_1">State Name</label>
                                                    <input value="<?php echo $row['city'] ?>" name="City" id="City"  class="form-control" placeholder="Enter Your State Name" type="text" required="">
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label for="form_control_1">City Name</label>
                                                    <input value="<?php echo $row['state'] ?>" name="State" id="State"  class="form-control" placeholder="Enter Your City Name" type="text" >
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label for="form_control_1">Contact Number</label>
                                                    <input value="<?php echo $row['zone'] ?>" name="Zone" id="Zone"  class="form-control" placeholder="Enter Your Contact Number" type="text" >
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label for="form_control_1">Merchant Name/Store Name/Dealer Name</label>
                                                    <input value="<?php echo $row['storeName'] ?>" name="StoreName" id="StoreName"  class="form-control" placeholder="Enter Your Store Name" type="text" required="">
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label for="form_control_1">SO Name</label>
                                                    <input value="<?php echo $row['SOname'] ?>" name="SOName" id="SOName"  class="form-control" placeholder="Enter Your SO Name" type="text" >
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label for="form_control_1">ASM</label>
                                                    <input value="<?php echo $row['ASM'] ?>" name="ASM" id="ASM"  class="form-control" placeholder="Enter Your ASM" type="text" >
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label for="form_control_1">Zone Name</label>
                                                    <input  value="<?php echo $row['contactNumber'] ?>" name="ContactNumber" id="ContactNumber"  class="form-control" placeholder="Enter Your Zone Name" type="text">
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label for="form_control_1">Address</label>
                                                    <textarea name="Address" id="Address"  class="form-control" placeholder="Enter Your Address" type="text" required=""><?php echo $row['address'] ?></textarea>
                                                </div>

                                            </div>

                                            <div class="form-actions noborder">
                                                <input class="btn blue margin-top-20" type="submit" id="Btnmybtn"  value="Submit" name="submit">      
                                                <button type="button" class="btn blue margin-top-20" onClick="checkclose();">Cancel</button>
                                            </div>
                                        </form>
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
    <script type="text/javascript">




        function checkclose() {
            window.location.href = '<?php echo $web_url; ?>admin/StoreLocator.php';
        }



        $('#frmparameter').submit(function (e) {

            e.preventDefault();
            var $form = $(this);
            $('#loading').css("display", "block");
            $.ajax({
                type: 'POST',
                url: '<?php echo $web_url; ?>admin/querydata.php',
                data: $('#frmparameter').serialize(),
                success: function (response) {
                    //alert(response);
                    console.log(response);
                    //$("#Btnmybtn").attr('disabled', 'disabled');
                    if (response == 2)
                    {
                        $('#loading').css("display", "none");
                        $("#Btnmybtn").attr('disabled', 'disabled');
                        alert('Edited Sucessfully.');
                        window.location.href = '<?php echo $web_url; ?>admin/StoreLocator.php';
                    }
                }

            });
        });

    </script>

</body>
</html>
