<?php

include_once '../helpers/Database.php';
include_once './Event.php';

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

/**
 * Description of Reservation
 *
 * @author Hassan
 */



const RESERVATION_RESERVED = 4;
const RESERVATION_COMPLETE = 1;
const RESERVATION_PENDING_PAYMENT = 3; // if reservation has completed but not paid in full
const RESERVATION_CANCELLED = 2;

class Reservation {
    
    private $reservationId;
    private $hallId;
    private $clientId;
    private $eventId;
    private $notes;
    private $price;
    private $statusId;
    
    public function initWith($reservationId, $hallId, $clientId, $eventId, $notes, $price, $statusId) {
        $this->reservationId = $reservationId;
        $this->hallId = $hallId;
        $this->clientId = $clientId;
        $this->eventId = $eventId;
        $this->notes = $notes;
        $this->price = $price;
        $this->statusId = $statusId;
    }

    public function __construct() {
        $this->reservationId = null;
        $this->hallId = null;
        $this->clientId = null;
        $this->eventId = null;
        $this->notes = null;
        $this->price = null;
        $this->statusId = null;
    }
    
    public function saveReservation(Event $event) {
        $db = new Database();
        if (!$this->isValid()) {
            return false;
        }
//                    echo "username $this->username, password $this->password";
        $event->setName($db->sanitizeString($event->getName()));
        $event->setStartDate($db->sanitizeString($event->getStartDate()));
        $event->setEndDate($db->sanitizeString($event->getEndDate()));
        $event->setStartTime($db->sanitizeString($event->getStartTime()));
        $event->setEndTime($db->sanitizeString($event->getEndTime()));
        $this->notes = $db->sanitizeString($this->notes);

        if ($this->reservationId == null) {
            $q = 'CALL InsertReservation(?,?,?,?,?,?,?,?,?,@res_id)';
        } else {
            // update query
//                $q = 
        }

        $stmt = mysqli_prepare($db->getDatabase(),$q);
//        var_dump($stmt);
        if (!$stmt) {
            $db->displayError($q);
            return false;
        }
        
        if ($this->reservationId == null) {
            $stmt->bind_param('iisssssis',
                $this->clientId,
                $this->hallId,
                $event->getName(),
                $event->getStartDate(),
                $event->getEndDate(),
                $event->getStartTime(),
                $event->getEndTime(),
                $event->getAudienceNumber(),
                $this->notes
            );
        } else {
            // update query bindings
//                    $stmt->bind_param('sssi', $this->username, $this->password, $this->email, $this->userId);
        }
        if (!$stmt->execute()) {
            var_dump($stmt);
            echo 'Execute failed';
            $db->displayError($q);
            return false;
        }
        // get reservation id from OUT parameter
        $res = $db->singleFetch("SELECT @res_id as res_id");
//        var_dump($res);
        $this->reservationId = $res->res_id;
        
        return true;
    }
    
    public function isValid() {
        if ($this->clientId <= 0) {
            return false;
        }
        if ($this->hallId <= 0) {
            return false;
        }
        return true;
    }
    
    public function getReservationId() {
        return $this->reservationId;
    }

    public function getHallId() {
        return $this->hallId;
    }

    public function getClientId() {
        return $this->clientId;
    }

    public function getEventId() {
        return $this->eventId;
    }
    
    public function getNotes() {
        return $this->notes;
    }
    
    public function getPrice() {
        return $this->price;
    }
    
    public function getStatusId() {
        return $this->statusId;
    }

    public function setReservationId($reservationId) {
        $this->reservationId = $reservationId;
    }

    public function setHallId($hallId) {
        $this->hallId = $hallId;
    }

    public function setClientId($clientId) {
        $this->clientId = $clientId;
    }

    public function setEventId($eventId) {
        $this->eventId = $eventId;
    }
    
    public function setNotes($notes) {
        $this->notes = $notes;
    }
    
    public function setPrice($price) {
        $this->price = $price;
    }
    
    public function setStatusId($statusId): void {
        $this->statusId = $statusId;
    }
}
