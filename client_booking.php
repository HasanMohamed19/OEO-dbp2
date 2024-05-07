<?php

include('./template/header.html');

include('./template/client/client_booking.html');

include('./template/footer.html');

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

    $billing = new BillingAddress();
    $billing->setPhoneNumber($_POST['paymentBillingPhone']);
    $billing->setBuildingNumber($_POST['paymentBillingBuilding']);
    $billing->setRoadNumber($_POST['paymentBillingStreet']);
    $billing->setBlockNumber($_POST['paymentBillingBlock']);
    $billing->setCity($_POST['paymentBillingArea']);
    $billing->setCountry($_POST['paymentBillingCountry']);
    $billing->setClientId(1);
    if (!$billing->isValid()) {
        die('Billing not valid!');
    } 

    $card = new CardDetail();
    $card->setCVV($_POST['paymentCardCVV']);
    $card->setCardNumber($_POST['paymentCardNumber']);
    $card->setCardholderName($_POST['paymentCardholderName']);
    $expiryDate = trim($_POST['paymentCardExpiryYear']).'-'.trim($_POST['paymentCardExpiryMonth']).'-28';
    $card->setExpiryDate($expiryDate);
    $card->setClientId(1);
    if (!card->isValid()) {
        die('Card not valid!');
    } 
    
    if ($event->addEvent() && $card->addCardDetail()
            && $billing->addBillingAddress()) {
        echo "Success!";
    } else {
        echo "FAILURE";
    }

//    $reservation = new Reservation();
//    $reservation->setNotes($_POST['bookingEventNotes']);
//    
//    $menuItems = $_POST['menuItems'];
    //$menuItem = new ReservationMenuItem();
    //$menuItem->setQuantity($quantity);
}