<?php


include_once '../helpers/Database.php';

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
    
    public static function addWithReservationId($resId, $isAmending) {
        $db = new Database();
        
        // this procedure will automatically calculate
        // rental and catering costs too
        $q = 'CALL insertInvoice(?,?)';
        
        $stmt = mysqli_prepare($db->getDatabase(),$q);
//        var_dump($stmt);
        if (!$stmt) {
            $db->displayError($q);
            return false;
        }
        
        $stmt->bind_param('ii',
            $resId,
            $isAmending
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

    public function getIssueDate() {
        return $this->issueDate;
    }

    public function setIssueDate($issueDate) {
        $this->issueDate = $issueDate;
    }


    
}
