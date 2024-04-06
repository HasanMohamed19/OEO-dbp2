<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

/**
 * Description of Invoice
 *
 * @author Hassan
 */
class Invoice {
    
    private $invoiceId;
    private $hallCost;
    private $cateringCost;
    private $reservationId;
    
    public function initWith($invoiceId, $hallCost, $cateringCost, $reservationId) {
        $this->invoiceId = $invoiceId;
        $this->hallCost = $hallCost;
        $this->cateringCost = $cateringCost;
        $this->reservationId = $reservationId;
    }
    
    public function __construct($invoiceId, $hallCost, $cateringCost, $reservationId) {
        $this->invoiceId = null;
        $this->hallCost = null;
        $this->cateringCost = null;
        $this->reservationId = null;
    }
    
    public function getInvoiceId() {
        return $this->invoiceId;
    }

    public function getHallCost() {
        return $this->hallCost;
    }

    public function getCateringCost() {
        return $this->cateringCost;
    }

    public function setInvoiceId($invoiceId) {
        $this->invoiceId = $invoiceId;
    }

    public function setHallCost($hallCost) {
        $this->hallCost = $hallCost;
    }

    public function setCateringCost($cateringCost) {
        $this->cateringCost = $cateringCost;
    }


    
}
