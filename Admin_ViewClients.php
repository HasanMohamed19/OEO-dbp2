<?php

/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */

include './template/header.html';



if (isset($_POST['submitted'])) {
//initialze a new Hall object
    $hall = new Hall();

//assign object values using set methods of Hall class
    $hall->setHallId(trim($_POST['Add-HallID']));
    $hall->setHallName(trim($_POST['HallName']));
    $hall->setDescription(trim($_POST['description']));
    $hall->setRentalCharge(trim($_POST['RntlCharge']));
    $hall->setCapacity(trim($_POST['capacity']));

    $db = Database::getInstance();
//check if hall id is null (New Hall) and call Add Function
    if ($hall->getHallId() == '') {
        if ($hall->addHall()) {
//display successful message
            echo '<br><div class="container"><div class="alert alert-success alert-dismissible fade show" role="alert"> The Hall has been added Sucessfullly!<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div></div>';
        }
//else if hall id is not null (Update Hall) and call Update function
    } else if ($hall->updateHall()) {
        echo '<br><div class="container"><div class="alert alert-success alert-dismissible fade show" role="alert"> The Hall has been Updated Sucessfullly!<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div></div>';
    } else {
        echo'<h1>Not saved :(</h1>';
    }
}

include './template/admin/Admin_DisplayClients.html';

if (isset($_POST['deleteHallSubmitted'])) {
    $hallID = trim($_POST['hallId']);
    $deletedHall = new Hall();
    $deletedHall->initWithHallid($hallID);
    if ($deletedHall->deleteHall()) {
        echo '<br><div class="container"><div class="alert alert-success alert-dismissible fade show" role="alert"> The Hall has been deleted Sucessfullly!<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div></div>';
    }
}

include './template/footer.html';
