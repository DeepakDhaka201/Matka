<?php
include "connection/config.php";
if (!checks("admin"))
{
    redirect("login.php");
}

if(isset($_REQUEST['from'])){
    $fromDate = $_REQUEST['from'];
    $toDate = $_REQUEST['to'];
    
    $From_explode = explode('/',$fromDate);
    $to_explode = explode('/',$toDate);
    
    $start_time = mktime(0, 0, 0, $From_explode[1], $From_explode[0], $From_explode[2]);
    $end_time = mktime(23, 59, 59, $to_explode[1], $to_explode[0], $to_explode[2]);
    
} else {
    
     $start_time = mktime(0, 0, 0, date("m"), date("d"), date("Y"));
    $end_time = mktime(23, 59, 59, date("m"), date("d"), date("Y"));
    $fromDate = date('d/m/Y');
     $toDate = date('d/m/Y');
}



$blog = query("select * from transactions where ( remark like '%Deposit%' OR remark like '%razorpay%') AND created_at > $start_time AND created_at < $end_time  AND wallet_type='1' order by created_at desc");

$blog_er = fetch(query("select sum(amount) as total from transactions where remark like '%Deposit%' AND created_at > $start_time AND created_at < $end_time AND type='1' AND wallet_type='1'"));

$blog_err = fetch(query("select sum(amount) as total from transactions where remark like '%Withdraw%' AND created_at > $start_time AND created_at < $end_time  AND wallet_type!='3'"));

$query="SELECT sn, SUM(amount) as amount, DATE(FROM_UNIXTIME(created_at)) as ctime,created_at FROM transactions where DATE(FROM_UNIXTIME(created_at)) BETWEEN '".date('Y-m-d ',$start_time)."' AND '".date('Y-m-d ',$end_time)."' group by DATE(FROM_UNIXTIME(created_at)) order by created_at desc";
$trans = query($query);

 $calcu = $blog_er['total']-$blog_err['total'];


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
                                        </div>
                                        
                                           
                                        <div class="form-group" style="    margin-bottom: 10px !important; margin-right:20px;">
                                            <label for="exampleInputName1">To Date</label>
                                            <input type="datepicker" id="datepicker2" class="form-control" name="to" required>
                                        </div>
                                         
                                        <button style="margin-top: 32px;" class="btn btn-primary">Filter</button>
                                   </form>
                       
                        
                    </div>
                 </div>
             </div>
             
                <div class="card">
                    <div class="card-body">
                       
                                
                                 <h4 class="card-title" style="margin-top:20px;">Deposit history</h4>
                                 
                                 
                                 
                        <div class="row">
                            <div class="col-12">
                                
                                  
                                    
                               
                                
                                <div class="table-responsive">
                                    <table id="order-listing" class="table">
                                            <thead>
                                                <tr>
                                                    <th>Sn</th>
                                                    <th>Date</th>
                                                    
                                                    <th>Deposit</th>
                                                    <th>Withdrawal</th>
                                                    <th>Available</th>
                                                    
                                                </tr>
                                            </thead>
                                        <tbody>

                                            <?php
                                            $total = 0;
                                            
                                            $i = 1; 
                                               while ($bld = fetch($trans)) {
                                        
                                        $d_amount = fetch(query("select sum(amount) as total from transactions where ( remark like '%Deposit%' OR remark like '%razorpay%') AND DATE(FROM_UNIXTIME(created_at)) =  '".date('Y-m-d ',$bld["created_at"])."'"));

$w_amount = fetch(query("select sum(amount) as total from withdraw_requests where status='1' AND DATE(FROM_UNIXTIME(created_at)) =  '".date('Y-m-d ',$bld["created_at"])."'"));
                                           
                                            $calcu = $d_amount['total']-$w_amount['total'];

                                            $dtotal += $d_amount['total'];
                                            $wtotal += $w_amount['total'];
                                            $atotal = $dtotal - $wtotal;
                                            
                                            ?>
                                            <tr>
                                                <td><?php echo $i;
                                              
                                                ?></td>
                                                
                                                <td><?php echo out(date('d/m/y ',$bld['created_at'])); ?></td>
                                                <td><?php echo out($d_amount['total']+0); ?></td>
                                                <td><?php echo out($w_amount['total']+0); ?></td>
                                                <td><?php if($calcu > 0){ echo " <span style='color:green'>+$calcu</span>"; } else { echo "  <span style='color:red'>$calcu</span>"; } ?></td>
                                                
                                                
                                               
                                               
                                            </tr>
                                            <?php $i++; } ?>
                                            
                                            
                                            <tfoot>
                                                <td>Total</td>
                                                <td></td>

                                                
                                                <td><?php echo $dtotal; ?></td>
                                                <td><?php echo $wtotal; ?></td>
                                                <td><?php echo $atotal; ?><?php if($atotal > 0){ echo "<span style='color:green'> (Profit)</span>"; } else { echo " <span style='color:red'>(Loss)</span>"; } ?></td>
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
var date = new Date();
    var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());

$('#datepicker').datepicker({
    format: 'dd/mm/yyyy',
    endDate: '0d'
});
$('#datepicker2').datepicker({
    format: 'dd/mm/yyyy',
    endDate: '0d'
});
 $('#datepicker').datepicker('setDate', today);
  $('#datepicker2').datepicker('setDate', today);
</script>


<!-- End custom js for this page-->
</body>

</html>
