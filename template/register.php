<?php
    include './helpers/Database.php'
    echo 'hello,';
    if (isset($_POST['submitted'])) {
        $user = new User();
        $user->setEmail($_POST['email']);
        $user->setUsername($_POST['username']);
        $user->setPassword($_POST['password']);

        if ($user->initWithUsername()) {

            if ($user->registerUser())
                echo 'Registerd Successfully';
            else
                echo '<p class="error"> Not Successfull </p>';
        }else {
            echo '<p class="error"> Username Already Exists </p>';
        }
    }
?>


<!DOCTYPE html>
<html lang="en">

<head>

    <style>
       .form-control {
        margin-bottom: 1rem;
    }
    #regBtn {
        margin-bottom: 1rem;
        margin-top: 1rem;
    }
    .bg-login-image {
        background-color: gray;
    }
    </style>
</head>

<body>

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
                                        <h1 class="h1 text-gray-900 mb-4">Create Account</h1>
                                    </div>
                                    <form class="user account-form" action="register.php" method="post">
                                        <input type="text" class="form-control form-control-user" id="username" placeholder="Username" name="username" value="<?php echo $_POST['username']?>">
                                        <input type="password" class="form-control form-control-user" id="pass" placeholder="Password" name="password">
                                        <input type="email" class="form-control form-control-user" id="email" placeholder="Email" name="email">
                                        <div class="text-center">
                                            <button type="submit" class="btn btn-primary" id="regBtn">Register</button>
                                            <input type="hidden" name="submitted" value="1" />
                                        </div>
                                    </form>
                                    <div class="text-center">
                                        <p>Already have an account? <a class="btn-link" href="./login.php">Login</a></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

</body>

</html>
