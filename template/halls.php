<?php
include './models/Hall.php';
include './helpers/Database.php';
include './debugging.php';
$hall = new Hall();

if ($_POST['submitted']) {
    $searchTerm = trim($_POST['search']);
    echo 'submitted: ' . $searchTerm;
    $halls = $hall->getHallsBySearch($searchTerm);
} else {
    echo 'get all active halls';
    $halls = $hall->getAllHalls();
}

//echo " there are " . count($halls);

function displayHalls($dataSet) {



    for ($i = 0; $i < count($dataSet); $i++) {
        $hall = $dataSet[$i];
        $hall = new Hall();
        $id = $dataSet[$i]->hall_id;
        $hall->initWithHallid($id);
        $image = new HallImage();
        $hallImages = $image->getAllImagesForHall($id);
        echo '<div class="card mb-5 ">
                    <div class="card-body p-0">
                        <div class="row m-0">
                            
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
                    </div>
                    
                ';

        echo '<div class="row text-center">';
        echo '<h1>' . $hall->getHallName() . '</h1></div>';
        echo '<div class="row mt-3 justify-content-center">' . $hall->getDescription() . '</div>';
        echo '<div class="row mt-5">';
        echo '<div class="col text-right"><h3>' . $hall->getRentalCharge() . ' BHD/Hr</h3></div>'
        . '<div class="col text-center"><a role="button" href="client_booking.php?hallId=' . $id . '" class="btn btn-primary">Book Now</a></div>'
        . '<div class="col text-left"><h3>' . $hall->getCapacity() . ' Seats</h3></div>'
        . '</div></div>';
    }




//                            </div>
//                            <div class="row mt-3">
//                                Description for the hall thats very long to show the length of the lthing is very long Description for the hall
//                                thats very long to show the length of the lthing is very long...
//                            </div>
//                            <div class="row mt-5">
//                                <div class="col text-center"><h3>100.00 BHD/Hr</h3></div>
//                                <div class="col text-center"><button class="btn btn-primary">Book Now</button></div>
//                                <div class="col text-center"><h3>80 Seats</h3></div>
//                            </div>
}
?>


