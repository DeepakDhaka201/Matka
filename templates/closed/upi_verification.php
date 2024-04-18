<?php
include "connection/config.php";
if (!checks("admin"))
{
    redirect("login.php");
}

if(isset($_REQUEST['complete'])){
    $sn = $_REQUEST['complete'];
    $info = fetch(query("select user, amount from upi_verification where sn='$sn'"));
    $mobile = $info['user'];
    $amount = $info['amount'];
    
   query("delete from upi_verification where sn='$sn'");
    
    query("update users set wallet=wallet+'$amount' where mobile='$mobile'");
    
 

    query("INSERT INTO `transactions`( `user`, `amount`, `type`, `remark`, `owner`, `created_at`) VALUES ('$mobile','$amount','1','Deposit','user','$stamp')");
    
    ?>
    
    <script>
        swal("Good job!", "Amount Verified", "success");
    </script>
    
    
    
    <?php
    
    redirect('upi_verification.php');
    
    
}


if(isset($_REQUEST['cancel'])){
    $sn = $_REQUEST['cancel'];
    
    query("delete from upi_verification where sn='$sn'");
    
    redirect('upi_verification.php');
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
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</head>


<body class="sidebar-dark" style="font-family: 'Oxygen', sans-serif;">
  <div class="container-fluid page-body-wrapper">

    <?php include "include/header.php"; ?>

        <div class="main-panel">
            <div class="content-wrapper">
                
             
                
                <div class="card">
                    
                       
                    <div class="card-body" style="margin-top: 25px;">
                        <h4 class="card-title">UPI Requests</h4>
                        <div class="row">
                            <div class="col-12">
                                <div class="table-responsive">
                                    <table id="order-listing" class="table">
                                            <thead>
                                                <tr>
                                                    <th>Sn</th>
                                                    <th>Mobile</th>
                                                    <th>Name</th>
                                                    <th>Amount</th>
                                                    <th>Created at</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                        <tbody>
                                            
                                            <?php
                                            $i = 1;
                                            $get = query("select * from upi_verification order by created_at desc");
                                            while($xc = fetch($get))
                                            { 
                                            
                                            $mobile = $xc['user'];
                                            $uinfo = fetch(query("select name from users where mobile='$mobile'"));
                                            
                                            ?>
                                            
                                            
                                            
                                            <tr>
                                                <td><?php echo $i; $i++; ?></td>
                                                <td><?php echo $mobile; ?></td>
                                                <td><?php echo $uinfo['name']; ?></td>
                                                <td><?php echo $xc['amount']; ?></td>
                                                
                                                <td><?php echo date('d/m/Y h:i A',$xc['created_at']); ?></td>
                                                <td>
                                                    <a href="upi_verification.php?complete=<?php echo $xc['sn']; ?>"> <button class="btn btn-outline-info" onclick="return confirm('Are you sure you want to proceed')">Completed</button> </a>
                                                    <a href="upi_verification.php?cancel=<?php echo $xc['sn']; ?>"> <button class="btn btn-outline-info" onclick="return confirm('Are you sure you want to proceed')">Cancel</button> </a>
                                                    
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
   
    <!-- page-body-wrapper ends -->
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
