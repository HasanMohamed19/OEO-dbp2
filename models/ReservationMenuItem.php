<?php

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
    
    public function isValid() {
        if ($this->quantity < 0) {
            return false;
        }
        return true;
    }
    
    public function addReservationMenuItem() {
        $db = new Database();
        if (!$this->isValid()) {
            return false;
        }
//        echo "quant $this->quantity, resid $this->reservationId";
        $this->quantity = $db->sanitizeString($this->quantity);

        if ($this->reservationMenuItemId == null || $this->reservationMenuItemId <= 0) {
            $q = 'INSERT INTO `dbProj_Reservation_Menu_Item`(`reservation_menu_item_id`, `quantity`, `reservation_id`, `item_id`) '
                    . 'VALUES (NULL,?,?,?) ';
        } else {
            $q = 'UPDATE `dbProj_Reservation_Menu_Item` '
                    . 'SET quantity=? '
                    . 'WHERE reservation_menu_item_id=?';
        }

        $stmt = mysqli_prepare($db->getDatabase(),$q);
//        var_dump($stmt);
        if (!$stmt) {
            $db->displayError($q);
            return false;
        }
        
        if ($this->reservationMenuItemId == null || $this->reservationMenuItemId <= 0) {
            $stmt->bind_param('iii',
                $this->quantity,
                $this->reservationId,
                $this->itemId
            );
        } else {
            // in case of update
            $stmt->bind_param('ii', 
                $this->quantity,
                $this->reservationMenuItemId
            );
        }
        if (!$stmt->execute()) {
            var_dump($stmt);
            echo 'Execute failed';
            $db->displayError($q);
            return false;
        }
        return true;
    }
    
    public static function getItemsForReservation($reservationId) {
        $db = Database::getInstance();
        $q = 'SELECT rmi.reservation_menu_item_id, mi.item_id, mi.service_id, rmi.quantity, mi.price FROM dbProj_Reservation_Menu_Item rmi '
                . 'JOIN dbProj_Menu_Item mi ON rmi.item_id = mi.item_id '
                . 'WHERE reservation_id = '.$reservationId;
        $data = $db->multiFetch($q);
        return $data;
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
