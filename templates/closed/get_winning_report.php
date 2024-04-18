<?php
$dummy_data = [
    ['user' => '9876543210', 'name' => 'Ramesh Sharma', 'amount' => 500, 'type' => 'Deduct', 'remark' => 'Payment for service', 'owner' => 'User', 'created_at' => time()],
    ['user' => '8765432109', 'name' => 'Suresh Patel', 'amount' => 1000, 'type' => 'Added', 'remark' => 'Referral bonus', 'owner' => 'Admin', 'created_at' => time()],
    ['user' => '7654321098', 'name' => 'Rajesh Singh', 'amount' => 200, 'type' => 'Added', 'remark' => 'Deposit', 'owner' => 'Partner', 'created_at' => time()],
    ['user' => '6543210987', 'name' => 'Amit Kumar', 'amount' => 800, 'type' => 'Deduct', 'remark' => 'Purchase', 'owner' => 'User', 'created_at' => time()],
    ['user' => '5432109876', 'name' => 'Vijay Sharma', 'amount' => 300, 'type' => 'Added', 'remark' => 'Deposit', 'owner' => 'User', 'created_at' => time()],
    ['user' => '4321098765', 'name' => 'Sanjay Gupta', 'amount' => 1500, 'type' => 'Deduct', 'remark' => 'Payment for service', 'owner' => 'Admin', 'created_at' => time()],
    ['user' => '3210987654', 'name' => 'Rahul Verma', 'amount' => 600, 'type' => 'Added', 'remark' => 'Deposit', 'owner' => 'Partner', 'created_at' => time()]
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
                                                var currentDate = new Date();
                                                var sevenDaysAgo = new Date(currentDate.getTime() - 7 * 24 * 60 * 60 * 1000);
                                                var day = String(sevenDaysAgo.getDate()).padStart(2, '0');
                                                var month = String(sevenDaysAgo.getMonth() + 1).padStart(2, '0');
                                                var year = sevenDaysAgo.getFullYear();
                                                var formattedDate = day + '/' + month + '/' + year;
                                                document.getElementById('datepicker').value = formattedDate;
                                            </script>
                                        </div>
                                        
                                           
                                        <div class="form-group" style="    margin-bottom: 10px !important; margin-right:20px;">
                                            <label for="exampleInputName1">To Date</label>
                                            <input type="datepicker" id="datepicker2" class="form-control" name="to" required>
                                            <script>
                                                var currentDate = new Date();
                                                var day = String(currentDate.getDate()).padStart(2, '0');
                                                var month = String(currentDate.getMonth() + 1).padStart(2, '0'); // January is 0!
                                                var year = currentDate.getFullYear();
                                                var formattedDate = day + '/' + month + '/' + year;
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
                       
                                
                                 <h4 class="card-title" style="margin-top:20px;">Winning history</h4>
                                 
                                 
                                 
                        <div class="row">
                            <div class="col-12">
                                
                                  
                                    
                               
                                
                                <div class="table-responsive">
                                    <table id="order-listing" class="table">
                                            <thead>
                                                <tr>
                                                    <th>Sn</th>
                                                    <th>User Mobile</th>
                                                    <th>User Name</th>
                                                    <th>Amount</th>
                                                    <th>Type</th>
                                                    <th>Remark</th>
                                                    <th>Created by</th>
                                                    <th>Date</th>
                                                </tr>
                                            </thead>
                                        <tbody>

                                            <?php $allam = 0; $i = 1; while ($bl = fetch($dummy_data)) {
                                                
                                                $allam += $bl['amount'];
                                            
                                            if($bl['owner']=="")
                                            {
                                                $owner = "User";
                                            }
                                            else if($bl['owner'] == "admin@gmail.com")
                                            {
                                                $owner = "Admin";
                                            }
                                            else
                                            {
                                                $owner= "Partner";
                                            }
                                            
                                            
                                            ?>
                                            <tr>
                                                <td><?php echo $i; ?></td>
                                                <td><?php out($bl['user']); ?></td>
                                                <td><?php out($bl['name']); ?></td>
                                                <td><?php out($bl['amount']); ?></td>
                                                <td><?php if($bl['type']=="0"){ echo "Deduct"; }else { echo "Added"; }  ?></td>
                                                <td><?php out($bl['remark']); ?></td>
                                                <td><?php out($owner); ?></td>
                                                <td><?php out(date('d/m/y h:i A',$bl['created_at'])); ?></td>
                                                
                                               
                                               
                                            </tr>
                                            <?php $i++; } ?>
                                            
                                            <tfoot>
                                                <td>Total</td>
                                                <td></td>
                                                <td></td>
                                                <td><?php echo $allam; ?></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            </tfoot>

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
