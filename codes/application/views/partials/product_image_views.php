    <img id="food_preview" src="<?=base_url('assets/images/products/'.$product['category_id'].'/'.$product['name'].'/'.$main_image)?>" alt="food">
    <ul>
<?php
    foreach($images as $image){?>
        <li class="<?=($image == $main_image)?'active':''?>"><button class="show_image"><img src="<?=base_url('assets/images/products/'.$product['category_id'].'/'.$product['name'].'/'.$image)?>" alt="<?$product['name']?>"></button></li>
<?php
    }?>
    </ul>