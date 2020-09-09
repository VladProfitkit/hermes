<?php get_header(); ?>

<div class="main_index">

    <div class="container-fluid">

        <section>

            <header>

                <?php if (!is_front_page()) { ?>
                    <nav>
                        <div id="breadcrumbs"><?php the_breadcrumb(); ?></div>
                    </nav>
                <?php } ?>

                <?php if (is_category()) { ?>
                    <h1 class="page_title"><?php echo single_cat_title('', false); ?></h1>
                <?php } else { ?>
                    <h1 class="page_title"><?php the_title(); ?></h1>
                <?php } ?>

            </header>

            <div class="row">
                <div class="col-lg-10 m-auto">

                    <?php if (is_category()) { ?>
                        <div class="category_description"><?php echo category_description(); ?></div>
                    <?php } ?>

                    <?php if ( have_posts() ) : ?>

                        <div<?php the_group_class(); ?>>

                            <?php while ( have_posts() ) : the_post(); ?>

                                <div<?php the_entry_class(); ?>>

                                    <?php get_template_part('content'); ?>

                                </div>

                            <?php endwhile; ?>

                        </div>

                        <?php the_links2pages(__('Pages:', 'aw'), '&larr;', '&rarr;', '<nav><p class="nav_pages">', '</p></nav>'); ?>

                    <?php else : ?>

                        <?php if (is_category()) { ?>
                            <p class="no_entry"><?php _e('No posts found.', 'aw'); ?></p>
                        <?php } else { ?>
                            <p class="no_entry"><?php _e('Nothing Found.', 'aw'); ?></p>
                        <?php } ?>

                    <?php endif; ?>

                </div>
            </div>

        </section>

    </div>

</div>

<?php get_footer(); ?>