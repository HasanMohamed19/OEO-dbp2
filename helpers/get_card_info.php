<?php
// Include necessary files and classes
include '../debugging.php';
include '../models/CardDetail.php'; // Include the Hall class definition

// Check if hallId parameter is provided
if (isset($_GET['cardId'])) {
    // Get hallId from the request
    $cardId = $_GET['cardId'];

    try {
        // Create a new instance of the Hall class
        $card = new CardDetail();
        
        // Initialize the hall object with data based on hallId
        $card->initWithCardId($cardId);
        // Prepare the response data
        $responseData = array(
            'cardId' => $card->getCardId(),
            'cardNumber' => $card->getCardNumber(),
            'cardholderName' => $card->getCardholderName(),
            'CVV' => $card->getCVV(),
            'expiryDate' => $card->getExpiryDate(),
            'clientId' => $card->getClientId()
        );

        // Send JSON response
        header('Content-Type: application/json');
        echo json_encode($responseData);
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
