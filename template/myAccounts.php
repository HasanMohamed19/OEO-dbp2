<?php
    $loggedInClientId = $_COOKIE['clientId'];
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
                            <button type="button" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                <strong>Wallet</strong>
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

                    <div class="table-responsive mx-4 px-0 mt-3">
                        <table class="table table-striped border">
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
                                    $reservation = new Reservation();
                                    $reservation->setClientId($loggedInClientId);
                                    $reservations = $reservation->getReservationsForClient();
                                    $reservation->displayClientReservations($reservations);
                                ?>
                            </tbody>

                        </table>
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
                    $card->displayCards($cards);
                    ?>

                    <!--                        
                    
                    -->                     <div class="row mx-auto mb-2" style="width: 15%;">
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
                                            <input type="text" name="cardholdername" id="cardholdernameInput" class="form-control" required/>
                                        </div>
                                        <div class="col form-group required">
                                            <label for="cardNumber" class="form-label">Card Number</label>
                                            <input type="text" id="cardNumberInput" class="form-control" name="cardNumber" required>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col form-group required">
                                            <label for="CVV" class="form-label">CVV</label>
                                            <input type="number" id="CVVInput" class="form-control" name="CVV" value="" required>
                                        </div>

                                        <div class="col form-group required">
                                            <label for="cardExpiryYear" class="form-label">Card Expiry</label>
                                            <select name="cardExpiryYear" id="cardExpiryYear" class="form-select">
                                                <option disabled selected>Year</option>
                                            </select>
                                        </div>

                                        <div class="col d-flex align-items-end form-group required">
                                            <select name="cardExpiryMonth" id="cardExpiryMonth" class="form-select">
                                                <option selected disabled>Month</option>
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

                <!-- Wallet & Royalty Points -->
                
                <?php
//                            include 'debugging.php';
//                        include './models/Client.php';
                            $cc = new Client();
//                            $client->setClientId('1');
                            $s = $cc->getClientStatusName($loggedInClientId);
                            $db = Database::getInstance();
//                            $n = $db->querySQL('SELECT getNumberOfBookings(1)');
//                            var_dump($db->querySQL('CALL getNumberOfBookings(1)'));
//                            echo $n . ' is what??';
//                            var_dump($s);
//                            echo $s->status_name . ' is the status';
                ?>
                
                <div class="card mb-2 ms-4 px-0 inactive">
                    <div class="card-header">
                        <h3>Wallet & Royalty Points</h3>
                    </div>

                    <div class="row my-status align-self-center my-2">
                        
                        <h1 class="text-uppercase text-center text-white align-self-center"><?php echo $s->status_name ?></h1>
                        <p class="text-white text-center align-self-center">3 Bookings to GOLD</p>
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
                <!-- end of Wallet & Royalty Points -->

                <!--Profile -->
                <div class="card col shadow-sm ms-4 px-0 inactive">
                    <div class="card-header">
                        <h3>Profile</h3>
                    </div>
                    <div class="row mx-3">
                        <h6>Personal Information</h6>
                    </div>

                    <?php
                    $p = new PersonalDetails();
                    $p->setClientId($loggedInClientId);
                    $p->initWithClientId();

                    $c = new CompanyDetails();
                    $c->setClientId($loggedInClientId);
                    $c->initWithClientId();
