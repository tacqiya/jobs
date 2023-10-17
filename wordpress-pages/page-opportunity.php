<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.0
 */
get_header('ku-career');
?>

<?php
if (have_posts()) : the_post();
    $banner = get_field('banner_image');
    ?>

    <link href="<?php bloginfo('template_directory'); ?>/assets/scss/<?= ($arabic) ? 'arabic/' : ''; ?>admissions.css?ver=<?php echo rand(111, 999) ?>" type="text/css" rel="stylesheet"/>
    <link href="<?php bloginfo('template_directory'); ?>/assets/scss/<?= ($arabic) ? 'arabic/' : ''; ?>responsive/admissions-responsive.css?ver=<?php echo rand(111, 999) ?>" type="text/css" rel="stylesheet"/>

    <?php
    global $wpdb;
    $table_opportunity = $wpdb->prefix . 'career_job';
    $slug = $_GET['redirectionURI'];
    $opportunities = $wpdb->get_results("SELECT * FROM $table_opportunity WHERE slug= '$slug'");
    ?>

    <div class="banner" style="background:url(<?php
    if ($opportunities[0]->image) {
        echo site_url() . '/career-opportunities/uploads/' . $opportunities[0]->image;
    } else {
        echo "/wp-content/themes/khalifauniversity/assets/img/careers/c_opportunities_banner.jpg";
    }
    ?>) center top;">

        <div class="wrapper">
            <div class="caption">            
                <div class="inner">
                    <h1><?= $opportunities[0]->description_value ?></h1>
                </div>
            </div>
        </div>
        <div class="breadcrumb">
            <div class="wrapper">
                <span><a href="<?php echo site_url(); ?>"><?php echo __('Home', 'themedomain') ?></a> | <a href="<?php echo get_the_permalink(75783); ?>"><?php echo get_post_field('post_title', 75783); ?></a> | <?= $opportunities[0]->description_value ?></span>
            </div></div>
    </div>

    <div class="container" id="c-opportunities-sub">
        <div class="wrapper"> 
            <div class="first_blk">
                <div class="blks">
                    <?php if ($opportunities[0]->requisition_id) { ?>
                        <div class="blk blk-2 clear">
                            <div class="left_blk inner"><h4>Position Code</h4></div>
                            <div class="right_blk inner"><p><?= $opportunities[0]->requisition_id ?></p></div> <!-- change -->
                        </div>
                    <?php } if ($opportunities[0]->description_value) { ?>
                        <div class="blk blk-4 clear">
                            <div class="left_blk inner"><h4>Position Title</h4></div>
                            <div class="right_blk inner"><p><?= $opportunities[0]->description_value ?></p></div>
                        </div>
                    <?php } if ($opportunities[0]->hiring_manager_name) {
                        if($opportunities[0]->category == 'Research') { ?>
                        <div class="blk blk-6 clear">
                            <div class="left_blk inner"><h4>Hiring Manager</h4></div>
                            <div class="right_blk inner"><p><?= $opportunities[0]->hiring_manager_name ?></p></div>
                        </div>
                    <?php } } if ($opportunities[0]->dept_name) { ?>
                        <?php if(strtolower($opportunities[0]->dept_name) != 'temp researcher internal fund' && strtolower($opportunities[0]->dept_name) != 'temp researcher external fund') { ?>
                        <div class="blk blk-9 clear">
                            <div class="left_blk inner"><h4>Department</h4></div>
                            <div class="right_blk inner"><p><?= $opportunities[0]->dept_name ?></p></div> <!-- change -->
                        </div>
                    <?php } } if ($opportunities[0]->closing_date) { ?>
                        <div class="blk blk-9 clear">
                            <div class="left_blk inner"><h4>Closing Date</h4></div>
                            <div class="right_blk inner"><p><?= $opportunities[0]->closing_date ?></p></div>
                        </div>
                    <?php } if ($opportunities[0]->years_of_experience) { ?>
                        <div class="blk blk-9 clear">
                            <div class="left_blk inner"><h4>Years of Experience</h4></div>
                            <div class="right_blk inner"><p><?= $opportunities[0]->years_of_experience ?></p></div>
                        </div>
                    <?php } ?>
                </div>
            </div>

            <!--
            <?php //foreach ((array)json_decode(($opportunities[0]->all_descriptions)) as $key => $desc) { ?>
                <br class="px-60">

                <div class="position_over">
                    <h2><?php //$key     ?></h2>
                    php //$desc ?>
                </div>
            <?php //} ?>
            -->

            <br class="px-40">
            
            <div class="position_over">
                <h2>Description</h2>
                <br class="px-10">
                <?= $opportunities[0]->descriptions ?>
                <br class="px-40">
                <!-- <h2>Qualifications</h2>
                <br class="px-10"> -->
                <?php // $opportunities[0]->qualifications ?>
            </div>

            <br class="px-60">

            <div class="dbl_blk clear">
                <!--                <a class="left_blk"> Position Description</a>-->
                <a href="<?= $opportunities[0]->apply_link ?>" class="right_blk">Apply Now</a>
            </div>

            <br class="px-60">

            <div class="career_links clear">
                <ul class="clear">
                    <li><a href="<?php echo get_the_permalink(75783); ?>">Current Opportunities</a></li>
                    <li><a href="<?php echo get_the_permalink(75781); ?>">Employee Benefits</a></li>
                    <li><a href="<?php echo get_the_permalink(75785); ?>">Information for Applicants</a></li>
                    <li><a href="<?php echo get_the_permalink(14); ?>">About KU and AbuDhabi</a></li>
                </ul>
            </div>
        </div>
    </div>



    <script>
        $(document).ready(function () {
            $('.tab-type-1 .tab').click(function () {
                id = $(this).data('id');
                parent = $(this).closest('.tab-type-1');
                $(parent).children('.tabs').children('.tab').removeClass('active');
                $(this).addClass('active');
                $(parent).children('.tab-dtls').children('.tab-dtl').hide();
                $(parent).children('.tab-dtls').children('.tab-dtl-' + id).fadeIn();
            });

        });

        $(document).ready(function () {
            //            if (window.innerWidth > 642) {
            //            $('.first_blk .blk').each(function () {
            //                $(this).find('.left_blk').height($(this).find('.right_blk').height() - 20);
            //            });
            //            }
            if (window.innerWidth > 500) {
                for (i = 1; i <= 9; i++) {
                    console.log(i);

                    $('.first_blk .blk-' + i + ' .inner').each(function () {
                        left_height = $(this).parent('.blk-' + i).children('.left_blk').height();
                        console.log(left_height + ' -left');
                        right_height = $(this).parent('.blk-' + i).children('.right_blk').height();
                        console.log(right_height + ' -right');
                        if (left_height > right_height) {
                            $(this).parent('.blk-' + i).children('.right_blk').height(left_height - 20);
                        } else {
                            $(this).parent('.blk-' + i).children('.left_blk').height(right_height - 20);
                        }
                    });
                }

            }
        });

    </script>
<?php endif; ?>
<?php
get_footer('ku-career');