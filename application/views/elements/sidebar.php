<div class="sidebar">
    <img class="logo" src="<?php echo base_url(); ?>assets/img/logo-admin.png" alt=""/>

    <div class="menu">
        <ul>
            <!--<li class="hasSub news">
                <i></i>
                <a class="<?php echo ($page == 'add-category' || $page == 'all-categories' || $page == 'edit-category') ? 'active' : ''; ?>" href="#">Category</a>
                <ul class="sub">
                    <li class="<?php echo ($page == 'add-category') ? 'active' : ''; ?>"><a href="<?php echo base_url() . ADMIN_URL; ?>/add-category">Add Category</a></li>
                    <li class="<?php echo ($page == 'all-categories') ? 'active' : ''; ?>"><a  href="<?php echo base_url() . ADMIN_URL; ?>/all-categories">All Categories</a></li>
                </ul>
            </li>-->
            <li class="hasSub events">
                <i></i>
                <a class="<?php echo ($page == 'add-opportunity' || $page == 'all-opportunities' || $page == 'edit-opportunity' || $page == 'all-opportunities-temp' || $page == 'edit-opportunity-temp') ? 'active' : ''; ?>" href="#">Opportunity</a>
                <ul class="sub">
                <li class="<?php echo ($page == 'edit-opportunity-temp' || $page == 'all-opportunities-temp') ? 'active' : ''; ?>"><a  href="<?php echo base_url() . ADMIN_URL; ?>/opportunities-temp">Unpublished Jobs</a></li>
                    <li class="<?php echo ($page == 'all-opportunities' || $page == 'edit-opportunity') ? 'active' : ''; ?>"><a  href="<?php echo base_url() . ADMIN_URL; ?>/all-opportunities">Published Jobs</a></li>
                    <li class="<?php echo ($page == 'add-opportunity') ? 'active' : ''; ?>"><a href="<?php echo base_url() . ADMIN_URL; ?>/add-opportunity">Add Job</a></li>
                </ul>
            </li>
            <?php if('show' != 'show') { ?>
            <li class="hasSub inquiries">
                <i></i>
                <a class="<?php echo ($page == 'import' || $page == 'jd-import') ? 'active' : ''; ?>" href="#">Import</a>
                <ul class="sub">
                    <li class="<?php echo ($page == 'import') ? 'active' : ''; ?>"><a href="<?php echo base_url() . ADMIN_URL; ?>/import">Import Jobs</a></li>
                    <li class="<?php echo ($page == 'jd-import') ? 'active' : ''; ?>"><a  href="<?php echo base_url() . ADMIN_URL; ?>/jd-import">Import Job Descriptions</a></li>
                </ul>
            </li>
            <li class="inspired" style="display: none;">
                <i></i>
                <a class="<?php echo ($page == 'post-updates') ? 'active' : ''; ?>" href="<?php echo base_url() . ADMIN_URL; ?>/post-updates">Logs</a>
            </li>
            <?php } ?>
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