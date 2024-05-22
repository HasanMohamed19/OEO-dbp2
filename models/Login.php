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

        if (!empty($_SESSION['userId'])) {
            $this->ok = true;
            return true;
        }
        else
            return false;
    }

    function check_cookie() {
        if (!empty($_COOKIE['userId'])) {
            $this->ok = true;
            return $this->check($_COOKIE['userId']);
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
             
            $clientId = $this->checkClient($this->getUserId());
            echo $clientId . " this is client id";
            if ($clientId != null && $clientId > 0) {
                $_SESSION['clientId'] = $clientId();
                setcookie('clientId', $_SESSION['clientId'], time() + 60 * 60 * 24 * 7, '/', $this->domain);
            }
            
            return true;
        }
        else
            $error[] = 'Wrong Username';


        return false;
    }
    
    function checkClient($userId) {
        $db = Database::getInstance();
        $q = "SELECT client_id FROM dbProj_Client WHERE user_id = ?";
        
        $stmt = mysqli_prepare($db->getDatabase(),$q);
            if ($stmt) {
                // this works:
//                ($stmt);
                $stmt->bind_param('i', $userId);
                
                if (!$stmt->execute()) {
                    echo 'Execute failed';
                    $db->displayError($q);
                    return null;
                } else {
//                    echo 'Execute successed';
                    $result = $stmt->get_result();
                    $data = $result->fetch_array(MYSQLI_ASSOC);
//                    ($data);
                    return $data["client_id"];
                }
                
            } else {
                $db->displayError($q);
                return null;
            }
    }

    function login($username, $password) {

        try {
            $this->checkUser($username, $password);
            if ($this->getUserId() != null) {
                $this->ok = true;
                $_SESSION['userId'] = $this->getUserId();
                $_SESSION['username'] = $this->getUsername();
                $_SESSION['clientId'] = $this->checkClient($_SESSION['userId']);
                echo 'client id from login: ' . $this->checkClient($_SESSION['userId']);
                setcookie('userId', $_SESSION['userId'], time() + 60 * 60 * 24 * 7, '/', $this->domain);
                setcookie('username', $_SESSION['username'], time() + 60 * 60 * 24 * 7, '/', $this->domain);
                setcookie('clientId', $_SESSION['clientId'], time() + 60 * 60 * 24 * 7, '/', $this->domain);

                return true;
            } else {
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
