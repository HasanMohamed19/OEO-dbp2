<?php
//echo 'asa';
//include '../debugging.php';
//include "../helpers/debugging.php";
include "../models/Hall.php";
include "../models/HallImage.php";

// set id appropriately
$id = $_GET['hallId'];
//$id = 1000;
//echo $id . ' is id';
$hall = new Hall();
$hall->setHallId($id);
$hall->initWithId();

//($hall);

$hallImages = new HallImage();
$hallImages = $hallImages->getAllImagesForHall($id);
$arr = [
    'hallName' => $hall->getHallName(),
    'hallDescription' => $hall->getDescription(),
    'rentalCharge' => $hall->getRentalCharge(),
    'capacity' => $hall->getCapacity(),
    'hallImages' => $hallImages
];
echo json_encode($arr);
//echo json_encode($hall);