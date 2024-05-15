<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

/**
 * Description of CardDetail
 *
 * @author Hassan
 */
class CardDetail {
    
    private $cardId;
    private $cardholderName;
    private $cardNumber;
    private $CVV;
    private $expiryDate;
    private $clientId;
    
    public function initWith($cardId, $cardholderName, $cardNumber, $CVV, $expiryDate, $clientId) {
        $this->cardId = $cardId;
        $this->cardholderName = $cardholderName;
        $this->cardNumber = $cardNumber;
        $this->CVV = $CVV;
        $this->expiryDate = $expiryDate;
        $this->clientId = $clientId;
    }
    
    public function __construct() {
        $this->cardId = null;
        $this->cardholderName = null;
        $this->cardNumber = null;
        $this->CVV = null;
        $this->expiryDate = null;
        $this->clientId = null;
    }

    public function isValid() {
        $errors = true;

        if (empty($this->cardholderName))
            $errors = false;
        
        if (empty($this->cardNumber))
            $errors = false;
        
        if (empty($this->CVV))
            $errors = false;

        if (empty($this->expiryDate))
            $errors = false;

        return $errors;
    }

    // add parameter for id later
    function getAllCards() {
        $db = Database::getInstance();
        $data = $db->multiFetch("SELECT * FROM dbProj_Card_Detail");
        return $data;
    }
    
    function getAllCardsForUser() {
        $db = Database::getInstance();
        $data = $db->multiFetch("SELECT * FROM dbProj_Card_Detail where client_id = " . $this->clientId);
        return $data;
    }

    function addCard() {
//        if ($this->isValid()) {
//            try {
//                $db = Database::getInstance();
//                // TODO: get client_id from cookie
//                $q = "INSERT INTO dbProj_Card_Detail (card_id, cardholder_name, card_number, CVV, expiry_date, client_id)
//                 VALUES (NULL,' $this->cardholderName','$this->cardNumber','$this->CVV','$this->expiryDate','$this->clientId')"; 
//                $data = $db->querySql($q);
////                var_dump($q);
//                 return true;
//            } catch (Exception $e) {
//                echo 'Exception: ' . $e;
//                return false;
//            }
//        } else {
//            return false;
//        }
        $db = new Database();
        
        if ($this->isValid()) {
            $this->cardholderName = $db->sanitizeString($this->cardholderName);
            $this->cardNumber = $db->sanitizeString($this->cardNumber);
            $this->CVV = $db->sanitizeString($this->CVV);
            $this->expiryDate = $db->sanitizeString($this->expiryDate);
            
            $q = "INSERT INTO dbProj_Card_Detail (cardholder_name, card_number, CVV, expiry_date, client_id) VALUES (?,?,?,?,?)";
            
            $stmt = mysqli_prepare($db->getDatabase(), $q);
            
            if ($stmt) {
                $stmt->bind_param('ssssi', $this->cardholderName, $this->cardNumber, $this->CVV, $this->expiryDate, $this->clientId);
                
                if (!$stmt->execute()) {
                    var_dump($stmt);
                    echo 'Execute Failed';
                    $db->displayError($q);
                    return false;
                }
            } else {
                $db->displayError($q);
                return false;
            }
            return true;
        }
        
    }
    
    function initWithCardId($cardId) {
        $db = Database::getInstance();
        $data = $db->singleFetch('SELECT * FROM dbProj_Card_Detail WHERE card_id = ' . $cardId);
        $this->initWith($data->card_id, $data->cardholder_name, $data->card_number, $data->CVV, $data->expiry_date, $data->client_id);
    }
    
