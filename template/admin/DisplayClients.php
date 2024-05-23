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
            <div class="col-xl-12 text-end">
                <button id="addClientBtn" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">+ New Client</button>
            </div>
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
                        <form action="Admin_ViewClients.php" id ="add-form" novalidate method="POST" enctype="multipart/form-data">
                            <div class="mb-3 form-group required">
                                <label for="username" class="form-label">Username</label>
                                <input type="text"  maxlength="20" class="form-control userInputs" id="usrName" placeholder="Enter Username" name="usrName" required>
                            </div>
                            <div class="mb-3 form-group required" id="passwordDiv" hidden>
                                <label for="password" class="form-label">Password</label>
                                <input type="password" maxlength="30" class="form-control userInputs" id="pwd" placeholder="Enter Password" name="pwd" required>
                            </div>
                            <div class="mb-3 form-group required">
                                <label for="email" class="form-label">Email</label>
                                <input type="text" maxlength="50" class="form-control userInputs" id="email" placeholder="Enter Email" name="email" required>
                            </div>
                            <div class="mb-3 form-group required">
                                <label for="phoneNum" class="form-label">Phone Number</label>
                                <input type="text" maxlength="25" class="form-control userInputs" id="phoneNum" placeholder="Enter Phone Number" name="phoneNumber" required>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="pdCheckBx" name="pdCheckBx">
                                <label class="form-check-label" for="flexCheckDefault">
                                    <h5>Personal Details:</h5> <em><small>(Check the box if you want to add personal details)</small></em>
                                </label>
                            </div>
                            <hr>

                            <div class="mb-3">
                                <label for="fName" class="form-label">First Name</label>
                                <input type="text" maxlength="50" class="form-control pdInputs" id="fName" placeholder="Enter First Name" name="fName">
                            </div>
                            <div class="mb-3">
                                <label for="lName" class="form-label">Last Name</label>
                                <input type="text" maxlength="50" class="form-control pdInputs" id="lName" placeholder="Enter Last Name" name="lName">
                            </div>
                            <div class="mb-3">
                                <label for="gender" class="form-label">Gender</label>
                                <select name="gender" class="form-select pdInputs" id="gender">
                                    <option value="" selected>Select Gender</option>
                                    <option value="M">Male</option>
                                    <option value="F" >Female</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="nation" class="form-label">Nationality</label>
                                <input type="text" maxlength="20" class="form-control pdInputs" id="nation" placeholder="Enter Nationality" name="nation">
                            </div>
                            <div class="mb-3">
                                <label for="dob" class="form-label">Date Of Birth</label>
                                <input type="date" class="form-control pdInputs" id="dob" placeholder="Enter Date of Birth" name="dob">
                            </div>
                            <br>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="cmpCheckBx" name="cmpCheckBx">
                                <label class="form-check-label" for="flexCheckDefault">
                                    <h5>Company Details:</h5><em><small>(Check the box if you want to add company details)</small></em>
                                </label>
                            </div>
                            <hr>
                            <div class="mb-3">
                                <label for="cmpName" class="form-label">Company Name</label>
                                <input type="text" maxlength="50" class="form-control cmpInputs" id="cmpName" placeholder="Enter Company Name" name="cmpName">
                            </div>
                            <div class="mb-3">
                                <label for="cmpSize" class="form-label">Company Size</label>
                                <input type="number" max="99999999999" class="form-control cmpInputs" id="cmpSize" placeholder="Enter Company Size" name="cmpSize">
                            </div>
                            <div class="mb-3">
                                <label for="cmpWeb" class="form-label">Company Website</label>
                                <input type="text" maxlength="50" class="form-control cmpInputs" id="cmpWeb" placeholder="Enter Company Website" name="cmpWeb">
                            </div>
                            <div class="mb-3">
                                <label for="cmpcity" class="form-label">Company City</label>
                                <input type="text" maxlength="50" class="form-control cmpInputs" id="cmpcity" placeholder="Enter Company City" name="cmpcity">
                            </div>
                            <em id="chckboxerror" class="text-center text-danger mb-3"></em>
                            <div class="row">
                                <div class="col text-start">
                                    <button class="btn btn-secondary" data-bs-dismiss="modal" type="button">Cancel</button>
                                </div>
                                <div class="col text-end">
                                    <input class="btn btn-primary" type="submit" value="Save">
                                    <input type="hidden" name="clientFormSubmitted">
                                    <input type="hidden" name="Add-UserID" id="Add-UserID">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Delete Modal -->
        <div class="modal fade" id="deleteModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Delete Confirmation</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Are You sure You want to delete this Client?
                    </div>
                    <div class="modal-footer">
                        <form action="Admin_ViewClients.php" method="post">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-danger">Delete</button>
                            <input type ="hidden" name="deleteClientSubmitted" value="TRUE">
                            <input type="hidden" id="DeleteIdInput" name="userId">
                        </form>
                    </div>
                </div>
            </div>
        </div>

