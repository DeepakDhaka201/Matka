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
$timing = $_REQUEST['timing'];


$sc = query("select * from rate where sn='1'");
$s = fetch($sc);



if($game == "single"){
    $getTotal = query("select * from starline_games where bazar='$market' AND game='$game' AND timing_sn='$timing' AND date='$date'");
    $numberArray = getSingle();   
} else if($game == "jodi"){
    $getTotal = query("select * from starline_games where bazar='$market' AND game='$game' AND timing_sn='$timing' AND date='$date'");
    $numberArray = getDouble();   
} else if($game == "panna"){
    $getTotal = query("select * from starline_games where bazar='$market' AND timing_sn='$timing' AND ( game='singlepatti' OR game='doublepatti' OR game='tripepatti' ) AND date='$date'");
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

<div class="row">
    
    <?php for($i = 0; $i < count($numberArray); $i++){
    
    $number = $numberArray[$i];
    $totalBetAmount2 = 0;
    $num_bets2 = 0;
    $get_sum_of = 0;
    
    
    if($game == "single"){
        $getBets = query("select * from starline_games where bazar='$market' AND timing_sn='$timing' AND game='single' AND number='$number' AND date='$date'");
        
    } else if($game == "jodi"){
        $getBets = query("select * from starline_games where bazar='$market' AND timing_sn='$timing' AND game='jodi' AND number='$number' AND date='$date'");
    } else if($game == "panna"){
        $getBets = query("select * from starline_games where bazar='$market' AND timing_sn='$timing' AND ( game='singlepatti' OR game='doublepatti' OR game='tripepatti' ) AND number='$number' AND date='$date'");
        
         $get_sum_of = $number[0]+$number[1]+$number[2];
        $get_sum_of = $get_sum_of."";
        if($get_sum_of > 9){
            $single_num = $get_sum_of[1];
        } else {
            $single_num = $get_sum_of;
        }
        
        $getBets2 = fetch(query("select sum(amount) as total from starline_games where bazar='$market' AND timing_sn='$timing' AND game='single' AND number='$single_num' AND date='$date'"));
    }

    
    $thisAmount = $total;
    
    $totalBetAmount = 0;
        
    $num_bets = 0;
    while($bet = fetch($getBets)){
        
        $user = $bet['user'];
        
        $totalBetAmount = $totalBetAmount+$bet_amount;
        $num_bets++;
    }
    
 //   $thisAmount -= $totalBetAmount;
    
    ?>
    
    

        
    <?php if(isset($getBets2)) {
    
    $totalBetAmount2 += $getBets2['total'];
    
    $num_bets2 += rows(query("select sn from starline_games where bazar='$market' AND timing_sn='$timing' AND game='single' AND number='$single_num' AND date='$date'"));
    
    
    if (!array_key_exists($single_num,$ssn)){
        $full_total += $totalBetAmount2;
        $ssn[$single_num] = $totalBetAmount2;
    } else {
        $full_total += $totalBetAmount;
    }
    ?>
    
        <div class="col-sm-6 col-md-4 col-lg-2 grid-margin stretch-card">
            <div class="card <?php if($totalBetAmount2 > 0){ echo 'loss';  } ?>">
                <div class="card-body" style="    text-align: center;">
                    <p style="margin-top: 10px;">Total Bids</p>
                    <p><?php echo $num_bets2.'('.$num_bets.')'; ?></p>
                    <div class="hrr"></div>
                    <h4 class="card-title number"><?php echo $single_num; ?></h4>
                    <h4 class="card-title"><?php echo $totalBetAmount2.'('.$totalBetAmount.')  '.$number; ?></h4>
                    
                  
                </div>
            </div>
        </div>
    
    <?php } else {
    $full_total += $totalBetAmount; ?>
        <div class="col-sm-6 col-md-4 col-lg-2 grid-margin stretch-card">
            <div class="card <?php if($totalBetAmount > 0){ echo 'loss';  } ?>">
                <div class="card-body" style="    text-align: center;">
                    <p style="margin-top: 10px;">Total Bids</p>
                    <p><?php echo $num_bets; ?></p>
                    <div class="hrr"></div>
                    <h4 class="card-title number"><?php echo $number; ?></h4>
                    <h4 class="card-title"><?php echo $totalBetAmount; ?></h4>
                    
                  
                </div>
            </div>
        </div>
    
    <?php } } ?>
    
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
    
        $numbers[] ="100";
        $numbers[] ="119";
        $numbers[] ="155";
        $numbers[] ="227";
        $numbers[] ="335";
        $numbers[] ="344";
        $numbers[] ="399";
        $numbers[] ="588";
        $numbers[] ="669";
        $numbers[] ="200";
        $numbers[] ="110";
        $numbers[] ="228";
        $numbers[] ="255";
        $numbers[] ="336";
        $numbers[] ="499";
        $numbers[] ="660";
        $numbers[] ="688";
        $numbers[] ="778";
        $numbers[] ="300";
        $numbers[] ="166";
        $numbers[] ="229";
        $numbers[] ="337";
        $numbers[] ="355";
        $numbers[] ="445";
        $numbers[] ="599";
        $numbers[] ="779";
        $numbers[] ="788";
        $numbers[] ="400";
        $numbers[] ="112";
        $numbers[] ="220";
        $numbers[] ="266";
        $numbers[] ="338";
        $numbers[] ="446";
        $numbers[] ="455";
        $numbers[] ="699";
        $numbers[] ="770";
        $numbers[] ="500";
        $numbers[] ="113";
        $numbers[] ="122";
        $numbers[] ="177";
        $numbers[] ="339";
        $numbers[] ="366";
        $numbers[] ="447";
        $numbers[] ="799";
        $numbers[] ="889";
        $numbers[] ="600";
        $numbers[] ="114";
        $numbers[] ="277";
        $numbers[] ="330";
        $numbers[] ="448";
        $numbers[] ="466";
        $numbers[] ="556";
        $numbers[] ="880";
        $numbers[] ="899";
        $numbers[] ="700";
        $numbers[] ="115";
        $numbers[] ="133";
        $numbers[] ="188";
        $numbers[] ="223";
        $numbers[] ="377";
        $numbers[] ="449";
        $numbers[] ="557";
        $numbers[] ="566";
        $numbers[] ="800";
        $numbers[] ="116";
        $numbers[] ="224";
        $numbers[] ="233";
        $numbers[] ="288";
        $numbers[] ="440";
        $numbers[] ="477";
        $numbers[] ="558";
        $numbers[] ="990";
        $numbers[] ="900";
        $numbers[] ="117";
        $numbers[] ="144";
        $numbers[] ="199";
        $numbers[] ="225";
        $numbers[] ="388";
        $numbers[] ="559";
        $numbers[] ="577";
        $numbers[] ="667";
        $numbers[] ="550";
        $numbers[] ="668";
        $numbers[] ="244";
        $numbers[] ="299";
        $numbers[] ="226";
        $numbers[] ="488";
        $numbers[] ="677";
        $numbers[] ="118";
        $numbers[] ="334";
        $numbers[] ="128";
        $numbers[] ="137";
        $numbers[] ="146";
        $numbers[] ="236";
        $numbers[] ="245";
        $numbers[] ="290";
        $numbers[] ="380";
        $numbers[] ="470";
        $numbers[] ="489";
        $numbers[] ="560";
        $numbers[] ="678";
        $numbers[] ="579";
        $numbers[] ="129";
        $numbers[] ="138";
        $numbers[] ="147";
        $numbers[] ="156";
        $numbers[] ="237";
        $numbers[] ="246";
        $numbers[] ="345";
        $numbers[] ="390";
        $numbers[] ="480";
        $numbers[] ="570";
        $numbers[] ="679";
        $numbers[] ="120";
        $numbers[] ="139";
        $numbers[] ="148";
        $numbers[] ="157";
        $numbers[] ="238";
        $numbers[] ="247";
        $numbers[] ="256";
        $numbers[] ="346";
        $numbers[] ="490";
        $numbers[] ="580";
        $numbers[] ="670";
        $numbers[] ="689";
        $numbers[] ="130";
        $numbers[] ="149";
        $numbers[] ="158";
        $numbers[] ="167";
        $numbers[] ="239";
        $numbers[] ="248";
        $numbers[] ="257";
        $numbers[] ="347";
        $numbers[] ="356";
        $numbers[] ="590";
        $numbers[] ="680";
        $numbers[] ="789";
        $numbers[] ="140";
        $numbers[] ="159";
        $numbers[] ="168";
        $numbers[] ="230";
        $numbers[] ="249";
        $numbers[] ="258";
        $numbers[] ="267";
        $numbers[] ="348";
        $numbers[] ="357";
        $numbers[] ="456";
        $numbers[] ="690";
        $numbers[] ="780";
        $numbers[] ="123";
        $numbers[] ="150";
        $numbers[] ="169";
        $numbers[] ="178";
        $numbers[] ="240";
        $numbers[] ="259";
        $numbers[] ="268";
        $numbers[] ="349";
        $numbers[] ="358";
        $numbers[] ="457";
        $numbers[] ="367";
        $numbers[] ="790";
        $numbers[] ="124";
        $numbers[] ="160";
        $numbers[] ="179";
        $numbers[] ="250";
        $numbers[] ="269";
        $numbers[] ="278";
        $numbers[] ="340";
        $numbers[] ="359";
        $numbers[] ="368";
        $numbers[] ="458";
        $numbers[] ="467";
        $numbers[] ="890";
        $numbers[] ="125";
        $numbers[] ="134";
        $numbers[] ="170";
        $numbers[] ="189";
        $numbers[] ="260";
        $numbers[] ="279";
        $numbers[] ="350";
        $numbers[] ="369";
        $numbers[] ="378";
        $numbers[] ="459";
        $numbers[] ="567";
        $numbers[] ="468";
        $numbers[] ="126";
        $numbers[] ="135";
        $numbers[] ="180";
        $numbers[] ="234";
        $numbers[] ="270";
        $numbers[] ="289";
        $numbers[] ="360";
        $numbers[] ="379";
        $numbers[] ="450";
        $numbers[] ="469";
        $numbers[] ="478";
        $numbers[] ="568";
        $numbers[] ="127";
        $numbers[] ="136";
        $numbers[] ="145";
        $numbers[] ="190";
        $numbers[] ="235";
        $numbers[] ="280";
        $numbers[] ="370";
        $numbers[] ="479";
        $numbers[] ="460";
        $numbers[] ="569";
        $numbers[] ="389";
        $numbers[] ="578";
        $numbers[] ="589";
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

   