    function displayCards($dataSet) {
        
        if (!empty($dataSet)) {
            for ($i = 0; $i < count($dataSet); $i++) {
                $card = new CardDetail();
                // todo: get this from the login
                $card->setClientId('1');
                $cardId = $dataSet[$i]->card_id;
                $card->initWithCardId($cardId);
                echo '<div class="card my-3 mx-3 w-50 align-self-center">
                        <div class="card-body vstack gap-2">';
                
                echo '<div class="row fw-bold justify-content-center"><h2 class="text-center">' . $card->getCardNumber() .'</h2></div>';
                echo '<div class="row justify-content-between">'
                .       '<span class="col-3 justify-content-end fw-bold">' . $card->getExpiryDate() .'</span>'
                        . '<span class="col-3 justify-content-start fw-bold">' . $card->getCardholderName() .'</span></div>';
                echo '<div class="row my-2 gap-2">';
                echo '<button id="editCardBtn" class=" col btn btn-primary fw-bold col border-0 justify-content-end" data-id="' . $card->getCardId() .'" data-bs-toggle="modal" data-bs-target="#editCardModal">Edit</button>';
                echo '<button class=" col btn btn-danger rounded" data-id="' . $card->getCardId() . '" data-bs-toggle="modal" data-bs-target="#deleteModal" onclick="setCardId(this)" id="deleteCardBtn">Delete</button>';
                echo '</div></div></div>';

            }
        }
    }
    
    public function deleteCard() {
        try {
            $db = Database::getInstance();
            $deleteQry = $db->querySQL("Delete from dbProj_Card_Detail where card_id=" . $this->cardId);
//            var_dump($deleteQry);
//            unlink($this->imagePath);
            return true;
        } catch (Exception $e) {
            echo 'Exception: ' . $e;
            return false;
        }
    }
    
    function updateCard() {
        
        
        $db = new Database();
        
        if ($this->isValid()) {
            $this->cardholderName = $db->sanitizeString($this->cardholderName);
            $this->cardNumber = $db->sanitizeString($this->cardNumber);
            $this->CVV = $db->sanitizeString($this->CVV);
            $this->expiryDate = $db->sanitizeString($this->expiryDate);
            
            $q = "UPDATE dbProj_Card_Detail set
			cardholder_name = ?, card_number = ?, CVV = ?, expiry_date = ? WHERE card_id = '$this->cardId';";
            
            $stmt = mysqli_prepare($db->getDatabase(), $q);
            
            if ($stmt) {
                $stmt->bind_param('ssss', $this->cardholderName, $this->cardNumber, $this->CVV, $this->expiryDate);
                
                if (!$stmt->execute()) {
                    var_dump($stmt);
                    echo 'Execute Failed';
                    $db->displayError($q);
                    return false;
                }
            } else {
                $db->displayError($q);
                return false;
            }
            return true;
        }

//        try {
//            $db = Database::getInstance();
//            $data = 'UPDATE dbProj_Card_Detail set
//			cardholder_name = \'' . $this->cardholderName . '\' ,
//			card_number = \'' . $this->cardNumber . '\'  ,
//                        CVV = \'' . $this->CVV . '\' ,
//                        expiry_date = \'' . $this->expiryDate . '\'
//                            WHERE card_id = ' . $this->cardId;
////            var_dump($data);
//            $db->querySQL($data);
//            return true;
//        } catch (Exception $e) {
//
//            echo 'Exception: ' . $e;
//            return false;
//        }
    }
    
    public function getCardId() {
        return $this->cardId;
    }

    public function getCardholderName() {
        return $this->cardholderName;
    }

    public function getCardNumber() {
        return $this->cardNumber;
    }

    public function getCVV() {
        return $this->CVV;
    }

    public function getExpiryDate() {
        return $this->expiryDate;
    }

    public function getClientId() {
        return $this->clientId;
    }

    public function setCardId($cardId): void {
        $this->cardId = $cardId;
    }

    public function setCardholderName($cardholderName): void {
        $this->cardholderName = $cardholderName;
    }

    public function setCardNumber($cardNumber): void {
        $this->cardNumber = $cardNumber;
    }

    public function setCVV($CVV): void {
        $this->CVV = $CVV;
    }

    public function setExpiryDate($expiryDate): void {
        $this->expiryDate = $expiryDate;
    }

    public function setClientId($clientId): void {
        $this->clientId = $clientId;
    }
    
}
