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
    protected $userId;
    protected $username;
    protected $password;
    protected $email;
    protected $roleId;
    
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
        $db = new Database();
        if (!$this->isValid()) {
            return false;
        }
//                    echo "username $this->username, password $this->password";
        $this->username = $db->sanitizeString($this->username);
        $this->password = $db->sanitizeString($this->password);
        $this->email    = $db->sanitizeString($this->email);


        if ($this->userId == null) {
            $q = 'INSERT INTO dbProj_User (username, password, email, role_id) values'
                    . '(?,AES_ENCRYPT(?, "'.SALT.'"),?,?)';
        } else {
            // assuming role_id never changes
            $q = "UPDATE dbProj_User SET "
                    . "username='?', password=AES_ENCRYPT(?, '".SALT."'), email='?'"
                    . "WHERE user_id=?";
        }

        $stmt = mysqli_prepare($db->getDatabase(),$q);
        
        if (!$stmt) {
            $db->displayError($q);
            return false;
        }
        
        if ($this->userId == null) {
            $stmt->bind_param('sssi', 
                    $this->username, 
                    $this->password, 
                    $this->email, 
                    $this->roleId);
        } else {
            $stmt->bind_param('sssi', 
                    $this->username, 
                    $this->password, 
                    $this->email, 
                    $this->userId);
        }
        
        if (!$stmt->execute()) {
            var_dump($stmt);
            echo 'Execute failed';
            $db->displayError($q);
            return false;
        }
        // add userId if new user
        if ($this->userId == null) {
            $this->userId = mysqli_insert_id($db->getDatabase());
        }

        return true;
    }

//    function sanitizeString($var) {
//        include_once  "./helpers/Database.php";
//        $db = new Database();
//       $var = strip_tags($var);
//       $var = htmlentities($var);
//       $var = stripslashes($var);
//       return mysqli_real_escape_string($db->getDatabase(), $var);
//   }
    
    function checkUser($username, $password) {
        $db = Database::getInstance();
        $u = $db->sanitizeString($username);
        $p = $db->sanitizeString($password);
        $q = "SELECT * FROM dbProj_User WHERE username = ? AND AES_DECRYPT(password, 'B4baB00eY') = ?";
        
        $stmt = mysqli_prepare($db->getDatabase(),$q);
            if ($stmt) {
                // this works:
//                var_dump($stmt);
                $stmt->bind_param('ss', $u, $p);
//                $stmt->execute();
//                $result = $stmt->get_result();
//                $data = $result->fetch_array(MYSQLI_ASSOC);
//                var_dump($data);
//                echo $data["username"]. 'my username is';
//                $this->initWith($data["user_id"], $data["username"], $data["password"], $data["email"], $data["role_id"]);
                
                if (!$stmt->execute()) {
                    echo 'Execute failed';
                    $db->displayError($q);
                    return false;
                } else {
//                    echo 'Execute successed';
                    $result = $stmt->get_result();
                    $data = $result->fetch_array(MYSQLI_ASSOC);
//                    var_dump($data);
                    $this->initWith($data["user_id"], $data["username"], $data["password"], $data["email"], $data["role_id"]);
                }
                
            } else {
                $db->displayError($q);
                return false;
            }
//        $data = $db->singleFetch("SELECT * FROM dbProj_User WHERE username = '$username' AND AES_DECRYPT(password, 'B4baB00eY') = '$password'");
//        var_dump($stmt->fetch());
//          $data = $stmt->get_result();
//          var_dump($data);
//        $this->initWith($data->user_id, $data->username, $data->password, $data->email, $data->role_id);
        return true;
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
    
//    function displayError($q) {
//        include_once  "./helpers/Database.php";
//        $db = new Database();
//        echo 'Error occured: ';
//        var_dump($q);
//        echo 'error:'.mysqli_error($db->getDatabase());
//    }
    
        function updateUser($userId) {
        include_once  "./helpers/Database.php";
        $db = new Database();
        if ($this->isValid()) {
            $this->username = $db->sanitizeString($this->username);
            $this->password = $db->sanitizeString($this->password);
            $this->email    = $db->sanitizeString($this->email);
            // assuming role_id never changes
            $q = "UPDATE dbProj_User SET "
                . "username=?, password=AES_ENCRYPT(?, '".SALT."'), email=? "
                . "WHERE user_id=?";


            $stmt = mysqli_prepare($db->getDatabase(),$q);
            var_dump($stmt);
            if ($stmt) {
                $stmt->bind_param('sssi', $this->username, $this->password, $this->email, $userId);
//                    echo "username" . $this->username ." password ". $this->password;

                if (!$stmt->execute()) {
                    var_dump($stmt);
                    echo 'Execute failed';
                    $db->displayError($q);
                    return false;
                }
            }

            } else {
                $db->displayError($q);
                return false;
            }

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
    
    function logout() {
        $this->ok = false;
        $_SESSION['userId'] = '';
        $_SESSION['username'] = '';
        $_SESSION['clientId'] = '';
        setcookie('userId', '', time() - 3600, '/', $this->domain);
        setcookie('username', '', time() - 3600, '/', $this->domain);
        setcookie('clientId', '', time() - 3600, '/', $this->domain);
        session_destroy();
    }
    
}