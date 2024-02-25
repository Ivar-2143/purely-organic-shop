<?php  
$data['product'] = $product; 
$data['main_image'] = $main_image;
$data['images'] = $images ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>

    <script src="<?=base_url()?>assets/js/vendor/jquery.min.js"></script>
    <script src="<?=base_url()?>assets/js/vendor/popper.min.js"></script>
    <script src="<?=base_url()?>assets/js/vendor/bootstrap.min.js"></script>
    <script src="<?=base_url()?>assets/js/vendor/bootstrap-select.min.js"></script>
    <link rel="stylesheet" href="<?=base_url()?>assets/css/vendor/bootstrap.min.css">
    <link rel="stylesheet" href="<?=base_url()?>assets/css/vendor/bootstrap-select.min.css">

    <link rel="stylesheet" href="<?=base_url()?>assets/css/custom/global.css">
    <link rel="stylesheet" href="<?=base_url()?>assets/css/custom/product_view.css">
</head>
<script>
    $(document).ready(function() {
        $("#add_to_cart").click(function(){
            // $("<span class='added_to_cart'>Added to cart succesfully!</span>")
            // .insertAfter(this)
            // .fadeIn()
            // .delay(1000)
            // .fadeOut(function() { 
            //     $(this).remove();
            // });
            $('#success_modal')
                .fadeIn()
                .delay(1000)
                .fadeOut();
            $('.popover_overlay')
                .fadeIn()
                .delay(1000)
                .fadeOut();
            return false;
        });
        $('.show_image').on('click', function(){
            let newSrc = $(this).children().attr('src');
            $('#food_preview').attr('src',newSrc);
            $('li.active').removeClass('active');
            $(this).parent().addClass('active');
        });
        $('.increase_decrease_quantity').on('click', function(){
            let value = parseInt($('#value').val());    	
            let ctrl_qty = parseInt($(this).attr('data-quantity-ctrl'))
            if(value == 1 && ctrl_qty == -1){
                    return;
            }
            let calculated_value = value += ctrl_qty;
            $('#value').val(calculated_value);
            let product_price = parseFloat($('input[name=product_price]').val());
            let total_amount = product_price * calculated_value;
            $('.total_amount').html('$ ' + total_amount);
        });
    })
</script>
<body>
    <div class="wrapper">
<?php   $this->load->view('partials/customer_header')?>
        <aside>
            <a href="<?=base_url()?>"><img src="<?=base_url()?>assets/images/organic_shop_logo.svg" alt="Organic Shop"></a>
            <!-- <ul>
                <li class="active"><a href="#"></a></li>
                <li><a href="#"></a></li>
            </ul> -->
        </aside>
        <section >
            <form action="process.php" method="post" class="search_form">
                <input type="text" name="search" placeholder="Search Products">
            </form>
            <a class="show_cart" href="cart.html">Cart (0)</a>
            <a href="<?=base_url()?>">Go Back</a>
            <ul>
                <li>
<?php               $this->load->view('partials/product_image_views',$data)?>
                </li>
                <li>
                    <h2><?=$product['name']?></h2>
                    <ul class="rating">
                        <li></li>
                        <li></li>
                        <li></li>
                        <li></li>
                        <li></li>
                    </ul>
                    <span>36 Rating</span>
                    <span class="amount">$ <?=$product['price']?></span>
                    <p><?=$product['description']?></p>
                    <form action="" method="post" id="add_to_cart_form">
                        <ul>
                            <li>
                                <label for="value">Quantity</label>
                                <input id="value" type="text" min-value="1" value="1">
                                <input type="hidden" name="product_price" value="<?=$product['price']?>">
                                <ul>
                                    <li><button title="increase" type="button" class="increase_decrease_quantity" data-quantity-ctrl="1"></button></li>
                                    <li><button title="decrease" type="button" class="increase_decrease_quantity" data-quantity-ctrl="-1"></button></li>
                                </ul>
                            </li>
                            <li>
                                <label>Total Amount</label>
                                <span class="total_amount">$ <?=$product['price']?></span>
                            </li>
                            <li><button type="submit" id="add_to_cart">Add to Cart</button></li>
                        </ul>
                    </form>
                </li>
            </ul>
            <section>
                <h3>Similar Items</h3>
                <ul>
<?php               $this->load->view('partials/customer_product_cards',$products)?>
                </ul>
            </section>
        </section>
        <div id="success_modal" class="modal" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <!-- <button> </button> -->
                    <h3>Added to cart successfully!</h3>
                </div>
            </div>
        </div>
    </div>
    <div class="popover_overlay"></div>
</body>
</html>