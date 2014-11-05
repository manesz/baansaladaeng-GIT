<?php get_header(); ?>
<?php get_template_part('nav'); ?>
<?php

if (have_posts()) :
    while (have_posts()) : the_post();
        if( is_page('Room') ){
            // get_template_part( 'post-formats/format-jobs', get_post_format() );
            get_template_part('category');
        } else {
            get_template_part( 'post-formats/format', get_post_format() );
        }//END: if check not in category name
    endwhile;
else :
?>
    <article id="post-not-found" class="hentry cf">
        <header class="article-header">
            <h1><?php _e( 'Oops, Post Not Found!', 'bonestheme' ); ?></h1>
        </header>
        <section class="entry-content">
            <p><?php _e( 'Uh Oh. Something is missing. Try double checking things.', 'bonestheme' ); ?></p>
        </section>
        <footer class="article-footer">
            <p><?php _e( 'This is the error message in the single.php template.', 'bonestheme' ); ?></p>
        </footer>
    </article>
<?php
endif;
?>

<?php get_footer(); ?>
