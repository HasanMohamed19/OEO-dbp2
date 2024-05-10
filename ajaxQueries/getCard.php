<?php
include '../debugging.php';
include '../models/CardDetail.php';

$card = new CardDetail();
$card->setCardId($_GET['id']);
$card->initWithId();
//var_dump($card);
//echo intval(explode('-', $card->getExpiryDate())[0])."     ";
$arr = [
    'Number'=>$card->getCardNumber(),
    'holderName'=>$card->getCardholderName(),
    'ExpiryYear'=>intval(explode('-', $card->getExpiryDate())[0]),
    'ExpiryMonth'=>intval(explode('-', $card->getExpiryDate())[1]),
    'CVV'=>$card->getCVV()
];
//var_dump($arr);
echo json_encode($arr);