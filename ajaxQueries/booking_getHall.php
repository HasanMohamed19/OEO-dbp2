<?php

include "../models/Hall.php";

// set id appropriately
//$id = $_GET['hall_id'];
$id = 1000;

$hall = new Hall();
$hall->setHallId($id);
$hall->initWithId();
$arr = [
    'hallName' => $hall->getHallName(),
    'hallDescription' => $hall->getDescription(),
    'rentalCharge' => $hall->getRentalCharge(),
    'capacity' => $hall->getCapacity()
];
echo json_encode($arr);
//echo json_encode($hall);