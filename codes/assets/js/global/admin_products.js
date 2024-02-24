$(document).ready(function() {

    /* To delete a product */
    $("body").on("click", ".delete_product", function() {
        $(this).closest("tr").addClass("show_delete");
        $(".popover_overlay").fadeIn();
        $("body").addClass("show_popover_overlay");
    });

    /* To cancel delete */
    $("body").on("click", ".cancel_remove", function() {
        $(this).closest("tr").removeClass("show_delete");
        $(".popover_overlay").fadeOut();
        $("body").removeClass("show_popover_overlay");
    });

    /* To trigger input file */
    $("body").on("click", ".upload_image", function() {
        $(".image_input").trigger("click");
    });

    /* To trigger image upload */
    $("body").on("change", ".image_input", function() {
        $('.form_data_action').val("upload_image");
        $(".add_product_form").trigger("submit");
    });

    /* To delete an image */
    $("body").on("click", ".delete_image", function() {
        $("input[name=image_index]").val($(this).attr("data-image-index"));
        $('.form_data_action').val("remove_image");
        $(".add_product_form").trigger("submit");
    });

    /*  */
    $("body").on("change", "input[name=main_image]", function() {
        // console.log("Main Image: "+$(this).val());
        $("input[name=image_index]").val($(this).val());
        $(".form_data_action").val("mark_as_main");
        $(".add_product_form").trigger("submit");
    });
    $("body").on('show.bs.modal','#add_product_modal', function () {
        if($('.form_data_action').val() == 'edit_product'){
            // alert('Modal Open');
            let product_id = $('input[name=edit_product_id]').val();
            // console.log(product_id);
            $.get('http://localhost.organic-shop/products/get_product/'+product_id,function(res){
                // console.log(res);
                $('.add_product_form input[name=product_name]').val(res.name);
                $('.add_product_form textarea[name=description]').val(res.description);
                $('.add_product_form input[name=price]').val(res.price);
                $('.add_product_form input[name=inventory]').val(res.stocks);
                $('.add_product_form select[name=category]').val(res.category_id);
                $('.selectpicker').selectpicker('refresh');
                $.get('http://localhost.organic-shop/products/get_editing_product_images/'+res.category_id+'/'+res.name,function(res){
                    $(".image_preview_list").html(res);
                    ($(".image_preview_list").children('li').length >= 4) ? $(".upload_image").parent().addClass("hidden") : $(".upload_image").parent().removeClass("hidden");
                })
            }, 'json');
        }
    })

    $("body").on("hidden.bs.modal", "#add_product_modal", function() {
        $(".form_data_action").val("reset_form");
        $(".add_product_form").trigger("submit");
        $(".add_product_form").attr("data-modal-action", 0);
        $(".form_data_action").find("textarea").addClass("jhaver");
    });

    $("body").on("submit", ".add_product_form", function() {
        let form = $(this);
        if (form.data('submitEnabled') == false) { return false; }
        form.data('submitEnabled', false);
        let form_data_action = $('.form_data_action').val();
        // console.log(form);
        $.ajax({
            url: $(this).attr("action"),
            type: 'POST',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData:false,
            success: function(res) {
                populate_csrf();
                // console.log('populating CSRF');
                form.data('submitEnabled', true);
                // $('.error-message').html(res);
                if(form_data_action == "add_product" || form_data_action == "edit_product") {
                    let isValid = true;
                    $('.error-message').children().remove();
                    if($(res).hasClass('error')) {
                        $('.error-message').html(res);
                        isValid = false;
                    }
                    if($('.image_preview_list').children('li').length < 1){
                        $(".image_label").html("Upload Images (4 Max) <span>* Please add an image.</span>");
                        isValid = false;
                    }
                    if(!isValid){
                        return false;
                    }
                    $(".product_content").html(res);
                    resetAddProductForm();
                    populate_category_nav();
                    $.get('http://localhost.organic-shop/users/csrf',function(res){
                        $('.csrf').replaceWith(res);
                    }).done(function(){
                        $("#add_product_modal").modal("hide");
                    });
                    
                }
                else if(form_data_action == "upload_image" || form_data_action == "remove_image" || form_data_action == "mark_as_main") {
                    $(".image_preview_list").html(res);
                }
                else if(form_data_action == "reset_form") {
                    resetAddProductForm();
                };
                ($(".add_product_form").attr("data-modal-action") == 0) ? $(".form_data_action").val("add_product") : $(".form_data_action").val("edit_product");
                ($(".image_preview_list").children('li').length >= 4) ? $(".upload_image").parent().addClass("hidden") : $(".upload_image").parent().removeClass("hidden");
            },
            error: function(data){
                console.log(data);
            }
        });
        return false;
    }); 

    $("body").on("submit", ".categories_form", function() {
        filterProducts($(this));         
        return false;    
    });

    $("body").on("click", ".categories_form button", function() {
        let button = $(this);
        let form = button.closest("form");
        // console.log(button.attr('data-category'));
        // console.log(button.attr('data-category-name'));
        form.find("input[name=category]").val(button.attr("data-category"));
        $("input[name=category_state]").val(button.attr("data-category"));
        form.find("input[name=category_name]").val(button.attr("data-category-name"));
        button.closest("ul").find(".active").removeClass("active");
        button.addClass("active");

        filterProducts(form);   

        return false;
    });

    $("body").on("keyup", ".search_form", function() {
        filterProducts($(this));
        $(".categories_form").find(".active").removeClass("active");
    });

    $("body").on("submit", ".delete_product_form", function(e) {
        $("body").removeClass("show_popover_overlay");
        $(".popover_overlay").fadeOut();
        // e.preventDefault();
        filterProducts($(this));
        $('.categories_form').submit();
        populate_category_nav();
        populate_csrf();
        return false;
    });

    $("body").on("click", ".edit_product", function() {
        // console.log('ID: ' + $(this).val());
        $("input[name=edit_product_id]").val($(this).val());
        $(".form_data_action").val("edit_product");
        $("#add_product_modal").modal("show");
        $(".add_product_form").attr("data-modal-action", 1);
        $("#add_product_modal").find("h2").text("Edit product #" + $(this).val());
    });

    $("body").on("submit", ".get_edit_data_form", function() {
        let form = $(this);
        if (form.data('submitEnabled') == false) { return false; }
        form.data('submitEnabled', false);
        $.post(form.attr("action"), form.serialize(), function(res) {
            form.data('submitEnabled', true);
            $(".add_product_form").find(".form_control").html(res);
            $('.selectpicker').selectpicker('refresh');
        });
        return false;
    });

    populate_csrf();
    populate_category_nav();
    populate_category_options();
});

