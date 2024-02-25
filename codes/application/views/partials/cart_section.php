<form class="search_form">
    <input type="text" name="search" placeholder="Search Products">
</form>
<button class="show_cart">Cart (<?=count($cart_items)   ?>)</button>
<section>
    <form action="<?=base_url('carts/update')?>" method="post" class="cart_items_form">
        <ul>
<?php       $this->load->view('partials/customer_row_products')?>
        </ul>
<?php       $this->load->view('partials/csrf_input')?>
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
        <h4>Items <span>$ <?=$total['total_amount']?></span></h4>
        <h4>Shipping Fee <span>$ 5</span></h4>
        <h4 class="total_amount">Total Amount <span>$ <?=$total['total_amount']+5?></span></h4>
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#card_details_modal">Proceed to Checkout</button>
    </form>
</section>