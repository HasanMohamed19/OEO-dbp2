<?php
// Include necessary files and classes
include '../debugging.php';
include '../models/User.php';
include '../models/Client.php';
include 'Database.php';

// Check if hallId parameter is provided
if (isset($_GET['clientId'])) {
    // Get hallId from the request
    $clientId = $_GET['clientId'];
    try {
//    echo $clientId . ' is client id';
        // Create a new instance of the Hall class
        $client = new Client();
        $client->setClientId($clientId);
        // Initialize the hall object with data based on hallId
        $clientStatus = $client->getClientStatusName($clientId)->status_name;
        $totalReservations = Client::getTotalReservations($clientId)->totalReservations;
        // Prepare the response data
//        $responseData = $clientStatus;
        $responseData = array(
            "status"=>$clientStatus,
            "numberOfReservations"=>$totalReservations
        );

//        echo $responseData->status_name . ' is response data';

        // Send JSON response
//        header('Content-Type: text/html');
        header('Content-Type: application/json'); 
        echo json_encode($responseData);
        
//        echo $responseData->status_name;
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
