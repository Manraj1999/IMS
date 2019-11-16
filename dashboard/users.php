<?php

    include_once $_SERVER['DOCUMENT_ROOT'] . "/ims/settings/General.php";
    include_once $_SERVER['DOCUMENT_ROOT'] . '/ims/php/UI/Dashboard.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/ims/php/modals/CompanyModal.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/ims/php/dashboard/Company.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . "/ims/php/Armor.php";

    $armor = new Armor();
    $armor->initDashboard();

    $CompanyModal = new CompanyModal();
    $CompanyName = $CompanyModal->getCompanyData("Company_Name");
    $CompanyLocation = $CompanyModal->getCompanyData("Company_Location");
    $CompanySupervisorName = $CompanyModal->getCompanySupervisorData("User_FullName");

?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title><?php echo SITE_NAME; ?> | Users</title>
        <!-- Favicon -->
        <link href="../assets/img/brand/favicon.png" rel="icon" type="image/png">
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
        <!-- Icons -->
        <link href="../assets/js/plugins/nucleo/css/nucleo.css" rel="stylesheet" />
        <link href="../assets/js/plugins/fontawesome-free/css/all.min.css" rel="stylesheet" />
        <!-- CSS Files -->
        <link href="../assets/css/dashboard.css" rel="stylesheet" />
    </head>

    <body class="">
    <!-- Start: Navbar -->
    <?php
    $dashboard = new Dashboard();
    $dashboard->getNavigation(7);
    ?>
    <!-- End: Navbar -->
    <div class="main-content">
        <!-- Start: Header -->
        <?php
        $dashboard->getHeader();
        ?>
        <!-- End: Header -->
        <div class="header bg-gradient-green pb-8 pt-5 pt-md-8">
            <div class="container-fluid">
                <div class="header-body">
                    <div class="row">
                        <div class="col-xl-2 col-lg-2"></div>
                        <div class="col-xl-8 col-lg-8">
                            <div id="message" class="d-flex justify-content-center position-fixed center mt--6" style="visibility: hidden; width: 100%; text-align: center; z-index: 9999;">
                                <div id="inner-msg" class="alert alert-primary">

                                </div>
                            </div>
                            <div class="card card-stats mb-4 mb-xl-0">
                                <div class="card-body">
                                    <div>
                                        <h3 class="text-center text-green">
                                            <i style="margin-right: 8px;" class="fa fa-user"></i> Users
                                            <button name="edit-company" class="edit-3" data-toggle="modal" data-target="#editUsersModal">
                                                <i class="fa fa-pencil-alt fa-align-right text-green"></i>
                                            </button>
                                        </h3>
                                        <div class="row">
                                            <div class="col-xl-3 col-lg-3"></div>
                                            <div class="col-xl-6 col-lg-6 mb-2">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" style="background: var(--green); border-color: var(--green); color: var(--white);" id="search-icon"><i class="fa fa-search"></i></span>
                                                    </div>
                                                    <input type='search' id="search-user" name='search-user' placeholder='Search' class='form-control' style="border-color: var(--green); text-align: center" />
                                                </div>
                                            </div>
                                            <div class="col-xl-3 col-lg-3"></div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-2 col-lg-2"></div>
                    </div>

                    <!-- Modal -->
                    <div class="modal fade" id="editUsersModal" tabindex="-1" role="dialog" aria-labelledby="ModalScrollableTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-scrollable" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="ModalScrollableTitle">Add User</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form name="add_user" id="add_user">
                                        <div class="modal-body">
                                            <div class="form-group row">
                                                <div class="row col-xl-12 col-lg-12 mb-2">
                                                    <input type='text' id="user_fullname" id="user_fullname" name='user_fullname' placeholder='Full Name' class='modal-text form-control' />
                                                </div>
                                                <div class="row col-xl-12 col-lg-12 mb-2">
                                                    <input type='email' name='user_email' id="user_email" placeholder='Email Address' class='modal-text form-control' />
                                                </div>
                                                <div class="row col-xl-12 col-lg-12 mb-2">
                                                    <input type="password" name='user_password' id="user_password" placeholder="Password" class="modal-text form-control"/>
                                                </div>
                                                <div class="row col-xl-12 col-lg-12 mb-2">
                                                    <input type="password" name='user_password_confirm' id="user_password_confirm" placeholder="Confirm Password" class="modal-text form-control"/>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" id="close-add-user" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="button" id="add-user" class="btn btn-primary">Add User</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row mt--7">
                <div class="col-xl-1 col-lg-1"></div>
                <div class="col-xl-10 col-lg-10">
                    <div class="card card-stats mb-4 mb-xl-0">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table text-center">
                                    <thead>
                                    <tr>
                                        <th scope="col">ID</th>
                                        <th scope="col">Full Name</th>
                                        <th scope="col">Email Address</th>
                                        <th scope="col">User Type</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                    </thead>

                                    <tbody id="users-table">
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
                <div class="col-xl-1 col-lg-1"></div>
            </div>
        </div>
    </div>

    <!--   Core   -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.4/umd/popper.min.js"></script>
    <!--   Optional JS   -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.bundle.js"></script>
    <!--   Dashboard JS   -->
    <script src="../assets/js/dashboard.min.js"></script>
    <script src="../assets/js/modal-rows.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            usersModalsJS();

            // START: Get Products and place them in the respective div
            $.get("./users/getUsers.php", function(data) {
                $('#users-table').html(data);
            });
            // END
        });
    </script>
    </body>

</html>