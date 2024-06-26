<?php

include_once '../helpers/Database.php';
include_once './Event.php';
include_once 'Hall.php';
include_once 'MenuItem.php';
include_once 'ReservationMenuItem.php';

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
//        ($data);
        $this->initWith($data->reservation_id, $data->hall_id, $data->client_id, $data->event_id, $data->notes, $data->reservation_status_id, $data->reservation_date);
    }

    
    // gets all reservation for admins
    public function getAllReservations($start, $end) {
        $db = Database::getInstance();
        
         if ($start == 1){
            $start = 0;
        } else {
           $start = $start * $end - $end; 
        }
        
//        $start *= $end;
        
        $q = "
        SELECT r.reservation_id,
       r.reservation_status_id,
       h.hall_name,
       e.event_name,
       e.start_date,
       e.end_date,
       e.start_time,
       e.end_time,
       c.client_id,
       c.phone_number,
       rs.status_name,
       (
           SELECT i2.catering_cost + i2.hall_cost
           FROM dbProj_Invoice i2
           WHERE i2.reservation_id = r.reservation_id
           ORDER BY i2.issue_date DESC
           LIMIT 1
       ) AS 'totalCost'
FROM dbProj_Reservation r
JOIN dbProj_Hall h ON r.hall_id = h.hall_id
JOIN dbProj_Event e ON r.event_id = e.event_id
JOIN dbProj_Client c ON r.client_id = c.client_id
JOIN dbProj_Reservation_Status rs ON r.reservation_status_id = rs.reservation_status_id
        ";

        if (isset($start)) {
            $q .= ' limit ' . $start . ',' . $end;
        }
//        echo "query is: " . $q;
        $data = $db->multiFetch($q);
        return $data;
    }

    // gets reservation for clients
    function getReservationsForClient($start,$end) {
        $db = Database::getInstance();
        $start = $start * $end - $end; 
        
        
//        $start *= $end;
        
        $q = "
        SELECT r.reservation_id,
       r.reservation_status_id,
       h.hall_name,
       e.event_name,
       e.start_date,
       e.end_date,
       e.start_time,
       e.end_time,
       c.client_id,
       c.phone_number,
       rs.status_name,
       (
           SELECT i2.catering_cost + i2.hall_cost
           FROM dbProj_Invoice i2
           WHERE i2.reservation_id = r.reservation_id
           ORDER BY i2.issue_date DESC
           LIMIT 1
       ) AS 'totalCost'
FROM dbProj_Reservation r
JOIN dbProj_Hall h ON r.hall_id = h.hall_id
JOIN dbProj_Event e ON r.event_id = e.event_id
JOIN dbProj_Client c ON r.client_id = c.client_id
JOIN dbProj_Reservation_Status rs ON r.reservation_status_id = rs.reservation_status_id
WHERE r.client_id = " . $this->clientId;

        if (isset($start)) {
            $q .= ' limit ' . $start . ',' . $end;
        }
//        echo "query is: " . $q;
        $data = $db->multiFetch($q);
        return $data;
    }
    
    // used for admin reservations pagination
    public static function countAllReservations() {
        $db = Database::getInstance();
        $q = "
        SELECT r.reservation_id,
       r.reservation_status_id,
       h.hall_name,
       e.event_name,
       e.start_date,
       e.end_date,
       e.start_time,
       e.end_time,
       c.client_id,
       c.phone_number,
       rs.status_name,
       (
           SELECT i2.catering_cost + i2.hall_cost
           FROM dbProj_Invoice i2
           WHERE i2.reservation_id = r.reservation_id
           ORDER BY i2.issue_date DESC
           LIMIT 1
       ) AS 'totalCost'
FROM dbProj_Reservation r
JOIN dbProj_Hall h ON r.hall_id = h.hall_id
JOIN dbProj_Event e ON r.event_id = e.event_id
JOIN dbProj_Client c ON r.client_id = c.client_id
JOIN dbProj_Reservation_Status rs ON r.reservation_status_id = rs.reservation_status_id
        ";
        $dataCount = $db->getRows($q);
        return $dataCount;
//        echo $dataCount . ' datacount found is';
    }
    
    // this will create the reservations table
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
                    <th>Event Name</th>
                    <th>Client Name</th>
                    <th>Status</th>
                    <th>Total</th>
                </tr>
            </thead>

            <tbody>
            ';

        // now populate table
        for ($i = 0; $i < count($dataset); $i++) {

            $client = new Client();
            $rp = $client->hasPersonalDeatils($dataset[$i]->client_id);

            $details = ($rp == 1) ? $client->getPersonalDeatils($dataset[$i]->client_id) : $client->getCompanyDetails($dataset[$i]->client_id);
            echo '<tr class="booking">
                    <th scope="row"><a class="text-decoration-none" href="booking_detail.php?reservationId=' . $dataset[$i]->reservation_id . '" </a>' . $dataset[$i]->reservation_id .'</th>
                    <td>' . $dataset[$i]->start_date . '</td>
                    <td>' . $dataset[$i]->end_date . '</td>
                    <td>' . $dataset[$i]->start_time . '</td>
                    <td>' . $dataset[$i]->end_time . '</td>
                    <td>' . $dataset[$i]->hall_name . '</td>
                    <td>' . $dataset[$i]->event_name . '</td>';
            if ($rp == 1) {
                echo '<td>' . $details->first_name . " " . $details->last_name . '</td>';
            } else {
                echo '<td>' . $details->company_name . '</td>';
            }

            echo '
                    <td>' . $dataset[$i]->status_name . '</td>
                    <td>' . $dataset[$i]->totalCost . '</td>

                </tr>';

        }

        echo '</tbody>'
        . '</table>';
    }

    // this method will be used for pagination for client reservations
    public static function countReservationsForClient($clientId) {
        $db = Database::getInstance();
        $q = 'SELECT r.reservation_id,
            r.reservation_status_id,
            r.notes,
            r.reservation_date,
            h.hall_name,
            h.capacity,
            e.event_name,
            e.start_date,
            e.end_date,
            e.start_time,
            e.end_time,
            c.phone_number,
            i.hall_cost + i.catering_cost AS "TotalCost"
            FROM dbProj_Reservation r
            JOIN dbProj_Hall h ON r.hall_id = h.hall_id
            JOIN dbProj_Event e ON r.event_id = e.event_id
            JOIN dbProj_Client c ON r.client_id = c.client_id
            JOIN dbProj_Invoice i ON r.reservation_id = i.reservation_id
            WHERE r.client_id = ' . $clientId;
        
        $dataCount = $db->getRows($q);
//        echo $dataCount . ' is data count';
        return $dataCount;
        
    }
    
    // gets reservation details
    function getReservationDetails() {
        $db = Database::getInstance();
        $data = $db->singleFetch("SELECT r.reservation_id,
            r.reservation_status_id,
            r.notes,
            r.reservation_date,
            h.hall_id,
            h.hall_name,
            h.capacity,
            e.event_id,
            e.event_name,
            e.start_date,
            e.end_date,
            e.start_time,
            e.end_time,
            e.audience_number,
            c.phone_number,
            i.invoice_id,
            i.hall_cost + i.catering_cost AS 'TotalCost'
            FROM dbProj_Reservation r
            JOIN dbProj_Hall h ON r.hall_id = h.hall_id
            JOIN dbProj_Event e ON r.event_id = e.event_id
            JOIN dbProj_Client c ON r.client_id = c.client_id
            JOIN dbProj_Invoice i ON r.reservation_id = i.reservation_id
            WHERE r.reservation_id = " . $this->reservationId . " ORDER BY i.invoice_id DESC LIMIT 1");
//        ($data);
        return $data;
    }



    
    // displays client reservations
     public function displayClientReservations($dataSet) {
        if (empty($dataSet)) {
            echo '<h1 class="text-center">No reservations were found.</h1>';
        }

        for ($i = 0; $i < count($dataSet); $i++) {
            $reservation = new Reservation();
            $hall = new Hall();
            $event = new Event();

//            $reservation->setClientId('1');
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
            echo '<td>' . $dataSet[$i]->totalCost . '</td>';
            echo '</tr>';
        }
    }
    
    // displays reservation menu items
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
//        ($data);
        return $data;
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

        if ($this->reservationId == null || $this->reservationId <=0) {
            $q = 'CALL InsertReservation(?,?,?,?,?,?,?,?,?,@res_id)';
        } else {
            $q = 'CALL updateReservation(?,?,?,?,?,?,?,?)';
        }

        $stmt = mysqli_prepare($db->getDatabase(),$q);
//        ($stmt);
        if (!$stmt) {
            $db->displayError($q);
            return false;
        }
        
        if ($this->reservationId == null || $this->reservationId <=0) {
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
            $stmt->bind_param('isssssis',
                $this->reservationId,
                $event->getName(),
                $event->getStartDate(),
                $event->getEndDate(),
                $event->getStartTime(),
                $event->getEndTime(),
                $event->getAudienceNumber(),
                $this->notes
            );
        }
        if (!$stmt->execute()) {
            ($stmt);
            echo 'Execute failed';
            $db->displayError($q);
            return false;
        }
        if ($this->reservationId == null || $this->reservationId <=0) {
            // get reservation id from OUT parameter
            $res = $db->singleFetch("SELECT @res_id as res_id");
    //        ($res);
            $this->reservationId = $res->res_id;
        }
        
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
