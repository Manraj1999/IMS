function dashboardModalsJS() {
    var $chart = $('#chart-bruh');

    // Create chart
    var ordersChart = new Chart($chart, {
        type: 'bar',
        options: {
            scales: {
                yAxes: [{
                    gridLines: {
                        lineWidth: 1,
                        color: '#dfe2e6',
                        zeroLineColor: '#dfe2e6'
                    },
                    ticks: {
                        callback: function(value) {
                            if (!(value % 10)) {
                                //return '$' + value + 'k'
                                return value
                            }
                        }
                    }
                }]
            },
            tooltips: {
                callbacks: {
                    label: function(item, data) {
                        var label = data.datasets[item.datasetIndex].label || '';
                        var yLabel = item.yLabel;
                        var content = '';

                        if (data.datasets.length > 1) {
                            content += '<span class="popover-body-label mr-auto">' + label + '</span>';
                        }

                        content += '<span class="popover-body-value">' + yLabel + '</span>';

                        return content;
                    }
                }
            }
        },
        data: {
            labels: ['Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            datasets: [{
                label: 'Sales',
                data: [25, 20, 30, 22, 17, 29]
            }]
        }
    });

    // Save to jQuery object
    $chart.data('chart', ordersChart);
}

function storeModalsJS(i) {
    $('#add').click(function(){
        i++;
        $('#dynamic_field').append('<tr id="row'+i+'"><td><input type="text" name="code[]" placeholder="Store Code" class="modal-text form-control name_list" /></td><td><input type="text" name="name[]" placeholder="Store Name" class="modal-text form-control name_list" /></td><td><input type="text" name="location[]" placeholder="Store Location" class="modal-text form-control name_list" /></td><td><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button></td></tr>');
    });

    $(document).on('click', '.btn_remove', function(){
        var button_id = $(this).attr("id");
        $('#row'+button_id+'').remove();
    });

    $('#save-store').click(function(){
        $.ajax({
            url:"./stores/saveStores.php",
            method:"POST",
            data:$('#add_store').serialize(),
            success:function(data)
            {
                $('#inner-msg').text(data).fadeIn().css('visibility', 'visible').delay(1800).fadeOut();
                $.get("./stores/getStores.php", function(data) {
                    $('#company-stores-data').html(data);
                });
            }
        });
    });

    $.ajaxSetup ({
        cache: false
    });
}

function storesProductsModalsJS() {
    $(".product-store").click(function() {
        $.ajax({
            url:"./stores/getSpecificStores.php",
            method:"POST",
            data: {storeCode: this.id},
            success:function(data)
            {
                $('#store-product-data').html(data);
            }
        });
    });
}

function categoryModalsJS(j) {
    $('#add').click(function(){
        j++;
        $('#dynamic_field').append('<tr id="row'+j+'"><td><input type="text" name="name[]" placeholder="Category Name" class="modal-text form-control name_list" /></td><td><input type=\'text\' name=\'abbr[]\' placeholder=\'Category Abbreviation\' class=\'modal-text form-control name_list\' /></td><td><button type="button" name="remove" id="'+j+'" class="btn btn-danger btn_remove">X</button></td></tr>');
    });

    $(document).on('click', '.btn_remove', function(){
        var button_id = $(this).attr("id");
        $('#row'+button_id+'').remove();
    });

    $('#save-categories').click(function(){
        $.ajax({
            url:"./categories/saveCategories.php",
            method:"POST",
            data:$('#add_categories').serialize(),
            success:function(data)
            {
                $('#inner-msg').text(data).fadeIn().css('visibility', 'visible').delay(1800).fadeOut();
                $.get("./categories/getCategories.php", function(data) {
                    $('#company-categories-data').html(data);
                });
            }
        });
    });

    $.ajaxSetup ({
        cache: false
    });
}

