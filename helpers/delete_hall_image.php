<?php

// Include necessary files and classes
include '../debugging.php';
include '../models/HallImage.php'; // Include the Hall class definition
// Check if itemId parameter is provided
if (isset($_POST['imgArray'])) {
    // Get itemId from the request
    $imgArray = $_POST['imgArray'];

    try {
//        $myArray = json_decode($_POST['imgArray']);
        foreach ($imgArray as $imagePath) {
            // Create a new instance of the HallImage class
            $img = new HallImage();
            $img->setHallImagePath($imagePath);
            $img->deleteImage();
        }
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
