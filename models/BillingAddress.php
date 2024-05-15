<?php

include_once '../helpers/Database.php';
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
                // TODO: get client_id from cookie
                $q = "INSERT INTO dbProj_Billing_Address (address_id, phone_number, road_number, building_number, block_number, city, country, client_id)
                 VALUES (NULL,' $this->phoneNumber','$this->roadNumber','$this->buildingNumber','$this->blockNumber','$this->city','$this->country','$this->clientId')"; 
                $data = $db->querySql($q);
//                var_dump($q);
                 return true;
            } catch (Exception $e) {
                echo 'Exception: ' . $e;
                return false;
            }
        } else {
            return false;
        }
    }
    
    public function deleteAddress() {
        try {
            $db = Database::getInstance();
            $deleteQry = $db->querySQL("Delete from dbProj_Billing_Address where address_id=" . $this->addressId);
//            var_dump($deleteQry);
//            unlink($this->imagePath);
            return true;
        } catch (Exception $e) {
            echo 'Exception: ' . $e;
            return false;
        }
    }
    
    function displayAddresses($dataSet) {
        
        if (!empty($dataSet)) {
            for ($i = 0; $i < count($dataSet); $i++) {
                $address = new BillingAddress();
                // todo: get this from the login
                $address->setClientId('13');
                $addressId = $dataSet[$i]->address_id;
                $address->setAddressId($addressId);
                $address->initWithId();
                
                
                echo '<div class="card my-3 mx-3 w-50 align-self-center">
                        <div class="card-body vstack gap-2 align-items-center">
                            <div class="row fw-bold"><h2>Company Address</h2></div>';
                                
                echo '<div class="row m-2">
                        <span class="col text-start text-secondary">Phone Number: ' . $address->getPhoneNumber() .'</span>
                     </div>';
                
                echo ' <div class="row m-2">
                        <span class="col text-start text-secondary">Building: ' . $address->getBuildingNumber() .', Street: ' . $address->getRoadNumber() .', Block: ' . $address->getBlockNumber() .'</span>
                     </div>';
                
                echo '<div class="row m-2">
                        <span class="col text-start text-secondary">' . $address->getCity() .', ' . $address->getCountry() .' </span>
                      </div>';
                
                echo '</div><div class="row m-2 gap-1">';
                echo '<button id="editAddressBtn" class="col btn btn-primary fw-bold col rounded justify-content-end" data-id="' . $address->getAddressId() . '" data-bs-toggle="modal" data-bs-target="#editAddressModal" onclick="setCardId(this)">Edit</button>
                    <button class="btn btn-danger col rounded" data-id="' . $address->getAddressId() . '" data-bs-toggle="modal" data-bs-target="#deleteAddressModal" onclick="setAddressId(this)" id="deleteAddressBtn">Delete</button>
                            </div>
                        </div>';
                                
            }
        }
    }
    
    function updateBillingAddress() {
        try {
            $db = Database::getInstance();
            $data = 'UPDATE dbProj_Billing_Address set
			phone_number = \'' . $this->phoneNumber . '\' ,
			road_number = \'' . $this->roadNumber . '\'  ,
                        building_number = \'' . $this->buildingNumber . '\' ,
                        block_number = \'' . $this->blockNumber . '\' ,
                        city = \'' . $this->city . '\' ,
                        country = \'' . $this->country . '\' 
                            WHERE address_id = ' . $this->addressId;

            $db->querySQL($data);
            return true;
        } catch (Exception $e) {

            echo 'Exception: ' . $e;
            return false;
        }
    }
    
    public static function getAddresses($clientId) {
        $db = Database::getInstance();
        $q = 'SELECT `address_id`, `phone_number`, `road_number`, `building_number`, `block_number`, `city`, `country`, `client_id` '
                . 'FROM `dbProj_Billing_Address` WHERE client_id = '.$clientId;
        $data = $db->multiFetch($q);
        return $data;
    }
    
    public function initWithId() {
        $db = Database::getInstance();
        $q = 'SELECT `address_id`, `phone_number`, `road_number`, `building_number`, `block_number`, `city`, `country`, `client_id` '
                . 'FROM `dbProj_Billing_Address` WHERE address_id = '.$this->addressId;
//        var_dump($q);
        $data = $db->singleFetch($q);
//        var_dump($data);
        $this->initWith($data->address_id, $data->phone_number, $data->road_number, $data->building_number, $data->city, $data->block_number, $data->country, $data->client_id);
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

        if (empty($this->clientId))
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