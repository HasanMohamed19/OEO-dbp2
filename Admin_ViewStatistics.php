<?php
/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */

include_once './debugging.php';
include_once './template/header.html';
include_once './models/Hall.php';
include_once './models/Reservation.php';
?>
<div class="container">
    <div class="row">
        <h1>View Statistics</h1>
    </div>
    <div class="row">
        <div class="col-xl-4">
            <div class="card" style="width: 18rem;">
                <img src="..." class="card-img-top" alt="...">
                <div class="card-body">
                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                </div>
            </div>
        </div>
        <div class="col-xl-4">
            <div class="card" style="width: 18rem;">
                <img src="..." class="card-img-top" alt="...">
                <div class="card-body">
                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                </div>
            </div>
        </div>
        <div class="col-xl-4">
            <div class="card" style="width: 18rem;">
                <img src="..." class="card-img-top" alt="...">
                <div class="card-body">
                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-12">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#Hall ID</th>
                        <th scope="col">Hall Name</th>
                        <th scope="col">Total Number of Reservations</th>
                        <th scope="col">Hall Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $hall = new Hall();
                    $allHalls = $hall->getAllHallsWithoutFilter();
                    $reservation = new Reservation();
                    for ($i = 0; $i < count($allHalls); $i++) {
                        echo '<tr>';
                        echo '<th scope="row">'.$allHalls[$i]->hall_id.'</th>';
                        echo'<td>'.$allHalls[$i]->hall_name.'</td>';
                        echo'<td>'.$allHalls[$i]->hall_name.'</td>';
                        $halltotalres = $reservation->getHallReservations($allHalls[$i]->hall_id);
                        echo'<td>'. count($halltotalres).'</td>';
                          echo '</tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php
include './template/footer.html';
