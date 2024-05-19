<?php

// include './models/Login.php';

session_start();


// ini_set('show_errors', 'On');
// ini_set('display_errors', 1);
// error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);

// function __autoload($className){
//     include_once  $className.'.php';
// }


// $obj = new Login();
// if (!$obj->ok) {
//     if($_SERVER['PHP_SELF'] != '/~u202101277/OEOProject/login.php'){
//         header('Location: login.php');
//         die();
//     }    
// }

$userId = $_COOKIE['userId'];
$userName = $_COOKIE['username'];

?>

<!DOCTYPE html>
<html>
    <head>
        <title>OEO Homepage</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- Bootstrap links -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
        <script src="./helpers/jquery-3.7.1.min.js"></script>
        <link rel="stylesheet" href="./styles/styles.css">

        <!-- fontawesome links-->
        <script src="https://kit.fontawesome.com/a96d123e51.js" crossorigin="anonymous"></script>
        
    </head>
    <body>
    <!--<div class="container main">-->
        <!-- Header -->
        <nav class="navbar navbar-expand-lg bg-body-tertiary">
            <div class="container-fluid">
              <a class="navbar-brand me-5" href="#">OEO</a>

              <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>

              <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="index.php">Home</a>
                    </li>
                    
                    <?php
                        if ($userName == 'admin') {
                            
                            echo '<li class="nav-item">
                                    <a class="nav-link" href="displayViewBookings.php">Reservations</a>
                                </li>';
                            
                            echo '<li class="nav-item">
                                    <a class="nav-link" href="Admin_ViewHalls.php">Halls</a>
                                </li>';
                            
                            echo '<li class="nav-item">
                                    <a class="nav-link" href="Admin_ViewServices.php">Catering</a>
                                </li>';
                            
                            echo '<li class="nav-item">
                                    <a class="nav-link" href="Admin_ViewClients.php">Clients</a>
                                </li>';                          
                        } else {
                            echo '<li class="nav-item">
                                    <a class="nav-link" href="halls.php">Halls</a>
                                </li>';
                            
                            echo '<li class="nav-item">
                                    <a class="nav-link" href="displayMyAccount.php">My Account</a>
                                </li>';
                            
//                            echo '<li class="nav-item">
//                                    <a class="nav-link" href="Admin_ViewClients.php">Clients</a>
//                                </li>';
                        }
                    ?>
                  
                  
                  
<!--                  <li class="nav-item">
                    <a class="nav-link" href="#">Royalty Points</a>
                  </li>-->
                  <li class="nav-item">
                    <a class="nav-link" href="aboutUs.php">About Us</a>
                  </li>
                </ul>
                  <!--<li class="nav-item">-->
                 <?php
                    if (!isset($userId)) {
//                        echo '<button type="button" class="btn btn-primary" onclick="window.location.href="login.php"">Login</button>';
                        
                        echo '<a type="button" class="btn btn-primary" href="login.php">Login</a>';
                    } else {
                        echo '<div class="row">';
                        echo '<span class="col align-self-center">' . $_COOKIE['username'] . '</span>';
                        echo '<a type="button" class="btn btn-primary col" href="logout.php">Logout</a>';
                        echo '</div>';
                    }
                 ?>
                  <!--</li>-->
                  
                
              </div>
            </div>
        </nav>
        
       
        
        
    <!--</div>-->

