<?php get_header(); ?>

<div class="main_search">

    <div class="container-fluid">

        <section>

            <header>

                <?php if (have_posts()) { ?>
                    <h1 class="page_title"><?php printf(__('Search Results for: %s', 'aw'), get_search_query()); ?></h1>
                <?php } else { ?>
                    <h1 class="page_title"><?php printf(__('Sorry, but nothing matched your search terms: %s', 'aw'), get_search_query()); ?></h1>
                <?php } ?>

            </header>

            <div class="row">
                <div class="col-lg-10 m-auto">

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

                        <p><?php _e('Please try again with some different keywords.', 'aw'); ?></p>

                    <?php endif; ?>

                </div>
            </div>

        </section>

    </div>

</div>

<?php get_footer(); ?>