<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

/**
 * Description of Payment
 *
 * @author Hassan
 */
class Payment {
    private $paymentId;
    private $amount;
    private $paymentDate;
    
    public function getPaymentId() {
        return $this->paymentId;
    }

    public function getAmount() {
        return $this->amount;
    }

    public function getPaymentDate() {
        return $this->paymentDate;
    }

    public function setPaymentId($paymentId): void {
        $this->paymentId = $paymentId;
    }

    public function setAmount($amount): void {
        $this->amount = $amount;
    }

    public function setPaymentDate($paymentDate): void {
        $this->paymentDate = $paymentDate;
    }
    
}
