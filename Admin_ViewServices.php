<?php

/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */
include './debugging.php';
include './template/header.html';
include './models/MenuItem.php';
include './helpers/Database.php';

function uploadImg() {
    //$_FILES is a PHP global array simialr to $_POST and $_GET
    if (isset($_FILES['MenuItemImg'])) {
        //we access the $_FILES array using the name of the upload control in the form created above    

        $name = "./images/MenuItems/" . $_FILES['MenuItemImg']['name']; //unix path uses forward slash
        //create a path to save the uploaded file into   
        //'filename' index comes from input type 'file' in the form above
        move_uploaded_file($_FILES['MenuItemImg']['tmp_name'], $name);
        //above moves uploaded file from temp to web directory

        if ($_FILES['MenuItemImg']['error'] > 0) {
            return "";
        } else {
            // echo "<p>Uploaded image '$name'</p><br /><img src='$name' />";
            //the above line of code displays the image now stored in the images sub directory
        }
    }
    return $name;
}

if (isset($_POST['submitted'])) {
    //initialze a new MenuItem object
    $item = new MenuItem();
    //assign object values using set methods of MenuItem class
    $item->setName(trim($_POST['ItemName']));
    $item->setDescription(trim($_POST['description']));
    $item->setCateringService(trim($_POST['serviceType']));
    $item->setPrice(trim($_POST['Price']));
    
    // check the uploading of the image and assigning the image path
    $imgFileName = uploadImg();
    //check if file name is not empty
    $item->setImagePath($imgFileName);

    //check if Hall is valid and added it to the database
    if ($item->isValid()) {
        $db = Database::getInstance();
        if ($item->addMenuItem()) {
            //display book image and successful message
            echo '<br><div class="container"><div class="alert alert-success alert-dismissible fade show" role="alert"> The Item has been added Sucessfullly!<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div></div>';
        }
    } else {
        echo '<br><div class="container"><div class="alert alert-danger alert-dismissible fade show" role="alert">The Item has not been added :(<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div></div>';
    }
}

if (isset($_POST['deleteItemSubmitted'])) {
    $ItemID = trim($_POST['ItemId']);
    $deletedItem = new MenuItem();
    $deletedItem->initWithMenuItemid($ItemID);
    echo $ItemID;
    if ($deletedItem->deleteMenuItem()) {
         echo '<br><div class="container"><div class="alert alert-success alert-dismissible fade show" role="alert"> The Item has been deleted Sucessfullly!<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div></div>';
    } else {
        echo'Error: not deleted';
    }
}
include './template/admin/DisplayServices.php';

include './template/footer.html';

