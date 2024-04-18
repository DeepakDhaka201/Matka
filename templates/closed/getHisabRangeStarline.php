<?php
include "connection/config.php";
extract($_REQUEST);
$market = $_REQUEST['market'];
if (!checks("admin"))
{
    redirect("login.php");
}

  $date = str_replace('/', '-', $date);
  $date2 = str_replace('/', '-', $date2);
  $todays_date = date("d-m-Y");
  
$start = strtotime($date);
$end = strtotime($date2);

//$days_between = ceil(abs($end - $start) / 86400);

for($i = $start; $i < $end; $i = $i+86400){
    
    $datesx[] = date('d/m/Y', $i);
    
 
}
$dates = implode("','",$datesx);

 $mrk = fetch(query("select * from starline_markets where name='$market'"));
    if($market != "all"){
$get_timings = query("select * from starline_timings where market='$market' order by str_to_date(close, '%H:%i')");
    } else {
        
$get_timings = query("select * from starline_timings order by str_to_date(close, '%H:%i')");
    }
            

?>

<div class="table-responsive">
    <table id="example" class="table">
            <thead>
                <tr>
                    <th>Sn</th>
                    <th>Name</th>
                    <th>Total Bid</th>
                    <th>Total Bid Amount</th>
                    <th>Total Win Amount</th>
                    <th>My Profit Loss</th>
                    <th>Timing</th>
                </tr>
            </thead>
        <tbody>
            
            <?php
            
            $i = 0;
            
            
               $winning = 0;
            $bets = 0;
            $bet_amount = 0;
            $profit = 0;
            $_winning = 0;
            if(isset($query)){
                unset($query);
            }
            if(isset($get_win)){
                unset($get_win);
            }
            
            
            while($xc = fetch($get_timings)){
             
            $open = $market;
            
            $timing = $xc['close'];
            if($market != "all"){
            $query = fetch(query("select sum(amount) as total_amount, count(*) as total_bid from starline_games where bazar='$open'  AND timing_sn='$timing' AND date IN ('".$dates."')"));
            } else {
              $query = fetch(query("select sum(amount) as total_amount, count(*) as total_bid from starline_games where date IN ('".$dates."') AND bazar='".$xc['market']."'  AND timing_sn='".$xc['close']."'"));  
            }
            
            $xvm = query("select * from rate_star where sn='1'");
            $xv = fetch($xvm);
            
            $_winning = 0;
            if($market != "all"){
            $get_win = query("select amount, game from starline_games where status='1' AND bazar='$open' AND date IN ('".$dates."')  AND timing_sn='$timing' AND timing_sn='$timing'");
            } else {
               $get_win = query("select amount, game from starline_games where status='1' AND date IN ('".$dates."') AND bazar='".$xc['market']."' AND timing_sn='".$xc['close']."'"); 
               
           //    echo "select amount, game from starline_games where status='1' AND date IN ('".$dates."') AND bazar='".$xc['market']."'  AND timing_sn='".$xc['close']."'";
             //  echo "<br>";
            }
            while($win = fetch($get_win)){
                $_winning += $win['amount']*$xv[$win['game']];
                
            }
            
            $bets += $query['total_bid'];
            $bet_amount += $query['total_amount']+0;
            $winning += $_winning;
            $profit += $query['total_amount']-$_winning;
            
            ?>
            
             
            <tr>
                <td><?php echo $i; $i++; ?></td>
                <td><?php echo $xc['name']; ?></td>
                <td><?php echo $query['total_bid']; ?></td>
                <td><?php echo $query['total_amount']+0; ?></td>
                <td><?php echo $_winning; ?></td>
                <td><?php echo $query['total_amount']-$_winning; ?><?php if($query['total_amount']-$_winning > 0){ echo "<span style='color:green'> (Profit)</span>"; } else { echo "<span style='color:red'> (Loss)</span>"; } ?></td>
                <td><?php echo date('h:i A',strtotime($xc['close'])); ?></td>
            </tr>
            
             <?php } ?>
            
            
            <tfoot>
                <td></td>
                <td>Total</td>
                <td><?php echo $bets; ?></td>
                <td><?php echo $bet_amount; ?></td>
                <td><?php echo $winning; ?></td>
                <td><?php echo $profit; ?><?php if($profit > 0){ echo "<span style='color:green'> (Profit)</span>"; } else { echo "<span style='color:red'> (Loss)</span>"; } ?></td>
                <td></td>
            </tfoot>
            
            

        </tbody>
    </table>
</div>

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