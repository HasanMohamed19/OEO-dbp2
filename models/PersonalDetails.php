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

enum Gender {
    case M;
    case F;
}

class PersonalDetails {
    
    private $personalDetialId;
    private $firstName;
    private $lastName;
//    private $department;
    private $age;
    private Gender $gender;
    private $nationality;
    private $clientId;
    
    public function __construct() {
        $this->personalDetialId = null;
        $this->firstName = null;
        $this->lastName = null;
        $this->age = null;
        $this->gender = null;
        $this->nationality = null;
        $this->clientId = null;
    }

        public function initWith($personalDetialId, $firstName, $lastName, $age, Gender $gender, $nationality, $clientId) {
        $this->personalDetialId = $personalDetialId;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->age = $age;
        $this->gender = $gender;
        $this->nationality = $nationality;
        $this->clientId = $clientId;
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
    
    public function getAge() {
        return $this->age;
    }

    public function getGender(): Gender {
        return $this->gender;
    }

    public function getNationality() {
        return $this->nationality;
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
    
    public function setAge($age) {
        $this->age = $age;
    }

    public function setGender(Gender $gender) {
        $this->gender = $gender;
    }

    public function setNationality($nationality) {
        $this->nationality = $nationality;
    }
    
    public function setClientId($clientId) {
        $this->clientId = $clientId;
    }


    
}
