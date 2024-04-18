<?php
include "connection/config.php";
if (!checks("admin"))
{
    redirect("login.php");
}

if(isset($_REQUEST['delete'])){
    $sn = $_REQUEST['delete'];
    
    query("delete from gametime_auto where sn='$sn'");
}

if(isset($_REQUEST['open'])){
    $sn = $_REQUEST['open'];
    $update = $_REQUEST['update'];
    
    query("update gametime_auto set is_open_next='$update' where sn='$sn'");
}

if(isset($_REQUEST['close'])){
    $sn = $_REQUEST['close'];
    $update = $_REQUEST['update'];
    
    query("update gametime_auto set is_close_next='$update' where sn='$sn'");
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
                    
                       <a style="position: absolute;right: 20px;margin-top: 18px;" href="add_market_auto.php"><button class="btn btn-primary">Add New Market</button></a>
                       
                    <div class="card-body" style="margin-top: 25px;">
                        <h4 class="card-title">Select Market</h4>
                        <div class="row">
                            <div class="col-12">
                                <div class="table-responsive">
                                    <table id="order-listing" class="table">
                                            <thead>
                                                <tr>
                                                    <th>Sn</th>
                                                    <th>Name</th>
                                                    <th>Open</th>
                                                    <th>Close</th>
                                                    <th>Days</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                        <tbody>
                                            
                                            <?php
                                            $i = 1;
                                            $get = query("select * from gametime_auto");
                                            while($xc = fetch($get))
                                            { ?>
                                            
                                            
                                            
                                            <tr>
                                                <td><?php echo $i; $i++; ?></td>
                                               
                                                <td><?php echo $xc['market']; ?></td>
                                                <td><?php echo $xc['open']; ?></td>
                                                <td><?php echo $xc['close']; ?></td>
                                                <td><?php echo $xc['days']; ?></td>
                                                <td>
                                                    <?php if($xc['is_open_next'] == "0"){ ?>
                                                     <a href="market_list_auto.php?open=<?php echo $xc['sn']; ?>&update=1"> <button class="btn btn-outline-info">Open Next Enable</button> </a>
                                                    <?php } else { ?>
                                                    
                                                    <a href="market_list_auto.php?open=<?php echo $xc['sn']; ?>&update=0"> <button class="btn btn-outline-info">Open Next Disable</button> </a>
                                                    <?php } ?>
                                                    
                                                    <?php if($xc['is_close_next'] == "0"){ ?>
                                                     <a href="market_list_auto.php?close=<?php echo $xc['sn']; ?>&update=1"> <button class="btn btn-outline-info">Close Next Enable</button> </a>
                                                    <?php } else { ?>
                                                    
                                                    <a href="market_list_auto.php?close=<?php echo $xc['sn']; ?>&update=0"> <button class="btn btn-outline-info">Close Next Disable</button> </a>
                                                    <?php } ?>
                                                    
                                                     
                                                      <a href="market_list_auto.php?delete=<?php echo $xc['sn']; ?>"> <button class="btn btn-outline-info" onclick="return confirm('Are you sure you want to remove this market')">Delete</button> </a>
                                                   
                                                 </td>
                                            </tr>
                                            
                                            
                                            
                                            <?php } ?>
                                            
                                            
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
<script src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.6/dist/loadingoverlay.min.js"></script>
<!-- End custom js for this page-->
</body>

</html>
