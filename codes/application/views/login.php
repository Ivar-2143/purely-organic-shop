<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Organic Shop: Let’s order fresh items for you.</title>

    <link rel="shortcut icon" href="../assets/images/organic_shop_favicon.ico" type="image/x-icon">

    <script src="../assets/js/vendor/jquery.min.js"></script>
    <script src="../assets/js/vendor/popper.min.js"></script>
    <script src="../assets/js/vendor/bootstrap.min.js"></script>
    <script src="../assets/js/vendor/bootstrap-select.min.js"></script>
    <link rel="stylesheet" href="../assets/css/vendor/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/vendor/bootstrap-select.min.css">

    <script src="../assets/js/global/dashboard.js"></script>
    <link rel="stylesheet" href="<?=base_url('assets/css/custom/global.css')?>">
    <link rel="stylesheet" href="<?=base_url('assets/css/custom/signup.css')?>">
</head>
<script>
    $(document).ready(function() {
        $("input[name=email]").focus();
        // $("form").submit(function(event) {
        //     event.preventDefault();
        //     return false;
        // });
        /* prototype add */
        // $(".login_btn").click(function() {
        //     window.location.href = "catalogue.html";
        // });
    });
</script>
<body>
    <div class="wrapper">
        <a href="/dashboard"><img src="../assets/images/organic_shop_logo_large.svg" alt="Organic Shop"></a>
        <form action="login/process" method="post" class="login_form">
            <?php $this->load->view('partials/csrf_input')?>
            <h2>Login</h2>
            <a href="signup">New Member? Register here.</a>
            <ul>
                <li>
                    <input id="email" type="text" name="email">
                    <label for="email">Email</label>
                </li>
                <li>
                    <input id="pass" type="password" name="password">
                    <label for="pass">Password</label>
                </li>
            </ul>
            <button type="submit" class="login_btn">Login</button>
            <input type="hidden" name="action" value="login">
        </form>
    </div>
<?php   
    $login = $this->session->flashdata('login');?>
    <script>
<?php
    if($login){?>
        $('<?=$login?>')
            .insertAfter('form')
            .fadeIn()
            .delay(1000)
            .fadeOut(function(){
                $(this).remove();
            });
<?php
    }
?>
    </script>
</body>
</html>