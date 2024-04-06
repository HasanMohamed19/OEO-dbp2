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
class PersonalDetails {
    
    private $personalDetialId;
    private $firstName;
    private $lastName;
    private $department;
    private $clientId;
    
    public function initWith($personalDetialId, $firstName, $lastName, $department, $clientId) {
        $this->personalDetialId = $personalDetialId;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->department = $department;
        $this->clientId = $clientId;
    }

    public function __construct() {
        $this->personalDetialId = null;
        $this->firstName = null;
        $this->lastName = null;
        $this->department = null;
        $this->clientId = null;
    }
    
    public function getPersonalDetialId() {
        return $this->personalDetialId;
    }

    public function getFirstName() {
        return $this->firstName;
    }

    public function getLastName() {
        return $this->lastName;
    }

    public function getDepartment() {
        return $this->department;
    }

    public function getClientId() {
        return $this->clientId;
    }

    public function setPersonalDetialId($personalDetialId) {
        $this->personalDetialId = $personalDetialId;
    }

    public function setFirstName($firstName) {
        $this->firstName = $firstName;
    }

    public function setLastName($lastName) {
        $this->lastName = $lastName;
    }

    public function setDepartment($department) {
        $this->department = $department;
    }

    public function setClientId($clientId) {
        $this->clientId = $clientId;
    }


    
}