<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
        <style>

        </style>
        <link href="styles/styles.css" rel="stylesheet" />
    </head>
    <body>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-9 shadow-lg rounded my-5 p-4">
                    <h4 class="text-left">Search for Available Halls</h4>
                    <form>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label for="startDate" class="form-label">Start Date</label>
                                <input type="date" class="form-control border border-secondary" id="startDate">
                            </div>
                            <div class="col-md-4">
                                <label for="endDate" class="form-label">End Date</label>
                                <input type="date" class="form-control border border-secondary" id="endDate">
                            </div>
                            <div class="col-md-4">
                                <label for="audienceCount" class="form-label">Number of Audiences</label>
                                <input type="number" class="form-control border border-secondary" id="audienceCount">
                            </div>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-12 d-flex justify-content-center">
                                <button type="submit" class="btn btn-primary shadow-lg mt-4">Search Now</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <form method="post" action="index.php">
                <div class="input-group">
                    <input type="text" class="form-control mb-0" placeholder="Search For a Hall" id="search" name="search">
                    <button type="submit" class="btn btn-outline-secondary" id="searchBtn">
                        <i class="bi bi-search"> Search</i>
                    </button>
                    <input type="hidden" name="submitted" value="1">
                </div>
            </form>
            <section class="py-5">
                <div class="container ">
                    <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-2 justify-content-center">

                        <?php
                        displayHalls($halls);
                        ?>

                        <!--                        <div class="card mb-5">
                                                    <div id="hall-3" class="carousel slide" data-bs-ride="carousel">
                                                        <div class="carousel-indicators">
                                                            <button type="button" data-bs-target="#hall-3" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                                                            <button type="button" data-bs-target="#hall-3" data-bs-slide-to="1" aria-label="Slide 2"></button>
                                                            <button type="button" data-bs-target="#hall-3" data-bs-slide-to="2" aria-label="Slide 3"></button>
                                                        </div>
                                                        <div class="carousel-inner">
                                                            <div class="carousel-item active">
                                                                <img src="https://dummyimage.com/450x300/dee2e6/6c757d.jpg" class="d-block w-100" alt="...">
                                                                                                        <div class="carousel-caption d-none d-md-block text-end">
                                                                                                            <button class="btn btn-primary">Book Now</button>
                                                                                                        </div>
                        
                                                            </div>
                                                            <div class="carousel-item">
                                                                <img src="https://dummyimage.com/450x300/dee2e6/6c757d.jpg" class="d-block w-100" alt="...">
                                                            </div>
                                                            <div class="carousel-item">
                                                                <img src="https://dummyimage.com/450x300/dee2e6/6c757d.jpg" class="d-block w-100" alt="...">
                                                            </div>
                                                        </div>
                                                        <button class="carousel-control-prev" type="button" data-bs-target="#hall-3" data-bs-slide="prev">
                                                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                            <span class="visually-hidden">Previous</span>
                                                        </button>
                                                        <button class="carousel-control-next" type="button" data-bs-target="#hall-3" data-bs-slide="next">
                                                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                            <span class="visually-hidden">Next</span>
                                                        </button>
                                                    </div>
                                                    <div class="row text-center">
                                                        <h1>Hall Name and Stuff</h1>
                                                    </div>
                                                    <div class="row mt-3">
                                                        Description for the hall thats very long to show the length of the lthing is very long Description for the hall
                                                        thats very long to show the length of the lthing is very long...
                                                    </div>
                                                    <div class="row mt-5">
                                                        <div class="col text-center"><h3>100.00 BHD/Hr</h3></div>
                                                        <div class="col text-center"><button class="btn btn-primary">Book Now</button></div>
                                                        <div class="col text-center"><h3>80 Seats</h3></div>
                                                    </div>
                                                </div>
                        
                                                <div class="card mb-5">
                                                    <div id="hall-4" class="carousel slide" data-bs-ride="carousel">
                                                        <div class="carousel-indicators">
                                                            <button type="button" data-bs-target="#hall-4" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                                                            <button type="button" data-bs-target="#hall-4" data-bs-slide-to="1" aria-label="Slide 2"></button>
                                                            <button type="button" data-bs-target="#hall-4" data-bs-slide-to="2" aria-label="Slide 3"></button>
                                                        </div>
                                                        <div class="carousel-inner">
                                                            <div class="carousel-item active">
                                                                <img src="https://dummyimage.com/450x300/dee2e6/6c757d.jpg" class="d-block w-100" alt="...">
                                                                                                        <div class="carousel-caption d-none d-md-block text-end">
                                                                                                            <button class="btn btn-primary">Book Now</button>
                                                                                                        </div>
                        
                                                            </div>
                                                            <div class="carousel-item">
                                                                <img src="https://dummyimage.com/450x300/dee2e6/6c757d.jpg" class="d-block w-100" alt="...">
                                                            </div>
                                                            <div class="carousel-item">
                                                                <img src="https://dummyimage.com/450x300/dee2e6/6c757d.jpg" class="d-block w-100" alt="...">
                                                            </div>
                                                        </div>
                                                        <button class="carousel-control-prev" type="button" data-bs-target="#hall-4" data-bs-slide="prev">
                                                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                            <span class="visually-hidden">Previous</span>
                                                        </button>
                                                        <button class="carousel-control-next" type="button" data-bs-target="#hall-4" data-bs-slide="next">
                                                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                            <span class="visually-hidden">Next</span>
                                                        </button>
                                                    </div>
                                                    <div class="row text-center">
                                                        <h1>Hall Name and Stuff</h1>
                                                    </div>
                                                    <div class="row mt-3">
                                                        Description for the hall thats very long to show the length of the lthing is very long Description for the hall
                                                        thats very long to show the length of the lthing is very long...
                                                    </div>
                                                    <div class="row mt-5">
                                                        <div class="col text-right"><h3>100.00 BHD/Hr</h3></div>
                                                        <div class="col text-center"><button class="btn btn-primary">Book Now</button></div>
                                                        <div class="col text-left"><h3>80 Seats</h3></div>
                                                    </div>
                                                </div>-->


                    </div>

                    </body>
                    </html>
