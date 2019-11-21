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
        <title><?php echo SITE_NAME; ?> | Orders</title>
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
    $dashboard->getNavigation(6);
    ?>
    <!-- End: Navbar -->
    <div class="main-content">
        <!-- Start: Header -->
        <?php
        $dashboard->getHeader();
        ?>
        <!-- End: Header -->
        <div class="header bg-gradient-purple-blue pb-8 pt-5 pt-md-8">
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
                                        <h3 class="text-center text-info">
                                            <i style="margin-right: 8px;" class="fa fa-shopping-cart"></i> Orders
                                        </h3>
                                        <div class="row">
                                            <div class="col-xl-3 col-lg-3"></div>
                                            <div class="col-xl-6 col-lg-6 mb-2">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" style="background: var(--info); border-color: var(--info); color: var(--white);" id="search-icon"><i class="fa fa-search"></i></span>
                                                    </div>
                                                    <input type='search' id="search-orders" name='search-orders' placeholder='Search' class='form-control' style="border-color: var(--info); text-align: center" />
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
                                        <th scope="col">Product Name</th>
                                        <th scope="col">Customer Name</th>
                                        <th scope="col">Quantity</th>
                                        <th scope="col">Total Amount</th>
                                        <th scope="col">Order Date</th>
                                    </tr>
                                    </thead>

                                    <tbody id="orders-table">
                                    <!-- Using JavaScript to call data -->
                                    </tbody>
                                </table>
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
            ordersModalsJS();

            // START: Get Products and place them in the respective div
            $.get("./orders/getOrders.php", function(data) {
                $('#orders-table').html(data);
            });
            // END
        });
    </script>
    </body>

</html>