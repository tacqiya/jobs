<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>ADMIN - CAREER OPPORTUNITIES</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <link rel="shortcut icon" href="<?php echo base_url(); ?>assets/img/favicon.png">
    <!--styles-->

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <script src="<?php echo base_url(); ?>assets/js/jquery-3.6.0.min.js" type="text/javascript"></script>
    <link href="<?php echo base_url(); ?>assets/scss/reset_css.css?v=2.0" type="text/css" rel="stylesheet" />
    <link href="<?php echo base_url(); ?>assets/scss/admin.css?v=2.0" type="text/css" rel="stylesheet" />
    <link href="<?php echo base_url(); ?>assets/scss/responsive/admin-responcive.css?v=2.0" type="text/css" rel="stylesheet" />
    <link href="<?php echo base_url(); ?>assets/scss/admin-alert.css?v=2.0" type="text/css" rel="stylesheet" />
    <script src="<?php echo base_url(); ?>assets/plugins/ckeditor/ckeditor.js" type="text/javascript"></script>
    <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/jqueryConfirm/dist/jquery-confirm.min.css" />
    <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/jqueryConfirm/css/jquery-confirm.custom.min.css" />
    <script src="<?= base_url() ?>assets/plugins/jqueryConfirm/dist/jquery-confirm.min.js"></script>
</head>

<body id="<?php echo $page; ?>-page" class="scrollable">

    <header class="clear">
        <span class="welcome left">Admin panel</span>
        <a href="<?php echo base_url() . ADMIN_URL; ?>/logout" class="logout right">Logout</a>
    </header>

    <div class="container clear">

        <?php
        if (isset($result)) {
        ?>
            <div class="alert-box <?php echo $result['type']; ?>"><span><?php echo $result['type']; ?> : </span><?php echo $result['msg']; ?></div>
        <?php
        }
        ?>

        <script>
            $(document).ready(function() {
                setTimeout(function() {
                    $('.alert-box').fadeOut();
                }, 5000);
            });
        </script>