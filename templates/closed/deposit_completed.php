<?php
include "connection/config.php";
if (!checks("admin"))
{
    redirect("login.php");
}



$xx = query("select * from deposit_request where status!='0' order by sn desc");



if(isset($_REQUEST['complete']))
{
    $sn = $_REQUEST['complete'];
    
    $get = fetch(query("select * from deposit_request where sn='$sn'"));
    
    query("update deposit_request set status='1' where sn='$sn'");
    
    query("update users set wallet=wallet+".$get['amount']." where mobile='".$get['user']."' ");
    
    query("INSERT INTO `transactions`(`user`, `amount`, `type`, `remark`, `owner`, `created_at`, `game_id`, `batch_id`, `in_type`, `wallet_type`) VALUES ('".$get['user']."','".$get['amount']."','1','Deposit money with Bank','user','$stamp','','','BANK','')");
    
    redirect("deposit_requests.php");
    
    return;
    
}

if(isset($_REQUEST['cancel']))
{
    $sn = $_REQUEST['cancel'];
    
    //$get = fetch(query("select * from deposit_request where sn='$sn'"));
    
    query("update deposit_request set status!='2' where sn='$sn'");
    
    // query("update users set wallet=wallet+".$get['amount']." where mobile='".$get['user']."' ");
    
    // query("INSERT INTO `transactions`(`user`, `amount`, `type`, `remark`, `owner`, `created_at`, `game_id`, `batch_id`, `in_type`, `wallet_type`) VALUES ('".$get['user']."','".$get['amount']."','1','Deposit money with Bank','user','$stamp','','','BANK_REFUND','')");
    
    redirect("deposit_requests.php");
    
    return;
    
}

?>

<!DOCTYPE html>
<html lang="en">


<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Admin Panel</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="vendors/ti-icons/css/themify-icons.css">
    <link rel="stylesheet" href="vendors/css/vendor.bundle.base.css">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="vendors/datatables.net-bs4/dataTables.bootstrap4.css">
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="css/horizontal-layout-light/style.css">
    <!-- endinject -->
    <link rel="shortcut icon" href="images/favicon.png" />
    
</head>

<body>

<body class="sidebar-dark" style="font-family: 'Oxygen', sans-serif;">
  <div class="container-fluid page-body-wrapper">
    <?php include "include/header.php"; ?>

        <div class="main-panel">
            <div class="content-wrapper">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Completed Withdraw requests</h4>
                        <div class="row">
                            <div class="col-12">
                                <div class="table-responsive">
                                    <table id="example" class="table">
                                            <thead>
                                                <tr>
                                                    <th>Sn</th>
                                                    <th>User Mobile</th>
                                                    <th>User Name</th>
                                                    <th>Img</th>
                                                    <th>Amount</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                        <tbody>

                                        <?php $i = 1; while ($bl = fetch($xx)) { 
                                        $user = $bl['user'];
                                        
                                        $csx = query("select * from users where mobile='$user'");
                                        $xs = fetch($csx);
                                        ?>
                                            <tr>
                                                <td><?php echo $i; ?></td>
                                                <td><?php echo $bl['user']; ?></td>
                                                <td><?php echo $xs['name']; ?></td>
                                                <td><a href="<?php echo $bl['image']; ?>" target='_blank'><img src="<?php echo $bl['image']; ?>" ></a></td>
                                                <td><?php echo $bl['amount']; ?></td>
                                                <td><?php if($bl['status'] == "1"){ echo "Completed"; } else { echo "Cancelled";  } ?></td>
                                               
                                               
                                            </tr>
                                        <?php $i++; } ?>
                                        
                                        
                                        </tbody>
                                    </table>
                                </div>
                                
                             
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- content-wrapper ends -->
            <!-- partial:partials/_footer.html -->
            <footer class="footer">
                <div class="w-100 clearfix">
                    <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Hand-crafted & made with <i class="ti-heart text-danger ml-1"></i></span>
                </div>
            </footer>
            <!-- partial -->
        </div>
        <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
</div>
<!-- container-scroller -->
<!-- plugins:js -->
<script src="vendors/js/vendor.bundle.base.js"></script>
<!-- endinject -->
<!-- Plugin js for this page-->
<script src="vendors/datatables.net/jquery.dataTables.js"></script>
<script src="vendors/datatables.net-bs4/dataTables.bootstrap4.js"></script>
<!-- End plugin js for this page-->
<!-- inject:js -->
<script src="js/off-canvas.js"></script>
<script src="js/hoverable-collapse.js"></script>
<script src="js/template.js"></script>
<script src="js/settings.js"></script>
<script src="js/todolist.js"></script>
<!-- endinject -->
<!-- Custom js for this page-->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/5.3.2/bootbox.js"></script>
<script src="js/data-table.js"></script>
<script src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.6/dist/loadingoverlay.min.js"></script>
<!-- End custom js for this page-->



<script src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>

<script>
    $(document).ready(function() {
    var buttonCommon = {
        exportOptions: {
            format: {
                body: function ( data, row, column, node ) {
                    // Strip $ from salary column to make it numeric
                    return column === 5 ?
                        data.replace( /[$,]/g, '' ) :
                        data;
                }
            }
        }
    };
 
    $('#example').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            $.extend( true, {}, buttonCommon, {
                extend: 'copyHtml5'
            } ),
            $.extend( true, {}, buttonCommon, {
                extend: 'excelHtml5'
            } ),
            $.extend( true, {}, buttonCommon, {
                extend: 'pdfHtml5'
            } )
        ]
    } );
} );
</script>
</body>

</html>
