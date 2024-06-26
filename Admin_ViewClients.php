<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */
include './debugging.php';
include './helpers/Database.php';
include './models/User.php';
include './models/Client.php';
include './models/PersonalDetails.php';
include './models/CompanyDetails.php';
include_once './models/Pagination.php';
include_once 'header.php';

// assuming admin id is always 1
if ($_COOKIE['userId'] != 1) {
    header("Location: PageNotFound.html");
}
//check if Add/Edit Client Form is submitted
if (isset($_POST['clientFormSubmitted'])) {
//initialze a new User object
    $userid = trim($_POST['Add-UserID']);
    $user = new User();

//assign object values using set methods of user class
    $user->setUserId($userid);
    $user->setUsername(trim($_POST['usrName']));
    $user->setPassword(trim($_POST['pwd']));
    $user->setRoleId(ROLE_CLIENT);
    $user->setEmail(trim($_POST['email']));

    //get personal details and assign them to a new personal details object
    $pd = new PersonalDetails();
    $pd->setFirstName(trim($_POST['fName']));
    $pd->setLastName(trim($_POST['lName']));
    $pd->setGender(trim($_POST['gender']));
    $pd->setNationality(trim($_POST['nation']));
    $pd->setDob(trim($_POST['dob']));

    //get company details and assign them to a new company details object
    $cmp = new CompanyDetails();
    $cmp->setName(trim($_POST['cmpName']));
    $cmp->setComapnySize(trim($_POST['cmpSize']));
    $cmp->setWebsite(trim($_POST['cmpWeb']));
    $cmp->setCity(trim($_POST['cmpcity']));
    $db = Database::getInstance();

    
    if ($userid == '') {//if user id is empty (New user) add the user
        if ($user->initWithUsername()) {//check if username exists
            if ($user->addUser()) {
//                echo'user after register is' . $user->getUserId();
                if (isset($_POST['pdCheckBx'])) {//check if the user filled personal details form
                    $pd->setClientId($user->getClientByUserId());
                    $pd->addPersonalDetails();
                }
                if (isset($_POST['cmpCheckBx'])) {//check if the user filled company details form
                    $cmp->setClientId($user->getClientByUserId());
                    $cmp->addCompanyDetails();
                }
                //display successful message to the user
                echo '<br><div class="container"><div class="alert alert-success alert-dismissible fade show" role="alert"> The Client has been Added Sucessfullly!<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div></div>';
            } else {
                //display error messae to the user
                echo '<br><div class="container"><div class="alert alert-danger alert-dismissible fade show" role="alert">Error: Client has not been Added<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div></div>';
            }
        } else {
            //display error messae to the user
            echo '<br><div class="container"><div class="alert alert-danger alert-dismissible fade show" role="alert">Error: Username Already Exists<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div></div>';
        }
    } else {
        //update user when user id is not empty
        $user->editUser($userid);
        $clientId = $user->getClientByUserId();
        $client = new Client();
        $client->setClientId($clientId);
        $client->setPhoneNumber($_POST['phoneNumber']);
        $client->updateClient($clientId);

        if (isset($_POST['pdCheckBx'])) {//check if the user filled personal details form
            $pd->setClientId($clientId);
            if ($pd->getPersonalDetail()) {
                $pd->updatePersonalDetails();
            } else {
                $pd->addPersonalDetails();
            }
        } else {
            $pd->setClientId($clientId);
            if ($pd->getPersonalDetail()) {
                PersonalDetails::deletePersonalDetail($clientId);
            }
        }
        if (isset($_POST['cmpCheckBx'])) {//check if the user filled company details form
            $cmp->setClientId($clientId);
            if ($cmp->getCompanyDetail()) {
                $cmp->updateCompanyDetails();
            } else {
                $cmp->addCompanyDetails();
            }
        } else {
            $cmp->setClientId($clientId);
            if ($cmp->getCompanyDetail()) {
                CompanyDetails::deleteCompanyDetail($clientId);
            }
            
        }
    }
}
//check if delete client form is submitted
if (isset($_POST['deleteClientSubmitted'])) {
    $userID = trim($_POST['userId']);
    $deletedUser = new User();
    $deletedUser->initWithUserid($userID);
    if ($deletedUser->deleteUser()) {
        echo '<br><div class="container"><div class="alert alert-success alert-dismissible fade show" role="alert"> The Client has been deleted Sucessfullly!<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div></div>';
    }
}
include './template/admin/DisplayClients.php';

if (isset($_GET['pageno']))
    $start = $_GET['pageno'];
else
    $start = 1;

$end = 10;
//show all users by defualt
$filter = (isset($_GET['filter'])) ? $_GET['filter'] : 'all';

$client = new Client();
$data = $client->getAllClients($start, $end);
echo '<div class="container">';
displayClients($data);

//create a new pagination and set the total number of clients
$pagination = new Pagination();
$pagination->setTotal_records(Client::countAllClients());
$pagination->setLimit($end);
$pagination->page($filter);
echo '</div>';

include './template/footer.html';

// a function to display clients using cards
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
?>

<script type="text/javascript">
    $(document).ready(function () {
        $('#clients').addClass('active-page');
    });
</script>