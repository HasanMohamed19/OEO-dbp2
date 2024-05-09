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
include '../helpers/Database.php';

class Hall {

    private $hallId;
    private $hallName;
    private $description;
    private $rentalCharge;
    private $capacity;
    private $imagePath;

//    public function __construct($hallId, $hallName, $description, $rentalCharge, $capacity, $imagePath) {
//        $this->hallId = $hallId;
//        $this->hallName = $hallName;
//        $this->description = $description;
//        $this->rentalCharge = $rentalCharge;
//        $this->capacity = $capacity;
//        $this->imagePath = $imagePath;
//    }
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

    public function initWithHallid($id) {
        $db = Database::getInstance();
        $data = $db->singleFetch('SELECT * FROM dbProj_Hall WHERE hall_id = ' . $id);
        $this->initWith($data->hall_id, $data->hall_name, $data->description, $data->rental_charge, $data->capacity, $data->image_path);
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

    function getAllHalls() {
        $db = Database::getInstance();
        $data = $db->multiFetch('Select * from dbProj_Hall');
        return $data;
    }

    function addHall() {
        try {
            $db = Database::getInstance();
            $insertQry = "INSERT INTO dbProj_Hall(hall_id,hall_name,description,rental_charge,capacity,image_path) VALUES( NULL,'$this->hallName','$this->description', '$this->rentalCharge','$this->capacity','$this->imagePath')";
            if (!($db->querySQL($insertQry))) {
                echo'insert failed  :(';
                return false;
            }
            return true;
        } catch (Exception $e) {
            echo 'Exception: ' . $e;
            return false;
        }
    }

    function deleteHall() {
        try {
            $db = Database::getInstance();
            $deleteQry = $db->querySQL("Delete from dbProj_Hall where hall_id=" . $this->hallId);
//            unlink($this->imagePath);
            return true;
        } catch (Exception $e) {
            echo 'Exception: ' . $e;
            return false;
        }
    }

    public function isValid() {
        $errors = array();

        if (empty($this->hallName))
            $errors[] = 'You must enter a Hall Name';

        if (empty($this->rentalCharge))
            $errors[] = 'You must enter a Rental Charge';

        if (empty($this->capacity))
            $errors[] ='You must enter a Capacity';

        if (empty($this->imagePath))
            $errors[] = 'You must add an Image';

        if (empty($errors))
            return true;
        else
            return false;
    }
}
