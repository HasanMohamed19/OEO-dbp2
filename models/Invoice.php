<?php


include_once '../helpers/Database.php';
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
    
    public function __construct() {
        $this->invoiceId = null;
        $this->hallCost = null;
        $this->cateringCost = null;
        $this->reservationId = null;
    }
    
    public static function addWithReservationId($resId) {
        $db = new Database();
        
        // this procedure will automatically calculate
        // rental and catering costs too
        $q = 'CALL insertInvoice(?)';
        
        $stmt = mysqli_prepare($db->getDatabase(),$q);
//        var_dump($stmt);
        if (!$stmt) {
            $db->displayError($q);
            return false;
        }
        
        $stmt->bind_param('i',
            $resId
        );
        
        if (!$stmt->execute()) {
            var_dump($stmt);
            echo 'Execute failed';
            $db->displayError($q);
            return false;
        }
        return true;
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
    
    public function getReservationId() {
        return $this->reservationId;
    }

    public function setReservationId($reservationId): void {
        $this->reservationId = $reservationId;
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
