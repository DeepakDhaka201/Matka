<?php
include "connection/config.php";
if (!checks("admin"))
{
    redirect("login.php");
}

$get_dd = fetch(query("select count(sn) as tota from withdraw_requests where status='0'"));

echo $get_dd['tota'];