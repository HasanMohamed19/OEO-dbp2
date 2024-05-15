<?php

include_once './models/User.php';
$user = new User();
$user->logout();
header("Location: index.php")

?>