<?php

    include_once $_SERVER['DOCUMENT_ROOT'] . '/ims/settings/General.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/ims/php/modals/UserModal.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/ims/php/user/User.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/ims/php/user/Tools.php';

    $UserModal = new UserModal();

    if(!(session_status() === PHP_SESSION_ACTIVE)) {
        session_start();
    }

    /*
    if(session_status() === PHP_SESSION_ACTIVE) {
        if(!(isset($_SESSION['email']))) {
            header("Location: /IMS/dashboard/dashboard.php");
        } else {
            $getUserType = $UserModal->getUserData("User_Type");
            if(!($getUserType == "ADMINISTRATOR")) {
                header("Location: /IMS/dashboard/dashboard.php");
            } else {

            }
        }
    }
    */

?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <title><?php echo ORI_SITE_NAME; ?> | Admin</title>
        <!-- Favicon -->
        <link href="../assets/img/brand/favicon.png" rel="icon" type="image/png">
        <!-- CSS Files -->
        <link href="../assets/css/dashboard.css" rel="stylesheet" />
        <link rel="stylesheet" href="../assets/css/primary-layout.css" />
        <link rel="stylesheet" href="../assets/css/primary/reg.css" />
        <link href="../assets/js/plugins/fontawesome-free/css/all.min.css" rel="stylesheet" />
    </head>

    <body class="container-fluid">
        <div class="row">

            <div class="col-sm-12">
                <div id="message" style="visibility: visible; text-align: center;">
                    <div class="show-msg">
                        <div id="inner-msg" class="alert alert-primary">

                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-2"></div>
            <div class="col-sm-8 mt-4 mb-2">
                <h2 class="text-center"><span class="bg-primary p-2 rounded text-white">Administrator Lounge</span></h2>
                <hr/>
            </div>
            <div class="col-sm-2 mt-3">
                <button class="btn btn-outline-primary hover-primary float-md-right">Logout <i class="fa fa-sign-out-alt"></i></button>
            </div>
        </div>
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <div class="card border-0">
                    <div class="card-header bg-gradient-white">
                        <h4 class="text-center mt-0 mb-3 text-white">
                            <span class="bg-danger p-2 rounded">Queue List</span>
                        </h4>
                        <div class="table-responsive">
                            <table class="table text-center">
                                <thead>
                                <tr>
                                    <th scope="col" class="text-center">Company Name</th>
                                    <th scope="col" class="text-center">Supervisor</th>
                                    <th scope="col" class="text-center">Email Address</th>
                                    <th scope="col" class="text-center">Status</th>
                                    <th scope="col" class="text-center">Action</th>
                                </tr>
                                </thead>

                                <tbody id="queue-table">
                                    <!-- Using JavaScript to call data -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-body" style="background-color: #f5f4f3;"><hr class="m-3"/></div>
                    <div class="card-footer">
                        <h4 class="text-center mt-0 mb-3 text-white">
                            <span class="bg-success p-2 rounded">Company List</span>
                        </h4>
                        <div class="table-responsive">
                            <table class="table text-center">
                                <thead>
                                <tr>
                                    <th scope="col" class="text-center">Company Name</th>
                                    <th scope="col" class="text-center">Supervisor</th>
                                    <th scope="col" class="text-center">Email Address</th>
                                    <th scope="col" class="text-center">Status</th>
                                    <th scope="col" class="text-center">Action</th>
                                </tr>
                                </thead>

                                <tbody id="list-table">
                                    <!-- Using JavaScript to call data -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-2"></div>
        </div>

        <!--   Core   -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
        <script src="../assets/js/dashboard.min.js"></script>
        <script src="../assets/js/modal-rows.js"></script>
        <script>
            $(document).ready(function() {
                adminModalsJS();
                // START: Get Products and place them in the respective div
                $.get("./functions/getQueueList.php", function (data) {
                    $('#queue-table').html(data);
                });

                $.get("./functions/getCompanyList.php", function (data) {
                    $('#list-table').html(data);
                });
                // END
            });
        </script>
    </body>
</html>