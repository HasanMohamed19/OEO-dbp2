<?php

include 'debugging.php';
include './helpers/Database.php';
include './models/User.php';
include_once './models/Client.php';
include './models/Reservation.php';
include './models/Pagination.php';
include 'header.php';

//include './template/admin/view_bookings.html';




echo '<div class="container">';
echo '<div class="row"><h1>Reservations</h1></div>';
if (isset($_GET['pageno']))
    $start = $_GET['pageno'];
else
    $start = 1;

$end = 10;

$table = 'dbProj_Reservation';

$reservation = new Reservation();
$reservations = $reservation->getAllReservations($start, $end);

echo count($reservations) . " rows were found";

$reservation->createReservationsTable($reservations);
$pagination = new Pagination();
$pagination->setTotal_records(Reservation::countAllReservations());
//$pagination->totalRecords($table);
echo $pagination->total_records . ' is total records';
$pagination->setLimit($end);
$pagination->page("");
 



//echo $pagination->firstBack();
//echo $pagination->where();
//echo $pagination->nextLast();
//echo 'current page is: ' . $pagination->where();
echo '</div>';
include './template/footer.html';
?>