<?php

include_once './helpers/Database.php';
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
    private $startTime;
    private $endTime;
    private $audienceNumber;
    
    public function __construct() {
        $this->eventId = null;
        $this->name = null;
        $this->startDate = null;
        $this->endDate = null;
        $this->startTime = null;
        $this->endTime = null;
        $this->audienceNumber = null;
    }
    
    public function initWith($eventId, $name, $startDate, $endDate, $startTime, $endTime, $audienceNumber) {
        $this->eventId = $eventId;
        $this->name = $name;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->startTime = $startTime;
        $this->endTime = $endTime;
        $this->audienceNumber = $audienceNumber;
    }
    
    public function addEvent() {
        if ($this->isValid()) {
            try {
                $db = Database::getInstance();
                $q = 'INSERT INTO `dbProj_Event`(`event_id`, `event_name`, `start_date`, `end_date`, `start_time`, `end_time`, `audience_number`)
                 VALUES (NULL, \'' . $this->name . '\',\'' . $this->startDate . '\',\'' . $this->endDate . '\',\'' . $this->startTime . '\',\''. $this->endTime.'\','.$this->audienceNumber.')';
                $data = $db->querySql($q);
                var_dump($q);
                $this->eventId = mysqli_insert_id($db->dblink);
                return true;
            } catch (Exception $e) {
                echo 'Exception: ' . $e;
                return false;
            }
        } else {
            return false;
        }
    }
    
    public function isValid() {
        $errors = true;

        if (empty($this->name))
            $errors = false;
        
        if (empty($this->startDate))
            $errors = false;
        
        if (empty($this->endDate))
            $errors = false;

        if (empty($this->startTime))
            $errors = false;

        if (empty($this->endTime))
            $errors = false;

        if (empty($this->audienceNumber) || $this->audienceNumber <= 0)
            $errors = false;

        return $errors;
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
    
    public function getStartTime() {
        return $this->startTime;
    }
    
    public function getEndTime() {
        return $this->endTime;
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
    
    public function setStartTime($startTime) {
        $this->startTime = $startTime;
    }
    
    public function setEndTime($endTime) {
        $this->endTime = $endTime;
    }

    public function setEndDate($endDate) {
        $this->endDate = $endDate;
    }

    public function setAudienceNumber($audienceNumber) {
        $this->audienceNumber = $audienceNumber;
    }


}
