<?php
include "connection/config.php";
if (!checks("admin"))
{
    redirect("login.php");
}
// if(!isset($_SESSION['permission']) || $_SESSION['permission'] != 'all'){
//     redirect("index.php");
// }


$user = $_REQUEST['user'];


if(isset($_REQUEST['revert'])){
    $id = $_REQUEST['revert'];
    
    $get = query("select * from transactions where batch_id='$id'");
    
    while($g = fetch($get)){
        $sn = $g['sn'];
        
        $amount = $g['amount'];
        $user = $g['user'];
        
        query("update user set wallet=wallet-'$amount' where mobile='$user'");
        query("delete from transactions where sn='$sn'");
    }
    
    query("update starline_batch set revert='1' where batch_id='$id'");
}

$blog = query("select * from starline_batch order by sn desc");



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
    
    <style>
        .ref {
                background: #4caf50;
                padding: 10px;
                color: white;
                font-size: 15px;
                border-radius: 5px;
                margin-top: 20px;
                display:none;
        }
    </style>
</head>

<body class="sidebar-dark" style="font-family: 'Oxygen', sans-serif;">
  <div class="container-fluid page-body-wrapper">
    <?php include "include/header.php"; ?>

        <div class="main-panel">
            <div class="content-wrapper">
                <div class="card">
                    <div class="card-body">
                        
                                
                                 <h4 class="card-title" style="margin-top:20px;">Starline Result history</h4>
                                 
                        <div class="row">
                            <div class="col-12">
                                
                                  
                                    
                               
                                
                                <div class="table-responsive">
                                    <table id="order-listing" class="table">
                                            <thead>
                                                <tr>
                                                    <th>Sn</th>
                                                    <th>Market</th>
                                                    <th>Timing</th>
                                                    <th>Result</th>
                                                    <th>Date</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                        <tbody>

                                            <?php $i = 1; while ($bl = fetch($blog)) {
                                            
                                            
                                            ?>
                                            <tr>
                                                <td><?php echo $i; ?></td>
                                                <td><?php out($bl['bazar']); ?></td>
                                                <td><?php out($bl['timing']); ?></td>
                                                <td><?php out($bl['result']); ?></td>
                                                <td><?php out(date('d/m/y h:i A',$bl['created_at'])); ?></td>
                                                
                                                 <td>
                                                      <a href="batch_history.php?batch_id=<?php echo $bl['batch_id']; ?>"> <button class="btn btn-outline-success">View Winnings</button> </a>
                                                     
                                                      <?php if ($bl['revert']==1) { ?>
                                                       <span>Reverted Back</span>
                                                    <?php } else { ?>
                                                       <a onclick="return confirm('Are you sure you want to revert this back ?')" href="starline_history.php?revert=<?php echo $bl['batch_id']; ?>"> <button class="btn btn-outline-warning">Revert Back</button> </a>
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
                    <span class="text-muted d-block text-center text-sm-left d-sm-inline-block">Copyright © 2023 <a target="_blank">A</a>. All rights reserved.</span>
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
