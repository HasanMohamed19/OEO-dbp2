<?php

include './helpers/Database.php';
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
