<?php
if(!isset($main_image) OR $main_image >= count($images)){
    $main_image = 0;
}
if($images){
    foreach($images as $key => $image){?>
        <li>
            <img class="<?=($key == $main_image)? 'active' : '';?>" src="<?=base_url('assets/images/uploads/'.$image)?>" alt="">
            <label class=""><input type="checkbox" name="main_image" value="<?=$key?>" <?=($key == $main_image)? 'checked' : '';?>>Mark As Main</label>
            <button type="submit" class="delete_image" data-image-index="<?=$key?>">
        </li>                          
<?php
    }   
}   ?>