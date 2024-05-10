<?php

include('../models/BillingAddress.php');

$billing = new BillingAddress();
$billing->setAddressId($_GET['addressId']);
$billing->initWithId();
$arr = [
    'building'=>$billing->getBuildingNumber(),
    'street'=>$billing->getRoadNumber(),
    'block'=>$billing->getBlockNumber(),
    'city'=>$billing->getCity(),
    'country'=>$billing->getCountry(),
    'phone'=>$billing->getPhoneNumber(),
];
echo json_encode($arr);