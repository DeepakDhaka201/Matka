<?php
include "connection/config.php";
if (!checks("admin"))
{
    redirect("login.php");
}


$blog = query("select * from refers order by status desc"); 



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
                    <div class="card-body">
                        <h4 class="card-title">Manage Refers</h4>
                        <div class="row">
                            <div class="col-12">
                                <div class="table-responsive">
                                    <table id="order-listing" class="table">
                                            <thead>
                                                <tr>
                                                    <th>Sn</th>
                                                    <th>User Mobile</th>
                                                    <th>User Name</th>
                                                    <th>Refered by</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                        <tbody>

                                        <?php $i = 1; while ($bl = fetch($blog)) { 
                                        $code = $bl['code'];
                                        
                                        $csx = query("select * from users where code='$code'");
                                        $xs = fetch($csx);

										$user = $bl['user'];
                                        
                                        $csxx = query("select * from users where mobile='$user'");
                                        $xsx = fetch($csxx);
                                        ?>
                                            <tr>
                                                <td><?php echo $i; ?></td>
                                                <td><?php echo $bl['user']; ?></td>
                                                <td><?php echo $xsx['name']; ?></td>
                                                <td><?php echo $xs['name'].' ( '.$xs['mobile'].' ) '; ?></td>
                                                <td id="actionmenu<?php echo $i; ?>">
                                                    <?php if($bl['status'] == "1")
                                                    { ?>
                                                        Already Updated
                                                    <?php } else { ?>
                                                        <div id="actionbar<?php echo $bl['sn']; ?>">
                                                            <input style="width:100px;" type="number" value="10" id="bet<?php echo $i; ?>" />
                                                            <button class="btn btn-success" onclick="win('<?php echo $bl['sn']; ?>',$('#bet<?php echo $i; ?>').val(),'<?php echo $bl['user']; ?>')">Update</button>
                                                        </div>
                                                        <span style="display:none;" id="msg<?php echo $bl['sn']; ?>">Already updated</span>
                                                    <?php  } ?>
                                                </td>
                                            </tr>
                                        <?php $i++; } ?>
                                        
                                        <script>
                                            
                                            function win(sn,amount,user)
                                            {
                                                console.log("ajax/refer.php?user="+user+"&amount="+amount+"&sn="+sn);
                                                $.LoadingOverlay("show");
                                                
                                                $.ajax({
                                                  url: "ajax/refer.php?user="+user+"&amount="+amount+"&sn="+sn,
                                                  cache: false,
                                                  success: function(html){
                                                      
                                                      console.log(html);
                                                      
                                                     $.LoadingOverlay("hide");
                                                    
                                                    $('#actionbar'+sn).hide();
                                                    $('#msg'+sn).show();
                                                  }
                                                });
                                            }
                                            
                                           
                                            
                                        </script>

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

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/5.3.2/bootbox.js"></script>
<script src="js/data-table.js"></script>
<script src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.6/dist/loadingoverlay.min.js"></script>
<!-- End custom js for this page-->
</body>

</html>
