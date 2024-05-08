<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

/**
 * Description of Event
 *
 * @author Hassan
 */
class Event {
    
    private $eventId;
    private $name;
    private $startDate;
    private $endDate;
    private $audienceNumber;
    private $startTime;
    private $endTime;
    
    public function __construct() {
        $this->eventId = null;
        $this->name = null;
        $this->startDate = null;
        $this->endDate = null;
        $this->audienceNumber = null;
        $this->startTime = null;
        $this->endTime = null;
    }
    
    public function initWith($eventId, $name, $startDate, $endDate, $audienceNumber, $startTime, $endTime) {
        $this->eventId = $eventId;
        $this->name = $name;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->audienceNumber = $audienceNumber;
        $this->startTime = $startTime;
        $this->endTime = $endTime;
    }
    
    public function initWithEventId($eventId) {
        $db = Database::getInstance();
        $data = $db->singleFetch('SELECT * FROM dbProj_Event WHERE event_id = ' . $eventId);
        $this->initWith($data->event_Id, $data->event_name, $data->start_date, $data->end_date, $data->audience_number, $data->start_time, $data->end_time);
    }
    
    public function getEventId() {
        return $this->eventId;
    }

    public function getName() {
        return $this->name;
    }

    public function getStartDate() {
        return $this->startDate;
    }

    public function getEndDate() {
        return $this->endDate;
    }

    public function getAudienceNumber() {
        return $this->audienceNumber;
    }

    public function setEventId($eventId) {
        $this->eventId = $eventId;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function setStartDate($startDate) {
        $this->startDate = $startDate;
    }

    public function setEndDate($endDate) {
        $this->endDate = $endDate;
    }

    public function setAudienceNumber($audienceNumber) {
        $this->audienceNumber = $audienceNumber;
    }
    
    public function getStartTime() {
        return $this->startTime;
    }

    public function getEndTime() {
        return $this->endTime;
    }

    public function setStartTime($startTime) {
        $this->startTime = $startTime;
    }

    public function setEndTime($endTime){
        $this->endTime = $endTime;
    }




}
