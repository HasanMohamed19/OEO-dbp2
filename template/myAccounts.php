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
                                    <strong>Profile</strong>
                                    <i class="fa-solid fa-arrow-right"></i>
                                </button>
                                <button type="button" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                    <strong>Address Book</strong>
                                    <i class="fa-solid fa-arrow-right"></i>
                                </button>
                                <button type="button" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                    <strong>Logout</strong>
                                </button>
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
                        <div class="row justify-content-between mx-3 mt-2">
                            <div class="col">Booking#: ME1193655626</div>
                            <div class="col text-secondary text-center">7 July, 2028</div>
                            <div class="col text-end">Total: BHD 1700.16</div>
                        </div>
                        <hr>
                        <div class="card mb-2 border-0 mx-3">
                            <div class="row g-0">
                                <div class="col-xl-5 p-2">
                                    <img src="https://placehold.co/550x400" alt="" class="img-fluid rounded">
                                </div>

                                <div class="col-xl-5 p-2 flex-grow-1">
                                    <div class="row m-2">
                                        <div class="col text-start completed">Completed</div>
                                        <div class="col text-end"><button class="btn btn-danger">Cancel Booking</button></div>
                                </div>
                                    <div class="row m-2">
                                        <span class="col text-start text-secondary">Hall Name: </span>
                                        <span class="col text-start">Hall Name</span>
                                    </div>
                                    <div class="row m-2">
                                        <span class="col text-start text-secondary">Event Name: </span>
                                        <span class="col text-start">Event Name</span>
                                    </div>
                                    <div class="row m-2">
                                        <span class="col text-start text-secondary">Start Date: </span>
                                        <span class="col text-start">Jab 1, 2026</span>
                                    </div>
                                    <div class="row m-2">
                                        <span class="col text-start text-secondary">End Date: </span>
                                        <span class="col text-start">Jan1, 2026</span>
                                    </div>
                                    <div class="row m-2">
                                        <span class="col text-start text-secondary">Daily Start Time: </span>
                                        <span class="col text-start">9:00 AM</span>
                                    </div>
                                    <div class="row m-2">
                                        <span class="col text-start text-secondary">Daily End Time: </span>
                                        <span class="col text-start">7:00 PM</span>
                                    </div>
                                    <div class="row m-2">
                                        <span class="col text-start text-secondary">No, Audiences </span>
                                        <span class="col text-start">100</span>
                                    </div>
                                </div>
                            </div>
                            <div class="row mx-1">
                                <span class="text-secondary">Notes: </span>
                                <p class="justify">Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolores exercitationem nulla earum dolorem dignissimos quos quisquam dolorum voluptatibus? Minima perferendis aliquid saepe, quod voluptatibus suscipit laudantium optio nisi ea dolorum sit culpa voluptatum sint enim amet dolores.
                                    Veritatis odio a dolorem id, dolor, unde consequatur exercitationem cum distinctio magnam dolores.</p>
                            </div>

                            <div class="row mx-1">
                                <div class="accordion">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#additionalServiceCollapse" aria-expanded="true" aria-controls="collapseOne">
                                                <span class="fs-3">Additional Services</span>
                                            </button>
                                        </h2>
                                        <div id="additionalServiceCollapse" class="accordion-collapse collapse show">
                                            <div class="accordion-body d-flex flex-wrap">

                                                <div class="card p-0 m-2 cateringItem">
                                                    <img class="card-img-top img-fluid" src="https://placehold.co/278x156">
                                                    <div class="card-body">
                                                        <h3 class="card-title text-center fs-5">Menu Item Name</h3>
                                                        <p class="card-text text-center"><strong>0.6 BHD x 0.5 BHD</strong></p>
                                                    </div>
                                                </div>

                                                <div class="card p-0 m-2 cateringItem">
                                                    <img class="card-img-top img-fluid" src="https://placehold.co/278x156">
                                                    <div class="card-body">
                                                        <h3 class="card-title text-center fs-5">Menu Item Name</h3>
                                                        <p class="card-text text-center"><strong>0.6 BHD x 0.5 BHD</strong></p>
                                                    </div>
                                                </div>

                                                <div class="card p-0 m-2 cateringItem">
                                                    <img class="card-img-top img-fluid" src="https://placehold.co/278x156">
                                                    <div class="card-body">
                                                        <h3 class="card-title text-center fs-5">Menu Item Name</h3>
                                                        <p class="card-text text-center"><strong>0.6 BHD x 0.5 BHD</strong></p>
                                                    </div>
                                                </div>

                                                <div class="card p-0 m-2 cateringItem">
                                                    <img class="card-img-top img-fluid" src="https://placehold.co/278x156">
                                                    <div class="card-body">
                                                        <h3 class="card-title text-center fs-5">Menu Item Name</h3>
                                                        <p class="card-text text-center"><strong>0.6 BHD x 0.5 BHD</strong></p>
                                                    </div>
                                                </div>

                                                <div class="card p-0 m-2 cateringItem">
                                                    <img class="card-img-top img-fluid" src="https://placehold.co/278x156">
                                                    <div class="card-body">
                                                        <h3 class="card-title text-center fs-5">Menu Item Name</h3>
                                                        <p class="card-text text-center"><strong>0.6 BHD x 0.5 BHD</strong></p>
                                                    </div>
                                                </div>

                                                <div class="card p-0 m-2 cateringItem">
                                                    <img class="card-img-top img-fluid" src="https://placehold.co/278x156">
                                                    <div class="card-body">
                                                        <h3 class="card-title text-center fs-5">Menu Item Name</h3>
                                                        <p class="card-text text-center"><strong>0.6 BHD x 0.5 BHD</strong></p>
                                                    </div>
                                                </div>

                                                <div class="card p-0 m-2 cateringItem">
                                                    <img class="card-img-top img-fluid" src="https://placehold.co/278x156">
                                                    <div class="card-body">
                                                        <h3 class="card-title text-center fs-5">Menu Item Name</h3>
                                                        <p class="card-text text-center"><strong>0.6 BHD x 0.5 BHD</strong></p>
                                                    </div>
                                                </div>

                                                <div class="card p-0 m-2 cateringItem">
                                                    <img class="card-img-top img-fluid" src="https://placehold.co/278x156">
                                                    <div class="card-body">
                                                        <h3 class="card-title text-center fs-5">Menu Item Name</h3>
                                                        <p class="card-text text-center"><strong>0.6 BHD x 0.5 BHD</strong></p>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

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
                            $card->setClientId('1');
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

                                            <!-- year and month can be datepicker formatted with js -->

                                            <div class="col form-group required">
                                                <label for="year" class="form-label">Card Expiry</label>
                                                <select name="year" id="year" class="form-select">
                                                    <option value="" disabled>Year</option>
                                                    <option value="1">1</option>
                                                </select>
                                            </div>

                                            <div class="col d-flex align-items-end form-group required">
                                                <select name="month" id="month" class="form-select">
                                                    <option value="" disabled>Month</option>
                                                    <option value="1">January</option>
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
                    <!-- end of my cards -->

                    <!-- Wallet & Royalty Points -->
                    <div class="card mb-2 ms-4 px-0 inactive">
                        <div class="card-header">
                            <h3>Wallet & Royalty Points</h3>
                        </div>

                        <div class="row my-status align-self-center my-2">
                            <h1 class="text-uppercase text-center text-white align-self-center">Silver</h1>
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
                            $p->setClientId('1');
                            $p->initWithClientId();
                            
                            $c = new CompanyDetails();
                            $c->setClientId('1');
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
                                        <input type="text" name="firstname" class="form-control" value="<?php echo $p->getFirstName();?>" placeholder="First Name">
                                    </div>
                                    <div class="col">
                                        <label for="lastname" class="form-label">Last Name</label>
                                        <input type="text" name="lastname" class="form-control" value="<?php echo $p->getLastName();?>" placeholder="Last Name">
                                    </div>
                                </div>
                                <div class="row my-2">
                                    <div class="col">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" name="email" class="form-control" value="<?php echo 'email should go here' ?>" placeholder="Email">
                                    </div>
                                    <div class="col">
                                        <label for="nationality" class="form-label">Nationality</label>
                                        <input type="text" name="nationality" class="form-control" placeholder="Nationality" value="<?php echo $p->getNationality();?>">
                                    </div>
                                </div>
                                <div class="row my-2">
                                    <div class="col">
                                        <label for="dob" class="form-label">DOB</label>
                                        <input type="date" name="dob" class="form-control" placeholder="DOB" value="<?php echo $p->getDob();?>">
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
                                        <input type="text" name="companyname" class="form-control" placeholder="Company Name" value="<?php echo $c->getName();?>">
                                    </div>
                                    <div class="col">
                                        <label for="companysize" class="form-label">Company Size</label>
                                        <input type="number" name="companysize" class="form-control" placeholder="Company Size" value="<?php echo $c->getComapnySize();?>">
                                    </div>
                                </div>

                                <div class="row my-2">
                                    <div class="col">
                                        <label for="city" class="form-label">City</label>
                                        <input type="text" name="city" class="form-control" placeholder="City" value="<?php echo $c->getCity();?>">
                                    </div>
                                    <div class="col">
                                        <label for="website" class="form-label">Website</label>
                                        <input type="text" name="website" class="form-control" placeholder="Website" value="<?php echo $c->getWebsite();?>">
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
                    
                    <!-- book address -->
                    <div class="card col shadow-sm ms-4 px-0 inactive">
                        <div class="card-header">
                            <h3>My Cards</h3>
                        </div>
                        
                        <?php
                            echo 'book address section';
