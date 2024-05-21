<?php


include_once 'models/User.php';


//enum ClientStatus: int {
//    // clientStatus with its discount rate
//    case golden = 0.2;
//    case silver = 0.1;
//    case bronze = 0.05;
//}
include_once 'helpers/Database.php';
include_once 'models/User.php';

const GOLDEN_STATUS = 0.2;
const SILVER_STATUS = 0.1;
const BRONZE_STATUS = 0.05;

class Client extends User {

    private $clientId;
    private $phoneNumber;
    private $clientStatusId;

//    private $userId;

    public function __construct() {
        $this->clientId = null;
        $this->phoneNumber = null;
        $this->clientStatusId = null;
//        $this->userId = null;
        parent::__construct();
    }


    // overrides registerUser from User class
    public function registerUser() {
        include_once  "./helpers/Database.php";
        $db = new Database();
//        if (!$this->isValid()) {
//            return false;
//        }
        
        // add a User first
        if (!parent::registerUser()) {
            return false;
        }
        
        $this->phoneNumber = $db->sanitizeString($this->phoneNumber);

        $q = "INSERT INTO `dbProj_Client` (`client_id`,`phone_number`, `user_id`, `client_status_id`)
            VALUES (NULL, ?, ?, 4)";
        $clientStmt = mysqli_prepare($db->getDatabase(), $q);

        if (!$clientStmt) {
            $db->displayError($q);
            return false;
        }

        $clientStmt->bind_param('is', 
                $this->phoneNumber,
                $this->userId);

        if (!$clientStmt->execute()) {
            var_dump($clientStmt);
            echo 'Execute failed';
            $db->displayError($q);
            return false;
        }
        $this->clientId = $db->getDatabase()->insert_id;
        return true;
    }



    public function initClientWith($clientId, $phoneNumber, $clientStatusId, $userId, $username, $password, $email, $roleId) {
        $this->clientId = $clientId;
        $this->phoneNumber = $phoneNumber;
        $this->clientStatusId = $clientStatusId;
//        $this->userId = $userId;
        parent::initWith($userId, $username, $password, $email, $roleId);
    }

    public function initClientWithoutParent($clientId, $phoneNumber, $clientStatusId, $userId) {
        $this->clientId = $clientId;
        $this->phoneNumber = $phoneNumber;
        $this->$clientStatusId = $clientStatusId;
//        $this->userId = $userId;
    }

    public function iniwWithClientId($clientId) {
        $db = Database::getInstance();
        $data = $db->singleFetch('SELECT * FROM dbProj_Client WHERE client_id = ' . $clientId);
        $this->initClientWithoutParent($data->client_id, $data->phone_number, $data->client_status_id, $data->user_id);
    }

    public function getClientEmail() {
        $db = Database::getInstance();
        $data = $db->singleFetch('SELECT email FROM dbProj_User WHERE user_id = ' . $this->userId);
        return $data;
    }


    public function getDiscountRate() {
        $db = Database::getInstance();
        $q = 'SELECT `client_status_id` '
                . 'FROM `dbProj_Client` WHERE client_id = '.$this->clientId;
        $data = $db->singleFetch($q);
//        var_dump($data);
        $discountRate = 0;
        if ($data->client_status_id == 1) {$discountRate = GOLDEN_STATUS;}
        if ($data->client_status_id == 2) {$discountRate = SILVER_STATUS;}
        if ($data->client_status_id == 3) {$discountRate = BRONZE_STATUS;}
        if ($data->client_status_id == 4) {$discountRate = 0;}
        return (1 - $discountRate);
    }
    


    public function getClientId() {
        return $this->clientId;
    }

//    public function getUserId() {
//        return $this->clientId;
//    }


    public function getClientStatusId() {
        return $this->clientStatusId;
    }

    public function setClientId($clientId) {
        $this->clientId = $clientId;
    }

    public function setClientStatus($clientStatusId) {
        $this->clientStatusId = $clientStatusId;
    }

//    public function setUserId($userId) {
//        $this->userId = $userId;
//    }

    public function getPhoneNumber() {
        return $this->phoneNumber;
    }

    public function setPhoneNumber($phoneNumber) {
        $this->phoneNumber = $phoneNumber;
    }

    function getAllClients($start, $end) {
        $db = Database::getInstance();
        $start = $start * $end - $end;

        $q = 'Select * from dbProj_Client ';
        if (isset($start))
            $q .= ' limit ' . $start . ',' . $end;
        $data = $db->multiFetch($q);
        return $data;
    }

