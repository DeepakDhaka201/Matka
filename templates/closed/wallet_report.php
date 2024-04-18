<?php
include "connection/config.php";
if (!checks("admin"))
{
    redirect("login.php");
}


if(isset($_REQUEST['delete'])){
    $delete = $_REQUEST['delete'];
    query("delete from transactions where sn='$delete'");
}

if(isset($_REQUEST['user'])){
$user = $_REQUEST['user'];


$blog = query("select * from transactions where user='$user'");

$us = query("select * from users where mobile='$user'");
$u = fetch($us);

$ref_q = query("select code from refers where user='$user'");
if(rows($ref_q) > 0){
    $ref_d = fetch($ref_q);
    $ref_code = $ref_d['code'];
    $ref_user = fetch(query("select name,mobile from users where code='$ref_code'"));
    
}

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
                        <h4 class="card-title">Wallet Report</h4>
                         <form class="forms-sample" method="post" enctype="multipart/form-data">
                                    
                                    
                                     
                                    <div class="form-group" style="    margin-bottom: 10px !important">
                                        <label for="exampleInputName1">Search User</label>
                                        <input type="text" value="<?php if(isset($_REQUEST['user'])){ echo $_REQUEST['user']; } ?>" class="form-control" id="term" name="term" placeholder="Enter mobile number or name">
                                    </div>
                                    
                                  
                                  
                                </form>
                                
                                <?php 
if(isset($_REQUEST['user'])){ ?>
                                
                                <div class="row card" style="padding: 14px;">
                                    
                                    <div class="col-sm-4">
                                        
                                        <h5>User Name = <?php echo $u['name']; ?></h5>
                                        
                                    </div>
                                    
                                    <div class="col-sm-4">
                                        
                                        <h5>Mobile Number = <?php echo $u['mobile']; ?></h5>
                                        
                                    </div>
                                    
                                    <div class="col-sm-4">
                                        
                                        <h5>Registration Date = <?php echo date('d/m/Y h:i A',$u['created_at']); ?></h5>
                                        
                                    </div>
                                    
                                    <div class="col-sm-4">
                                        
                                        <h5>Wallet Balance = <?php echo $u['wallet']+$u['winning']+$u['bonus']; ?></h5>
                                        
                                    </div>
                                    
                                    
                                </div>
                                
                              
                                
                                 <h4 class="card-title" style="margin-top:20px;">Transaction history</h4>
                                 
                        <div class="row">
                            <div class="col-12">
                                
                                  
                                    
                               
                                
                                <div class="table-responsive">
                                    <table id="order-listing" class="table">
                                            <thead>
                                                <tr>
                                                    <th>Sn</th>
                                                    <th>Amount</th>
                                                    <th>Type</th>
                                                    <th>Remark</th>
                                                    <th>Created by</th>
                                                    <th>Date</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                        <tbody>

                                            <?php $i = 1; while ($bl = fetch($blog)) {
                                            
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
                                            <tr <?php if($bl['wallet_type'] == "3"){ echo "class='rangeela'"; } ?>>
                                                <td><?php echo $i; ?></td>
                                                <td><?php out($bl['amount']); ?></td>
                                                <td><?php if($bl['type']=="0"){ echo "Deduct"; }else { echo "Added"; }  ?></td>
                                                <td><?php out($bl['remark']); ?></td>
                                                <td><?php out($owner); ?></td>
                                                <td><?php out(date('d/m/y h:i A',$bl['created_at'])); ?></td>
                                                  
                                                <td>
                                                    <a href="wallet_report.php?user=<?php echo $bl['user']; ?>&delete=<?php echo $bl['sn']; ?>" onclick="return confirm('Are you sure you want to proceed')"> <button class="btn btn-outline-info">Delete</button> </a>
                                                </td>
                                                
                                               
                                               
                                            </tr>
                                            <?php $i++; } ?>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        
                        <?php } ?>
                        <style>
                            .rangeela {
                                    background: #ffe8a4;
                            }
                        </style>
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
<script src="https://code.jquery.com/ui/1.13.1/jquery-ui.min.js" integrity="sha256-eTyxS0rkjpLEo16uXTS0uVCS4815lc40K2iVpWDvdSY=" crossorigin="anonymous"></script>
<script src="js/data-table.js"></script>
  <script type="text/javascript">
          $(function() {
             $( "#term" ).autocomplete({
               source: 'search_user.php',
                select: function( event, ui ) {
                    window.location.href="wallet_report.php?user="+ui.item.value;
                }
             });
          });
        </script>
<!-- End custom js for this page-->
<style>
    .ui-autocomplete {
        background:white;
    }
    .ui-menu-item {
        padding:10px;
    }
</style>
</body>

</html>
