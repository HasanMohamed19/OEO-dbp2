<?php
    
    include 'debugging.php';

    include './template/header.html';
    include './template/myAccount.html';
    include './template/footer.html';


    include './helpers/Database.php';
    include './models/CardDetail.php';

    
    
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
            echo 'console.log("added card")';
        } else {
            echo ' card disapperaed';
            echo 'console.log("disapperaed card")';
        }

    }

?>
