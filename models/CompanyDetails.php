<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

/**
 * Description of CompanyDetails
 *
 * @author Hassan
 */
class CompanyDetails {
    
    private $comapnyId;
    private $name;
    private $address;
    private $comapnySize;
    private $clientId;
    
    public function initWith($comapnyId, $name, $address, $comapnySize, $clientId) {
        $this->comapnyId = $comapnyId;
        $this->name = $name;
        $this->address = $address;
        $this->comapnySize = $comapnySize;
        $this->clientId = $clientId;
    }
    
    public function __construct() {
        $this->comapnyId = null;
        $this->name = null;
        $this->address = null;
        $this->comapnySize = null;
        $this->clientId = null;
    }
    
    public function getComapnyId() {
        return $this->comapnyId;
    }

    public function getName() {
        return $this->name;
    }

    public function getAddress() {
        return $this->address;
    }

    public function getComapnySize() {
        return $this->comapnySize;
    }

    public function getClientId() {
        return $this->clientId;
    }

    public function setComapnyId($comapnyId) {
        $this->comapnyId = $comapnyId;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function setAddress($address) {
        $this->address = $address;
    }

    public function setComapnySize($comapnySize) {
        $this->comapnySize = $comapnySize;
    }

    public function setClientId($clientId) {
        $this->clientId = $clientId;
    }

}
