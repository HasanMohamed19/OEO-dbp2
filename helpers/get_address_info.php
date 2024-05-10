<?php
// Include necessary files and classes
include '../debugging.php';
include '../models/BillingAddress.php';

// Check if hallId parameter is provided
if (isset($_GET['addressId'])) {
    // Get hallId from the request
    $addressId = $_GET['addressId'];

    try {
        // Create a new instance of the Hall class
        $address = new BillingAddress();
        $address->setAddressId($addressId);
        // Initialize the hall object with data based on hallId
        $address->initWithId();
        // Prepare the response data
        $responseData = array(
            'addressId' => $address->getAddressId(),
            'phoneNumber' => $address->getPhoneNumber(),
            'buildingNumber' => $address->getBuildingNumber(),
            'streetNumber' => $address->getRoadNumber(),
            'blockNumber' => $address->getBlockNumber(),
            'area' => $address->getCity(),
            'country' => $address->getCountry(),
            'clientId' => $address->getClientId()
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
    echo json_encode(array('error' => 'Address ID is required'));
}
?>
