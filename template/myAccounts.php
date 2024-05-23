<?php
$loggedInClientId = $_COOKIE['clientId'];
include './models/Pagination.php';
?>

<!DOCTYPE html>
<body>
    <div class="container main">
        <div class="row mb-5 mt-3">
            <h1>My Account</h1>
        </div>

        <div class="d-flex gap-3">
            <div class="my-account-sidebar align-self-center">
                <div class="row">
                    <div class="card col shadow-sm">

                        <div class="list-group list-group-flush">
                            <button type="button" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center active-side-btn">
                                <strong>My Bookings</strong>
                                <i class="fa-solid fa-arrow-right"></i>
                            </button>
                            <button type="button" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                <strong>Payment Cards</strong>
                                <i class="fa-solid fa-arrow-right"></i>
                            </button>
                            <button id="points" type="button" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                <strong>Royalty Points</strong>
                                <i class="fa-solid fa-arrow-right"></i>
                            </button>
                            <button type="button" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                <strong>Profile (Details)</strong>
                                <i class="fa-solid fa-arrow-right"></i>
                            </button>
                            <button type="button" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                <strong>Account </strong>
                                <i class="fa-solid fa-arrow-right"></i>
                            </button>
                            <button type="button" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                <strong>Address Book</strong>
                                <i class="fa-solid fa-arrow-right"></i>
                            </button>
                            <a role="button" type="button" href="logout.php" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                <strong>Logout</strong>
                            </a>
                        </div>

                    </div>
                </div>
            </div>

            <div class="row my-account-body">
                <!-- my bookings -->
                <div class="card col shadow-sm ms-4 px-0">
                    <div class="card-header">
                        <h3>My Bookings</h3>
                    </div>
                    <?php
                    if (isset($_GET['pageno']))
                        $start = $_GET['pageno'];
                    else
                        $start = 1;

                    $end = 10;
                    $reservation = new Reservation();
                    $reservation->setClientId($loggedInClientId);
                    $reservations = $reservation->getReservationsForClient($start, $end);
                    ?>
                    <div class="table-responsive mx-4 px-0 mt-3">
                        <table class="table table-striped border <?php if (count($reservations) <= 0) echo 'd-none' ?>">
                            <thead>
                                <tr class="text-center">
                                    <th scope="col">Booking #</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">date</th>
                                    <th scope="col">Event</th>
                                    <th scope="col">Hall</th>
                                    <th scope="col">Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $reservation->displayClientReservations($reservations);
                                ?>
                            </tbody>

                        </table>
                        <?php
                        if (count($reservations) >= 1) {
                            $pagination = new Pagination();
                            $pagination->setTotal_records(Reservation::countReservationsForClient($loggedInClientId));
                            $pagination->setLimit($end);
                            $pagination->page("");
                        }
                        ?>
                    </div>


                </div> 
                <!-- end of  my bookings-->

                <!-- mycards -->
                <div class="card col shadow-sm ms-4 px-0 inactive">
                    <div class="card-header">
                        <h3>My Cards</h3>
                    </div>

