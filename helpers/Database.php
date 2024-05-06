<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

/**
 * Description of Database
 *
 * @author Hassan
 */
class Database {

    // DB connection parameters
    private $host = "20.126.5.244";
    private $dbName = "db202100523";
    private $userName = "u202100523";
    private $password = "u202100523";
    // singleton
    public static $instance = null;
    public $dblink = null;

    public function __construct() {
        if (is_null($this->dblink)) {
            $this->connect();
        }
    }

    public static function getInstance() {
        if (is_null(self::$instance)) {
            self::$instance = new Database ( );
        }
        return self::$instance;
    }

    function connect() {
        $this->dblink = mysqli_connect($this->host, $this->userName, $this->password, $this->dbName) or die("Can Not Connect!");
    }

    public function __destruct() {
        if (!is_null($this->dblink)) {
            $this->close();
        }
    }

    function close() {
        mysqli_close($this->dblink);
    }

    // use prepared statements
    function querySql($sql) {
        if ($sql != null || $sql != '') {
            if (!mysqli_query($this->dblink, $sql)) {
                echo "<br>Error in a Query" . mysqli_error($this->dblink) . "<br>";
                return FALSE;
            } else {
                return TRUE;
            }
        } else {
            return false;
        }
    }

    function singleFetch($sql) {
        $fet = null;
        if ($sql != null || $sql != '') {
            $res = mysqli_query($this->dblink, $sql);
            $fet = mysqli_fetch_object($res);
        }
        return $fet;
    }
}
