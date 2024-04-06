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
    private $clientId;
    
    public function initWith($comapnyId, $name, $comapnySize, $clientId) {
        $this->comapnyId = $comapnyId;
        $this->name = $name;
        $this->comapnySize = $comapnySize;
        $this->clientId = $clientId;
    }
    
    public function __construct() {
        $this->comapnyId = null;
        $this->name = null;
        $this->comapnySize = null;
        $this->clientId = null;
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

    public function setComapnyId($comapnyId) {
        $this->comapnyId = $comapnyId;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function setComapnySize($comapnySize) {
        $this->comapnySize = $comapnySize;
    }

    public function setClientId($clientId) {
        $this->clientId = $clientId;
    }

}
