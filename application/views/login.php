<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>ADMIN - CAREER OPPORTUNITIES</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <link rel="shortcut icon" href="assets/img/favicon.png">
        <!--styles--> 
        <link href="<?php echo base_url(); ?>assets/scss/reset_css.css?v=2.0" type="text/css"  rel="stylesheet"/>
        <link href="<?php echo base_url(); ?>assets/scss/admin-login.css?v=2.0" type="text/css" rel="stylesheet"/>

    </head>  
    <body  class="scrollable">

        <div class="container">
            <?php
            if (isset($results)) {
                echo $results;
            }
            ?>
            <form method="post">
                <img class="logo" src="<?php echo base_url(); ?>assets/img/logo.png" alt=""/>
                <input class="input" type="text" name="username" placeholder="Username" required/>
                <input class="input" type="password" name="password" placeholder="Password" required/>
                <input class="submit" type="submit" Value="Sign in"/>
            </form>
        </div>

    </body>
</html>