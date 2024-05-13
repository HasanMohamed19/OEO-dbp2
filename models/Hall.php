<?php

include_once '../helpers/Database.php';

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

/**
 * Description of Hall
 *
 * @author Hassan
 */
class Hall {
    
    private $hallId;
    private $hallName;
    private $description;
    private $rentalCharge;
    private $capacity;
    private $imagePath;
    
    public function __construct() {
        $this->hallId = null;
        $this->hallName = null;
        $this->description = null;
        $this->rentalCharge = null;
        $this->capacity = null;
        $this->imagePath = null;
    }
    
    public function initWith($hallId, $hallName, $description, $rentalCharge, $capacity, $imagePath) {
        $this->hallId = $hallId;
        $this->hallName = $hallName;
        $this->description = $description;
        $this->rentalCharge = $rentalCharge;
        $this->capacity = $capacity;
        $this->imagePath = $imagePath;
    }
    
    public function initWithId() {
        $db = Database::getInstance();
        $data = $db->singleFetch('SELECT * FROM dbProj_Hall WHERE hall_id = ' . $this->hallId );
        $this->initWith($data->hall_id, $data->hall_name, $data->description, $data->rental_charge, $data->capacity, $data->image_path);
    }
    
    public static function queryHallCapacity($hallId) {
        $db = Database::getInstance();
        $hallIdSanitized = $db->sanitizeString($hallId);
        $q = "SELECT capacity "
                . "FROM dbProj_Hall h "
                . "WHERE h.hall_id = ? ";
        
        $stmt = mysqli_prepare($db->getDatabase(),$q);
        if (!$stmt) {
            $db->displayError($q);
            return false;
        }
//      var_dump($stmt);
        $stmt->bind_param('s', $hallIdSanitized);
        if (!$stmt->execute()) {
            $db->displayError($q);
            return false;
        }
        $result = $stmt->get_result();
        $data = $result->fetch_assoc();
        return $data['capacity'];
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

    public function getImagePath() {
        return $this->imagePath;
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

    public function setImagePath($imagePath) {
        $this->imagePath = $imagePath;
    }


}
