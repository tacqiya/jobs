<?php
$preview = (isset($_GET['preview']))?true:false;
if(!$preview){
  header('Location: https://careers.ku.ac.ae/careersection/ku+external+portal/moresearch.ftl?lang=en&portal=8116755942');
  exit();
}
if (isset($_POST['job-search'])) {
    if ($_POST['search-job'] != '') {
        global $wpdb;
        $table_category = $wpdb->prefix . 'opportunity_categories';
        $table_opportunity = $wpdb->prefix . 'career_job';
        $key_word = $_POST['search-job'];
        $search_result = $wpdb->get_results("SELECT * FROM $table_opportunity WHERE publish='published' AND (description_value LIKE '%$key_word%' or project_auth_name LIKE '%$key_word%' or position_type LIKE '%$key_word%' or
                project_title LIKE '%$key_word%' or dept_name LIKE '%$key_word%' or relevant_research_center LIKE '%$key_word%' or technical_keywords LIKE '%$key_word%' or descriptions LIKE '%$key_word%') ");
//        echo "<pre>"; print_r($search_result); exit;
        if (!$search_result) {
            $search_result = ['error' => 'No results found'];
        }
    }
}
?>

<?php
get_header('ku-career');
?>

<?php
if (have_posts()) : the_post();
    $banner = get_field('banner_image');
    ?>

    <link href="<?php bloginfo('template_directory'); ?>/assets/scss/<?= ($arabic) ? 'arabic/' : ''; ?>admissions.css?ver=<?php echo rand(111, 999) ?>" type="text/css" rel="stylesheet"/>
    <link href="<?php bloginfo('template_directory'); ?>/assets/scss/<?= ($arabic) ? 'arabic/' : ''; ?>responsive/admissions-responsive.css?ver=<?php echo rand(111, 999) ?>" type="text/css" rel="stylesheet"/>
    <style>
        .hide {
            display: none !important
        }
    </style>

    <link href="<?php bloginfo('template_directory'); ?>/assets/plugins/paginationjs/pagination.css" type="text/css" rel="stylesheet"/>
    <script src="<?php bloginfo('template_directory'); ?>/assets/plugins/paginationjs/pagination.js"></script>
    <script src="<?php bloginfo('template_directory'); ?>/assets/plugins/paginationjs/pagination.min.js"></script>
    <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>-->
    <!--    <script src="https://cdnjs.cloudflare.com/ajax/libs/simplePagination.js/1.6/jquery.simplePagination.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/simplePagination.js/1.6/simplePagination.min.css">-->

    <div class="banner" style="background:url(<?php
    if ($banner) {
        echo $banner;
    } else {
        echo "/wp-content/themes/khalifauniversity/assets/img/careers/c_opportunities_banner.jpg";
    }
    ?>) center top;">

        <div class="wrapper">
            <div class="caption">            
                <div class="inner">
                    <h1><?php the_title(); ?></h1>
                </div>
            </div>
        </div>
        <div class="breadcrumb">
            <div class="wrapper">
                <span><a href="<?php echo site_url(); ?>"><?php echo __('Home', 'themedomain') ?></a> | <a href="<?php echo get_the_permalink(75779); ?>"><?php echo get_post_field('post_title', 75779); ?></a> | <?php the_title(); ?></span>
            </div></div>
    </div>

    <div class="container" id="c-opportunities">
        <div class="wrapper"> 
            <div class="search_section clear">
                <div class="left_blk"><h3>Search Keywords</h3></div>
                <div class="right_blk">
                    <form action="" method="post">
                        <input type="text" name="search-job" id="search" <?= ($_POST['search-job']) ? 'value="' . $_POST['search-job'] .'"' : ''; ?>>
                        <input type="submit" name="job-search" value="search" id="job-search-btn">
                    </form>
                </div>
            </div>
            <?php if ($search_result) { ?>
                <br class="px-60">

                <div class="content_section search-opportunities">
                    <div class="content" style="display: block;">
                        <div class="blks">

                        </div>
                    </div>

                </div>
                <div class="pagination_section">
                    <h3 class="pager"></h3>
                <br class="px-20">
        <!--                    <h3>RESULTS <span>1 - 50</span> of <span>297</span></h3>-->
                    <div class="pagination" id="pagination-se"></div>
                </div>
            <?php } else { ?>
                <?php
                global $wpdb;
                $table_category = $wpdb->prefix . 'opportunity_categories';
                $table_opportunity = $wpdb->prefix . 'career_job';
                $categories = $wpdb->get_results("SELECT * FROM $table_category");
//            echo "<pre>"; print_r($categories); exit;
                ?>
                <div class="menu_section">
                    <div class="blks clear" >
                        <?php
                        if ($categories) {
                            $i = 1;
                            foreach ($categories as $cat) {
                                ?>
                                <a class="blk menu_item <?= ($i == 1) ? 'active' : ''; ?>" data-id="<?= $i ?>" onclick="section(this, '<?= $cat->title ?>')"><?= $cat->title ?></a>
                                <?php
                                $i++;
                            }
                        }
                        ?>
                    </div>
                </div>
                <div class="menu_section_sub clear">
                    <button class="dropbtn">Job Categories</button>
                    <div class="dropdown-content">
                        <?php
                        if ($categories) {
                            $i = 1;
                            foreach ($categories as $cat) {
                                ?>
                                <a class="blk menu_item <?= ($i == 1) ? 'active' : ''; ?>" data-id="<?= $i ?>" onclick="section(this, '<?= $cat->title ?>')"><?= $cat->title ?></a>
                                <?php
                                $i++;
                            }
                        }
                        ?>
                    </div>
                </div>
                <div class="blockser_sub clear">
                    <button class="dropbtn">Colleges</button>
                    <div class="dropdown-content">
                        <span data-id="1">College of Engineering</span>
                        <span data-id="2">College of Arts and Science</span>
                        <span data-id="3">College of Medicine and Health Science</span>
                    </div>
                </div>

                <br class="px-60">

                <div class="content_section opportunities">
                    <?php
                    if ($categories) {
                        $i = 1;
                        foreach ($categories as $cat) {
                            ?>
                            <div id="<?= $cat->title ?>" class="content content-<?= $i ?>">
                                <?php if ($cat->title == 'Faculty') { ?>
                                    <div class="faculty clear">
                                        <div class="blockser">
                                            <span class="blk-sec active" data-id="1">College of Engineering</span>
                                            <span class="blk-sec" data-id="2">College of Arts and Science</span>
                                            <span class="blk-sec" data-id="3">College of Medicine and Health Science</span>
                                        </div>
                                        <br class="px-60">
                                        <div class="inside-blk inside-blk-1">
                                            <div id="blocker-1" class="blockers">
                                            </div>
                                            <div class="pagination_sec clear">
                                                <h3 class="pager-inside-1"></h3>
                                                <div class="pagination-inside" id="pagination-inside-1"></div>
                                            </div>
                                        </div>
                                        <div class="inside-blk inside-blk-2">
                                            <div id="blocker-2" class="blockers">
                                            </div>
                                            <div class="pagination_sec clear">
                                                <h3 class="pager-inside-2"></h3>
                                                <div class="pagination-inside" id="pagination-inside-2"></div>
                                            </div>
                                        </div>
                                        <div class="inside-blk inside-blk-3">
                                            <div id="blocker-3" class="blockers">
                                            </div>
                                            <div class="pagination_sec clear">
                                                <h3 class="pager-inside-3"></h3>
                                                <div class="pagination-inside" id="pagination-inside-3"></div>
                                            </div>
                                        </div>
                                        <div class="inside-blk inside-blk-4">
                                            <div id="blocker-4" class="blockers">
                                            </div>
                                            <div class="pagination_sec clear">
                                                <h3 class="pager-inside-4"></h3>
                                                <div class="pagination-inside" id="pagination-inside-4"></div>
                                            </div>
                                        </div>
                                    </div>
                                <?php } else { ?>
                                    <div class="blks">
                                    </div>
                                    <div class="pagination_section clear">
                                        <h3 class="pager-<?= $i ?>"></h3>
                                        <div class="pagination" id="pagination-<?= $i ?>"></div>
                                    </div>
                                <?php } ?>

                            </div>
                            <?php
                            $i++;
                        }
                    }
                    ?>

                </div>

            <?php } ?>

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

    <?php if ($search_result) { ?>
        <script>
            function template(data) {
                for (var i = 0, len = data.length; i < len; i++) {

                    var trimmedString = $(data[i].descriptions).text().substr(0, 500);//data[i].descriptions.substr(0, 500);
                    // trimmedString = trimmedString.substr(0, Math.min(trimmedString.length, trimmedString.lastIndexOf(" ")));
                    // trimmedString = trimmedString.replace(/<\/?[^>]+(>|$)/g, "");

                    var apply_before = '';
                    if (data[i].closing_date !== null) {
                        apply_before = '<h4>Apply before :</h4>' +
                                '<h5>' + data[i].closing_date + '</h5>';
                    }
                    data[i] = '<div class="blk blk-' + data[i].slug + '">' +
                            '<h3>' + data[i].description_value + '</h3>' +
                            '<h4 class="department">Department : ' + data[i].dept_name + '</h4>' +
                            '<p>' + trimmedString + '</p>' +
                            '<div class="details clear">' +
                            '<ul class="clear">' +
                            '<li class="date">' +
                            apply_before +
                            '</li>' +
                            '</ul>' +
                            '</div>' +
                            '<a href="<?= get_the_permalink(75787) . '/?lang=en&redirectionURI=' ?>' + data[i].slug + '">Further details</a>' +
                            '<hr>' +
                            '</div>';
                }

                return data.join("");
            }

            DATA_SOURCE = <?= (!isset($search_result['error'])) ? json_encode($search_result) : '[]' ?>;


            $('#pagination-se').pagination({
                dataSource: DATA_SOURCE,
                pageSize: 10,
                hideWhenLessThanOnePage: true,
                autoHidePrevious: true,
                autoHideNext: true,
                callback: function (data, pagination) {
                    // template method of yourself
                    var html = template(data);
                    //                    console.log(pagination);
                    if (pagination.totalNumber > 0) {
                        if (pagination.totalNumber <= pagination.pageSize * pagination.pageNumber) {
                            pageNum = 'RESULTS <span>' + (((pagination.pageNumber - 1) * pagination.pageSize) + 1) + ' - ' + pagination.totalNumber + '</span> of <span>' + pagination.totalNumber + '</span>';
                        } else {
                            pageNum = 'RESULTS <span>' + (((pagination.pageNumber - 1) * pagination.pageSize) + 1) + ' - ' + pagination.pageSize * pagination.pageNumber + '</span> of <span>' + pagination.totalNumber + '</span>';
                        }
                    } else {
                        pageNum = 'RESULTS <span>0 -  0</span> of <span>0</span>';
                    }
        <?php if (isset($search_result['error'])) { ?>
                        $(".search-opportunities .content .blks").html('<h1 class="not-found">No results found</h1>');
        <?php } else { ?>
                        $(".search-opportunities .content .blks").html(html);
        <?php } ?>
                    $(".pager").html(pageNum);
                }
            });

        </script>

    <?php } else { ?>
        <script>
            function template(data) {

                for (var i = 0, len = data.length; i < len; i++) {

                    var trimmedString = $(data[i].descriptions).text().substr(0, 500);//data[i].descriptions.substr(0, 500);
                    // trimmedString = trimmedString.substr(0, Math.min(trimmedString.length, trimmedString.lastIndexOf(" ")));
                    // trimmedString = trimmedString.replace(/<\/?[^>]+(>|$)/g, "");

                    var apply_before = '';
                    if (data[i].closing_date !== null) {
                        apply_before = '<h4>Apply before :</h4>' +
                                '<h5>' + data[i].closing_date + '</h5>';
                    }
                    if(data[i].dept_name == 'Temp Researcher Internal Fund' || data[i].dept_name == 'Temp Researcher External Fund') {
                        $depts = '<h4 class="department"></h4>';
                    } else {
                        $depts = '<h4 class="department">Department : ' + data[i].dept_name + '</h4>';
                    }
                    data[i] = '<div class="blk blk-' + data[i].slug + '">' +
                            '<h3>' + data[i].description_value + '</h3>' +
                            $depts +
                            '<p>' + trimmedString + '...</p>' +
                            '<div class="details clear">' +
                            '<ul class="clear">' +
                            '<li class="date">' +
                            apply_before +
                            '</li>' +
                            '</ul>' +
                            '</div>' +
                            '<a href="<?= get_the_permalink(75787) . '/?lang=en&redirectionURI=' ?>' + data[i].slug + '">Further details</a>' +
                            '<hr>' +
                            '</div>';
                }

                return data.join("");
            }
        <?php
        $k = 1;
        foreach ($categories as $cat) {
            if ($cat->title == 'Faculty') {
                $opportunities_1 = $wpdb->get_results("SELECT * FROM $table_opportunity WHERE category='$cat->title' AND college='College of Engineering' AND publish='published'");
                $opportunities_2 = $wpdb->get_results("SELECT * FROM $table_opportunity WHERE category='$cat->title' AND college='College of Arts and Science' AND publish='published'");
                $opportunities_3 = $wpdb->get_results("SELECT * FROM $table_opportunity WHERE category='$cat->title' AND college='College of Medicine and Health Science' AND publish='published'");
                $oper_1 = json_encode($opportunities_1);
                $oper_2 = json_encode($opportunities_2);
                $oper_3 = json_encode($opportunities_3);
                if ($oper_1) {
                    ?>
                        DATA_SOURCE_FAC_1 = <?= $oper_1 ?>;
                <?php } else { ?>
                        DATA_SOURCE_FAC_1 = '[]';
                    <?php
                }
                if ($oper_2) {
                    ?>
                        DATA_SOURCE_FAC_2 = <?= $oper_2 ?>;
                <?php } else { ?>
                        DATA_SOURCE_FAC_2 = '[]';
                    <?php
                }
                if ($oper_3) {
                    ?>
                        DATA_SOURCE_FAC_3 = <?= $oper_3 ?>;
                <?php } else { ?>
                        DATA_SOURCE_FAC_3 = '[]';
                    <?php
                }
            } else {
                $opportunities = $wpdb->get_results("SELECT * FROM $table_opportunity WHERE category='$cat->title' AND publish='published' ");
                $oper = json_encode($opportunities);
                ?>
                <?php if ($oper) { ?>
                        DATA_SOURCE_<?= $k ?> = <?= $oper ?>;
                <?php } else { ?>
                        DATA_SOURCE_<?= $k ?> = '[]';
                <?php } ?>
                <?php
            }
            $k++;
        }
        ?>

            var catCount = <?php echo count($categories); ?>;
        <?php
        $j = 1;
        foreach ($categories as $cat) {
            if ($cat->title == 'Faculty') {
                ?>
                    for (let j = 1; j <= 3; j++) {
                        $('#pagination-inside-' + j).pagination({
                            dataSource: eval(`DATA_SOURCE_FAC_${j}`),
                            pageSize: 10,
                            hideWhenLessThanOnePage: true,
                            autoHidePrevious: true,
                            autoHideNext: true,
                            callback: function (data, pagination) {
                                // template method of yourself
                                var html = template(data);
                                //console.log(html);
                                if (pagination.totalNumber > 0) {
                                    if (pagination.totalNumber <= pagination.pageSize * pagination.pageNumber) {
                                        pageNum = 'RESULTS <span>' + (((pagination.pageNumber - 1) * pagination.pageSize) + 1) + ' - ' + pagination.totalNumber + '</span> of <span>' + pagination.totalNumber + '</span>';
                                    } else {
                                        pageNum = 'RESULTS <span>' + (((pagination.pageNumber - 1) * pagination.pageSize) + 1) + ' - ' + pagination.pageSize * pagination.pageNumber + '</span> of <span>' + pagination.totalNumber + '</span>';
                                    }
                                    $(".opportunities .content-2 #blocker-" + j).html(html);
                                } else {
                                    pageNum = 'RESULTS <span>0 -  0</span> of <span>0</span>';
                                    $(".opportunities .content-2 #blocker-" + j).html('<h1 class="not-found">No results found</h1>');
                                }
                                //                        console.log(html);

                                $(".pager-inside-" + j).html(pageNum);
                            }
                        });
                    }

            <?php } else { ?>

                    for (let j = 1; j <= 4; j++) {
                        if (j != 2) {
                            $('#pagination-' + j).pagination({
                                dataSource: eval(`DATA_SOURCE_${j}`),
                                pageSize: 10,
                                hideWhenLessThanOnePage: true,
                                autoHidePrevious: true,
                                autoHideNext: true,
                                callback: function (data, pagination) {
                                    // template method of yourself
                                    var html = template(data);
                                    //console.log(html);
                                    if (pagination.totalNumber > 0) {
                                        if (pagination.totalNumber <= pagination.pageSize * pagination.pageNumber) {
                                            pageNum = 'RESULTS <span>' + (((pagination.pageNumber - 1) * pagination.pageSize) + 1) + ' - ' + pagination.totalNumber + '</span> of <span>' + pagination.totalNumber + '</span>';
                                        } else {
                                            pageNum = 'RESULTS <span>' + (((pagination.pageNumber - 1) * pagination.pageSize) + 1) + ' - ' + pagination.pageSize * pagination.pageNumber + '</span> of <span>' + pagination.totalNumber + '</span>';
                                        }
                                        $(".opportunities .content-" + j + " .blks").html(html);
                                    } else {
                                        pageNum = 'RESULTS <span>0 -  0</span> of <span>0</span>';
                                        $(".opportunities .content-" + j + " .blks").html('<h1 class="not-found">No results found</h1>');
                                    }
                                    //                        console.log(html);

                                    $(".pager-" + j).html(pageNum);
                                }
                            });
                        }
                    }
                <?php
            }
            $j++;
        }
        ?>

        </script>

    <?php } ?>

    <script>
        $(document).ready(function () {
            $('.blockser_sub').hide();
            $('.tab-type-1 .tab').click(function () {
                id = $(this).data('id');
                parent = $(this).closest('.tab-type-1');
                $(parent).children('.tabs').children('.tab').removeClass('active');
                $(this).addClass('active');
                $(parent).children('.tab-dtls').children('.tab-dtl').hide();
                $(parent).children('.tab-dtls').children('.tab-dtl-' + id).fadeIn();
            });

            $('.blockser .blk-sec').click(function () {
                //console.log($(this).attr("data-id"));
                var id = $(this).attr("data-id");
                $('.blockser .blk-sec').removeClass('active');
                $(this).addClass('active');
                $('.inside-blk').css('display', 'none');
                $('.inside-blk-' + id).css('display', 'block');
            });

            $('.blockser_sub span').click(function () {
                var id = $(this).attr("data-id");
                $('.blockser_sub span').removeClass('active');
                $(this).addClass('active');
                $('.inside-blk').css('display', 'none');
                $('.inside-blk-' + id).css('display', 'block');
            });

        });

        function section(menu, menuName) {
            $windowWidth = $(window).width();
            if ($windowWidth <= 500) {
                if (menuName != 'Faculty') {
                    $('.blockser_sub').hide();
                } else {
                    $('.blockser_sub').show();
                }
            }
            var i, content, menu_item;
            content = document.getElementsByClassName("content");
            for (i = 0; i < content.length; i++) {
                content[i].style.display = "none";
            }
            menu_item = document.getElementsByClassName("menu_item");
            for (i = 0; i < menu_item.length; i++) {
                menu_item[i].className = menu_item[i].className.replace(" active", "");
            }
            document.getElementById(menuName).style.display = "block";
            menu.className += " active";
        }

        $(document).ready(function () {
            $('.menu_section .menu_item:first').next().addClass("remove");
            $('.menu_section .menu_item').click(function () {
                $(".menu_item").removeClass("remove");
                $(this).next().addClass("remove");
            });
        });

    </script>
<?php endif; ?>
<?php
get_footer('ku-career');