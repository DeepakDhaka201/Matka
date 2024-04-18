<?php
include "connection/config.php";
if (!checks("admin"))
{
    redirect("login.php");
}
if(!isset($_SESSION['permission']) || $_SESSION['permission'] != 'all'){
    redirect("index.php");
}


$game = $_REQUEST['game'];
$market = $_REQUEST['market'];

$blog = query("select date from games where bazar='$market' AND game='$game' group by date"); 



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
                        <h4 class="card-title">Select Date</h4>
                        <div class="row">
                            <div class="col-12">
                                <div class="table-responsive">
                                    <table id="order-listing" class="table">
                                            <thead>
                                                <tr>
                                                    <th>Sn</th>
                                                    <th>Date</th>
                                                    <th>Amount</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                        <tbody>

                                        <?php $i = 1; while ($bl = fetch($blog)) {
                                            
                                            $dat = $bl['date'];
                                        
                                        $chk = query("select date from games where bazar='$market' AND game='$game' AND date='$dat' AND status='1'");
                                        
                                          $ttl = query("select sum(amount) as total from games where bazar='$market' AND game='$game' AND date='$dat'");
                                          $tt = fetch($ttl);
                                        
                                        
                                        
                                        ?>
                                            <tr>
                                                <td><?php echo $i; ?></td>
                                                <td><?php echo $bl['date']; ?></td>
                                                <td><?php echo $tt['total']; ?></td>
                                                <td>
                                                    <a href="bets.php?game=<?php echo $game; ?>&market=<?php echo $market; ?>&date=<?php echo $bl['date']; ?>"> <button class="btn btn-outline-info">Select</button> </a>
                                                    <a href="report.php?game=<?php echo $game; ?>&market=<?php echo $market; ?>&date=<?php echo $bl['date']; ?>"> <button class="btn btn-outline-info">View Report</button> </a>
                                                    <?php if(rows($chk) == 0)
                                                    { ?>
                                                      <a href="publish.php?game=<?php echo $game; ?>&market=<?php echo $market; ?>&date=<?php echo $bl['date']; ?>"> <button class="btn btn-outline-success">Publish Result</button> </a>
                                                      <?php } ?>
                                                </td>
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
<script src="js/data-table.js"></script>
<!-- End custom js for this page-->
</body>

</html>
