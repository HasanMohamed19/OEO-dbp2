<?php
    include './helpers/Database.php';
    include './models/CardDetail.php';
    include './models/PersonalDetails.php';
    include './models/CompanyDetails.php';
    include './models/Client.php';
    include './models/Reservation.php';
    include './models/hall.php';
    include './models/BillingAddress.php';
    include './template/header.html';   
    
    include 'debugging.php';
//    echo 'what is happening';
    // if add/edit card form submitted
    if (isset($_POST['submitted'])) {
        $card = new CardDetail();
        $card->setCardId($_POST['Add-CardID']);
        $card->setCardholderName($_POST['cardholdername']);
        $card->setCardNumber($_POST['cardNumber']);
        $card->setCVV($_POST['CVV']);
        $expiryDate = trim($_POST['cardExpiryYear']).'-'.trim($_POST['cardExpiryMonth']).'-28';
        $card->setExpiryDate($expiryDate);
        // get from the cookie
        $card->setClientId('1');
        $client = new Client();
        $client->setClientId('1');
        echo $client->getClientStatusName('1')->status_name . ' status name';
        
    if ($card->getCardId() == '') {
        if ($card->addCard()) {
                //display successful message
            echo '<br><div class="container"><div class="alert alert-success alert-dismissible fade show" role="alert"> The Card has been added Sucessfullly!<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div></div>';
        }
    } else if ($card->updateCard()) {
        echo 'expiryDate ' . $card->getExpiryDate() ;
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
        $personal->setClientId('1');
        $company->setClientId('1');
        
        $personal->initWithClientId();
        $company->initWithClientId();
//        var_dump($personal);
        
        // personal fields
        $personal->setFirstName($_POST['firstname']);
        $personal->setLastName($_POST['lastname']);
        $personal->setNationality($_POST['nationality']);
        $personal->setDob('2022-5-3');
        
        $personal->setGender($_POST['gender']);
//        $personal->setClientId('1');
        
        // company details
        $company->setName($_POST['companyname']);
        $company->setComapnySize($_POST['companysize']);
        $company->setCity($_POST['city']);
        $company->setWebsite($_POST['website']);
//        $company->setClientId('1');
        
        if ($company->updateCompanyDetails()) {
             echo 'updated company details successfully';
        } else {
            echo 'not updated company';
        }
        
        if ($personal->updatePersonalDetails()) {
             echo 'updated personal details successfully';
        } else {
            echo 'not updated personal';
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
        $address->setClientId('1');
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
    
    include './template/myAccounts.php';
    
    include './template/footer.html';

?>