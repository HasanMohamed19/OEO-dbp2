<?php

ini_set('show_errors', 'On');
ini_set('display_errors', 1);
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);

spl_autoload_register(function($className){
    include_once  './models/'.$className.'.php';
});

?>