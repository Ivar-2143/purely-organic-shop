<?php
foreach($products as $product){
    $images = json_decode($product['image_links_json'],TRUE)?>
    <li class="<?=$product['category']?>">
        <a href="products/view/<?=$product['id']?>">
            <img src="<?=base_url('assets/images/products/'.$product['category_id'].'/'.$product['name'].'/'.$images['main_image'])?>" alt="<?$product['name']?>">
            <h3><?=$product['name']?></h3>
            <ul class="rating">
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li class="blank"></li>
            </ul>
            <span>36 Rating</span>
            <span class="price">$ <?=$product['price']?></span>
        </a>
    </li>
<?php
}?>