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
//        var_dump($data);
        $this->initWith($data->reservation_id, $data->hall_id, $data->client_id, $data->event_id, $data->notes, $data->reservation_status_id, $data->reservation_date);
    }
    

    public function getAllReservations($start, $end) {
        $db = Database::getInstance();
        
         if ($start == 1){
            $start = 0;
        } else {
           $start = $start * $end - $end; 
        }
        
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
        i.catering_cost + i.hall_cost AS 'totalCost'
        FROM dbProj_Reservation r
        JOIN dbProj_Hall h ON r.hall_id = h.hall_id
        JOIN dbProj_Event e ON r.event_id = e.event_id
        JOIN dbProj_Client c ON r.client_id = c.client_id
        JOIN dbProj_Invoice i ON r.reservation_id = i.reservation_id
        JOIN dbProj_Reservation_Status rs ON r.reservation_status_id = rs.reservation_status_id
        ";

        if (isset($start)) {
            $q .= ' limit ' . $start . ',' . $end;
        }

        $data = $db->multiFetch($q);
        return $data;
    }
    
    public static function countAllReservations() {
        $db = Database::getInstance();
        $q = "SELECT r.reservation_id,
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
        i.catering_cost + i.hall_cost AS 'totalCost'
        FROM dbProj_Reservation r
        JOIN dbProj_Hall h ON r.hall_id = h.hall_id
        JOIN dbProj_Event e ON r.event_id = e.event_id
        JOIN dbProj_Client c ON r.client_id = c.client_id
        JOIN dbProj_Invoice i ON r.reservation_id = i.reservation_id
        JOIN dbProj_Reservation_Status rs ON r.reservation_status_id = rs.reservation_status_id";
        $dataCount = $db->getRows($q);
        return $dataCount;
//        echo $dataCount . ' datacount found is';
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
                    <td scope="row">' . $dataset[$i]->reservation_id . '</td>
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

    function getReservationsForClient($start, $end) {
        $db = Database::getInstance();
        
         if ($start == 1){
            $start = 0;
        } else {
           $start = $start * $end - $end; 
        }
        
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
            WHERE r.client_id = ' . $this->clientId;

        if (isset($start)) {
            $q .= ' limit ' . $start . ', ' . $end;
        }

        $data = $db->multiFetch($q);

//        var_dump($data);
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
            echo '<td>' . $dataSet[$i]->TotalCost . '</td>';
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

//        public function getAdditionalServicesForReservation($reservationId) { 
//        $db = Database::getInstance();
//        $data = $db->multiFetch("SELECT 
//             m.item_id,
//            m.name,
//            m.image_path,
//            m.price,
//            rm.reservation_id,
//            rm.quantity
//            FROM dbProj_Menu_Item m
//            JOIN dbProj_Reservation_Menu_Item rm ON rm.item_id = m.item_id
//            JOIN dbProj_Reservation r ON rm.reservation_id = r.reservation_id
//            WHERE r.reservation_id =" . $reservationId);
////        var_dump($data);
//        return $data;
//    }

    

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
//        var_dump($stmt);
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
            var_dump($stmt);
            echo 'Execute failed';
            $db->displayError($q);
            return false;
        }
        if ($this->reservationId == null || $this->reservationId <=0) {
            // get reservation id from OUT parameter
            $res = $db->singleFetch("SELECT @res_id as res_id");
    //        var_dump($res);
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

}
