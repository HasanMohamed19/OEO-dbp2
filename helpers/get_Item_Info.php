<?php
// Include necessary files and classes
include '../debugging.php';
include '../models/MenuItem.php'; // Include the Hall class definition

// Check if itemId parameter is provided
if (isset($_GET['itemId'])) {
    // Get itemId from the request
    $itemId = $_GET['itemId'];

    try {
        // Create a new instance of the Hall class
        $Item = new MenuItem();
        
        // Initialize the Item object with data based on item id
        $Item->initWithMenuItemid($itemId);

        // Prepare the response data
        $responseData = array(
            'ItemId' => $Item->getItemId(),
            'name' => $Item->getName(),
            'description' => $Item->getDescription(),
            'price' => $Item->getPrice(),
            'image_path' => $Item->getImagePath(),
            'service_id' => $Item->getCateringServiceId()
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
    echo json_encode(array('error' => 'Item ID is required'));
    
}
?>
