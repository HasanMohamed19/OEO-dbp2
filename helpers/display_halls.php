<?php
include_once '../debugging.php';
include_once '../models/Hall.php';
include_once '../models/HallImage.php';

if (isset($_GET['filter'])) {
    $filter = $_GET['filter'];
    $hall = new Hall();

    if ($filter == "All-Halls") {
        $data = $hall->getAllHalls();
        displayHalls($data);
    } else if ($filter == "Available-Halls") {
        $data = $hall->getAvailableHalls();
        displayHalls($data);
    } else if ($filter == "Cancelled-Halls") {
        $data = $hall->getCancelledHalls();
        displayHalls($data);
    }
} else {
    echo 'No name parameter provided!';
}

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