<?php

    include_once $_SERVER['DOCUMENT_ROOT'] . "/ims/settings/General.php";
    include_once $_SERVER['DOCUMENT_ROOT'] . '/ims/php/UI/Dashboard.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/ims/php/modals/CompanyModal.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/ims/php/dashboard/Company.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . "/ims/php/Armor.php";

    session_start();

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
        $dashboard->getNavigation(1);
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
                                                <i style="margin-right: 8px;" class="fa fa-building"></i> Company Information
                                                <button name="edit-company" class="edit" data-toggle="modal" data-target="#editCompanyModal">
                                                    <i class="fa fa-pencil-alt fa-align-right text-blue"></i>
                                                </button>
                                            </h3>
                                            <!-- Modal -->
                                            <div class="modal fade" id="editCompanyModal" tabindex="-1" role="dialog" aria-labelledby="ModalScrollableTitle" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-scrollable" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="ModalScrollableTitle">Company Information</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="input-group mb-3">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text" id="inputGroup-sizing-default">Name</span>
                                                                </div>
                                                                <input type="text" class="form-control modal-text" aria-label="Name" aria-describedby="inputGroup-sizing-default">
                                                            </div>
                                                            <div class="input-group mb-3">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text" id="inputGroup-sizing-default">Location</span>
                                                                </div>
                                                                <input type="text" class="form-control modal-text" aria-label="Location" aria-describedby="inputGroup-sizing-default">
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                            <button type="button" class="btn btn-primary">Save changes</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <hr/>
                                        <div class="row">
                                            <div class="col-xl-4 col-lg-4 text-center">
                                                <h4 class="text-underline">Company's Name</h4>
                                                <h4 class="text-blue"><?php echo $CompanyName; ?></h4>
                                            </div>
                                            <div class="col-xl-4 col-lg-4 text-center">
                                                <h4 class="text-underline">Company's Supervisor</h4>
                                                <h4 class="text-blue"><?php echo $CompanySupervisorName; ?></h4>
                                            </div>
                                            <div class="col-xl-4 col-lg-4 text-center">
                                                <h4 class="text-underline">Company's Location</h4>
                                                <h4 class="text-blue"><?php echo $CompanyLocation; ?></h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-2 col-lg-2"></div>
                        </div>
                        <br/>
                        <div class="row">
                            <div class="col-xl-2 col-lg-2"></div>
                            <div class="col-xl-8 col-lg-8">
                                <div class="card card-stats mb-4 mb-xl-0">
                                    <div class="card-body">
                                        <div>
                                            <h3 class="text-center text-blue">
                                                <i style="margin-right: 8px;" class="fa fa-store"></i> Stores
                                                <button name="edit-stores" class="edit" data-toggle="modal" data-target="#editStores">
                                                    <i class="fa fa-pencil-alt fa-align-right text-blue"></i>
                                                </button>
                                            </h3>
                                        </div>

                                        <hr/>
                                        <div class="row" id="company-stores-data">
                                            <?php
                                                $Company = new Company();
                                                $Company->getStores();
                                            ?>
                                        </div>
                                    </div>
                                </div>


                                <!-- Modal -->
                                <div class="modal fade" id="editStores" tabindex="-1" role="dialog" aria-labelledby="ModalScrollableTitle" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="ModalScrollableTitle">Stores</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form name="add_store" id="add_store">
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <div class="table-responsive">
                                                            <table class="table" id="dynamic_field">
                                                                <tr>
                                                                    <h3>Store</h3>

                                                                    <?php
                                                                        $counter = $Company->checkStoresLogic();
                                                                    ?>
                                                                </tr>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" id="close-btn-store" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    <button type="button" id="save-store" class="btn btn-primary">Save changes</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-2 col-lg-2"></div>
                        </div>
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