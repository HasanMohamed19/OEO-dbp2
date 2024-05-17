<?php

include_once '../models/User.php';
include_once '../models/Client.php';
include_once '../models/PersonalDetails.php';
include_once '../models/CompanyDetails.php';

include_once '../debugging.php';

if (isset($_GET['filter'])) {
    $client = new Client();
    $dataSet = $client->getAllClients();
    displayClients($dataSet);
} else {
    echo 'No name parameter provided!';
}

function displayClients($dataSet) {
    if (!empty($dataSet)) {
        for ($i = 0; $i < count($dataSet); $i++) {
            $userId = $dataSet[$i]->user_id;
            $clientId = $dataSet[$i]->client_id;

            $user = new User();
            $user->initWithUserid($userId);

            $client = new Client();
            $client->iniwWithClientId($clientId);

            $pd = new PersonalDetails();
            $pd->setClientId($clientId);
            $pd->initWithClientId();

            $cmp = new CompanyDetails();
            $cmp->setClientId($clientId);
            $cmp->initWithClientId();

            echo '<div class="card clientCard mb-4">
                <div class="card-body p-0">
                    <div class="row ">
                        <div class="col-xl-11">
                            <br>
                            <div class="row">
                                <div class="col text-center " >
                                    <span class="fw-bold display-6">@' . $user->getUsername() . '</span>
                                    <span class="badge bg-' . $client->getClientStatusName($clientId)->status_name . '">' . $client->getClientStatusName($clientId)->status_name . '</span>
                                    <br>
                                    <span class="fw-bold">#' . $user->getUserId() . '</span>
                                </div>
                            </div>

                            <div class="row d-flex justify-content-center">
                                <div class="col-xl-5">
                                    <dl class="row d-flex justify-content-center align-items-center">
                                        <dt class="col-xl-5">Full Name:</dt>
                                        <dd class="col-xl-5">' . $pd->getFirstName() . ' ' . $pd->getLastName() . '</dd>

                                        <dt class="col-xl-5">Email:</dt>
                                        <dd class="col-xl-5">' . $user->getEmail() . '</dd>

                                        <dt class="col-xl-5">DOB:</dt>
                                        <dd class="col-xl-5">' . $pd->getDob() . ' </dd>

                                        <dt class="col-xl-5">Nationality:</dt>
                                        <dd class="col-xl-5">' . $pd->getNationality() . '</dd>

                                        <dt class="col-xl-5">Phone Number:</dt>
                                        <dd class="col-xl-5">' . $client->getPhoneNumber() . '</dd>
                                    </dl>  
                                </div>
                                <div class="col-xl-5">
                                    <dl class="row d-flex justify-content-center align-items-center">
                                        <dt class="col-xl-5">Company Name:</dt>
                                        <dd class="col-xl-5">' . $cmp->getName() . '</dd>

                                        <dt class="col-xl-5">Size:</dt>
                                        <dd class="col-xl-5">' . $cmp->getComapnySize() . '</dd>

                                        <dt class="col-xl-5">Webiste:</dt>
                                        <dd class="col-xl-5">' . $cmp->getWebsite() . '</dd>

                                        <dt class="col-xl-5">City:</dt>
                                        <dd class="col-xl-5">' . $cmp->getCity() . '</dd>
                                    </dl>    

                                </div>  
                            </div>

                        </div>
                        <div class="col-xl-1">
                            <div class="d-flex flex-column h-100 justify-content-between">
                                <button id="editClientBtn" class="btn btn-primary flex-fill rounded-0 rounded-top-right" data-bs-toggle="modal" data-bs-target="#addModal" data-id="' . $user->getUserId() . '"><i class="bi bi-pen-fill">Edit</i></button>
                                <button class="btn btn-danger flex-fill rounded-0 rounded-bottom-right" data-bs-toggle="modal" data-bs-target="#deleteModal" data-id="' . $user->getUserId() . '" onclick="setDeleteID(this)"><i class="bi bi-trash3-fill">Delete</i></button>
                                <input type="hidden" id="' . $userId . '" name="clientId" value ="' . $clientId . '">   
                            </div>
                        </div>
                    </div>
                </div>
            </div>';
        }
    }
}
