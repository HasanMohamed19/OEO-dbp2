<?php
    include 'debugging.php';
    include './helpers/Database.php';
    include './models/CardDetail.php';
    include './models/PersonalDetails.php';
    include './models/CompanyDetails.php';
    include './models/User.php';
    include './models/Client.php';
    include './models/Reservation.php';
    include './models/hall.php';
    include './models/BillingAddress.php';
    include './header.php';
    
//    echo 'what is happening';
    // if add/edit card form submitted
    
    // assuming admin id is always 1
if ($_COOKIE['userId'] == 1) {
    header("Location: 404.php");
}
    
    $loggedInClientId = $_COOKIE['clientId'];
    
    if (isset($_POST['submitted'])) {
        $card = new CardDetail();
        $card->setCardId($_POST['Add-CardID']);
        $card->setCardholderName($_POST['cardholdername']);
        $card->setCardNumber($_POST['cardNumber']);
        $card->setCVV($_POST['CVV']);
        $expiryDate = trim($_POST['cardExpiryYear']).'-'.trim($_POST['cardExpiryMonth']).'-28';
        $card->setExpiryDate($expiryDate);
        // get from the cookie
        $card->setClientId($loggedInClientId);
        $client = new Client();
        $client->setClientId($loggedInClientId);
//        echo $client->getClientStatusName('1')->status_name . ' status name';
        
    if ($card->getCardId() == '') {
        if ($card->addCard()) {
                //display successful message
            echo '<br><div class="container"><div class="alert alert-success alert-dismissible fade show" role="alert"> The Card has been added Sucessfullly!<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div></div>';
        }
    } else if ($card->updateCard()) {
//        echo 'expiryDate ' . $card->getExpiryDate() ;
        echo '<br><div class="container"><div class="alert alert-success alert-dismissible fade show" role="alert"> The Card has been Updated Sucessfullly!<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div></div>';
    }
        
//        if ($card->addCard()) {
//            echo 'added card successfully';
////            echo 'console.log("added card")';
//        } else {
//            echo ' card disapperaed';
//            echo 'console.log("disapperaed card")';
//        }
//    }
}
//    echo '   ' . $_POST['gender'] . 'gender';
    // for profile
    if (isset($_POST['profileSubmitted'])) {
        // create personal and comapny details object
        $personal = new PersonalDetails();
        $company = new CompanyDetails();
        
        // set current client id
        $personal->setClientId($loggedInClientId);
        $company->setClientId($loggedInClientId);
        
        $personal->initWithClientId();
        $company->initWithClientId();
//        var_dump($personal);
        
        // personal fields
        $personal->setFirstName($_POST['firstname']);
        $personal->setLastName($_POST['lastname']);
        $personal->setNationality($_POST['nationality']);
        $personal->setDob($_POST['dob']);
        
        $personal->setGender($_POST['gender']);
//        $personal->setClientId('1');
        
        // company details
        $company->setName($_POST['companyname']);
        $company->setComapnySize($_POST['companysize']);
        $company->setCity($_POST['city']);
        $company->setWebsite($_POST['website']);
//        $company->setClientId('1');
        
        if ($company->updateCompanyDetails()) {
            echo '<br><div class="container"><div class="alert alert-success alert-dismissible fade show" role="alert"> Company Details has been Updated Sucessfullly!<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div></div>';
        } else {
            echo '<br><div class="container"><div class="alert alert-error alert-dismissible fade show" role="alert"> An error occured: Company Details has not been Updated. <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div></div>';
        }
        
        if ($personal->updatePersonalDetails()) {
            echo '<br><div class="container"><div class="alert alert-success alert-dismissible fade show" role="alert"> Personal Details has been Updated Sucessfullly!<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div></div>';
        } else {
            echo '<br><div class="container"><div class="alert alert-error alert-dismissible fade show" role="alert"> An error occured: Personal Details has not been Updated. <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div></div>';
        }
        
        // upload company details this will be for registration
//        if ($company->addCompanyDetails()) {
//            echo 'added details successfully';
//        } else {
//            echo 'didnt add details';
//        }
//        
//        if ($personal->addPersonalDetails()) {
//            echo 'added personal details successfully';
//        } else {
//            echo 'didnt add details';
//        }
        
    }
    
    if (isset($_POST['addressSubmitted'])) {
        $address = new BillingAddress();
        
        $address->setAddressId($_POST['Add-AddressID']);
        $address->setBuildingNumber($_POST['bldgNumber']);
        $address->setRoadNumber($_POST['streetNumber']);
        $address->setBlockNumber($_POST['block']);
        $address->setCity($_POST['area']);
        $address->setCountry($_POST['country']);
        $address->setPhoneNumber($_POST['phoneNumber']);
        echo 'phoneNumber ' . $_POST['phoneNumber'];
        // get from the cookie
        $address->setClientId($loggedInClientId);
//        echo $address->getCity() . ' city';
        
        if ($address->getAddressId() == '') {
            if ($address->addBillingAddress()) {
                echo 'as ' . $address->getPhoneNumber();
                    //display successful message
                echo '<br><div class="container"><div class="alert alert-success alert-dismissible fade show" role="alert"> The Address has been added Sucessfullly!<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div></div>';
            }
        } else if ($address->updateBillingAddress()) {
            echo '<br><div class="container"><div class="alert alert-success alert-dismissible fade show" role="alert"> The Address has been Updated Sucessfullly!<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div></div>';
        }
    }
    
        if (isset($_POST['accountSubmitted'])) {
        $user = new User();
        $userId = $_COOKIE['userId'];
        echo $userId . ' is userid';
        $clientId = $_COOKIE['clientId'];
        $username = $_POST['username'];
        $email = $_POST['email'];
        echo $email . 'is  email';
        $phoneNumber = $_POST['phoneNumber'];
        $password = $_POST['password'];

        $user->setUserId($userId);
        $user->setUsername($username);
        $user->setEmail($email);
        $user->setPassword($password);
        $user->setRoleId(ROLE_CLIENT);
        $client = new Client();
        $client->setPhoneNumber($phoneNumber);
//        echo $user->getEmail() . ' is new email';
        $updatedUser = $user->updateUser($userId);
        $updatedClient = $client->updateClient($clientId);
        // message remaining
        if ($updatedUser && $updatedClient) {
            echo 'Updated Both';
        } else if ($updatedClient) {
            echo 'updated client';
        } else if ($updatedUser) {
            echo 'updated user';
        } else {
            echo 'nothing updated';
        }
        
    }
    
    // check for deletes:
    // card deletion:
    if (isset($_POST['deleteCardSubmitted'])) {
        $cardId = trim($_POST['cardId']);
        echo 'card id is: ' . $cardId;
        $deletedCard = new CardDetail();
        $deletedCard->initWithCardId($cardId);
    //    var_dump($deletedCard);
        echo ' id: ' . $deletedCard->getCardId();
        if ($deletedCard->deleteCard()) {
            echo '<br><div class="container"><div class="alert alert-success alert-dismissible fade show" role="alert"> The Card has been deleted Sucessfullly!<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div></div>';
        }
    }
    
    // check for deletes:
    if (isset($_POST['deleteAddressSubmitted'])) {
        $addressId = trim($_POST['addressId']);
        echo '$addressIdis: ' . $addressId;
        $deletedAddress = new BillingAddress();
        $deletedAddress->setAddressId($addressId);
        $deletedAddress->initWithId();
    //    var_dump($deletedCard);
        echo ' id: ' . $deletedAddress->getAddressId();
        if ($deletedAddress->deleteAddress()) {
            echo '<br><div class="container"><div class="alert alert-success alert-dismissible fade show" role="alert"> The Address has been deleted Sucessfullly!<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div></div>';
        }
    }
    
    include './template/myAccounts.php';
    
    include './template/footer.html';

?>