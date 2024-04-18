<?php
// Dummy array representing data that would be fetched from the database
$dummy_data = [
    ['sn' => 1,'name' => 'Rajesh Sharma', 'mobile' => '9876543210', 'email' => 'rajesh@example.com', 'password' => 'rajesh123', 'wallet' => 150, 'winning' => 75, 'bonus' => 15, 'created_at' => time(), 'active' => 1],
    ['sn' => 2,'name' => 'Neha Patel', 'mobile' => '8765432109', 'email' => 'neha@example.com', 'password' => 'neha456', 'wallet' => 200, 'winning' => 100, 'bonus' => 20, 'created_at' => time(), 'active' => 1],
    ['sn' => 3,'name' => 'Sanjay Singh', 'mobile' => '7654321098', 'email' => 'sanjay@example.com', 'password' => 'sanjay789', 'wallet' => 180, 'winning' => 90, 'bonus' => 18, 'created_at' => time(), 'active' => 1],
    ['sn' => 4,'name' => 'Pooja Mehta', 'mobile' => '6543210987', 'email' => 'pooja@example.com', 'password' => 'pooja654', 'wallet' => 220, 'winning' => 110, 'bonus' => 22, 'created_at' => time(), 'active' => 0],
    ['sn' => 5,'name' => 'Manish Gupta', 'mobile' => '5432109876', 'email' => 'manish@example.com', 'password' => 'manish123', 'wallet' => 190, 'winning' => 95, 'bonus' => 19, 'created_at' => time(), 'active' => 0],
    ['sn' => 6,'name' => 'Ritu Jain', 'mobile' => '4321098765', 'email' => 'ritu@example.com', 'password' => 'ritu789', 'wallet' => 170, 'winning' => 85, 'bonus' => 17, 'created_at' => time(), 'active' => 1],
    ['sn' => 7,'name' => 'Amit Verma', 'mobile' => '3210987654', 'email' => 'amit@example.com', 'password' => 'amit456', 'wallet' => 210, 'winning' => 105, 'bonus' => 21, 'created_at' => time(), 'active' => 0],
    // Add more dummy data as needed
];

// Dummy fetch function that iterates over the dummy data array
function fetch($data) {
    static $index = 0;
    if ($index < count($data)) {
        return $data[$index++];
    }
    return false;
}

// Dummy out function for displaying output
function out($data) {
    echo htmlentities($data); // Use htmlentities to prevent XSS attacks
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
                        <h4 class="card-title">Manage Users</h4>
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

                                            <?php $i = 1; while ($bl = fetch($dummy_data)) { ?>
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
