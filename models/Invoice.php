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
    private $catering_cost;
    
    public function getInvoiceId() {
        return $this->invoiceId;
    }

    public function getHallCost() {
        return $this->hallCost;
    }

    public function getCatering_cost() {
        return $this->catering_cost;
    }

    public function setInvoiceId($invoiceId) {
        $this->invoiceId = $invoiceId;
    }

    public function setHallCost($hallCost) {
        $this->hallCost = $hallCost;
    }

    public function setCatering_cost($catering_cost) {
        $this->catering_cost = $catering_cost;
    }


    
}
