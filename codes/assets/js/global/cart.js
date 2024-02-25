$(document).ready(function() {
    $("body").on("click", ".remove_item", function() {
        $(this).closest("ul").closest("li").addClass("confirm_delete");
        $(".popover_overlay").fadeIn();
        $(".cart_items_form").find("input[name=action]").val("delete_cart_item");
        $(".cart_items_form").find("input[name=update_cart_item_id]").val($(this).val());
    });
    $("body").on("click", ".cancel_remove", function() {
        $(this).closest("li").removeClass("confirm_delete");
        $(".popover_overlay").fadeOut();
        $(".cart_items_form").find("input[name=action]").val("update_cart");
    });
    /* prototype added delete */
    $("body").on("click", ".remove", function() {
        $(this).closest('li.confirm_delete').remove();
        $(".popover_overlay").fadeOut();
        if($('.cart_items_form ul').children().length == 0){
            let no_data = 
                `<li class="no_data">
                    <h3>There are no items in this cart</h3>
                    <a href="catalogue.html">Continue Shopping</a>
                </li>`;
            $('.cart_items_form ul').append(no_data);
        }
    });

    $("body").on("click", ".increase_decrease_quantity", function() {
        let input = $(this).closest(".form_controls").find('input');
        let input_val = parseInt(input.val());
        if($(this).attr("data-quantity-ctrl") == 1) {
            input.val(input_val + 1);
        }
        else {
            if(input_val != 1) {
                input.val(input_val - 1)
            };
        };
        console.log('Updating Cart Item ID: ' + $(this).val(), input.val());
        $("input[name=update_cart_item_id]").val($(this).val())
        $("input[name=update_cart_item_quantity]").val(input.val());
        $(".cart_items_form").trigger("submit");
    });

    $("body").on("submit", ".cart_items_form", function() {
        let form = $(this);
        $.post(form.attr("action"), form.serialize(), function(res) {
            $(".wrapper > section").html(res);
            $(".popover_overlay").fadeOut();
        }).always(function(){
            populate_csrf();
        });
        return false;
    });

    $("body").on("submit", ".checkout_form", function() {
        let form = $(this);
        $.post(form.attr("action"), form.serialize(), function(res) {
            $(".wrapper > section").html(res);
            $("#card_details_modal").modal("show");
        } );

        return false;
    });

    $("body").on("submit", ".pay_form", function() {
        let form = $(this);
        $(this).find("button").addClass("loading");
        $.post(form.attr("action"), form.serialize(), function(res) {
            setTimeout(function(res) {
                $("#card_details_modal").find("button").removeClass("loading").addClass("success").find("span").text("Payment Successfull!");
            }, 2000, res);
            setTimeout(function(res) {
                $("#card_details_modal").modal("hide");
            }, 3000, res);
            setTimeout(function(res) {
                $(".wrapper > section").html(res);
            }, 3200, res);
        });
        return false;
    });
});

function populate_csrf(){
    $.get('http://localhost.organic-shop/users/csrf',function(res){
        $('.csrf').replaceWith(res);
    });
}