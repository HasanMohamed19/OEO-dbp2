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
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
        <link rel="stylesheet" href="./styles/styles.css">
        
        <!-- fontawesome links-->
        <script src="https://kit.fontawesome.com/a96d123e51.js" crossorigin="anonymous"></script>
        
        <!--AJAX-->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        
    </head>
    <body>
    <!--<div class="container main">-->
        <!-- Header -->
        <nav class="navbar navbar-expand-lg bg-body-tertiary">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">
                    <img src="./images/DBLogo.svg" height="50" width="100"/>
                    <!--<svg id="Layer_1_copy" data-name="Layer 1 copy" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 2084 1165.74"><defs><style>.cls-1{fill:#2261ab;}</style></defs><path class="cls-1" d="M1537.5,169.5h-1018c-204.33,0-370,165.88-370,370.5s165.65,370.5,370,370.5h1018c204.31,0,369.93-165.9,369.93-370.5S1741.81,169.53,1537.5,169.5Zm-1016,733c-200.48,0-363-162.52-363-363s162.52-363,363-363,363,162.52,363,363S722,902.5,521.5,902.5Zm1015,0a362.17,362.17,0,0,1-275-126h-323v-175h240.28a366.19,366.19,0,0,1,3.8-143H938.5v-151h318.81c66.58-80,166.93-131,279.19-131,200.48,0,363,162.52,363,363S1737,902.5,1536.5,902.5Z"/><circle class="cls-1" cx="521" cy="540" r="143"/><circle class="cls-1" cx="1532" cy="539" r="143"/></svg>-->
                </a>

<!--              <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>-->

              <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a id="home" class="nav-link" aria-current="page" href="index.php">Home</a>
                    </li>
                    
                    <?php
                        if ($userName == 'admin') {
                            
                            echo '<li class="nav-item">
                                    <a id="all-bookings" class="nav-link" href="displayViewBookings.php">Reservations</a>
                                </li>';
                            
                            echo '<li class="nav-item">
                                    <a id="halls" class="nav-link" href="Admin_ViewHalls.php">Halls</a>
                                </li>';
                            
                            echo '<li class="nav-item">
                                    <a id="services" class="nav-link" href="Admin_ViewServices.php">Catering</a>
                                </li>';
                            
                            echo '<li class="nav-item">
                                    <a id="clients" class="nav-link" href="Admin_ViewClients.php">Clients</a>
                                </li>';    
                            
                            echo '<li class="nav-item">
                                    <a id="dashboard" class="nav-link" href="Admin_ViewStatistics.php">Dashboard</a>
                                </li>';
                        } else {
                            echo '<li class="nav-item">
                                    <a id="halls" class="nav-link" href="halls.php">Halls</a>
                                </li>';
                            
                            echo '<li class="nav-item">
                                    <a id="my-account" class="nav-link" href="displayMyAccount.php">My Account</a>
                                </li>';
                            
                        }
                    ?>
                  
                  
                  
<!--                  <li class="nav-item">
                    <a class="nav-link" href="#">Royalty Points</a>
                  </li>-->
                  <li class="nav-item">
                    <a id="about" class="nav-link" href="aboutUs.php">About Us</a>
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

