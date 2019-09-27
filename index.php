<?php

    include_once $_SERVER['DOCUMENT_ROOT'] . '/ims/settings/General.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/ims//php/user/User.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/ims/php/modals/UserModal.php';

    if(!(session_status() === PHP_SESSION_ACTIVE)) {
        session_start();
    }

    if(session_status() === PHP_SESSION_ACTIVE) {
        if(isset($_SESSION['email'])) {
            header("Location: dashboard.php");
        }
    }

    $user = new User();

    if(isset($_POST['sign-in-btn'])) {
        $emailFromUser = $_POST['email-sign-in'];
        $passwordFromUser = $_POST['password-sign-in'];

        $response = $user->login($emailFromUser, $passwordFromUser);
        $message = $user->displayMessage($response, "login");

        if($response['error'] == false) {
            echo "<div class='message'>
        <div class='alert alert-success alert-dismissible inner-message fade show'>
            <button type='button' class='close' data-dismiss='alert'>&times;</button>" .
                $message .
                "</div>
    </div>";

            $_SESSION['email'] = $emailFromUser;
            header("Location: dashboard/dashboard.php");
        } else {
            echo "<div class='message'>
        <div class='alert alert-danger alert-dismissible inner-message fade show'>
            <button type='button' class='close' data-dismiss='alert'>&times;</button>" .
                $message .
                "</div>
    </div>";
        }

    }

    /*
    if(isset($_POST['sign-up-btn'])) {
        $companyName = $_POST['company-name-sign-up'];
        $userFullName = $_POST['name-sign-up'];
        $userEmail = $_POST['email-sign-up'];
        $userPassword = $_POST['password-sign-up'];

        $companyID = strtolower(preg_replace("/[^a-zA-Z]/", "", $companyName));

        $data = array(
            array("Company_ID", $companyID),
            array("User_FullName", $userFullName),
            array("User_Email", $userEmail),
            array("User_Salt", $userPassword),
            array("User_Type", "SUPERVISOR")
        );

        $response = $user->register($data);
        $message = $user->displayMessage($response, "register");

        if($response['error'] == false) {
            echo "<div class='message'>
        <div class='alert alert-success alert-dismissible inner-message fade show'>
            <button type='button' class='close' data-dismiss='alert'>&times;</button>" .
                $message .
                "</div>
    </div>";
        } else {
            echo "<div class='message'>
        <div class='alert alert-danger alert-dismissible inner-message fade show'>
            <button type='button' class='close' data-dismiss='alert'>&times;</button>" .
                $message .
                "</div>
    </div>";
        }
    }
    */


?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <title><?php echo SITE_NAME; ?> | Home</title>

        <!-- CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons" />
        <link rel="stylesheet" href="assets/css/materialize/materialize.min.css" />
        <link rel="stylesheet" href="assets/css/primary-layout.css" />
        <link rel="stylesheet" href="assets/css/primary/login-reg.css" />

    </head>

    <body class="container">
        <div class="row">
            <div class="col-sm-1"></div>
            <div class="col-sm-10">
                <div class="form-container" id="form-container">
                    <div class="inner-container sign-up-container">
                        <!-- Sign Up-->
                        <form action="register-2.php" method="post">
                            <div class="input-field">
                                <i class="material-icons prefix">business</i>
                                <input type="text" name="company-name-sign-up" class="validate" id="company-name-sign-up" />
                                <label for="company-name-sign-up">Company's Name</label>
                            </div>
                            <div class="input-field">
                                <i class="material-icons prefix">person</i>
                                <input type="text" name="name-sign-up" class="validate" id="name-sign-up" />
                                <label for="name-sign-up">Name</label>
                            </div>
                            <div class="input-field">
                                <i class="material-icons prefix">email</i>
                                <input type="email" name="email-sign-up" class="validate" id="email-sign-up" />
                                <label for="email-sign-up">Email Address</label>
                            </div>
                            <div class="input-field">
                                <i class="material-icons prefix">vpn_key</i>
                                <input type="password" name="password-sign-up" class="validate" id="password-sign-up" />
                                <label for="password-sign-up">Password</label>
                            </div>
                            <button class="btn waves-effect waves-light blue lighten-1" type="submit" name="sign-up-btn">Sign up
                                <i class="material-icons right">chevron_right</i>
                            </button>
                            <div class="bottom-text-div">
                                <p class="bottom-text d-block d-sm-none">Already have an account? <a id="signInMobile" href="#">Sign in now!</a></p>
                            </div>
                        </form>
                    </div>
                    <div class="inner-container sign-in-container">
                        <!-- Sign In -->
                        <form action="" method="post">
                            <div class="input-field">
                                <i class="material-icons prefix">email</i>
                                <input type="email" name="email-sign-in" class="validate" id="email-sign-in" />
                                <label for="email-sign-in">Email Address</label>
                            </div>
                            <div class="input-field">
                                <i class="material-icons prefix">vpn_key</i>
                                <input type="password" name="password-sign-in" class="validate" id="password-sign-in" />
                                <label for="password-sign-in">Password</label>
                            </div>
                            <button class="btn waves-effect waves-light blue lighten-1" type="submit" name="sign-in-btn">Sign in
                                <i class="material-icons right">chevron_right</i>
                            </button>
                            <div class="bottom-text-div">
                                <p class="bottom-text d-block d-sm-none">Don't have an account? <a id="signUpMobile" href="#">Create one now!</a></p>
                            </div>
                        </form>

                    </div>
                    <div class="overlay-container d-none d-sm-block">
                        <!-- Overlay -->
                        <div class="overlay">
                            <div class="overlay-panel overlay-left">
                                <h3>Create an account</h3>
                                <p>Start using <?php echo SITE_NAME; ?> and manage your company's inventory.</p>
                                <p>If you already have an account, sign in now!</p>
                                <button class="ghost" id="signIn">Sign In</button>
                            </div>
                            <div class="overlay-panel overlay-right">
                                <h3>Welcome to <?php echo SITE_NAME; ?></h3>
                                <p>Enter your credentials to start managing your company's inventory.</p>
                                <p>If you've not signed up yet, sign up now!</p>
                                <button class="ghost" id="signUp">Sign Up</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-1"></div>
        </div>

        <!-- JavaScript -->
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
        <script src="assets/js/materialize/materialize.min.js"></script>
        <script src="assets/js/login-reg-overlay.js"></script>
    </body>

</html>
