<!DOCTYPE html>
<body>
    <div class="container">
        <br>
        <div class="row">
            <h1>Browse Halls</h1>
        </div>
        <div class="row">
            <div class="col-xl-10">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Search For a Hall" id="search">
                    <button class="btn btn-outline-secondary" type="button" id="searchBtn">
                        <i>Search</i>
                    </button>
                </div>
            </div>
            <div class="col-xl-2 text-end">
                <button id="addHallBtn" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">+ New Hall</button>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-2 ">
                <!-- Pagination bar -->
                <nav class="mb-3 d-flex justify-content-center align-items-center" aria-label="Menu Page Navigation">
                    <span class="me-2">Page: </span>
                    <ul class="pagination d-flex flex-row m-0">
                        <li class="page-item"><input type="button" class="pagination-first-halls page-link mx-2 rounded border-2" value="First"></li>
                    </ul>
                    <ul class="pagination pagination-numbers-halls d-flex flex-row m-0">
                    </ul>
                    <ul class="pagination d-flex flex-row m-0">
                        <li class="page-item"><input type="button" class="pagination-last-halls page-link mx-2 rounded border-2" value="Last"></li>
                    </ul>
                </nav>
            </div>
        </div>
        <br>

        <div id="pagination-items-halls">
            <?php
            $newHall = new Hall();
            $dataSet = $newHall->getAllHalls();
            displayHalls($dataSet);
            ?>
        </div>
        <!-- Pagination bar -->
        <nav class="mb-3 d-flex justify-content-center align-items-center" aria-label="Menu Page Navigation">
            <span class="me-2">Page: </span>
            <ul class="pagination d-flex flex-row m-0">
                <li class="page-item"><input type="button" class="pagination-first-halls page-link mx-2 rounded border-2" value="First"></li>
            </ul>
            <ul class="pagination pagination-numbers-halls d-flex flex-row m-0">
            </ul>
            <ul class="pagination d-flex flex-row m-0">
                <li class="page-item"><input type="button" class="pagination-last-halls page-link mx-2 rounded border-2" value="Last"></li>
            </ul>
        </nav>

        <!-- Add/Update Modal -->
        <div class="modal" id="addModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Add/Edit Halls</h4>
                        <button type="button" class="btn-close cancelBtn" data-bs-dismiss="modal"></button>
                    </div>
                    <!-- Modal body -->
                    <div class="modal-body">

                        <form id="add-form" action="Admin_ViewHalls.php" novalidate method="POST" enctype="multipart/form-data">
                            <div class="mb-3 form-group required" id="hallImg">
                                <label class="form-label" id="imageUploadLabel">Hall Image</label>
                                <input type="file" class="form-control" id="imageUpload" name="HallImage" required >

                            </div>  
                            <div class="mb-3 form-group required">
                                <label class="form-label">Hall Name</label>
                                <input type="text" class="form-control" placeholder="Enter Hall Name" name="HallName" value="" id="hallNameInput" required >
                            </div>
                            <div class="mb-3 form-group required">
                                <label class="form-label">Rental Charge</label>
                                <input type="number" step="any" class="form-control" placeholder="Enter Rental Charge" name="RntlCharge" value="" id="RntlchargeInput" required >
                            </div>
                            <div class="mb-3 form-group required">
                                <label class="form-label">Hall Capacity</label>
                                <input type="number" class="form-control" placeholder="Enter Hall's Capacity" name="capacity" value="" id="CapacityInput" required >
                            </div>
                            <div class="mb-3 form-group">
                                <label class="form-label">Hall Description</label>
                                <textarea class="form-control" rows="5" placeholder="Enter Hall's Description" name="description" id="descriptionInput"></textarea>
                            </div>
                            <div class="row">
                                <div class="col text-start">
                                    <button class="btn btn-secondary cancelBtn" data-bs-dismiss="modal" type="button">Cancel</button>
                                </div>
                                <div class="col text-end">
                                    <input class="btn btn-primary" type="submit" value="Save">
                                    <input type="hidden" name="submitted">
                                    <input type="hidden" name="Add-HallID" id="Add-HallID">
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
                        Are You sure You want to delete this Hall?
                    </div>
                    <div class="modal-footer">
                        <form action="Admin_ViewHalls.php" method="post">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-danger">Delete</button>
                            <input type ="hidden" name="deleteHallSubmitted" value="TRUE">
                            <input type="hidden" id="DeleteIdInput" name="hallId">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<script src="./helpers/pagination.js"></script>
<script src="./helpers/AdminForms.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    window.addEventListener("load", () => {
        enablePagination("halls", ".hallCard");
    });

//                            // JavaScript to toggle the visibility of image upload on image click
//                            document.getElementById('imagePreview').addEventListener('click', function () {
//                                document.getElementById('imageUpload').click();
//                            });

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
</body>


<?php

function displayHalls($dataSet) {
    if (!empty($dataSet)) {
        for ($i = 0; $i < count($dataSet); $i++) {
            $hall = new Hall();
            $id = $dataSet[$i]->hall_id;
            $hall->initWithHallid($id);

            echo'<div class="card hallCard mb-4">
                <div class="card-body p-0">
                    <div class="row ">
                        <div class="col-xl-5 text-center">';
            echo'<img class="img-fluid" src="' . $hall->getImagePath() . '">
                        </div>';
            echo'<div class="col-xl-6 text-center p-3">
                            <br>
                            <h3>' . $hall->getHallName() . '</h3>
                            <br>';
            echo'<p>' . $hall->getDescription() . '</p>
                            <br><br>
                            <div class="row">';
            echo'<div class="col text-start">
                                    <h3>' . $hall->getRentalCharge() . '/Hr</h3>
                                </div>';
            echo'<div class="col text-end">
                                    <h3>' . $hall->getCapacity() . ' seats</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-1">
                            <div class="d-flex flex-column h-100 justify-content-between">
                                <button id="editHallBtn" class="btn btn-primary flex-fill rounded-0 rounded-top-right" data-id="' . $hall->getHallId() . '" data-bs-toggle="modal" data-bs-target="#addModal">Edit</button>
                                <button class="btn btn-danger flex-fill rounded-0 rounded-bottom-right" data-id="' . $hall->getHallId() . '" data-bs-toggle="modal" data-bs-target="#deleteModal" onclick="setDeleteID(this)" id="deleteHallBtn">Delete</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            ';
        }
    } else {
        echo '<h1>No Halls to Display</h1>';
    }
}
?>