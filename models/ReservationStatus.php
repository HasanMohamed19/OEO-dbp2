<?php

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
?>
