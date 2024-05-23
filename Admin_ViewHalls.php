<?php

include_once './debugging.php';
include_once 'header.php';
include_once './models/Hall.php';
include_once './models/Pagination.php';
include_once './helpers/Database.php';

// assuming admin id is always 1
if ($_COOKIE['userId'] != 1) {
    header("Location: PageNotFound.html");
}

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

if(isset($_GET['pageno']))
   $start = $_GET['pageno'];
else $start = 1;

$end = 10;

//apply all filter by default
$filter = (isset($_GET['filter'])) ? $_GET['filter'] : 'all';

//check the filter 
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
//display halls depending on filter chosen
$hall = new Hall();
$data = $hall->getAllHalls($start, $end, $displayby);
echo '<div class="container">';
displayHalls($data);

//set the pagination total records depending on filter
$pagination = new Pagination();
if ($displayby=='all'){
    $pagination->setTotal_records(Hall::countAllHalls());
} else if ($displayby=='ava') {
    $pagination->setTotal_records(Hall::countAvailableHalls());
} else if ($displayby == 'cncl'){
    $pagination->setTotal_records(Hall::countCancelledHalls());
}
$pagination->setLimit($end);
$pagination->page($displayby);
echo '</div>';
include './template/footer.html';
?>


<?php
//functiont o display halls using cards
function displayHalls($dataSet) {
    if (!empty($dataSet)) {
        for ($i = 0; $i < count($dataSet); $i++) {
            $hall = new Hall();
            $id = $dataSet[$i]->hall_id;
            $hall->initWithHallid($id);
            $image = new HallImage();
            $hallImages = $image->getAllImagesForHall($id);
            echo '<div class="card hallCard mb-4 ">
                    <div class="card-body p-0">
                        <div class="row m-0">
                            <div class="col-xl-6 p-0">
                                <div id="carousel-' . $id . '" class="carousel slide" data-bs-ride="carousel">
                                    <div class="carousel-indicators">
                                    ';
            for ($j = 0; $j < count($hallImages); $j++) {
                if ($j == 0) {
                    echo'<button type="button" data-bs-target="#carousel-' . $id . '" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>';
                } else {
                    echo '<button type="button" data-bs-target="#carousel-' . $id . '" data-bs-slide-to="' . ($j) . '" aria-label="Slide ' . ($j) . '"></button>';
                }
            }
            echo'</div>
                                <div class="carousel-inner">';
            for ($k = 0; $k < count($hallImages); $k++) {
                if ($k == 0) {
                    echo '<div class="carousel-item active">
                                        <img src="' . $hallImages[$k]->hall_image_path . '" class="d-block w-100 rounded-start" alt="...">
                                        </div>';
                } else {
                    echo '<div class="carousel-item">
                                        <img src="' . $hallImages[$k]->hall_image_path . '" class="d-block w-100 rounded-start" alt="...">
                                        </div>';
                }
            }
            echo'</div> 
                                <button class="carousel-control-prev" type="button" data-bs-target="#carousel-' . $id . '" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#carousel-' . $id . '" data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                </button>
                            </div>
                        </div>
                        <div class="col-xl-6 p-0">
                            <div class="d-flex flex-column h-100 justify-content-between text-center ">
                                <div class="row pt-5">
                                    <div class="col text-center " >
                                        <span class="fw-bold display-6">' . $hall->getHallName() . '</span>
                                            <br>
                                        <span class="badge bg-' . $hall->getHallStatusName()->status_name . '">' . $hall->getHallStatusName()->status_name . '</span>
                                </div>
                                    </div>
                                <div class="row ps-5 pe-5">
                                    <p>' . $hall->getDescription() . '</p>
                                </div>
                                <div class="row ps-5 pe-5">
                                    <div class="col text-start">
                                        <h3>' . $hall->getRentalCharge() . '/Hr</h3>
                                    </div>
                                    <div class="col text-end">
                                        <h3>' . $hall->getCapacity() . ' seats</h3>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="d-flex col w-100">
                                        <button id ="editHallBtn" class="btn btn-primary rounded-0 flex-fill" data-id="' . $hall->getHallId() . '" data-bs-toggle="modal" data-bs-target="#addModal"><i class="bi bi-pen-fill">Edit</i> </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>';
        }
    } else {
        echo '<h1>No Halls to Display</h1>';
    }
}
?>


<script type="text/javascript">
    $(document).ready(function () {
        $('#halls').addClass('active-page');
    });
</script>