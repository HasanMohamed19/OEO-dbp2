<?php
session_start();
include_once 'debugging.php';
include_once './models/User.php';
// send verification code via email to client
// validate the code to allow changing password
function sendEmail() {

    if (!isset($_POST['sentCode'])) {
        return;
    }
    // send random 6 digit code via email
    $user = new User();
    $user->setUsername($_POST['username']);
    if (!$user->createWithUsername()) {
        // if no user with this username is found, show error
        return 'Username '.$user->getUsername().' not found.';
    }
    $email = $user->getEmail();
//    $verificationCode = random_int(123410, 996540);
    $verificationCode = 123457;
    $_SESSION['verifyCode'] = $verificationCode;
    // send email here

    //
    
}

$errorMessage = sendEmail();
if ($_GET['incorrect'] == 1) {
    $errorMessage = 'Incorrect code.';
}

include 'header.php';
?>
<div class="main">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-12 col-md-9">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block bg-login-image rounded-start"></div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h1 text-gray-900 mb-4">Forget Password</h1>
                                    </div>
                                    <form class="user account-form" action="verifyCode.php" method="post">
                                        <p>A verification code will be sent to you via email.</p>
                                        <div class="row">
                                            <div class="col">
                                                <input type="text" class="form-control form-control-user" id="username" placeholder="Username" name="username" value="<?php echo $_POST['username'] ?>">
                                            </div>
                                            <div class="col-auto">
                                                <div class="text-center">
                                                    <!-- <button type="submit" class="btn btn-primary" id="loginBtn">Login</button> -->
                                                    <button type="submit" class="btn btn-primary" id="loginBtn">Send Code</button>
                                                    <input type="hidden" name="sentCode" value="1" />
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <?php
                                    if (isset($_POST['sentCode']) && !$errorMessage) {
                                echo '<form class="user account-form" action="forgetPassword.php" method="post">
                                        <input type="text" class="form-control form-control-user" id="code" placeholder="Verification Code" name="code">
                                        <div class="text-center">
                                            <button type="submit" class="btn btn-primary" id="loginBtn">Verify</button>
                                            <input type="hidden" name="verifyCode" value="1" />
                                        </div>
                                    </form>';
                                    }
                                    ?>
                                    <div class="text-center">
                                        <p>Don't have an account? <a class="btn-link" href="./register.php">Sign Up</a></p>
                                    </div>
                                    <?php
                                    if ($errorMessage) {
                                        echo '<div id="errorBox">
                                                    <p class="text-danger">'.$errorMessage.'</p>
                                                </div>';
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include './template/footer.html';