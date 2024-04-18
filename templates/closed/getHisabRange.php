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
            
            
            if(rows(query("select * from gametime_new where market='$market'")) > 0){
                $get = fetch(query("select * from gametime_new where market='$market'"));
                
            } else {
                
                $get = fetch(query("select * from gametime_manual where market='$market'"));
            }
            
                $open = str_replace(" ","_",$market)."_OPEN";
                
            if($market != "all"){
                $cather = "bazar='$open'";
            } else {
                $cather = "bazar like '%_OPEN%'";
            }

            $query = fetch(query("select sum(amount) as total_amount, count(*) as total_bid from games where ".$cather." AND game='single' AND date IN ('".$dates."')"));
            
            $xvm = query("select * from rate where sn='1'");
            $xv = fetch($xvm);
            
            $winning = 0;
            $get_win = query("select amount, game from games where status='1' AND ".$cather." AND date IN ('".$dates."')");
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
                <td>OPEN Single</td>
                <td><?php echo $query['total_bid']; ?></td>
                <td><?php echo $query['total_amount']+0; ?></td>
                <td><?php echo $winning; ?></td>
                <td><?php echo $query['total_amount']-$winning; ?><?php if($query['total_amount']-$winning > 0){ echo "<span style='color:green'> (Profit)</span>"; } else { echo "<span style='color:red'> (Loss)</span>"; } ?></td>
                <td><?php echo date('h:i A',strtotime($get['open'])); ?></td>
            </tr>
            
            <?php
              $open = str_replace(" ","_",$market)."_OPEN";
                
            if($market != "all"){
                $cather = "bazar='$open'";
            } else {
                $cather = "bazar like '%_OPEN%'";
            }

            
            $query = fetch(query("select sum(amount) as total_amount, count(*) as total_bid from games where ".$cather." AND (game='singlepatti' OR game='doublepatti' OR game='triplepatti') AND date IN ('".$dates."')"));
            
            $xvm = query("select * from rate where sn='1'");
            $xv = fetch($xvm);
            
            $winning = 0;
            $get_win = query("select amount, game from games where status='1' AND ".$cather." AND (game='singlepatti' OR game='doublepatti' OR game='triplepatti') AND date IN ('".$dates."')");
            while($win = fetch($get_win)){
                $winning += $win['amount']*$xv[$win['game']];
                
            }
            
            $a_bet += $query['total_bid'];
            $a_amount += $query['total_amount']+0;
            $a_winning += $winning;
            $a_profit += $query['total_amount']-$winning;
            
            ?>
            
            
            
            <tr>
                <td>2</td>
                <td>OPEN Patti</td>
                <td><?php echo $query['total_bid']; ?></td>
                <td><?php echo $query['total_amount']+0; ?></td>
                <td><?php echo $winning; ?></td>
                <td><?php echo $query['total_amount']-$winning; ?><?php if($query['total_amount']-$winning > 0){ echo "<span style='color:green'> (Profit)</span>"; } else { echo "<span style='color:red'> (Loss)</span>"; } ?></td>
                <td><?php echo date('h:i A',strtotime($get['open'])); ?></td>
            </tr>
            
             <?php
            
            $open = str_replace(" ","_",$market)."_CLOSE";
                
            if($market != "all"){
                $cather = "bazar='$open'";
            } else {
                $cather = "bazar like '%_CLOSE%'";
            }

            
            $query = fetch(query("select sum(amount) as total_amount, count(*) as total_bid from games where ".$cather."  AND game='single' AND date IN ('".$dates."')"));
            
            $xvm = query("select * from rate where sn='1'");
            $xv = fetch($xvm);
            
            $winning = 0;
            $get_win = query("select amount, game from games where status='1' AND ".$cather."  AND game='single' AND date IN ('".$dates."')");
            while($win = fetch($get_win)){
                $winning += $win['amount']*$xv[$win['game']];
                
            }
            
            $b_bet += $query['total_bid'];
            $b_amount += $query['total_amount']+0;
            $b_winning += $winning;
            $b_profit += $query['total_amount']-$winning;
            ?>
            
            
            
            <tr>
                <td>3</td>
                <td>CLOSE Single</td>
                <td><?php echo $query['total_bid']; ?></td>
                <td><?php echo $query['total_amount']+0; ?></td>
                <td><?php echo $winning; ?></td>
                <td><?php echo $query['total_amount']-$winning; ?><?php if($query['total_amount']-$winning > 0){ echo "<span style='color:green'> (Profit)</span>"; } else { echo "<span style='color:red'> (Loss)</span>"; } ?></td>
                <td><?php echo date('h:i A',strtotime($get['close'])); ?></td>
            </tr>
            
             <?php
            
            $open = str_replace(" ","_",$market)."_CLOSE";
                
            if($market != "all"){
                $cather = "bazar='$open'";
            } else {
                $cather = "bazar like '%_CLOSE%'";
            }

            
            $query = fetch(query("select sum(amount) as total_amount, count(*) as total_bid from games where ".$cather." AND (game='singlepatti' OR game='doublepatti' OR game='triplepatti')  AND date IN ('".$dates."')"));
            
            $xvm = query("select * from rate where sn='1'");
            $xv = fetch($xvm);
            
            $winning = 0;
            $get_win = query("select amount, game from games where status='1' AND ".$cather." AND (game='singlepatti' OR game='doublepatti' OR game='triplepatti') AND date IN ('".$dates."')");
            while($win = fetch($get_win)){
                $winning += $win['amount']*$xv[$win['game']];
                
            }
            
            $b_bet += $query['total_bid'];
            $b_amount += $query['total_amount']+0;
            $b_winning += $winning;
            $b_profit += $query['total_amount']-$winning;
            ?>
            
            
            
            <tr>
                <td>4</td>
                <td>CLOSE Patti</td>
                <td><?php echo $query['total_bid']; ?></td>
                <td><?php echo $query['total_amount']+0; ?></td>
                <td><?php echo $winning; ?></td>
                <td><?php echo $query['total_amount']-$winning; ?><?php if($query['total_amount']-$winning > 0){ echo "<span style='color:green'> (Profit)</span>"; } else { echo "<span style='color:red'> (Loss)</span>"; } ?></td>
                <td><?php echo date('h:i A',strtotime($get['close'])); ?></td>
            </tr>
            
             <?php
            
            $open = str_replace(" ","_",$market);
                
            if($market != "all"){
                $cather = "bazar='$open'";
            } else {
                $cather = "1=1";
            }

            
            $query = fetch(query("select sum(amount) as total_amount, count(*) as total_bid from games where ".$cather." AND game='jodi' AND date IN ('".$dates."')"));
            
            
            $xvm = query("select * from rate where sn='1'");
            $xv = fetch($xvm);
            $winning = 0;
            $get_win = query("select amount, game from games where status='1' AND ".$cather." AND game='jodi' AND date IN ('".$dates."')");
            while($win = fetch($get_win)){
                $winning += $win['amount']*$xv[$win['game']];
                
            }
            
            $c_bet += $query['total_bid'];
            $c_amount += $query['total_amount']+0;
            $c_winning += $winning;
            $c_profit += $query['total_amount']-$winning;
            ?>
            
            
            
            <tr>
                <td>5</td>
                <td>JODI</td>
                <td><?php echo $query['total_bid']; ?></td>
                <td><?php echo $query['total_amount']+0; ?></td>
                <td><?php echo $winning; ?></td>
                <td><?php echo $query['total_amount']-$winning; ?><?php if($query['total_amount']-$winning > 0){ echo "<span style='color:green'> (Profit)</span>"; } else { echo "<span style='color:red'> (Loss)</span>"; } ?></td>
                <td><?php echo date('h:i A',strtotime($get['open'])); ?></td>
            </tr>
            
              <?php
            
            $open = str_replace(" ","_",$market);
                
            if($market != "all"){
                $cather = "bazar='$open'";
            } else {
                $cather = "1=1";
            }

            
            $query = fetch(query("select sum(amount) as total_amount, count(*) as total_bid from games where ".$cather." AND game='halfsangam' AND date IN ('".$dates."')"));
            
            $xvm = query("select * from rate where sn='1'");
            $xv = fetch($xvm);
            
            $winning = 0;
            $get_win = query("select amount, game from games where status='1' AND ".$cather." AND game='halfsangam' AND date IN ('".$dates."')");
            while($win = fetch($get_win)){
                $winning += $win['amount']*$xv[$win['game']];
                
            }
            
            $c_bet += $query['total_bid'];
            $c_amount += $query['total_amount']+0;
            $c_winning += $winning;
            $c_profit += $query['total_amount']-$winning;
            ?>
            
            
            
            <tr>
                <td>6</td>
                <td>Half Sangam</td>
                <td><?php echo $query['total_bid']; ?></td>
                <td><?php echo $query['total_amount']+0; ?></td>
                <td><?php echo $winning; ?></td>
                <td><?php echo $query['total_amount']-$winning; ?><?php if($query['total_amount']-$winning > 0){ echo "<span style='color:green'> (Profit)</span>"; } else { echo "<span style='color:red'> (Loss)</span>"; } ?></td>
                <td><?php echo date('h:i A',strtotime($get['open'])); ?></td>
            </tr>
            
              <?php
            
            $open = str_replace(" ","_",$market);
                
            if($market != "all"){
                $cather = "bazar='$open'";
            } else {
                $cather = "1=1";
            }

            
            $query = fetch(query("select sum(amount) as total_amount, count(*) as total_bid from games where ".$cather." AND game='fullsangam' AND date IN ('".$dates."')"));
            
            $xvm = query("select * from rate where sn='1'");
            $xv = fetch($xvm);
            
            $winning = 0;
            $get_win = query("select amount, game from games where status='1' AND ".$cather." AND AND game='fullsangam' date IN ('".$dates."')");
            while($win = fetch($get_win)){
                $winning += $win['amount']*$xv[$win['game']];
                
            }
            
            $c_bet += $query['total_bid'];
            $c_amount += $query['total_amount']+0;
            $c_winning += $winning;
            $c_profit += $query['total_amount']-$winning;
            ?>
            
            
            
            <tr>
                <td>7</td>
                <td>Full Sangam</td>
                <td><?php echo $query['total_bid']; ?></td>
                <td><?php echo $query['total_amount']+0; ?></td>
                <td><?php echo $winning; ?></td>
                <td><?php echo $query['total_amount']-$winning; ?><?php if($query['total_amount']-$winning > 0){ echo "<span style='color:green'> (Profit)</span>"; } else { echo "<span style='color:red'> (Loss)</span>"; } ?></td>
                <td><?php echo date('h:i A',strtotime($get['open'])); ?></td>
            </tr>
            
             
            <tfoot>
                <td></td>
                <td>Total</td>
                <td><?php echo $a_bet+$b_bet+$c_bet; ?></td>
                <td><?php echo $a_amount+$b_amount+$c_amount; ?></td>
                <td><?php echo $a_winning+$b_winning+$c_winning; ?></td>
                <td><?php echo $a_profit+$b_profit+$c_profit; ?><?php if($a_profit+$b_profit+$c_profit > 0){ echo "<span style='color:green'> (Profit)</span>"; } else { echo "<span style='color:red'> (Loss)</span>"; } ?></td>
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