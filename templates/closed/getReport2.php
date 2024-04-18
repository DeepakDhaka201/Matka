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



if($game == "single"){
    $getTotal = query("select * from games where bazar='$market' AND game='$game' AND date='$date'");
    $numberArray = getSingle();   
} else if($game == "jodi"){
    $getTotal = query("select * from games where bazar='$market' AND game='$game' AND date='$date'");
    $numberArray = getDouble();   
} else if($game == "panna"){
    $getTotal = query("select * from games where bazar='$market' AND  game='Harf' AND date='$date'");
    $numberArray = getPatti();   
}


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
    
    if($game == "single"){
        $getBets = query("select * from games where bazar='$market' AND game='single' AND number='$number' AND date='$date'");
        
    } else if($game == "jodi"){
        $getBets = query("select * from games where bazar='$market' AND game='jodi' AND number='$number' AND date='$date'");
    } else if($game == "panna"){
        $getBets = query("select * from games where bazar='$market' AND game='Harf' AND number='$number' AND date='$date'");
        
        $get_sum_of = $number[0]+$number[1]+$number[2];
        $get_sum_of = $get_sum_of."";
        if($get_sum_of > 9){
            $single_num = $get_sum_of[1];
        } else {
            $single_num = $get_sum_of;
        }
        
        $getBets2 = fetch(query("select sum(amount) as total from games where bazar='$market' AND game='single' AND number='$single_num' AND date='$date'"));
    }

    
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

function getSingle(){
    
    for($i = 0; $i < 10; $i++){
     $array[] = $i;   
    }
    
    return $array;
}

function getDouble(){
    
    for($i = 0; $i < 100; $i++){
        if($i < 10){
            $i = "0".$i;
        }
     $array[] = $i;   
    }
    
    return $array;
}


function getPatti(){
    
        
        $numbers[] ="000";
        $numbers[] ="111";
        $numbers[] ="222";
        $numbers[] ="333";
        $numbers[] ="444";
        $numbers[] ="555";
        $numbers[] ="666";
        $numbers[] ="777";
        $numbers[] ="888";
        $numbers[] ="999";
        
        return $numbers;
}

?>

   
