<?php
include "../connection/config.php";
extract($_REQUEST);

echo "<option value='all'>All</option>";

if($type == "starline"){
    
    $get_markets = query("select * from starline_markets");
    
    while($market = fetch($get_markets)){
        
        echo "<option>".$market['name']."</option>";
        
    }
    
} else if($type == "main"){
    
    $get_markets = query("select * from gametime_new");
    
    while($market = fetch($get_markets)){
        
        echo "<option>".$market['market']."</option>";
        
    }
    
    $get_markets = query("select * from gametime_manual");
    
    while($market = fetch($get_markets)){
        
        echo "<option>".$market['market']."</option>";
        
    }
    
    
}else if($type == "delhi"){
    
    $get_markets = query("select * from gametime_delhi");
    
    while($market = fetch($get_markets)){
        
        echo "<option>".$market['market']."</option>";
        
    }
    
   
    
    
}else if($type == "card"){
    
    $get_markets = query("select * from card_timings");
    
    while($market = fetch($get_markets)){
        
        echo "<option>".$market['close']."</option>";
        
    }
    
   
    
    
}