<?php
include "connection/config.php";
if (!checks("admin"))
{
    redirect("login.php");
}
if (isset($_REQUEST['active']))
{
    verification();
    query("update users set active='1' where sn='".$_REQUEST['active']."'");
    redirect('buser.php');
}

if (isset($_REQUEST['inactive']))
{
    verification();
    query("update users set active='0' where sn='".$_REQUEST['inactive']."'");
    redirect('buser.php');
}

if (isset($_REQUEST['delete']))
{
    verification();
    query("delete from users where sn='".$_REQUEST['delete']."'");
    redirect('buser.php');
}

if(isset($_REQUEST['partner'])){
    $partner = $_REQUEST['partner'];
    $blog = query("select * from users where partner='$partner' where active = '0'");
} else {
    $blog = query("select * from users where active = '0'");
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
    <link rel="stylesheet" href="css/horizontal-layout-light/style.css?v=2">
    <!-- endinject -->
    <link rel="shortcut icon" href="images/favicon.png" />
</head>

<body class="sidebar-dark" style="font-family: 'Oxygen', sans-serif;">
<div class="container-fluid page-body-wrapper">
    <!-- partial:partials/_horizontal-navbar.html -->
    <?php include "include/header.php"; ?>

   
        <div class="main-panel">
            <div class="content-wrapper">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Blocked Users</h4>
                        <div class="row">
                            <div class="col-12">
                                <div class="table-responsive">
                                    <table id="order-listing" class="table">
                                            <thead>
                                                <tr>
                                                    <th>Sn</th>
                                                    <th>Name</th>
                                                    <th>Mobile number</th>
                                                    <th>Email</th>
                                                    <th>Password</th>
                                                    <th>Total Balance</th>
                                                    <th>Deposit Wallet</th>
                                                    <th>Winning Wallet</th>
                                                    <th>Bonus Wallet</th>
                                                    <th>Register time</th>
                                                    <th>View bets</th>
                                                    <th>Update wallet</th>
                                                    
                                                    <th>Change password</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                        <tbody>

                                            <?php $i = 1; while ($bl = fetch($blog)) { ?>
                                            <tr>
                                                <td><?php echo $i; ?></td>
                                                <td><?php out($bl['name']); ?></td>
                                                <td><?php out($bl['mobile']); ?></td>
                                                <td><?php out($bl['email']); ?></td>
                                                <td><?php out($bl['password']); ?></td>
                                                <td><?php out($bl['wallet']+$bl['winning']+$bl['bonus']); ?></td>
                                                <td><?php out($bl['wallet']); ?></td>
                                                <td><?php out($bl['winning']); ?></td>
                                                <td><?php out($bl['bonus']); ?></td>
                                                <td><?php out(date('d/m/y h:i A',$bl['created_at'])); ?></td>
                                                
                                                <td>
                                                    <a href="all_bets.php?mobile=<?php echo $bl['mobile']; ?>"> <button class="btn btn-outline-info">View bets</button> </a>
                                                </td>
                                                
                                                <td>
                                                    <a href="wallet.php?user=<?php echo $bl['mobile']; ?>"> <button class="btn btn-outline-info">Manage wallet</button> </a>
                                                </td>
                                                
                                            
                                                 
                                                <td>
                                                    <a href="userpass.php?sn=<?php echo $bl['sn']; ?>"> <button class="btn btn-outline-info">Change password</button> </a>
                                                </td>
                                                
                                                <td>
                                                    <?php if ($bl['active']==1) { ?>
                                                        <a href="users.php?inactive=<?php echo $bl['sn']; ?>"> <button class="btn btn-outline-success">Active</button> </a>
                                                    <?php } else { ?>
                                                        <a href="users.php?active=<?php echo $bl['sn']; ?>"> <button class="btn btn-outline-warning">Inactive</button> </a>
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
    <!-- page-body-wrapper ends -->
</div>
<!-- container-scroller -->
<!-- plugins:js -->
<script src="vendors/js/vendor.bundle.base.js?v=2"></script>
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
