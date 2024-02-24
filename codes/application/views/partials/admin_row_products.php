<?php
foreach($products as $product){   
    $images = json_decode($product['image_links_json'],TRUE)?>
    <tr>
        <td>
            <span>
                <img src="<?=base_url('assets/images/products/'.$product['category_id'].'/'.$product['name'].'/'.$images['main_image'])?>" alt="<?=$product['name']?>">
                <?=$product['name']?>
            </span>
        </td>
        <td><span><?=$product['id']?></span></td>
        <td><span>$ <?=$product['price']?></span></td>
        <td><span><?=$product['category']?></span></td>
        <td><span><?=$product['stocks']?></span></td>
        <td><span><?=rand(0,1000)?></span></td>
        <td>
            <span>
                <button class="edit_product" value="<?=$product['id']?>">Edit</button>
                <button class="delete_product">X</button>
            </span>
            <form class="delete_product_form" action="<?=base_url('products/remove/'.$product['id'])?>" method="post">
<?php           $this->load->view('partials/csrf_input')?>
                <p>Are you sure you want to remove this item?</p>
                <button type="button" class="cancel_remove">Cancel</button>
                <button type="submit">Remove</button>
            </form>
        </td>
    </tr>
<?php
}?>