<?php get_header(); ?>

<div class="main_single">

    <div class="container-fluid">

        <?php if ( have_posts() ) : ?>

            <div<?php the_group_class(); ?>>

                <?php while ( have_posts() ) : the_post(); ?>

                    <div<?php the_entry_class(); ?>>

                        <article>

                            <header>

                                <?php if (!is_front_page()) { ?>
                                    <nav>
                                        <div id="breadcrumbs"><?php the_breadcrumb(); ?></div>
                                    </nav>
                                <?php } ?>

                                <h1 class="page_title"><?php the_title(); ?></h1>

                            </header>

                            <div class="row">
                                <div class="col-lg-10 m-auto">

                                    <?php get_template_part('content'); ?>

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