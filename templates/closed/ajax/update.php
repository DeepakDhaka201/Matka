<?php
include "../connection/config.php";
extract($_REQUEST);

query("update games set status='1' where sn='$sn'");

    query("update users set wallet=wallet+'$amount' where mobile='$user'");
    
    query("INSERT INTO `transactions`(`user`, `amount`, `type`, `remark`, `created_at`) VALUES ('$user','$amount','1','Winning','$stamp')");
    
    $get_partner = fetch(query("select partner,email from users where mobile='$user'"));
    if($get_partner['partner'] != 0){
       
        $partner_sn = $get_partner['partner'];
        $partner_email = $get_partner['email'];
        
        $get_partcomission = fetch(query("select partnership from partners where sn='$partner_sn'"));
        
        $part = $get_partcomission['partnership'];
        
        $part_amount = $amount*$part/100;
        $admin_amount = $amount-$part_amount;
        
        query("update partners set partner_ledger=partner_ledger-'$part_amount', ledger=ledger-'$admin_amount' where sn='$partner_sn'");
        
        query("INSERT INTO `partner_ledger`(`user`, `amount`, `type`, `remark`, `created_at`,`owner`) VALUES ('$partner_sn','$part_amount','0','Bet winning','$stamp','$partner_sn')");
        
        $a_msg = 'Bet winning for '.$partner_email.' User';
        
        query("INSERT INTO `transactions`(`user`, `amount`, `type`, `remark`, `created_at`,`owner`) VALUES ('admin','$admin_amount','0','$a_msg','$stamp','$partner_sn')");
    }
    
    echo "Done";