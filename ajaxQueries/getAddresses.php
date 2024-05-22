<?php

include('../models/BillingAddress.php');

$billings = BillingAddress::getAddresses($_GET['clientId']);

echo json_encode($billings);