<?php

include_once './helpers/Database.php';
/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

/**
 * Description of BillingAddress
 *
 * @author Hassan
 */
class BillingAddress {
    
    private $addressId;
    private $phoneNumber;
    private $roadNumber;
    private $buildingNumber;
    private $city;
    private $blockNumber;
    private $country;
    private $clientId;
    
    public function initWith($addressId, $phoneNumber, $roadNumber, $buildingNumber, $city, $blockNumber, $country, $clientId) {
        $this->addressId = $addressId;
        $this->phoneNumber = $phoneNumber;
        $this->roadNumber = $roadNumber;
        $this->buildingNumber = $buildingNumber;
        $this->city = $city;
        $this->blockNumber = $blockNumber;
        $this->country = $country;
        $this->clientId = $clientId;
    }

    public function __construct() {
        $this->addressId = null;
        $this->phoneNumber = null;
        $this->roadNumber = null;
        $this->buildingNumber = null;
        $this->city = null;
        $this->blockNumber = null;
        $this->country = null;
        $this->clientId = null;
    }
    
    public function addBillingAddress() {
        if ($this->isValid()) {
            try {
                $db = Database::getInstance();
                $q = 'INSERT INTO `dbProj_Billing_Address`(`address_id`, `phone_number`, `road_number`, `building_number`, `block_number`, `city`, `country`, `client_id`)
                 VALUES (NULL, \'' . $this->phoneNumber . '\',\'' . $this->roadNumber . '\',\'' . $this->buildingNumber . '\',\'' . $this->blockNumber . '\',\''. $this->city.'\',\''.$this->country.'\','.$this->clientId.')';
                $data = $db->querySql($q);
                var_dump($q);
                $this->addressId = mysqli_insert_id($db->dblink);
                return true;
            } catch (Exception $e) {
                echo 'Exception: ' . $e;
                return false;
            }
        } else {
            return false;
        }
    }
    
    public function isValid() {
        $errors = true;

        if (empty($this->phoneNumber))
            $errors = false;
        
        if (empty($this->roadNumber))
            $errors = false;
        
        if (empty($this->buildingNumber))
            $errors = false;

        if (empty($this->blockNumber))
            $errors = false;

        if (empty($this->city))
            $errors = false;

        if (empty($this->country))
            $errors = false;

        if (empty($this->clientId) || $this->clientId <= 0)
            $errors = false;

        return $errors;
    }
    
    public function getAddressId() {
        return $this->addressId;
    }

    public function getPhoneNumber() {
        return $this->phoneNumber;
    }

    public function getRoadNumber() {
        return $this->roadNumber;
    }

    public function getBuildingNumber() {
        return $this->buildingNumber;
    }

    public function getCity() {
        return $this->city;
    }

    public function getBlockNumber() {
        return $this->blockNumber;
    }

    public function getCountry() {
        return $this->country;
    }

    public function getClientId() {
        return $this->clientId;
    }

    public function setAddressId($addressId) {
        $this->addressId = $addressId;
    }

    public function setPhoneNumber($phoneNumber) {
        $this->phoneNumber = $phoneNumber;
    }

    public function setRoadNumber($roadNumber) {
        $this->roadNumber = $roadNumber;
    }

    public function setBuildingNumber($buildingNumber) {
        $this->buildingNumber = $buildingNumber;
    }

    public function setCity($city) {
        $this->city = $city;
    }

    public function setBlockNumber($blockNumber) {
        $this->blockNumber = $blockNumber;
    }

    public function setCountry($country) {
        $this->country = $country;
    }

    public function setClientId($clientId) {
        $this->clientId = $clientId;
    }



    
}
