<?php
    
    include 'debugging.php';

    include './template/header.html';
    include './template/myAccount.html';
    include './template/footer.html';


    include './helpers/Database.php';
    include './models/CardDetail.php';
    include './models/PersonalDetails.php';
    include './models/CompanyDetails.php';
    include './models/Client.php';
//    include './models/User.php';
    
    if (isset($_POST['submitted'])) {
        $card = new CardDetail();
        $card->setCardholderName($_POST['cardholdername']);
        $card->setCardNumber($_POST['cardNumber']);
        $card->setCVV($_POST['CVV']);
        $card->setExpiryDate('0001-01-28');
        // get from the cookie
        $card->setClientId('1');
        $client = new Client();
        $client->setClientId('1');
        echo $client->getClientStatusName('1')->status_name . ' status name';
        if ($card->addCard()) {
            echo 'added card successfully';
//            echo 'console.log("added card")';
        } else {
            echo ' card disapperaed';
            echo 'console.log("disapperaed card")';
        }
        
        echo count($card->getAllCardsForUser()) . " were found";
        $card->displayCards($card->getAllCardsForUser());

    }
    
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
        
        echo $personal->getFirstName() . ' first name';
        echo $company->getCity() . ' city ';
        
        // personal fields
        $personal->setFirstName($_POST['firstname']);
        $personal->setLastName($_POST['lastname']);
        $personal->setNationality($_POST['nationality']);
        $personal->setAge('2022-5-3');
        $personal->setGender('M');
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

?>
