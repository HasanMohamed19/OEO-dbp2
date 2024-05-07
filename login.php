<?php
include './template/header.html';
include 'header.php';
// start_session();

// include 'debugging.php';

    
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
        header('Location: index.php');
        echo "Success";
    } else {
        echo $error = "Wrong Credintals";
    }

    // if ($login->login($username, $password)) {
    //     header("Location: myAccount.php");
    //     echo 'Logged in successfully';
    // } else {
    //     header("Location: viewBookings.php");
    //     echo '<p class="error"> Wrong Login Values </p>';
    // }
}