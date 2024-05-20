<?php
include './helpers/Database.php';
include './models/Hall.php';
include './debugging.php';
?>
<body>
<style>
    .hero {
        position: relative;
        background: url(./images/hero8.webp) no-repeat !important;
        background-size: cover !important;
        background-position: bottom !important;
        height: 40vh !important;
    }

    .hero::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.25); /* Adjust the opacity and color as needed */
        z-index: 1;
    }

    .hero .container-fluid {
        position: relative;
        z-index: 2;
    }
</style>
<body>
    <div class="hero bg-light text-white w-100 h-50 mb-5">
        <div class="container-fluid">
            <h1 class="display-5 fw-bold">Hall Booking Simplified</h1>
            <p class="col-md-8 lead">Find and reserve the perfect space for your events, from weddings to corporate meetings, with ease and confidence.</p>
            <button class="btn btn-primary btn-lg" onclick="location.href = '#popularHalls'">View Halls</button>
        </div>
    </div>
    <div class="container">
        <div class="row text-center mb-3">
            <h1 class="fw-bold">Popular Halls</h1>
        </div>
        <div id="popularHalls" class="row d-flex justify-content-center mt-3" >
            <?php
            $hall = new Hall();
            $halls = $hall->getPopularHalls();
            displayHalls($halls);
            ?>
        </div>
    </div>
</body>

<?php

function displayHalls($dataSet) {
    foreach ($dataSet as $data) {
        $data = (object) $data;
        $hall = new Hall();
        $id = $data->hall_id;
        $hall->initWithHallid($id);
        $image = new HallImage();
        $hallImages = $image->getAllImagesForHall($id);
        echo '
        <div class="col-xl-4">
            <div class="card mb-5 ">
                <div class="card-body p-0">
                    <div class="row">
                        <div class="col">
                            <div id="carousel-' . $id . '" class="carousel slide" data-bs-ride="carousel">
                                <div class="carousel-indicators">';
        for ($j = 0; $j < count($hallImages); $j++) {
            if ($j == 0) {
                echo '<button type="button" data-bs-target="#carousel-' . $id . '" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>';
            } else {
                echo '<button type="button" data-bs-target="#carousel-' . $id . '" data-bs-slide-to="' . ($j) . '" aria-label="Slide ' . ($j) . '"></button>';
            }
        }
        echo'</div>
                                <div class="carousel-inner rounded-top">';
        for ($k = 0; $k < count($hallImages); $k++) {
            if ($k == 0) {
                echo '<div class="carousel-item active">
                                        <img src="' . $hallImages[$k]->hall_image_path . '" class="d-block w-100" alt="...">
                                    </div>';
            } else {
                echo '<div class="carousel-item">
                                        <img src="' . $hallImages[$k]->hall_image_path . '" class="d-block w-100" alt="...">
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
                </div>
        ';
        echo '<div class="p-3">';
        echo '<div class="row text-center">';
        echo '<h1 class="col">' . $hall->getHallName() . '</h1>'
        . '</div>';
        echo '<div class="row"><p class="col text-center text-truncate">' . $hall->getDescription() . '</p></div>';
        echo '<div class="row align-items-center">';
        echo '<div class="col"><h5 class="text-end">' . $hall->getRentalCharge() . ' BHD/Hr</h5></div>'
        . '<div class="col-auto text-center"><a role="button" href="client_booking.php?hallId=' . $id . '" class="btn btn-primary btn-lg">Book Now</a></div>'
        . '<div class="col"><h5 class="text-start">' . $hall->getCapacity() . ' Seats</h5></div>'
        . '</div>
                </div>
            </div>
        </div>';
    }
}
?>