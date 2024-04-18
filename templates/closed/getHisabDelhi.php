<?php
include "connection/config.php";
extract($_REQUEST);
$market = $_REQUEST['market'];
if (!checks("admin"))
{
    redirect("login.php");
}


if($market != "all"){ ?>

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
            
            
            
                
                $get = fetch(query("select * from gametime_delhi where market='$market'"));
            
            
            
            $open = str_replace(" ","_",$market)."_OPEN";
            
            $query = fetch(query("select sum(amount) as total_amount, count(*) as total_bid from games where bazar='$open' AND game='single' AND date='$date'"));
            
            $xvm = query("select * from rate where sn='1'");
            $xv = fetch($xvm);
            
            $winning = 0;
            $get_win = query("select amount, game from games where status='1' AND bazar='$open' AND date='$date'");
            while($win = fetch($get_win)){
                $winning += $win['amount']*$xv[$win['game']];
                
            }
            
            $a_bet += $query['total_bid'];
            $a_amount += $query['total_amount']+0;
            $a_winning += $winning;
            $a_profit += $query['total_amount']-$winning;
            
            ?>
            
            
            
            
            
            <?php
              $open = str_replace(" ","_",$market)."_OPEN";
            
            $query = fetch(query("select sum(amount) as total_amount, count(*) as total_bid from games where bazar='$open' AND (game='singlepatti' OR game='doublepatti' OR game='triplepatti') AND date='$date'"));
            
            $xvm = query("select * from rate where sn='1'");
            $xv = fetch($xvm);
            
            $winning = 0;
            $get_win = query("select amount, game from games where status='1' AND bazar='$open' AND (game='singlepatti' OR game='doublepatti' OR game='triplepatti') AND date='$date'");
            while($win = fetch($get_win)){
                $winning += $win['amount']*$xv[$win['game']];
                
            }
            
            $a_bet += $query['total_bid'];
            $a_amount += $query['total_amount']+0;
            $a_winning += $winning;
            $a_profit += $query['total_amount']-$winning;
            
            ?>
            
            
            
            <tr>
                <td>1</td>
                <td>HARF OPEN</td>
                <td><?php echo $query['total_bid']; ?></td>
                <td><?php echo $query['total_amount']+0; ?></td>
                <td><?php echo $winning; ?></td>
                <td><?php echo $query['total_amount']-$winning; ?><?php if($query['total_amount']-$winning > 0){ echo " (Profit)"; } else { echo " (Loss)"; } ?></td>
                <td><?php echo date('h:i A',strtotime($get['open'])); ?></td>
            </tr>
            
             <?php
            
            $open = str_replace(" ","_",$market)."_CLOSE";
            
            $query = fetch(query("select sum(amount) as total_amount, count(*) as total_bid from games where bazar='$open'  AND game='single' AND date='$date'"));
            
            $xvm = query("select * from rate where sn='1'");
            $xv = fetch($xvm);
            
            $winning = 0;
            $get_win = query("select amount, game from games where status='1' AND bazar='$open'  AND game='single' AND date='$date'");
            while($win = fetch($get_win)){
                $winning += $win['amount']*$xv[$win['game']];
                
            }
            
            $b_bet += $query['total_bid'];
            $b_amount += $query['total_amount']+0;
            $b_winning += $winning;
            $b_profit += $query['total_amount']-$winning;
            ?>
            
            
            
            
            
             <?php
            
            $open = str_replace(" ","_",$market)."_CLOSE";
            
            $query = fetch(query("select sum(amount) as total_amount, count(*) as total_bid from games where bazar='$open' AND (game='singlepatti' OR game='doublepatti' OR game='triplepatti')  AND date='$date'"));
            
            $xvm = query("select * from rate where sn='1'");
            $xv = fetch($xvm);
            
            $winning = 0;
            $get_win = query("select amount, game from games where status='1' AND bazar='$open' AND (game='singlepatti' OR game='doublepatti' OR game='triplepatti') AND date='$date'");
            while($win = fetch($get_win)){
                $winning += $win['amount']*$xv[$win['game']];
                
            }
            
            $b_bet += $query['total_bid'];
            $b_amount += $query['total_amount']+0;
            $b_winning += $winning;
            $b_profit += $query['total_amount']-$winning;
            ?>
            
            
            
            <tr>
                <td>2</td>
                <td>HARF CLOSE</td>
                <td><?php echo $query['total_bid']; ?></td>
                <td><?php echo $query['total_amount']+0; ?></td>
                <td><?php echo $winning; ?></td>
                <td><?php echo $query['total_amount']-$winning; ?><?php if($query['total_amount']-$winning > 0){ echo " (Profit)"; } else { echo " (Loss)"; } ?></td>
                <td><?php echo date('h:i A',strtotime($get['close'])); ?></td>
            </tr>
            
             <?php
            
            $open = str_replace(" ","_",$market);
            
            $query = fetch(query("select sum(amount) as total_amount, count(*) as total_bid from games where bazar='$open' AND game='jodi' AND date='$date'"));
            
            $xvm = query("select * from rate where sn='1'");
            $xv = fetch($xvm);
            
            $winning = 0;
            $get_win = query("select amount, game from games where status='1' AND bazar='$open' AND game='jodi' AND date='$date'");
            while($win = fetch($get_win)){
                $winning += $win['amount']*$xv[$win['game']];
                
            }
            
            $c_bet += $query['total_bid'];
            $c_amount += $query['total_amount']+0;
            $c_winning += $winning;
            $c_profit += $query['total_amount']-$winning;
            ?>
            
            
            
            <tr>
                <td>3</td>
                <td>JODI</td>
                <td><?php echo $query['total_bid']; ?></td>
                <td><?php echo $query['total_amount']+0; ?></td>
                <td><?php echo $winning; ?></td>
                <td><?php echo $query['total_amount']-$winning; ?><?php if($query['total_amount']-$winning > 0){ echo " (Profit)"; } else { echo " (Loss)"; } ?></td>
                <td><?php echo date('h:i A',strtotime($get['open'])); ?></td>
            </tr>
            
              <?php
            
            $open = str_replace(" ","_",$market);
            
            $query = fetch(query("select sum(amount) as total_amount, count(*) as total_bid from games where bazar='$open' AND game='halfsangam' AND date='$date'"));
            
            $xvm = query("select * from rate where sn='1'");
            $xv = fetch($xvm);
            
            $winning = 0;
            $get_win = query("select amount, game from games where status='1' AND bazar='$open' AND game='halfsangam' AND date='$date'");
            while($win = fetch($get_win)){
                $winning += $win['amount']*$xv[$win['game']];
                
            }
            
            $c_bet += $query['total_bid'];
            $c_amount += $query['total_amount']+0;
            $c_winning += $winning;
            $c_profit += $query['total_amount']-$winning;
            ?>
            
            
            
            
            
              <?php
            
            $open = str_replace(" ","_",$market);
            
            $query = fetch(query("select sum(amount) as total_amount, count(*) as total_bid from games where bazar='$open' AND game='fullsangam' AND date='$date'"));
            
            $xvm = query("select * from rate where sn='1'");
            $xv = fetch($xvm);
            
            $winning = 0;
            $get_win = query("select amount, game from games where status='1' AND bazar='$open' AND AND game='fullsangam' date='$date'");
            while($win = fetch($get_win)){
                $winning += $win['amount']*$xv[$win['game']];
                
            }
            
            $c_bet += $query['total_bid'];
            $c_amount += $query['total_amount']+0;
            $c_winning += $winning;
            $c_profit += $query['total_amount']-$winning;
            ?>
            
            
            
            
            
             
            <tfoot>
                <td></td>
                <td>Total</td>
                <td><?php echo $a_bet+$b_bet+$c_bet; ?></td>
                <td><?php echo $a_amount+$b_amount+$c_amount; ?></td>
                <td><?php echo $a_winning+$b_winning+$c_winning; ?></td>
                <td><?php echo $a_profit+$b_profit+$c_profit; ?><?php if($a_profit+$b_profit+$c_profit > 0){ echo " (Profit)"; } else { echo " (Loss)"; } ?></td>
                <td></td>
            </tfoot>
            
            

        </tbody>
    </table>
</div>

<?php } else  { ?>



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
            
            
         
            
            $open = "_OPEN";
            
            $query = fetch(query("select sum(amount) as total_amount, count(*) as total_bid from games where bazar like '%$open%' AND game='single' AND date='$date'"));
            
            $xvm = query("select * from rate where sn='1'");
            $xv = fetch($xvm);
            
            $winning = 0;
            $get_win = query("select amount, game from games where status='1' AND bazar like '%$open%' AND date='$date'");
            while($win = fetch($get_win)){
                $winning += $win['amount']*$xv[$win['game']];
                
            }
            
            $a_bet += $query['total_bid'];
            $a_amount += $query['total_amount']+0;
            $a_winning += $winning;
            $a_profit += $query['total_amount']-$winning;
            
            ?>
            
            
            
            
            
            <?php
              $open = "_OPEN";
            
            $query = fetch(query("select sum(amount) as total_amount, count(*) as total_bid from games where bazar like '%$open%' AND (game='singlepatti' OR game='doublepatti' OR game='triplepatti') AND date='$date'"));
            
            $xvm = query("select * from rate where sn='1'");
            $xv = fetch($xvm);
            
            $winning = 0;
            $get_win = query("select amount, game from games where status='1' AND bazar like '%$open%' AND (game='singlepatti' OR game='doublepatti' OR game='triplepatti') AND date='$date'");
            while($win = fetch($get_win)){
                $winning += $win['amount']*$xv[$win['game']];
                
            }
            
            $a_bet += $query['total_bid'];
            $a_amount += $query['total_amount']+0;
            $a_winning += $winning;
            $a_profit += $query['total_amount']-$winning;
            
            ?>
            
            
            
            <tr>
                <td>1</td>
                <td>HARF OPEN</td>
                <td><?php echo $query['total_bid']; ?></td>
                <td><?php echo $query['total_amount']+0; ?></td>
                <td><?php echo $winning; ?></td>
                <td><?php echo $query['total_amount']-$winning; ?><?php if($query['total_amount']-$winning > 0){ echo " (Profit)"; } else { echo " (Loss)"; } ?></td>
                <td><?php echo date('h:i A',strtotime($get['open'])); ?></td>
            </tr>
            
             <?php
            
            $open = "_CLOSE";
            
            $query = fetch(query("select sum(amount) as total_amount, count(*) as total_bid from games where bazar like '%$open%'  AND game='single' AND date='$date'"));
            
            $xvm = query("select * from rate where sn='1'");
            $xv = fetch($xvm);
            
            $winning = 0;
            $get_win = query("select amount, game from games where status='1' AND bazar like '%$open%'  AND game='single' AND date='$date'");
            while($win = fetch($get_win)){
                $winning += $win['amount']*$xv[$win['game']];
                
            }
            
            $b_bet += $query['total_bid'];
            $b_amount += $query['total_amount']+0;
            $b_winning += $winning;
            $b_profit += $query['total_amount']-$winning;
            ?>
            
            
            
            
            
             <?php
            
            $open = "_CLOSE";
            
            $query = fetch(query("select sum(amount) as total_amount, count(*) as total_bid from games where bazar like '%$open%' AND (game='singlepatti' OR game='doublepatti' OR game='triplepatti')  AND date='$date'"));
            
            $xvm = query("select * from rate where sn='1'");
            $xv = fetch($xvm);
            
            $winning = 0;
            $get_win = query("select amount, game from games where status='1' AND bazar like '%$open%' AND (game='singlepatti' OR game='doublepatti' OR game='triplepatti') AND date='$date'");
            while($win = fetch($get_win)){
                $winning += $win['amount']*$xv[$win['game']];
                
            }
            
            $b_bet += $query['total_bid'];
            $b_amount += $query['total_amount']+0;
            $b_winning += $winning;
            $b_profit += $query['total_amount']-$winning;
            ?>
            
            
            
            <tr>
                <td>2</td>
                <td>HARF CLOSE</td>
                <td><?php echo $query['total_bid']; ?></td>
                <td><?php echo $query['total_amount']+0; ?></td>
                <td><?php echo $winning; ?></td>
                <td><?php echo $query['total_amount']-$winning; ?><?php if($query['total_amount']-$winning > 0){ echo " (Profit)"; } else { echo " (Loss)"; } ?></td>
                <td><?php echo date('h:i A',strtotime($get['close'])); ?></td>
            </tr>
            
             <?php
            
            $query = fetch(query("select sum(amount) as total_amount, count(*) as total_bid from games where game='jodi' AND date='$date'"));
            
            $xvm = query("select * from rate where sn='1'");
            $xv = fetch($xvm);
            
            $winning = 0;
            $get_win = query("select amount, game from games where status='1' AND game='jodi' AND date='$date'");
            while($win = fetch($get_win)){
                $winning += $win['amount']*$xv[$win['game']];
                
            }
            
            $c_bet += $query['total_bid'];
            $c_amount += $query['total_amount']+0;
            $c_winning += $winning;
            $c_profit += $query['total_amount']-$winning;
            ?>
            
            
            
            <tr>
                <td>3</td>
                <td>JODI</td>
                <td><?php echo $query['total_bid']; ?></td>
                <td><?php echo $query['total_amount']+0; ?></td>
                <td><?php echo $winning; ?></td>
                <td><?php echo $query['total_amount']-$winning; ?><?php if($query['total_amount']-$winning > 0){ echo " (Profit)"; } else { echo " (Loss)"; } ?></td>
                <td><?php echo date('h:i A',strtotime($get['open'])); ?></td>
            </tr>
            
              <?php
            
            
            $query = fetch(query("select sum(amount) as total_amount, count(*) as total_bid from games where game='halfsangam' AND date='$date'"));
            
            $xvm = query("select * from rate where sn='1'");
            $xv = fetch($xvm);
            
            $winning = 0;
            $get_win = query("select amount, game from games where status='1' AND game='halfsangam' AND date='$date'");
            while($win = fetch($get_win)){
                $winning += $win['amount']*$xv[$win['game']];
                
            }
            
            $c_bet += $query['total_bid'];
            $c_amount += $query['total_amount']+0;
            $c_winning += $winning;
            $c_profit += $query['total_amount']-$winning;
            ?>
            
            
            
            
            
              <?php
            
            $query = fetch(query("select sum(amount) as total_amount, count(*) as total_bid from games where game='fullsangam' AND date='$date'"));
            
            $xvm = query("select * from rate where sn='1'");
            $xv = fetch($xvm);
            
            $winning = 0;
            $get_win = query("select amount, game from games where status='1' AND game='fullsangam' date='$date'");
            while($win = fetch($get_win)){
                $winning += $win['amount']*$xv[$win['game']];
                
            }
            
            $c_bet += $query['total_bid'];
            $c_amount += $query['total_amount']+0;
            $c_winning += $winning;
            $c_profit += $query['total_amount']-$winning;
            ?>
            
            
            
           
            
             
            <tfoot>
                <td></td>
                <td>Total</td>
                <td><?php echo $a_bet+$b_bet+$c_bet; ?></td>
                <td><?php echo $a_amount+$b_amount+$c_amount; ?></td>
                <td><?php echo $a_winning+$b_winning+$c_winning; ?></td>
                <td><?php echo $a_profit+$b_profit+$c_profit; ?><?php if($a_profit+$b_profit+$c_profit > 0){ echo " (Profit)"; } else { echo " (Loss)"; } ?></td>
                <td></td>
            </tfoot>
            
            

        </tbody>
    </table>
</div>


<?php } ?>

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