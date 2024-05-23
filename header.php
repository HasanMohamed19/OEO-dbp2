<?php

session_start();

$userId = $_COOKIE['userId'];
$userName = $_COOKIE['username'];

$title = '';

switch (basename($_SERVER['PHP_SELF'])) {

  case ('index.php') : $title = 'OEO Home page'; break;
  case ('halls.php') : $title = 'Halls page'; break;
  case ('displayMyAccount.php') : $title = 'My Account'; break;
  case ('aboutUs.php') : $title = 'About Us'; break;
  case ('login.php') : $title = 'Login'; break;
  case ('verifyCode.php') : $title = 'Forget Passwrod'; break;
  case ('forgetPassword.php') : $title = 'Forget Password'; break;
  case ('register.php') : $title = 'Register Page'; break;
  case ('displayViewBookings.php') : $title = 'Reservations'; break;
  case ('Admin_ViewHalls.php.php') : $title = 'Manage Halls'; break;
  case ('Admin_ViewServices.php') : $title = 'Manage Services'; break;
  case ('Admin_ViewClients.php') : $title = 'Manage Clients'; break;
  case ('Admin_ViewStatistics.php') : $title = 'Admin Dashboard'; break;
}

?>

<!DOCTYPE html>
<html>
    <head>
        <title><?php echo $title ?></title>
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
                <a class="navbar-brand" href="index.php">
                    <img src="./images/DBLogo.svg" height="50" width="100"/>
                    
                </a>

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
                            
                            if (isset($_COOKIE['userId'])) {
                               echo '<li class="nav-item">
                                    <a id="my-account" class="nav-link" href="displayMyAccount.php">My Account</a>
                                </li>'; 
                            }                            
                        }
                    ?>
                  
                  
                  <li class="nav-item">
                    <a id="about" class="nav-link" href="aboutUs.php">About Us</a>
                  </li>
                </ul>
                  <!--<li class="nav-item">-->
                 <?php
                    if (!isset($userId)) {                        
                        echo '<a type="button" class="btn btn-primary" href="login.php">Login</a>';
                    } else {
                        echo '<div class="row">';
                        echo '<span class="col align-self-center">' . $_COOKIE['username'] . '</span>';
                        echo '<a type="button" class="btn btn-primary col" href="logout.php">Logout</a>';
                        echo '</div>';
                    }
                 ?>
                  
              </div>
            </div>
        </nav>
        