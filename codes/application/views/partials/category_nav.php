    <li>
        <button type="submit" class="active">
            <span>0</span><img src="../assets/images/all_products.png" alt="#"><h4>All Products</h4>
        </button>
    </li>
<?php
foreach($categories as $category){?>
    <li>
        <button type="submit">
            <span><?=$category['product_count']?></span><img src="<?=base_url('assets/images/categories/'.$category['image'])?>" alt="#"><h4><?=$category['name']?></h4>
        </button>
    </li>
<?php
}   ?>