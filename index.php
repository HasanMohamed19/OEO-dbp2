<?php



//session_start();
//setcookie('userId', '1', time() + 60 * 60 * 24 * 7, '/');

//echo 'This is cookie: '.$_COOKIE['userId'];
//echo 'This is session: '.$_SESSION['userId'];
//include 'helpers/Database.php';
//include 'models/Hall.php';
//include 'debugging.php';
//$hall = new Hall();
//$halls = $hall->getPopularHalls();
//echo 'number of halls found ' . count($halls);


include './template/header.html';
    
include './template/home2.php';

include './template/footer.html';
?>
