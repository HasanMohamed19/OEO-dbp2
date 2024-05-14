<?php

include_once '../debugging.php';
include_once '../models/Event.php';
include_once '../models/Reservation.php';

$hallId = $_POST['hallId'];
$eventJSON = json_decode($_POST['event']);
$reservationId = $_POST['reservationId'];
$event = new Event();
if ($reservationId > 0) {
    $reservation = new Reservation();
    $reservation->initReservationWithId($reservationId);
    $event->setEventId($reservation->getEventId());
}
$event->setName($eventJSON->eventName);
$event->setStartDate($eventJSON->startDate);
$event->setEndDate($eventJSON->endDate);
$event->setStartTime($eventJSON->startTime);
$event->setEndTime($eventJSON->endTime);
$event->setAudienceNumber($eventJSON->audience);

echo $event->isValid($hallId);