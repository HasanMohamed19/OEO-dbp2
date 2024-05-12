<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Other/html.html to edit this template
-->
<body>
    <div class="container">
        <br>
        <div class="row">
            <h1>Browse Clients</h1>
        </div>
        <div class="row">
            <div class="col-xl-10">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Search For a Client" id="search">
                    <button class="btn btn-outline-secondary" type="button" id="searchBtn">
                        <i>Search</i>
                    </button>
                </div>
            </div>
            <div class="col-xl-2 text-end">
                <button id="addClientBtn" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">+ New Client</button>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-2">
                <!-- Pagination bar -->
                <nav class="mb-3 d-flex justify-content-center align-items-center" aria-label="Menu Page Navigation">
                    <span class="me-2">Page: </span>
                    <ul class="pagination d-flex flex-row m-0">
                        <li class="page-item"><input type="button" class="pagination-first-clients page-link mx-2 rounded border-2" value="First"></li>
                    </ul>
                    <ul class="pagination pagination-numbers-clients d-flex flex-row m-0">
                    </ul>
                    <ul class="pagination d-flex flex-row m-0">
                        <li class="page-item"><input type="button" class="pagination-last-clients page-link mx-2 rounded border-2" value="Last"></li>
                    </ul>
                </nav>
            </div>
        </div>
        <br>
        <div id="pagination-items-clients">

        </div>

        <br>
        <!-- The Modal -->
        <div class="modal" id="addModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Add/Edit Client</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <!-- Modal body -->
                    <div class="modal-body">
                        <form action="/ManageHalls.php" id ="clientForm">
                            <h5>Personal Details:</h5>
                            <hr>
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" class="form-control" id="username" placeholder="Enter Username" name="username">
                            </div>
                            <div class="mb-3" id="passwordDiv">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" placeholder="Enter Password" name="password">
                            </div>
                            <div class="mb-3">
                                <label for="fName" class="form-label">First Name</label>
                                <input type="text" class="form-control" id="fName" placeholder="Enter First Name" name="fName">
                            </div>
                            <div class="mb-3">
                                <label for="lName" class="form-label">Last Name</label>
                                <input type="text" class="form-control" id="lName" placeholder="Enter Last Name" name="lName">
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="text" class="form-control" id="email" placeholder="Enter Email" name="email">
                            </div>
                            <div class="mb-3">
                                <label for="phoneNum" class="form-label">Phone Number</label>
                                <input type="number" class="form-control" id="phoneNum" placeholder="Enter Phone Number" name="phoneNum">
                            </div>
                            <div class="mb-3">
                                <label for="nation" class="form-label">Nationality</label>
                                <input type="text" class="form-control" id="nation" placeholder="Enter Nationality" name="nation">
                            </div>
                            <div class="mb-3">
                                <label for="dob" class="form-label">Date Of Birth</label>
                                <input type="date" class="form-control" id="dob" placeholder="Enter Date of Birth" name="dob">
                            </div>
                            <br>
                            <h5>Company Details:</h5>
                            <hr>
                            <div class="mb-3">
                                <label for="cmpName" class="form-label">Company Name</label>
                                <input type="text" class="form-control" id="cmpName" placeholder="Enter Company Name" name="cmpName">
                            </div>
                            <div class="mb-3">
                                <label for="cmpSize" class="form-label">Company Size</label>
                                <input type="number" class="form-control" id="cmpSize" placeholder="Enter Company Size" name="cmpSize">
                            </div>
                            <div class="mb-3">
                                <label for="cmpWeb" class="form-label">Company Website</label>
                                <input type="text" class="form-control" id="cmpWeb" placeholder="Enter Company Website" name="cmpWeb">
                            </div>
                            <div class="mb-3">
                                <label for="cmpcity" class="form-label">Company City</label>
                                <input type="text" class="form-control" id="cmpcity" placeholder="Enter Company City" name="cmpcity">
                            </div>
                            <div class="row">
                                <div class="col text-start">
                                    <button class="btn btn-danger" data-bs-dismiss="modal" type="button">Cancel</button>
                                </div>
                                <div class="col text-end">
                                    <button class="btn btn-primary" data-bs-dismiss="modal" type="button">Save</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="./helpers/pagination.js"></script>
    <script src="./helpers/AdminForms.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</body>

