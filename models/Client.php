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
include_once 'helpers/Database.php';
include_once 'models/User.php';

const GOLDEN_STATUS = 0.2;
const SILVER_STATUS = 0.1;
const BRONZE_STATUS = 0.05;

class Client extends User {
    
    private $clientId;
    private $phoneNumber;
    private $clientStatusId;
//    private $userId;
    
    public function __construct() {
        $this->clientId = null;
        $this->phoneNumber = null;
        $this->clientStatusId = null;
//        $this->userId = null;
        parent::__construct();
    }

    
    public function initClientWith($clientId, $phoneNumber, $clientStatusId, $userId, $username, $password, $email, $roleId) {
        $this->clientId = $clientId;
        $this->phoneNumber = $phoneNumber;
        $this->clientStatusId = $clientStatusId;
//        $this->userId = $userId;
        parent::initWith($userId, $username, $password, $email, $roleId);
    }

    public function getDiscountRate() {
        $db = Database::getInstance();
        $q = 'SELECT `client_status_id` '
                . 'FROM `dbProj_Client` WHERE client_id = '.$this->clientId;
        $data = $db->singleFetch($q);
//        var_dump($data);
        $discountRate = 0;
        if ($data->client_status_id == 1) {$discountRate = GOLDEN_STATUS;}
        if ($data->client_status_id == 2) {$discountRate = SILVER_STATUS;}
        if ($data->client_status_id == 3) {$discountRate = BRONZE_STATUS;}
        if ($data->client_status_id == 4) {$discountRate = 0;}
        return (1 - $discountRate);
    }
    
    public function getClientId() {
        return $this->clientId;
    }
    
//    public function getUserId() {
//        return $this->clientId;
//    }

    public function getClientStatusId() {
        return $this->clientStatusId;
    }

    public function setClientId($clientId) {
        $this->clientId = $clientId;
    }

    public function setClientStatus($clientStatusId) {
        $this->clientStatusId = $clientStatusId;
    }
    
//    public function setUserId($userId) {
//        $this->userId = $userId;
//    }
    
    public function getPhoneNumber() {
        return $this->phoneNumber;
    }

    public function setPhoneNumber($phoneNumber) {
        $this->phoneNumber = $phoneNumber;
    }


    
}