<?php
$card = new CardDetail();
$card->setClientId($loggedInClientId);
$cards = $card->getAllCardsForUser();
displayCards($cards);
?>

                    <div class="row mx-auto mb-2" style="width: 15%;">
                        <button id="btnAddCard" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editCardModal"> +Add </button>
                    </div>

                </div>


                <!-- My Cards Modal -->
                <div class="modal fade" id="editCardModal">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="staticBackdropLabel">Add/Edit Card</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="card-add-form" novalidate action="displayMyAccount.php" method="post">
                                    <div class="row">
                                        <div class="col form-group required">
                                            <label for="cardholdername" class="form-label" >Cardholder name</label>
                                            <input type="text" name="cardholdername" minlength="3" maxlength="50" id="cardholdernameInput" class="form-control" required/>
                                        </div>
                                        <div class="col form-group required">
                                            <label for="cardNumber" class="form-label">Card Number</label>
                                            <input type="text" inputmode="numeric" pattern="[0-9\s]{16}" minlength="16" maxlength="16" id="cardNumberInput" class="form-control" name="cardNumber" required>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col form-group required">
                                            <label for="CVV" class="form-label">CVV</label>
                                            <input type="text" inputmode="numeric" pattern="[0-9]{3}" minlength="3" maxlength="3" id="CVVInput" class="form-control" name="CVV" value="" required>
                                        </div>

                                        <div class="col form-group required">
                                            <label for="cardExpiryYear" class="form-label">Card Expiry Year</label>
                                            <select name="cardExpiryYear" id="cardExpiryYear" class="form-select" required>
                                                <option disabled selected value="">Year</option>
                                            </select>
                                        </div>

                                        <div class="col form-group required">
                                            <label for="cardExpiryMonth" class="form-label">Month</label>
                                            <select name="cardExpiryMonth" id="cardExpiryMonth" class="form-select" required>
                                                <option selected disabled value="">Month</option>
                                                <option value="1">January (1)</option>
                                                <option value="2">February (2)</option>
                                                <option value="3">March (3)</option>
                                                <option value="4">April (4)</option>
                                                <option value="5">May (5)</option>
                                                <option value="6">June(6)</option>
                                                <option value="7">July(7)</option>
                                                <option value="8">August(8)</option>
                                                <option value="9">September (9)</option>
                                                <option value="10">October (10)</option>
                                                <option value="11">November (11)</option>
                                                <option value="12">December (12)</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row mt-3">
                                        <button type="submit" class="btn btn-primary mx-auto" style="width: 40%;">Save</button>
                                        <input type="hidden" name="submitted" value="1">
                                        <input type="hidden" name="Add-CardID" id="Add-CardID">
                                    </div>

                                </form>
                            </div>

                        </div>
                    </div>
                </div>

                <!--delete card modal -->
                <div class="modal fade" id="deleteModal">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Delete Confirmation</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                Are You sure You want to delete this Card?
                            </div>
                            <div class="modal-footer">
                                <form action="displayMyAccount.php" method="post">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                    <input type ="hidden" name="deleteCardSubmitted" value="TRUE">
                                    <input type="hidden" id="DeleteIdInput" name="cardId">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- end of my cards -->

                <!-- Royalty Points -->

<?php
//                            include 'debugging.php';
//                        include './models/Client.php';
$cc = new Client();
//                            $client->setClientId('1');
$s = $cc->getClientStatusName($loggedInClientId);
?>

                <div class="card mb-2 ms-4 px-0 inactive">
                    <div class="card-header">
                        <h3>Royalty Points</h3>
                    </div>

                    <div class="row my-status align-self-center my-2">

                        <h1 id="statusName" class="text-uppercase text-center text-white align-self-center"><?php echo $s->status_name ?></h1>
                        <p id="nextStatus" class="text-white text-center align-self-center">3 Bookings to GOLD</p>
                    </div>

                    <div class="card rounded shadow-sm mb-2 mx-3">

                        <ul class="list-group list-group-flush border-0">
                            <li class="list-group-item border-0"><span>How it works?</span></li>
                            <li class="list-group-item border-0"><i class="fa-solid fa-star gold"></i><strong class="ms-2">Gold Tier</strong> are earned on More than 15 booked events</li>
                            <li class="list-group-item border-0"><i class="fa-solid fa-circle silver"></i><strong class="ms-2">Silver Tier</strong> are earned on More than 10 booked events</li>
                            <li class="list-group-item border-0"><i class="fa-solid fa-circle bronze"></i><strong class="ms-2">Bronze Tier</strong> are earned on More than 5 booked events</li>
                        </ul>
                    </div>

                </div>
                <!-- end of Royalty Points -->

                <!--Profile -->
                <div class="card col shadow-sm ms-4 px-0 inactive">
                    <div class="card-header">
                        <h3>Profile</h3>
                    </div>

