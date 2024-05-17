<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */
include './debugging.php';
include './helpers/Database.php';
include './models/User.php';
include './models/Client.php';
include './models/PersonalDetails.php';
include './models/CompanyDetails.php';
include './template/header.html';

if (isset($_POST['clientFormSubmitted'])) {
//initialze a new Client object
    $userid = trim($_POST['Add-UserID']);
    $user = new User();

//assign object values using set methods of user class
    $user->setUserId($userid);
    $user->setUsername(trim($_POST['usrName']));
    $user->setPassword(trim($_POST['pwd']));
    $user->setRoleId(ROLE_CLIENT);
    $user->setEmail(trim($_POST['email']));

    //get personal details
    $pd = new PersonalDetails();
    $pd->setFirstName(trim($_POST['fName']));
    $pd->setLastName(trim($_POST['lName']));
    $pd->setGender(trim($_POST['gender']));
    $pd->setNationality(trim($_POST['nation']));
    $pd->setDob(trim($_POST['dob']));
    
    
    echo 'client id is' .$user->getClientByUserId();
    //get company details
    $cmp = new CompanyDetails();
    $cmp->setName(trim($_POST['cmpName']));
    $cmp->setComapnySize(trim($_POST['cmpSize']));
    $cmp->setWebsite(trim($_POST['cmpWeb']));
    $cmp->setCity(trim($_POST['cmpcity']));
    $db = Database::getInstance();

    //if user id is empty (New user) add the user
    if ($userid == '') {
        if ($user->initWithUsername()) {
            if ($user->registerUser()) {
                echo'user after register is' .$user->getUserId();
                if (isset($_POST['pdCheckBx'])) {
                    $pd->setClientId($user->getClientByUserId());
                    $pd->addPersonalDetails();
                }
                if (isset($_POST['cmpCheckBx'])) {
                    $cmp->setClientId($user->getClientByUserId());
                    $cmp->addCompanyDetails();
                    
                }
                echo '<br><div class="container"><div class="alert alert-success alert-dismissible fade show" role="alert"> The Client has been Added Sucessfullly!<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div></div>';
            } else {
                echo '<br><div class="container"><div class="alert alert-danger alert-dismissible fade show" role="alert">Error: Client has not been Added<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div></div>';
            }
        } else {
            echo '<br><div class="container"><div class="alert alert-danger alert-dismissible fade show" role="alert">Error: Username Already Exists<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div></div>';
        }
    } else {
        //update user when user id is not empty
        $user->updateUser($userid);
        $clientId = $user->getClientByUserId();
        $client = new Client();
        $client->setClientId($clientId);
        $client->setPhoneNumber($_POST['phoneNumber']);
        echo 'phone number is:'.$client->getPhoneNumber();
        $client->updateClient($clientId);
        
        if (isset($_POST['pdCheckBx'])) {
            $pd->setClientId($clientId);
            if ($pd->getPersonalDetail()){
                $pd->updatePersonalDetails();
            } else {
                $pd->addPersonalDetails();
            }
        }
        if (isset($_POST['cmpCheckBx'])) {
            $cmp->setClientId($clientId);
            if ($cmp->getCompanyDetail()){
                $cmp->updateCompanyDetails();
            } else {
                $cmp->addCompanyDetails();
            } 
        }
    }
}
if (isset($_POST['deleteClientSubmitted'])) {
    $userID = trim($_POST['userId']);
    $deletedUser = new User();
    $deletedUser->initWithUserid($userID);
    if ($deletedUser->deleteUser()) {
        echo '<br><div class="container"><div class="alert alert-success alert-dismissible fade show" role="alert"> The Client has been deleted Sucessfullly!<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div></div>';
    }
}
include './template/admin/DisplayClients.html';
include './template/footer.html';
