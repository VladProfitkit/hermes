<?php get_header(); ?>

<div class="main_404">

    <div class="container-fluid">

        <article>

            <header>
                <h1 class="page_title"><?php _e('Not Found', 'aw'); ?></h1>
            </header>

            <div class="row">
                <div class="col-lg-10 m-auto">

                    <p><?php _e('It looks like nothing was found at this location.<br>The link you followed may be broken, or the page may have been removed.<br>Please return to <a href="/">the homepage</a> or try a search.', 'aw'); ?></p>

                    <?php get_search_form(); ?>

                </div>
            </div>

        </article>

    </div>

</div>

<?php get_footer(); ?>