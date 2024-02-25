<form action="users/logout" method="post">
<?php   $this->load->view('partials/csrf_input')?>
    <button class="logout_btn text-left" type="submit" value="Logout">Logout</button>
</form>
<header>
    <h1>Let’s order fresh items for you.</h1>
<?php 
if(isset($user)){?>
    <div>
        <div class="profile_btn">
            <span><?=$user['initials']?></span>
            <?=$user['full_name']?>
        </div>
    </div>
<?php
}else{  ?>
    <div>
        <a class="signup_btn" data-toggle="modal" data-target="#signup_modal">Signup</a>
        <a class="login_btn"  data-toggle="modal" data-target="#login_modal">Login</a>
    </div>
<?php
}   ?>
</header>