function addProductModalsJS() {
    $('#save-products').click(function(){
        $.ajax({
            url:"./products/saveProducts.php",
            method:"POST",
            data:$('#add_products').serialize(),
            success:function(data)
            {
                $('#inner-msg').text(data).fadeIn().css('visibility', 'visible').delay(1800).fadeOut();
                $.get("./products/getProducts.php", function(data) {
                    $('#products-table').html(data);
                });
            }
        });
    });

    $.ajaxSetup ({
        cache: false
    });

    $('#save-update-products').click(function(){
        $.ajax({
            url:"./products/updateProducts.php",
            method:"POST",
            data:$('#update_products').serialize(),
            success:function(data)
            {
                $('#inner-msg').text(data).fadeIn().css('visibility', 'visible').delay(1800).fadeOut();
                $.get("./products/getProducts.php", function(data) {
                    $('#products-table').html(data);
                });
            }
        });
    });

    $("#search-product").keyup(function() {
        $.ajax({
            url:"./products/getSearchProducts.php",
            method:"POST",
            data: {searchData: $("#search-product").val()},
            success:function(data)
            {
                $('#products-table').html(data);
            }
        });
    });

    // START: Reset Data after closing Modal
    $('#editProducts').on('hidden.bs.modal', function () {
        $(this).find("input").val('').end();
        $('#supplier_code').selectpicker("val", "default");
        $('#product_category').selectpicker("val", "default");
        $('#store_code').selectpicker("val", "default");
        $('.selectpicker').selectpicker('refresh');

    });
    // END: Reset Data after closing Modal

    $(document).on('click', '.edit-data', function() {
        var product_code = $(this).attr("id");

        $.ajax({
            url: "./products/getUpdateData.php",
            method: "POST",
            data: {Product_Code: product_code},
            dataType: "json",
            success: function(data) {
                $('#update_product_code').val(product_code);
                $('#update_product_name').val(data.Product_Name);
                $('#update_product_inventory').val(data.Product_Inventory);
                $('select[name=update_product_category]').val(data.Product_Category);
                $('select[name=update_supplier_code]').val(data.Supplier_Code);
                $('select[name=update_store_code]').val(data.Store_Code);
                $('#update_product_price').val(data.Product_Price);
                $('.selectpicker').selectpicker('refresh');
            }
        });
    });

    $(document).on('click', '.delete-data', function() {
        var product_code = $(this).attr("id");

        $.ajax({
            url: "./products/deleteProduct.php",
            method: "POST",
            data: {Product_Code: product_code},
            success: function(data) {
                $('#inner-msg').text(data).fadeIn().css('visibility', 'visible').delay(1800).fadeOut();
                $.get("./products/getProducts.php", function(data) {
                    $('#products-table').html(data);
                });
            }
        });
    });
}

function supplierModalsJS(j) {
    $('#add').click(function(){
        j++;
        $('#dynamic_field').append('<tr id="row'+j+'"><td><input type="text" name="name[]" placeholder="Supplier Name" class="modal-text form-control name_list" /></td><td><input type=\'text\' name=\'code[]\' placeholder=\'Supplier Code\' class=\'modal-text form-control name_list\' /></td><td><input type="text" name="loc[]" placeholder="Supplier Location" class="modal-text form-control name_list" /></td><td><button type="button" name="remove" id="'+j+'" class="btn btn-danger btn_remove">X</button></td></tr>');
    });

    $(document).on('click', '.btn_remove', function(){
        var button_id = $(this).attr("id");
        $('#row'+button_id+'').remove();
    });

    $('#save-suppliers').click(function(){
        $.ajax({
            url:"./supplier/saveSuppliers.php",
            method:"POST",
            data:$('#add_suppliers').serialize(),
            success:function(data)
            {
                $('#inner-msg').text(data).fadeIn().css('visibility', 'visible').delay(1800).fadeOut();
                $.get("./supplier/getSuppliers.php", function(data) {
                    $('#company-suppliers-data').html(data);
                });
            }
        });
    });

    $.ajaxSetup ({
        cache: false
    });
}

