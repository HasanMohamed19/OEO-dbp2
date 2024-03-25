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
    private $host = "";
    private $dbName = "";
    private $userName = "";
    private $password = "";
    
    // singleton
    public static $instance = null;
    public $dblink = null;
    
    public function __construct() {
        if (is_null($this->dblink)) {
            $this->connect();
        }
    }
    
    function connect() {
        $this->dblink = mysqli_connect($this->host, $this->userName, $this->password, $this->password) or die("Can Not Connect!");
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