</body>
<script src="./helpers/pagination.js"></script>
<script src="./helpers/AdminForms.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript">

    window.addEventListener("load", () => {
        enablePagination("clients", ".clientCard");
    });
    $(document).ready(function () {
        $("#addClientBtn").click(function () {
            //clear all form inputs when clicking on add client button
            $('.form-control').val('');
            $('.form-select').val('');
            $("#passwordDiv").removeAttr('hidden');
            $('#pwd').attr('required', '');
            $('#Add-UserID').removeAttr('value');
            $('.cmpInputs').prop('disabled', true);
            $('.pdInputs').prop('disabled', true);
            $('#chckboxerror').html("");
        });
    });
    $('#addModal').on('hidden.bs.modal', function (e) {
        // Clear form Input fields when closing the form
        $('.form-control').val('');
        $('.form-select').val('');
        $('#add-form').removeClass('was-validated');
        $('.pdInputs').prop('required', false);
        $('.cmpInputs').prop('required', false);
        $('#pdCheckBx').prop("checked", false);
        $('#cmpCheckBx').prop("checked", false);
        $('#chckboxerror').html("");
        $('.pdInputs').prop('disabled', false);
        $('.cmpInputs').prop('disabled', false);
    });
    $('#cmpCheckBx').change(function () {
        if ($(this).is(':checked')) {
            // check if company check box is checked, and add required propery to all company details form components
            $('.cmpInputs').prop('required', true);
            $('.cmpInputs').prop('disabled', false);
            $('#pdCheckBx').prop("required", false);//remove the required attributes from personal details form, becaue only one form is required
        } else {
            // do the opposite when it is unchekced
            $('.cmpInputs').prop('required', false);
            $('.cmpInputs').prop('disabled', true);
        }
    });
    $('#pdCheckBx').change(function () {
        if ($(this).is(':checked')) {
             // check if personal check box is checked, and add required propery to all personal details form components
            $('.pdInputs').prop('required', true);
            $('.pdInputs').prop('disabled', false);
            $('#cmpCheckBx').prop("required", false);
        } else {
           // do the opposite when it is unchekced
            $('.pdInputs').prop('required', false);
            $('.pdInputs').prop('disabled', true);
        }
    });
    $('#add-form').submit(function (e) {
        // a var to check if one of the forms is checked
        var isNotChecked = !($('#pdCheckBx').is(':checked') || $('#cmpCheckBx').is(':checked')); 
        
        if (isNotChecked) {
            $('#chckboxerror').html("Personal and/or Company Details must be provided");//display error message when no form is checked
            $('#cmpCheckBx').prop("required", true);
            $('#pdCheckBx').prop("required", true);
        } else {//clear error message if at least one form is checked
            $('#chckboxerror').html("");
            $('#cmpCheckBx').prop("required", false);
            $('#pdCheckBx').prop("required", false);
        }

        // Loop over the required inputs
        $('.cmpInputs, .pdInputs,.userInputs').each(function () {
            // Check if company details checkbox is checked
            if (($(this).val() === '' && $(this).attr('required') !== undefined) || isNotChecked) {
                $('#add-form').addClass('was-validated');
                e.preventDefault(); // Prevent form submission
                return false;
            }
        });
        return true;
    });
    $(document).ready(function () {
        $(document).on('click', '#editClientBtn', function () {
            $('#pwd').removeAttr('required');
            $("#passwordDiv").attr('hidden', '');
            var userId = $(this).attr('data-id');
            var clientId = $('#' + userId).val();
            console.log('user id is:', userId);
            console.log('client id is:', clientId);
            // AJAX request
            $.ajax({
                url: './helpers/get_Client_Info.php', // URL of your PHP script to fetch client info
                method: 'GET',
                data: {userId: userId, clientId: clientId}, // Send userId and client id to server
                dataType: 'json', // Expected data type from server
                success: function (response) {
                    // Handle successful response
                    console.log('User Info:', response);
                    // Update form inputs with fetched data
                    $('#usrName').val(response.username);
                    $('#email').val(response.email);
                    $('#phoneNum').val(response.phoneNumber);
                    $('#pwd').val(response.password);
                    $('#fName').val(response.firstName);
                    if ($('#fName').val() !== '') {
                        $('#pdCheckBx').prop("checked", true);
                    }else {
                        $('.pdInputs').prop('disabled', true);
                    }
                    $('#lName').val(response.lastName);
                    $('#gender').val(response.gender);
                    $('#nation').val(response.nationality);
                    $('#dob').val(response.dob);
                    $('#cmpName').val(response.companyName);
                    if ($('#cmpName').val() !== '') {
                        $('#cmpCheckBx').prop("checked", true);
                    } else {
                        $('.cmpInputs').prop('disabled', true);
                    }
                    $('#cmpSize').val(response.companySize);
                    $('#cmpWeb').val(response.website);
                    $('#cmpcity').val(response.city);
                    $('#Add-UserID').val(userId);
                },
                error: function (xhr, status, error) {
                    // Handle errors
                    console.error('Error fetching user info:', error);
                }
            });
        });
    });
</script>
