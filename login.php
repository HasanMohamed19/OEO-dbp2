<?php
include 'header.php';
 include 'debugging.php';
 include './helpers/Database.php';
include './models/User.php';
include './models/Login.php';

    if (!empty($_COOKIE['userId'])) {
        header('Location: myAccount.php');
    }

    if (isset($_POST['submitted'])) {
    $db = new Database();
    $login = new Login();
    $username = $_POST['username'];
    $password = $_POST['password'];
//     echo 'manually: ' . $login->login($username, $password) . ' is';
//    if ($login->login($username, $password)) {
////        header('Location: index.php');
//        echo "Success";
//    } else {
//        echo $error = "Wrong Credintals";
//    }

     if ($login->login($username, $password)) {
         header("Location: myAccount.php");
         echo 'Logged in successfully';
     } else {
//         header("Location: viewBookings.php");
         echo '<p class="error"> Wrong Login Values </p>';
     }
}



include './template/header.html';
// start_session();


//    echo "bababooey lol";
//    session_start();
//    setcookie('userId', '3', time() + 60 * 60 * 24 * 7, '/');
//    echo $_COOKIE['userId'] . " this is the cookie";
//    echo $_SESSION['userId'] . ": session id";
echo '<div class="main">';
include './template/login.html';
echo  '</div>';

include './template/footer.html';

