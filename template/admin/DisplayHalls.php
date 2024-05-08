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
                <button id="addClientBtn" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal">+ New Hall</button>
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
        <div class="modal" id="myModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Add/Edit Halls</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <!-- Modal body -->
                    <div class="modal-body">

                        <form id ="add-form" action="Admin_ViewHalls.php" method="POST"  enctype="multipart/form-data" onsubmit="return validateForm()">
                            <div class="text-center">
                                <img class="img-fluid form-img img-thumbnail" src="./images/upload-image.png" id="imagePreview">
                                <input type="file" id="imageUpload" name="HallImage">
                            </div>  
                            <div class="mb-3">
                                <label class="form-label">Hall Name</label>
                                <input type="text" class="form-control" placeholder="Enter Hall Name" name="HallName" value="" id="hallNameInput">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Rental Charge</label>
                                <input type="number" class="form-control" placeholder="Enter Rental Charge" name="RntlCharge" value="" id="RntlchargeInput">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Hall Capacity</label>
                                <input type="number" class="form-control" placeholder="Enter Hall's Capacity" name="capacity" value="" id="CapacityInput">
                            </div>
                            <div class="mb-3">
                                <label class="form-label" >Hall Description</label>
                                <textarea class="form-control" rows="5" placeholder="Enter Hall's Description" name="description" ></textarea>
                            </div>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert" id="formAlert"  hidden>
                                <span id="formAlertMsg"></span>
                            </div>
                            <div class="row">
                                <div class="col text-start">
                                    <button class="btn btn-secondary" data-bs-dismiss="modal" type="button">Cancel</button>
                                </div>
                                <div class="col text-end">
                                    <input class="btn btn-primary" type="submit" value="Save"/>
                                    <input type="hidden" name="submitted"/>
<!--                                    <input type="hidden" id="hallIdInput" name="hallId">-->
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
                            <input type ="hidden" name="deleteSubmitted" value="TRUE">
                            <input type="hidden" id="hallIdInput" name="hallId">
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="errorModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Invalid Input</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p id="errorMessage">This is an error message.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<script src="./helpers/pagination.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script>

                            window.addEventListener("load", () => {
                                enablePagination("halls", ".hallCard");
                            });

                            // JavaScript to toggle the visibility of image upload on image click
                            document.getElementById('imagePreview').addEventListener('click', function () {
                                document.getElementById('imageUpload').click();
                            });
                            function getHallID(button) {
                                var hallID = button.getAttribute("data-id");
                                var hallIDInput = document.getElementById('hallIdInput');
                                hallIDInput.value = hallID; // Set the value directly, no need for setAttribute
                            }

                            function validateForm() {
                                // Get form inputs
                                var Hallname = document.getElementById('hallNameInput').value;
                                var rntlCharge = document.getElementById('RntlchargeInput').value;
                                var capacity = document.getElementById('CapacityInput').value;
                                var imageUpload = document.getElementById('imageUpload');
                                var formAlert = document.getElementById('formAlert');
                                formAlert.setAttribute('hidden', '');
                                var formAlertmsg = document.getElementById('formAlertMsg');
                                // Check if name is empty
                                if (imageUpload.files.length === 0) {
                                    formAlert.removeAttribute('hidden');
                                    formAlertmsg.innerHTML = 'Hall Image Cannot be Empty';
                                    return false; // Prevent form submission
                                }

                                // Check if email is empty or invalid
                                else if (Hallname === '') {
                                    formAlert.removeAttribute('hidden');
                                    formAlertmsg.innerHTML = 'Hall Name cannot be Empty';
                                    return false; // Prevent form submission

                                } else if (rntlCharge == '') {
                                    formAlert.removeAttribute('hidden');
                                    formAlertmsg.innerHTML = 'Rental Charge cannot be Empty';
                                    return false; // Prevent form submission
                                } else if (capacity == '') {
                                    formAlert.removeAttribute('hidden');
                                    formAlertmsg.innerHTML = 'Capacity cannot be Empty';
                                    return false; // Prevent form submission
                                }

                                // If all checks pass, allow form submission
                                return true;
                            }
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
                                <button class="btn btn-primary flex-fill rounded-0 rounded-top-right" data-id="' . $hall->getHallId() . '"data-bs-toggle="modal" data-bs-target="#myModal" onclick="location.href=&quot;Admin_ViewHalls.php?hallId='. $hall->getHallId().';">Edit</button>
                                 <a href="Admin_ViewHalls.php?hallId='. $hall->getHallId().'">Edit</a> 
                                <button class="btn btn-danger flex-fill rounded-0 rounded-bottom-right" data-id="' . $hall->getHallId() . '" data-bs-toggle="modal" data-bs-target="#deleteModal" onclick="getHallID(this)" id="deleteHallBtn">Delete</button>
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