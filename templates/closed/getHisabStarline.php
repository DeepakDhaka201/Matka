<?php
include "connection/config.php";
extract($_REQUEST);
$market = $_REQUEST['market'];
if (!checks("admin"))
{
    redirect("login.php");
}


 $mrk = fetch(query("select * from starline_markets where name='$market'"));
    
$get_timings = query("select * from starline_timings where market='$market' order by str_to_date(close, '%H:%i')");
    
            

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
            
            while($xc = fetch($get_timings)){
            
            $open = $market;
            
            $timing = $xc['close'];
            
            $query = fetch(query("select sum(amount) as total_amount, count(*) as total_bid from starline_games where bazar='$open' AND date='$date' AND timing_sn='$timing'"));
            
            $xvm = query("select * from rates_star where sn='1'");
            $xv = fetch($xvm);
            
            $_winning = 0;
            
            $get_win = query("select amount, game from starline_games where status='1' AND bazar='$open' AND date='$date' AND timing_sn='$timing'");
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
                <td><?php echo $query['total_amount']-$_winning; ?><?php if($query['total_amount']-$_winning > 0){ echo " (Profit)"; } else { echo " (Loss)"; } ?></td>
                <td><?php echo date('h:i A',strtotime($xc['close'])); ?></td>
            </tr>
            
             <?php } ?>
            
            
            <tfoot>
                <td></td>
                <td>Total</td>
                <td><?php echo $bets; ?></td>
                <td><?php echo $bet_amount; ?></td>
                <td><?php echo $winning; ?></td>
                <td><?php echo $profit; ?><?php if($profit > 0){ echo " (Profit)"; } else { echo " (Loss)"; } ?></td>
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