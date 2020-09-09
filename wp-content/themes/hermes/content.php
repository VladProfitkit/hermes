<?php if ( is_singular() ) : ?>

    <?php if ( has_post_thumbnail() && ! post_password_required() && ! is_attachment() ) : ?>

        <div class="single_thumbnail">
            <?php the_post_thumbnail('large'); ?>
        </div>

    <?php endif; ?>

    <?php
        //If news
        if (has_category('news')) {
            echo '<p class="date"><time datetime="' . get_the_date('c') . '">' . get_month_rus(get_the_date('j.n.Y')) . '</time></p>';
        }

        the_content();

        //Displays page-links for paginated posts (i.e. includes the <!--nextpage-->)
        wp_link_pages(array('before' => '<nav><p><span>' . __('Pages:', 'aw') . '</span>', 'after' => '</p></nav>', 'link_before' => '<span>', 'link_after' => '</span>'));
    ?>

    <?php edit_post_link(null, '<p class="edit_post_link">[ ', ' ]</p>'); ?>

<?php else : ?>

    <article>

        <header>
            <h2 class="entry_title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
        </header>

        <?php if ( has_post_thumbnail() && ! post_password_required() && ! is_attachment() ) : ?>

            <div class="entry_thumbnail">
                <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('thumbnail'); ?></a>
            </div>

        <?php endif; ?>


        <?php if ( is_search() ) : ?>

            <?php the_announcement('45', true, false); ?>

        <?php else : ?>

            <?php
                //If news
                if (has_category('news')) {
                    echo '<p class="date"><time datetime="' . get_the_date('c') . '">' . get_month_rus(get_the_date('j.n.Y')) . '</time></p>';
                }

                if (is_category()) {
                    the_announcement('more|55', true, false);
                } else {
                    the_content();
                }
            ?>

        <?php endif; ?>

        <?php edit_post_link(null, '<p class="edit_post_link">[ ', ' ]</p>'); ?>

    </article>

<?php endif; ?>