//                            $card = new CardDetail();
//                            $card->setClientId('1');
//                            $cards = $card->getAllCardsForUser();
//                            $card->displayCards($cards);
                        ?>
                        
<!--                        

-->                     <div class="row mx-auto mb-2" style="width: 15%;">
                            <button id="btnAddAddress" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editAddressModal"> +Add </button>
                        </div>

                    </div>


                    <!-- My Cards Modal -->
                    <div class="modal fade" id="editAddressModal">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Address Detail</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form id="card-add-form" novalidate action="displayMyAccount.php" method="post">
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
                                                <input type="number" id="blockInput" class="form-control" name="block" value="" required>
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
                                                <label for="phoneNumber" class="form-label">Phone Nubmer</label>
                                                <input type="number" id="phoneNumberInput" class="form-control" name="phoneNumber" value="" required>
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
                    <!-- end of book address -->

                </div>

            </div>

        </div>
    
    <script src="./helpers/myAccount.js"></script>
    <script src="./helpers/AdminForms.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
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
                    $('#cardholdernameInput').val(response.cardHolderName);
                    $('#cardNumberInput').val(response.cardNumber);
                    $('#CVVInput').val(response.CVV);
//                    $('#expiryDate').val(response.description);
                    $('#Add-CardID').val(response.cardId);
                },
                error: function (xhr, status, error) {
                    // Handle errors
                    console.error('Error fetching card info:', error);
                }
            });
        });
    });
    
    $('#btnAddCard').click(function () {
        // Clear form Input fields when closing the form
        $('#Add-CardID').removeAttr('value');
    });
    
    $('#card-add-form').submit(function(e) {
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
    </script>
</body>