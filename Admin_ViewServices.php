<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */
include_once './debugging.php';
include_once './template/header.html';
include_once './models/MenuItem.php';
include_once './models/Pagination.php';
include_once './helpers/Database.php';

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
    $item->setItemId(trim($_POST['Add-ItemID']));
    $item->setName(trim($_POST['ItemName']));
    $item->setDescription(trim($_POST['description']));
    $item->setCateringService(trim($_POST['serviceType']));
    $item->setPrice(trim($_POST['Price']));
    $item->setItemStaus(trim($_POST['status']));
    // check the uploading of the image and assigning the image path
    $imgFileName = uploadImg();
    //if no image uploaded (only in update) then set the image to the old one
    if ($imgFileName == '') {
        $item->setImagePath(trim($_POST['imagePath']));
    } else {
         //else if new image uploaded set it to the new one
        $item->setImagePath($imgFileName);
    }

    //check if Item is valid and added it to the database
    $db = Database::getInstance();
    if ($item->getItemId() == '') {
        if ($item->addMenuItem()) {
            //display book image and successful message
            echo '<br><div class="container"><div class="alert alert-success alert-dismissible fade show" role="alert"> The Item has been added Sucessfullly!<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div></div>';
        }else {
            echo'error: cannot add';
        }
    } else if ($item->updateMenuItem()){
        echo '<br><div class="container"><div class="alert alert-success alert-dismissible fade show" role="alert"> The Item has been updated Sucessfullly!<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div></div>';
    }
}
include './template/admin/DisplayServices.php';

if(isset($_GET['pageno']))
   $start = $_GET['pageno'];
else $start = 1;

$end = 10;

$filter = (isset($_GET['filter'])) ? $_GET['filter'] : 'all';

switch ($filter) 
{
    case 'ava':
        $displayby = 'ava';
        break;
    case 'cncl':
        $displayby = 'cncl';
        break;
    default:
        $displayby = 'all';
        break;
}
$item = new MenuItem();
$data = $item->getAllMenuItems($start, $end, $displayby);
echo '<div class="container">';
displayMenuItems($data);

$pagination = new Pagination();
if ($displayby=='all'){
    $pagination->setTotal_records(28);
} else if ($displayby=='ava') {
    $pagination->setTotal_records(23);
} else {
    $pagination->setTotal_records(5);
}

//$pagination->totalRecords($table);
echo $pagination->total_records . ' is total records';
$pagination->setLimit($end);
$pagination->page($displayby);

echo '</div>';


include './template/footer.html';




function displayMenuItems($dataSet) {
    if (!empty($dataSet)) {
        for ($i = 0; $i < count($dataSet); $i++) {
            $item = new MenuItem();
            $id = $dataSet[$i]->item_id;
            $item->initWithMenuItemid($id);
            echo '<div class="card serviceCard mb-4 ">
                <div class="card-body p-0">
                    <div class="row m-0">
                        <div class="col-xl-6 p-0">
                        <img src="' . $item->getImagePath() . '" class="d-block w-100 rounded-start" alt="...">
                        </div>
                        <div class="col-xl-6 p-0">
                            <div class="d-flex flex-column h-100 justify-content-between text-center ">
                                <div class="row pt-5">
                                    <div class="col text-center " >
                                        <span class="fw-bold display-6">' . $item->getName() . '</span>
                                            <br>
                                        <span class="badge bg-' . $item->getItemStatusName()->status_name . '">' . $item->getItemStatusName()->status_name . '</span>
                                </div>
                                </div>
                                <div class="row ps-5 pe-5">
                                    <p>' . $item->getDescription() . '</p>
                                </div>
                                <div class="row ps-5 pe-5">
                                    <div class="col text-start">
                                        <h3>' . $item->getPrice() . '/Hr</h3>
                                    </div>
                                    <div class="col text-end">
                                        <h3>' . $item->getCateringSerivceName() . '</h3>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="d-flex col w-100">
                                        <button id ="editItemBtn" class="btn btn-primary rounded-0 flex-fill" data-id="' . $item->getItemId() . '" data-bs-toggle="modal" data-bs-target="#addModal"><i class="bi bi-pen-fill">Edit</i> </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>';
        }
    } else {
        echo '<h1>No Menu Items to Display</h1>';
    }
}
?>