    public static function countAllClients() {
        $db = Database::getInstance();
        $q = "Select * from dbProj_Client";
        $dataCount = $db->getRows($q);
        return $dataCount;
    }

    public function getBestClient() {
        $db = Database::getInstance();
        $data = $db->singleFetch("SELECT 
            c.client_id,
            u.user_id,
            u.username,
            r.reservation_count
        FROM (
            SELECT 
                client_id,
                COUNT(*) AS reservation_count
            FROM 
                dbProj_Reservation
            GROUP BY 
                client_id
        ) AS r
        JOIN 
            dbProj_Client c ON r.client_id = c.client_id
        JOIN 
            dbProj_User u ON c.user_id = u.user_id
        ORDER BY 
            r.reservation_count DESC
        LIMIT 1");
        return $data;
    }

    function getClientStatusName($client_id) {
        $db = Database::getInstance();
        $data = $db->singleFetch("SELECT status_name FROM dbProj_Client_Status cs JOIN dbProj_Client c ON c.client_status_id = cs.client_status_id WHERE c.client_id = '$client_id'");
//       var_dump($data);
        return $data;
    }

    function updateClient($clientId) {
        include_once "./helpers/Database.php";

        $db = new Database();
//        if ($this->isValid()) {
//                    echo "username $this->username, password $this->password";
        $this->phoneNumber = $db->sanitizeString($this->phoneNumber);
        // assuming role_id never changes
        $q = "UPDATE dbProj_Client SET "
                . "phone_number=? WHERE client_id=?";

        $stmt = mysqli_prepare($db->getDatabase(), $q);
        if ($stmt) {
            $stmt->bind_param('si', $this->phoneNumber, $clientId);
        }
        if (!$stmt->execute()) {
            var_dump($stmt);
            echo 'Execute failed';
            $db->displayError($q);
            return false;
        }
//            } else {
//                $db->displayError($q);
//                return false;
//            }
    }

        // it appears that this function is duplicated (to remove if it works)
//        function updateClient($clientId) {
//            include_once  "./helpers/Database.php";
//
//            $db = new Database();
//    //        if ($this->isValid()) {
//    //                    echo "username $this->username, password $this->password";
//                $this->phoneNumber = $db->sanitizeString($this->phoneNumber);
//                // assuming role_id never changes
//                $q = "UPDATE dbProj_Client SET "
//                    . "phone_number=? WHERE client_id=?";
//
//                $stmt = mysqli_prepare($db->getDatabase(),$q);
//                if ($stmt) {
//                    $stmt->bind_param('si', $this->phoneNumber, $clientId);
//                }
//                    if (!$stmt->execute()) {
//                        var_dump($stmt);
//                        echo 'Execute failed';
//                        $db->displayError($q);
//                        return false;
//                    }
////            } else {
////                $db->displayError($q);
////                return false;
////            }
//
//        }
    
    static function getTotalReservations($clientId) {
        $db = Database::getInstance();
       $data = $db->singleFetch('SELECT COUNT(*) AS "totalReservations" FROM dbProj_Reservation WHERE client_id = ' . $clientId);
//       var_dump($data);
       return $data;
    }
    
     public function hasPersonalDeatils($clientId) {
        $db = Database::getInstance();
        $q = "SELECT EXISTS (SELECT * from dbProj_PersonalDetails WHERE client_id=" . $clientId . ") AS hasPersonalDetails";
        $data = $db->singleFetch($q);
//        var_dump($data);
        return $data->hasPersonalDetails;
    }
    
    public function hasCompanyDetails($clientId) {
        $db = Database::getInstance();
        $q = "SELECT EXISTS(SELECT * from dbProj_CompanyDetails WHERE client_id=" . $clientId . ") AS hasCompanyDetails";
        $data = $db->singleFetch($q);
//        var_dump($data);
        return $data->hasCompanyDetails;
    }
    
    public function getPersonalDeatils($clientId) {
        $db = Database::getInstance();
        $q = "SELECT * from dbProj_PersonalDetails WHERE client_id=" . $clientId;
        $data = $db->singleFetch($q);
//        var_dump($data);
        return $data;
    }
    
    public function getCompanyDetails($clientId) {
        $db = Database::getInstance();
        $q = "SELECT * from dbProj_CompanyDetails WHERE client_id=" . $clientId;
        $data = $db->singleFetch($q);
//        var_dump($data);
        return $data;
    }
    

}
