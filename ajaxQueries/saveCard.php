<?php

//include ('../debugging.php');
include('../models/CardDetail.php');

$card = new CardDetail();
$card->setCVV($_POST['cvv']);
$card->setCardNumber($_POST['cardNumber']);
$card->setCardholderName($_POST['cardholderName']);
$expiryDate = trim($_POST['expiryYear']).'-'.trim($_POST['expiryMonth']).'-28';
$card->setExpiryDate($expiryDate);
$card->setClientId($_POST['clientId']);
$card->addCardDetail();

echo $card->getCardId();