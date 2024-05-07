<?php

// include 'header.php';

include 'debugging.php';
include './template/header.html';
    
echo '<div class="main">';
include './template/login.html';
echo  '</div>';

include './template/footer.html';

include './helpers/Database.php';
include './models/User.php';
include './models/Login.php';

if (isset($_POST['submitted'])) {
    $login = new Login();
    $username = $_POST['username'];
    $password = $_POST['password'];

    // echo 'manually: ' . $login->login($username, $password) . ' is';
    
    if ($login->login($username, $password)) {
        echo "Success";
    } else {
        echo "Wrong Credintals";
    }

    // if ($login->login($username, $password)) {
    //     header("Location: myAccount.php");
    //     echo 'Logged in successfully';
    // } else {
    //     header("Location: viewBookings.php");
    //     echo '<p class="error"> Wrong Login Values </p>';
    // }
}