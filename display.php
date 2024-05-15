<?php

include './helpers/Database.php';
include './models/User.php';
include './models/Login.php';

$users = new User();
$row = $users->getAllUsers();

echo count($row) . " rows were found";
header("Location: myAccount.php");

?>