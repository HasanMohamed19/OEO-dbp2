<?php

Class Login extends User {

    public $ok;
    public $salt;
    public $domain;

    function __construct() {
        parent::__construct();
        $this->ok = false;
        $this->salt = 'ENCRYPT';
        $this->domain = '';

        if (!$this->check_session())
            $this->check_cookie();

        return $this->ok;
    }

    function check_session() {

        if (!empty($_SESSION['uid'])) {
            $this->ok = true;
            return true;
        }
        else
            return false;
    }

    function check_cookie() {
        if (!empty($_COOKIE['uid'])) {
            $this->ok = true;
            return $this->check($_COOKIE['uid']);
        }
        else
            return false;
    }

    function check($userId) {
        $this->initWithUserid($userId);
        if ($this->getUserId() != null && $this->getUserId() == $userId) {
            $this->ok = true;
            $_SESSION['userId'] = $this->getUserId();
            $_SESSION['username'] = $this->getUsername();
            setcookie('userId', $_SESSION['userId'], time() + 60 * 60 * 24 * 7, '/', $this->domain);
            setcookie('username', $_SESSION['username'], time() + 60 * 60 * 24 * 7, '/', $this->domain);

            return true;
        }
        else
            $error[] = 'Wrong Username';


        return false;
    }

    function login($username, $password) {

        try {
            $this->checkUser($username, $password);
            echo 'login function first echo: ';
            // echo 'User: ' . $this->getUsername() . 'password    ' . $this->getPassword();
            if ($this->getUserId() != null) {
                $this->ok = true;
                echo '<h1>Inside login function</h1>';
                $_SESSION['userId'] = $this->getUserId();
                $_SESSION['username'] = $this->getUsername();
                setcookie('userId', $_SESSION['userId'], time() + 60 * 60 * 24 * 7, '/', $this->domain);
                setcookie('username', $_SESSION['username'], time() + 60 * 60 * 24 * 7, '/', $this->domain);

                return true;
            } else {
                echo 'NULLLLL';
                $error[] = 'Wrong Username OR password';
            }
            return false;
        } catch (Exception $e) {
            $error[] = $e->getMessage();
        }

        return false;
    }

    function logout() {
        $this->ok = false;
        $_SESSION['userId'] = '';
        $_SESSION['username'] = '';
        setcookie('userId', '', time() - 3600, '/', $this->domain);
        setcookie('username', '', time() - 3600, '/', $this->domain);
        session_destroy();
    }

}