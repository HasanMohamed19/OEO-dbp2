<?php
// Include necessary files and classes
include '../debugging.php';
include '../models/Reservation.php';
//include 'Database.php';

// Check if hallId parameter is provided
if (isset($_GET['reservationId'])) {
    // Get hallId from the request
    $reservationId = $_GET['reservationId'];
//    echo $reservationId . ' is id';
    try {
//    echo $clientId . ' is client id';
        // Create a new instance of the Hall class
        $reservation = new Reservation();
        $reservation->setReservationId($reservationId);
        // Initialize the hall object with data based on hallId
        $reservation->initReservationWithId($reservationId);
        $reservationStatus = $reservation->getStatusName($reservation->getStatusId());
        // Prepare the response data
        $responseData = $reservationStatus;
//        echo $responseData . ' is data';
//        $responseData = array(
//            "status"=>$clientStatus,
//            "numberOfReservations"=>$totalReservations
//        );

//        echo $responseData->status_name . ' is response data';

        // Send JSON response
        header('Content-Type: text/html');
//        header('Content-Type: application/json'); 
//        echo json_encode($responseData);
        
        echo $responseData;
    } catch (Exception $e) {
        // Handle any exceptions
        header('HTTP/1.1 500 Internal Server Error');
        echo json_encode(array('error' => 'An error occurred: ' . $e->getMessage()));
    }
} else {
    // Return error if hallId parameter is missing
    header('HTTP/1.1 400 Bad Request');
    echo json_encode(array('error' => 'Hall ID is required'));
}
?>
