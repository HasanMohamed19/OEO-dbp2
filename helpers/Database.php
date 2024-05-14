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
    private $host = "localhost";
    private $dbName = "db202101277";
    private $userName = "u202101277";
    private $password = "u202101277";
    
    // singleton
    public static $instance = null;
    public $dblink = null;

    public function getDatabase() {
        return $this->dblink;
    }
    
    public static function getInstance() {
        if (is_null(self::$instance)) {
            self::$instance = new Database ( );
        }
        return self::$instance;
    }
    
    public function __construct() {
        if (is_null($this->dblink)) {
            $this->connect();
        }
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
    function querySQL($sql) {
        if ($sql != null || $sql != '') {
            mysqli_query($this->dblink, $sql);
        }
    }

    function singleFetch($sql) {
        $sql = $this->mkSafe($sql);
        $fet = null;
        if ($sql != null || $sql != '') {
            $res = mysqli_query($this->dblink, $sql);
            $fet = mysqli_fetch_object($res);
        }
        return $fet;
    }

    function multiFetch($sql) {
        $sql = $this->mkSafe($sql);
        $result = null;
        $counter = 0;
        if ($sql != null || $sql != '') {
            $res = mysqli_query($this->dblink, $sql);
            while ($fet = mysqli_fetch_object($res)) {
                $result[$counter] = $fet;
                $counter++;
            }
        }
        return $result;
    }

    function mkSafe($string) {
        /* $string = strip_tags($string);
          if (!get_magic_quotes_gpc()) {
          $string = addslashes($string);
          } else {
          $string = stripslashes($string);
          }
          $string = str_ireplace("script", "blocked", $string);
          $string = addcslashes($escaped, '%_');

          $string = trim($string);*/
          //$newString = mysqli_escape_string($this->dblink, $string); 

        return $string;
    }

    function getRows($sql) {
        $rows = 0;
        if ($sql != null || $sql != '') {
            $result = mysqli_query($this->dblink, $sql);
            $rows = mysqli_num_rows($result);
        }
        return $rows;
    }
    
    function sanitizeString($var) {
       $var = strip_tags($var);
       $var = htmlentities($var);
       $var = stripslashes($var);
       return mysqli_real_escape_string($this->dblink, $var);
   }
   
   function displayError($q) {
        echo 'Error occured: ';
        var_dump($q);
        echo 'error:'.mysqli_error($this->dblink);
    }
    
}