function resetAddProductForm() {
    // populate_csrf();
    $(".add_product_form").find("textarea, input[name=product_name], input[name=price], input[name=inventory]").attr("value", "").text("");
    $('.add_product_form select[name=category]').val(1);
    $('.selectpicker').selectpicker('refresh');
    // $('select[name=categories]').find("option").removeAttr("selected").closest("select").val("1").selectpicker('refresh');
    $(".add_product_form")[0].reset();
    $(".image_label").find("span").remove();
    $(".image_preview_list").children().remove();
    $("#add_product_modal").find("h2").text("Add a Product");
    $('.error-message').children().remove();
};

function filterProducts(form) {
    if (form.data('submitEnabled') == false) { return false; }
    form.data('submitEnabled', false);
    $.post(form.attr("action"), form.serialize(), function(res) {
        // console.log('filtering and populating csrf');
        populate_csrf();  
        $(".product_content").html(res);
        // console.log(res);
        form.data('submitEnabled', true);
    });
    return false;
}

function populate_csrf(){
    $.get('http://localhost.organic-shop/users/csrf',function(res){
        $('.csrf').replaceWith(res);
    });
}

function populate_category_options(){
    $.get('http://localhost.organic-shop/categories/get_options',function(res){
        // populate_csrf();
        $('select.category-picker').html(res);
        // $('.selectpicker').first().attr('selected',TRUE);
        $('.selectpicker').selectpicker('refresh');
        $('.selectpicker').selectpicker('selectAll');
        // $('.selectpicker').val(1);
        $('.selectpicker').selectpicker('refresh');
    })
}

function populate_category_nav(){
    let id = $('input[name="category"]').val();
    $.get("http://localhost.organic-shop/categories/get_category_nav/"+id,function(res){
        populate_csrf();    
        $('.category_nav').html(res);
    });
    return;
}

function update_nav_and_products(){
    $('.categories_form').submit();
    populate_category_nav();
    return;
}