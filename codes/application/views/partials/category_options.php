<?php
    foreach($categories as $key => $category){?>
        <option value="<?=$category['id']?>"><?=$category['name']?></option>
<?php
    }?>