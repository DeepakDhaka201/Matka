<?php
include "../connection/config.php";
extract($_REQUEST);


query("DELETE FROM `rates_offers` WHERE sn='$sn'");

$data['isConfirmed'] = true;

echo json_encode($data);