<?php


class CompanyDetails {
    
    private $comapnyId;
    private $name;
    private $comapnySize;
    private $city;
    private $website;
    private $clientId;
    
    public function __construct() {
        $this->comapnyId = null;
        $this->name = null;
        $this->comapnySize = null;
        $this->city = null;
        $this->website = null;
        $this->clientId = null;
    }
    
    public function initWith($comapnyId, $name, $comapnySize, $city, $website, $clientId) {
        $this->comapnyId = $comapnyId;
        $this->name = $name;
        $this->comapnySize = $comapnySize;
        $this->city = $city;
        $this->website = $website;
        $this->clientId = $clientId;
    }
    
    function addCompanyDetails() {
//        if ($this->isValid()) {
//            try {
//                $db = Database::getInstance();
//                // TODO: get client_id from cookie
//                $q = "INSERT INTO dbProj_CompanyDetails (company_id, name, company_size, city, website, client_id)
//                 VALUES (NULL,' $this->name','$this->comapnySize','$this->city','$this->website','$this->clientId')"; 
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
            $this->name = $db->sanitizeString($this->name);
            $this->comapnySize = $db->sanitizeString($this->comapnySize);
            $this->city = $db->sanitizeString($this->city);
            $this->website = $db->sanitizeString($this->website);
            
            if ($this->comapnyId == null) {
                $q = "INSERT INTO dbProj_CompanyDetails (name, company_size, city, website, client_id) VALUES (?,?,?,?,?)";
            } else {
                $q = "UPDATE dbProj_CompanyDetails set
			name = ?, company_size = ?, city = ?, website = ? WHERE company_id = ?";
            }
            
            $stmt = mysqli_prepare($db->getDatabase(), $q);
            if (!$stmt) {
                $db->displayError($q);
                return false;
            }
            if ($this->comapnyId == null) {
                $stmt->bind_param('sissi', $this->name, $this->comapnySize, $this->city, $this->website, $this->clientId);
            } else {
                $stmt->bind_param('sissi', $this->name, $this->comapnySize, $this->city, $this->website, $this->comapnyId);
            }
                
                

            if (!$stmt->execute()) {
                var_dump($stmt);
                echo 'Execute Failed';
                $db->displayError($q);
                return false;
            }
            
            if ($this->comapnyId == null) {
                $this->comapnyId = mysqli_insert_id($db->getDatabase());
            }
            
            return true;
            
        }
        
    }
    
    function initWithClientId() {
        $db = Database::getInstance();
        $data = $db->singleFetch("SELECT * FROM dbProj_CompanyDetails WHERE client_id = '$this->clientId'");
        $this->initWith($data->company_id, $data->name, $data->company_size, $data->city, $data->website, $data->client_id);
//        var_dump($data);
        if ($data != null) {
            return false;
        }
        return true;
    }
    
    
    function getCompanyDetail() {
        $db = Database::getInstance();
        $data = $db->singleFetch("SELECT * FROM dbProj_CompanyDetails WHERE client_id = '$this->clientId'");
        if ($data == null) {
            return false;
        }
        return true;
    }
    
    function updateCompanyDetails() {
        
        
        $db = new Database();
        if ($this->isValid()) {
            $this->name = $db->sanitizeString($this->name);
            $this->comapnySize = $db->sanitizeString($this->comapnySize);
            $this->city = $db->sanitizeString($this->city);
            $this->website = $db->sanitizeString($this->website);
            
            $q = "UPDATE dbProj_CompanyDetails set
			name = ?, company_size = ?, city = ?, website = ? WHERE client_id = '$this->clientId';";
            
            $stmt = mysqli_prepare($db->getDatabase(), $q);
            if ($stmt) {
                $stmt->bind_param('siss', $this->name, $this->comapnySize, $this->city, $this->website);
                
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
        
//        if ($this->isValid()) {
//            try {
//                $db = Database::getInstance();
//                $data = "UPDATE dbProj_CompanyDetails
//                        SET name = '$this->name',
//                            company_size = '$this->comapnySize',
//                            city = '$this->city',
//                            website = '$this->website'
//                        WHERE client_id = '$this->clientId'";
//                $db->querySql($data);
//                return true;
//            } catch (Exception $ex) {
//                echo 'Exception: ' . $ex;
//                return false;
//            }
//        } 
//        else {
//            return false;
//        }
    }
    
    function getAllCompanyDetails() {
        $db = Database::getInstance();
        $data = $db->multiFetch("SELECT * FROM dbProj_CompanyDetails");
        return $data;
    }
    
    public function isValid() {
        $errors = true;

        if (empty($this->name))
            $errors = false;
        
        if (empty($this->comapnySize))
            $errors = false;
        
        if (empty($this->city))
            $errors = false;

//        if (empty($this->website))
//            $errors = false;

        return $errors;
    }
    
    public static function deleteCompanyDetail($clientIdIn) {
        $db = new Database();
        $clientId = $db->sanitizeString($clientIdIn);
        $q = "DELETE FROM dbProj_CompanyDetails WHERE client_id = ?";

        $stmt = mysqli_prepare($db->getDatabase(), $q);
        if (!$stmt) {
            $db->displayError($q);
            return false;
        }
        $stmt->bind_param('i', $clientId);

        if (!$stmt->execute()) {
            var_dump($stmt);
            echo 'Execute Failed';
            $db->displayError($q);
            return false;
        }
        return true;
    }
    
    public function getComapnyId() {
        return $this->comapnyId;
    }

    public function getName() {
        return $this->name;
    }

    public function getComapnySize() {
        return $this->comapnySize;
    }

    public function getClientId() {
        return $this->clientId;
    }
    
    public function getCity() {
        return $this->city;
    }

    public function getWebsite() {
        return $this->website;
    }
    
    public function setComapnyId($comapnyId) {
        $this->comapnyId = $comapnyId;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function setComapnySize($comapnySize) {
        $this->comapnySize = $comapnySize;
    }
    
    public function setCity($city) {
        $this->city = $city;
    }

    public function setWebsite($website) {
        $this->website = $website;
    }

    
    public function setClientId($clientId) {
        $this->clientId = $clientId;
    }

}
