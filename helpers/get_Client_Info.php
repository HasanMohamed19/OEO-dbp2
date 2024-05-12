<?php
// Include necessary files and classes
include '../debugging.php';
include '../models/Hall.php'; // Include the Hall class definition

// Check if hallId parameter is provided
if (isset($_GET['hallId'])) {
    // Get hallId from the request
    $hallId = $_GET['hallId'];

    try {
        // Create a new instance of the Hall class
        $hall = new Hall();
        
        // Initialize the hall object with data based on hallId
        $hall->initWithHallid($hallId);
        // Prepare the response data
        $responseData = array(
            'hallId' => $hall->getHallId(),
            'hallName' => $hall->getHallName(),
            'description' => $hall->getDescription(),
            'rentalCharge' => $hall->getRentalCharge(),
            'capacity' => $hall->getCapacity(),
            'imagePath' => $hall->getImagePath()
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
