<!DOCTYPE html>
<body>
    <div class="container">
        <br>
        <div class="row">
            <h1>Browse Services</h1>
        </div>
        <div class="row">
            <div class="col-xl-10">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Search For a Service" id="search">
                    <button class="btn btn-outline-secondary" type="button" id="searchBtn">
                        <i>Search</i>
                    </button>
                </div>
            </div>
            <div class="col-xl-2 text-end">
                <button id="addClientBtn" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">+ New Service</button>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-2">
                <!-- Pagination bar -->
                <nav class="mb-3 d-flex justify-content-center align-items-center" aria-label="Menu Page Navigation">
                    <span class="me-2">Page: </span>
                    <ul class="pagination d-flex flex-row m-0">
                        <li class="page-item"><input type="button" class="pagination-first-services page-link mx-2 rounded border-2" value="First"></li>
                    </ul>
                    <ul class="pagination pagination-numbers-services d-flex flex-row m-0">
                    </ul>
                    <ul class="pagination d-flex flex-row m-0">
                        <li class="page-item"><input type="button" class="pagination-last-services page-link mx-2 rounded border-2" value="Last"></li>
                    </ul>
                </nav>

            </div>
        </div>
        <br>
        <div id="pagination-items-services">
            <!-- display menu items -->
            <?php
            echo'<h1>Testing Display</h1>';
            $newMenu = new MenuItem();
            $dataSet = $newMenu->getAllMenuItems();
            displayMenuItems($dataSet);
            ?>
        </div>
        <br>
        <!-- Add Modal -->
        <div class="modal" id="addModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Add/Edit Services</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <!-- Modal body -->
                    <div class="modal-body">
                        <form action="Admin_ViewServices.php" id="add-form" novalidate method="POST" enctype="multipart/form-data" onsubmit="return validateForm()">
                            <div class="mb-3 form-group required">
                                <label class="form-label">Menu Item Image</label>
                                <input type="file" class="form-control" id="imageUpload" name="MenuItemImg" required >
                            </div> 
                            <div class="mb-3 form-group required">
                                <label for="ItemName" class="form-label">Item Name</label>
                                <input type="text" class="form-control" id="ItemName" placeholder="Enter Item Name" name="ItemName" required>
                            </div>
                            <div class="mb-3 form-group required">
                                <label for="Price" class="form-label">Price</label>
                                <input type="number" class="form-control" id="Price" placeholder="Enter Price" name="Price" required>
                            </div>
                            <div class="mb-3 form-group required">
                                <label for="serviceType" class="form-label">Service Type</label>
                                <select name="serviceType" class="form-select" required>
                                    <option value="" disabled>Select Service Type</option>
                                    <option value="Type1">Breakfast</option>
                                    <option value="Type2">Lunch</option>
                                    <option value="Type3">Hot Beverages</option>
                                    <option value="Type4">Cold Beverages</option>  
                                </select>
                            </div>
                            <div class="mb-3" form-group>
                                <label for="description">Item Description</label>
                                <textarea class="form-control" rows="5" id="description" placeholder="Enter Items's Description" name="description" ></textarea>
                            </div>
                            <div class="row">
                                <div class="col text-start">
                                    <button class="btn btn-danger" data-bs-dismiss="modal" type="button">Cancel</button>
                                </div>
                                <div class="col text-end">
                                    <input class="btn btn-primary" data-bs-dismiss="modal" type="submit" value="Save">
                                    <input type="hidden" name="submitted">
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
    </div>
    <script src="./helpers/pagination.js"></script>
    <script src="./helpers/AdminForms.js"></script>
    <script>

                            window.addEventListener("load", () => {
                                enablePagination("services", ".serviceCard");
                            });
                            // JavaScript to toggle the visibility of image upload on image click
                            document.getElementById('imagePreview').addEventListener('click', function () {
                                document.getElementById('imageUpload').click();
                            });
    </script>
</body>


<?php

function displayMenuItems($dataSet) {
    if (!empty($dataSet)) {
        for ($i = 0; $i < count($dataSet); $i++) {
            $item = new MenuItem();
            $id = $dataSet[$i]->item_id;
            $item->initWithMenuItemid($id);
            echo '<div class="card serviceCard mb-4">
                <div class="card-body p-0">
                    <div class="row ">';
            echo'<div class="col-xl-5 text-center">
                            <img class="img-fluid" src="' . $item->getImagePath() . '">
                        </div>
                        <div class="col-xl-6 text-center p-3">
                            <br>';
            echo'<h3>' . $item->getName() . '</h3>
                            <br>';
            echo'<p>' . $item->getDescription() . '</p>
                            <br><br>';
            echo'<div class="row">
                                <div class="col text-start">
                                    <h3>BD ' . $item->getPrice() . '</h3>
                                </div>';
            echo'<div class="col text-end">
                                    <h3>' . $item->getCateringType($item->getCateringService()) . '</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-1">
                            <div class="d-flex flex-column h-100 justify-content-between">
                                <button class="btn btn-primary flex-fill rounded-0 rounded-top-right" data-bs-toggle="modal" data-bs-target="#myModal">Edit</button>
                                <button class="btn btn-danger flex-fill rounded-0 rounded-bottom-right data-bs-toggle="modal" data-bs-target="#deleteModal"">Delete</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>';
        }
    } else {
        echo '<h1>No Menu Items to Display</h1>';
    }
}
?>
