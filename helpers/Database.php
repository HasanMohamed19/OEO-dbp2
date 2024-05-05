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
    private $dbName = "db202101277";
    private $userName = "u202101277";
    private $password = "u202101277";
    
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
    
}
