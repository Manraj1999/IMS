<?php

    include_once $_SERVER['DOCUMENT_ROOT'] . "/ims/settings/General.php";
    include_once $_SERVER['DOCUMENT_ROOT'] . '/ims/php/UI/Dashboard.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/ims/php/modals/CompanyModal.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/ims/php/dashboard/Company.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . "/ims/php/Armor.php";

    $armor = new Armor();
    $armor->initDashboard();

?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title><?php echo SITE_NAME; ?> | Company</title>
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
    $dashboard->getNavigation(5);
    ?>
    <!-- End: Navbar -->
    <div class="main-content">
        <!-- Start: Header -->
        <?php
        $dashboard->getHeader();
        ?>
        <!-- End: Header -->
        <div class="header bg-gradient-primary pb-8 pt-5 pt-md-8">
            <div class="container-fluid">
                <div class="header-body">
                    <div class="row">
                        <div class="col-xl-2 col-lg-2"></div>
                        <div class="col-xl-8 col-lg-8">
                            <div class="card card-stats mb-4 mb-xl-0">
                                <div class="card-body">
                                    <div>
                                        <h3 class="text-center text-blue">
                                            <i style="margin-right: 8px;" class="fa fa-store"></i> Stores
                                            <button name="edit-company" class="edit" data-toggle="modal" data-target="#editCompanyModal">
                                                <i class="fa fa-pencil-alt fa-align-right text-blue"></i>
                                            </button>
                                        </h3>
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
            <div class="row mt--5">
                <div class="col-xl-6 col-lg-6 mb-4">
                    <a href="#">
                        <div class="card card-stats bg-gradient-dark">
                            <div class="card-body">
                                <h3 class="text-center text-primary">Store #1</h3>
                                <h4 class="text-center text-primary">This is where the location will go along with everything extra</h4>
                                <br/>
                                <h1 class="text-center"><span class='badge badge-light text-white p-3 bg-primary'>15</span></h1>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!--   Core   -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
    <!--   Optional JS   -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.bundle.js"></script>
    <!--   Dashboard JS   -->
    <script src="../assets/js/dashboard.min.js"></script>
    <script src="../assets/js/modal-rows.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            storeModalsJS(<?php echo $counter; ?>);
        });
    </script>
    </body>

</html>