<?php

    include './template/header.html';
        
        echo '<h1>Bookings</h1>';
        echo '<div class="container">
                
                <div class="form-outline mt-5 mb-5" data-mdb-input-init>
                        <input type="search" id="form1" class="form-control" placeholder="Search" aria-label="Search"/>
                        <!-- <button type="submit" class="btn btn-primary">Search</button> -->
                </div>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered border-5 align-middle text-center rounded rounded-2">
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
                            <tr>
                                <td scope="row">Jan 1, 2025</td>
                                <td>Pending</td>
                                <td>800 BHD</td>
                                <td>#093284EF0-3</td>
                                <td>Hall Name</td>
                                <td>Mohamed</td>
                            </tr>
                            
                            <tr>
                                <td scope="row">Jan 1, 2025</td>
                                <td>Pending</td>
                                <td>800 BHD</td>
                                <td>#093284EF0-3</td>
                                <td>Hall Name</td>
                                <td>Mohamed</td>
                            </tr>
                            
                            <tr>
                                <td scope="row">Jan 1, 2025</td>
                                <td>Pending</td>
                                <td>800 BHD</td>
                                <td>#093284EF0-3</td>
                                <td>Hall Name</td>
                                <td>Mohamed</td>
                            </tr>

                            <tr>
                                <td scope="row">Jan 1, 2025</td>
                                <td>Pending</td>
                                <td>800 BHD</td>
                                <td>#093284EF0-3</td>
                                <td>Hall Name</td>
                                <td>Mohamed</td>
                            </tr>

                            <tr>
                                <td scope="row">Jan 1, 2025</td>
                                <td>Pending</td>
                                <td>800 BHD</td>
                                <td>#093284EF0-3</td>
                                <td>Hall Name</td>
                                <td>Husain</td>
                            </tr>

                            <tr>
                                <td scope="row">Jan 1, 2025</td>
                                <td>Pending</td>
                                <td>800 BHD</td>
                                <td>#093284EF0-3</td>
                                <td>Hall Name</td>
                                <td>Mohamed</td>
                            </tr>

                            <tr>
                                <td scope="row">Jan 1, 2025</td>
                                <td>Pending</td>
                                <td>800 BHD</td>
                                <td>#093284EF0-3</td>
                                <td>Hall Name</td>
                                <td>Ali</td>
                            </tr>
                            
                        </tbody>

                    </table>
                </div>
            
            <!-- this needs to be created programmitcally -->
            <nav aria-label="Page navigation example">
                <ul class="pagination d-flex flex-row">
                    <p>Page: </p>
                    <li class="page-item disabled"><a class="page-link mx-2 rounded border-2" href="#">First</a></li>
                    <li class="page-item active"><a class="page-link ms-2 rounded border-2" href="#">1</a></li>
                    <li class="page-item"><a class="page-link ms-2 rounded border-2" href="#">2</a></li>
                    <li class="page-item"><a class="page-link ms-2 rounded border-2" href="#">3</a></li>
                    <li class="page-item"><a class="page-link mx-2 rounded border-2" href="#">Last</a></li>
                </ul>
            </nav>
        </div>';
    
    include './template/footer.html';

?>