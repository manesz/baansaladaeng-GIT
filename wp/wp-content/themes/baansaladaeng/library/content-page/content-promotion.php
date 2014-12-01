<?php get_header();

get_template_part('nav');

$dateNow = date_i18n("Y-m-d");
?>
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
                        <td style="width: 20%"><?php echo date_i18n("M", strtotime("+0 month", $dateNow))?></td>
                        <td style="width: 20%"><?php echo date_i18n("M", strtotime("+1 month", $dateNow))?></td>
                        <td style="width: 20%"><?php echo date_i18n("M", strtotime("+2 month", $dateNow))?></td>
                        <td style="width: 20%">REDERVATION</td>
                    </tr>
                    <?php $loopPostTypeRoom = new WP_Query(array(
                        'post_type' => 'room', 'posts_per_page' => -1
                    ));
                    if ($loopPostTypeRoom->have_posts()):
                        while ($loopPostTypeRoom->have_posts()) : $loopPostTypeRoom->the_post();
                            $postID = get_the_id();
                            $recommend_price = get_post_meta($postID, 'recommend_price', true);

                            $checkShow = false;
                            if (is_array($recommend_price)) {
                                $recMonth1 = $recommend_price[intval(date_i18n('m') - 1)];
                                $recMonth2 = $recommend_price[intval(date_i18n("m", strtotime("+0 month", $dateNow)))];
                                $recMonth3 = $recommend_price[intval(date_i18n("m", strtotime("+1 month", $dateNow)))];
                                $recMonth4 = $recommend_price[intval(date_i18n("m", strtotime("+2 month", $dateNow)))];
                                if ($recMonth1 && $recMonth2 && $recMonth3 && $recMonth4)
                                    $checkShow = true;
                            }
                            if ($checkShow) :
                            $customField = get_post_custom($postID);
                            $type = $customField["type"][0];
                            $size = $customField["size"][0];
                            $designer = $customField["designer"][0];
                            $price = number_format($customField["price"][0]);
//                            $recommend_price = $customField["recommend_price"][0];
//                            $recommend_price = empty($recommend_price)? null: number_format($customField["recommend_price"][0]);

                            ?>
                            <tr>
                                <td style="width: 20%"><?php the_title(); ?></td>
                                <td style="width: 20%"><?php echo $recMonth1; ?> THB</td>
                                <td style="width: 20%"><?php echo $recMonth2; ?> THB</td>
                                <td style="width: 20%"><?php echo $recMonth3; ?> THB</td>
                                <td style="width: 20%"><?php echo $recMonth4; ?> THB</td>
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
                        <?php endif;
                            endwhile;
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