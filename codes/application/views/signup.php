<?php $registration = $this->session->flashdata('registration');?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Organic Shop: Let’s order fresh items for you.</title>

    <link rel="shortcut icon" href="assets/images/organic_shop_favicon.ico" type="image/x-icon">

    <script src="../assets/js/vendor/jquery.min.js"></script>
    <script src="../assets/js/vendor/popper.min.js"></script>
    <script src="../assets/js/vendor/bootstrap.min.js"></script>
    <script src="../assets/js/vendor/bootstrap-select.min.js"></script>
    <link rel="stylesheet" href="../assets/css/vendor/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/vendor/bootstrap-select.min.css">

    <script src="<?=base_url('assets/js/global/global.js')?>"></script>
    <link rel="stylesheet" href="../assets/css/custom/global.css">
    <link rel="stylesheet" href="<?=base_url('assets/css/custom/signup.css')?>">
</head>
<script>
    $(document).ready(function() {
        // $("form").submit(function(event) {
        //     event.preventDefault();
        //     console.log('submitted');
        //     return false;
        // });
        /* prototype add */
        $(".signup_btn").click(function() {
            $('.popover_overlay')
                .fadeIn()
                .delay(1000)
                .fadeOut();
            // $("<span class='notif notif-success'>Successfully registered</span>")
            // .insertAfter($('form'))
            // .fadeIn()
            // .delay(1000)
            // .fadeOut(function(){
            //     $(this).remove();
            // })
            // window.location.href = "login.html";
        });
    });
</script>
<body>
    <div class="wrapper">
        <a href="/dashboard"><img src="../assets/images/organic_shop_logo_large.svg" alt="Organic Shop"></a>
        <form action="signup/process" method="post">
            <?php $this->load->view('partials/csrf_input')?>
            <h2>Signup</h2>
            <a href="login">Already a member? Login here.</a>
            <ul>
                <li>
                    <input id="fn" type="text" name="first_name">
                    <label for="fn">First Name</label>
                </li>
                <li>
                    <input id="ln" type="text" name="last_name">
                    <label for="ln">Last Name</label>
                </li>
                <li>
                    <input id="email" type="email" name="email">
                    <label for="email">Email</label>
                </li>
                <li>
                    <input id="pass" type="password" name="password">
                    <label for="pass">Password</label>
                </li>
                <li>
                    <input id="conf_pass" type="password" name="confirm_password">
                    <label for="conf_pass">Confirm Password</label>
                </li>
            </ul>
            <button class="signup_btn" type="submit">Signup</button>
            <input type="hidden" name="action" value="signup">
        </form>
    </div>
    <div class="popover_overlay"></div>
    <script>
<?php

if(isset($registration['errors'])){
    foreach($registration['errors'] as $key => $value){
?>      
        console.log( $('input[name="<?=$key?>"]'))
        $('input[name="<?=$key?>"]').addClass('error');
        $("<?=$value?>")
            .insertAfter($('input[name="<?=$key?>"]').siblings());
<?php
    }
}
if(isset($registration['message'])){
?>
    setTimeout(function(){
        $("<?=$registration['message']?>")
        .insertAfter($('form'))
        .fadeIn()
        .delay(1000)
        .fadeOut(function(){
            $(this).remove();
        })    
    },250);
    
<?php
}
?>    
    </script>
</body>
</html>