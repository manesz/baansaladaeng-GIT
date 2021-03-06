<?php get_header();

get_template_part('nav');

$dateNow = date_i18n("Y-m-d");
$objClassContact = new Contact($wpdb);
?>
    <style>
        table tr td {
            padding: 10px;
        }
    </style>

    <div class="container min-height-540">
        <div class="row">
            <div class="col-md-12 wow fadeInLeft margin-bottom-20" data-wow-delay="1s">
                <h2>Promotions</h2>
                <span class="font-color-999 font-size-14">BaanSaladaeng has served you the best price on the best location of Bangkok  !!! </span><span
                    class="font-color-red">Don't miss...</span>

                <p>
                <table class="table-bordered" style="width: 100%">
                    <tr>
                        <td style="width: 20%">Rate / Night</td>
                        <td style="width: 20%">Regular rate / night</td>
                        <td style="width: 20%"><?php echo date_i18n("M", strtotime($dateNow)) ?></td>
                        <td style="width: 20%"><?php echo date_i18n("M", strtotime("+1 month", $dateNow)) ?></td>
                        <td style="width: 20%"><?php echo date_i18n("M", strtotime("+2 month", $dateNow)) ?></td>
                        <td style="width: 20%">REDERVATION</td>
                    </tr>
                    <?php
                    $argc = array(
                        'post_type' => 'room',
                        'category_name' => 'guest-house',
                        'post_status' => 'publish',
                        'posts_per_page' => -1,
                        'orderby' => 'menu_order',
                        'order' => 'ASC'
                    );
                    $loop = new WP_Query($argc);
                    $loopPostTypeRoom = new WP_Query($argc);
                    if ($loopPostTypeRoom->have_posts()):
                        while ($loopPostTypeRoom->have_posts()) : $loopPostTypeRoom->the_post();
                            $postID = get_the_id();
                            $recommend_price = get_post_meta($postID, 'recommend_price', true);
                            $customField = get_post_custom($postID);
                            $price = empty($customField["price"][0]) ? 0 : $customField["price"][0];
                            $price = number_format($price) . " THB";//normal price
                            $checkShow = false;
                            if (is_array($recommend_price)) {
                                $recMonth2 = $recommend_price[intval(date_i18n("m", strtotime($dateNow))) - 1];
                                $recMonth3 = $recommend_price[intval(date_i18n("m", strtotime($dateNow)))];
                                $recMonth4 = $recommend_price[intval(date_i18n("m", strtotime($dateNow))) + 1];
//                                $recMonth3 = $recommend_price[intval(date_i18n("m", strtotime("+0 month", $dateNow)))];
//                                $recMonth4 = $recommend_price[intval(date_i18n("m", strtotime("+1 month", $dateNow)))];
                                if ($recMonth2 || $recMonth3 || $recMonth4) {
                                    $checkShow = true;
                                    $recMonth2 = empty($recMonth2) ? "" : number_format($recMonth2) . " THB";
                                    $recMonth3 = empty($recMonth3) ? "" : number_format($recMonth3) . " THB";
                                    $recMonth4 = empty($recMonth4) ? "" : number_format($recMonth4) . " THB";
                                }
                            }
                            $customField = get_post_custom($postID);
                            $room_plan = empty($customField["room_plan"][0]) ? '' : $customField["room_plan"][0];
                            $type = empty($customField["type"][0]) ? '' : $customField["type"][0];
                            $size = empty($customField["size"][0]) ? '' : $customField["size"][0];
                            $designer = empty($customField["designer"][0]) ? '' : $customField["designer"][0];
//                            $recommend_price = $customField["recommend_price"][0];
//                            $recommend_price = empty($recommend_price)? null: number_format($customField["recommend_price"][0]);
                            if ($checkShow):
                                ?>
                                <tr>
                                    <td style="width: 20%"><?php the_title(); ?></td>
                                    <td style="width: 20%"><?php echo $price; ?></td>
                                    <td style="width: 20%"><?php echo $recMonth2; ?></td>
                                    <td style="width: 20%"><?php echo $recMonth3; ?></td>
                                    <td style="width: 20%"><?php echo $recMonth4; ?></td>
                                    <td style="width: 20%">
                                        <form class="form" method="get"
                                              action="<?php echo network_site_url('/') . "reservation"; ?>">
                                            <input type="hidden" value="true" name="booking_post"/>
                                            <input type="hidden" value="1" name="step"/>
                                            <input type="hidden" value="<?php the_title(); ?>" name="room_name"/>
                                            <input type="hidden" value="<?php echo $postID; ?>" name="room_id"/>
                                            <input type="hidden" value="" name="check_in_date"/>
                                            <input type="hidden" value="" name="check_out_date"/>
                                            <button
                                                class="col-md-12 col-xs-12 alpha omega btn-service wow fadeIn animated">
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

            <div class="col-md-12 wow fadeInLeft margin-bottom-20" data-wow-delay="1s">
                <h2 class="margin-bottom-20"><?php
                    $arrTitle = $objClassContact->getTitlePromotion();
                    echo $arrTitle['promotion_title'];
                    ?></h2>
                <hr/>
                <div id="sectionRoom">
                    <?php
                    $args = array(
                        'category_name' => 'news',
                        'posts_per_page' => -1
                    );
                    $loop = new WP_Query($args);
                    if ($loop->have_posts()): while ($loop->have_posts()) : $loop->the_post();
                        ?>
                        <div class="col-md-12 alpha omega bg-fafafa clearfix margin-bottom-20 wow fadeInRight"
                             style="min-height: 250px;">
                            <div class="col-md-4 alpha omega">
                                <?php
                                $postID = get_the_id();
                                $url = wp_get_attachment_url(get_post_thumbnail_id($postID));


                                if (!empty($url)) {
                                    ?>
                                    <section class="img_thumb"
                                             style="margin: 0px; padding: 0px; height: auto; overflow: hidden;">
                                        <a href="<?php the_permalink(); ?>">
                                            <img class="col-md-12 alpha omega" alt="<?php the_title(); ?>"
                                                 src="<?php echo $url; ?>"
                                                 style="width: auto; height: 360px; left: -15%;"/>
                                        </a>
                                    </section>
                                <?php
                                } else {
                                    ?>
                                    <section class="img_thumb"
                                             style="margin: 0px; padding: 0px; width: auto; height: 360px; overflow: hidden;">
                                        <a href="<?php the_permalink(); ?>">
                                            <img class="col-md-12 alpha omega" alt="<?php the_title(); ?>"
                                                 src="<?php echo get_template_directory_uri(); ?>/library/images/no-thumb.png"
                                                 style="width: auto; left: -15%"/>
                                        </a>
                                    </section>

                                <?php
                                }
                                ?>
                            </div>

                            <div class="col-md-6 alpha omega"><h3><?php the_title(); ?></h3>

                                <p class="font-12 padding-10" style="">
                                    <?php the_content(); ?>
                                </p>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="clearfix"></div>
                    <?php
//                    endfor;
                    endwhile;
                    else:
                        echo "No data.";
                    endif;
                    ?>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
<?php get_footer(); ?>