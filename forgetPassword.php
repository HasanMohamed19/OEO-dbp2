<?php
session_start();

include_once './debugging.php';
include_once './models/User.php';

if (isset($_POST['submitted'])) {
    $user = new User();
    $user->setUsername($_POST['username']);
    if (!$user->createWithUsername()) {
        $errorMessage = 'Update failed.';
    } else {
        $user->setPassword($_POST['password']);
        if (!$user->updateUser($user->getUserId())) {
            // update failed
            $errorMessage = 'Update failed.';
        } else {
            header('Location: ./login.php');
        }
    }
} else {
    $verifyCode = isset($_POST['verifyCode']);

    if (!$verifyCode) {
        header('Location: ./verifyCode.php?incorrect=1');
        exit();
    }

    $correctCode = $_SESSION['verifyCode'];
    //echo 'Input code is '.$_POST['code'];
    //echo ' Correct code is '.$correctCode;
    if ($_POST['code'] != $correctCode) {
        header('Location: ./verifyCode.php?incorrect=1');
        exit();
    }
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
                                    <form class="user account-form" action="forgetPassword.php" method="post">
                                        <input type="text" class="form-control form-control-user" id="password" placeholder="New Password" name="password">
                                        <div class="text-center">
                                            <!-- <button type="submit" class="btn btn-primary" id="loginBtn">Login</button> -->
                                            <button type="submit" class="btn btn-primary" id="passBtn">Change Password</button>
                                            <input type="hidden" name="submitted" value="1" />
                                            <input type="hidden" name="username" value="<?php echo $_POST['username'] ?>" />
                                        </div>
                                    </form>
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
