<?php
//include '../debugging.php';
include_once '../helpers/Database.php';
include_once '../models/User.php';
include_once '../models/Client.php';

$client = new Client();
$client->setClientId($_GET['clientId']);
//echo $client->getClientId();
$discount = $client->getDiscountRate();

echo $discount;