<?php

include('../models/CardDetail.php');

$cards = CardDetail::getCards($_GET['clientId']);

echo json_encode($cards);