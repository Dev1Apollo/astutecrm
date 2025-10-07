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
        <title><?php echo $ProjectName; ?> | Store Locator</title>
        <?php include_once './include.php'; ?>
    </head>
    <body class="page-container-bg-solid page-boxed">
        <?php include_once './header.php'; ?>
        <div style="display: none; z-index: 10060;" id="loading">
            <img id="loading-image" src="<?php echo $web_url; ?>Employee/images/loader1.gif">
        </div>
       

        <div class="english_main">
            <div class="container">
                

                <div class="col-md-12 english_heading">
                    <p class="col-md-6 col-sm-6 english_text_1">03-May-2019</p>
                    <p class="col-md-6 col-sm-6 english_text_2">Friday</p>

                    <marquee behavior="scroll" direction="up" onmouseover="this.stop()" onmouseout="this.start()" scrollamount="4"><p class="col-md-12">1. Pitch Full Penal Amount from BCC and LPP charges to customer and nagotiate to clear penalty amount.</p>
                        <p class="col-md-12">2. Mention clear and detailed remarks after closing the call so that in future same remarks can be used as referrence to talk with customer</p></marquee>
                </div>

            </div>
        </div>


         <div class="english_main_2">
            <div class="container">

                <div class="col-md-12 english_heading">
                    <p class="col-md-6 col-sm-6 english_text_1">02-May-2019</p>
                    <p class="col-md-6 col-sm-6 english_text_2">Thursday</p>

                    <marquee behavior="scroll" direction="up" onmouseover="this.stop()" onmouseout="this.start()" scrollamount="4"><p class="col-md-12">1. Pitch Full Penal Amount from BCC and LPP charges to customer and nagotiate to clear penalty amount.</p>
                        <p class="col-md-12">2. Mention clear and detailed remarks after closing the call so that in future same remarks can be used as referrence to talk with customer</p></marquee>
                </div>

            </div>
        </div>








        <?php include_once './footer.php'; ?>
        <script type="text/javascript">


            function checkClear() {

                $('#PinCode').val('');
                $('#Partner').val('');
                $('#City').val('');
                $('#State').val('');
                $('#Zone').val('');
                $('#StoreName').val('');
                $('#SOName').val('');
                $('#ASM').val('');
                $('#ContactNumber').val('');
                $('#Address').val('');

                return false;
            }

            function deletedata(task, id)
            {

                var errMsg = '';
                if (task == 'Delete') {
                    errMsg = 'Are you sure to delete?';
                }
                if (confirm(errMsg)) {
                    $('#loading').css("display", "block");
                    $.ajax({
                        type: "POST",
                        url: "<?php echo $web_url; ?>Employee/AjaxStoreLocator.php",
                        data: {action: task, ID: id},
                        success: function (msg) {

                            $('#loading').css("display", "none");
                            window.location.href = '';

                            return false;
                        },
                    });
                }
                return false;
            }
            function PageLoadData(Page) {

                var PinCode = $('#PinCode').val();
                var Partner = $('#Partner').val();
                var City = $('#City').val();
                var State = $('#State').val();
                var Zone = $('#Zone').val();
                var StoreName = $('#StoreName').val();
                var SOName = $('#SOName').val();
                var ASM = $('#ASM').val();
                var ContactNumber = $('#ContactNumber').val();
                var Address = $('#Address').val();

                $('#loading').css("display", "block");
                $.ajax({
                    type: "POST",
                    url: "<?php echo $web_url; ?>Employee/AjaxStoreLocator.php",
                    data: {action: 'ListUser', Page: Page, PinCode: PinCode, Partner: Partner, City: City, State: State, Zone: Zone, StoreName: StoreName, SOName: SOName, ASM: ASM, ContactNumber: ContactNumber, Address: Address},
                    success: function (msg) {
                        $('#SLID').show();
                        $("#PlaceUsersDataHere").html(msg);
                        $('#loading').css("display", "none");
                    },
                });
            }// end of filter
//            PageLoadData(1);



        </script>
    </body>
</html>