<?php
$p = new PersonalDetails();
$p->setClientId($loggedInClientId);
$p->initWithClientId();

$c = new CompanyDetails();
$c->setClientId($loggedInClientId);
$c->initWithClientId();
//                            echo $p->getFirstName() . " sdds";
//                            echo $c->getName() . " sdds";
                    ?>
                    <div id="detailsForm" class="card-body">
                        <fieldset id="personalDetailsForm">
                            <div class="form-check mb-3">
                                <input type="checkbox" id="personalDetailsCheck" class="form-check-input mt-2"  <?php if ($p->getPersonalDetialId() > 0) echo 'checked' ?>>
                                <h4 class=""><label for="personalDetailsCheck" class="form-check-label">Personal Details</label></h4>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <input type="text" maxlength="50" minlength="3" value="<?php echo $p->getFirstName() ?>" class="form-control form-control-user mb-3" id="firstName" placeholder="First Name" name="firstName">
                                </div>
                                <div class="col">
                                    <input type="text" maxlength="50" minlength="3" value="<?php echo $p->getLastName() ?>" class="form-control form-control-user mb-3" id="lastName" placeholder="Last Name" name="lastName">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <select class="form-select mb-3" id="gender" name="gender">
                                        <option value="" disabled>Gender</option>
                                        <option value="M" <?php if ($p->getGender() == 'M') echo 'selected' ?>>Male</option>
                                        <option value="F" <?php if ($p->getGender() == 'F') echo 'selected' ?>>Female</option>
                                    </select>
                                </div>
                                <div class="col">
                                    <input type="text" maxlength="20" minlength="3" value="<?php echo $p->getNationality() ?>" class="form-control form-control-user" id="nationality" placeholder="Nationality" name="nationality">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col d-flex align-items-center">
                                    <label class="form-label mb-3 ms-3" for="dob">Date of Birth</label>
                                </div>
                                <div class="col">
                                    <input type="date" value="<?php echo $p->getDob() ?>" class="form-control form-control-user" id="dob" name="dob">
                                </div>
                            </div>
                        </fieldset>
                        <hr>
                        <fieldset id="companyDetailsForm">
                            <div class="form-check mb-3">
                                <input type="checkbox" id="companyDetailsCheck" class="form-check-input mt-2" <?php if ($c->getComapnyId() > 0) echo 'checked' ?>>
                                <h4 class=""><label for="companyDetailsCheck" class="form-check-label">Company Details</label></h4>
                            </div>
                            <input type="text" maxlength="50" minlength="3" value="<?php echo $c->getName() ?>" class="form-control form-control-user mb-3" id="companyName" placeholder="Company Name" name="companyName">
                            <input type="text" maxlength="50" minlength="10" value="<?php echo $c->getWebsite() ?>" class="form-control form-control-user mb-3" id="website" placeholder="Website" name="website">
                            <div class="row">
                                <div class="col">
                                    <input type="text" maxlength="50" value="<?php echo $c->getCity() ?>" class="form-control form-control-user" id="city" placeholder="City" name="city">
                                </div>
                                <div class="col">
                                    <input type="number" min="1" max="99999999999" value="<?php echo $c->getComapnySize() ?>" class="form-control form-control-user" id="size" placeholder="Company Size" name="size">
                                </div>
                            </div>
                        </fieldset>
                    </div>
                    <div class="text-center my-2">
                        <input type="button" class="btn btn-primary" id="saveBtn" value="Save" onclick="updateClientDetails()">
                        <input type="hidden" class="btn btn-primary" id="personalIdInput" value="<?php echo $p->getPersonalDetialId() ?>">
                        <input type="hidden" class="btn btn-primary" id="companyIdInput" value="<?php echo $c->getComapnyId() ?>">
                        <input type="hidden" class="btn btn-primary" id="clientIdInput" value="<?php echo $loggedInClientId ?>">
                    </div>
                    <div id="errorBox" class="text-center text-danger mb-3 d-none">
                        Error
                    </div>
                    <div id="successBox" class="text-center text-success mb-3 d-none">
                        Details have been saved successfully.
                    </div>
                    <script src="javascript/client_details.js"></script>
                    <script>
                        handleDetailsCheckboxes();
                    </script>
