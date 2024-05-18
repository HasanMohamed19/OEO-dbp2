<?php
// Include necessary files and classes
include '../debugging.php';
include '../models/BillingAddress.php'; // Include the Hall class definition

// Check if hallId parameter is provided
if (isset($_GET['clientId'])) {
    // Get cleintId from the request
    $clientId = $_GET['clientId'];

    try {
        // Create a new instance of the Hall class
        $card = new BillingAddress();
        // Prepare the response data
        $numberOfCards = $card->getAddressCount($clientId);
//        $responseData = array(
//            'numberOfCards'=>$numberOfCards
//        );
        $responseData = $numberOfCards;
        // Send JSON response
        header('Content-Type: text/html');
        echo $responseData;
    } catch (Exception $e) {
        // Handle any exceptions
        header('HTTP/1.1 500 Internal Server Error');
        echo json_encode(array('error' => 'An error occurred: ' . $e->getMessage()));
    }
} else {
    // Return error if hallId parameter is missing
    header('HTTP/1.1 400 Bad Request');
    echo json_encode(array('error' => 'Client ID is required'));
}
?>
