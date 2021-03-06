<?php

if (have_posts()) :
    while (have_posts()) : the_post();
        if (is_page('index')) {
            get_template_part("library/content-page/content-index", get_post_format());
        } elseif (is_page('room')) {
            get_template_part("library/content-page/content-room", get_post_format());
        } /*elseif (is_page('room-view')) {
            get_template_part("library/content-page/content-room-view", get_post_format());
        } */ elseif (is_page('reservation')) {
            get_template_part("library/content-page/content-reservation", get_post_format());
        } elseif (is_page('promotion')) {
            get_template_part("library/content-page/content-promotion", get_post_format());
        } elseif (is_page('long-stay')) {
            get_template_part("library/content-page/content-long-stay", get_post_format());
        } elseif (is_page('gallery')) {
            get_template_part("library/content-page/content-gallery", get_post_format());
        } elseif (is_page('contact')) {
            get_template_part('library/content-page/content-contact', get_post_format());
        } elseif (is_page('about-bannsaladang')) {
            get_template_part('library/content-page/content-about', get_post_format());
        } elseif (is_page('term-and-conditions')) {
            get_template_part('library/content-page/content-term-and-condition', get_post_format());
        } elseif (is_page('get-post-data')) {
            require_once("library/get-post-data.php");
        } elseif (is_page('view-p')) {
            get_template_part('library/content-page/content-view-payment');
        } else {
            get_template_part('library/content-page/content-single-page', get_post_format());
        }//END: if check not in category name
    endwhile;
else :
    ?>
    <article id="post-not-found" class="hentry cf">
        <header class="article-header">
            <h1><?php _e('Oops, Post Not Found!', 'bonestheme'); ?></h1>
        </header>
        <section class="entry-content">
            <p><?php _e('Uh Oh. Something is missing. Try double checking things.', 'bonestheme'); ?></p>
        </section>
        <footer class="article-footer">
            <p><?php _e('This is the error message in the single.php template.', 'bonestheme'); ?></p>
        </footer>
    </article>
<?php
endif;
?>
