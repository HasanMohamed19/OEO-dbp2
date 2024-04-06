<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

/**
 * Description of ReservationMenuItem
 *
 * @author Hassan
 */
class ReservationMenuItem {
    
    private $reservationMenuItemId;
    private $quantity;
    private $reservationId;
    private $itemId;
    
    public function __construct() {
        $this->reservationMenuItemId = null;
        $this->quantity = null;
        $this->reservationId = null;
        $this->itemId = null;
    }
    
    public function initWith($reservationMenuItemId, $quantity, $reservationId, $itemId) {
        $this->reservationMenuItemId = $reservationMenuItemId;
        $this->quantity = $quantity;
        $this->reservationId = $reservationId;
        $this->itemId = $itemId;
    }
    
    public function getReservationMenuItemId() {
        return $this->reservationMenuItemId;
    }

    public function getQuantity() {
        return $this->quantity;
    }

    public function getReservationId() {
        return $this->reservationId;
    }

    public function getItemId() {
        return $this->itemId;
    }

    public function setReservationMenuItemId($reservationMenuItemId): void {
        $this->reservationMenuItemId = $reservationMenuItemId;
    }

    public function setQuantity($quantity): void {
        $this->quantity = $quantity;
    }

    public function setReservationId($reservationId): void {
        $this->reservationId = $reservationId;
    }

    public function setItemId($itemId): void {
        $this->itemId = $itemId;
    }


    
}
