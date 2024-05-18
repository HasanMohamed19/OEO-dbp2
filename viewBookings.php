<?php 
    include './helpers/Database.php';
    include './models/User.php';
    include './models/Reservation.php';
    include 'debugging.php';
    include './template/header.html';
        
//    include './template/admin/view_bookings.html';   

//    include './template/admin/viewBookings.php';
?>


<div class="container">
    <script src="./helpers/pagination.js"></script>
        <div class="row">
        <h1>Bookings</h1>
        </div>
    <div class="form-outline mb-1" data-mdb-input-init>
        <div class="row">
            <div class="col">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Search For a Client" id="search">
                    <button class="btn btn-outline-secondary" type="button" id="searchBtn">
                        <i>Search</i>
                    </button>
                </div>
            </div>
            <div class="col">
                 <!-- Pagination bar -->
                <nav class="mb-3 d-flex justify-content-center align-items-center" aria-label="Menu Page Navigation">
                    <span class="me-2">Page: </span>
                    <ul class="pagination d-flex flex-row m-0">
                        <li class="page-item"><input type="button" class="pagination-first-bookings page-link mx-2 rounded border-2" value="First"></li>
                    </ul>
                    <ul class="pagination pagination-numbers-bookings d-flex flex-row m-0">
                    </ul>
                    <ul class="pagination d-flex flex-row m-0">
                        <li class="page-item"><input type="button" class="pagination-last-bookings page-link mx-2 rounded border-2" value="Last"></li>
                    </ul>
                </nav>
        </div>

        </div>
        
    </div>
    
    <?php 
        $reservation = new Reservation();
        $reservations = $reservation->getAllReservations();
    
//        echo count($reservations) . " rows were found";

        $reservation->createReservationsTable($reservations);
    ?>
    <!-- <div class="table-responsive">
        <table id="pagination-items-bookings" class="table table-striped table-bordered border-5 align-middle text-center rounded rounded-2">
            
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Total</th>
                    <th>Reservation ID</th>
                    <th>Hall Name</th>
                    <th>Client</th>
                </tr>
            </thead>

            <tbody>
                <tr class="booking">
                    <td scope="row">Jan 1, 2025</td>
                    <td>Pending</td>
                    <td>800 BHD</td>
                    <td>#093284EF0-3</td>
                    <td>Hall Name</td>
                    <td>Mohamed</td>
                </tr>

                <tr class="booking">
                    <td scope="row">Jan 1, 2025</td>
                    <td>Pending</td>
                    <td>800 BHD</td>
                    <td>#093284EF0-3</td>
                    <td>Hall Name</td>
                    <td>Mohamed</td>
                </tr>

                <tr class="booking">
                    <td scope="row">Jan 1, 2025</td>
                    <td>Pending</td>
                    <td>800 BHD</td>
                    <td>#093284EF0-3</td>
                    <td>Hall Name</td>
                    <td>Mohamed</td>
                </tr>

                <tr class="booking">
                    <td scope="row">Jan 1, 2025</td>
                    <td>Pending</td>
                    <td>800 BHD</td>
                    <td>#093284EF0-3</td>
                    <td>Hall Name</td>
                    <td>Mohamed</td>
                </tr>

                <tr class="booking">
                    <td scope="row">Jan 1, 2025</td>
                    <td>Pending</td>
                    <td>800 BHD</td>
                    <td>#093284EF0-3</td>
                    <td>Hall Name</td>
                    <td>Husain</td>
                </tr>

                <tr class="booking">
                    <td scope="row">Jan 1, 2025</td>
                    <td>Pending</td>
                    <td>800 BHD</td>
                    <td>#093284EF0-3</td>
                    <td>Hall Name</td>
                    <td>Mohamed</td>
                </tr>

                <tr class="booking">
                    <td scope="row">Jan 1, 2025</td>
                    <td>Pending</td>
                    <td>800 BHD</td>
                    <td>#093284EF0-3</td>
                    <td>Hall Name</td>
                    <td>Ali</td>
                </tr>

                <tr class="booking">
                    <td scope="row">Jan 1, 2025</td>
                    <td>Pending</td>
                    <td>800 BHD</td>
                    <td>#093284EF0-3</td>
                    <td>Hall Name</td>
                    <td>Mohamed</td>
                </tr>

                <tr class="booking">
                    <td scope="row">Jan 1, 2025</td>
                    <td>Pending</td>
                    <td>800 BHD</td>
                    <td>#093284EF0-3</td>
                    <td>Hall Name</td>
                    <td>Ali</td>
                </tr>

                <tr class="booking">
                    <td scope="row">Jan 1, 2025</td>
                    <td>Pending</td>
                    <td>800 BHD</td>
                    <td>#093284EF0-3</td>
                    <td>Hall Name</td>
                    <td>Mohamed</td>
                </tr>

                <tr class="booking">
                    <td scope="row">Jan 1, 2025</td>
                    <td>Pending</td>
                    <td>800 BHD</td>
                    <td>#093284EF0-3</td>
                    <td>Hall Name</td>
                    <td>Ali</td>
                </tr>

                <tr class="booking">
                    <td scope="row">Jan 1, 2025</td>
                    <td>Pending</td>
                    <td>800 BHD</td>
                    <td>#093284EF0-3</td>
                    <td>Hall Name</td>
                    <td>Mohamed</td>
                </tr>

                <tr class="booking">
                    <td scope="row">Jan 1, 2025</td>
                    <td>Pending</td>
                    <td>800 BHD</td>
                    <td>#093284EF0-3</td>
                    <td>Hall Name</td>
                    <td>Ali</td>
                </tr>

                <tr class="booking">
                    <td scope="row">Jan 1, 2025</td>
                    <td>Pending</td>
                    <td>800 BHD</td>
                    <td>#093284EF0-3</td>
                    <td>Hall Name</td>
                    <td>Mohamed</td>
                </tr>

                <tr class="booking">
                    <td scope="row">Jan 1, 2025</td>
                    <td>Pending</td>
                    <td>800 BHD</td>
                    <td>#093284EF0-3</td>
                    <td>Hall Name</td>
                    <td>Last</td>
                </tr>

            </tbody>

        </table>
    </div> -->

    
    <!-- Pagination bar -->
    <nav class="mb-3 d-flex justify-content-center align-items-center" aria-label="Menu Page Navigation">
        <span class="me-2">Page: </span>
        <ul class="pagination d-flex flex-row m-0">
            <li class="page-item"><input type="button" class="pagination-first-bookings page-link mx-2 rounded border-2" value="First"></li>
        </ul>
        <ul class="pagination pagination-numbers-bookings d-flex flex-row m-0">
        </ul>
        <ul class="pagination d-flex flex-row m-0">
            <li class="page-item"><input type="button" class="pagination-last-bookings page-link mx-2 rounded border-2" value="Last"></li>
        </ul>
    </nav>

    

    
    
</div>

<script>
    window.addEventListener("load", () => {
        enablePagination("bookings", ".booking");
    });
</script>

<?php
    include './template/footer.html';
?>