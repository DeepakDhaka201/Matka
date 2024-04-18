<?php
include "connection/config.php";
if (!checks("admin"))
{
    redirect("login.php");
}

if(isset($_REQUEST['delete'])){
    $sn = $_REQUEST['delete'];
    
    query("delete from gametime_manual where sn='$sn'");
}

if (isset($_REQUEST['active']))
{
    query("update gametime_manual set active='1' where sn='".$_REQUEST['active']."'");
    redirect('market_list_manual.php');
}

if (isset($_REQUEST['inactive']))
{
    query("update gametime_manual set active='0' where sn='".$_REQUEST['inactive']."'");
    redirect('market_list_manual.php');
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
                    
                       <a style="position: absolute;right: 20px;margin-top: 18px;" href="add_market_manaul.php"><button class="btn btn-primary">Add New Market</button></a>
                       
                    <div class="card-body" style="margin-top: 25px;">
                        <h4 class="card-title">Select Market</h4>
                        <div class="row">
                            <div class="col-12">
                                <div class="table-responsive">
                                    <table id="order-listing" class="table">
                                            <thead>
                                                <tr>
                                                    <th>Sn</th>
                                                    <th>Sorted on</th>
                                                    <th>Name</th>
                                                    <th>Open</th>
                                                    <th>Close</th>
                                                    <th>Days</th>
                                                    <th>Action</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                        <tbody>
                                            
                                            <?php
                                            $i = 1;
                                            $get = query("select * from gametime_manual");
                                            while($xc = fetch($get))
                                            { ?>
                                            
                                            
                                            
                                            <tr>
                                                <td><?php echo $i; $i++; ?></td>
                                                <td id="actionmenu<?php echo $i; ?>">
                                                        <div id="actionbar<?php echo $bl['sn']; ?>">
                                                            <input style="width:100px;" value="<?php echo $xc['sort_no']; ?>" type="number" id="bet<?php echo $i; ?>" />
                                                            <button class="btn btn-success" onclick="win('<?php echo $xc['sn']; ?>',$('#bet<?php echo $i; ?>').val())">Update</button>
                                                           
                                                        </div>
                                                       
                                                </td>
                                                <td><?php echo $xc['market']; ?></td>
                                                <td><?php echo $xc['open']; ?></td>
                                                <td><?php echo $xc['close']; ?></td>
                                                <td><?php echo $xc['days']; ?></td>
                                                <td>
                                                    <a href="market_list_manual.php?delete=<?php echo $xc['sn']; ?>"> <button class="btn btn-outline-info" onclick="return confirm('Are you sure you want to remove this market')">Delete</button> </a>
                                                </td>
                                                
                                                  <td>
                                                    <?php if ($xc['active']==1) { ?>
                                                        <a href="market_list_manual.php?inactive=<?php echo $xc['sn']; ?>"> <button class="btn btn-outline-success">Active</button> </a>
                                                    <?php } else { ?>
                                                        <a href="market_list_manual.php?active=<?php echo $xc['sn']; ?>"> <button class="btn btn-outline-warning">Inactive</button> </a>
                                                    <?php } ?>
                                                    
                                                </td>
                                            </tr>
                                            
                                            
                                            
                                            <?php } ?>
                                            
                                             <script>
                                            
                                            function win(sn,sort_by)
                                            {
                                                console.log("ajax/update_sort_manual.php?sort_no="+sort_by+"&sn="+sn);
                                                $.LoadingOverlay("show");
                                                
                                                $.ajax({
                                                  url: "ajax/update_sort.php?sort_no="+sort_by+"&sn="+sn,
                                                  cache: false,
                                                  success: function(html){
                                                      
                                                      console.log(html);
                                                      
                                                     $.LoadingOverlay("hide");
                                                    
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
<script src="js/data-table.js"></script>
<script src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.6/dist/loadingoverlay.min.js"></script>
<!-- End custom js for this page-->
</body>

</html>
