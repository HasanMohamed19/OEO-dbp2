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
    
    public function initWith($addressId, $phoneNumber, $roadNumber, $buildingNumber, $blockNumber, $city, $country, $clientId) {
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
                 VALUES (NULL,' $this->phoneNumber','$this->roadNumber','$this->buildingNumber','$this->blockNumber','$this->city','$this->country',$this->clientId)"; 
                $data = $db->querySql($q);
                $this->addressId = mysqli_insert_id($db->dblink);
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
        $this->initWith($data->address_id, $data->phone_number, $data->road_number, $data->building_number, $data->block_number, $data->city, $data->country, $data->client_id);
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

    
    public function getAddressCount($clientId) {
        $db = new Database();
        $q = "SELECT COUNT(*) AS addressCount FROM dbProj_Billing_Address WHERE client_id = ?";

        $this->clientId = $db->sanitizeString($clientId);

        $stmt = mysqli_prepare($db->getDatabase(), $q);
        if ($stmt) {
            $stmt->bind_param('i', $this->clientId);

            if (!$stmt->execute()) {
                var_dump($stmt);
                echo 'Execute Failed';
                $db->displayError($q);
//                    return false;
            } else {
                $result = $stmt->get_result();
                $data = $result->fetch_array(MYSQLI_ASSOC);
//                var_dump($data);
                return $data["addressCount"];
            }
        } else {
            echo 'Execute Failed';
            $db->displayError($q);
        }
    }
    
}
