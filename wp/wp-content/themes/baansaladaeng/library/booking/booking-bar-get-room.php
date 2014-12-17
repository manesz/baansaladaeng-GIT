<?php
$argc =  array('post_type' => 'room', 'posts_per_page' => -1);

$loopPostTypeRoom = new WP_Query($argc);
if ($loopPostTypeRoom->have_posts()):
    while ($loopPostTypeRoom->have_posts()) : $loopPostTypeRoom->the_post();
        $postID = get_the_id();
        $urlThumbnail = wp_get_attachment_url(get_post_thumbnail_id($postID));
        if (!$urlThumbnail)
            $urlThumbnail = get_template_directory_uri() . "/library/images/no-thumb.png";
        $customField = get_post_custom($postID);
        $room_plan = isset($customField["room_plan"][0]) ? $customField["room_plan"][0]: '';
        $type = isset($customField["type"][0]) ? $customField["type"][0]: '';
        $size = isset($customField["size"][0]) ? $customField["size"][0]: '';
        $designer = isset($customField["designer"][0]) ? $customField["designer"][0]: '';
        $price = isset($customField["price"][0]) ? $customField["price"][0]: 0;
        $price = number_format($price);
        $recommend_price = isset($customField["recommend_price"][0]) ? $customField["recommend_price"][0]: 0;
        $recommend_price = number_format($recommend_price);
        ?>
        <div class="col-md-12 alpha bg-fafafa clearfix margin-bottom-20" style="height: 250px;">
            <div class="col-md-4 alpha omega">
                <img src="<?php echo $urlThumbnail; ?>"
                     style="margin: 0px; padding: 0px; width: 100%; height: 250px; overflow: hidden;"/>
            </div>
            <div class="col-md-8">
                <a href="<?php the_permalink(); ?>"><h4><?php the_title(); ?></h4></a>

                <p class="font-12">
                    Type: <?php echo $type; ?><br/>
                    Size: <?php echo $size; ?> sq.mtrs<br/>
                    Designer: <?php echo $designer; ?><br/>
                    Price: <?php echo !$recommend_price ? $price : $recommend_price; ?> THB/night (Incl Breakfast)
                </p>

                <p class="font-12">
                    <?php
                    $excerpt = get_the_content();
                    $excerpt = strip_shortcodes($excerpt);
                    $excerpt = strip_tags($excerpt);
                    $the_str = substr($excerpt, 0, 150);
                    $the_str = strlen($the_str) < strlen($excerpt) ? $the_str . '...' : $the_str;
                    echo $the_str;
                    ?>
                </p>

                <div class="col-md-8 alpha" style="">
                    <h4 style="margin-top: 0px; padding-top: 10px;">PRICE
                        : <?php echo empty($recommend_price) ? $price : $recommend_price; ?> BAHT</h4>
                </div>
                <div class="col-md-4 bg-ED2024" onclick="chooseRoom(<?php echo $postID; ?>, '<?php the_title(); ?>');"
                     style="text-align: center; padding: 10px 0 10px 0; color: #fff; cursor: pointer;">
                    CHOOSE
                </div>
            </div>
        </div>
    <?php endwhile; ?>
    <?php
    exit;
endif;

?>