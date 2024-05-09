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

//enum Gender {
//    case M;
//    case F;
//}

const GENDER_MALE = 'M';
const GENDER_FEMALE = 'F';

class PersonalDetails {
    
    private $personalDetialId;
    private $firstName;
    private $lastName;
//    private $department;
    private $dob;
    private $gender;
    private $nationality;
    private $clientId;
    
    public function __construct() {
        $this->personalDetialId = null;
        $this->firstName = null;
        $this->lastName = null;
        $this->dob = null;
        $this->gender = null;
        $this->nationality = null;
        $this->clientId = null;
    }

        public function initWith($personalDetialId, $firstName, $lastName, $dob, $gender, $nationality, $clientId) {
        $this->personalDetialId = $personalDetialId;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->dob = $dob;
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
    
    public function getDob() {
        return $this->dob;
    }
    
    public function getAge() {
        // calculate age
    }

    public function getGender() {
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
    
    public function setDob($dob) {
        $this->dob = $dob;
    }

    public function setGender($gender) {
        $this->gender = $gender;
    }

    public function setNationality($nationality) {
        $this->nationality = $nationality;
    }
    
    public function setClientId($clientId) {
        $this->clientId = $clientId;
    }


    
}
