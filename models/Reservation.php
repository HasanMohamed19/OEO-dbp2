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
class Reservation {
    
    private $reservationId;
    private $hallId;
    private $clientId;
    private $eventId;
    
    public function initWith($reservationId, $hallId, $clientId, $eventId) {
        $this->reservationId = $reservationId;
        $this->hallId = $hallId;
        $this->clientId = $clientId;
        $this->eventId = $eventId;
    }

    public function __construct() {
        $this->reservationId = null;
        $this->hallId = null;
        $this->clientId = null;
        $this->eventId = null;
    }

    public function getAllReservations() {
        $db = Database::getInstance();
        $data = $db->multiFetch("
        SELECT r.reservation_id,
        r.reservation_status_id,
        h.hall_name,
        e.event_name,
        e.start_date,
        e.end_date,
        e.start_time,
        e.end_time,
        c.phone_number
        FROM dbProj_Reservation r
        INNER JOIN dbProj_Hall h ON r.hall_id = h.hall_id
        INNER JOIN dbProj_Event e ON r.event_id = e.event_id
        INNER JOIN dbProj_Client c ON r.client_id = c.client_id;
        ");
        return $data;
    }

    public function createReservationsTable($dataset) {

        if (empty($dataset)) {
            return;
        }

        // make table header

        echo 
        ' <div class="table-responsive">
        <table id="pagination-items-bookings" class="table table-striped table-bordered border-5 align-middle text-center rounded rounded-2">
            <!-- table header -->
            <thead>
                <tr>
                    <th>Reservation ID</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Start Time</th>
                    <th>End Time</th>
                    <th>Hall Name</th>
                    <th>Client Name</th>
                    <th>Status</th>
                    <th>Total</th>
                </tr>
            </thead>

            <tbody>
            ';

            // now populate table
            for ($i=0; $i < count($dataset); $i++) { 
                echo '<tr class="booking">
                    <td scope="row">'. $dataset[$i]->reservation_id .'</td>
                    <td>'. $dataset[$i]->event_name .'</td>
                    <td>'. $dataset[$i]->start_date .'</td>
                    <td>'. $dataset[$i]->end_date .'</td>
                    <td>'. $dataset[$i]->start_time .'</td>
                    <td>'. $dataset[$i]->end_time .'</td>
                    <td>'. $dataset[$i]->phone_number .'</td>
                    <td>'. $dataset[$i]->reservation_status_id .'</td>
                    <td>'. 100 .'</td>

                </tr>';
            }

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



}