<!--                   

                <!-- end of profile -->

<?php
$client = new Client();
$client->iniwWithClientId($_COOKIE['clientId']);

$user = new User();
$user->initWithUserid($_COOKIE['userId']);
?>

                <div class="card col shadow-sm ms-4 px-0 inactive">
                    <div class="card-header">
                        <h3>Edit Account</h3>
                    </div>
                    <div class="container">
                        <form action="displayMyAccount.php" method="post">
                            <div class="row my-2">
                                <div class="col form-group required">
                                    <label for="username" class="form-label">Username</label>
                                    <input type="text" maxlength="20" minlength="3" name="username" class="form-control" placeholder="Username" value="<?php echo $user->getUsername(); ?>">
                                </div>
                                <div class="col form-group required">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" maxlength="50" minlength="10" name="email" class="form-control" placeholder="Email" value="<?php echo $user->getEmail(); ?>">
                                </div>
                            </div>
                            <div class="row my-2 form-group required">
                                <div class="col">
                                    <label for="phoneNumber" class="form-label">Phone Number</label>
                                    <input type="text" maxlength="25" minlength="8" name="phoneNumber" class="form-control" placeholder="Phone Number" value="<?php echo $client->getPhoneNumber(); ?>">
                                </div>
                                <div class="col form-group required">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" maxlength="30" minlength="8" name="password" class="form-control" placeholder="Password">
                                </div>
                            </div>
                            <div class="row my-2">
                                <button type="submit" class="btn btn-primary mx-auto" style="width: 40%;">Save</button>
                                <input type="hidden" name="accountSubmitted" value="1">
                            </div>
                        </form>
                    </div>    
                </div>    

                <!-- book address -->
                <div class="card col shadow-sm ms-4 px-0 inactive">
                    <div class="card-header">
                        <h3>Address Book</h3>
                    </div>

