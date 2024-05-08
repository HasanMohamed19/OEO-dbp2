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

const Gold = 0.2;
const Silver = 0.1;
const Bronze = 0.05;
const None = 0;

include 'User.php';

class Client extends User {
    
    private $clientId;
//    private $firstName;
//    private $lastName;
    private $balance;
    private $clientStatus;
    private $userId;
    
    public function __construct() {
        $this->clientId = null;
//        $this->firstName = null;
//        $this->lastName = null;
        $this->balance = null;
        $this->clientStatus = null;
        $this->userId = null;
        parent::__construct();
    }

    
    public function initClientWith($clientId, $balance, $clientStatus, $userId, $username, $password, $email, UserRole $userRole) {
        $this->clientId = $clientId;
        $this->balance = $balance;
        $this->clientStatus = $clientStatus;
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

    public function getClientStatus(): ClientStatus {
        return $this->clientStatus;
    }

    public function setClientId($clientId) {
        $this->clientId = $clientId;
    }

    public function setBalance($balance) {
        $this->balance = $balance;
    }

    public function setClientStatus(ClientStatus $clientStatus) {
        $this->clientStatus = $clientStatus;
    }
    
    public function setUserId($userId) {
        $this->userId = $userId;
    }
    
    function getClientStatusName($client_id) {
       $db = Database::getInstance();
       $data = $db->singleFetch("SELECT status_name FROM dbProj_Client_Status cs JOIN dbProj_Client c ON c.client_status_id = cs.client_status_id WHERE c.client_id = '$client_id'");
//       var_dump($data);
       return $data;

    }
    
}
