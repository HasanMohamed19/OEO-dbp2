<?php


include('debugging.php');
//include('./models/Reservation.php');
//include('./models/ReservationMenuItem.php');
//include('./models/Event.php');
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

    
    
    
    // get id for the event
    if ($event->addEvent() ) {
        
        $eventId = $event->getEventId();

//        echo "IDS: $eventId";
        
        // use ids for reservation
        $reservation = new Reservation();
        $reservation->setNotes($_POST['bookingEventNotes']);
        $reservation->setHallId(1000);
        $reservation->setClientId(1);
        $reservation->setEventId($eventId);
        $reservation->setStatusId(RESERVATION_RESERVED);
        $reservation->setPrice($_POST['bookingPrice']);
        
        if ($billing->addBillingAddress() && $card->addCardDetail()) {

        }
    } 
}
    

include('./template/header.html');

include('./template/client/client_booking.html');

include('./template/footer.html');
    

//    
//    $menuItems = $_POST['menuItems'];
    //$menuItem = new ReservationMenuItem();
    //$menuItem->setQuantity($quantity);