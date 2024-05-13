<?php

include '../debugging.php';
include_once '../models/Event.php';

$eventJSON = json_decode($_POST['event']);
$event = new Event();
$event->setName($eventJSON->eventName);
$event->setStartDate($eventJSON->startDate);
$event->setEndDate($eventJSON->endDate);
$event->setStartTime($eventJSON->startTime);
$event->setEndTime($eventJSON->endTime);
$event->setAudienceNumber($eventJSON->audience);

echo $event->isValid();