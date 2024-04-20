<?php
include "../connection/config.php";
extract($_REQUEST);


query("INSERT INTO `rates_offers`(`user`, `game`, `rate`) VALUES ('$id','$game','$rate')");

$data['isConfirmed'] = true;

echo json_encode($data);