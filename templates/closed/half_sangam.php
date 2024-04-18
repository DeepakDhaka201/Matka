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


$sc = query("select * from rate where sn='1'");
$s = fetch($sc);

$getTotal = fetch(query("select sum(amount) as total from games where bazar='$market' AND game='$game' AND date='$date'"));

$total = $getTotal['total']+0;



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
    
    
    
    <?php 
    
   
    $getBets = query("select * from games where bazar='$market' AND game='$game' AND date='$date' group by number");
    
        
    while($bet = fetch($getBets)){
        
        $bet_amount = $bet['amount'];
        $number = $bet['number'];
        $get_total = fetch(query("select sum(amount) as total from games where bazar='$market' AND game='$game' AND date='$date' AND number='".$bet['number']."'"));
        
        $totalBetAmount = $get_total['total'];
    
        $get_total = query("select sn from games where bazar='$market' AND game='$game' AND date='$date' AND number='".$bet['number']."'");
    
        $num_bets = rows($get_total);
    
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
                    
                    <h4 class="card-title number"><?php echo $total; ?></h4>
                    
                  
                </div>
            </div>
    </div>
</div>




   
