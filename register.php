<?php
include 'debugging.php';

include './template/header.html';
    
echo '<div class="main"> ';
include './template/register.html';
echo '</div>';

include './template/footer.html';


include './helpers/Database.php';
include './models/User.php';
if (isset($_POST['submitted'])) {
    $user = new User();
    $user->setEmail($_POST['email']);
    $user->setUsername($_POST['username']);
    $user->setPassword($_POST['password']); 
    $user->setRoleId(ROLE_CLIENT);

    if ($user->initWithUsername()) {

        if ($user->registerUser())
            echo 'Registerd Successfully';
        else
            echo '<p class="error"> Not Successfull </p>';
    }else {
        echo '<p class="error"> Username Already Exists </p>';
    }
}

