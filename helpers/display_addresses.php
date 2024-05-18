<?php

//include_once '../models/User.php';
include_once '../debugging.php';
include_once '../models/BillingAddress.php';
 
//if ($_GET['clientId']) {
//    echo 'asa';
//} else {
//    echo 'asasasa';
//}

$address = new BillingAddress();
$address->setClientId($_COOKIE['clientId']);
$dataSet = $address->getAddresses($_COOKIE['clientId']);
//echo count($dataSet) . ' count were found';
displayAddresses($dataSet);

function displayAddresses($dataSet) {

        if (!empty($dataSet)) {
            for ($i = 0; $i < count($dataSet); $i++) {
                $address = new BillingAddress();
                // todo: get this from the login
//                $address->setClientId('13');
                $addressId = $dataSet[$i]->address_id;
                $address->setAddressId($addressId);
                $address->initWithId();

                echo '<div class="col card my-3 mx-3 w-50 align-self-center">
                        <div class="card-body vstack gap-2 align-items-center">
                            <div class="row fw-bold"><h2>Company Address</h2></div>';

                echo '<div class="row m-2">
                        <span class="col text-start text-secondary">Phone Number: ' . $address->getPhoneNumber() . '</span>
                     </div>';

                echo ' <div class="row m-2">
                        <span class="col text-start text-secondary">Building: ' . $address->getBuildingNumber() . ', Street: ' . $address->getRoadNumber() . ', Block: ' . $address->getBlockNumber() . '</span>
                     </div>';

                echo '<div class="row m-2">
                        <span class="col text-start text-secondary">' . $address->getCity() . ', ' . $address->getCountry() . ' </span>
                      </div>';

                echo '</div><div class="row m-2 gap-1">';
                echo '<button id="editAddressBtn" class="col btn btn-primary fw-bold col rounded justify-content-end" data-id="' . $address->getAddressId() . '" data-bs-toggle="modal" data-bs-target="#editAddressModal" onclick="setCardId(this)">Edit</button>
                    <button class="btn btn-danger col rounded" data-id="' . $address->getAddressId() . '" data-bs-toggle="modal" data-bs-target="#deleteAddressModal" onclick="setAddressId(this)" id="deleteAddressBtn">Delete</button>
                            </div>
                        </div>';
            }
        }
    }
