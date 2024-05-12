<?php
include '../helpers/Database.php';
include '../models/Reservation.php';
//include '../models/Event.php';
//include '../models/Hall.php';
//include '../models/MenuItem.php';
//include '../models/ReservationMenuItem.php';
include '../debugging.php';

include './header.html'; 

    $reservationId = $_GET['reservationId'];

    $reservation = new Reservation();
    $reservation->setReservationId($reservationId);
    
    $reservation->initReservationWithId($reservationId);
    $reservation->setClientId('1');
    
//    var_dump($reservation);
    $reservationDetails = $reservation->getReservationDetails();
//    echo '  reservation details are: ' . count($reservations);
    
    
//var_dump($reservations);
   

?>



<div class="container">
    <div class="my-account-body">
        <div class="row justify-content-between mx-3 mt-2">
            <div class="col">Booking#: <?php echo $reservationDetails->reservation_id ?> </div>
            <div class="col text-secondary text-center"> <?php echo $reservationDetails->reservation_date ?> </div>
            <div class="col text-end">Total: BHD 1700.16</div>
        </div>
        <hr>
        <div class="card mb-2 border-0 mx-3">
            <div class="row g-0">
                <div class="col-xl-5 p-2">
                    <img src="<?php echo $reservationDetails->image_path ?>" alt="" class="img-fluid rounded">
                </div>

                <div class="col-xl-5 p-2 flex-grow-1">
                    <div class="row m-2">
                        <div class="col text-start completed"> <?php echo Reservation::getStatusName($reservationDetails->reservation_status_id) ?> </div>
                        <div class="col text-end"><button class="btn btn-danger">Cancel Booking</button></div>
                    </div>
                    <div class="row m-2">
                        <span class="col text-start text-secondary">Hall Name: </span>
                        <span class="col text-start"> <?php echo $reservationDetails->hall_name ?> </span>
                    </div>
                    <div class="row m-2">
                        <span class="col text-start text-secondary">Event Name: </span>
                        <span class="col text-start"> <?php echo $reservationDetails->event_name ?> </span>
                    </div>
                    <div class="row m-2">
                        <span class="col text-start text-secondary">Start Date: </span>
                        <span class="col text-start"> <?php echo $reservationDetails->start_date ?> </span>
                    </div>
                    <div class="row m-2">
                        <span class="col text-start text-secondary">End Date: </span>
                        <span class="col text-start"> <?php echo $reservationDetails->end_date ?> </span>
                    </div>
                    <div class="row m-2">
                        <span class="col text-start text-secondary">Daily Start Time: </span>
                        <span class="col text-start"> <?php echo $reservationDetails->start_time ?> </span>
                    </div>
                    <div class="row m-2">
                        <span class="col text-start text-secondary">Daily End Time: </span>
                        <span class="col text-start"> <?php echo $reservationDetails->end_time ?> </span>
                    </div>
                    <div class="row m-2">
                        <span class="col text-start text-secondary">No. Audiences </span>
                        <span class="col text-start"> <?php echo $reservationDetails->audience_number ?> </span>
                    </div>
                </div>
            </div>
            <div class="row mx-1">
                <span class="text-secondary">Notes: </span>
                <p class="justify"> <?php echo $reservationDetails->notes; ?> </p>
            </div>

            <div class="row mx-1">
                <div class="accordion">
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#additionalServiceCollapse" aria-expanded="true" aria-controls="collapseOne">
                                <span class="fs-3">Additional Services</span>
                            </button>
                        </h2>
                        <div id="additionalServiceCollapse" class="accordion-collapse collapse show">
                            <div class="accordion-body d-flex flex-wrap">

                                <div class="card p-0 m-2 cateringItem">
                                    <img class="card-img-top img-fluid" src="https://placehold.co/278x156">
                                    <div class="card-body">
                                        <h3 class="card-title text-center fs-5">Menu Item Name</h3>
                                        <p class="card-text text-center"><strong>0.6 BHD x 0.5 BHD</strong></p>
                                    </div>
                                </div>

                                <div class="card p-0 m-2 cateringItem">
                                    <img class="card-img-top img-fluid" src="https://placehold.co/278x156">
                                    <div class="card-body">
                                        <h3 class="card-title text-center fs-5">Menu Item Name</h3>
                                        <p class="card-text text-center"><strong>0.6 BHD x 0.5 BHD</strong></p>
                                    </div>
                                </div>

                                <div class="card p-0 m-2 cateringItem">
                                    <img class="card-img-top img-fluid" src="https://placehold.co/278x156">
                                    <div class="card-body">
                                        <h3 class="card-title text-center fs-5">Menu Item Name</h3>
                                        <p class="card-text text-center"><strong>0.6 BHD x 0.5 BHD</strong></p>
                                    </div>
                                </div>

                                <div class="card p-0 m-2 cateringItem">
                                    <img class="card-img-top img-fluid" src="https://placehold.co/278x156">
                                    <div class="card-body">
                                        <h3 class="card-title text-center fs-5">Menu Item Name</h3>
                                        <p class="card-text text-center"><strong>0.6 BHD x 0.5 BHD</strong></p>
                                    </div>
                                </div>

                                <div class="card p-0 m-2 cateringItem">
                                    <img class="card-img-top img-fluid" src="https://placehold.co/278x156">
                                    <div class="card-body">
                                        <h3 class="card-title text-center fs-5">Menu Item Name</h3>
                                        <p class="card-text text-center"><strong>0.6 BHD x 0.5 BHD</strong></p>
                                    </div>
                                </div>

                                <div class="card p-0 m-2 cateringItem">
                                    <img class="card-img-top img-fluid" src="https://placehold.co/278x156">
                                    <div class="card-body">
                                        <h3 class="card-title text-center fs-5">Menu Item Name</h3>
                                        <p class="card-text text-center"><strong>0.6 BHD x 0.5 BHD</strong></p>
                                    </div>
                                </div>

                                <div class="card p-0 m-2 cateringItem">
                                    <img class="card-img-top img-fluid" src="https://placehold.co/278x156">
                                    <div class="card-body">
                                        <h3 class="card-title text-center fs-5">Menu Item Name</h3>
                                        <p class="card-text text-center"><strong>0.6 BHD x 0.5 BHD</strong></p>
                                    </div>
                                </div>

                                <div class="card p-0 m-2 cateringItem">
                                    <img class="card-img-top img-fluid" src="https://placehold.co/278x156">
                                    <div class="card-body">
                                        <h3 class="card-title text-center fs-5">Menu Item Name</h3>
                                        <p class="card-text text-center"><strong>0.6 BHD x 0.5 BHD</strong></p>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<?php
include './footer.html';
?>