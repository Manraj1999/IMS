<?php

    include_once $_SERVER['DOCUMENT_ROOT'] . '/ims/settings/General.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/ims/php/modals/UserModal.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/ims/php/user/User.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/ims/php/user/Tools.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/ims/php/dashboard/Customer.php';

    $UserModal = new UserModal();
    $Customer = new Customer();

    if(!(session_status() === PHP_SESSION_ACTIVE)) {
        session_start();
    }

?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <title><?php echo ORI_SITE_NAME; ?> | Customer</title>
        <!-- Favicon -->
        <link href="../assets/img/brand/favicon.png" rel="icon" type="image/png">
        <!-- CSS Files -->
        <link href="../assets/css/dashboard.css" rel="stylesheet" />
        <link rel="stylesheet" href="../assets/css/primary-layout.css" />
        <link rel="stylesheet" href="../assets/css/primary/reg.css" />
        <link href="../assets/js/plugins/fontawesome-free/css/all.min.css" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/css/bootstrap-select.min.css">
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
            <h2 class="text-center"><span class="bg-primary p-2 rounded text-white"><?php echo ORI_SITE_NAME; ?>'s Customer Dashboard</span></h2>
            <hr/>
        </div>
        <div class="col-sm-2"></div>
    </div>
    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8">
            <div class="card border-0">
                <div class="card-header bg-gradient-white">
                    <h4 class="text-center mt-0 mb-3 text-white">
                        <span class="bg-green p-2 rounded">Order</span>
                    </h4>

                    <hr/>

                    <div class="row">
                        <div class="col-md-4"></div>
                        <div class="col-md-4 d-flex justify-content-center mb-5">
                            <select id='company_name' class='selectpicker' data-style='btn-outline-primary no-outline' name='company_name' data-live-search='true'>
                                <option value="default" selected disabled hidden>Company</option>
                                <?php
                                    $Customer->getCompanyList();
                                ?>
                            </select>
                        </div>
                        <div class="col-md-4"></div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <input type="text" placeholder="Customer Name" class="form-control"/>
                        </div>
                        <div class="col-12 col-md-4 d-flex justify-content-center">
                            <select id='product_name' class='selectpicker' data-style='btn-primary no-outline' name='product_name' data-live-search='true'>

                            </select>
                        </div>
                        <div class="col-md-4">
                            <input type="number" id="product_quantity" placeholder="Product Quantity" class="form-control" min="1" readonly/>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4"></div>
                        <div class="col-md-4 input-group mt-5">
                            <div class="input-group-prepend">
                                <span class="input-group-text scale-transition">RM</span>
                            </div>
                            <input type='text' id="product_price" name='product_price' placeholder='Price' class='modal-text pl-3 form-control' readonly />
                        </div>
                        <div class="col-md-4"></div>
                    </div>

                    <div class="row">
                        <div class="col-md-4"></div>
                        <div class="col-md-4"></div>
                        <div class="col-md-4">
                            <button type="button" class="btn btn-outline-success float-right">Order</button>
                        </div>
                    </div>
                </div>
                <div class="card-body" style="background-color: #f5f4f3;"><hr class="m-3"/></div>
            </div>
        </div>
        <div class="col-md-2"></div>
    </div>

    <!--   Core   -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/dashboard.min.js"></script>
    <script src="../assets/js/modal-rows.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/js/bootstrap-select.min.js"></script>
    <script>
        $(document).ready(function() {
            customerModalsJS();

            $.get("./functions/getProducts.php", function(data) {
                $('#product_name').html(data);
                $('.selectpicker').selectpicker('refresh');
            });
        });
    </script>
    </body>
</html>