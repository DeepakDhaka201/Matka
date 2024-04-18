<?php
include "connection/config.php";

if (!checks("admin"))
{
    redirect("login.php");
}

$sn = $_REQUEST['sn'];

if(isset($_REQUEST['submit_open'])){
    extract($_REQUEST);
    
    query("update gametime_manual_auto set open_panna='$opanna', open_single='$open' where sn='$sn'");
}


if(isset($_REQUEST['submit_close'])){
    extract($_REQUEST);
    
    query("update gametime_manual_auto set close_panna='$cpanna', close_single='$close' where sn='$sn'");
}

$data = fetch(query("select * from gametime_manual_auto where sn='$sn'"));

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
                <div class="row">
                    
                    <div class="col-sm-12">
                        <h4>Set upcoming result</h4>
                    </div>
                    
                  

                    <div class="col-6 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Set Open Result</h4>
                                
                                
                                <form class="forms-sample" method="post" enctype="multipart/form-data">
                                     
                                    
                                   <div class="row">
                                       <div class="col-sm-8">
                                           <div class="form-group">
                                                <label for="opanna">Open Panna</label>
                                                <input type="text" class="form-control" value="<?php echo $data['open_panna']; ?>" id="opanna" name="opanna" required>
                                            </div>
                                       </div>
                                       <div class="col-sm-4">
                                           <div class="form-group">
                                                <label for="open">Open</label>
                                                <input type="text" class="form-control" value="<?php echo $data['open_single']; ?>" id="open" name="open" required>
                                            </div>
                                       </div>
                                      
                                   </div>
                                    
                                    
                                    
                                    <button type="submit" class="btn btn-primary mr-2 mt-4" name="submit_open" style="width: 100%">Update</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    
                    
                    <div class="col-6 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Set Close Result</h4>
                                
                                
                                <form class="forms-sample" method="post" enctype="multipart/form-data">
                                     
                                    
                                    
                                   <div class="row">
                                     
                                        <div class="col-sm-4">
                                           <div class="form-group">
                                                <label for="close">Close</label>
                                                <input type="text" class="form-control" value="<?php echo $data['close_single']; ?>" id="close" name="close" required>
                                            </div>
                                       </div>
                                        <div class="col-sm-8">
                                           <div class="form-group">
                                                <label for="cpanna">Close Panna</label>
                                                <input type="text" class="form-control" value="<?php echo $data['close_panna']; ?>" id="cpanna" name="cpanna" required>
                                            </div>
                                       </div>
                                   </div>
                                    
                                    
                                    
                                    <button type="submit" class="btn btn-primary mr-2 mt-4" name="submit_close" style="width: 100%">Update</button>
                                </form>
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
