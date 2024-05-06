<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */

include './template/header.html';
include './models/Hall.php';
include './helpers/Database.php';

function uploadImg() {
    //$_FILES is a PHP global array simialr to $_POST and $_GET
    if (isset($_FILES['HallImage'])) {
        //we access the $_FILES array using the name of the upload control in the form created above    

        $name = "images//" . $_FILES['HallImage']['name']; //unix path uses forward slash
        //create a path to save the uploaded file into   
        //'filename' index comes from input type 'file' in the form above
        move_uploaded_file($_FILES['HallImage']['tmp_name'], $name);
        //above moves uploaded file from temp to web directory

        if ($_FILES['HallImage']['error'] > 0) {
            echo "<p>There was an error</p>";
            echo $_FILES['HallImage']['error'];
        } else {
            // echo "<p>Uploaded image '$name'</p><br /><img src='$name' />";
            //the above line of code displays the image now stored in the images sub directory
        }
    }
    return $name;
}

if (isset($_POST['submitted'])) {
    //initialze a new Hall object
    $hall = new Hall();
    //assign object values using set methods of Hall class
    $hall->setHallName(trim($_POST['HallName']));
    $hall->setDescription(trim($_POST['description']));
    $hall->setRentalCharge(trim($_POST['RntlCharge']));
    $hall->setCapacity(trim($_POST['capacity']));
    // check the uploading of the image and assigning the image path
    $imgFileName=uploadImg();
    $hall->setImagePath($imgFileName);
    //check if Hall is valid and added it to the database
    if ($hall->isValid()) {
        echo "<h1>Valid Inputs</h1> image path is:".$hall->getImagePath();
        $db = Database::getInstance();
        if ($hall->addHall()) {
            //display book image and successful message
            echo "<h1>Thank you the hall has been added to the database</h1>";
        } else {
            echo "<h1>the hall has not been added :(</h1>";
        }
    } else {
        echo "<h1>InValid Inputs</h1>";
    }
} else {
    include './template/admin/Admin_ViewHalls.html';
}

include './template/footer.html';
?>



