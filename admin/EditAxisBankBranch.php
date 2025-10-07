<?php
ob_start();
error_reporting(E_ALL);
include_once '../common.php';
$connect = new connect();
include('IsLogin.php');
$result = mysqli_query($dbconn, "SELECT * FROM `axisbankbranch` WHERE `iAxisBankBranchId`='" . $_REQUEST['token'] . "'");
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
        <title> <?php echo $ProjectName ?> |Edit Axis Bank Branch</title>
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
            <div class="page-content">
                <div class="container">                    
                    <ul class="page-breadcrumb breadcrumb">
                        <li>
                            <a href="<?php echo $web_url; ?>admin/index.php">Home</a>
                            <i class="fa fa-circle"></i>
                        </li>
                        <li>
                            <a href="<?php echo $web_url; ?>admin/StoreLocator.php">List Of Axis Bank Branch</a>
                            <i class="fa fa-circle"></i>
                        </li>
                        <li>
                            <span>Edit Axis Bank Branch</span>
                        </li>
                    </ul>
                    <div class="page-content-inner">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="portlet light ">
                                    <div class="portlet-title">
                                        <div class="caption font-red-sunglo">
                                            <i class="icon-settings font-red-sunglo"></i>
                                            <span class="caption-subject bold uppercase"> Edit Axis Bank Branch</span>
                                        </div>
                                    </div>
                                    <div class="portlet-body form">
                                        <form  role="form"  method="POST"  action="" name="frmparameter"  id="frmparameter" enctype="multipart/form-data">
                                            <input type="hidden" value="EditAxisBankBranch" name="action" id="action">
                                            <input type="hidden" value="<?php echo $row['iAxisBankBranchId'] ?>" name="iAxisBankBranchId" id="iAxisBankBranchId">
                                            <div class="form-body">
                                                <div class="form-group col-md-3">
                                                    <label for="form_control_1">State Name</label>
                                                    <input value="<?php echo $row['strState'] ?>" name="strState" id="strState"  class="form-control" placeholder="Enter Your State Name" type="text" >
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <label for="form_control_1">District Name</label>
                                                    <input value="<?php echo $row['strDistrict'] ?>" name="strDistrict" id="strDistrict"  class="form-control" placeholder="Enter Your State Name" type="text" >
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <label for="form_control_1">Pin Code</label>
                                                    <input value="<?php echo $row['pincode'] ?>" name="pincode" id="pincode" pattern="[0-9]{6}" class="form-control" placeholder="Enter Your Pin Code" type="text" required="">
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <label for="form_control_1">Branch Name</label>
                                                    <input value="<?php echo $row['strBranchName'] ?>" name="strBranchName" id="strBranchName"  class="form-control" placeholder="Enter Your Partner Name" type="text" required="">
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label for="form_control_1">Address</label>
                                                    <textarea name="strAdress" id="strAdress"  class="form-control" placeholder="Enter Your Address" type="text" required=""><?php echo $row['strAdress'] ?></textarea>
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
            window.location.href = '<?php echo $web_url; ?>admin/AxisBankBranch.php';
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
                        window.location.href = '<?php echo $web_url; ?>admin/AxisBankBranch.php';
                    }
                }
            });
        });

    </script>
</body>
</html>
