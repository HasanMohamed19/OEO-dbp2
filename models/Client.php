<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

/**
 * Description of Client
 *
 * @author Hassan
 */

//enum ClientStatus: int {
//    // clientStatus with its discount rate
//    case golden = 0.2;
//    case silver = 0.1;
//    case bronze = 0.05;
//}

const GOLDEN_STATUS = 0.2;
const SILVER_STATUS = 0.1;
const BRONZE_STATUS = 0.05;

class Client extends User {
    
    private $clientId;
//    private $firstName;
//    private $lastName;
    private $balance;
    private $clientStatusId;
    private $userId;
    
    public function __construct() {
        $this->clientId = null;
//        $this->firstName = null;
//        $this->lastName = null;
        $this->balance = null;
        $this->clientStatusId = null;
        $this->userId = null;
        parent::__construct();
    }

    
    public function initClientWith($clientId, $balance, $clientStatusId, $userId, $username, $password, $email, UserRole $userRole) {
        $this->clientId = $clientId;
        $this->balance = $balance;
        $this->clientStatusId = $clientStatusId;
        $this->userId = $userId;
        parent::initWith($userId, $username, $password, $email, $userRole);
    }

    
    public function getClientId() {
        return $this->clientId;
    }

    public function getBalance() {
        return $this->balance;
    }
    
    public function getUserId() {
        return $this->clientId;
    }

    public function getClientStatusId() {
        return $this->clientStatusId;
    }

    public function setClientId($clientId) {
        $this->clientId = $clientId;
    }

    public function setBalance($balance) {
        $this->balance = $balance;
    }

    public function setClientStatus($clientStatusId) {
        $this->clientStatusId = $clientStatusId;
    }
    
    public function setUserId($userId) {
        $this->userId = $userId;
    }
    
    public function hasPersonalDeatils($clientId) {
        $db = Database::getInstance();
        $q = "SELECT EXISTS (SELECT * from dbProj_PersonalDetails WHERE client_id=" . $clientId . ") AS hasPersonalDetails";
        $data = $db->singleFetch($q);
//        var_dump($data);
        return $data->hasPersonalDetails;
    }
    
    public function hasCompanyDetails($clientId) {
        $db = Database::getInstance();
        $q = "SELECT EXISTS(SELECT * from dbProj_CompanyDetails WHERE client_id=" . $clientId . ") AS hasCompanyDetails";
        $data = $db->singleFetch($q);
//        var_dump($data);
        return $data->hasCompanyDetails;
    }
    
    public function getPersonalDeatils($clientId) {
        $db = Database::getInstance();
        $q = "SELECT * from dbProj_PersonalDetails WHERE client_id=" . $clientId;
        $data = $db->singleFetch($q);
//        var_dump($data);
        return $data;
    }
    
    public function getCompanyDetails($clientId) {
        $db = Database::getInstance();
        $q = "SELECT * from dbProj_CompanyDetails WHERE client_id=" . $clientId;
        $data = $db->singleFetch($q);
//        var_dump($data);
        return $data;
    }
    
}
