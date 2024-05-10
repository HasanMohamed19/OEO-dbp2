<?php

    include './helpers/Database.php';
    include './models/User.php';
    include './models/Reservation.php';
    include './template/header.html';
        
    include './template/admin/view_bookings.html';
    
    include './template/footer.html';

    

    include 'debugging.php';

    $reservation = new Reservation();
    $reservations = $reservation->getAllReservations();
    
    echo count($reservations) . " rows were found";

    $reservation->createReservationsTable($reservations);
?>