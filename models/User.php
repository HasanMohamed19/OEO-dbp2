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
include_once 'helpers/Database.php';

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
        if ($this->isValid()) {
            try {
                $db = Database::getInstance();
                $q = 'INSERT INTO dbProj_User (user_id, username, password, email, role_id)
                 VALUES (NULL, \'' . $this->username . '\',\'' . $this->password . '\',\'' . $this->email . '\',' . $this->roleId . ')';
                $data = $db->querySql($q);
                var_dump($q);
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