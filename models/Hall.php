<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

/**
 * Description of Hall
 *
 * @author Hassan
 */
include_once '../helpers/Database.php';
include_once 'models/HallImage.php';

//hall status

const AVAILABLE_STATUS = 1;
const CANCELLED_STATUS = 2;

class Hall {

    private $hallId;
    private $hallName;
    private $description;
    private $rentalCharge;
    private $capacity;
//    private $imagePath;
//    private $images;
    private $hallStatus;
    private $deletedImages;

    public function __construct() {
        $this->hallId = null;
        $this->hallName = null;
        $this->description = null;
        $this->rentalCharge = null;
        $this->capacity = null;
        $this->hallStatus = null;
//        $this->imagePath = null;
//        $this->images = [];
        $this->deletedImages = [];
    }

    public function initWith($hallId, $hallName, $description, $rentalCharge, $capacity, $hallStatus) {
        $this->hallId = $hallId;
        $this->hallName = $hallName;
        $this->description = $description;
        $this->rentalCharge = $rentalCharge;
        $this->capacity = $capacity;
        $this->hallStatus = $hallStatus;
//        $this->imagePath = $imagePath;
    }

    public function initWithHallid($id) {
        $db = Database::getInstance();
        $data = $db->singleFetch('SELECT * FROM dbProj_Hall WHERE hall_id = ' . $id);
        $this->initWith($data->hall_id, $data->hall_name, $data->description, $data->rental_charge, $data->capacity, $data->hall_status_id);
//        $hallImages = $db->multiFetch('Select * from dbProj_Hall_Image where hall_id ='.$id);
//        for ($i=0;$i<count($hallImages);$i++){
//            $this->images = $hallImages[$i]->hall_image_path;
//        }
    }

    public function getHallId() {
        return $this->hallId;
    }

    public function getHallName() {
        return $this->hallName;
    }

    public function getDescription() {
        return $this->description;
    }

    public function getRentalCharge() {
        return $this->rentalCharge;
    }

    public function getCapacity() {
        return $this->capacity;
    }

//    public function getImagePath() {
//        return $this->imagePath;
//    }
    public function getHallStatus() {
        return $this->hallStatus;
    }

    public function setHallId($hallId) {
        $this->hallId = $hallId;
    }

