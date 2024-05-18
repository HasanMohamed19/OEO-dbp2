<?php

//include_once '../models/User.php';
include_once '../debugging.php';
include_once '../models/CardDetail.php';
 
//if ($_GET['clientId']) {
//    echo 'asa';
//} else {
//    echo 'asasasa';
//}

$card = new CardDetail();
$card->setClientId($_COOKIE['clientId']);
$dataSet = $card->getAllCardsForUser();
//echo count($dataSet) . ' count were found';
displayCards($dataSet);

function displayCards($dataSet) {

    if (!empty($dataSet)) {
        for ($i = 0; $i < count($dataSet); $i++) {
            $card = new CardDetail();
            // todo: get this from the login
//                $card->setClientId($_COOKIE['clientId']);
            $cardId = $dataSet[$i]->card_id;
            $card->initWithCardId($cardId);
            
            echo '<div class="col card my-3 mx-3 align-self-center">
                        <div class="card-body vstack gap-2">';

            echo '<div class="row fw-bold justify-content-center"><h2 class="text-center">' . $card->getCardNumber() . '</h2></div>';
            echo '<div class="row justify-content-between">'
            . '<span class="col justify-content-end fw-bold">' . $card->getExpiryDate() . '</span>'
            . '<span class="col justify-content-start fw-bold text-end">' . $card->getCardholderName() . '</span></div>';
            echo '<div class="row my-2 gap-2">';
            echo '<button id="editCardBtn" class=" col btn btn-primary fw-bold col border-0 justify-content-end" data-id="' . $card->getCardId() . '" data-bs-toggle="modal" data-bs-target="#editCardModal">Edit</button>';
            echo '<button class=" col btn btn-danger rounded" data-id="' . $card->getCardId() . '" data-bs-toggle="modal" data-bs-target="#deleteModal" onclick="setCardId(this)" id="deleteCardBtn">Delete</button>';
            echo '</div></div></div>';
        }
    }
}