<?php
//                            echo 'book address section';
$address = new BillingAddress();
$address->setClientId($loggedInClientId);
$addresses = BillingAddress::getAddresses($loggedInClientId);
displayAddresses($addresses);
//                            $card->displayCards($cards);
?>

                    <div class="row mx-auto mb-2" style="width: 15%;">
                        <button id="btnAddAddress" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editAddressModal"> +Add </button>
                    </div>
                </div>

            </div>


            <!-- My Addresses Modal -->
            <div class="modal fade" id="editAddressModal">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="staticBackdropLabel">Add/Edit Address</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="address-add-form" novalidate action="displayMyAccount.php" method="post">
                                <div class="row">
                                    <div class="col form-group required">
                                        <label for="bldgNumber" class="form-label" >Building Number</label>
                                        <input type="text" name="bldgNumber" minlength="3" maxlength="10" id="bldgNumberInput" class="form-control" required/>
                                    </div>
                                    <div class="col form-group required">
                                        <label for="streetNumber" class="form-label">Street Number</label>
                                        <input type="text" id="streetNumberInput" minlength="3" maxlength="10" class="form-control" name="streetNumber" required>
                                    </div>
                                    <div class="col form-group required">
                                        <label for="block" class="form-label">Block</label>
                                        <input type="text" id="blockInput" class="form-control" minlength="3" maxlength="10" name="block" value="" required>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col form-group required">
                                        <label for="area" class="form-label">Area</label>
                                        <input type="text" id="areaInput" minlength="3" maxlength="10" class="form-control" name="area" value="" required>
                                    </div>
                                    <div class="col form-group required">
                                        <label for="country" class="form-label">Country</label>
                                        <input type="text" id="countryInput" minlength="3" maxlength="25" class="form-control" name="country" value="" required>
                                    </div>
                                    <div class="col form-group required">
                                        <label for="phoneNumber" class="form-label">Phone Number</label>
                                        <input type="text" id="phoneNumberInput" minlength="8" maxlength="25" class="form-control" name="phoneNumber" value="" required>
                                    </div>
                                </div>

                                <div class="row mt-3">
                                    <button type="submit" class="btn btn-primary mx-auto" style="width: 40%;">Save</button>
                                    <input type="hidden" name="addressSubmitted" value="1">
                                    <input type="hidden" name="Add-AddressID" id="Add-AddressID">
                                </div>

                            </form>
                        </div>

                    </div>
                </div>
            </div>
            <!--end of add/edit modal-->

            <!--delete address modal -->
            <div class="modal fade" id="deleteAddressModal">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Delete Confirmation</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Are You sure You want to delete this Address?
                        </div>
                        <div class="modal-footer">
                            <form action="displayMyAccount.php" method="post">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-danger">Delete</button>
                                <input type ="hidden" name="deleteAddressSubmitted" value="TRUE">
                                <input type="hidden" id="DeleteAddressInput" name="addressId">
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- end of book address -->

            <!--extra card modal-->
            <div class="modal fade" id="noMoreCardModal">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Limit Reached</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Sorry, you cannot add more cards, you have reached maximum card limit (4).
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="button" class="btn btn-primary" data-bs-dismiss="modal">OK</button>
                        </div>
                    </div>
                </div>
            </div>

            <!--extra card modal-->
            <div class="modal fade" id="noMoreAddressModal">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Limit Reached</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Sorry, you cannot add more addresses, you have reached maximum card limit (4).
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="button" class="btn btn-primary" data-bs-dismiss="modal">OK</button>
                        </div>
                    </div>
                </div>
            </div>


            <!--END OF EXTRA MODALS-->

        </div>

    </div>

<?php

function displayCards($dataSet) {

    if (!empty($dataSet)) {
        for ($i = 0; $i < count($dataSet); $i++) {
            $card = new CardDetail();
            // todo: get this from the login
//                $card->setClientId($_COOKIE['clientId']);
            $cardId = $dataSet[$i]->card_id;
            $card->initWithCardId($cardId);
            echo '<div class="card my-3 mx-3 w-50 align-self-center">
                        <div class="card-body vstack gap-2">';

            echo '<div class="row fw-bold justify-content-center"><h2 class="text-center">' . $card->getCardNumber() . '</h2></div>';
            echo '<div class="row">'
            . '<span class="col justify-content-end fw-bold">' . $card->getExpiryDate() . '</span>'
            . '<span class="col text-end justify-content-start fw-bold">' . $card->getCardholderName() . '</span></div>';
            echo '<div class="row my-2 gap-2">';
            echo '<button id="editCardBtn" class=" col btn btn-primary fw-bold col border-0 justify-content-end" data-id="' . $card->getCardId() . '" data-bs-toggle="modal" data-bs-target="#editCardModal">Edit</button>';
            echo '<button class=" col btn btn-danger rounded" data-id="' . $card->getCardId() . '" data-bs-toggle="modal" data-bs-target="#deleteModal" onclick="setCardId(this)" id="deleteCardBtn">Delete</button>';
            echo '</div></div></div>';
        }
    }
}

