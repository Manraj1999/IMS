<?php

    include_once $_SERVER['DOCUMENT_ROOT'] . '/ims/settings/General.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/ims//php/user/User.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/ims/php/modals/UserModal.php';

    if(!(session_status() === PHP_SESSION_ACTIVE)) {
        session_start();
    }

    if(session_status() === PHP_SESSION_ACTIVE) {
        if(isset($_SESSION['email'])) {
            header("Location: /IMS/dashboard/dashboard.php");
        }
        if(isset($_SESSION['emailAdmin'])) {
            header("Location: /IMS/admin/index.php");
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

            if($response['admin'] == true) {
                $_SESSION['emailAdmin'] = $emailFromUser;
                header("Location: admin/index.php");
            } else {
                $_SESSION['email'] = $emailFromUser;
                header("Location: dashboard/dashboard.php");
            }
        } else {
            echo "<div class='message'>
        <div class='alert alert-danger alert-dismissible inner-message fade show'>
            <button type='button' class='close' data-dismiss='alert'>&times;</button>" .
                $message .
                "</div>
    </div>";
        }

    }
?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <title><?php echo ORI_SITE_NAME; ?> | Login</title>
        <!-- Favicon -->
        <link href="assets/img/brand/favicon.png" rel="icon" type="image/png">

        <!-- CSS Files -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous" />
        <link rel="stylesheet" href="assets/css/primary-layout.css" />
        <link rel="stylesheet" href="assets/css/primary/reg.css" />
        <link rel="stylesheet" href="assets/css/materialize/materialize.min.css" />
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons" />

    </head>

    <body class="container-fluid">
    <div class="row">
        <div class="col-sm-6">
            <img alt="..." class="responsive-img" src="./assets/img/theme/ss_welcome.png" style="position: fixed; width: 50%;"/>
            <h4 class="fixed-info mt-5">Welcome back.</h4>
            <h6 class="fixed-info">Sign in and get back to where you left off! :)</h6>

            <button onclick="location.href='customer/index.php'" class="btn waves-effect waves-light lighten-1 d-none d-sm-block cust-btn right" type="button" name="back-btn">
                <i class="material-icons right">chevron_right</i>
                Customer
            </button>
        </div>
        <div class="col-sm-1"></div>
        <div class="col-sm-4 bg-white register-form">
            <div class="log-top-container left-0">
                <h5 class="reg-title">Login</h5>
            </div>
            <button onclick="location.href='register.php'" class="btn waves-effect waves-light lighten-1 d-none d-sm-block reg-btn right" type="button" name="back-btn">
                <i class="material-icons right">chevron_right</i>
                Register
            </button>

            <img src="http://manraj.randhawa.my/IMS/assets/ss_welcome_2.png" class="img-header" alt="...">
            <form class="" action="" method="post">
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
                <button class="btn waves-effect waves-light lighten-1 right sign-up-btn" type="submit" name="sign-in-btn">Sign in
                    <i class="material-icons right">chevron_right</i>
                </button>
                <div class="log-bottom-text-div">
                    <p class="bottom-text text-center d-block d-sm-none">Don't have an account yet? <a id="signInMobile" href="register.php">Sign up now!</a></p>
                </div>
            </form>
        </div>
        <div class="col-sm-1"></div>
    </div>

    <!--   Core   -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/materialize/materialize.min.js"></script>
    <script>
        $(document).ready(function() {
            setTimeout(function() {
                $(".alert").alert('close');
            }, 1500);
        });
    </script>
    </body>

</html>
