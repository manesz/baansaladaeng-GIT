<?php
/**
 * Created by PhpStorm.
 * User: Rux
 * Date: 10/10/2557
 * Time: 16:19 น.
 */
?>
<?php
$loop = new WP_Query(array(
    'post_type' => 'room',
    'posts_per_page' => 10,
    'post_status' => 'publish',
    'orderby' => 'menu_order',
    'order' => 'ASC'
));
while ($loop->have_posts()) : $loop->the_post();
    echo '<div class="menupageContent">';
    the_post_thumbnail("thumbnail");
    ?><p class="textYellow arrow"><?php the_title(); ?></p><?php
    //the_content();
    echo '</div>';
endwhile;
?>