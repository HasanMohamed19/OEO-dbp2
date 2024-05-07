<?php

include('./template/header.html');

include('./template/client/client_booking.html');

include('./template/footer.html');

include('./models/Reservation.php');
include('./models/ReservationMenuItem.php');
include('./models/Event.php');
include('./models/BillingAddress.php');
include('./models/CardDetail.php');

$event = new Event();
$event->setName($_POST['bookingEventName']);
$event->setStartDate($_POST['bookingStartDate']);
$event->setEndDate($_POST['bookingEndDate']);
$event->setStartTime($_POST['bookingStartTime']);
$event->setEndTime($_POST['bookingEndTime']);
$event->setAudienceNumber($_POST['bookingNoAudiences']);

$menuItems = $_POST['menuItems'];
//$menuItem = new ReservationMenuItem();
//$menuItem->setQuantity($quantity);

$billing = new BillingAddress();
$billing->setPhoneNumber($_POST['paymentBillingPhone']);
$billing->setBuildingNumber($_POST['paymentBillingBuilding']);
$billing->setRoadNumber($_POST['paymentBillingStreet']);
$billing->setBlockNumber($_POST['paymentBillingBlock']);
$billing->setCity($_POST['paymentBillingArea']);
$billing->setCountry($_POST['paymentBillingCountry']);

$card = new CardDetail();
$card->setCVV($_POST['paymentCardCVV']);
$card->setCardNumber($_POST['paymentCardNumber']);
$card->setCardholderName($_POST['paymentCardholderName']);
$card->setExpiryDate($_POST['paymentCardExpiryYear'] + $_POST['paymentCardExpiryMonth']);

$reservation = new Reservation();
$reservation->setNotes($_POST['bookingEventNotes']);