function usersModalsJS() {
    $("#search-user").keyup(function() {
        $.ajax({
            url:"./users/getSearchUsers.php",
            method:"POST",
            data: {searchData: $("#search-user").val()},
            success:function(data)
            {
                $('#users-table').html(data);
            }
        });
    });

    $.ajaxSetup ({
        cache: false
    });

    $('#add-user').click(function(){

        $.ajax({
            url:"./users/addUser.php",
            method:"POST",
            data:$('#add_user').serialize(),
            success:function(data)
            {
                $('#inner-msg').text(data).fadeIn().css('visibility', 'visible').delay(1800).fadeOut();
                $.get("./users/getUsers.php", function(data) {
                    $('#users-table').html(data);
                });

                // Reset Data
                $("#user_fullname").val('');
                $("#user_email").val('');
                $("#user_password").val('');
                $("#user_password_confirm").val('');
            }
        });
    });

    $(document).on('click', '.change-pass', function() {
        var user_id = $(this).attr("id");

        // Reset Data
        $("#user_pswd").val('');
        $("#user_pswd_confirm").val('');

        $('#save-update-pass').click(function() {
            $.ajax({
                url:"./users/changeUserPass.php",
                method:"POST",
                data:$('#update_password').serialize() + "&User_ID=" + user_id,
                success:function(data)
                {
                    $('#inner-msg').text(data).fadeIn().css('visibility', 'visible').delay(1800).fadeOut();
                    $.get("./users/getUsers.php", function(data) {
                        $('#users-table').html(data);
                    });
                }
            });
        });
    });

    $(document).on('click', '.delete-data', function() {
        var user_id = $(this).attr("id");

        $.ajax({
            url: "./users/deleteUser.php",
            method: "POST",
            data: {User_ID: user_id},
            success: function(data) {
                $('#inner-msg').text(data).fadeIn().css('visibility', 'visible').delay(1800).fadeOut();
                $.get("./users/getUsers.php", function(data) {
                    $('#users-table').html(data);
                });
            }
        });
    });

    $(document).on('click', '.pass-ownership-data', function() {
        var user_id = $(this).attr("id");

        $.ajax({
            url: "./users/passOwnership.php",
            method: "POST",
            data: {User_ID: user_id},
            success: function(data) {
                $('#inner-msg').text(data).fadeIn().css('visibility', 'visible').delay(1800).fadeOut();
                $.get("./users/getUsers.php", function(data) {
                    $('#users-table').html(data);
                });

                window.location.replace("/ims/dashboard/dashboard.php");
            }
        });
    });
}

function settingsModalsJS() {
    $("#save-threshold").click(function() {

        var min = $("#min_threshold").val();
        var max = $("#max_threshold").val();

        $.ajax({
            url: "./settings/updateThreshold.php",
            method: "POST",
            data: {Min: min, Max: max},
            success: function(data) {
                $('#inner-msg').text(data).fadeIn().css('visibility', 'visible').delay(1800).fadeOut();
            }
        });
    });

    $("#save-currency").click(function() {

        var format = $("#currency_format").val();

        $.ajax({
            url: "./settings/updateCurrencyFormat.php",
            method: "POST",
            data: {Format: format},
            success: function(data) {
                $('#inner-msg').text(data).fadeIn().css('visibility', 'visible').delay(1800).fadeOut();
            }
        });
    });

    $("#delete").click(function() {
        $.ajax({
            url: "./settings/deleteEverything.php",
            method: "POST",
            data: {},
            success: function(data) {
                window.location.replace("/ims/index.php");
            }
        });
    });
}

