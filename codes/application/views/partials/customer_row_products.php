<?php
foreach($cart_items as $cart_item){
    $images = json_decode($cart_item['image_links_json'],TRUE);
    $image = $images['main_image']?>
    <li>
        <img src="<?=base_url('assets/images/products/'.$cart_item['category_id'].'/'.$cart_item['name'].'/'.$image)?>" alt="">
        <h3><?=$cart_item['name']?></h3>
        <span>$ <?=$cart_item['price']?></span>
        <ul>
            <li class="form_controls">
                <label for="<?=$cart_item['id']?>" >Quantity</label>
                <input id="<?=$cart_item['id']?>" name="quantity" type="text" min-value="1" value="<?=$cart_item['quantity']?>">
                <ul>
                    <li><button title="increase" type="button" class="increase_decrease_quantity btn_increase_qty" data-quantity-ctrl="1" value="<?=$cart_item['id']?>"></button></li>
                    <li><button title="decrease" type="button" class="increase_decrease_quantity btn_decrease_qty" data-quantity-ctrl="0" value="<?=$cart_item['id']?>"></button></li>
                </ul>
            </li>
            <li>
                <label>Total Amount</label>
                <span class="total_amount">$ <?=$cart_item['total_amount']?></span>
            </li>
            <li>
                <button title="Remove" type="button" class="remove_item"></button>
            </li>
        </ul>
        <div>
            <p>Are you sure you want to remove this item?</p>
            <button type="button" class="cancel_remove">Cancel</button>
            <button type="button" class="remove">Remove</button>
        </div>
    </li>
<?php
}?>
