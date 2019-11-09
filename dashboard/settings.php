<?php

    include_once $_SERVER['DOCUMENT_ROOT'] . "/ims/settings/General.php";
    include_once $_SERVER['DOCUMENT_ROOT'] . '/ims/php/UI/Dashboard.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/ims/php/modals/CompanyModal.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/ims/php/dashboard/Settings.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . "/ims/php/Armor.php";

    $armor = new Armor();
    $armor->initDashboard();

    $Settings = new Settings();

    $CompanyModal = new CompanyModal();

    $Min_Threshold = $CompanyModal->getCompanyData("Minimum_Threshold");
    $Max_Threshold = $CompanyModal->getCompanyData("Maximum_Threshold");

    $Min_String = "";
    $Max_String = "";

    if($Min_Threshold != 0) {
        $Min_String = "value='" . $Min_Threshold . "'";
    }

    if($Max_Threshold != 0) {
        $Max_String = "value='" . $Max_Threshold . "'";
    }

    if(isset($_POST["save-threshold"])) {
        $Min_String = "value='" . $CompanyModal->getCompanyData("Minimum_Threshold") . "'";
        $Max_String = "value='" . $CompanyModal->getCompanyData("Maximum_Threshold") . "'";
    }

?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title><?php echo SITE_NAME; ?> | Settings</title>
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
    $dashboard->getNavigation(8);
    ?>
    <!-- End: Navbar -->
    <div class="main-content">
        <!-- Start: Header -->
        <?php
        $dashboard->getHeader();
        ?>
        <!-- End: Header -->
        <div class="header bg-gradient-gray-dark pb-8 pt-5 pt-md-8">
            <div class="container-fluid">
                <div class="header-body">
                    <div class="row">
                        <div id="message" style="visibility: hidden; text-align: center; width: 50%; left: 22%; position: fixed; z-index: 9999;">
                            <div class="del-msg">
                                <div id="inner-msg" class="alert alert-primary">

                                </div>
                            </div>
                        </div>

                        <div class="col-xl-2 col-lg-2"></div>
                        <div class="col-xl-8 col-lg-8">
                            <div class="card card-stats mb-4 mb-xl-0">
                                <div class="card-body">
                                    <div>
                                        <h3 class="text-center text-gray-dark">
                                            <i style="margin-right: 8px;" class="fa fa-building"></i> Settings
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
                <div class="col-xl-1 col-lg-1"></div>
                <div class="col-xl-10 col-lg-10">
                    <div class="card card-stats mb-4 mb-xl-0 bg-gradient-dark">
                        <div class="card-body">

                            <h2 class="text-white">Threshold Settings</h2>
                            <div class="border border-white rounded p-3">
                                    <div class="row">
                                        <div class="col col-xl-8 col-lg-auto">
                                            <h3 class="text-white">Set minimum threshold</h3>
                                            <h5 class="text-white-50">Whenever an item reaches this threshold or lower, an alert would be sent to the dashboard.</h5>
                                            <h6 class="text-white-50">*Helps alert whenever a particular item requires restocking.</h6>
                                        </div>
                                        <div class="col col-xl-4 col-lg-4 mt-5 mt-lg-0 mt-xl-3">
                                            <input type="number" placeholder="Minimum Threshold" id="min_threshold" name="min_threshold" <?php echo $Min_String; ?> class="form-control"/>
                                        </div>
                                    </div>
                                    <br/>
                                    <div class="row">
                                        <div class="col col-xl-8 col-lg-auto">
                                            <h3 class="text-white">Set maximum threshold</h3>
                                            <h5 class="text-white-50">This will set the maximum amount of inventory you're able to have for each item.</h5>
                                            <h6 class="text-white-50">*Helps reduce the overflow of products.</h6>
                                        </div>
                                        <div class="col col-xl-4 col-lg-4 mt-5 mt-lg-0 mt-xl-3">
                                            <input type="number" placeholder="Maximum Threshold" id="max_threshold" name="max_threshold" <?php echo $Max_String; ?> class="form-control"/>
                                        </div>
                                    </div>

                                    <br/>

                                    <div class="row">
                                        <div class="col col-xl-8"></div>
                                        <div class="col col-xl-4">
                                            <button id="save-threshold" name="save-threshold" class="btn btn-outline-white float-right">Save</button>
                                        </div>
                                    </div>
                            </div>

                            <br/>

                            <!-- Modal -->
                            <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="ModalScrollableTitle" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-scrollable" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="ModalScrollableTitle">Delete everything?</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body bg-danger">
                                            <h2 class="text-center text-white">Are you sure you want to delete everything?</h2>
                                        </div>
                                        <div class="modal-footer bg-danger">
                                            <button type="button" id="close-delete" class="btn btn-secondary" data-dismiss="modal">Nope</button>
                                            <button type="button" id="delete" class="btn btn-primary">Yes, I'm sure</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <h2 class="text-danger">Danger Zone</h2>
                            <div class="border border-danger rounded p-3">
                                <div class="row">
                                    <div class="col col-xl-8 col-lg-auto">
                                        <h3 class="text-white">Delete everything</h3>
                                        <h5 class="text-white-50">This will delete <?php echo $CompanyName; ?>'s inventory management system.</h5>
                                    </div>
                                    <div class="col col-xl-4 col-lg-4 mt-3 mt-lg-0 mt-xl-1">
                                        <button name="btn-delete-everything" class="btn btn-outline-danger float-lg-right" data-toggle="modal" data-target="#deleteModal">DELETE EVERYTHING</button>
                                    </div>
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
    <!--   Optional JS   -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.bundle.js"></script>
    <!--   Dashboard JS   -->
    <script src="../assets/js/dashboard.min.js"></script>
    <script src="../assets/js/modal-rows.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            settingsModalsJS();
        });
    </script>
    </body>

</html>