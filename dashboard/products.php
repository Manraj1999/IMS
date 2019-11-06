<?php
    include_once $_SERVER['DOCUMENT_ROOT'] . "/ims/settings/General.php";
    include_once $_SERVER['DOCUMENT_ROOT'] . '/ims/php/UI/Dashboard.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/ims/php/Armor.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/ims/php/dashboard/Products.php';

    $Armor = new Armor();
    $Armor->initDashboard();

    $Products = new Products();
?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title><?php echo SITE_NAME; ?> | Products</title>
        <!-- Favicon -->
        <link href="../assets/img/brand/favicon.png" rel="icon" type="image/png">
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
        <!-- Icons -->
        <link href="../assets/js/plugins/nucleo/css/nucleo.css" rel="stylesheet" />
        <link href="../assets/js/plugins/fontawesome-free/css/all.min.css" rel="stylesheet" />
        <!-- CSS Files -->
        <link href="../assets/css/dashboard.css" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/css/bootstrap-select.min.css">
    </head>

    <body class="">
        <!-- Start: Navbar -->
        <?php
        $dashboard = new Dashboard();
        $dashboard->getNavigation(4);
        ?>
        <!-- End: Navbar -->
        <div class="main-content">
            <!-- Start: Header -->
            <?php
            $dashboard->getHeader();
            ?>
            <!-- End: Header -->
            <div class="header bg-gradient-peach pb-8 pt-5 pt-md-8">
                <div class="container-fluid">
                    <div class="header-body">
                        <div class="row">
                            <div class="col-xl-1 col-lg-1"></div>
                            <div class="col-xl-10 col-lg-10">
                                <div id="message" style="visibility: hidden; text-align: center;">
                                    <div style="width: 50%; left: 75%; margin: -7% 0 0 -51%; display: block; position: fixed; z-index: 9999;">
                                        <div id="modal-msg" class="alert alert-primary">

                                        </div>
                                    </div>
                                </div>
                                <div id="message" style="visibility: visible; text-align: center;">
                                    <div class="del-msg">
                                        <div id="inner-msg" class="alert alert-primary">

                                        </div>
                                    </div>
                                </div>
                                <div class="card card-stats mb-4 mb-xl-0">
                                    <div class="card-body">
                                        <div>
                                            <h3 class="text-center text-orange mb--2 ml-7">
                                                <i style="margin-right: 8px;" class="fa fa-archive text-orange"></i> Products
                                                <button name="edit-products" class="btn btn-md btn-outline-success mt--2 float-right" data-toggle="modal" data-target="#editProducts">
                                                    Add
                                                </button>
                                            </h3>

                                            <div class="col-5 col-sm-3 col-md-4 col-lg-2 col-xl-2 ml--3 ">
                                                <select class="selectpicker form-control float-left mt--4" id="limit-selector" name="limit-selector" data-style="btn-primary">
                                                    <option value="10" selected disabled>Limit</option>
                                                    <option value="10">10</option>
                                                    <option value="50">50</option>
                                                    <option value="100">100</option>
                                                </select>
                                            </div>
                                        </div>

                                        <hr/>

                                        <div class="table-responsive">
                                            <table class="table text-center">
                                                <thead>
                                                <tr>
                                                    <th scope="col">Code</th>
                                                    <th scope="col">Name</th>
                                                    <th scope="col">Category</th>
                                                    <th scope="col">Quantity</th>
                                                    <th scope="col">Supplier</th>
                                                    <th scope="col">Action</th>
                                                </tr>
                                                </thead>

                                                <tbody id="products-table">
                                                    <!-- Using JavaScript to call data -->
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <!-- Modal -->
                                <div class="modal fade" id="editProducts" tabindex="-1" role="dialog" aria-labelledby="ModalScrollableTitle" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="ModalScrollableTitle">Add Product</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form name="add_products" id="add_products">
                                                <div class="modal-body">
                                                    <div class="form-group row">
                                                        <div class="col-xl-3 col-lg-3 mb-2">
                                                            <input type='text' id="product_code" name='product_code' placeholder='Product Code' class='modal-text form-control' />
                                                        </div>
                                                        <div class="col-xl-5 col-lg-5 mb-2">
                                                            <input type='text' name='product_name' placeholder='Product Name' class='modal-text form-control' />
                                                        </div>
                                                        <div class="col-xl-4 col-lg-4 mb-2">
                                                            <select id='product_category' class='selectpicker' data-style='btn-primary no-outline' name='product_category' data-live-search='true'>
                                                                <option val="default" selected disabled hidden>Product Category</option>
                                                                <?php
                                                                    $Products->getCategoriesForAddingProducts();
                                                                ?>
                                                            </select>
                                                        </div>
                                                        <div class="col-xl-3 col-lg-3 mb-2">
                                                            <input type="number" name='product_inventory' id="product_inventory" min="0" placeholder="Quantity" class="modal-text form-control"/>
                                                        </div>
                                                        <div class="col-xl-5 col-lg-5 mb-2">
                                                            <select id='supplier_code' class='selectpicker' data-style='btn-primary no-outline' name='supplier_code' data-live-search='true'>
                                                                <option val="default" selected disabled hidden>Product Supplier</option>
                                                                <?php
                                                                    $Products->getSuppliersForAddingProducts();
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" id="close-btn-products" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    <button type="button" id="save-products" class="btn btn-primary">Save changes</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <!-- Update Modal -->
                                <div class="modal fade" id="updateProducts" tabindex="-1" role="dialog" aria-labelledby="ModalScrollableTitle" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="ModalScrollableTitle">Update Product</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form name="update_products" id="update_products">
                                                <div class="modal-body">
                                                    <div class="form-group row">
                                                        <div class="col-xl-3 col-lg-3 mb-2">
                                                            <input type='text' id="update_product_code" name='update_product_code' placeholder='Product Code' class='modal-text form-control' readonly="true" />
                                                        </div>
                                                        <div class="col-xl-5 col-lg-5 mb-2">
                                                            <input type='text' id="update_product_name" name='update_product_name' placeholder='Product Name' class='modal-text form-control' />
                                                        </div>
                                                        <div class="col-xl-3 col-lg-3 mb-2">
                                                            <input type="number" name='update_product_inventory' id="update_product_inventory" min="0" placeholder="Quantity" class="modal-text form-control"/>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" id="close-btn-update-products" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    <button type="button" id="save-update-products" class="btn btn-primary">Update Product</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="col-xl-1 col-lg-1"></div>
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
        <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/js/bootstrap-select.min.js"></script>
        <script src="../assets/js/modal-rows.js"></script>
        <script>
            $(document).ready(function() {
                addProductModalsJS();

                // START: Get Products and place them in the respective div
                $.get("./products/getProducts.php", function(data) {
                    $('#products-table').html(data);
                });
                // END


                // START: Set limit to the products
                var limit = 10;

                $("#limit-selector").change(function() {
                    limit = $(this).children("option:selected").val();
                    $.ajax({
                        url: "./products/getProducts.php",
                        method: "POST",
                        data: {limitCount: limit},
                        success: function(data) {
                            $('#products-table').html(data);
                        }
                    });
                });
                // END
            });

            // START: Auto-capitalize and set number limit to modals
            var number = document.getElementById('product_inventory');
            var numberUpdate = document.getElementById('update_product_inventory');

            // Listen for input event on numInput.
            number.onkeydown = function(e) {
                if(!((e.keyCode > 95 && e.keyCode < 106)
                    || (e.keyCode > 47 && e.keyCode < 58)
                    || e.keyCode == 8)) {
                    return false;
                }
            };

            // Listen for input event on numInput.
            numberUpdate.onkeydown = function(e) {
                if(!((e.keyCode > 95 && e.keyCode < 106)
                    || (e.keyCode > 47 && e.keyCode < 58)
                    || e.keyCode == 8)) {
                    return false;
                }
            };

            function forceKeyPressUppercase(e)
            {
                var charInput = e.keyCode;
                if((charInput >= 97) && (charInput <= 122)) { // lowercase
                    if(!e.ctrlKey && !e.metaKey && !e.altKey) { // no modifier key
                        var newChar = charInput - 32;
                        var start = e.target.selectionStart;
                        var end = e.target.selectionEnd;
                        e.target.value = e.target.value.substring(0, start) + String.fromCharCode(newChar) + e.target.value.substring(end);
                        e.target.setSelectionRange(start+1, start+1);
                        e.preventDefault();
                    }
                }
            }

            document.getElementById("product_code").addEventListener("keypress", forceKeyPressUppercase, false);
            // END
        </script>
    </body>
</html>