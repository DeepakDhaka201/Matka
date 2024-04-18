<?php
include "connection/config.php";
if (!checks("admin"))
{
    redirect("login.php");
}

$user = $_REQUEST['user'];



if(isset($_REQUEST['revert']))
{
    extract($_REQUEST);
    
    $at = fetch(query("select * from auto_history where sn='$revert'"));
    
    $gid = $at['game_id'];
    $am = $at['amount'];
    
    $bl = fetch(query("select * from games where sn='$gid'"));
                                            
    $user = $bl['user'];
    
    // echo "update users set wallet=wallet-'$am' where mobile='$user'";
    // echo "<br>";
    // echo "delete from transactions where game_id='$gid'";
    // echo "<br>";
    // echo "update auto_history set revert='1' where sn='$revert'";
    
    query("update users set wallet=wallet-'$am' where mobile='$user'");
    query("delete from transactions where game_id='$gid' AND user='$user'");
    query("update auto_history set revert='1' where sn='$revert'");
    query("update games set status='0' where sn='$gid'");
}

$blog = query("select * from auto_history order by sn desc");


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

    <!-- partial -->
    
        <div class="main-panel">
            <div class="content-wrapper">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Auto history</h4>
                        <div class="row">
                            <div class="col-12">
                                <div class="table-responsive">
                                    <table id="order-listing" class="table">
                                            <thead>
                                                <tr>
                                                    <th>Sn</th>
                                                    <th>User Mobile</th>
                                                    <th>User Name</th>
                                                    <th>Game</th>
                                                    <th>Market</th>
                                                    <th>Number</th>
                                                    <th>Bet Amount</th>
                                                    <th>Win Amount</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                        <tbody>

                                        <?php $i = 1; while ($blx = fetch($blog)) { 
                                            
                                        $g_id = $blx['game_id'];
                                        
                                        $bl = fetch(query("select * from games where sn='$g_id'"));
                                            
                                        $user = $bl['user'];
                                        
                                        $csx = query("select * from users where mobile='$user'");
                                        $xs = fetch($csx);
                                        ?>
                                            <tr>
                                                <td><?php echo $i; ?></td>
                                                <td><?php echo $blx['user']; ?></td>
                                                <td><?php echo $xs['name']; ?></td>
                                                <td><?php echo $bl['game']; ?></td>
                                                <td><?php echo $bl['bazar']; ?></td>
                                                <td><?php if($game=="jodi"){ echo sprintf("%02d", $bl['number']); } else {  echo $bl['number']; } ?></td>
                                                <td><?php echo $bl['amount']; ?></td>
                                                <td><?php echo $blx['amount']; ?></td>
                                                <td><?php if($blx['revert']=="0"){ ?>
                                                     <a class="btn btn-danger" onclick="return confirm('are you sure you want to revert this ?')" href="auto_history.php?revert=<?php echo $blx['sn']; ?>" style="margin-left:20px;">Revert Back</a>
                                                     <?php } else { ?>
                                                            Reverted
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
                    <span class="text-muted d-block text-center text-sm-left d-sm-inline-block">Copyright © 2019 <a href="http://www.abhastra.com/" target="_blank">Doxy Play</a>. All rights reserved.</span>
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
