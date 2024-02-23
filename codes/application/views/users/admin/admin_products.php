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
    <link rel="stylesheet" href="../assets/css/vendor/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/vendor/bootstrap-select.min.css">

    <link rel="stylesheet" href="../assets/css/custom/admin_global.css">
    <script src="<?=base_url('assets/js/global/admin_products.js')?>"></script>
</head>
<script>
    $(document).ready(function() {
        // $("form").submit(function(event) {
        //     event.preventDefault();
        //     return false;
        // });
        /* prototype add */
        $(".switch").click(function() {
            window.location.href = "products_dashboard.html";
        });
    });
</script>
<body>
    <div class="wrapper">
        <header>
            <h1>Let’s provide fresh items for everyone.</h1>
            <h2>Products</h2>
            <div>
                <!-- <a class="switch" href="catalogue.html">Switch to Shop View</a> -->
                <button class="profile">
                    <img src="<?=base_url('assets/images/profile.png')?>" alt="#">
                </button>
            </div>
            <div class="dropdown show">
                <a class="btn btn-secondary dropdown-toggle profile_dropdown" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></a>
                <div class="dropdown-menu admin_dropdown" aria-labelledby="dropdownMenuLink">
                    <a class="dropdown-item" href="login.html">Logout</a>
                </div>
            </div>
        </header>
        <aside>
            <a href="#"><img src="<?=base_url('assets/images/organi_shop_logo_dark.svg')?>" alt="Organic Shop"></a>
            <ul>
                <li><a href="orders">Orders</a></li>
                <li class="active"><a href="products">Products</a></li>
            </ul>
        </aside>
        <section>
            <form action="process.php" method="post" class="search_form">
                <input type="text" name="search" placeholder="Search Products">
            </form>
            <button class="add_product" data-toggle="modal" data-target="#add_product_modal">Add Product</button>
            <form action="process.php" method="post" class="categories_form">
                <?php   $this->load->view('partials/csrf_input')?>
                <h3>Categories</h3>
                <ul>
<?php               $this->load->view('partials/category_nav',$categories)?>
                </ul>
            </form>
            <div>
                <table class="products_table">
                    <thead>
                        <tr>
                            <th><h3>All Products</h3></th>
                            <th>ID #</th>
                            <th>Price</th>
                            <th>Caregory</th>
                            <th>Inventory</th>
                            <th>Sold</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody class="product_content">
<?php                   $this->load->view('partials/admin_row_products',$products);?>
                    </tbody>
                </table>
            </div>
        </section>
        <div class="modal fade form_modal" id="add_product_modal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <button data-dismiss="modal" aria-label="Close" class="close_modal"></button>
                    <form class="add_product_form" data-modal-action="0" action="<?=base_url('products/process')?>" method="post" enctype="multipart/form-data">
                        <div class="error-message"></div>
                        <h2>Add a Product</h2>
                        <ul>
                            <li>
                                <input type="text" name="product_name">
                                <label>Product Name</label>
                            </li>
                            <li>
                                <textarea name="description"></textarea>
                                <label>Description</label>
                            </li>
                            <li>
                                <label>Category</label>
                                <select class="selectpicker category-picker" name="category">
                                </select>
                            </li>
                            <li>
                                <input type="number" name="price" value="1" step="0.01">
                                <label>Price</label>
                            </li>
                            <li>
                                <input type="number" name="inventory" value="1">
                                <label>Inventory</label>
                            </li>
                            <li>
                                <label class="image_label">Upload Images (4 Max)</label>
                                <ul>
                                    <li><button type="button" class="upload_image"></button></li>
                                </ul>
                                <ul class="image_preview_list">
                                </ul>
                                <input class="image_input" type="file" name="image" accept="image/*">
                                <input name="image_index" type="hidden" value="">   
                            </li>
                        </ul>
                        <input type="hidden" id="csrf">
                        <input class="form_data_action" name="form_action" type="hidden" value="add_product">
                        <button type="button" data-dismiss="modal" aria-label="Close">Cancel</button>
                        <button type="submit">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="popover_overlay"></div>
</body>
</html>