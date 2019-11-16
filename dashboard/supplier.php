<?php
    include_once $_SERVER['DOCUMENT_ROOT'] . "/ims/settings/General.php";
    include_once $_SERVER['DOCUMENT_ROOT'] . '/ims/php/UI/Dashboard.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/ims/php/Armor.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/ims/php/dashboard/Supplier.php';

    $Armor = new Armor();
    $Armor->initDashboard();
?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title><?php echo SITE_NAME; ?> | Supplier</title>
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
        $dashboard->getNavigation(2);
        ?>
        <!-- End: Navbar -->
        <div class="main-content">
            <!-- Start: Header -->
            <?php
            $dashboard->getHeader();
            ?>
            <!-- End: Header -->
            <div style="background: linear-gradient(to right, #ed213a, #93291e);" class="header pb-8 pt-5 pt-md-8">
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
                                            <h3 class="text-center" style="color: #ed213a;">
                                                <i style="margin-right: 8px; color: #ed213a;" class="fa fa-industry"></i> Supplier
                                                <button name="edit-categories" class="edit-2" data-toggle="modal" data-target="#editSuppliers">
                                                    <i class="fa fa-pencil-alt fa-align-right text-danger"></i>
                                                </button>
                                            </h3>
                                        </div>

                                        <hr/>
                                        <div class="row" id="company-suppliers-data">

                                            <?php
                                            $Supplier = new Supplier();
                                            $Supplier->getSuppliers();
                                            ?>
                                        </div>
                                    </div>
                                </div>


                                <!-- Modal -->
                                <div class="modal fade" id="editSuppliers" tabindex="-1" role="dialog" aria-labelledby="ModalScrollableTitle" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="ModalScrollableTitle">Add a Supplier</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form name="add_suppliers" id="add_suppliers">
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <table class="table" id="dynamic_field">
                                                            <tr>
                                                                <h3>Supplier</h3>
                                                                <?php
                                                                    $counter = $Supplier->checkSuppliersLogic();
                                                                ?>
                                                            </tr>
                                                        </table>

                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" id="close-btn-suppliers" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    <button type="button" id="save-suppliers" class="btn btn-primary">Save changes</button>
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
        <!--   Dashboard JS   -->
        <script src="../assets/js/dashboard.min.js"></script>
        <script src="../assets/js/modal-rows.js"></script>
        <script type="text/javascript">
            $(document).ready(function() {
                supplierModalsJS(<?php echo $counter; ?>);
            });
        </script>

    </body>
</html>