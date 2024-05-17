<?php

include 'debugging.php';
include './helpers/Database.php';
include './models/User.php';
include_once './models/Client.php';
include './models/Reservation.php';
include './models/Pagination.php';
include './template/header.html';

include './template/admin/view_bookings.html';




if (isset($_GET['pageno']))
    $start = $_GET['pageno'];
else
    $start = 0;

$end = 10;

$table = 'dbProj_Reservation';

$reservation = new Reservation();
$reservations = $reservation->getAllReservations($start, $end);

//echo count($reservations) . " rows were found";

$reservation->createReservationsTable($reservations);
$pagination = new Pagination();
$pagination->totalRecords($table);
//echo $pagination->total_records . ' is total records';
$pagination->setLimit($end);
$pagination->page("");
 
$c = new Client();
$r = $c->hasPersonalDeatils('50');


//echo $pagination->firstBack();
//echo $pagination->where();
//echo $pagination->nextLast();
//echo 'current page is: ' . $pagination->where();

include './template/footer.html';
?>