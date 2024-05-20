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
include_once 'Hall.php';
include_once 'Event.php';
include_once 'MenuItem.php';
include_once 'ReservationMenuItem.php';
include_once '../helpers/Database.php';

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
        $this->reservationDate = null;
    }

    public function initReservationWithId($reservationId) {
        $db = Database::getInstance();
        $data = $db->singleFetch('SELECT * FROM dbProj_Reservation WHERE reservation_id = ' . $reservationId);
//        var_dump($data);
        $this->initWith($data->reservation_id, $data->hall_id, $data->client_id, $data->event_id, $data->notes, $data->reservation_status_id, $data->reservation_date);
    }

    function getReservationsForClient() {
        $db = Database::getInstance();
        $data = $db->multiFetch("SELECT r.reservation_id,
            r.reservation_status_id,
            r.notes,
            r.reservation_date,
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

    function getReservationDetails() {
        $db = Database::getInstance();
        $data = $db->singleFetch("SELECT r.reservation_id,
            r.reservation_status_id,
            r.notes,
            r.reservation_date,
            h.hall_id,
            h.hall_name,
            h.capacity,
            h.image_path,
            e.event_name,
            e.start_date,
            e.end_date,
            e.start_time,
            e.end_time,
            e.audience_number,
            c.phone_number
            FROM dbProj_Reservation r
            JOIN dbProj_Hall h ON r.hall_id = h.hall_id
            JOIN dbProj_Event e ON r.event_id = e.event_id
            JOIN dbProj_Client c ON r.client_id = c.client_id
            WHERE r.reservation_id = " . $this->reservationId);
//        var_dump($data);
        return $data;
    }

    public function displayClientReservations($dataSet) {
        if (empty($dataSet)) {
            echo 'nothing found';
        }

        for ($i = 0; $i < count($dataSet); $i++) {
            $reservation = new Reservation();
            $hall = new Hall();
            $event = new Event();

            $reservation->setClientId('1');
            $reservationId = $dataSet[$i]->reservation_id;
            $reservation->initReservationWithId($reservationId);
            $hall->setHallId($reservation->hallId);
            $event->setEventId($reservation->eventId);

            $hall->initWithHallId($hall->getHallId());
            $event->initWithEventId($event->getEventId());

            echo '<tr class="text-center">';
            echo '<th scope="row" class="text-center"><a class="text-decoration-none" href="booking_detail.php?reservationId=' . $reservation->getReservationId() . '">' . $reservation->getReservationId() . ' </a>';

            echo '<td>' . Reservation::getStatusName($reservation->getStatusId()) . '</td>';
            echo '<td>' . $reservation->getReservationDate() . '</td>';
            echo '<td>' . $event->getName() . '</td>';
            echo '<td>' . $hall->getHallName() . '</td>';
            echo '<td>' . 101010 . '</td>';

            echo '</tr>';
        }
    }

    public function displayReservationMenuItems($dataSet) {
        if (empty($dataSet)) {
            echo 'nothing found';
        }


        // additional services section
        for ($i = 0; $i < count($dataSet); $i++) {
            $menuItem = new MenuItem();
            $menuItemId = $dataSet[$i]->item_id;
            $menuItem->setItemId($menuItemId);
            $menuItem->initMenuItemWithId();
            echo '
                    <div class="card p-0 m-2 cateringItem">
                                    <img class="card-img-top img-fluid" src="' . $menuItem->getImagePath() . '">
                                    <div class="card-body">
                                        <h3 class="card-title text-center fs-5">' . $menuItem->getName() . '</h3>
                                        <p class="card-text text-center"><strong>' . $menuItem->getPrice() . ' BHD x ' . $dataSet[$i]->quantity . '</strong></p>
                                    </div>
                   </div>';
        }
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
                    <img src="' . $hall->getImagePath() . ' " alt="" class="img-fluid rounded">
                  </div>';

            echo '<div class="col-xl-5 p-2 flex-grow-1">
                    <div class="row m-2">
                        <div class="col text-start completed">' . $reservation->getReservationId() . '</div>
                        <div class="col text-end"><button class="btn btn-danger">Cancel Booking</button></div>
                  </div>';

            echo '<div class="row m-2">
                        <span class="col text-start text-secondary">Hall Name: </span>
                        <span class="col text-start">' . $hall->getHallName() . '</span>
                  </div>';

            echo '<div class="row m-2">
                    <span class="col text-start text-secondary">Event Name: </span>
                    <span class="col text-start">' . $event->getName() . '</span>
                  </div>';

            echo '<div class="row m-2">
                    <span class="col text-start text-secondary">Start Date: </span>
                    <span class="col text-start">' . $event->getStartDate() . '</span>
                 </div>';

            echo '<div class="row m-2">
                    <span class="col text-start text-secondary">End Date: </span>
                    <span class="col text-start">' . $event->getEndDate() . '</span>
                 </div>';

            echo '<div class="row m-2">
                    <span class="col text-start text-secondary">Daily Start Time: </span>
                    <span class="col text-start">' . $event->getStartTime() . '</span>
                 </div>';

            echo '<div class="row m-2">
                    <span class="col text-start text-secondary">Daily End Time: </span>
                    <span class="col text-start">' . $event->getEndTime() . '</span>
                 </div>';

            echo '<div class="row m-2">
                    <span class="col text-start text-secondary">No. Audiences </span>
                    <span class="col text-start">' . $event->getAudienceNumber() . '</span>
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

    public function getAdditionalServicesForReservation($reservationId) {
        $db = Database::getInstance();
        $data = $db->multiFetch("SELECT 
             m.item_id,
            m.name,
            m.image_path,
            m.price,
            rm.reservation_id,
            rm.quantity
            FROM dbProj_Menu_Item m
            JOIN dbProj_Reservation_Menu_Item rm ON rm.item_id = m.item_id
            JOIN dbProj_Reservation r ON rm.reservation_id = r.reservation_id
            WHERE r.reservation_id =" . $reservationId);
//        var_dump($data);
        return $data;
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

    static function getStatusName($statusId) {
        switch ($statusId) {
            case 1:
                return 'Completed';
                break;

            case 2:
                return 'Canceled';
                break;

            case 3:
                return 'In Progress';
                break;

            case 4:
                return 'Booked';
                break;
        }
    }

    function cancelReservation($reservationId) {
        $db = new Database();
        $q = "UPDATE dbProj_Reservation r SET r.reservation_status_id = 2 WHERE r.reservation_id = " . $reservationId;
        $data = $db->querySQL($q);
    }

    function getHallReservations($hallId) {
        $db = Database::getInstance();
        $data = $db->multiFetch("SELECT * FROM  dbProj_Reservation WHERE hall_id = ".$hallId ." AND reservation_status_id != 2");
        return $data;
    }
}
