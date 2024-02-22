<?php
if($images){
    foreach($images as $key => $image){?>
        <li><img src="<?=base_url('assets/images/uploads/'.$image)?>" alt=""><button type="submit" class="delete_image" data-image-index="<?=$key?>"></li>                          
<?php
    }   
}   ?>