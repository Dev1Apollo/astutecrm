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
        <title><?php echo $ProjectName; ?> | Complain </title>
        <?php include_once './include.php'; ?>
    </head>
    <body class="page-header-fixed page-sidebar-closed-hide-logo page-content-white page-md">
        <div class="page-wrapper">
            <?php include_once './header.php'; ?>
            <div style="display: none; z-index: 10060;" id="loading">
                <img id="loading-image" src="<?php echo $web_url; ?>Employee/images/loader.gif">
            </div>
            <div class="page-content-wrapper">
                <div class="page-content">
                    <div class="page-bar">
                        <ul class="page-breadcrumb">
                          <li>
                                <a href="index.php">Home</a>
                                <i class="fa fa-circle"></i>
                            </li>
                            <li>
                                <span>Complain </span>
                            </li>
                        </ul>
                    </div>
                     <div class="row">
                         <div class="col-lg-12 mb-3">
                            <div class="f-pull-right">
                               <div class="form-group">
                                  <button type="button" id="addBtn" class="btn btn-primary f-pull-right"><i class="fa fa-plus"></i> Add New</button>
                               </div>
                            </div>
                         </div>
                    </div>
                    
                  <div class="row">
                     <div class="col-md-12 col-lg-12">
                        <div class="card">
                           <div class="table-responsive" id="pageLoadData">
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="modal fade" id="exampleModal3" tabindex="-1" role="dialog"  aria-hidden="true">
                  <div class="modal-dialog" role="document">
                     <div class="modal-content">
                        <div class="modal-header">
                           <h5 class="modal-title" id="Course">Add Complain</h5>
                           <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                           <span aria-hidden="true">&times;</span>
                           </button>
                        </div>
                        <form id="frmcourse" name="frmcourse" method="post" enctype="multipart/form-data">
                           <div class="modal-body">
                              <input type="hidden" value="AddCategory" name="action" id="action">

                              <div class="row">

                                  <div class="form-group col-md-6">
                                     <label for="recipient-name" class="form-control-label">Complain Text <span>*</span></label>
                                     <input type="testarea" name="categoryName" id="categoryName"   class="form-control" placeholder="Name" required>
                                  </div>

                             
                              </div>

                           </div>
                           <div class="modal-footer">
                              <button type="submit" name="submit" id="submit"  class="btn btn-primary">Submit</button>
                              <div id="updatebtn" style="display: none;">
                              <button type="submit" name="submit"  class="btn btn-primary">Update</button>
                              </div>
                              <button type="button" class="btn btn-danger" data-dismiss="modal" onclick="checkclose();">Close</button>
                           </div>
                        </form>
                     </div>
                  </div>
               </div>
                </div>
            </div>
            <a href="javascript:;" class="page-quick-sidebar-toggler">
                <i class="icon-login"></i>
            </a>
        </div>
        <?php include_once './footer.php'; ?>
    </div>
    <?php include_once './footerjs.php'; ?>
   


    <script>
         jQuery.noConflict();
         (function($) {
             $(function() {
                 // More code using $ as alias to jQuery
                 $('#addBtn').click(function() {
                     $('#exampleModal3').modal('show');
                 });
             });
         })(jQuery);
      </script>
      


      <script>
         function checkclose() {
             window.location.href = '';
         }
       

        $('#frmcourse').submit(function(e) {

            
       
            
            var action = $('#action').val();
            
            
           
            $('#loading').css("display", "block");
         
            $.ajax({
                type: 'POST',
                url: '<?= $web_url?>admin/querydata.php',
                data: $('#frmcourse').serialize(),
                success: function(response) {
                    console.log(response);
                    
                    if (response == 1) {
                       
                        $('#loading').css("display", "none");
                        $("#Btnmybtn").attr('disabled', 'disabled');
                        alert('Added Sucessfully.');
                        window.location.href = '';
                    }else  {
                        $('#loading').css("display", "none");
                        $("#Btnmybtn").attr('disabled', 'disabled');
                        alert('Invalid Request.');
                        window.location.href = '';
                    }
                    
                    PageLoadData(1);
                return false;
                }
            });
            
       
             return false;
        });
         
         
         
         
         
         // function deletedata(task, id) {
         //     var errMsg = '';
         //     if (task == 'Delete') {
         //         errMsg = 'Are you sure to delete?';
         //     } else if (task == 'Active') {
         //         errMsg = 'Are you sure to Active!';
         //     } else if (task == 'Inactive') {
         //         errMsg = 'Are you sure to Inactive!';
         //     }
         //     if (confirm(errMsg)) {
         //         $('#loading').css("display", "block");
         //         $.ajax({
         //             type: "POST",
         //             url: "<?=$web_url?>admin/AjaxComplain.php",
         //             data: {
         //                 action: task,
         //                 ID: id
         //             },
         //             success: function(msg) {
         //                 $('#loading').css("display", "none");
         //                 window.location.href = '';
         //                 //                            var table = $('#tableC').DataTable();
         //                 //                            table.ajax.reload();
         //                 return false;
         //             },
         //         });
         //     }
         //     return false;
         // }
         
         
         
         
         
         
         function PageLoadData(Page) {
             var name = $('#name').val();
             $('#loading').css("display", "block");
             $.ajax({
                 type: "POST",
                 url: "<?=$web_url?>admin/AjaxComplain.php",
                 data: {
                     action: 'ListUser',
                     Page: Page,
                     name: name
                 },
                 success: function(msg) {
                     $("#pageLoadData").html(msg);
                     $('#loading').css("display", "none");
                 },
             });
         } // end of filter
         PageLoadData(1);

      </script>   

</body>
</html>