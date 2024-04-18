<?php
include "connection/config.php";
if (!checks("admin"))
{
    redirect("login.php");
}

$num = $_REQUEST['number'];

$game = $_REQUEST['game'];
$date = $_REQUEST['date'];
$market = $_REQUEST['market'];

$total = query("select sum(amount) as total from games where bazar='$market' AND game='$game' AND date='$date' AND number='$num'");
$ttl = fetch($total);

$xx = query("select * from games where bazar='$market' AND game='$game' AND date='$date' AND number='$num'");



if(isset($_REQUEST['submit2']))
{
    extract($_REQUEST);
    
    $xx = query("select * from games where bazar='$market' AND game='$game' AND date='$date' AND number='$num'");
    
    while($x = fetch($xx))
    {
        $sn = $x['sn'];
        $user = $x['user'];
      //  $amount = $x['amount']*$rate;
        
        updateWinning($user, $x['game'], $x['amount'], $sn, $x);  
    }
    redirect("success.php");
    
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


<body class="sidebar-dark" style="font-family: 'Oxygen', sans-serif;">
  <div class="container-fluid page-body-wrapper">

    <?php include "include/header.php"; ?>

        <div class="main-panel">
            <div class="content-wrapper">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Manage Bets ( Total Amount - <?php echo $ttl['total']; ?> )</h4>
                        <div class="row">
                            <div class="col-12">
                                <div class="table-responsive">
                                    <table id="example" class="table">
                                            <thead>
                                                <tr>
                                                    <th>Sn</th>
                                                    <th>User Mobile</th>
                                                    <th>User Name</th>
                                                    <th>Number</th>
                                                    <th>Amount</th>
                                                    <th>Winning Amount</th>
                                                </tr>
                                            </thead>
                                        <tbody>

                                        <?php $i = 1; while ($bl = fetch($xx)) { 
                                        $user = $bl['user'];
                                        
                                        $csx = query("select * from users where mobile='$user'");
                                        $xs = fetch($csx);
                                        
                                        
                                        $rate = getUserRate($user,$game);

                                        ?>
                                            <tr>
                                                <td><?php echo $i; ?></td>
                                                <td><?php echo $bl['user']; ?></td>
                                                <td><?php echo $xs['name']; ?></td>
                                                <td><?php echo $bl['number']; ?></td>
                                                <td><?php echo $bl['amount']; ?></td>
                                                <td><?php echo $bl['amount']*$rate; ?></td>
                                               
                                            </tr>
                                        <?php $i++; } ?>
                                        
                                        
                                        </tbody>
                                    </table>
                                </div>
                                
                                <div class="text-right pt-2">
                                    <form method="get">
                                        
                                          
                                        <input type="hidden" name="market" value="<?php echo $market; ?>" class="form-control" required>
                                        
                                        <input type="hidden" name="game"  value="<?php echo $game; ?>" class="form-control" required>
                                        
                                        <input type="hidden" name="date"  value="<?php echo $date; ?>"  class="form-control"  required>

                                        <input type="hidden" name="num"  value="<?php echo $num; ?>"  class="form-control"  required>




                                            <button type="submit" onclick="return confirm('This action cannot be undone after proccess, Are you sure you want to continue');" name="submit2" class="btn btn-primary">Verify and Publish</button>
                                            </form>
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
