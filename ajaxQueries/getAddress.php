<?php

include('../models/BillingAddress.php');

$billing = new BillingAddress();
$billing->setAddressId($_GET['id']);
$billing->initWithId();
// the name of the keys must match the html element ids for input
$arr = [
    'Building'=>$billing->getBuildingNumber(),
    'Street'=>$billing->getRoadNumber(),
    'Block'=>$billing->getBlockNumber(),
    'Area'=>$billing->getCity(),
    'Country'=>$billing->getCountry(),
    'Phone'=>$billing->getPhoneNumber(),
];
echo json_encode($arr);