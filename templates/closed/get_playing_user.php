<?php
// Dummy array representing data that would be fetched from the database
$dummy_data = [
    ['sn' => 1, 'mobile' => '9876543210', 'name' => 'Rajesh Kumar', 'total_bets' => 20, 'total_amount' => 5000, 'today_win' => 1500, 'today_deposit' => 1000, 'total_bid_amount' => 25000, 'total_winning' => 8000, 'total_deposit' => 7000, 'total_withdraw' => 3000, 'total_balance' => 12000, 'created_at' => time()],
    ['sn' => 2, 'mobile' => '8765432109', 'name' => 'Sunita Sharma', 'total_bets' => 15, 'total_amount' => 4000, 'today_win' => 800, 'today_deposit' => 1200, 'total_bid_amount' => 18000, 'total_winning' => 6000, 'total_deposit' => 8000, 'total_withdraw' => 2000, 'total_balance' => 10000, 'created_at' => time()],
    ['sn' => 3, 'mobile' => '7654321098', 'name' => 'Amit Verma', 'total_bets' => 25, 'total_amount' => 6000, 'today_win' => 2000, 'today_deposit' => 1500, 'total_bid_amount' => 30000, 'total_winning' => 10000, 'total_deposit' => 9000, 'total_withdraw' => 4000, 'total_balance' => 15000, 'created_at' => time()],
    ['sn' => 4, 'mobile' => '6543210987', 'name' => 'Priya Singh', 'total_bets' => 18, 'total_amount' => 4500, 'today_win' => 1200, 'today_deposit' => 800, 'total_bid_amount' => 22000, 'total_winning' => 7000, 'total_deposit' => 6000, 'total_withdraw' => 2500, 'total_balance' => 10500, 'created_at' => time()],
    ['sn' => 5, 'mobile' => '5432109876', 'name' => 'Sanjay Patel', 'total_bets' => 22, 'total_amount' => 5500, 'today_win' => 1800, 'today_deposit' => 1100, 'total_bid_amount' => 28000, 'total_winning' => 9000, 'total_deposit' => 8000, 'total_withdraw' => 3500, 'total_balance' => 11500, 'created_at' => time()],
    ['sn' => 6, 'mobile' => '4321098765', 'name' => 'Shanti Devi', 'total_bets' => 16, 'total_amount' => 4200, 'today_win' => 900, 'today_deposit' => 900, 'total_bid_amount' => 20000, 'total_winning' => 5000, 'total_deposit' => 5000, 'total_withdraw' => 1800, 'total_balance' => 8200, 'created_at' => time()],
    ['sn' => 7, 'mobile' => '3210987654', 'name' => 'Vikram Singh', 'total_bets' => 19, 'total_amount' => 4800, 'today_win' => 1500, 'today_deposit' => 1300, 'total_bid_amount' => 23000, 'total_winning' => 7500, 'total_deposit' => 7000, 'total_withdraw' => 2800, 'total_balance' => 9700, 'created_at' => time()]
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
                      <div class="row">
                        
                         
                                     
                                 
                                   <form method="post"  autocomplete="off">
                                        <input autocomplete="false" name="hidden" type="text" style="display:none;">
                                        <div class="form-group" style="    margin-bottom: 10px !important; margin-right:20px;">
                                            <label for="exampleInputName1">From Date</label>
                                            <input type="datepicker" id="datepicker" class="form-control" name="from" required>
                                            <script>
                                                // Get the current date
                                                var currentDate = new Date();
                                            
                                                // Calculate the date 7 days ago
                                                var sevenDaysAgo = new Date(currentDate.getTime() - 7 * 24 * 60 * 60 * 1000);
                                            
                                                // Get the day, month, and year components
                                                var day = String(sevenDaysAgo.getDate()).padStart(2, '0');
                                                var month = String(sevenDaysAgo.getMonth() + 1).padStart(2, '0'); // January is 0!
                                                var year = sevenDaysAgo.getFullYear();
                                            
                                                // Construct the date string in the format dd/mm/yyyy
                                                var formattedDate = day + '/' + month + '/' + year;
                                            
                                                // Set the default value of the datepicker input field
                                                document.getElementById('datepicker').value = formattedDate;
                                            </script>
                                        </div>
                                        
                                           
                                        <div class="form-group" style="    margin-bottom: 10px !important; margin-right:20px;">
                                            <label for="exampleInputName1">To Date</label>
                                            <input type="datepicker" id="datepicker2" class="form-control" name="to" required>
                                            <script>
                                                // Get the current date
                                                var currentDate = new Date();
                                            
                                                // Get the day, month, and year components
                                                var day = String(currentDate.getDate()).padStart(2, '0');
                                                var month = String(currentDate.getMonth() + 1).padStart(2, '0'); // January is 0!
                                                var year = currentDate.getFullYear();
                                            
                                                // Construct the date string in the format dd/mm/yyyy
                                                var formattedDate = day + '/' + month + '/' + year;
                                            
                                                // Set the default value of the datepicker input field
                                                document.getElementById('datepicker2').value = formattedDate;
                                            </script>
                                        </div>
                                         
                                        <button style="margin-top: 32px;" class="btn btn-primary">Filter</button>
                                   </form>
                       
                        
                    </div>
                 </div>
             </div>
             
                <div class="card">
                    <div class="card-body">
                       
                                
                                 <h4 class="card-title" style="margin-top:20px;">Total Playing User history</h4>
                                 
                                 
                                 
                        <div class="row">
                            <div class="col-12">
                                
                                  
                                    
                               
                                
                                <div class="table-responsive">
                                    <table id="order-listing" class="table">
                                            <thead>
                                                <tr>
                                                    <th>Sn</th>
                                                    <th>User Mobile</th>
                                                    <th>User Name</th>
                                                    <th>Today Bets</th>
                                                    <th>Today Bid Amount</th>
                                                    <th>Today Win Amount</th>
                                                    <th>Today Deposit</th>
                                                    <th>Total Bid Amount</th>
                                                    <th>Total Winning</th>
                                                    <th>Total Deposit</th>
                                                    <th>Total Withdraw</th>
                                                    <th>Total Balance</th>
                                                    <th>Date</th>
                                                </tr>
                                            </thead>
                                        <tbody>

                                           
                                        <?php $i = 1; while ($bl = fetch($dummy_data)) { 
                                        ?>
                                            <tr>
                                                <td><?php echo $i; ?></td>
                                                <td><?php if($bl['total_withdraw']-$bl['total_deposit']>0){ echo "<span style='color:red'>$mobile</span>"; }else{echo $bl['mobile'];}?></td>
                                                <td><?php echo $bl['name']; ?></td>
                                                <td><?php echo $bl['total_bets']; ?></td>
                                                <td><?php echo $bl['total_amount']; ?></td>
                                                
                                                <td><?php echo 0+$bl['today_win']; ?></td>
                                                
                                                <td><?php echo 0+$bl['today_deposit']; ?></td>
                                                <td><?php echo 0+$bl['total_bid_amount']; ?></td>
                                                
                                                <td><?php echo 0+$bl['total_winning']; ?></td>
                                                <td><?php echo 0+$bl['total_deposit']; ?></td>
                                                <td><?php echo 0+$bl['total_withdraw']; ?></td>
                                                <td><?php echo $bl['total_balance']; ?></td>
                                                <td><?php echo date("d/m/Y h:i A",$bl['created_at']); ?></td>
                                                
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

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js" integrity="sha512-T/tUfKSV1bihCnd+MxKD0Hm1uBBroVYBOYSk1knyvQ9VyZJpc/ALb4P0r6ubwVPSGB2GvjeoMAJJImBG12TiaQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" integrity="sha512-mSYUmp1HYZDFaVKK//63EcZq4iFWFjxSL+Z3T/aCt4IO9Cejm03q3NKKYN6pFQzY0SBOr8h+eCIAZHPXcpZaNw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<style>
    .datepicker {
            z-index: 99999 !important;
    }
</style>
<script>
$('#datepicker').datepicker({
    format: 'dd/mm/yyyy',
    endDate: '0d'
});
$('#datepicker2').datepicker({
    format: 'dd/mm/yyyy',
    endDate: '0d'
});
</script>


<!-- End custom js for this page-->
</body>

</html>
