<?php
// Include necessary files and classes
//include '../debugging.php';
include '../models/HallImage.php'; // Include the Hall class definition
// Check if hallId parameter is provided
if (isset($_GET['hallIdImg'])) {
    // Get hallId from the request
    $hallIdImg = $_GET['hallIdImg'];

    try {
        // Create a new instance of the Hall class
        $hallImage = new HallImage();
        
        // Initialize the hall object with data based on hallId
        $responseData = $hallImage->getAllImagesForHall($hallIdImg);

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
