<?php

include 'debugging.php';
include './helpers/Database.php';
include './models/User.php';
include_once './models/Client.php';
include './models/Reservation.php';
include './models/Pagination.php';
include 'header.php';





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



$reservation->createReservationsTable($reservations);
$pagination = new Pagination();
$pagination->setTotal_records(Reservation::countAllReservations());

$pagination->setLimit($end);
$pagination->page("");
 

echo '</div>';
include './template/footer.html';
?>

<script type="text/javascript">
    $(document).ready(function () {
        $('#all-bookings').addClass('active-page');
    });
</script>