<?php
include 'debugging.php';



include './helpers/Database.php';
include './models/User.php';
include './models/Client.php';
include './models/PersonalDetails.php';
include './models/CompanyDetails.php';
$registrationFailedMessage = 'Registration failed.';
if (isset($_POST['submitted'])) {
    $client = new Client();
    $client->setEmail($_POST['email']);
    $client->setUsername($_POST['username']);
    $client->setPassword($_POST['password']); 
    $client->setPhoneNumber($_POST['phone']);
    $client->setRoleId(ROLE_CLIENT);

    if (!$client->initWithUsername()) {
        echo 'Username already exists.';
        exit();
    }
    if (!$client->registerUser()) {
        echo $registrationFailedMessage;
        exit();
    }
    
    if (isset($_POST['firstName'])) {
        // add personal details
        $personal = new PersonalDetails();
        $personal->setFirstName($_POST['firstName']);
        $personal->setLastName($_POST['lastName']);
        $personal->setDob($_POST['dob']);
        $personal->setNationality($_POST['nationality']);
        $personal->setGender($_POST['gender']);
        $personal->setClientId($client->getClientId());
        if (!$personal->addPersonalDetails()) {
//            echo $registrationFailedMessage;
            echo 'personal failed';
            exit();
        }
    }
    
    if (isset($_POST['companyName'])) {
        // add company details
        $company = new CompanyDetails();
        $company->setName($_POST['companyName']);
        $company->setComapnySize($_POST['size']);
        $company->setCity($_POST['city']);
        $company->setWebsite($_POST['website']);
        $company->setClientId($client->getClientId());
        if (!$company->addCompanyDetails()) {
//            echo $registrationFailedMessage;
            echo 'company failed';
            exit();
        }
    }

    echo 1;
    exit();
}


include './template/header.html';
    
echo '<div class="main"> ';
include './template/register.html';
echo '</div>';

include './template/footer.html';