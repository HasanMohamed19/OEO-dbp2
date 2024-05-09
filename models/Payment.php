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
    private $invoiceId;
    
    public function initWith($paymentId, $amount, $paymentDate, $invoiceId) {
        $this->paymentId = $paymentId;
        $this->amount = $amount;
        $this->paymentDate = $paymentDate;
        $this->invoiceId = $invoiceId;
    }
    
    public function __construct() {
        $this->paymentId = null;
        $this->amount = null;
        $this->paymentDate = null;
        $this->invoiceId = null;
    }
        
    public function getPaymentId() {
        return $this->paymentId;
    }

    public function getAmount() {
        return $this->amount;
    }

    public function getPaymentDate() {
        return $this->paymentDate;
    }
    
    public function getInvoiceId() {
        return $this->invoiceId;
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
    
    public function setInvoiceId($invoiceId): void {
        $this->invoiceId = $invoiceId;
    }
    
}
