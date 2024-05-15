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
    private $issueDate;


    public function initWith($invoiceId, $hallCost, $cateringCost, $reservationId, $issueDate) {
        $this->invoiceId = $invoiceId;
        $this->hallCost = $hallCost;
        $this->cateringCost = $cateringCost;
        $this->reservationId = $reservationId;
        $this->issueDate = $issueDate;
    }
    
    public function __construct() {
        $this->invoiceId = null;
        $this->hallCost = null;
        $this->cateringCost = null;
        $this->reservationId = null;
        $this->issueDate = null;
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

    public function getReservationId() {
        return $this->reservationId;
    }

    public function getIssueDate() {
        return $this->issueDate;
    }

    public function setReservationId($reservationId) {
        $this->reservationId = $reservationId;
    }

    public function setIssueDate($issueDate) {
        $this->issueDate = $issueDate;
    }


    
}
