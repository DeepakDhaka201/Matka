<?php
include "connection/config.php";


$get_dd = fetch(query("select count(sn) as total from upi_verification"));

echo $get_dd['total'];