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

enum ClientStatus: int {
    // clientStatus with its discount rate
    case golden = 0.2;
    case silver = 0.1;
    case bronze = 0.05;
}

class Client extends User {
    
    private $clientId;
    private $firstName;
    private $lastName;
    private $balance;
    private ClientStatus $clientStatus;
    private $userId;
    
    public function __construct() {
        $this->clientId = null;
        $this->firstName = null;
        $this->lastName = null;
        $this->balance = null;
        $this->clientStatus = null;
        $this->userId = null;
        parent::__construct();
    }

    
    public function initClientWith($clientId, $firstName, $lastName, $balance, ClientStatus $clientStatus, $userId, $userId, $username, $password, $email, UserRole $userRole) {
        $this->clientId = $clientId;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->balance = $balance;
        $this->clientStatus = $clientStatus;
        $this->userId = $userId;
        parent::initWith($userId, $username, $password, $email, $userRole);
    }

    
    public function getClientId() {
        return $this->clientId;
    }

    public function getFirstName() {
        return $this->firstName;
    }

    public function getLastName() {
        return $this->lastName;
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

    public function setFirstName($firstName) {
        $this->firstName = $firstName;
    }

    public function setLastName($lastName) {
        $this->lastName = $lastName;
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
    
}
