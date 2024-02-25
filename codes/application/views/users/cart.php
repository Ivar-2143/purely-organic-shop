<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>

    <script src="../assets/js/vendor/jquery.min.js"></script>
    <script src="../assets/js/vendor/popper.min.js"></script>
    <script src="../assets/js/vendor/bootstrap.min.js"></script>
    <script src="../assets/js/vendor/bootstrap-select.min.js"></script>
    <link rel="stylesheet" href="../assets/css/vendor/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/vendor/bootstrap-select.min.css">
    <script src="<?=base_url('assets/js/global/global.js')?>"></script>
    <link rel="stylesheet" href="../assets/css/custom/global.css">
    <link rel="stylesheet" href="../assets/css/custom/cart.css">
    <script src="../assets/js/global/cart.js"></script>
</head>

<script>
    $(document).ready(function() {
        $(document).on('change', function(){
            console.log($('.cart_items_form ul').children().length);
        })
        $('.cart_items_form ul').children().on('change', function(){
            
        });
    });
</script>
<body>
    <div class="wrapper">
<?php   $this->load->view('partials/customer_header')?>
        <aside>
            <a href="<?=base_url()?>"><img src="../assets/images/organic_shop_logo.svg" alt="Organic Shop"></a>
            <!-- <ul>
                <li class="active"><a href="#"></a></li>
                <li><a href="#"></a></li>
            </ul> -->
        </aside>
        <section >
            <form class="search_form">
                <input type="text" name="search" placeholder="Search Products">
            </form>
            <button class="show_cart">Cart (<?=count($cart_items)   ?>)</button>
            <section>
                <form action="<?=base_url('carts/update')?>" method="post" class="cart_items_form">
                    <ul>
<?php                   $this->load->view('partials/customer_row_products')?>
                    </ul>
<?php               $this->load->view('partials/csrf_input')?>
                    <input type="hidden" name="update_cart_item_id">
                    <input type="hidden" name="update_cart_item_quantity">
                </form>
                <form class="checkout_form">
                    <h3>Shipping Information</h3>
                    <ul>
                        <li>
                            <input id="fn" type="text" name="first_name" required>
                            <label for="fn">First Name</label>
                        </li>
                        <li>
                            <input id="ln" type="text" name="last_name" required>
                            <label for="ln">Last Name</label>
                        </li>
                        <li>
                            <input id="address1" type="text" name="address_1" required>
                            <label for="address1">Address 1</label>
                        </li>
                        <li>
                            <input id="address2" type="text" name="address_2" required>
                            <label for="address2">Address 2</label>
                        </li>
                        <li>
                            <input id="city" type="text" name="city" required>
                            <label for="city">City</label>
                        </li>
                        <li>
                            <input id="state" type="text" name="state" required>
                            <label for="state">State</label>
                        </li>
                        <li>
                            <input id="zip" type="text" name="zip_code" required>
                            <label for="zip">Zip Code</label>
                        </li>
                    </ul>
                    <h3>Order Summary</h3>
                    <h4>Items <span>$ 40</span></h4>
                    <h4>Shipping Fee <span>$ 5</span></h4>
                    <h4 class="total_amount">Total Amount <span>$ 45</span></h4>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#card_details_modal">Proceed to Checkout</button>
                </form>
            </section>
        </section>
        <!-- Button trigger modal -->
        <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#card_details_modal">
            Launch demo modal
        </button> -->
        <div class="modal fade form_modal" id="card_details_modal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <button data-dismiss="modal" aria-label="Close" class="close_modal"></button>
                    <form action="process.php" method="post">
                        <h2>Card Details</h2>
                        <ul>
                            <li>
                                <input type="text" name="card_name" required>
                                <label>Card Name</label>
                            </li>
                            <li>
                                <input type="number" name="card_number" required>
                                <label>Card Number</label>
                            </li>
                            <li>
                                <input type="month" name="expiration" required>
                                <label>Exp Date</label>
                            </li>
                            <li>
                                <input type="number" name="cvc" required>
                                <label>CVC</label>
                            </li>
                        </ul>
                        <h3>Total Amount <span>$ 45</span></h3>
                        <button type="button">Pay</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade form_modal" id="login_modal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <button data-dismiss="modal" aria-label="Close" class="close_modal"></button>
                    <form action="process.php" method="post">
                        <h2>Login to order.</h2>
                        <button type="button" class="switch_to_signup">New Member? Register here.</button>
                        <ul>
                            <li>
                                <input type="text" name="email" required>
                                <label>Email</label>
                            </li>   
                            <li>
                                <input type="password" name="password" required>
                                <label>Password</label>
                            </li>
                        </ul>
                        <button type="button">Login</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade form_modal" id="signup_modal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <button data-dismiss="modal" aria-label="Close" class="close_modal"></button>
                    <form action="process.php" method="post">
                        <h2>Signup to order.</h2>
                        <button type="button" class="switch_to_signup">Already a member? Login here.</button>
                        <ul>
                            <li>
                                <input type="text" name="email" required>
                                <label>Email</label>
                            </li>
                            <li>
                                <input type="password" name="password" required>
                                <label>Password</label>
                            </li>
                            <li>
                                <input type="password" name="password" required>
                                <label>Password</label>
                            </li>
                            <li>
                                <input type="password" name="password" required>
                                <label>Password</label>
                            </li>
                            <li>
                                <input type="password" name="password" required>
                                <label>Password</label>
                            </li>
                        </ul>
                        <button type="button">Signup</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="popover_overlay"></div>
</body>
</html>