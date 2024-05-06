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

    function addHall() {
        try {
            $db = Database::getInstance();
            $insertQry = "INSERT INTO dbProj_Hall VALUES( NULL,'$this->hallName','$this->description', '$this->rentalCharge','$this->capacity','Null')";
            if (!($db->querySql($insertQry))) {
                echo'insert failed';
                return false;
            }
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
            $errors[] = 'You must enter a Capacity';
//        if (empty($this->imagePath))
////            $errors[] = 'You must add an Image';

        if (empty($errors))
            return true;
        else
            return false;
    }
}
