<?php

include_once'./debugging.php';
include_once './template/header.html';
include_once './models/Hall.php';
include_once './helpers/Database.php';

function uploadImg() {
    $fileNames = []; // Array to store file names

    if (isset($_FILES['HallImage'])) {
        $fileCount = count($_FILES['HallImage']['name']); // Count of uploaded files

        for ($i = 0; $i < $fileCount; $i++) {
            $name = "./images/halls/" . $_FILES['HallImage']['name'][$i]; // Path to save the uploaded file into
            move_uploaded_file($_FILES['HallImage']['tmp_name'][$i], $name); // Move uploaded file from temp to web directory

            if ($_FILES['HallImage']['error'][$i] > 0) {
                // Handle error if needed
            } else {
                // Add file name to array
                $fileNames[] = $name;
            }
        }
    }

    return $fileNames;
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
    $hall->setHallStatus(trim($_POST['status']));
    $images = uploadImg();
    $db = Database::getInstance();
//check if hall id is null (New Hall) and call Add Function
    if ($hall->getHallId() == '') {
        if ($hall->addHall()) {
            $hall->addHallImages($images);
//display successful message
            echo '<br><div class="container"><div class="alert alert-success alert-dismissible fade show" role="alert"> The Hall has been added Sucessfullly!<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div></div>';
        }
//else if hall id is not null (Update Hall) and call Update function
    } else if ($hall->updateHall()) {
        $hall->addHallImages($images);
        echo '<br><div class="container"><div class="alert alert-success alert-dismissible fade show" role="alert"> The Hall has been Updated Sucessfullly!<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div></div>';
    } else {
        echo'<h1>Not saved :(</h1>';
    }
}
include './template/admin/DisplayHalls.php';

include './template/footer.html';
?>



