<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

/**
 * Description of User
 *
 * @author Hassan
 */

const ROLE_ADMIN = 1;
const ROLE_CLIENT = 2;
const ROLE_EMPLOYEE = 3;
const SALT= 'B4baB00eY';

class User {
    private $userId;
    private $username;
    private $password;
    private $email;
    private $roleId;
    
    public function __construct() {
        $this->userId = null;
        $this->username = null;
        $this->password = null;
        $this->email = null;
        $this->roleId = null;
    }
    
    public function initWith($userId, $username, $password, $email, $roleId) {
        $this->userId = $userId;
        $this->username = $username;
        $this->password = $password;
        $this->email = $email;
        $this->roleId = $roleId;
    }

    function initWithUserid($userid) {
        $db = Database::getInstance();
        $data = $db->singleFetch('SELECT * FROM dbProj_User WHERE user_id = ' . $userid);
        $this->initWith($data->user_id, $data->username, $data->password, $data->email, $data->role_id);
    }

    public function isValid() {
        $errors = true;

        if (empty($this->username))
            $errors = false;
        
        if (empty($this->password))
            $errors = false;
        
        if (empty($this->email))
            $errors = false;

        if (empty($this->roleId))
            $errors = false;

        return $errors;
    }
    
    // function getRoldId(UserRole $role) {
        
    // }

    function registerUser() {
        include_once  "./helpers/Database.php";
        if ($this->isValid()) {
//                    echo "username $this->username, password $this->password";
            $this->username = $this->sanitizeString($this->username);
            $this->password = $this->sanitizeString($this->password);
            $this->email    = $this->sanitizeString($this->email);
            
            if ($this->userId == null) {
                $q = 'INSERT INTO dbProj_User (username, password, email, role_id) values'
                        . '(?,AES_ENCRYPT(?, "'.SALT.'"),?,?)';
            } else {
                // assuming role_id never changes
                $q = "UPDATE dbProj_User SET "
                        . "username='?', password=AES_ENCRYPT(?, '".SALT."'), email='?'"
                        . "WHERE user_id=?";
            }
            
            $db = new Database();
            
            $stmt = mysqli_prepare($db->getDatabase(),$q);
            if ($stmt) {
                if ($this->userId == null) {
                    $stmt->bind_param('sssi', $this->username, $this->password, $this->email, $this->roleId);
                } else {
                    $stmt->bind_param('sssi', $this->username, $this->password, $this->email, $this->userId);
                }
                if (!$stmt->execute()) {
                    var_dump($stmt);
                    echo 'Execute failed';
                    $this->displayError($q);
                    return false;
                }
            } else {
                $this->displayError($q);
                return false;
            }
//            try {
//                $db = Database::getInstance();
//                $q = 'INSERT INTO dbProj_User (user_id, username, password, email, role_id)
//                 VALUES (NULL, \'' . $this->username . '\',\'' . $this->password . '\',\'' . $this->email . '\',' . $this->roleId . ')';
//                $data = $db->querySql($q);
//                var_dump($q);
//                 return true;
//            } catch (Exception $e) {
//                echo 'Exception: ' . $e;
//                return false;
//            }
        } else {
            return false;
        }
        return true;
    }

    function sanitizeString($var) {
        include_once  "./helpers/Database.php";
        $db = new Database();
       $var = strip_tags($var);
       $var = htmlentities($var);
       $var = stripslashes($var);
       return mysqli_real_escape_string($db->getDatabase(), $var);
   }
    
    function checkUser($username, $password) {
        $db = Database::getInstance();
        $data = $db->singleFetch("SELECT * FROM dbProj_User WHERE username = '$username' AND password = '$password'");
//        var_dump($data);
        $this->initWith($data->user_id, $data->username, $data->password, $data->email, $data->role_id);
    }
    
    function getClientByUserId() {
        $db = Database::getInstance();
        $data = $db->singleFetch("SELECT client_id FROM dbProj_Client WHERE user_id = '$this->userId'");
//        var_dump($data);
        return $data;
    }

    function initWithUsername() {

        $db = Database::getInstance();
        $data = $db->singleFetch('SELECT * FROM dbProj_User WHERE username = \'' . $this->username . '\'');
        if ($data != null) {
            return false;
        }
        return true;
    }

    function initWithEmail() {

        $db = Database::getInstance();
        $data = $db->singleFetch('SELECT * FROM dbProj_User WHERE email = \'' . $this->email . '\'');
        if ($data != null) {
            return false;
        }
        return true;
    }

    function getAllUsers() {
        $db = Database::getInstance();
        $data = $db->multiFetch("Select * from dbProj_User");
        return $data;
    }
    
    function displayError($q) {
        include_once  "./helpers/Database.php";
        $db = new Database();
        echo 'Error occured: ';
        var_dump($q);
        echo 'error:'.mysqli_error($db->getDatabase());
    }
    
    public function getUserId() {
        return $this->userId;
    }

    public function getUsername() {
        return $this->username;
    }

    public function getPassword() {
        return $this->password;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getRoleId() {
        return $this->roleId;
    }

    public function setUserId($userId) {
        $this->userId = $userId;
    }

    public function setUsername($username) {
        $this->username = $username;
    }

    public function setPassword($password) {
        $this->password = $password;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function setRoleId($roleId) {
        $this->roleId = $roleId;
    }

}