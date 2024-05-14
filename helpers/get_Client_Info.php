<?php
// Include necessary files and classes
include '../debugging.php';
//include './helpers/Database.php';
include '../models/User.php';
include '../models/Client.php';
include '../models/PersonalDetails.php';
include '../models/CompanyDetails.php'; // Include the user class definition

// Check if userId parameter is provided
if (isset($_GET['userId'])) {
    // Get hallId from the request
    $userId = $_GET['userId'];

    try {
        // Create a new instances of the user,client,personal/company details classes
        $user = new User();
        $client = new Client();
        $pd = new PersonalDetails();
        $cmp =  new CompanyDetails();
        
        // Initialize the objects with data based on userId
        $user->initWithUserid($userId);
        $client->iniwWithUsertId($userId);
        
        $pd->setClientId($client->getClientId());
        $pd->initWithClientId();
        
        $cmp->setClientId($client->getClientId());
        $cmp->initWithClientId();
        
        // Prepare the response data
        $responseData = array(
            'userId' => $user->getUserId(),
            'username' => $user->getUsername(),
            'email' => $user->getEmail(),
            'clientId' => $client->getClientId(),
            'phoneNumber' => $client->getPhoneNumber(),
            'clientStatus' => $client->getClientStatusName($client->getClientId()),
            'firstName' => $pd->getFirstName(),
            'lastName' => $pd->getLastName(),
            'dob' => $pd->getDob(),
            'gender' => $pd->getGender(),
            'nationality' => $pd->getNationality(),
            'companyName' => $cmp->getName(),
            'companySize' => $cmp->getComapnySize(),
            'city' => $cmp->getCity(),
            'website' => $cmp->getWebsite()  
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
    echo json_encode(array('error' => 'User ID is required'));
}
?>