function displayAddresses($dataSet) {

    if (!empty($dataSet)) {
        for ($i = 0; $i < count($dataSet); $i++) {
            $address = new BillingAddress();
            // todo: get this from the login
//                $address->setClientId('13');
            $addressId = $dataSet[$i]->address_id;
            $address->setAddressId($addressId);
            $address->initWithId();

            echo '<div class="card my-3 mx-3 w-50 align-self-center">
                        <div class="card-body vstack gap-2 align-items-center">
                            <div class="row fw-bold"><h2>Billing Address</h2></div>';

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
?>

</div>

<script src="./helpers/myAccount.js"></script>
<script src="./helpers/CardForm.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>

    const updateCardExpiryYearDropdown = () => {
        // updates expiry year dropdown to the current year + next 10 years.
        let currentYear = new Date().getFullYear();
        for (i = currentYear; i <= currentYear + 10; i++) {
            $('#cardExpiryYear').append(
                    `<option value="${i}">${i}</option>`);
        }
    };

    updateCardExpiryYearDropdown();

    $(document).ready(function () {
        $(document).on('click', '#editCardBtn', function () {

            var cardId = $(this).attr('data-id');
            console.log('Card id is:', cardId);
            // AJAX request
            $.ajax({
                url: './helpers/get_card_info.php', // URL of your PHP script to fetch hall info
                method: 'GET',
                data: {cardId: cardId},
                dataType: 'json', // Expected data type from server
                success: function (response) {
                    // Handle successful response
                    console.log('Card Info:', response);

                    // Update form inputs with fetched data
                    $('#cardholdernameInput').val(response.cardholderName);
                    $('#cardNumberInput').val(response.cardNumber);
                    $('#CVVInput').val(response.CVV);
                    const expiryDate = response.expiryDate.split("-");
                    console.log(parseInt(expiryDate[1]));
                    $('#cardExpiryYear').val(expiryDate[0]);
                    $('#cardExpiryMonth').val(parseInt(expiryDate[1]));
//                    $('#cardExpiryMonth').val(expiryDate[1]);
                    $('#Add-CardID').val(response.cardId);
                },
                error: function (xhr, status, error) {
                    // Handle errors
                    console.error('Error fetching card info:', error);
                }
            });
        });
    });

    $(document).ready(function () {
        $(document).on('click', '#editAddressBtn', function () {

            var addressId = $(this).attr('data-id');
            console.log('Address id is:', addressId);
            // AJAX request
            $.ajax({
                url: './helpers/get_address_info.php',
                method: 'GET',
                data: {addressId: addressId},
                dataType: 'json', // Expected data type from server
                success: function (response) {
                    // Handle successful response
                    console.log('address Info:', response);

                    // Update form inputs with fetched data
                    $('#bldgNumberInput').val(response.buildingNumber);
                    $('#streetNumberInput').val(response.streetNumber);
                    $('#blockInput').val(response.blockNumber);
                    $('#areaInput').val(response.area);
                    $('#countryInput').val(response.country);
                    $('#phoneNumberInput').val(response.phoneNumber);
                    $('#Add-AddressID').val(response.addressId);
                },
                error: function (xhr, status, error) {
                    // Handle errors
                    console.error('Error fetching address info:', error);
                }
            });
        });
    });


    function getCookie(cname) {
        let name = cname + "=";
        let decodedCookie = decodeURIComponent(document.cookie);
        let ca = decodedCookie.split(';');
        for (let i = 0; i < ca.length; i++) {
            let c = ca[i];
            while (c.charAt(0) == ' ') {
                c = c.substring(1);
            }
            if (c.indexOf(name) == 0) {
                return c.substring(name.length, c.length);
            }
        }
        return "";
    }

    $(function () {
        $.ajax({
            url: './helpers/get_client_status.php',
            method: 'GET',
            data: {clientId: getCookie('clientId')},
            dataType: 'json', // Expected data type from server
            success: function (response) {
                // Handle successful response
                console.log('status Info:', response);

                // Update class list
                const statusDiv = $(".my-status");
                const statusText = $("#statusName");
                const nextStatus = $("#nextStatus");
                const numberOfReservations = parseInt(response.numberOfReservations);

                switch (response.status) {
                    case 'Gold':
                        nextStatus.html("You are at the highest tier");
                        statusDiv.addClass('gold');
                        break;
                    case 'Silver':
                        nextStatus.html(15 - numberOfReservations + " until Gold Tier");
                        statusDiv.addClass('silver');
                        break;
                    case 'Bronze':
                        nextStatus.html(10 - numberOfReservations + " until Silver Tier");
                        statusDiv.addClass('bronze');
                        break;
                    default:
                        nextStatus.html(5 - numberOfReservations + " until Bronze Tier");
                        statusDiv.addClass('nothing');
                        statusText.addClass('text-black');
                        nextStatus.addClass('text-black');
                        statusText.removeClass('text-white');
                        nextStatus.removeClass('text-white');
                }



            },
            error: function (xhr, status, error) {
                // Handle errors
                console.error('Error fetching address info:', error);
            }
        });
    });

    $(function () {
        $.ajax({
            url: './helpers/get_card_count.php',
            method: 'GET',
            data: {clientId: getCookie('clientId')},
            dataType: 'text', // Expected data type from server
            success: function (response) {
                // Handle successful response
                console.log('cardCount Info:', response);

                // if there is 4 cards don't allow them to add more cards
                if (response >= 4) {
                    $("#btnAddCard").attr("data-bs-target", "#noMoreCardModal");
                }

            },
            error: function (xhr, status, error) {
                // Handle errors
                console.error('Error fetching card info:', error);
            }
        });
    });

    $(function () {
        $.ajax({
            url: './helpers/get_address_count.php',
            method: 'GET',
            data: {clientId: getCookie('clientId')},
            dataType: 'text', // Expected data type from server
            success: function (response) {
                // Handle successful response
                console.log('address Info:', response);

                // if there is 4 cards don't allow them to add more cards
                if (response >= 4) {
                    $("#btnAddAddress").attr("data-bs-target", "#noMoreAddressModal");
                }

            },
            error: function (xhr, status, error) {
                // Handle errors
                console.error('Error fetching Address info:', error);
            }
        });
    });

    $('#btnAddCard').click(function () {
        // Clear form Input fields when closing the form
        $('#Add-CardID').removeAttr('value');
    });

    $('#btnAddAddress').click(function () {
        // Clear form Input fields when closing the form
        $('#Add-AddressID').removeAttr('value');
    });

    $('#card-add-form').submit(function (e) {
        var cardNumber = $('#cardNumberInput').val();
        var cardholderName = $('#cardholdernameInput').val();
        var CVV = $('#CVVInput').val();
//        var expirydate = $('#imageUpload');
        var numberOnlyRegex = /^[0-9]+(\.[0-9]+)?$/;
        
        if (cardNumber === '' || cardholderName === '' || CVV === '' ||!numberOnlyRegex.test(cardNumber)
                || cardholderName.length < 3 || cvv.length !== 3 || cardNumber.length !== 16) {
            $(this).addClass('was-validated');
            e.preventDefault();
            return false;
        }

        return true;
    });

    $('#address-add-form').submit(function (e) {
        var bldgNumber = $('#bldgNumberInput').val();
        var streetNumber = $('#streetNumberInput').val();
        var blockNumber = $('#blockInput').val();
        var area = $('#areaInput').val();
        var country = $('#countryInput').val();
        var phoneNumber = $('#phoneNumberInput').val();
//        var expirydate = $('#imageUpload');

        if (bldgNumber === '' || streetNumber === '' || blockNumber === '' || area === '' || country === '' || phoneNumber === ''
                || bldgNumber.length < 3 || blockNumber.length < 3 || area.length < 3 || country.length < 3 || phoneNumber.length < 8) {
            $(this).addClass('was-validated');
            e.preventDefault();
            return false;
        }
        return true;
    });

    $('#editCardModal').on('hidden.bs.modal', function (e) {
        // Clear form Input fields when closing the form
        $('.form-control').val('');
        $('.form-select').val('');
        $('#card-add-form').removeClass('was-validated');
    });

    $('#editAddressModal').on('hidden.bs.modal', function (e) {
        // Clear form Input fields when closing the form
        $('.form-control').val('');
        $('#address-add-form').removeClass('was-validated');
    });

</script>
</body>
