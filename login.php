<?php
include 'header.php';
 include 'debugging.php';
 include './helpers/Database.php';
include './models/User.php';
include './models/Login.php';

    if (!empty($_COOKIE['userId'])) {
        header('Location: displayMyAccount.php');
    }

    if (isset($_POST['submitted'])) {
    $db = new Database();
    $login = new Login();
    $username = $_POST['username'];
    $password = $_POST['password'];


     if ($login->login($username, $password)) {
         if ($username == 'admin') {
             header("Location: Admin_ViewHalls.php");
         } else {
             header("Location: displayMyAccount.php");
         }
         
         echo 'Logged in successfully';
     } else {
//         header("Location: viewBookings.php");
         echo '<p class="error"> Wrong Login Values </p>';
     }
}



//include './template/header.html';
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

