<?php
include_once '../debugging.php';
include_once '../models/MenuItem.php';

if (isset($_GET['filter'])) {
    $filter = $_GET['filter'];
    $menuItem = new MenuItem();

    if ($filter == "All-Items") {
        $data = $menuItem->getAllMenuItems();
        displayMenuItems($data);
    } else if ($filter == "Available-Items") {
        $data = $menuItem->getAvailableItems();
        displayMenuItems($data);
    } else if ($filter == "Cancelled-Items") {
        $data = $menuItem->getCancelledItems();
        displayMenuItems($data);
    }
} else {
    echo 'No name parameter provided!';
}

function displayMenuItems($dataSet) {
    if (!empty($dataSet)) {
        for ($i = 0; $i < count($dataSet); $i++) {
            $item = new MenuItem();
            $id = $dataSet[$i]->item_id;
            $item->initWithMenuItemid($id);
            echo '<div class="card serviceCard mb-4 ">
                <div class="card-body p-0">
                    <div class="row m-0">
                        <div class="col-xl-6 p-0">
                        <img src="' . $item->getImagePath() . '" class="d-block w-100 rounded-start" alt="...">
                        </div>
                        <div class="col-xl-6 p-0">
                            <div class="d-flex flex-column h-100 justify-content-between text-center ">
                                <div class="row pt-5">
                                    <div class="col text-center " >
                                        <span class="fw-bold display-6">' . $item->getName() . '</span>
                                            <br>
                                        <span class="badge bg-' . $item->getItemStatusName()->status_name . '">' . $item->getItemStatusName()->status_name . '</span>
                                </div>
                                </div>
                                <div class="row ps-5 pe-5">
                                    <p>' . $item->getDescription() . '</p>
                                </div>
                                <div class="row ps-5 pe-5">
                                    <div class="col text-start">
                                        <h3>' . $item->getPrice() . '</h3>
                                    </div>
                                    <div class="col text-end">
                                        <h3>' . $item->getCateringSerivceName() . '</h3>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="d-flex col w-100">
                                        <button id ="editItemBtn" class="btn btn-primary rounded-0 flex-fill" data-id="' . $item->getItemId() . '" data-bs-toggle="modal" data-bs-target="#addModal"><i class="bi bi-pen-fill">Edit</i> </button>
                                    </div>
                                </div>
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