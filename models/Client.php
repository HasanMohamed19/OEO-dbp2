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

include_once 'models/User.php';

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
    
    public function initClientWithoutParent($clientId, $phoneNumber, $clientStatus, $userId) {
        $this->clientId = $clientId;
        $this->phoneNumber = $phoneNumber;
        $this->clientStatus = $clientStatus;
        $this->userId = $userId;
    }
    
    public function iniwWithClientId($clientId) {
        $db = Database::getInstance();
        $data = $db->singleFetch('SELECT * FROM dbProj_Client WHERE client_id = ' . $clientId);
        $this->initClientWithoutParent($data->client_id, $data->phone_number, $data->client_status_id, $data->user_id);
    }
    
    public function getClientEmail() {
        $db = Database::getInstance();
        $data = $db->singleFetch('SELECT email FROM dbProj_User WHERE user_id = ' . $this->userId);
        return $data;
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


    
    function getClientStatusName($client_id) {
       $db = Database::getInstance();
       $data = $db->singleFetch("SELECT status_name FROM dbProj_Client_Status cs JOIN dbProj_Client c ON c.client_status_id = cs.client_status_id WHERE c.client_id = '$client_id'");
//       var_dump($data);
       return $data;

    }
    
        function updateClient($clientId) {
        include_once  "./helpers/Database.php";

        $db = new Database();
//        if ($this->isValid()) {
//                    echo "username $this->username, password $this->password";
            $this->phoneNumber = $db->sanitizeString($this->phoneNumber);
            // assuming role_id never changes
            $q = "UPDATE dbProj_Client SET "
                . "phone_number=? WHERE client_id=?";

            $stmt = mysqli_prepare($db->getDatabase(),$q);
            if ($stmt) {
                $stmt->bind_param('si', $this->phoneNumber, $clientId);
            }
                if (!$stmt->execute()) {
                    var_dump($stmt);
                    echo 'Execute failed';
                    $db->displayError($q);
                    return false;
                }
//            } else {
//                $db->displayError($q);
//                return false;
//            }

    }
    
}
