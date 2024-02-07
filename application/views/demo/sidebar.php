<div class="sidebar">
    <img class="logo" src="<?php echo base_url(); ?>assets/img/logo-admin.png" alt=""/>

    <div class="menu">
        <ul>
            <li class="hasSub events">
                <i></i>
                <a class="<?php echo ($page == 'demo-temp-opportunities' || $page == 'demo-opportunities' ) ? 'active' : ''; ?>" href="#">Opportunity Demo</a>
                <ul class="sub">
                <li class="<?php echo ($page == 'demo-temp-opportunities') ? 'active' : ''; ?>"><a  href="<?php echo base_url() . ADMIN_URL; ?>/demo-unpublished">Unpublished Jobs Demo</a></li>
                <li class="<?php echo ($page == 'demo-opportunities') ? 'active' : ''; ?>"><a  href="<?php echo base_url() . ADMIN_URL; ?>/demo-published">Published Jobs Demo</a></li>    
                </ul>
            </li>
        </ul>
    </div>
</div>


<script>
    $(document).ready(function () {
        $('.hasSub > a').click(function () {
            $('.hasSub').children('.sub').slideUp();
            $('.hasSub').children('a').removeClass('temp-active');
            $(this).addClass('temp-active');
            $(this).siblings('.sub').slideToggle();
        });
    });
</script>