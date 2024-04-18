<?php 
include "connection/config.php";
if (!checks("admin"))
{
    redirect("login.php");
}

$time = date("H:i",$stamp);
$day = strtoupper(date("l",$stamp));
$date = date("d/m/Y");
//$date = "07/09/2021";


$game = $_REQUEST['game'];
$market = $_REQUEST['market'];


$sc = query("select * from card_rate where sn='1'");
$s = fetch($sc);




    $getTotal = query("select * from card_games where timing='$market' AND  game='Hukum' AND date='$date'");
    $numberArray = getPatti();   



while($bet = fetch($getTotal)){
    
    $user = $bet['user'];
    
    $total += $bet['amount'];
    
}

if(!isset($total)){
    $total = "0";
}

$full_total = 0;


?>
<style>
    .hrr {
            width: 100%;
    height: 1px;
    margin-bottom: 10px;
    background: rgb(255, 255, 255);
    }
    
    .card-body {
        padding: 0px !important;
    }
</style>
<div class="row">
    
    
    
    <?php for($i = 0; $i < count($numberArray); $i++){
    
    $number = $numberArray[$i];
    $totalBetAmount2 = 0;
    $num_bets2 = 0;
    $get_sum_of = 0;
    
    
        $getBets = query("select * from card_games where timing='$market' AND game='Hukum' AND number='$number' AND date='$date'");
        
    
        
     //   $getBets2 = fetch(query("select sum(amount) as total from card_games where timing='$market' AND game='$game' AND number='$number' AND date='$date'"));
    

    
    $thisAmount = $total;
    
    $totalBetAmount = 0;
    
    
    $num_bets = 0;
        
    while($bet = fetch($getBets)){
        
        $bet_amount = $bet['amount'];
        
        $totalBetAmount = $totalBetAmount+$bet_amount;
        $num_bets++;
    
    }
    
    
    ?>
    
    
    <?php 
    
    
    $full_total += $totalBetAmount;
    
    $dddiv = "";
    
    $dddiv= '<div class="col-sm-6 col-md-4 col-lg-2 grid-margin stretch-card">
            <div class="card'; 
            if($totalBetAmount > 0){  $dddiv .=' loss';  }
               $dddiv .=  '"><div class="card-body" style="    text-align: center;">
                    <p style="margin-top: 10px;">Total Bids</p>
                    <p>'.$num_bets.'</p>
                    <div class="hrr"></div>
                    <h4 class="card-title number">'.$number.'</h4>
                    <h4 class="card-title">'.$totalBetAmount.'</h4>
                </div>
            </div>
        </div>';
        $daata['div'] = $dddiv;
        $daata['amount'] = $totalBetAmount;
        
        
        $datas[] = $daata;
    
     } 
     
     
     function cmp(array $a, array $b) {
        if ($a['amount'] < $b['amount']) {
            return 1;
        } else if ($a['amount'] > $b['amount']) {
            return -1;
        } else {
            return 0;
        }
    }
     usort($datas, 'cmp');
     
     for($ix = 0; $ix < count($datas); $ix++){
         
        echo $datas[$ix]['div'];
         
     }
     ?>

  

</div>
<div style="    display: flex;
    justify-content: flex-end;">
    
  <div class="col-sm-6 col-md-4 col-lg-2 grid-margin stretch-card">
            <div class="card">
                <div class="card-body" style="    text-align: center;">
                    <p style="margin-top: 10px;">Total Betting Amount</p>
                    
                    <h4 class="card-title number"><?php echo $full_total; ?></h4>
                    
                  
                </div>
            </div>
    </div>
</div>
<?php 





function getPatti(){
    
        $numbers[] ="J";
        $numbers[] ="Q";
        $numbers[] ="K";
        
        
        return $numbers;
}

?>


   
