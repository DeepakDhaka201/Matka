<?php
include "connection/config.php";

if (!checks("admin"))
{
    redirect("login.php");
}

$time = date("H:i",$stamp);
$day = strtoupper(date("l",$stamp));
$date = date("d/m/Y");

$sn = $_REQUEST['sn'];



if (isset($_REQUEST['submit']))
{
    extract($_REQUEST);
    
    if(strlen($panna) != 3 && strlen($open) != 1){
        
        $error = "Open must be 1 digit and panna must be 3 digit";
        
    } else {
        
        query("INSERT INTO `starline_results`( `market`, `timing`, `panna`, `number`, `date`, `created_at`) VALUES ('$market','$timing','$panna','$open','$date','$stamp')");
        
        $xvm = query("select * from rate where sn='1'");
        $xv = fetch($xvm);
        
       
        
        
        
        
        $get_games = query("SELECT * FROM `starline_games` where bazar='$market' AND timing_sn='$timing' AND date='$date' AND (number='$panna' OR number='$open')");
        
        while($x = fetch($get_games))
        {
            $sn = $x['sn'];
            $user = $x['user'];
            $amount = $x['amount']*$xv[$x['game']];
            
            $remrk = $x['game']." ".$x['bazar']." Winning";
        
            query("update starline_games set status='1' where sn='$sn'");
        
            query("update users set wallet=wallet+'$amount' where mobile='$user'");
            
            query("INSERT INTO `transactions`(`user`, `amount`, `type`, `remark`, `created_at`) VALUES ('$user','$amount','1','$remrk','$stamp')");
            sendNotiicaton("You have won amount $amount","Congratulations",$user);
        }
        
        query("update starline_games set is_loss='1'");
        
    }
    
    if(isset($_REQUEST['redirect_back'])){
        header("location:".$redirect_back);
    }
}



$market = query("select * from starline_markets where active='1'");

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
                
                   <?php if(isset($error)) { ?>
                        
                            <div class="alert alert-danger" role="alert">
                              <?php echo $error; ?>
                            </div>
                        
                        <?php } ?>
                        
                <div class="row">
                    
              
                    
                    <?php while($mrk = fetch($market)){
                        
                        $mrk_sn = $mrk['sn'];
                        
                        $mrk_name = $mrk['name'];
                        
                        $get_timings = query("select * from starline_timings where market='$mrk_name'");
                        
                        while($xc = fetch($get_timings)){
                            
                            
                        $time_id = $xc['close'];
                    
                        if($mrk['days'] == "" || substr_count($mrk['days'],$day) == 0){
                        
                            if(strtotime($time)<strtotime($xc['open'])){
                                $xc['is_open'] = "1";
                            } else {
                                $xc['is_open'] = "0";
                            }
                            
                            if(strtotime($time)<strtotime($xc['close'])) {
                                $xc['is_close'] = "1";
                            } else {
                                $xc['is_close'] = "0";
                            }
                            
                        } else if(substr_count($xc['days'],$day."(CLOSE)") > 0){
                            $xc['is_open'] = "0";
                            $xc['is_close'] = "0";
                        }
                        
                        
                        if(1 == 1){
                            
                            $available = true;
                    
                    ?>

                    <div class="col-sm-12 col-md-6 col-lg-4 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title"><?php echo $mrk['name'].' ( '.$xc['close'].' )'; ?></h4>
                                
                                
                                <form class="forms-sample" method="post" enctype="multipart/form-data">
                                     
                                     
                                    <input type="hidden" name="market" value="<?php echo $mrk['name']; ?>">
                                    
                                    <input type="hidden" name="timing" value="<?php echo $xc['close']; ?>">
                                    
                                   <div class="row">
                                       <div class="col-sm-8">
                                           <div class="form-group">
                                                <label for="panna">Panna</label>
                                                <input type="text" pattern="(.){3,3}"  maxlength="3" class="form-control" id="panna" name="panna">
                                            </div>
                                       </div>
                                       <div class="col-sm-4">
                                           <div class="form-group">
                                                <label for="open">Open</label>
                                                <input type="text" pattern="(.){1,1}"  maxlength="1"  class="form-control" id="open" name="open">
                                            </div>
                                       </div>
                                   </div>
                                
                                
                                   <!-- <div class="col-sm-4">-->
                                   <!--    <div class="form-group">-->
                                   <!--         <label for="open">Jodi</label>-->
                                   <!--         <input type="text" pattern="(.){2,2}"  maxlength="2"  class="form-control" id="jodi" name="jodi" required>-->
                                   <!--     </div>-->
                                   <!--</div>-->
                                    
                                    <button type="submit" class="btn btn-primary mr-2 mt-4" name="submit" style="width: 100%">Update</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    
                    <?php } } }
                    
                    if(!isset($available)){ ?>
                        
                        <h2 style="text-align: center;
    position: relative;
    width: 100%;">No Results Pending</h2>
                        
                   <?php }
                    
                    ?>

                </div>
            </div>
            <!-- content-wrapper ends -->
            <!-- partial:../../partials/_footer.html -->
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
