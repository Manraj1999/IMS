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
                alert(data);
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
                alert(data);
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
                $('#modal-msg').text(data).fadeIn().css('visibility', 'visible').delay(1800).fadeOut();
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
                $('#modal-msg').text(data).fadeIn().css('visibility', 'visible').delay(1800).fadeOut();
                $.get("./products/getProducts.php", function(data) {
                    $('#products-table').html(data);
                });
            }
        });
    });

    // START: Reset Data after closing Modal
    $('#editProducts').on('hidden.bs.modal', function () {
        $(this).find("input").val('').end();
        $('#supplier_code').selectpicker("val", "default");
        $('#product_category').selectpicker("val", "default");
        $('#store_code').selectpicker("val", "default");

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
                alert(data);
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
                alert(data);
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
                    $('#modal-msg').text(data).fadeIn().css('visibility', 'visible').delay(1800).fadeOut();
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

    $("#delete").click(function() {
        $.ajax({
            url: "./settings/deleteEverything.php",
            method: "POST",
            data: {},
            success: function(data) {}
        });
    });
}