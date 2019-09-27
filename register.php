<?php

    include 'settings/General.php';

    if(!(session_status() === PHP_SESSION_ACTIVE)) {
        session_start();
    }

    if(session_status() === PHP_SESSION_ACTIVE) {
        if(!(isset($_POST['company-name-sign-up'])) ||
            !(isset($_POST['name-sign-up'])) ||
            !(isset($_POST['email-sign-up'])) ||
            !(isset($_POST['password-sign-up']))) {
            header("Location: index.php");
        } else {
            // Register User
            echo 'Something.';
        }
    }

?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <title><?php echo SITE_NAME; ?> | Register</title>

        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- CSS Files -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous" />
        <link rel="stylesheet" href="assets/css/primary-layout.css" />
        <link rel="stylesheet" href="assets/css/primary/reg.css" />
        <link rel="stylesheet" href="assets/css/materialize/materialize.min.css" />
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons" />
    </head>

    <body class="container-fluid reg-body">
        <div class="row">
            <div class="col-sm-3"></div>
            <div class="col-sm-6 bg-white register-form">
                <button onclick="location.href='index.php'" class="btn waves-effect waves-light blue lighten-1 d-none d-sm-block back" type="button" name="back-btn">
                    <i class="material-icons left">chevron_left</i>
                    Back
                </button>
                <img src="http://manraj.randhawa.my/IMS/assets/ss_welcome_2.png" class="img-header" alt="...">
                <form class="" action="" method="post">
                    <div class="input-field">
                        <i class="material-icons prefix">business</i>
                        <input type="text" name="company-name-sign-up" class="validate" id="company-name-sign-up" value="<?php echo $_POST['company-name-sign-up']; ?>" />
                        <label for="company-name-sign-up">Company's Name</label>
                    </div>
                    <div class="input-field">
                        <i class="material-icons prefix">person</i>
                        <input type="text" name="name-sign-up" class="validate" id="name-sign-up" value="<?php echo $_POST['name-sign-up']; ?>" />
                        <label for="name-sign-up">Name</label>
                    </div>
                    <div class="input-field">
                        <i class="material-icons prefix">email</i>
                        <input type="email" name="email-sign-up" class="validate" id="email-sign-up" value="<?php echo $_POST['email-sign-up']; ?>" />
                        <label for="email-sign-up">Email Address</label>
                    </div>
                    <div class="input-field">
                        <i class="material-icons prefix">vpn_key</i>
                        <input type="password" name="password-sign-up" class="validate" id="password-sign-up" value="<?php echo $_POST['password-sign-up']; ?>" />
                        <label for="password-sign-up">Password</label>
                    </div>
                    <div class="input-field">
                        <i class="material-icons prefix">vpn_key</i>
                        <input type="password" name="confirm-password-sign-up" class="validate" id="confirm-password-sign-up" />
                        <label for="confirm-password-sign-up">Confirm Password</label>
                    </div>
                    <hr/>
                    <div class="row row-divider-1 text-center">
                    <h5 class="subtitle">Choose an Inventory System</h5>
                        <div class="col-xl-2 col-lg-3">
                            <label>
                                <input type="radio" name="organization" class="card-input-element d-none" id="inv-1">
                                <div class="card card-body d-flex flex-row justify-content-between align-items-center" data-toggle="tooltip" data-placement="right" title="Stock & Inventory System includes a management system for Users, Products (with Categories), Stores"> Stock & Inventory </div>
                            </label>
                        </div>
                        <div class="col-xl-12 col-lg-12">
                            <label>
                                <input type="radio" name="organization" class="card-input-element d-none" id="inv-2">
                                <div class="card card-body d-flex flex-row justify-content-between align-items-center" data-toggle="tooltip" data-placement="right" title="Medical Inventory System includes a management system for Staff, Medicine (with Categories), Patients."> Medical </div>
                            </label>
                        </div>
                        <div class="col-xl-12 col-lg-12">
                            <label>
                                <input type="radio" name="organization" class="card-input-element d-none" id="inv-2">
                                <div class="card card-body d-flex flex-row justify-content-between align-items-center" data-toggle="tooltip" data-placement="right" title="Medical Inventory System includes a management system for Staff, Medicine (with Categories), Patients."> Medical </div>
                            </label>
                        </div>
                    </div>
                    <button class="btn waves-effect waves-light blue lighten-1 right sign-up-btn" type="submit" name="sign-up-btn">Sign up
                        <i class="material-icons right">chevron_right</i>
                    </button>
                </form>
                <div class="bottom-text-div">
                    <p class="bottom-text text-center d-block d-sm-none">Already have an account? <a id="signInMobile" href="index.php">Sign in now!</a></p>
                </div>
            </div>
            <div class="col-sm-3"></div>
        </div>

        <!--   Core   -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
        <script src="assets/js/materialize/materialize.min.js"></script>
    </body>
</html>