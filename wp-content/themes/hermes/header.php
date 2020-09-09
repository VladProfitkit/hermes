<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width">
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

    <script src="https://api-maps.yandex.ru/2.1/?apikey=fe778b6e-64e1-4f4b-adb7-58ac86e7344c&lang=ru_RU"></script>

    <?php wp_head(); ?>
</head>

<body>

    <?php wp_body_open(); ?>

    <div id="general">

        <div class="<?php echo (is_front_page()) ? 'header_wrapper_home' : 'header_wrapper'; ?>">

            <header>

                <div class="container-fluid header">
                    <div class="row">
                        <div class="col col-sm-12 col-md-6 col-lg-5 col-xl-4">
                            <a href="/" class="logo">
                                <?php /*<h2><?php echo aw_option('name') ?></h2>
                                <h3><?php echo aw_option('subname') ?></h3>*/ ?>
                            </a>
                        </div>
                        <div class="col-sm-6 col-md-6 col-lg-4 col-xl-3 address">
                            <p><b>Адрес:</b><br>
                            <?php echo aw_option('address', true) ?></p>
                        </div>
                        <div class="col-sm-6 col-md-6 col-lg-3 col-xl-2 font-weight-bold text-nowrap phone">
                            <p><?php echo aw_phone('span', '') ?>
                            <?php echo aw_option('phone_comment') ?></p>
                        </div>
                        <div class="col col-md-6 col-lg-12 col-xl-3 text-right font-weight-bold dealer">
                            <p><?php echo aw_option('top_link') ?></p>
                        </div>
                    </div>
                    <div class="row m-0 mt-md-3 mt-xl-0 separator">
                    </div>
                </div>

            </header>


            <div class="container-fluid top_nav">
                <div class="row">
                    <div class="col col-sm-6 col-lg-12 col-xl-9">

                        <nav>
                            <a href="#adaptive_menu" id="adaptive_menu">Меню</a>

                            <?php if (!is_front_page()) { ?>
                                <a href="/" class="top_menu_home" title="Главная"></a>
                            <?php } ?>
<?php

    $args = array(
        'theme_location'  => 'main-menu',
        'container'       => '',
        'menu_class'      => 'top_menu',
        'menu_id'         => 'top_menu',
        'echo'            => true,
        'fallback_cb'     => 'wp_page_menu',
        'before'          => '',
        'after'           => '',
        'link_before'     => '',
        'link_after'      => '',
        'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
        'item_spacing'    => 'discard',
        'depth'           => 0
    );

    wp_nav_menu($args);

?>

                        </nav>

                    </div>

                    <div class="d-none d-sm-block col-sm-6 col-lg-12 col-xl-3">

                        <form method="get" action="/" id="top_search">
                            <input type="text" value="" name="s" id="s" placeholder="Поиск...">
                            <input type="submit" value="">
                        </form>

                    </div>
                </div>
            </div>

        </div>

<?php if (is_front_page()) { ?>

        <div id="slider">
            <div class="slider">

                <div class="slider_frame">
                    <ul class="slider_container">
            <?php

                $wpq = new WP_Query('post_type=post_slider&posts_per_page=-1&orderby=menu_order&order=asc');

                while ($wpq->have_posts())
                {
                    $wpq->the_post();

                    //$link = get_field('link');

                    echo '<li class="slider_slide">';

                        echo '<div class="slider_image" style="background-image: url(\'' . get_the_post_thumbnail_url() . '\')"></div>';

                        echo '<div class="slider_text">';

                            echo '<div class="container-fluid"><div class="row">';

                            /*if ($link) {
                                echo '<a href="' . $link . '">';
                            }*/

                            echo '<div class="text_bg"><h2>' . get_the_title() . '</h2>' . apply_filters('the_content', get_the_content()) . '</div>';

                            /*if ($link) {
                                echo '</a>';
                            }*/

                            echo '</div></div>';

                        echo '</div>';

                    echo '</li>';
                }

                wp_reset_query();
            ?>
                    </ul>
                </div>

                <div class="container-fluid">
                    <div class="row">
                        <div class="col">
                            <div class="slider_prev"></div>
                            <div class="slider_next"></div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

<?php } ?>


        <main>
            <div id="main">