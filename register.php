<?php
include 'debugging.php';



include './helpers/Database.php';
include './models/User.php';
include './models/Client.php';
if (isset($_POST['submitted'])) {
    $user = new User();
    $client = new Client();
    $user->setEmail($_POST['email']);
    $user->setUsername($_POST['username']);
    $user->setPassword($_POST['password']); 
    $client->setPhoneNumber($_POST['phoneNumber']);
    $user->setRoleId(ROLE_CLIENT);

    if (!$user->initWithUsername()) {
        echo 'Username already exists.';
        exit();
    }
    if ($user->registerUser()) {
        echo 1;
    } else {
        echo 'Registration failed.';
    }

    exit();
}


include './template/header.html';
    
echo '<div class="main"> ';
include './template/register.html';
echo '</div>';

include './template/footer.html';