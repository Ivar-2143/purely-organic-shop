<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Products</title>

        <link rel="shortcut icon" href="../assets/images/organic_shop_fav.ico" type="image/x-icon">

        <script src="../assets/js/vendor/jquery.min.js"></script>
        <script src="../assets/js/vendor/popper.min.js"></script>
        <script src="../assets/js/vendor/bootstrap.min.js"></script>
        <script src="../assets/js/vendor/bootstrap-select.min.js"></script>
        <link rel="stylesheet" href="../assets/css/vendor/bootstrap.min.css">
        <link rel="stylesheet" href="../assets/css/vendor/bootstrap-select.min.css">

        <script src="<?=base_url('assets/js/global/global.js')?>"></script>
        <link rel="stylesheet" href="../assets/css/custom/global.css">
        <link rel="stylesheet" href="../assets/css/custom/product_dashboard.css">
    </head>
    <script>
        $(document).ready(function() {
            $('.categories_form').on('submit', function(e) {
                console.log('submitted');
                e.preventDefault();
                return false;
            });
            $('.categories').on('click',function(){
                console.log($(this));
                $('button.active').removeClass('active');
                let category = $(this).children()[2].innerHTML;
                $(this).addClass('active');
                $('#product-category').html(category + '(' + $(this).children()[0].innerHTML  + ')');
                $('#products>li').hide();
                if(category != 'All Products'){
                    $('#products>li.'+ category).show();
                }else{
                    $('#products>li').show();
                }
            })
        })
        function populate_csrf(){
            $.get('http://localhost.organic-shop/users/csrf',function(res){
                $('.csrf').replaceWith(res);
            });
        }
    </script>
    <body>
        <div class="wrapper">
<?php       $this->load->view('partials/customer_header',$user)?>
            <aside>
                <a href="catalogue.html"><img src="../assets/images/organic_shop_logo.svg" alt="Organic Shop"></a>
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
                <form action="process.php" method="post" class="categories_form">
<?php               $this->load->view('partials/csrf_input')?>
                    <h3>Categories</h3>
                    <ul>
                        <li>
                            <button class="categories" type="submit" class="active">
                                <span>11</span><img src="../assets/images/all_products.png" alt="#"><h4>All Products</h4>
                            </button>
                        </li>
                        <li>
                            <button class="categories" type="submit">
                                <span>3</span><img src="../assets/images/Vegetables.png" alt="#"><h4>Vegetables</h4>
                            </button>
                        </li>
                        <li>
                            <button class="categories" type="submit">
                                <span>1</span><img src="../assets/images/Fruits.png" alt="#"><h4>Fruits</h4>
                            </button>
                        </li>
                        <li>
                            <button class="categories" type="submit">
                                <span>2</span><img src="../assets/images/Meat.png" alt="#"><h4>Pork</h4>
                            </button>
                        </li>
                        <li>
                            <button class="categories" type="submit">
                                <span>4</span><img src="../assets/images/Grains.png" alt="#"><h4>Beef</h4>
                            </button>
                        </li>
                        <li>
                            <button class="categories" type="submit">
                                <span>1</span><img src="../assets/images/Dairy.png" alt="#"><h4>Chicken</h4>
                            </button>
                        </li>
                    </ul>
                </form>
                <div>
                    <h3 id="product-category">All Products(11)</h3>
                    <ul id="products">
<?php                   $this->load->view('partials/customer_product_cards',$products)?>
                    </ul>
                </div>
            </section>
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
                                <input type="text" name="first_name" required>
                                <label>First Name</label>
                            </li>
                            <li>
                                <input type="text" name="last_name" required>
                                <label>Last Name</label>
                            </li>
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
                                <label>Confirm Password</label>
                            </li>
                        </ul>
                        <button type="button">Signup</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="popover_overlay"></div>
    </body>
</html>