<?php
include "connection/config.php";
if (!checks("admin"))
{
    redirect("login.php");
}
// if(!isset($_SESSION['permission']) || $_SESSION['permission'] != 'all'){
//     redirect("index.php");
// }


$game = $_REQUEST['game'];


?>

<!DOCTYPE html>
<html lang="en">


<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Admin Panel | Codegente</title>
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
                        <h4 class="card-title">Select Market</h4>
                        <div class="row">
                            <div class="col-12">
                                <div class="table-responsive">
                                    <table id="order-listing" class="table">
                                            <thead>
                                                <tr>
                                                    <th>Sn</th>
                                                    <th>Name</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                        <tbody>
                                            
                                               <?php
                                            
                                            $i = 1;
                                            $get = query("select * from gametime_manual");
                                            while($xc = fetch($get))
                                            {
                                            
                                             if($game != "jodi" && $game != "fullsangam" && $game != "halfsangam"){
                                            
                                            ?>
                                            
                                            
                                            
                                            <tr>
                                                <td><?php echo $i; $i++; ?></td>
                                                <td><?php echo $xc['market']; ?> Open</td>
                                                <td>
                                                    <a href="dates.php?game=<?php echo $game; ?>&market=<?php echo str_replace(" ","_",$xc['market']); ?>_OPEN"> <button class="btn btn-outline-info">Select</button> </a>
                                                </td>
                                            </tr>
                                            
                                            <tr>
                                                <td><?php echo $i; $i++; ?></td>
                                                <td><?php echo $xc['market']; ?> Close</td>
                                                <td>
                                                    <a href="dates.php?game=<?php echo $game; ?>&market=<?php echo str_replace(" ","_",$xc['market']); ?>_CLOSE"> <button class="btn btn-outline-info">Select</button> </a>
                                                </td>
                                            </tr>
                                            
                                            
                                            <?php } else { ?>
                                            
                                               
                                            <tr>
                                                <td><?php echo $i; $i++; ?></td>
                                                <td><?php echo $xc['market']; ?></td>
                                                <td>
                                                    <a href="dates.php?game=<?php echo $game; ?>&market=<?php echo str_replace(" ","_",$xc['market']); ?>"> <button class="btn btn-outline-info">Select</button> </a>
                                                </td>
                                            </tr>
                                            
                                            
                                            
                                            <?php } } ?>

                                            
                                            <?php
                                            $get = query("select * from gametime_new");
                                            while($xc = fetch($get))
                                            {
                                            
                                            if($game != "jodi"){
                                            
                                            ?>
                                            
                                            
                                            
                                            <tr>
                                                <td><?php echo $i; $i++; ?></td>
                                                <td><?php echo $xc['market']; ?> Open</td>
                                                <td>
                                                    <a href="dates.php?game=<?php echo $game; ?>&market=<?php echo str_replace(" ","_",$xc['market']); ?>_OPEN"> <button class="btn btn-outline-info">Select</button> </a>
                                                </td>
                                            </tr>
                                            
                                            <tr>
                                                <td><?php echo $i; $i++; ?></td>
                                                <td><?php echo $xc['market']; ?> Close</td>
                                                <td>
                                                    <a href="dates.php?game=<?php echo $game; ?>&market=<?php echo str_replace(" ","_",$xc['market']); ?>_CLOSE"> <button class="btn btn-outline-info">Select</button> </a>
                                                </td>
                                            </tr>
                                            
                                            
                                            <?php } else { ?>
                                            
                                               
                                            <tr>
                                                <td><?php echo $i; $i++; ?></td>
                                                <td><?php echo $xc['market']; ?></td>
                                                <td>
                                                    <a href="dates.php?game=<?php echo $game; ?>&market=<?php echo str_replace(" ","_",$xc['market']); ?>"> <button class="btn btn-outline-info">Select</button> </a>
                                                </td>
                                            </tr>
                                            
                                            
                                            
                                            <?php } } ?>

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
