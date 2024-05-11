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

include 'User.php';

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
    
    public function initClientWithoutParent($clientId, $phoneNumber, $clientStatus, $userId) {
        $this->clientId = $clientId;
        $this->phoneNumber = $phoneNumber;
        $this->clientStatus = $clientStatus;
        $this->userId = $userId;
    }
    
    public function iniwWithClientId($clientId) {
        $db = Database::getInstance();
        $data = $db->singleFetch('SELECT * FROM dbProj_Client WHERE client_id = ' . $clientId);
        $this->initClientWithoutParent($data->client_id, $data->phone_number, $data->user_id, $client_status_id);
    }
    
    public function getClientEmail() {
        $db = Database::getInstance();
        $data = $db->singleFetch('SELECT email FROM dbProj_User WHERE user_id = ' . $this->userId);
        return $data;
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


    
    function getClientStatusName($client_id) {
       $db = Database::getInstance();
       $data = $db->singleFetch("SELECT status_name FROM dbProj_Client_Status cs JOIN dbProj_Client c ON c.client_status_id = cs.client_status_id WHERE c.client_id = '$client_id'");
//       var_dump($data);
       return $data;

    }
    
}
