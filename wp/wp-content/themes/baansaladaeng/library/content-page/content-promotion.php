<?php get_header(); ?>
<?php get_template_part('nav'); ?>
    <style>
        table tr td {
            padding: 10px;
        }
    </style>

    <div class="container min-height-540">
        <div class="row">
            <div class="col-md-12 wow fadeInLeft margin-bottom-20" data-wow-delay="1s">
                <h2>Promotion</h2>
                <span class="font-color-999 font-size-14">BaanSaladaeng has served you the best price on the best location of Bangkok  !!! </span><span
                    class="font-color-red">Don't miss...</span>

                <p>
                <table class="table-bordered" style="width: 100%">
                    <tr>
                        <td style="width: 20%">Rate / Night</td>
                        <td style="width: 20%">Regular rate / night</td>
                        <td style="width: 20%">Sep</td>
                        <td style="width: 20%">Oct</td>
                        <td style="width: 20%">Nov-Dec</td>
                        <td style="width: 20%">REDERVATION</td>
                    </tr>
                    <?php $loopPostTypeRoom = new WP_Query(array(
                        'post_type' => 'room',
                    ));
                    if ($loopPostTypeRoom->have_posts()):
                        while ($loopPostTypeRoom->have_posts()) : $loopPostTypeRoom->the_post();
                            $postID = get_the_id();
                            $customField = get_post_custom($postID);
                            $type = $customField["type"][0];
                            $size = $customField["size"][0];
                            $designer = $customField["designer"][0];
                            $price = number_format($customField["price"][0]);
                            $recommend_price = number_format(@$customField["recommend_price"][0]);
                            ?>
                            <tr>
                                <td style="width: 20%"><?php the_title(); ?></td>
                                <td style="width: 20%"><?php echo $price; ?> THB</td>
                                <td style="width: 20%">1,249 THB</td>
                                <td style="width: 20%">1,249 THB</td>
                                <td style="width: 20%">1,249 THB</td>
                                <td style="width: 20%">
                                    <form class="form" method="post"
                                          action="<?php echo network_site_url('/') . "reservation"; ?>">
                                        <input type="hidden" value="true" name="booking_post"/>
                                        <input type="hidden" value="1" name="step"/>
                                        <input type="hidden" value="<?php the_title(); ?>" name="room_name"/>
                                        <input type="hidden" value="<?php echo $postID; ?>" name="room_id"/>
                                        <input type="hidden" value="" name="check_in_date"/>
                                        <input type="hidden" value="" name="check_out_date"/>
                                        <button class="col-md-12 col-xs-12 alpha omega btn-service wow fadeIn animated">
                                            RESERVATION
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endwhile;
                    endif; ?>
                </table>
                </p>
                <p class="font-color-999 font-size-12">
                    <?php
                    $mypostids = $wpdb->get_col("
                        select ID from $wpdb->posts where post_title LIKE 'promotion description%' limit 1
                    ");
                    $args = array(
                        'post__in' => $mypostids,
                        'orderby' => 'title',
                        'order' => 'asc'
                    );
                    $res = new WP_Query($args);
                    if ($res->have_posts()):
                        while ($res->have_posts()) : $res->the_post();
                            the_content();
                        endwhile;
                    endif;
                    ?>
                </p>
            </div>
        </div>
    </div>
<?php get_footer(); ?>