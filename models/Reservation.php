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

//include 'Client.php';
include 'Hall.php';
include 'Event.php';


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
//    private $price;
    private $statusId;
    private $reservationDate;
    
    public function initWith($reservationId, $hallId, $clientId, $eventId, $notes, $statusId, $reservationDate) {
        $this->reservationId = $reservationId;
        $this->hallId = $hallId;
        $this->clientId = $clientId;
        $this->eventId = $eventId;
        $this->notes = $notes;
//        $this->price = $price;
        $this->statusId = $statusId;
        $this->reservationDate = $reservationDate;
    }

    public function __construct() {
        $this->reservationId = null;
        $this->hallId = null;
        $this->clientId = null;
        $this->eventId = null;
        $this->notes = null;
        $this->price = null;
        $this->statusId = null;
        $this->$reservationDate = null;
    }
    
    public function initReservationWithId($reservationId) {
        $db = Database::getInstance();
        $data = $db->singleFetch('SELECT * FROM dbProj_Reservation WHERE reservation_id = ' . $reservationId);
        $this->initWith($data->reservation_id, $data->hall_id, $data->client_id, $data->event_id, $data->notes, $data->reservation_status_id, $data->reservation_date);
    }
    
    function getReservationsForClient() {
        $db = Database::getInstance();
        $data = $db->multiFetch("SELECT r.reservation_id,
            r.reservation_status_id,
            r.notes,
            r.reservation_date
            h.hall_name,
            h.capacity,
            h.image_path,
            e.event_name,
            e.start_date,
            e.end_date,
            e.start_time,
            e.end_time,
            c.phone_number
            FROM dbProj_Reservation r
            JOIN dbProj_Hall h ON r.hall_id = h.hall_id
            JOIN dbProj_Event e ON r.event_id = e.event_id
            JOIN dbProj_Client c ON r.client_id = c.client_id
            WHERE r.client_id = " . $this->clientId);
        return $data;
    }
    
    public function displayUserReservations($dataSet) {
        if (empty($dataSet)) {
            return;
        }
        
        for ($i = 0; $i < count($dataSet); $i++) {
            $reservation = new Reservation();
            $hall = new Hall();
            $event = new Event();
            $client = new Client();
            
             // todo: get this from the login
            $reservation->setClientId('1');
            $reservationId = $dataSet[$i]->reservation_id;
            $reservation->initReservationWithId($reservationId);
            $hall->setHallId($reservation->hallId);
            $event->setEventId($reservation->eventId);
            $client->setClientId($reservation->clientId);
            
            $client->iniwWithClientId($client->getClientId());
            $hall->initWithHallId($hall->getHallId());
            $event->initWithEventId($event->getEventId());
            
            echo 'image path was ' . $hall->getCapacity() . ' image path was';
                // display the header
            echo '<div class="row justify-content-between mx-3 mt-2">
                                <div class="col">Booking#: ' . $reservation->getReservationId() . '</div>
                                <div class="col text-secondary text-center">random date</div>
                                <div class="col text-end">random price</div>
                  </div>';

            echo ' <hr>'
            . '<div class="card mb-2 border-0 mx-3">'
                    . '<div class="row g-0">';

            // image
            echo '<div class="col-xl-5 p-2">
                    <img src="' . $hall->getImagePath() .' " alt="" class="img-fluid rounded">
                  </div>';

            echo '<div class="col-xl-5 p-2 flex-grow-1">
                    <div class="row m-2">
                        <div class="col text-start completed">' . $reservation->getReservationId() . '</div>
                        <div class="col text-end"><button class="btn btn-danger">Cancel Booking</button></div>
                  </div>';

            echo '<div class="row m-2">
                        <span class="col text-start text-secondary">Hall Name: </span>
                        <span class="col text-start">'. $hall->getHallName() .'</span>
                  </div>';

            echo '<div class="row m-2">
                    <span class="col text-start text-secondary">Event Name: </span>
                    <span class="col text-start">'. $event->getName() .'</span>
                  </div>';

            echo '<div class="row m-2">
                    <span class="col text-start text-secondary">Start Date: </span>
                    <span class="col text-start">' . $event->getStartDate() .'</span>
                 </div>';

            echo '<div class="row m-2">
                    <span class="col text-start text-secondary">End Date: </span>
                    <span class="col text-start">' . $event->getEndDate() .'</span>
                 </div>';

            echo '<div class="row m-2">
                    <span class="col text-start text-secondary">Daily Start Time: </span>
                    <span class="col text-start">' . $event->getStartTime() .'</span>
                 </div>';

            echo '<div class="row m-2">
                    <span class="col text-start text-secondary">Daily End Time: </span>
                    <span class="col text-start">' . $event->getEndTime() .'</span>
                 </div>';

            echo '<div class="row m-2">
                    <span class="col text-start text-secondary">No. Audiences </span>
                    <span class="col text-start">' . $event->getAudienceNumber() .'</span>
                  </div>
                </div>
              </div>';

            // notes section
            echo '<div class="row mx-1">
                    <span class="text-secondary">Notes: </span>
                    <p class="justify">' . $hall->getDescription() . '</p>
                  </div>';
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
    
    public function getReservationDate() {
        return $this->reservationDate;
    }

    public function setReservationDate($reservationDate): void {
        $this->reservationDate = $reservationDate;
    }


}
