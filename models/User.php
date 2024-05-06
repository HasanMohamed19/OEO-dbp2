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

enum UserRole {
    case client;
    case employee;
    case admin;
}

class User {
    private $userId;
    private $username;
    private $password;
    private $email;
    private UserRole $userRole;
    
    public function __construct() {
        $this->userId = null;
        $this->username = null;
        $this->password = null;
        $this->email = null;
        $this->userRole = null;
    }
    
    public function initWith($userId, $username, $password, $email, UserRole $userRole) {
        $this->userId = $userId;
        $this->username = $username;
        $this->password = $password;
        $this->email = $email;
        $this->userRole = $userRole;
    }

    public function isValid() {
        $errors = true;

        if (empty($this->username))
            $errors = false;
        
        if (empty($this->password))
            $errors = false;
        
        if (empty($this->email))
            $errors = false;

        if (empty($this->userRole))
            $errors = false;

        return $errors;
    }

    // function getRoldId(UserRole $role) {
        
    // }

    function registerUser() {
        if ($this->isValid()) {
            try {
                $db = Database::getInstance();
                $data = $db->querySql('INSERT INTO dbProj_User (uid, user_name, password, email, role_id)
                 VALUES (NULL, \'' . $this->username . '\',\'' . $this->firstname . '\',\'' . $this->lastname . 
                 '\',\'' . $this->password . '\',\'' . $this->email . '\')');
                 return true;
            } catch (Exception $e) {
                echo 'Exception: ' . $e;
                return false;
            }
        } else {
            return false;
        }
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
        $data = $db->singleFetch('SELECT * FROM dbProj_User WHERE username = \'' . $this->email . '\'');
        if ($data != null) {
            return false;
        }
        return true;
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

    public function getUserRole(): UserRole {
        return $this->userRole;
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

    public function setUserRole(UserRole $userRole) {
        $this->userRole = $userRole;
    }

}