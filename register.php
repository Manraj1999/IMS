<?php

include_once $_SERVER['DOCUMENT_ROOT'] . '/ims/settings/General.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/ims/php/user/User.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/ims/php/user/Tools.php';

if(!(session_status() === PHP_SESSION_ACTIVE)) {
    session_start();
}

if(session_status() === PHP_SESSION_ACTIVE) {
    if(isset($_SESSION['email'])) {
        header("Location: /IMS/dashboard/dashboard.php");
    } else {
        // Register User
        if (isset($_POST['sign-up-btn-reg'])) {
            $companyName = $_POST['company-name-sign-up'];
            $userFullName = $_POST['name-sign-up'];
            $userEmail = $_POST['email-sign-up'];
            $userPassword = $_POST['password-sign-up'];
            $userPasswordConfirm = $_POST['confirm-password-sign-up'];
            $invType = $_POST['inventory-type'];

            $companyID = strtolower(preg_replace("/[^a-zA-Z]/", "", $companyName));

            $error = false;
            $errorMsg = "";
            if (empty($companyName)) {
                $error = true;
                $errorMsg .= "The 'Company Name' field is empty<br/>";
            }
            if (empty($userFullName)) {
                $error = true;
                $errorMsg .= "The 'Full Name' field is empty<br/>";
            }
            if (empty($userEmail)) {
                $error = true;
                $errorMsg .= "The 'Email' field is empty<br/>";
            }
            if (empty($userPassword)) {
                $error = true;
                $errorMsg .= "The 'Password' field is empty<br/>";
            }
            if (empty($userPasswordConfirm)) {
                $error = true;
                $errorMsg .= "The 'Confirm Password' field is empty<br/>";
            }
            if (empty($invType)) {
                $error = true;
                $errorMsg .= "The 'Inventory Type' field is not selected<br/>";
            }
            if ($error == true) {
                $tools = new Tools();
                $tools->sendErrorMessage($errorMsg);
            } else {
                if ($userPassword !== $userPasswordConfirm) {
                    echo "<div class='message'>
        <div class='alert alert-danger alert-dismissible inner-message fade show'>
            <button type='button' class='close' data-dismiss='alert'>&times;</button>The passwords do not match!</div></div>";
                } else {
                    $data = array(
                        array("Company_ID", $companyID),
                        array("Company_Name", $companyName),
                        array("Supervisor_Name", $userFullName),
                        array("Email_Address", $userEmail),
                        array("Password_Salt", $userPassword),
                        array("Status", "NOT-APPROVED")
                    );

                    /*
                    $data = array(
                            array("Company_ID", $companyID),
                            array("User_FullName", $userFullName),
                            array("User_Email", $userEmail),
                            array("User_Salt", $userPassword),
                            array("User_Type", "SUPERVISOR")
                    );
                    */

                    $user = new User();

                    $response = $user->addToQueue($data);
                    $message = $user->displayMessage($response, "register");

                    if ($response['error'] == false) {
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
            }
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <title><?php echo ORI_SITE_NAME; ?> | Register</title>
        <!-- Favicon -->
        <link href="../assets/img/brand/favicon.png" rel="icon" type="image/png">

        <!-- CSS Files -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous" />
        <link rel="stylesheet" href="assets/css/primary-layout.css" />
        <link rel="stylesheet" href="assets/css/primary/reg.css" />
        <link rel="stylesheet" href="assets/css/materialize/materialize.css" />
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons" />
    </head>

    <body class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <img alt="..." class="responsive-img" src="./assets/img/theme/ss_welcome.png" style="position: fixed; width: 50%;"/>
                <h4 class="fixed-info">We'll get you sorted as soon as you're done creating your account</h4>
            </div>
            <div class="col-sm-1"></div>
            <div class="col-sm-4 bg-white register-form">
                <div class="reg-top-container left-0 ">
                    <h5 class="reg-title">Register</h5>
                </div>
                <button onclick="location.href='index.php'" class="btn waves-effect waves-light lighten-1 d-none d-sm-block back" type="button" name="back-btn">
                    <i class="material-icons left">chevron_left</i>
                    Back
                </button>

                <img src="http://manraj.randhawa.my/IMS/assets/ss_welcome_2.png" class="img-header" alt="...">
                <form class="" action="" method="post">
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
                    <div class="input-field">
                        <i class="material-icons prefix">vpn_key</i>
                        <input type="password" name="confirm-password-sign-up" class="validate" id="confirm-password-sign-up" />
                        <label for="confirm-password-sign-up">Confirm Password</label>
                    </div>
                    <hr/>
                    <div class="row row-divider-1 text-center">
                        <h5 class="subtitle">Choose an Inventory System</h5>
                        <div class="col-xl-12 col-lg-12 mb-2">
                            <label>
                                <input type="radio" name="inventory-type" class="card-input-element d-none" value="STOCK" checked>
                                <div class="card card-body d-flex flex-row justify-content-between align-items-center" data-toggle="tooltip" data-placement="right" title="Stock Inventory System includes a management system for Users, Products (with Categories), Stores"> Stock </div>
                            </label>
                            <h7 class="text-purple">*More inventory systems will be added in the future*</h7>
                        </div>
                    </div>
                    <button class="btn waves-effect waves-light lighten-1 right sign-up-btn" type="submit" name="sign-up-btn-reg">Sign up
                        <i class="material-icons right">chevron_right</i>
                    </button>
                    <div class="bottom-text-div">
                        <p class="bottom-text text-center d-block d-sm-none">Already have an account? <a id="signInMobile" href="index.php">Sign in now!</a></p>
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