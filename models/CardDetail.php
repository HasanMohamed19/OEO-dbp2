<?php

include_once '../helpers/Database.php';
/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

/**
 * Description of CardDetail
 *
 * @author Hassan
 */
class CardDetail {
    
    private $cardId;
    private $cardholderName;
    private $cardNumber;
    private $CVV;
    private $expiryDate;
    private $clientId;
    
    public function initWith($cardId, $cardholderName, $cardNumber, $CVV, $expiryDate, $clientId) {
        $this->cardId = $cardId;
        $this->cardholderName = $cardholderName;
        $this->cardNumber = $cardNumber;
        $this->CVV = $CVV;
        $this->expiryDate = $expiryDate;
        $this->clientId = $clientId;
    }
    
    public function __construct() {
        $this->cardId = null;
        $this->cardholderName = null;
        $this->cardNumber = null;
        $this->CVV = null;
        $this->expiryDate = null;
        $this->clientId = null;
    }
    
    public function addCardDetail() {
        if ($this->isValid()) {
            try {
                $db = Database::getInstance();
                $q = 'INSERT INTO `dbProj_Card_Detail`(`card_id`, `cardholder_name`, `card_number`, `CVV`, `expiry_date`, `client_id`)
                 VALUES (NULL, \'' . $this->cardholderName . '\',\'' . $this->cardNumber . '\',\'' . $this->CVV . '\',\''. $this->expiryDate.'\','.$this->clientId.')';
                $data = $db->querySql($q);
                $this->cardId = mysqli_insert_id($db->dblink);
//                var_dump($q);
                return true;
            } catch (Exception $e) {
                echo 'Exception: ' . $e;
                return false;
            }
        } else {
            return false;
        }
    }
    
    public static function getCards($clientId) {
        $db = Database::getInstance();
        $q = 'SELECT `card_id`, `cardholder_name`, `card_number`, `CVV`, `expiry_date`, `client_id` '
                . 'FROM `dbProj_Card_Detail` WHERE client_id = '.$clientId;
        $data = $db->multiFetch($q);
        return $data;
    }
    public function initWithId() {
        $db = Database::getInstance();
        $q = 'SELECT `card_id`, `cardholder_name`, `card_number`, `CVV`, `expiry_date`, `client_id` '
                . 'FROM `dbProj_Card_Detail` WHERE card_id = '.$this->cardId;
        $data = $db->singleFetch($q);
        $this->initWith($data->card_id, $data->cardholder_name, $data->card_number, $data->CVV, $data->expiry_date, $data->client_id);
    }
    
    public function isValid() {
        $errors = true;

        if (empty($this->cardholderName))
            $errors = false;
        
        if (empty($this->cardNumber))
            $errors = false;
        
        if (empty($this->CVV))
            $errors = false;

        if (empty($this->expiryDate))
            $errors = false;

        if (empty($this->clientId) || $this->clientId <= 0)
            $errors = false;

        return $errors;
    }
    
    public function getCardId() {
        return $this->cardId;
    }

    public function getCardholderName() {
        return $this->cardholderName;
    }

    public function getCardNumber() {
        return $this->cardNumber;
    }

    public function getCVV() {
        return $this->CVV;
    }

    public function getExpiryDate() {
        return $this->expiryDate;
    }

    public function getClientId() {
        return $this->clientId;
    }

    public function setCardId($cardId): void {
        $this->cardId = $cardId;
    }

    public function setCardholderName($cardholderName): void {
        $this->cardholderName = $cardholderName;
    }

    public function setCardNumber($cardNumber): void {
        $this->cardNumber = $cardNumber;
    }

    public function setCVV($CVV): void {
        $this->CVV = $CVV;
    }

    public function setExpiryDate($expiryDate): void {
        $this->expiryDate = $expiryDate;
    }

    public function setClientId($clientId): void {
        $this->clientId = $clientId;
    }
    
}
