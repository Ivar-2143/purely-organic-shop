    <li>
        <button type="submit" class="<?=(!isset($current_category) || $current_category == 0)?'active':'';?>" data-category="0" data-category-name="All Products">
            <span><?=$total_products['total_count']?></span><img src="../assets/images/all_products.png" alt="#"><h4>All Products</h4>
        </button>
    </li>
<?php
foreach($categories as $category){?>
    <li>
        <button type="submit" class="<?=(isset($current_category) && $current_category == $category['id'])?'active':''?>" data-category="<?=$category['id']?>" data-category-name="<?=$category['name']?>">
            <span><?=$category['product_count']?></span><img src="<?=base_url('assets/images/categories/'.$category['image'])?>" alt="#"><h4><?=$category['name']?></h4>
        </button>
    </li>
<?php
}   ?>