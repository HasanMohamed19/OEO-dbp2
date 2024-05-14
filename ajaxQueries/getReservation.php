<?php
include_once '../debugging.php';
include_once '../models/Reservation.php';
include_once '../models/Event.php';
include_once '../models/ReservationMenuItem.php';

$reservation = new Reservation();
$reservation->initReservationWithId($_GET['reservationId']);
$event = new Event();
$event->initWithEventId($reservation->getEventId());
$menuItems = ReservationMenuItem::getItemsForReservation($_GET['reservationId']);

$data = [
    reservationId=>$_GET['reservationId'],
    eventId=>$event->getEventId(),
    clientId=>$reservation->getClientId(),
    eventName=>$event->getName(),
    eventAudience=>$event->getAudienceNumber(),
    eventStartDate=>$event->getStartDate(),
    eventEndDate=>$event->getEndDate(),
    eventStartTime=>$event->getStartTime(),
    eventEndTime=>$event->getEndTime(),
    notes=>$reservation->getNotes(),
    menuItems=>$menuItems
];

echo json_encode($data);