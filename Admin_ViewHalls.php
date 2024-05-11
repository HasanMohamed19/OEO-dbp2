<?php

include './debugging.php';
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
    $hall->setHallId(trim($_POST['Add-HallID']));
    $hall->setHallName(trim($_POST['HallName']));
    $hall->setDescription(trim($_POST['description']));
    $hall->setRentalCharge(trim($_POST['RntlCharge']));
    $hall->setCapacity(trim($_POST['capacity']));
// check the uploading of the image and assigning the image path
    $imgFileName = uploadImg();
    //if no image uploaded (only in update) then set the image to the old one
    if ($imgFileName == '') {
        $hall->setImagePath(trim($_POST['imagePath']));
    } else {
         //else if new image uploaded set it to the new one
        $hall->setImagePath($imgFileName);
    }
   
    

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



if (isset($_POST['deleteHallSubmitted'])) {
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



