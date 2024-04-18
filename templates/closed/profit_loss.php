<?php
include "connection/config.php";
if (!checks("admin"))
{
    redirect("login.php");
}

extract($_REQUEST);


if(!isset($date)){
    $date = date('d/m/Y');
    $date2 = date('d/m/Y');
} 
 $date = str_replace('/', '-', $date);
  $date2 = str_replace('/', '-', $date2);
  $todays_date = date("d-m-Y");
  
$start = strtotime($date.' 00:00:00');
$end = strtotime($date2.' 23:59:59');


for($i = $start; $i < $end; $i = $i+86400){
    
    $datesx[] = date('d/m/Y', $i);
    
 
}
$dates = implode("','",$datesx);

if(!isset($market)) { $market = "delhi"; }


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

<body>
<body class="sidebar-dark" style="font-family: 'Oxygen', sans-serif;">
  <div class="container-fluid page-body-wrapper">
    <?php include "include/header.php"; ?>

   
        <div class="main-panel">
            <div class="content-wrapper">
                
             
             <div class="card">
                 <div class="card-body">
                      <div class="row">
                        
                        <form method="post">
                          <div class="form-group" style="   margin-left: 10px; margin-bottom: 10px !important; margin-right:20px;">
                                    
                                    <label for="type">Market Type</label>
                                        <select class="form-control form-control-lg" name="market" id="type">
                                         
                                          <!--<option value="main" <?php if(isset($market) && $market == "main"){ echo "selected"; } ?>>individual Markets</option>-->
                                          <!--<option value="starline" <?php if(isset($market) && $market == "starline"){ echo "selected"; } ?>>Starline Markets</option>-->
                                          
                                          <option value="delhi" <?php if(isset($market) && $market == "delhi"){ echo "selected"; } ?>>Delhi Markets</option>
                                          <option value="card" <?php if(isset($market) && $market == "card"){ echo "selected"; } ?>>Card</option>
                                        </select>
                                    </div>
                                    
                                    <div class="form-group" style="    margin-bottom: 10px !important; margin-right:20px;">
                                        <label for="exampleInputName1">From Date</label>
                                        <input type="datepicker" value="<?php if(isset($date)){ echo $date; } ?>" id="datepicker" class="form-control" name="date" required>
                                    </div>
                                    
                                    <div class="form-group" style="    margin-bottom: 10px !important; margin-right:20px;">
                                        <label for="exampleInputName1">To Date</label>
                                        <input type="datepicker" value="<?php if(isset($date2)){ echo $date2; } ?>"  id="datepicker2" class="form-control" name="date2" required>
                                    </div>
                                    
                                  <button style="margin-top: 32px;" type="submit" class="btn btn-primary">Get Hisab</button>
                       
                        </form>
                        
                    </div>
                 </div>
             </div>
                
                <div class="card">
                    
                   
                    
                       
                    <div class="card-body" style="margin-top: 25px;">
                        <h4 class="card-title">Market Report</h4>
                        <div class="row">
                            <div class="col-12" id="hisab">
                               
                                <div class="table-responsive">
                                    <table id="example" class="table">
                                            <thead>
                                                <tr>
                                                    <th>Sn</th>
                                                    <th>From Date</th>
                                                    <th>To Date</th>
                                                    <th>Market</th>
                                                    <th>Total Bid Amount</th>
                                                    <th>Total Win Amount</th>
                                                    <th>Profit/Loss</th>
                                                </tr>
                                            </thead>
                                        <tbody>
                                            
                                            <?php
                                            
                                            $all_winning = 0 ;
                                            $all_bet = 0 ;
                                            
                                            if($market == "all_main") { ?>
                                            
                                                <?php
                                                
                                                    $query = fetch(query("select sum(amount) as total_amount, count(*) as total_bid from card_games where date IN ('".$dates."')"));
                                                    
                                                    $xvm = query("select * from card_rate where sn='1'");
                                                    $xv = fetch($xvm);
                                                    
                                                    $winning = 0;
                                                    $get_win = query("select amount, game from games where status='1' AND date IN ('".$dates."')");
                                                    
                                                    while($win = fetch($get_win)){
                                                        $winning += $win['amount']*$xv['single'];
                                                    }
                                                    
                                                    $all_winning = $all_winning+$winning;
                                                    $all_bet = $all_bet+$query['total_amount'];
                                                    ?>
                                                
                                                <tr>
                                                    <td>1</td>
                                                    <td><?php echo $date; ?></td>
                                                    <td><?php echo $date2; ?></td>
                                                    <td>Card Markets</td>
                                                    <td><?php echo $query['total_amount']+0; ?></td>
                                                    <td><?php echo $winning; ?></td>
                                                    <td><?php echo $query['total_amount']-$winning; ?><?php if($query['total_amount']-$winning > 0){ echo "<span style='color:green'> (Profit)</span>"; } else { echo " <span style='color:red'>(Loss)</span>"; } ?></td>
                                                  
                                                </tr>
                                            
                                              
                                            <?php
                                            
                                                $query2 = fetch(query("select sum(amount) as total_amount, count(*) as total_bid from starline_games where date IN ('".$dates."')"));
                                                
                                                $xvm2 = query("select * from rate_star where sn='1'");
                                                $xv2 = fetch($xvm2);
                                                
                                                $winning2 = 0;
                                                $get_win2 = query("select amount, game from starline_games where status='1' AND date IN ('".$dates."')");
                                                
                                                while($win2 = fetch($get_win2)){
                                                    $winning2 += $win2['amount']*$xv2[$win2['game']];
                                                }
                                                
                                                $all_winning = $all_winning+$winning2;
                                                $all_bet = $all_bet+$query2['total_amount'];
                                                
                                                ?>
                                            
                                            <tr>
                                                <td>2</td>
                                                <td><?php echo $date; ?></td>
                                                <td><?php echo $date2; ?></td>
                                                <td>Starline Markets</td>
                                                <td><?php echo $query2['total_amount']+0; ?></td>
                                                <td><?php echo $winning2; ?></td>
                                                <td><?php echo $query2['total_amount']-$winning2; ?><?php if($query2['total_amount']-$winning2 > 0){ echo " <span style='color:green'>(Profit)</span>"; } else { echo "  <span style='color:red'>(Loss)</span>"; } ?></td>
                                              
                                            </tr>
                                            
                                            <?php } else if($market == "card") {  ?>
                                            
                                            
                                            <?php 
                                            
                                            $xc = 1;
                                            
                                            $get_market = query("select * from card_timings");
                                            while($mrr = fetch($get_market)){
                                                
                                                $market_name = $mrr['close'];
                                                $market_name2 = str_replace(" ","_",$market_name);
                                                $market_name3 = str_replace(" ","_",$market_name.' OPEN');
                                                $market_name4 = str_replace(" ","_",$market_name.' CLOSE');
                                                
                                                $query2 = fetch(query("select sum(amount) as total_amount, count(*) as total_bid from card_games where date IN ('".$dates."') AND ( timing='$market_name')"));
                                                
                                                 
                                                
                                                $xvm2 = query("select * from card_rate where sn='1'");
                                                $xv2 = fetch($xvm2);
                                                
                                                $winning2 = 0;
                                                $get_win2 = query("select amount, game from card_games where status='1' AND date IN ('".$dates."') AND ( timing='$market_name')");
                                                
                                                while($win2 = fetch($get_win2)){
                                                    $winning2 += $win2['amount']*$xv2['single'];
                                                }
                                                
                                                $all_winning = $all_winning+$winning2;
                                                $all_bet = $all_bet+$query2['total_amount'];
                                                
                                            ?>
                                            
                                            <tr>
                                                <td><?php echo $xc; ?></td>
                                                <td><?php echo $date; ?></td>
                                                <td><?php echo $date2; ?></td>
                                                <td><?php echo $mrr['close']; ?></td>
                                                <td><?php echo $query2['total_amount']+0; ?></td>
                                                <td><?php echo $winning2; ?></td>
                                                <td><?php echo $query2['total_amount']-$winning2; ?><?php if($query2['total_amount']-$winning2 > 0){ echo "<span style='color:green'> (Profit)</span>"; } else { echo " <span style='color:red'>(Loss)</span>"; } ?></td>
                                            </tr>
                                            
                                            
                                            <?php $xc++; } } 
                                            else if($market == "delhi") {  ?>
                                            
                                            
                                            <?php 
                                            
                                            $xc = 1;
                                            
                                            $get_market = query("select * from gametime_delhi");
                                            while($mrr = fetch($get_market)){
                                                
                                                $market_name = $mrr['market'];
                                                $market_name2 = str_replace(" ","_",$market_name);
                                                $market_name3 = str_replace(" ","_",$market_name.' OPEN');
                                                $market_name4 = str_replace(" ","_",$market_name.' CLOSE');
                                                
                                                $query2 = fetch(query("select sum(amount) as total_amount, count(*) as total_bid from games where date IN ('".$dates."') AND ( bazar='$market_name' OR bazar='$market_name2' OR bazar='$market_name3' OR bazar='$market_name4')"));
                                                
                                                 
                                                
                                                $xvm2 = query("select * from rates where sn='1'");
                                                $xv2 = fetch($xvm2);
                                                
                                                $winning2 = 0;
                                                $get_win2 = query("select amount, game from games where status='1' AND date IN ('".$dates."') AND ( bazar='$market_name' OR bazar='$market_name2' OR bazar='$market_name3' OR bazar='$market_name4')");
                                                
                                                while($win2 = fetch($get_win2)){
                                                    $winning2 += $win2['amount']*$xv2[$win2['game']];
                                                }
                                                
                                                $all_winning = $all_winning+$winning2;
                                                $all_bet = $all_bet+$query2['total_amount'];
                                                
                                            ?>
                                            
                                            <tr>
                                                <td><?php echo $xc; ?></td>
                                                <td><?php echo $date; ?></td>
                                                <td><?php echo $date2; ?></td>
                                                <td><?php echo $mrr['market']; ?></td>
                                                <td><?php echo $query2['total_amount']+0; ?></td>
                                                <td><?php echo $winning2; ?></td>
                                                <td><?php echo $query2['total_amount']-$winning2; ?><?php if($query2['total_amount']-$winning2 > 0){ echo "<span style='color:green'> (Profit)</span>"; } else { echo " <span style='color:red'>(Loss)</span>"; } ?></td>
                                            </tr>
                                            
                                            
                                            <?php $xc++; } } 
                                            
                                            else if($market == "starline") {  ?>
                                            
                                            <?php 
                                            
                                            $xc = 1;
                                            
                                            $get_market_x = query("select * from starline_markets");
                                            while($mrr_x = fetch($get_market_x)){
                                                
                                                $market_name = $mrr_x['name'];
                                            $get_market = query("select * from starline_timings where market='$market_name'");
                                            while($mrr = fetch($get_market)){
                                                
                                                $timing_ = $mrr['close'];
                                                
                                                $query2 = fetch(query("select sum(amount) as total_amount, count(*) as total_bid from starline_games where date IN ('".$dates."') AND bazar='$market_name' AND timing_sn='$timing_'"));
                                                
                                                
                                                $xvm2 = query("select * from rate_star where sn='1'");
                                                $xv2 = fetch($xvm2);
                                                
                                                $winning2 = 0;
                                                $get_win2 = query("select amount, game from starline_games where status='1' AND date IN ('".$dates."') AND bazar='$market_name' AND timing_sn='$timing_'");
                                                
                                                while($win2 = fetch($get_win2)){
                                                    $winning2 += $win2['amount']*$xv2[$win2['game']];
                                                }
                                                
                                                $all_winning = $all_winning+$winning2;
                                                $all_bet = $all_bet+$query2['total_amount'];
                                                
                                            ?>
                                            
                                            <tr>
                                                <td><?php echo $xc; ?></td>
                                                <td><?php echo $date; ?></td>
                                                <td><?php echo $date2; ?></td>
                                                <td><?php echo $market_name.' - '.$timing_; ?></td>
                                                <td><?php echo $query2['total_amount']+0; ?></td>
                                                <td><?php echo $winning2; ?></td>
                                                <td><?php echo $query2['total_amount']-$winning2; ?><?php if($query2['total_amount']-$winning2 > 0){ echo "<span style='color:green'> (Profit)</span>"; } else { echo " <span style='color:red'>(Loss)</span>"; } ?></td>
                                            </tr>
                                            
                                            
                                            <?php $xc++; } } } ?>
                                            
                                            <?php 
                                            
                                                $mainProfit = $all_bet-$all_winning;
                                            
                                            ?>
                                            
                                           <tfoot>
                                                <td>Total</td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td><?php echo $all_bet; ?></td>
                                                <td><?php echo $all_winning; ?></td>
                                                <td><?php echo $mainProfit; ?><?php if($mainProfit > 0){ echo "<span style='color:green'> (Profit)</span>"; } else { echo " <span style='color:red'>(Loss)</span>"; } ?></td>
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
<!-- endinject -->
<!-- Custom js for this page-->
<script src="js/data-table.js"></script>



<script src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.6/dist/loadingoverlay.min.js"></script>
 
<script>
  var buttonCommon = {
        exportOptions: {
            format: {
                body: function ( data, row, column, node ) {
                    // Strip $ from salary column to make it numeric
                    return column === 5 ?
                        data.replace( /[$,]/g, '' ) :
                        data;
                }
            }
        }
    };
 
    $('#example').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            $.extend( true, {}, buttonCommon, {
                extend: 'copyHtml5', footer: true
            } ),
            $.extend( true, {}, buttonCommon, {
                extend: 'excelHtml5', footer: true
            } ),
            $.extend( true, {}, buttonCommon, {
                extend: 'pdfHtml5', footer: true
            } )
        ]
    } );
    
    $('title').html("<?php echo $market.' - '.$date; ?>");
</script>
<!-- End custom js for this page-->
</body>

</html>
