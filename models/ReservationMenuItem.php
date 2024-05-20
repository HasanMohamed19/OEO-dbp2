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
include_once '../helpers/Database.php';
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

    public function getBestSellerItem() {
        $db = Database::getInstance();
        $data = $db->singleFetch("SELECT mi.name, rmi.item_id, SUM(rmi.quantity) AS total_quantity
                                FROM dbProj_Reservation_Menu_Item rmi
                                JOIN dbProj_Menu_Item mi ON rmi.item_id = mi.item_id
                                GROUP BY rmi.item_id, mi.name
                                ORDER BY total_quantity DESC
                                LIMIT 1");
        return $data;
    }
}
