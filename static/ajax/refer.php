<?php
include "../connection/config.php";
extract($_REQUEST);

query("update refers set status='1' where sn='$sn'");

    query("update users set wallet=wallet+'$amount' where mobile='$user'");
    
    query("INSERT INTO `transactions`(`user`, `amount`, `type`, `remark`, `created_at`) VALUES ('$user','$amount','1','Referral Earning','$stamp')");
    
    echo "Done";