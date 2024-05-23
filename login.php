<?php
 include 'debugging.php';
 include './helpers/Database.php';
include './models/User.php';
include './models/Login.php';

if (!empty($_COOKIE['userId'])) {
    header('Location: displayMyAccount.php');
}

if (isset($_POST['submitted'])) {
    $db = new Database();
    $login = new Login();
    $username = $_POST['username'];
    $password = $_POST['password'];


     if ($login->login($username, $password)) {
         if ($username == 'admin') {
             header("Location: Admin_ViewHalls.php");
         } else {
             header("Location: displayMyAccount.php");
         }
     } else {
         $errorMessage = 'Incorrect Login Credentials.';
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
                                        <h1 class="h1 text-gray-900 mb-4">Login</h1>
                                    </div>
                                    <form class="user account-form" action="login.php" method="post">
                                        <input type="text" maxlength="20" class="form-control form-control-user" id="username" placeholder="Username" name="username" value="<?php echo $_POST['username'] ?>">
                                        <input type="password" maxlength="30" class="form-control form-control-user mb-2" id="password" placeholder="Password" name="password" value="<?php echo $_POST['password'] ?>">
                                        <div class="row">
                                                <div class="col-md-6 text-right">
                                                    <a class="btn btn-link" href="verifyCode.php">Forgot Password?</a>
                                                </div>
                                            </div>
                                        <div class="text-center my-2">
                                            <!-- <button type="submit" class="btn btn-primary" id="loginBtn">Login</button> -->
                                            <button type="submit" class="btn btn-primary" id="loginBtn">Login</button>
                                            <input type="hidden" name="submitted" value="1" />
                                        </div>
                                    </form>
                                    <div class="text-center">
                                        <p>Don't have an account? <a class="btn-link" href="./register.php">Sign Up</a></p>
                                    </div>
                                    <?php
                                    if ($errorMessage) {
                                echo '<div id="errorBox" class="text-center text-danger">
                                        '.$errorMessage.'
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

