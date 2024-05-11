<?php


include_once('debugging.php');
include_once('./models/Event.php');
include_once('./models/Reservation.php');
include_once('./models/ReservationMenuItem.php');
//include('./models/BillingAddress.php');
//include('./models/CardDetail.php');

if (isset($_POST['submitted'])) {
    $event = new Event();
    $event->setName($_POST['bookingEventName']);
    $event->setStartDate($_POST['bookingStartDate']);
    $event->setEndDate($_POST['bookingEndDate']);
    $event->setStartTime($_POST['bookingStartTime']);
    $event->setEndTime($_POST['bookingEndTime']);
    $event->setAudienceNumber($_POST['bookingNoAudiences']);
    if (!$event->isValid()) {
        die('Event not valid!');
    } 

    // use ids for reservation
    $reservation = new Reservation();
    $reservation->setNotes($_POST['bookingEventNotes']);
    $reservation->setHallId($_POST['bookingHallId']);
    $reservation->setClientId($_POST['bookingClientId']);
    $reservation->setStatusId(RESERVATION_RESERVED);
    if (!$reservation->saveReservation($event)) {
        die('Reservation not saved!');
    }

    $resId = $reservation->getReservationId();
    echo "ID: $resId";
    
    
//    header('booking_summary.php');
}
    

include('./template/header.html');

include('./template/client/client_booking.html');

include('./template/footer.html');
    

//    
//    $menuItems = $_POST['menuItems'];
    //$menuItem = new ReservationMenuItem();
    //$menuItem->setQuantity($quantity);