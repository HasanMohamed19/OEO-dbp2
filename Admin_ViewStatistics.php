<?php
/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */

include_once './debugging.php';
include_once './template/header.html';
include_once './models/Hall.php';
include_once './models/Reservation.php';
include_once './models/ReservationMenuItem.php';
include_once './models/Client.php';
include_once './helpers/Database.php';
?>
<div class="container">
    <div class="row p-3">
        <h1>View Statistics</h1>
    </div>
    <div class="row p-5">
        <div class="col-xl-4">
            <div class="card">
                <div class="card-body text-center">
                    <h4>Most Reserved Hall</h4>
                    <?php
                    $rsrvIhall = new Hall();
                    $bestHall = $rsrvIhall->getBestHall();
                    echo'<h6>#' . $bestHall->hall_id . '</h6>';
                    echo'<h6>' . $bestHall->hall_name . '</h6>';
                    ?>
                </div>
            </div>
        </div>
        <div class="col-xl-4">
            <div class="card">
                <div class="card-body text-center">
                    <h4>Best Seller In Menu Items</h4>
                    <?php
                    $rsrvItem = new ReservationMenuItem();
                    $bestItem = $rsrvItem->getBestSellerItem();
                    echo'<h6>#' . $bestItem->item_id . '</h6>';
                    echo'<h6>' . $bestItem->name . '</h6>';
                    ?>

                </div>
            </div>
        </div>
                <div class="col-xl-4">
            <div class="card">
                <div class="card-body text-center">
                    <h4>Most Client Made Reservations</h4>
                    <?php
                    $rsrvClient = new Client();
                    $bestClient = $rsrvClient->getBestClient();
                    echo'<h6>#' . $bestClient->user_id . '</h6>';
                    echo'<h6>@' . $bestClient->username . '</h6>';
                    ?>

                </div>
            </div>
        </div>
    </div>

    <div class="row p-5">
        <div class="col-xl-12">
            <h3>Total number of Reservations Per Hall</h3>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#Hall ID</th>
                        <th scope="col">Hall Name</th>
                        <th scope="col">Total Number of Reservations</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $hall = new Hall();
                    $allHalls = $hall->getAllHallsWithoutFilter();
                    $reservation = new Reservation();
                    for ($i = 0; $i < count($allHalls); $i++) {
                        echo '<tr>';
                        echo '<th scope="row">' . $allHalls[$i]->hall_id . '</th>';
                        echo'<td>' . $allHalls[$i]->hall_name . '</td>';
                        $halltotalres = $reservation->getHallReservations($allHalls[$i]->hall_id);
                        echo'<td>' . count($halltotalres) . '</td>';
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
