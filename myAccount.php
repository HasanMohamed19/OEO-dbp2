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
        $card->setCardNumber('1234 5678 9012 3456');
        $card->setCVV('333');
        $card->setExpiryDate('5-5-2025');
        $card->setClientId('1000');

        if ($card->addCard()) {
            echo 'added card successfully';
            echo 'console.log("added card")';
        } else {
            echo ' card disapperaed';
            echo 'console.log("disapperaed card")';
        }

    }

?>
