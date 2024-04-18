<?php
include "connection/config.php";
if (!checks("admin"))
{
    redirect("login.php");
}




if(isset($_REQUEST['delete'])){
    $sn = $_REQUEST['delete'];
    
    query("delete from card_timings where sn='$sn'");
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
                    
                       <a style="position: absolute;right: 20px;margin-top: 18px;" href="card_timings_add.php?"><button class="btn btn-primary">Add New Timing</button></a>
                       
                    <div class="card-body" style="margin-top: 25px;">
                        <h4 class="card-title">Market Timings</h4>
                        <div class="row">
                            <div class="col-12">
                                <div class="table-responsive">
                                    <table id="order-listing" class="table">
                                            <thead>
                                                <tr>
                                                    <th>Sn</th>
                                                    <th>Name</th>
                                                    <th>Close</th>
                                                    <th>Auto Update Time</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                        <tbody>
                                            
                                            <?php
                                            $i = 1;
                                            $get = query("select * from card_timings");
                                            while($xc = fetch($get))
                                            { ?>
                                            
                                            
                                            
                                            <tr>
                                                <td><?php echo $i; $i++; ?></td>
                                              
                                                <td><?php echo $xc['name']; ?></td>
                                                <td><?php echo $xc['close']; ?></td>
                                                <td id="actionmenu<?php echo $i; ?>">
                                                        <div id="actionbar<?php echo $bl['sn']; ?>">
                                                            <input style="width:100px;" value="<?php echo $xc['auto']; ?>" type="text" id="bet<?php echo $i; ?>" />
                                                            <button class="btn btn-success" onclick="win('<?php echo $xc['sn']; ?>',$('#bet<?php echo $i; ?>').val())">Update</button>
                                                           
                                                        </div>
                                                       
                                                </td>
                                                <td>
                                                    <a href="card_timings.php?delete=<?php echo $xc['sn']; ?>&sn=<?php echo $market; ?>"> <button class="btn btn-outline-info" onclick="return confirm('Are you sure you want to remove this market')">Delete</button> </a>
                                                  
                                                </td>
                                            </tr>
                                            
                                            
                                            
                                            <?php } ?>
                                            
                                           

                                        </tbody>
                                    </table>
                                    
                                     <script>
                                            
                                            function win(sn,sort_by)
                                            {
                                                $.LoadingOverlay("show");
                                                
                                                $.ajax({
                                                  url: "ajax/update_auto.php?sort_no="+sort_by+"&sn="+sn,
                                                  cache: false,
                                                  success: function(html){
                                                      
                                                      console.log(html);
                                                      
                                                     $.LoadingOverlay("hide");
                                                    
                                                  }
                                                });
                                            }
                                            
                                         
                                            
                                        </script>
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
