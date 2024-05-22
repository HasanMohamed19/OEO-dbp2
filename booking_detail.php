<?php
include 'debugging.php';
include './helpers/Database.php';
include './models/Reservation.php';
include_once ''; './models/Event.php';
//include_once './models/Hall.php';
//include_once './models/HallImage.php';
//include './models/MenuItem.php';
//include './models/ReservationMenuItem.php';

include './template/header.html';

$reservationId = $_GET['reservationId'];

$reservation = new Reservation();
$reservation->setReservationId($reservationId);


$reservation->initReservationWithId($reservationId);

$reservation->setClientId($_COOKIE['clientId']);

//    var_dump($reservation);
$reservationDetails = $reservation->getReservationDetails();
//var_dump($reservationDetails);
//echo 'catering found: ' . count($reservation->getAdditionalServicesForReservation($reservationId));
//    echo '  reservation details are: ' . count($reservations);

$hall = new Hall();
$id = $reservationDetails->hall_id;
$hall->initWithHallid($id);
$image = new HallImage();
$hallImages = $image->getAllImagesForHall($id);

?>



<div class="container">
    <div class="my-account-body">
        <div class="row justify-content-between mx-3 mt-2">
            <div class="col" id="resId" data-id="<?php echo $reservationDetails->reservation_id ?>">Booking#: <?php echo $reservationDetails->reservation_id ?> </div>
            <div class="col text-secondary text-center"> <?php echo $reservationDetails->reservation_date ?> </div>
            <div class="col text-end">Total: BHD <?php echo $reservationDetails->TotalCost ?></div>
        </div>
        <hr>
        <div class="card mb-2 border-0 mx-3">
            <div class="row g-0">
                <div class="col-xl-5 p-2">
                    <?php
                    
                    
                    
                        echo '<div id="carousel-' . $id . '" class="carousel slide" data-bs-ride="carousel">
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
        ';
                    ?>
                    
                </div>

                <div class="col-xl-5 p-2 flex-grow-1">
                    <div class="row m-2">
                        <div id="resStatus" class="col text-start"> <?php echo Reservation::getStatusName($reservationDetails->reservation_status_id) ?> </div>
                        <!-- condition needs to be changed -->
                        <?php
                            $event = new Event();
                            $dayDifferences = $event->checkDaysDifference($reservationDetails->event_id, $reservationDetails->start_date);
                            if ($reservationDetails->reservation_status_id != 2 && $dayDifferences >= 2) {
                                echo '<div class="col text-end"><button class="btn btn-danger" data-id="' . $reservationDetails->reservation_id . '"data-bs-toggle="modal" data-bs-target="#cancelModal" onclick="setCancel(this)" id="cancelReservationBtn">Cancel Booking</button></div>';
                            echo '<div class="col text-end">'
                            . '<a href="client_booking.php?hallId=' . $reservationDetails->hall_id .'&reservationId=' . $reservationDetails->reservation_id .'" role="button" class="btn btn-primary" id="editReservationBtn">Edit Reservation</a>'
                                    . '</div>';
                            }
                        ?>
                        
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

                                <?php
                                    
                                    $r = new Reservation();
                                    $r->setReservationId($reservationId);
                                    $services = $r->getAdditionalServicesForReservation($reservationId);
                                    $r->displayReservationMenuItems($services);
                                
                                ?>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    
     <!--cancel reservation moda;-->
                <div class="modal fade" id="cancelModal">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Cancel Confirmation</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                Are You sure You want to Cancel this Booking?
                            </div>
                            <div class="modal-footer">
                                <form action="booking_detail.php" method="post">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Stop</button>
                                    <button type="submit" class="btn btn-danger">Cancel</button>
                                    <input type ="hidden" name="cancelReservationSubmitted" value="TRUE">
                                    <input type="hidden" id="cancelReservation" name="reservationId">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
 
<script src="./helpers/CardForm.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    
<script>
    
    $(function () {
        $.ajax({
            url: './helpers/get_reservation_status.php',
            method: 'GET',
            data: {reservationId: $("#resId").attr('data-id')},
            dataType: 'text', // Expected data type from server
            success: function (response) {
                // Handle successful response
                console.log('reservation Info:', response);

                // Update class list
                const statusDiv = $("#resStatus");
//
                switch (response) {
                    case 'Completed':
                        statusDiv.addClass('completed');
                        break;
                    case 'Canceled':
                        statusDiv.addClass('cancelled');
                        break;
                    case 'In Progress':
                        statusDiv.addClass('in-progress');
                        break;
                    case 'Booked':
                        statusDiv.addClass('in-progress');
                        break;
                }



            },
            error: function (xhr, status, error) {
                // Handle errors
                console.error('Error fetching status info:', error);
            }
        });
    });
    
</script>

</div>

<?php

    if (isset($_POST['cancelReservationSubmitted'])) {
        $reservationId = $_POST['reservationId'];
//        echo "reservation id is: " . $reservationId;
        echo 'cancelling booking with id: ' . $reservationId;
//        $db = Database::getInstance();
//        $data = $db->querySQL('CALL cancelBooking(' . $reservationId .')');
//        var_dump($data);'
        $reservation = new Reservation();
        $reservation->cancelReservation($reservationId);
    } else {
//        echo 'nothing is submitted yet';
    }
    
?>

<?php
include './footer.html';
?>