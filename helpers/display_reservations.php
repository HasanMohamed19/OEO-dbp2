<?php

//include_once '../models/User.php';
include_once '../debugging.php';
include_once '../models/Reservation.php';
 
//if ($_GET['clientId']) {
//    echo 'asa';
//} else {
//    echo 'asasasa';
//}

$start = 0;
$limit = 10;
$reservation = new Reservation();
$reservation->setClientId($_COOKIE['clientId']);
$reservations = $reservation->getReservationsForClient($start, $limit);
$reservation->displayClientReservations($reservations);
