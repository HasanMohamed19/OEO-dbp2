<?php
//include ('../debugging.php');
include('../models/BillingAddress.php');

$billing = new BillingAddress();
$billing->setPhoneNumber($_POST['phone']);
$billing->setBuildingNumber($_POST['building']);
$billing->setRoadNumber($_POST['street']);
$billing->setBlockNumber($_POST['block']);
$billing->setCity($_POST['area']);
$billing->setCountry($_POST['country']);
$billing->setClientId($_POST['clientId']);

echo $billing->addBillingAddress();

