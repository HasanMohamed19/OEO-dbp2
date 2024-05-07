<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

/**
 * Description of Reservation
 *
 * @author Hassan
 */

class ReservationStatus {
    private $reservationStatusId;
    private $reservationStatusName;
    
    public function initWith($reservationStatusId, $reservationStatusName) {
        $this->reservationStatusId = $reservationStatusId;
        $this->reservationStatusName = $reservationStatusName;
    }
    
    public function __construct() {
        $this->reservationStatusId = null;
        $this->reservationStatusName = null;
    }
    
    public function getReservationStatusId() {
        return $this->reservationStatusId;
    }

    public function getReservationStatusName() {
        return $this->reservationStatusName;
    }

    public function setReservationStatusId($reservationStatusId) {
        $this->reservationStatusId = $reservationStatusId;
    }

    public function setReservationStatusName($reservationStatusName) {
        $this->reservationStatusName = $reservationStatusName;
    }
}

const RESERVATION_RESERVED = 0;
const RESERVATION_COMPLETE = 1;
const RESERVATION_PENDING_PAYMENT = 2; // if reservation has completed but not paid in full
const RESERVATION_CANCELLED = 3;

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
