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
            return "";
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
    $imgFileName = uploadImg();
    //check if file name != //images
    if ($imgFileName != "") {
        $hall->setImagePath($imgFileName);
    }
    //check if Hall is valid and added it to the database
    if ($hall->isValid()) {
        $db = Database::getInstance();
        if ($hall->addHall()) {
            //display book image and successful message
            echo '<br><div class="container"><div class="alert alert-success alert-dismissible fade show" role="alert"> The Hall has been added Sucessfullly!<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div></div>';
        }
    } else {
        echo '<br><div class="container"><div class="alert alert-danger alert-dismissible fade show" role="alert">The form has not been added :(<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div></div>';
    }
}

if (isset($_POST['deleteSubmitted'])) {
    $hallID = trim($_POST['hallId']);
    $deletedHall = new Hall();
    $deletedHall->initWithHallid($hallID);
    if ($deletedHall->deleteHall()) {
         echo '<br><div class="container"><div class="alert alert-success alert-dismissible fade show" role="alert"> The Hall has been deleted Sucessfullly!<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div></div>';
    }
}

include './template/admin/DisplayHalls.php';

include './template/footer.html';
?>



