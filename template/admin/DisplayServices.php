<!DOCTYPE html>
<body>
    <div class="container">
        <br>
        <div class="row">
            <h1>Browse Services</h1>
        </div>
        <div class="row">
            <div class="col-xl-8 mb-4">
                <div class="input-group">
                    <input type="text" class="form-control mb-0" placeholder="Search For a Hall" id="search">
                    <button class="btn btn-outline-secondary" id="searchBtn">
                        <i class="bi bi-search"> Search</i>
                    </button>
                </div>
            </div>
            <div class="col-xl-2">
                <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-funnel-fill"></i>
                    </button>
                    <ul class="dropdown-menu">
                        <li><a id="all-halls" class="dropdown-item" href="<?php echo $_SERVER['PHP_SELF'] . '?filter=all'; ?>">All Items</a></li>
                        <li><a id="all-halls" class="dropdown-item" href="<?php echo $_SERVER['PHP_SELF'] . '?filter=ava'; ?>">Available Items</a></li>
                        <li><a id="all-halls" class="dropdown-item" href="<?php echo $_SERVER['PHP_SELF'] . '?filter=cncl'; ?>">Cancelled Items</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-xl-2 text-end">
                <button id="addItemBtn" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">+ New Service</button>
            </div>
        </div>
        <br>
        <!-- Add Modal -->
        <div class="modal" id="addModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Add/Edit Services</h4>
                        <button type="button" class="btn-close cancelBtn" data-bs-dismiss="modal"></button>
                    </div>
                    <!-- Modal body -->
                    <div class="modal-body">
                        <form action="Admin_ViewServices.php" id="add-form" novalidate method="POST" enctype="multipart/form-data">
                            <div class="mb-3 form-group required" id="ItemImg">
                                <label class="form-label">Menu Item Image</label>
                                <input type="file" class="form-control" id="imageUpload" name="MenuItemImg" required >
                                <input value="" type="hidden" name="imagePath" id="imagePath" >
                            </div> 
                            <div class="mb-3 form-group required">
                                <label for="ItemName" class="form-label">Item Name</label>
                                <input type="text" class="form-control" id="ItemName" placeholder="Enter Item Name" name="ItemName" required>
                            </div>
                            <div class="mb-3 form-group required">
                                <label for="Price" class="form-label">Price</label>
                                <input type="number" step="any" class="form-control" id="Price" placeholder="Enter Price" name="Price" required>
                            </div>
                            <div class="mb-3 form-group required">
                                <label for="serviceType" class="form-label">Service Type</label>
                                <select name="serviceType" class="form-select" id="serviceidSelect" required>
                                    <option value="" disabled selected>Select Service Type</option>
                                    <option value="1" >Breakfast</option>
                                    <option value="2" >Lunch</option>
                                    <option value="3" >Hot Beverages</option>
                                    <option value="4" >Cold Beverages</option>  
                                </select>
                            </div>
                            <div class="mb-3 form-group required">
                                <label for="status" class="form-label">Item Status</label>
                                <select name="status" class="form-select" id="itemStatus" required>
                                    <option value="" disabled>Select Status</option>
                                    <option value="1">Available</option>
                                    <option value="2" >Cancelled</option>
                                </select>
                            </div>
                            <div class="mb-3" form-group>
                                <label for="description">Item Description</label>
                                <textarea class="form-control" rows="5" id="description" placeholder="Enter Items's Description" name="description" ></textarea>
                            </div>
                            <div class="row">
                                <div class="col text-start">
                                    <button class="btn btn-secondary cancelBtn" data-bs-dismiss="modal" type="button">Cancel</button>
                                </div>
                                <div class="col text-end">
                                    <input class="btn btn-primary" type="submit" value="Save">
                                    <input type="hidden" name="submitted">
                                    <input type="hidden" name="Add-ItemID" id="Add-ItemID">
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
                        Are You sure You want to delete this Item?
                    </div>
                    <div class="modal-footer">
                        <form action="Admin_ViewServices.php" method="post">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-danger">Delete</button>
                            <input type ="hidden" name="deleteItemSubmitted" value="TRUE">
                            <input type="hidden" id="DeleteIdInput" name="ItemId">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="./helpers/pagination.js"></script>
    <script src="./helpers/AdminForms.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>

        window.addEventListener("load", () => {
            enablePagination("services", ".serviceCard");
        });
        // JavaScript to toggle the visibility of image upload on image click
        //                            document.getElementById('imagePreview').addEventListener('click', function () {
        //                                document.getElementById('imageUpload').click();
        //                            });
        //get Hall ID value 
        $(document).ready(function () {
            $('#catering').addClass('active-page');
            $(document).on('click', '#editItemBtn', function () {

                var itemId = $(this).attr('data-id');
                console.log('Item id is:', itemId);
                // AJAX request
                $.ajax({
                    url: './helpers/get_Item_Info.php', // URL of your PHP script to fetch hall info
                    method: 'GET',
                    data: {itemId: itemId}, // Send hallId to server
                    dataType: 'json', // Expected data type from server
                    success: function (response) {
                        // Handle successful response
                        console.log('Item Info:', response);
                        //remove image upload validation
                        $('#ItemImg').removeAttr('required');
                        $('#imageUpload').removeAttr('required');
                        $('#imageUploadLabel:after').remove();
                        // Update form inputs with fetched data
                        $('#ItemName').val(response.name);
                        $('#Price').val(response.price);
                        console.log('Service id Info:', response.service_id);
                        $('#serviceidSelect').val(response.service_id).change();
                        $('#description').val(response.description);
                        $('#imagePath').val(response.image_path);
                        $('#Add-ItemID').val(response.ItemId);
                    },
                    error: function (xhr, status, error) {
                        // Handle errors
                        console.error('Error fetching hall info:', error);
                    }
                });
            });
        });
        $('#addModal').on('hidden.bs.modal', function (e) {
            // Do something when the modal is dismissed
            $('.form-control').val('');
            $('.form-select').val('');
            $('#add-form').removeClass('was-validated');
            console.log('Modal dismissed');
        });
        $('#addItemBtn').click(function () {
            // Clear form Input fields when closing the form
            $('#ItemImg').attr('required', '');
            $('#imageUpload').attr('required', '');
            $('#Add-ItemID').removeAttr('value');
            $('#imageUploadLabel:after').add();
        });

        $('#add-form').submit(function (e) {
            // Get form inputs
            var name = $('#ItemName').val();
            var price = $('#Price').val();
            var serviceId = $('#serviceidSelect').val();
            console.log("service id value is:", serviceId);
            var imageUpload = $('#imageUpload');
            var status = $('#itemStatus').val();
            // Check if any field is empty or image is not uploaded
            if ((imageUpload.prop('required') && imageUpload[0].files.length === 0) || name === '' || price == '' || serviceId == '' || serviceId === null || status == '') {
                $(this).addClass('was-validated');
                e.preventDefault(); // Prevent form submission
                return false;
            }
            // If all checks pass, allow form submission
            return true;
        });
    </script>
</body>


