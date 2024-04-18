<?php
include "connection/config.php";
extract($_REQUEST);
$market = $_REQUEST['market'];
$game = $_REQUEST['game'];
$digit = $_REQUEST['digit'];


if (!checks("admin"))
{
    redirect("login.php");
}


$fromDate = $_REQUEST['date'];
    $toDate = $_REQUEST['date2'];
    
    $From_explode = explode('/',$fromDate);
    $to_explode = explode('/',$toDate);
    
    $start_time = mktime(0, 0, 0, $From_explode[1], $From_explode[0], $From_explode[2]);
    $end_time = mktime(23, 59, 59, $to_explode[1], $to_explode[0], $to_explode[2]);
//   $date = str_replace('/', '-', $date);
//   $date2 = str_replace('/', '-', $date2);
//   $todays_date = date("d-m-Y");
  
// $start = strtotime($date);
// $end = strtotime($date2);

// //$days_between = ceil(abs($end - $start) / 86400);

// for($i = $start; $i < $end; $i = $i+86400){
    
//     $datesx[] = date('d/m/Y', $i);
    
 
// }
// $dates = implode("','",$datesx);


?>

<div class="table-responsive">
    <table id="example" class="table">
            <thead>
                <tr>
                    <th>Sn</th>
                    <th>Market</th>
                    <th>Game</th>
                    <th>Digit</th>
                    <th>Bid Amount</th>
                    <th>Win Amount</th>
                    <th>Profit/Loss</th>
                    
                </tr>
            </thead>
        <tbody>
            
            <?php
            
            
           
                
            if($market != "all"){
                
                if($game != "all"){
                  
                    $j = fetch(query("select sum(amount) as total_amount, count(*) as total_bid from card_games where timing='$market' AND game='$game' AND number='J' AND created_at > $start_time AND created_at < $end_time"));
                    $q = fetch(query("select sum(amount) as total_amount, count(*) as total_bid from card_games where timing='$market' AND game='$game' AND number='Q' AND created_at > $start_time AND created_at < $end_time"));
                    $k = fetch(query("select sum(amount) as total_amount, count(*) as total_bid from card_games where timing='$market' AND game='$game' AND number='K' AND created_at > $start_time AND created_at < $end_time"));
                
                }else{
                    
                    $j  = fetch(query("select sum(amount) as total_amount, count(*) as total_bid from card_games where timing='$market' AND number='J' AND created_at > $start_time AND created_at < $end_time"));
                    $q  = fetch(query("select sum(amount) as total_amount, count(*) as total_bid from card_games where timing='$market' AND number='Q' AND created_at > $start_time AND created_at < $end_time"));
                    $k  = fetch(query("select sum(amount) as total_amount, count(*) as total_bid from card_games where timing='$market' AND number='K' AND created_at > $start_time AND created_at < $end_time"));
                
                }
            } else {
                if($game != "all"){
                
                    $j = fetch(query("select sum(amount) as total_amount, count(*) as total_bid from card_games where  game='$game' AND number='J' AND created_at > $start_time AND created_at < $end_time"));
                    $q = fetch(query("select sum(amount) as total_amount, count(*) as total_bid from card_games where  game='$game' AND number='Q' AND created_at > $start_time AND created_at < $end_time"));
                    $k = fetch(query("select sum(amount) as total_amount, count(*) as total_bid from card_games where  game='$game' AND number='K' AND created_at > $start_time AND created_at < $end_time"));
                
                    
                }else{
                    
                    $j = fetch(query("select sum(amount) as total_amount, count(*) as total_bid from card_games where  number='J' AND created_at > $start_time AND created_at < $end_time"));
                    $q = fetch(query("select sum(amount) as total_amount, count(*) as total_bid from card_games where  number='Q' AND created_at > $start_time AND created_at < $end_time"));
                    $k = fetch(query("select sum(amount) as total_amount, count(*) as total_bid from card_games where  number='K' AND created_at > $start_time AND created_at < $end_time"));
                }
            }

            
            
            $xvm = query("select * from card_rate where sn='1'");
            $xv = fetch($xvm);
            
            $winning = 0;
             if($market != "all"){
                 if($game != "all"){
               
               
                   $jw = query("select amount from card_games where status='1' AND timing='$market' AND game='$game' AND number='J' AND created_at > $start_time AND created_at < $end_time");
                   $qw = query("select amount from card_games where status='1' AND timing='$market' AND game='$game' AND number='Q' AND created_at > $start_time AND created_at < $end_time");
                   $kw = query("select amount from card_games where status='1' AND timing='$market' AND game='$game' AND number='K' AND created_at > $start_time AND created_at < $end_time");
               
                     
                 }else{
                     
                   $jw = query("select amount from card_games where status='1' AND timing='$market' AND number='J' AND created_at > $start_time AND created_at < $end_time");
                   $qw = query("select amount from card_games where status='1' AND timing='$market' AND number='Q' AND created_at > $start_time AND created_at < $end_time");
                   $kw = query("select amount from card_games where status='1' AND timing='$market' AND number='K' AND created_at > $start_time AND created_at < $end_time");
                 }
                   
                   
               } else {
                   if($game != "all"){
                   
                   
                       $jw = query("select amount from card_games where status='1' AND game='$game' AND number='J' AND created_at > $start_time AND created_at < $end_time");
                   $qw = query("select amount from card_games where status='1' AND game='$game' AND number='Q' AND created_at > $start_time AND created_at < $end_time");
                   $kw = query("select amount from card_games where status='1' AND game='$game' AND number='K' AND created_at > $start_time AND created_at < $end_time");
                       
                   }else{
                       
                       $jw = query("select amount from card_games where status='1' AND number='J' AND created_at > $start_time AND created_at < $end_time");
                   $qw = query("select amount from card_games where status='1' AND number='Q' AND created_at > $start_time AND created_at < $end_time");
                   $kw = query("select amount from card_games where status='1' AND number='K' AND created_at > $start_time AND created_at < $end_time");
                   }
                   
                   $jww = $jw['amount']*$xv['single'];
                   $qww = $qw['amount']*$xv['single'];
                   $kww = $kw['amount']*$xv['single'];
              
              // $query = fetch(query("select sum(amount) as total_amount, count(*) as total_bid from games where game='$game' AND number='$digit' AND date IN ('".$dates."')"));
               }
           // $get_win = query("select amount from games where status='1' AND game='$game' AND number='$digit' AND created_at > $start_time AND created_at < $end_time");
            // while($win = fetch($get_win)){
            //     $winning += $win['amount']*$xv['single'];
                
            // }
            
            // $a_bet += $query['total_bid'];
            // $a_amount += $query['total_amount']+0;
            // $a_winning += $winning;
            // $a_profit += $query['total_amount']-$winning;
            
            ?>
            
            
            
            <tr>
                <td>1</td>
                <td><?php echo $market; ?></td>
                <td><?php echo $game; ?></td>
                <td>J</td>
                <td><?php echo $j['total_amount']+0; ?></td>
                <td><?php echo $jww+0; ?></td>
                <td><?php echo $j['total_amount']-$jww; ?><?php if($j['total_amount']-$jww > 0){ echo "<span style='font-size:12px;color:white; background-color:green; padding:4px 10px;border-radius:5px;margin-left:5px'>Profit</span>"; } else { echo "<span style='font-size:12px;color:white; background-color:red; padding:4px 10px;border-radius:5px;margin-left:5px'>Loss</span>"; } ?></td>
                
            </tr>
            
            <tr>
                <td>2</td>
                <td><?php echo $market; ?></td>
                <td><?php echo $game; ?></td>
                <td>Q</td>
                <td><?php echo $q['total_amount']+0; ?></td>
                <td><?php echo $qww+0; ?></td>
                <td><?php echo $q['total_amount']-$qww; ?><?php if($q['total_amount']-$qww > 0){ echo "<span style='font-size:12px;color:white; background-color:green; padding:4px 10px;border-radius:5px;margin-left:5px'>Profit</span>"; } else { echo "<span style='font-size:12px;color:white; background-color:red; padding:4px 10px;border-radius:5px;margin-left:5px'>Loss</span>"; } ?></td>
                
            </tr>
            
            <tr>
                <td>3</td>
                <td><?php echo $market; ?></td>
                <td><?php echo $game; ?></td>
                <td>K</td>
                <td><?php echo $k['total_amount']+0; ?></td>
                <td><?php echo $kww+0; ?></td>
                <td><?php echo $k['total_amount']-$kww; ?><?php if($k['total_amount']-$kww > 0){ echo "<span style='font-size:12px;color:white; background-color:green; padding:4px 10px;border-radius:5px;margin-left:5px'>Profit</span>"; } else { echo "<span style='font-size:12px;color:white; background-color:red; padding:4px 10px;border-radius:5px;margin-left:5px'>Loss</span>"; } ?></td>
                
            </tr>
            
            
            
            

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