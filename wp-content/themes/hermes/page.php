<?php get_header(); ?>

<div class="main_page">

    <div class="container-fluid">

        <?php if ( have_posts() ) : ?>

            <div<?php the_group_class(); ?>>

                <?php while ( have_posts() ) : the_post(); ?>

                    <div<?php the_entry_class(); ?>>

                        <article>

                            <header>

                                <?php if (!is_front_page()) { ?>
                                    <nav>
                                        <div id="breadcrumbs"><?php the_breadcrumb('<b>&rarr;</b>'); ?></div>
                                    </nav>
                                <?php } ?>

                                <h1 class="page_title"><?php the_title(); ?></h1>

                            </header>

                            <div class="row">
                                <div class="col-lg-10 m-auto">

                                    <?php the_content(); ?>

                                    <?php edit_post_link(null, '<p class="edit_post_link">[ ', ' ]</p>'); ?>

                                </div>
                            </div>

                        </article>

                    </div>

                <?php endwhile; ?>

            </div>

        <?php endif; ?>

    </div>

</div>

<?php get_footer(); ?>