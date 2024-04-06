<?php

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
