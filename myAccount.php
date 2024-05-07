<?php
    
    include 'debugging.php';

    include './template/header.html';
    include './template/myAccount.html';
    include './template/footer.html';


    include './helpers/Database.php';
    include './models/CardDetail.php';
    include './models/PersonalDetails.php';
    include './models/CompanyDetails.php';
    
    if (isset($_POST['submitted'])) {
        $card = new CardDetail();
        $card->setCardholderName('hasan');
        $card->setCardNumber($_POST['cardNumber']);
        $card->setCVV($_POST['CVV']);
        $card->setExpiryDate('5-5-2025');
        // get from the cookie
        $card->setClientId('1');
        
        if ($card->addCard()) {
            echo 'added card successfully';
//            echo 'console.log("added card")';
        } else {
            echo ' card disapperaed';
            echo 'console.log("disapperaed card")';
        }

    }
    
    if (isset($_POST['profileSubmitted'])) {
        // create personal and comapny details object
        $personal = new PersonalDetails();
        $company = new CompanyDetails();
        
        // personal fields
        $personal->setFirstName($_POST['firstname']);
        $personal->setLastName($_POST['lastname']);
        $personal->setNationality($_POST['nationality']);
        $personal->setAge('2022-5-3');
        $personal->setGender('M');
        $personal->setClientId('1');
        
        // company details
        $company->setName($_POST['companyname']);
        $company->setComapnySize($_POST['companysize']);
        $company->setCity($_POST['city']);
        $company->setWebsite($_POST['website']);
        $company->setClientId('1');
        
        // upload company details
        if ($company->addCompanyDetails()) {
            echo 'added details successfully';
        } else {
            echo 'didnt add details';
        }
        
        if ($personal->addPersonalDetails()) {
            echo 'added personal details successfully';
        } else {
            echo 'didnt add details';
        }
        
    }

?>