//                            echo $p->getFirstName() . " sdds";
                    ?>

                    <form action="displayMyAccount.php" method="post">
                        <div class="container">
                            <div class="row my-2">
                                <div class="col">
                                    <label for="username" class="form-label">Username</label>
                                    <input type="text" name="username" class="form-control" placeholder="Username" value="">
                                </div>
                                <div class="col">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" name="password" class="form-control" placeholder="Password">
                                </div>
                            </div>
                            <div class="row my-2">
                                <div class="col">
                                    <label for="firstname" class="form-label">First Name</label>
                                    <input type="text" name="firstname" class="form-control" value="<?php echo $p->getFirstName(); ?>" placeholder="First Name">
                                </div>
                                <div class="col">
                                    <label for="lastname" class="form-label">Last Name</label>
                                    <input type="text" name="lastname" class="form-control" value="<?php echo $p->getLastName(); ?>" placeholder="Last Name">
                                </div>
                            </div>
                            <div class="row my-2">
                                <div class="col">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" name="email" class="form-control" value="<?php echo 'email should go here' ?>" placeholder="Email">
                                </div>
                                <div class="col">
                                    <label for="nationality" class="form-label">Nationality</label>
                                    <input type="text" name="nationality" class="form-control" placeholder="Nationality" value="<?php echo $p->getNationality(); ?>">
                                </div>
                            </div>
                            <div class="row my-2">
                                <div class="col">
                                    <label for="dob" class="form-label">DOB</label>
                                    <input type="date" name="dob" class="form-control" placeholder="DOB" value="<?php echo $p->getDob(); ?>">
                                </div>
                                <div class="col">
                                    <label for="gender" class="form-label">Gender</label>
                                    <select name="gender" class="form-select" id="n">
                                        <option value="" disabled>Gender</option>
                                        <option value="M" <?php if ($p->getGender() == 'M') echo 'selected'; ?> >Male</option>
                                        <option value="F" <?php if ($p->getGender() == 'F') echo 'selected'; ?> >Female</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!-- </form> -->

                        <hr>
                        <div class="row mx-3">
                            <h6>Company Information</h6>
                        </div>
                        <!-- <form action=""> -->
                        <div class="container">
                            <div class="row my-2">
                                <div class="col">
                                    <label for="companyname" class="form-label">Company Name</label>
                                    <input type="text" name="companyname" class="form-control" placeholder="Company Name" value="<?php echo $c->getName(); ?>">
                                </div>
                                <div class="col">
                                    <label for="companysize" class="form-label">Company Size</label>
                                    <input type="number" name="companysize" class="form-control" placeholder="Company Size" value="<?php echo $c->getComapnySize(); ?>">
                                </div>
                            </div>

                            <div class="row my-2">
                                <div class="col">
                                    <label for="city" class="form-label">City</label>
                                    <input type="text" name="city" class="form-control" placeholder="City" value="<?php echo $c->getCity(); ?>">
                                </div>
                                <div class="col">
                                    <label for="website" class="form-label">Website</label>
                                    <input type="text" name="website" class="form-control" placeholder="Website" value="<?php echo $c->getWebsite(); ?>">
                                </div>
                            </div>

                            <div class="row my-2">
                                <button type="submit" class="btn btn-primary mx-auto" style="width: 40%;">Save</button>
                                <input type="hidden" name="profileSubmitted" value="1">
                            </div>

                        </div>
                    </form>

                </div>
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
                                    <input type="text" name="username" class="form-control" placeholder="Username" value="<?php echo $user->getUsername(); ?>">
                                </div>
                                <div class="col form-group required">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" name="email" class="form-control" placeholder="Email" value="<?php echo $user->getEmail(); ?>">
                                </div>
                            </div>
                            <div class="row my-2 form-group required">
                                <div class="col">
                                    <label for="phoneNumber" class="form-label">Phone Number</label>
                                    <input type="text" name="phoneNumber" class="form-control" placeholder="Phone Number" value="<?php echo $client->getPhoneNumber(); ?>">
                                </div>
                                <div class="col form-group required">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" name="password" class="form-control" placeholder="Password">
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
$address->displayAddresses($addresses);
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
                                        <input type="text" name="bldgNumber" id="bldgNumberInput" class="form-control" required/>
                                    </div>
                                    <div class="col form-group required">
                                        <label for="streetNumber" class="form-label">Street Number</label>
                                        <input type="text" id="streetNumberInput" class="form-control" name="streetNumber" required>
                                    </div>
                                    <div class="col form-group required">
                                        <label for="block" class="form-label">Block</label>
                                        <input type="text" id="blockInput" class="form-control" name="block" value="" required>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col form-group required">
                                        <label for="area" class="form-label">Area</label>
                                        <input type="text" id="areaInput" class="form-control" name="area" value="" required>
                                    </div>
                                    <div class="col form-group required">
                                        <label for="country" class="form-label">Country</label>
                                        <input type="text" id="countryInput" class="form-control" name="country" value="" required>
                                    </div>
                                    <div class="col form-group required">
                                        <label for="phoneNumber" class="form-label">Phone Number</label>
                                        <input type="text" id="phoneNumberInput" class="form-control" name="phoneNumber" value="" required>
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
                            Are You sure You want to delete this Card?
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

        </div>

    </div>

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

        if (cardNumber === '' || cardholderName === '' || CVV === '') {
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

        if (bldgNumber === '' || streetNumber === '' || blockNumber === '' || area === '' || country === '' || phoneNumber === '') {
            $(this).addClass('was-validated');
            e.preventDefault();
            return false;
        }
        return true;
    });
</script>
</body>