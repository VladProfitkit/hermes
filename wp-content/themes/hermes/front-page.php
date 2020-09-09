<?php get_header(); ?>

<div class="main_front">

    <section>

        <div class="container-fluid home_about">
            <div class="row justify-content-center">
                <div class="col-sm-10">

                    <?php if ( have_posts() ) : ?>

                        <div<?php the_group_class(); ?>>

                            <?php while ( have_posts() ) : the_post(); ?>

                                <header>
                                    <h2><?php the_field('title'); ?></h2>
                                </header>

                                <?php the_content(); ?>

                                <?php edit_post_link(null, '<p class="edit_post_link">[ ', ' ]</p>'); ?>

                            <?php endwhile; ?>

                        </div>

                    <?php endif; ?>

                </div>
            </div>
        </div>

    </section>

    <section>

        <div class="home_advantages">

            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6 text">

                        <h2><?php the_field('advantages_title'); ?></h2>

                        <?php the_field('advantages_text'); ?>

                    </div>
                </div>
            </div>

        </div>

        <div class="container-fluid home_about2">
            <div class="row">
                <div class="col-md-8">

                    <?php the_field('advantages_text2'); ?>

                </div>
            </div>
        </div>

    </section>

    <section>

        <div class="container-fluid brands">
            <div class="row justify-content-center">
                <div class="col-sm-10">

                    <?php the_field('brands'); ?>

                </div>
            </div>
        </div>

    </section>

    <section>

        <div class="container-fluid brands">
            <div class="row justify-content-center">
                <div class="col-sm-10">

                    <?php the_field('brands2'); ?>

                </div>
            </div>
        </div>

    </section>

    <?php the_field('map'); ?>

    <div class="container-fluid map_text">
        <div class="row">
            <div class="col-5 position-relative">
                <div><?php the_field('map_text'); ?></div>
            </div>
        </div>
    </div>

    <div id="map" style="width: 100%; height: 510px"></div>

</div>

<?php get_footer(); ?>