<script type="text/javascript">

    window.addEventListener("load", () => {
        enablePagination("clients", ".clientCard");
    });

    $(document).ready(function () {
        $("#addClientBtn").click(function () {
            $("#passwordDiv").removeAttr('hidden');

        });

        $("#editClientBtn").click(function () {
            $("#passwordDiv").attr('hidden', '');
        });
    });

    //get Hall ID value 
    $(document).ready(function () {
        $(document).on('click', '#editHallBtn', function () {

            var hallId = $(this).attr('data-id');
            console.log('Hall id is:', hallId);
            // AJAX request
            $.ajax({
                url: './helpers/get_hall_info.php', // URL of your PHP script to fetch hall info
                method: 'GET',
                data: {hallId: hallId}, // Send hallId to server
                dataType: 'json', // Expected data type from server
                success: function (response) {
                    // Handle successful response
                    console.log('Hall Info:', response);
                    //remove image upload validation
                    $('#hallImg').removeAttr('required');
                    $('#imageUpload').removeAttr('required');
                    $('#imageUploadLabel:after').remove();
                    // Update form inputs with fetched data
                    $('#hallNameInput').val(response.hallName);
                    $('#RntlchargeInput').val(response.rentalCharge);
                    $('#CapacityInput').val(response.capacity);
                    $('#descriptionInput').val(response.description);
                    $('#imagePath').val(response.imagePath);
                    $('#Add-HallID').val(response.hallId);
                },
                error: function (xhr, status, error) {
                    // Handle errors
                    console.error('Error fetching hall info:', error);
                }
            });
        });
    });

    $('#addModal').on('hidden.bs.modal', function (e) {
        // Clear form Input fields when closing the form
        $('.form-control').val('');
        $('#add-form').removeClass('was-validated');
        console.log('Modal dismissed');
    });
    $('#addHallBtn').click(function () {
        $('#hallImg').attr('required', '');
        $('#imageUpload').attr('required', '');
        $('#Add-HallID').removeAttr('value');
        $('#imageUploadLabel:after').add();
    });

    $('#add-form').submit(function (e) {
        // Get form inputs
        var Hallname = $('#hallNameInput').val();
        var rntlCharge = $('#RntlchargeInput').val();
        var capacity = $('#CapacityInput').val();
        var imageUpload = $('#imageUpload');

        // Check if any field is empty or image is not uploaded
        if ((imageUpload.prop('required') && imageUpload[0].files.length === 0) || Hallname === '' || rntlCharge == '' || capacity == '') {
            $(this).addClass('was-validated');
            e.preventDefault(); // Prevent form submission
            return false;
        }
        // If all checks pass, allow form submission
        return true;
    });


</script>

<?php

function displayClients($dataSet) {
    echo '            <div class="card clientCard">
                <div class="card-body p-0">
                    <div class="row ">
                        <div class="col-xl-11">
                            <br>
                            <div class="col text-center " >
                                <span class="fw-bold display-6">@FatimaM_04</span>
                                <span class="badge bg-warning">Gold</span>
                                <br>
                                <span class="fw-bold">#88R324U-93</span>
                                <br><br>
                            </div>
                            <div class="row">
                                <div class="col-xl-5">
                                    <dl class="row d-flex justify-content-center align-items-center">
                                        <dt class="col-xl-5">Full Name:</dt>
                                        <dd class="col-xl-5">Fatima Mahfoodh</dd>

                                        <dt class="col-xl-5">Email:</dt>
                                        <dd class="col-xl-5">Fatima@gmail.com</dd>

                                        <dt class="col-xl-5">DOB:</dt>
                                        <dd class="col-xl-5">23-4-24 </dd>

                                        <dt class="col-xl-5">Nationality:</dt>
                                        <dd class="col-xl-5">Bahrain</dd>

                                        <dt class="col-xl-5">Phone Number:</dt>
                                        <dd class="col-xl-5">333333333</dd>
                                    </dl>  
                                </div>
                                <div class="col-xl-6">
                                    <dl class="row d-flex justify-content-center align-items-center">
                                        <dt class="col-xl-5">Company Name:</dt>
                                        <dd class="col-xl-5">Bahrain Polytechnic</dd>

                                        <dt class="col-xl-5">Size:</dt>
                                        <dd class="col-xl-5">500</dd>

                                        <dt class="col-xl-5">Webiste:</dt>
                                        <dd class="col-xl-5">polytechnic.bh</dd>

                                        <dt class="col-xl-5">City:</dt>
                                        <dd class="col-xl-5">Manama, Bahrain</dd>
                                    </dl>    

                                </div>  
                            </div>

                        </div>
                        <div class="col-xl-1">
                            <div class="d-flex flex-column h-100 justify-content-between">
                                <button id="editClientBtn" class="btn btn-primary flex-fill rounded-0 rounded-top-right" data-bs-toggle="modal" data-bs-target="#addModal" >Edit</button>
                                <button class="btn btn-danger flex-fill rounded-0 rounded-bottom-right">Delete</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>';
}
