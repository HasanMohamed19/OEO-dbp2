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
    private $audience;
    
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

    public function getAudience() {
        return $this->audience;
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

    public function setAudience($audience) {
        $this->audience = $audience;
    }


}
