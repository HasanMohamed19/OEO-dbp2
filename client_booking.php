<?php


include_once('debugging.php');
include_once('./helpers/Database.php');
include_once('./models/Event.php');
include_once('./models/Reservation.php');
include_once('./models/ReservationMenuItem.php');
include_once('./models/Invoice.php');

if (isset($_POST['submitted'])) {
    // create event
    $event = new Event();
    $event->setName($_POST['bookingEventName']);
    $event->setStartDate($_POST['bookingStartDate']);
    $event->setEndDate($_POST['bookingEndDate']);
    $event->setStartTime($_POST['bookingStartTime']);
    $event->setEndTime($_POST['bookingEndTime']);
    $event->setAudienceNumber($_POST['bookingNoAudiences']);
    if (!$event->isValid($_POST['bookingHallId']) > 1) {
        die('Event not valid!');
    } 

    // create reservation
    $reservation = new Reservation();
    $reservation->setNotes($_POST['bookingEventNotes']);
    $reservation->setHallId($_POST['bookingHallId']);
    $reservation->setClientId($_POST['bookingClientId']);
    // status is 'booked' by default in the procedure
//    $reservation->setStatusId(RESERVATION_RESERVED);
    if (!$reservation->saveReservation($event)) {
        die('Reservation not saved!');
    }
    
    // saving reservation also sets reservation id, need to use
    // it to insert menu items and invoice
    $resId = $reservation->getReservationId();
//    echo "ID: $resId";

    // now save selected menu items
    $menuItems = json_decode($_POST['menuItems'], true);
//    var_dump($menuItems);
    foreach ($menuItems as $i=>$menuItem) {
        $item = new ReservationMenuItem();
        $item->setItemId($menuItem['id']);
        $item->setQuantity($menuItem['quantity']);
        $item->setReservationId($resId);
        if (!$item->addReservationMenuItem()) {
            die('Reservation menu item not saved!');
        }
    }
//    echo "all items added";

    // now add invoice
    Invoice::addWithReservationId($resId);
    
//    header('booking_summary.php');
}
    

include('./template/header.html');

include('./template/client/client_booking.html');

include('./template/footer.html');
    

//    
//    $menuItems = $_POST['menuItems'];
    //$menuItem = new ReservationMenuItem();
    //$menuItem->setQuantity($quantity);