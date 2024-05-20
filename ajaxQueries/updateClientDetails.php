<?php
include_once '../debugging.php';
include_once '../helpers/Database.php';
include_once '../models/User.php';
include_once '../models/Client.php';
include_once '../models/PersonalDetails.php';
include_once '../models/CompanyDetails.php';
$updateFailedMessage = 'Update failed.';

$clientId = $_POST['clientId'];
$data  = [];
if (isset($_POST['firstName'])) {
    // add personal details
    $personal = new PersonalDetails();
    $personal->setFirstName($_POST['firstName']);
    $personal->setLastName($_POST['lastName']);
    $personal->setDob($_POST['dob']);
    $personal->setNationality($_POST['nationality']);
    $personal->setGender($_POST['gender']);
    $personal->setClientId($clientId);
    if (isset($_POST['personalId'])) {
        $personal->setPersonalDetialId($_POST['personalId']);
    }
    if (!$personal->addPersonalDetails()) {
//            echo $registrationFailedMessage;
        echo $updateFailedMessage;
        exit();
    }
    // return new personalId if new one was added
    if (!isset($_POST['personalId']) || empty($_POST['personalId'])) {
        $data['personalId'] = $personal->getPersonalDetialId();
    }
} else {
    // delete personal details if not set
    if (!PersonalDetails::deletePersonalDetail($clientId)) {
        echo $updateFailedMessage;
        exit();
    }
    $data['personalId'] = -1;
}

if (isset($_POST['companyName'])) {
    // add company details
    $company = new CompanyDetails();
    $company->setName($_POST['companyName']);
    $company->setComapnySize($_POST['size']);
    $company->setCity($_POST['city']);
    $company->setWebsite($_POST['website']);
    $company->setClientId($clientId);
    if (isset($_POST['companyId'])) {
        $company->setComapnyId($_POST['companyId']);
    }
    if (!$company->addCompanyDetails()) {
//            echo $registrationFailedMessage;
        echo $updateFailedMessage;
        exit();
    }
    // return new companyId if new one was added
    if (!isset($_POST['companyId']) || empty($_POST['companyId'])) {
        $data['companyId'] = $company->getComapnyId();
    }
    
} else {
    // delete company details if not set
    if (!CompanyDetails::deleteCompanyDetail($clientId)) {
        echo $updateFailedMessage;
        exit();
    }
    $data['companyId'] = -1;
}

echo json_encode($data);