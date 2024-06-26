<!DOCTYPE html>
<body>
    <div class="container">
        <br>
        <div class="row">
            <h1>Browse Halls</h1>
        </div>
        <div class="row">
            <div class="col-xl-10 text-end">
                <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-funnel-fill"></i>
                    </button>
                    <ul class="dropdown-menu">
                        <li><a id="all-halls" class="dropdown-item" href="<?php echo $_SERVER['PHP_SELF'] . '?filter=all'; ?>">All Halls</a></li>
                        <li><a id="all-halls" class="dropdown-item" href="<?php echo $_SERVER['PHP_SELF'] . '?filter=ava'; ?>">Available Halls</a></li>
                        <li><a id="all-halls" class="dropdown-item" href="<?php echo $_SERVER['PHP_SELF'] . '?filter=cncl'; ?>">Cancelled Halls</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-xl-2 text-end">
                <button id="addHallBtn" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal"><i class="bi bi-plus-lg"></i> New Hall</button>
            </div>
        </div>
        <br>
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
                                <label class="form-label" id="imageUploadLabel">Hall Images<span class="fst-italic"> (minimum1)</span></label>
                                <input class="form-control " id="imageUpload1" name="HallImage[]" type="file" hidden>
                                <input class="form-control " id="imageUpload2" name="HallImage[]" type="file" hidden>
                                <input class="form-control " id="imageUpload3" name="HallImage[]" type="file" hidden>
                                <input class="form-control " id="imageUpload4" name="HallImage[]" type="file" hidden>
                                <table class="table">
                                    <tbody id="imageList">
                                        <tr>
                                            <td>1.</td>
                                            <td id="img1" class="hallimgIn">Empty</td>
                                            <td id="rm-file1"><i class="bi bi-trash3-fill">Delete</i></td>
                                            <td id="add-file1"><i class="bi bi-plus-circle-fill">Add</i></td>
                                        </tr>
                                        <tr>
                                            <td>2.</td>
                                            <td id="img2"class="hallimgIn">Empty</td>
                                            <td id="rm-file2"><i class="bi bi-trash3-fill">Delete</i></td>
                                            <td id="add-file2"><i class="bi bi-plus-circle-fill">Add</i></td>
                                        </tr>
                                        <tr>
                                            <td>3.</td>
                                            <td id="img3"class="hallimgIn">Empty</td>
                                            <td id="rm-file3"><i class="bi bi-trash3-fill">Delete</i></td>
                                            <td id="add-file3"><i class="bi bi-plus-circle-fill">Add</i></td>
                                        </tr>
                                        <tr>
                                            <td>4.</td>
                                            <td id="img4"class="hallimgIn">Empty</td>
                                            <td id="rm-file4"><i class="bi bi-trash3-fill">Delete</i></td>
                                            <td id="add-file4"><i class="bi bi-plus-circle-fill">Add</i></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>  
                            <div class="mb-3 form-group required">
                                <label class="form-label">Hall Name</label>
                                <input type="text" minlength="3" maxlength="100" class="form-control" placeholder="Enter Hall Name" name="HallName" value="" id="hallNameInput" required >
                            </div>
                            <div class="mb-3 form-group required">
                                <label class="form-label">Rental Charge</label>
                                <input type="number" step="0.001" max="9999999" class="form-control" placeholder="Enter Rental Charge" name="RntlCharge" value="" id="RntlchargeInput" required >
                            </div>
                            <div class="mb-3 form-group required">
                                <label class="form-label">Hall Capacity</label>
                                <input type="number" max="99999999999" class="form-control" placeholder="Enter Hall's Capacity" name="capacity" value="" id="CapacityInput" required >
                            </div>
                            <div class="mb-3 form-group required">
                                <label for="status" class="form-label">Hall Status</label>
                                <select name="status" class="form-select" id="hallStatus" required>
                                    <option value="" disabled>Select Status</option>
                                    <option value="1">Available</option>
                                    <option value="2" >Cancelled</option>
                                </select>
                            </div>
                            <div class="mb-3 form-group">
                                <label class="form-label">Hall Description</label>
                                <textarea class="form-control" maxlength="500" rows="5" placeholder="Enter Hall's Description" name="description" id="descriptionInput"></textarea>
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    window.addEventListener("load", () => {
        enablePagination("halls", ".hallCard");
    });

    //get Hall ID value 
    $(document).ready(function () {
        var imgArray = []; // array to store removed images paths
        
        //add event listners to the image upload inputs
        $('#add-file1').click(function () {
            $('#imageUpload1').click();
        });
        $('#add-file2').click(function () {
            $('#imageUpload2').click();
        });
        $('#add-file3').click(function () {
            $('#imageUpload3').click();
        });
        $('#add-file4').click(function () {
            $('#imageUpload4').click();
        });
        
        $('#imageUpload1').change(function () {
            // Check if any file is selected
            if (this.files.length > 0) {
                $('#img1').text(this.files[0].name);
            }
        });
        $('#imageUpload2').change(function () {
            // Check if any file is selected
            if (this.files.length > 0) {
                $('#img2').text(this.files[0].name);
            }
        });
        $('#imageUpload3').change(function () {
            // Check if any file is selected
            if (this.files.length > 0) {
                $('#img3').text(this.files[0].name);
            }
        });
        $('#imageUpload4').change(function () {
            // Check if any file is selected
            if (this.files.length > 0) {
                $('#img4').text(this.files[0].name);
            }
        });
        $('#rm-file1').click(function () {
            var imgPath = $('#img1').text();
            console.log("image path is" + imgPath);
            if ($('#imageUpload1').val() == '' && $('#img1').text() != "Empty") {
                console.log("old image path is" + imgPath);
                imgArray.push(imgPath);
                $('#img1').text("Empty");
            } else {
                $('#imageUpload1').val('');
                $('#img1').text("Empty");
            }
        });
        $('#rm-file2').click(function () {
            var imgPath = $('#img2').text();
            console.log("image path is" + imgPath);
            if ($('#imageUpload2').val() == '' && $('#img2').text() != "Empty") {
                imgArray.push(imgPath);
                $('#img2').text("Empty");
            } else {
                $('#imageUpload2').val('');
                $('#img2').text("Empty");
            }
        });
        $('#rm-file3').click(function () {
            var imgPath = $('#img3').text();
            console.log("image path is" + imgPath);
            if ($('#imageUpload3').val() == '' && $('#img3').text() != "Empty") {
                console.log("old image path is" + imgPath);
                imgArray.push(imgPath);
                $('#img3').text("Empty");
            } else {
                $('#imageUpload3').val('');
                $('#img3').text("Empty");
            }
        });
        $('#rm-file4').click(function () {
            var imgPath = $('#img4').text();
            console.log("image path is" + imgPath);
            if ($('#imageUpload4').val() == '' && $('#img4').text() != "Empty") {
                console.log("old image path is" + imgPath);
                imgArray.push(imgPath);
                $('#img4').text("Empty");
            } else {
                $('#imageUpload4').val('');
                $('#img4').text("Empty");
            }
        });
        $('#halls').addClass('active-page');
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
                    // Update form inputs with fetched data
                    $('#hallNameInput').val(response.hallName);
                    $('#RntlchargeInput').val(response.rentalCharge);
                    $('#CapacityInput').val(response.capacity);
                    $('#descriptionInput').val(response.description);
                    $('#hallStatus').val(response.status);
                    $('#Add-HallID').val(response.hallId);
                },
                error: function (xhr, status, error) {
                    // Handle errors
                    console.error('Error fetching hall info:', error);
                }
            });
            $.ajax({
                url: './helpers/get_hall_images.php', // URL of your PHP script to fetch hall info
                method: 'GET',
                data: {hallIdImg: hallId}, // Send hallId to server
                dataType: 'json', // Expected data type from server
                success: function (response) {
                    // Handle successful response
                    console.log('Hall Images Info:', response);
                    // Update form inputs with fetched data
                    $('#img1').text(response[0].hall_image_path);
                    $('#img2').text(response[1].hall_image_path);
                    $('#img3').text(response[2].hall_image_path);
                    $('#img4').text(response[3].hall_image_path);
                },
                error: function (xhr, status, error) {
                    // Handle errors
                    console.error('Error fetching hall images info:', error);
                }
            });
        });

        $('#add-form').submit(function (e) {
            // Get form inputs
            var Hallname = $('#hallNameInput').val();
            var rntlCharge = $('#RntlchargeInput').val();
            var capacity = $('#CapacityInput').val();
            var status = $('#hallStatus').val();
            var oneImageUploaded = false;

            $('.hallimgIn').each(function () {
                if ($(this).text() !== 'Empty') {
                    oneImageUploaded = true;
                    return false;
                }
            });

            // Check if any field is empty or image is not uploaded
            if (!oneImageUploaded || Hallname === '' || rntlCharge == '' || capacity == '' || status == '') {
                $(this).addClass('was-validated');
                e.preventDefault(); // Prevent form submission
                console.log(imgArray+"these are images");
                return false;
            }
//            var jsonData = JSON.stringify(imgArray);
            $.ajax({
                url: './helpers/delete_hall_image.php',
                method: 'POST',
                data: {imgArray: imgArray},
                success: function (response) {
                    console.log(response);
                    return true;
                },
                error: function (xhr, status, error) {
                    console.error(error);
                    return false;// Log any errors
                }
            });
            // If all checks pass, allow form submission
            
        });
    });
    $('#addModal').on('hidden.bs.modal', function (e) {
        // Clear form Input fields when closing the form
        $('.form-control').val('');
        $('.form-select').val('');
        $('#img1').text("Empty");
        $('#img2').text("Empty");
        $('#img3').text("Empty");
        $('#img4').text("Empty");
        $('#add-form').removeClass('was-validated');
        console.log('Modal dismissed');
    });
    $('#addHallBtn').click(function () {
        $('.form-control').val('');
        $('.form-select').val('');
        $('#Add-HallID').removeAttr('value');
    });

</script>
</body>