function adminModalsJS() {
    $(document).on('click', '.company-approve', function() {
        var id = $(this).attr("id");
        var status = "APPROVED";

        $.ajax({
            url: "./functions/updateStatus.php",
            method: "POST",
            data: {List_ID: id, Status: status},
            success: function(data) {
                $('#inner-msg').text(data).fadeIn().css('visibility', 'visible').delay(1800).fadeOut();
                $.get("./functions/getQueueList.php", function (data) {
                    $('#queue-table').html(data);
                });

                $.get("./functions/getCompanyList.php", function (data) {
                    $('#list-table').html(data);
                });
            }
        });
    });

    $(document).on('click', '.company-disapprove', function() {
        var id = $(this).attr("id");
        var status = "DISAPPROVED";

        $.ajax({
            url: "./functions/updateStatus.php",
            method: "POST",
            data: {List_ID: id, Status: status},
            success: function(data) {
                $('#inner-msg').text(data).fadeIn().css('visibility', 'visible').delay(1800).fadeOut();
                $.get("./functions/getQueueList.php", function (data) {
                    $('#queue-table').html(data);
                });

                $.get("./functions/getCompanyList.php", function (data) {
                    $('#list-table').html(data);
                });
            }
        });
    });

    $(document).on('click', '.company-delete', function() {
        var id = $(this).attr("id");

        $.ajax({
            url: "./functions/deleteCompany.php",
            method: "POST",
            data: {List_ID: id},
            success: function(data) {
                $('#inner-msg').text(data).fadeIn().css('visibility', 'visible').delay(1800).fadeOut();
                $.get("./functions/getQueueList.php", function (data) {
                    $('#queue-table').html(data);
                });

                $.get("./functions/getCompanyList.php", function (data) {
                    $('#list-table').html(data);
                });
            }
        });
    });

    $(document).on('click', '.company-change-pass', function() {
        var user_id = $(this).attr("id");
        var company_id = $(this).attr("company");
        var company_name = $(this).attr("comp-name");
        var email = $(this).attr("email");

        // Reset Data
        $("#user_pswd").val('');
        $("#user_pswd_confirm").val('');

        $('#save-update-pass').click(function() {
            $.ajax({
                url:"./functions/changeUserPass.php",
                method:"POST",
                data:$('#update_password').serialize() + "&User_ID=" + user_id + "&Company_ID=" + company_id + "&Email=" + email + "&Company_Name=" + company_name,
                success:function(data)
                {
                    $('#inner-msg').text(data).fadeIn().css('visibility', 'visible').delay(1800).fadeOut();
                    $.get("./functions/getCompanyList.php", function(data) {
                        $('#list-table').html(data);
                    });
                }
            });
        });
    });
}

function customerModalsJS() {

    $('#company_name').on("change", function () {
        var comp_id = $(this).val();
        $.ajax({
            url: "./functions/getProducts.php",
            method: "POST",
            data: {Company_ID: comp_id},
            success: function(data) {
                $('#product_name').html(data);
                $('.selectpicker').selectpicker('refresh');
            }
        });
    });

    $('#product_name').on("change", function () {
        var comp_id = $('#company_name').val();
        var prod_id = $(this).val();
        $.ajax({
            url: "./functions/getMaxInventory.php",
            method: "POST",
            data: {Company_ID: comp_id, Product_ID: prod_id},
            success: function(data) {
                $('#product_quantity').val("");
                $('#product_quantity').removeAttr("readonly");
                $('#product_quantity').attr("max", data);
            }
        });
    });

    $('#product_quantity').on('keydown keyup mousedown', function(e) {
        var comp_id = $('#company_name').val();
        var prod_id = $('#product_name').val();
        var max = parseInt($('#product_quantity').attr('max'));

        if (parseInt($(this).val()) > max
            && e.keyCode !== 46 // keycode for delete
            && e.keyCode !== 8 // keycode for backspace
        ) {
            e.preventDefault();
            $(this).val(max);
        }

        var prod_quantity = $(this).val();

        if(prod_quantity === "") {
            prod_quantity = 0;
        }

        $.ajax({
            url: "./functions/getPrice.php",
            method: "POST",
            data: {Company_ID: comp_id, Product_ID: prod_id, Product_Quantity: prod_quantity},
            success: function(data) {
                $('#product_price').val(data);
            }
        });
    });

    $('#order-btn').on('click', function() {
        var comp_id = $('#company_name').val();
        var prod_id = $('#product_name').val();
        var prod_quantity = $('#product_quantity').val();
        var prod_price = $('#product_price').val();
        var customer_name = $('#customer_name').val();

        $.ajax({
            url: "./functions/orderProduct.php",
            method: "POST",
            data: {Company_ID: comp_id, Product_ID: prod_id, Product_Quantity: prod_quantity, Product_Price: prod_price, Customer_Name: customer_name},
            success: function(data) {
                $('#inner-msg').text(data).fadeIn().css('visibility', 'visible').delay(1800).fadeOut();
            }
        });
    });
}

function ordersModalsJS() {
    $("#search-orders").keyup(function() {
        $.ajax({
            url:"./orders/getSearchOrders.php",
            method:"POST",
            data: {searchData: $("#search-orders").val()},
            success:function(data)
            {
                $('#orders-table').html(data);
            }
        });
    });
}