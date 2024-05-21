<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

/**
 * Description of CompanyDetails
 *
 * @author Hassan
 */
const GENDER_MALE = 'M';
const GENDER_FEMALE = 'F';

class PersonalDetails {

    private $personalDetialId;
    private $firstName;
    private $lastName;
//    private $department;
    private $dob;
    private $gender;
    private $nationality;
    private $clientId;

    public function __construct() {
        $this->personalDetialId = null;
        $this->firstName = null;
        $this->lastName = null;
        $this->dob = null;
        $this->gender = null;
        $this->nationality = null;
        $this->clientId = null;
    }

    public function initWith($personalDetialId, $firstName, $lastName, $dob, $gender, $nationality, $clientId) {
        $this->personalDetialId = $personalDetialId;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->dob = $dob;
        $this->gender = $gender;
        $this->nationality = $nationality;
        $this->clientId = $clientId;
    }

    function addPersonalDetails() {
//        if ($this->isValid()) {
//            try {
//                $db = Database::getInstance();
//                // TODO: get client_id from cookie
//                $q = "INSERT INTO dbProj_PersonalDetails (personal_details_id, first_name, last_name, dob, gender, nationality, client_id)
//                 VALUES (NULL,' $this->firstName','$this->lastName','$this->dob','$this->gender','$this->nationality','$this->clientId')"; 
//                $data = $db->querySql($q);
//                var_dump($q);
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
            $this->firstName = $db->sanitizeString($this->firstName);
            $this->lastName = $db->sanitizeString($this->lastName);
            $this->dob = $db->sanitizeString($this->dob);
            $this->gender = $db->sanitizeString($this->gender);
            $this->nationality = $db->sanitizeString($this->nationality);

            $q = "INSERT INTO dbProj_PersonalDetails (first_name, last_name, dob, gender, nationality, client_id) VALUES (?,?,?,?,?,?)";

            $stmt = mysqli_prepare($db->getDatabase(), $q);
            if ($stmt) {
                $stmt->bind_param('sssssi', $this->firstName, $this->lastName, $this->dob, $this->gender, $this->nationality, $this->clientId);

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

    function initWithClientId() {
        $db = Database::getInstance();
        $data = $db->singleFetch("SELECT * FROM dbProj_PersonalDetails WHERE client_id = '$this->clientId'");
        $this->initWith($data->personal_details_id, $data->first_name, $data->last_name, $data->dob, $data->gender, $data->nationality, $data->client_id);
//        var_dump($data);
        if ($data != null) {
            return false;
        }
        return true;
    }

    function getPersonalDetail() {
        $db = Database::getInstance();
        $data = $db->singleFetch("SELECT * FROM dbProj_PersonalDetails WHERE client_id = '$this->clientId'");
//        var_dump($data);
        if ($data == null) {
            return false;
        }
        return true;
    }

    function getAllPersonalDetails() {
        $db = Database::getInstance();
        $data = $db->multiFetch("SELECT * FROM dbProj_PersonalDetails");
        return $data;
    }

    function updatePersonalDetails() {
        $db = new Database();

        if ($this->isValid()) {
            $this->firstName = $db->sanitizeString($this->firstName);
            $this->lastName = $db->sanitizeString($this->lastName);
            $this->dob = $db->sanitizeString($this->dob);
            $this->gender = $db->sanitizeString($this->gender);
            $this->nationality = $db->sanitizeString($this->nationality);

            $q = "UPDATE dbProj_PersonalDetails set
			first_name = ?, last_name = ?, dob = ?, gender = ?, nationality = ? WHERE client_id = '$this->clientId';";

            $stmt = mysqli_prepare($db->getDatabase(), $q);
            if ($stmt) {
                $stmt->bind_param('sssss', $this->firstName, $this->lastName, $this->dob, $this->gender, $this->nationality);

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
        return false;
//        if ($this->isValid()) {
//            try {
//                $db = Database::getInstance();
//                $data = "UPDATE dbProj_PersonalDetails
//                        SET first_name = '$this->firstName',
//                            last_name = '$this->lastName',
//                            dob = '2025-5-5',
//                            gender = '$this->gender',
//                            nationality = '$this->nationality'
//                        WHERE client_id = '$this->clientId';   ";
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

    public function isValid() {
        $errors = true;

        if (empty($this->firstName))
            $errors = false;

        if (empty($this->lastName))
            $errors = false;

        if (empty($this->dob))
            $errors = false;

        if (empty($this->gender))
            $errors = false;

        if (empty($this->nationality))
            $errors = false;

        return $errors;
    }

    public function getPersonalDetialId() {
        return $this->personalDetialId;
    }

    public function getFirstName() {
        return $this->firstName;
    }

    public function getLastName() {
        return $this->lastName;
    }

    public function getDepartment() {
        return $this->department;
    }

    public function getDob() {
        return $this->dob;
    }

    public function getAge() {
        // calculate age
    }

    public function getGender() {
        return $this->gender;
    }

    public function getNationality() {
        return $this->nationality;
    }

    public function getClientId() {
        return $this->clientId;
    }

    public function setPersonalDetialId($personalDetialId) {
        $this->personalDetialId = $personalDetialId;
    }

    public function setFirstName($firstName) {
        $this->firstName = $firstName;
    }

    public function setLastName($lastName) {
        $this->lastName = $lastName;
    }

    public function setDepartment($department) {
        $this->department = $department;
    }

    public function setDob($dob) {
        $this->dob = $dob;
    }

    public function setGender($gender) {
        $this->gender = $gender;
    }

    public function setNationality($nationality) {
        $this->nationality = $nationality;
    }

    public function setClientId($clientId) {
        $this->clientId = $clientId;
    }
        public static function deletePersonalDetail($clientIdIn) {
        $db = new Database();
        $clientId = $db->sanitizeString($clientIdIn);
        $q = "DELETE FROM dbProj_PersonalDetails WHERE client_id = ?";

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
}
