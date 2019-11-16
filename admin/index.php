<?php

    include_once $_SERVER['DOCUMENT_ROOT'] . '/ims/settings/General.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/ims/php/modals/UserModal.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/ims/php/user/User.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/ims/php/user/Tools.php';

    $UserModal = new UserModal();

    if(!(session_status() === PHP_SESSION_ACTIVE)) {
        session_start();
    }

    if(session_status() === PHP_SESSION_ACTIVE) {
        if(!(isset($_SESSION['emailAdmin']))) {
            header("Location: /IMS/index.php");
        }
    }

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
            <div class="col-sm-2"></div>
            <div class="col-sm-8">
                <div id="message" class="d-flex justify-content-center position-fixed center mt-6" style="visibility: hidden; width: 100%; text-align: center; z-index: 9999;">
                    <div id="inner-msg" class="alert alert-primary">

                    </div>
                </div>
            </div>
            <div class="col-sm-2"></div>
        </div>
        <div class="row">
            <div class="col-sm-2"></div>
            <div class="col-sm-8 mt-4 mb-2">
                <h2 class="text-center"><span class="bg-primary p-2 rounded text-white"><?php echo ORI_SITE_NAME; ?>'s Admin Dashboard</span></h2>
                <hr/>
            </div>
            <div class="col-sm-2 mt-3">
                <a href="../dashboard/logout.php"><button class="btn btn-outline-primary hover-primary float-md-right">Logout <i class="fa fa-sign-out-alt"></i></button></a>
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
                            <table class="table text-center mt-3 mb-4">
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
                            <table class="table text-center mt-3 mb-5">
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

                <!-- Update Modal -->
                <div class="modal fade" id="updatePassword" tabindex="-1" role="dialog" aria-labelledby="ModalScrollableTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="ModalScrollableTitle">Change Password</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form name="update_password" id="update_password">
                                    <div class="form-group row">
                                        <div class="col-xl-6 col-lg-6 mb-2">
                                            <input type='password' id="user_pswd" name='user_pswd' placeholder='Enter the new password' class='modal-text form-control' />
                                        </div>
                                        <div class="col-xl-6 col-lg-6 mb-2">
                                            <input type='password' id="user_pswd_confirm" name='user_pswd_confirm' placeholder='Re-enter the new password' class='modal-text form-control' />
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" id="close-btn-update-pass" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="button" id="save-update-pass" class="btn btn-primary">Change Password</button>
                            </div>
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