    public function setHallName($hallName) {
        $this->hallName = $hallName;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    public function setRentalCharge($rentalCharge) {
        $this->rentalCharge = $rentalCharge;
    }

    public function setCapacity($capacity) {
        $this->capacity = $capacity;
    }

    public function setHallStatus($hallStatus) {
        echo 'set hall status to ' . $hallStatus;
        $this->hallStatus = $hallStatus;
    }

//    public function setImagePath($imagePath) {
//        $this->imagePath = $imagePath;
//    }

    public function addHallImages($hallImages) {
        for ($i = 0; $i < count($hallImages); $i++) {
            $hallImg = new HallImage();
            $hallImg->setHall_id($this->hallId);
            echo'<h1>Hall id is</h1>' . $this->hallId;
            $hallImg->setHallImagePath($hallImages[$i]);
            $hallImg->addHallImage();
        }
    }

    function getAllHalls() {
        $db = Database::getInstance();
        // get only active halls
        $data = $db->multiFetch('Select * from dbProj_Hall WHERE hall_status_id != 2');
        return $data;
    }

    function getHallsBySearch($search) {
        $db = new Database();
        $searhTerm = $db->sanitizeString($search);
        $q = "SELECT * FROM dbProj_Hall WHERE hall_status_id != 2 AND MATCH(hall_name, description) against (?)";

        $stmt = mysqli_prepare($db->getDatabase(), $q);

        if (!$stmt) {
            $db->displayError($q);
            return false;
        }
        $stmt->bind_param('s', $searhTerm);
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
        return $data;
    }

    function addHall() {
        $db = new Database();
        if ($this->isValid()) {
            $this->hallName = $db->sanitizeString($this->hallName);
            $this->description = $db->sanitizeString($this->description);
            $this->rentalCharge = $db->sanitizeString($this->rentalCharge);
            $this->capacity = $db->sanitizeString($this->capacity);
//            $this->imagePath = $db->sanitizeString($this->imagePath);
            $this->hallStatus = $db->sanitizeString($this->hallStatus);

            $q = "INSERT INTO dbProj_Hall(hall_name,description,rental_charge,capacity,hall_status_id) VALUES(?,?,?,?,?)";

            $stmt = mysqli_prepare($db->getDatabase(), $q);

            if ($stmt) {
                $stmt->bind_param('ssdii', $this->hallName, $this->description, $this->rentalCharge, $this->capacity, $this->hallStatus);
                if (!$stmt->execute()) {
                    var_dump($stmt);
                    echo 'Execute failed';
                    $db->displayError($q);
                    return false;
                }
            } else {
                $db->displayError($q);
                return false;
            }
            $this->hallId = $db->singleFetch("SELECT hall_id FROM dbProj_Hall WHERE hall_name = '" . $this->hallName . '\'')->hall_id;
            return true;
        } else {
            echo'invalid inputs';
            return false;
        }
    }

    function deleteHall() {
        $db = new Database();
        $this->hallId = $db->sanitizeString($this->hallId);
        $q = "Delete from dbProj_Hall where hall_id=?";
        $stmt = mysqli_prepare($db->getDatabase(), $q);

        if ($stmt) {
            $stmt->bind_param('i', $this->hallId);
            if (!$stmt->execute()) {
                var_dump($stmt);
                echo 'Execute failed';
                $db->displayError($q);
                return false;
            }
        } else {
            $db->displayError($q);
            return false;
        }
        return true;
    }

    function updateHall() {
        $db = new Database();
        if ($this->isValid()) {
            $this->hallId = $db->sanitizeString($this->hallId);
            $this->hallName = $db->sanitizeString($this->hallName);
            $this->description = $db->sanitizeString($this->description);
            $this->rentalCharge = $db->sanitizeString($this->rentalCharge);
            $this->capacity = $db->sanitizeString($this->capacity);
            $this->hallStatus = $db->sanitizeString($this->hallStatus);
            $q = "UPDATE dbProj_Hall set hall_name = ? ,description = ?  ,rental_charge = ? ,capacity = ?, hall_status_id = ? WHERE hall_id = ? ";

            $stmt = mysqli_prepare($db->getDatabase(), $q);

            if ($stmt) {
                $stmt->bind_param('ssdiii', $this->hallName, $this->description, $this->rentalCharge, $this->capacity, $this->hallStatus, $this->hallId);
                if (!$stmt->execute()) {
                    var_dump($stmt);
                    echo 'Execute failed';
                    $db->displayError($q);
                    return false;
                }
            } else {
                $db->displayError($q);
                return false;
            }
            return true;
        } else {
            echo'invalid values :(';
        }
    }

    function getHallStatusName() {
        $db = Database::getInstance();
        $data = $db->singleFetch("SELECT status_name FROM dbProj_Availability_Status a JOIN dbProj_Hall h ON h.hall_status_id = a.availability_status_id WHERE h.hall_id = '$this->hallId'");
//       var_dump($data);
        return $data;
    }

    public function isValid() {
        $errors = array();

        if (empty($this->hallName))
            $errors[] = 'You must enter a Hall Name';

        if (empty($this->rentalCharge))
            $errors[] = 'You must enter a Rental Charge';

        if (empty($this->capacity))
            $errors[] = 'You must enter a Capacity';
        if (empty($this->hallStatus))
            $errors[] = 'You must enter a status';
        if (empty($errors))
            return true;
        else
            return false;
    }
    
    public static function getAvailableHalls($startDate, $endDate) {
        include_once './models/Event.php';
        // returns halls that are available at the selected timeframe
        $availableHalls = [];
        $h = new Hall();
        $halls = $h->getAllHalls();
        foreach ($halls as $hall) {
            $events = Event::getEventsForHall($hall->hall_id);
            $isOverlapping = false;
            foreach ($events as $event) {
                $eStartDate = $event->start_date;
                $eEndDate = $event->end_date;
                
                // check if event timeframe overlaps requested timeframe
                if (($startDate >= $eStartDate && $startDate <= $eEndDate)
                        || ($endDate >= $eStartDate && $endDate <= $eEndDate)
                        || ($eStartDate >= $startDate && $eStartDate <= $endDate)) {
                    // there is overlap, meaning hall is already booked at this time
                    $isOverlapping = true;
                    break;
                }
            }
            // if no timeframes overlap, this hall is available
            if (!$isOverlapping) {
                $availableHalls[] = $hall;
            }
        }
//        echo 'Available halls found are: ';
//        var_dump($availableHalls);
        return $availableHalls;
    }
    
}
