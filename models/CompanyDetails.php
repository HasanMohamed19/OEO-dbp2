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
    private $comapnySize;
    private $city;
    private $website;
    private $clientId;
    
    public function __construct() {
        $this->comapnyId = null;
        $this->name = null;
        $this->comapnySize = null;
        $this->city = null;
        $this->website = null;
        $this->clientId = null;
    }
    
    public function initWith($comapnyId, $name, $comapnySize, $city, $website, $clientId) {
        $this->comapnyId = $comapnyId;
        $this->name = $name;
        $this->comapnySize = $comapnySize;
        $this->city = $city;
        $this->website = $website;
        $this->clientId = $clientId;
    }

    
    public function getComapnyId() {
        return $this->comapnyId;
    }

    public function getName() {
        return $this->name;
    }

    public function getComapnySize() {
        return $this->comapnySize;
    }

    public function getClientId() {
        return $this->clientId;
    }
    
    public function getCity() {
        return $this->city;
    }

    public function getWebsite() {
        return $this->website;
    }
    
    public function setComapnyId($comapnyId) {
        $this->comapnyId = $comapnyId;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function setComapnySize($comapnySize) {
        $this->comapnySize = $comapnySize;
    }
    
    public function setCity($city) {
        $this->city = $city;
    }

    public function setWebsite($website) {
        $this->website = $website;
    }

    
    public function setClientId($clientId) {
        $this->clientId = $clientId;
    }

}
