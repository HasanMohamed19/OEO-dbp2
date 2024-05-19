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
    
    public function initWithEventId($eventId) {
        $db = Database::getInstance();
        $data = $db->singleFetch('SELECT * FROM dbProj_Event WHERE event_id = ' . $eventId);
        $this->initWith($data->event_Id, $data->event_name, $data->start_date, $data->end_date, $data->audience_number, $data->start_time, $data->end_time);
    }
    
    public static function getEventsForHall($hallId) {
        $db = new Database();
        $hallId = $db->sanitizeString($hallId);
        $q = "SELECT * "
                . "FROM dbProj_Event e "
                . "JOIN dbProj_Reservation r ON e.event_id = r.event_id "
                . "WHERE r.hall_id = ?";

        $stmt = mysqli_prepare($db->getDatabase(), $q);

        if (!$stmt) {
            $db->displayError($q);
            return false;
        }
        $stmt->bind_param('i', $hallId);
        if (!$stmt->execute()) {
//                var_dump($stmt);
            echo 'Execute failed';
            $db->displayError($q);
            return false;
        }
        $result = $stmt->get_result();             
//        var_dump($result);
        $data = $result->fetch_all(MYSQLI_ASSOC);
//        var_dump($data);
        //returns results as array
        return $data;
    }
    
    public static function getEventsForHallSorted($hallId, $sortType, $startDate) {
        $db = new Database();
        $hallId = $db->sanitizeString($hallId);
        
        if ($sortType == 'asc') {
            $q = "SELECT * "
                    . "FROM dbProj_Event e "
                    . "JOIN dbProj_Reservation r ON e.event_id = r.event_id "
                    . "WHERE r.hall_id = ? "
                    . "AND e.end_date >= ? "
                    . "ORDER BY e.end_date ASC";
        } else {
            echo "sorting desc";
            $q = "SELECT * "
                    . "FROM dbProj_Event e "
                    . "JOIN dbProj_Reservation r ON e.event_id = r.event_id "
                    . "WHERE r.hall_id = ? "
                    . "AND e.start_date <= ? "
                    . "ORDER BY e.start_date DESC";
        }

        $stmt = mysqli_prepare($db->getDatabase(), $q);

        if (!$stmt) {
            $db->displayError($q);
            return false;
        }
        // $startDate is used to filter events before/after this date
        $stmt->bind_param('is', $hallId, $startDate);
        if (!$stmt->execute()) {
//                var_dump($stmt);
            echo 'Execute failed';
            $db->displayError($q);
            return false;
        }
        $result = $stmt->get_result();             
//        var_dump($result);
        $data = $result->fetch_all(MYSQLI_ASSOC);
//        var_dump($data);
        //returns results as array
        return $data;
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
