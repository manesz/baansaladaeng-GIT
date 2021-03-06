<?php get_header(); ?>
<?php get_template_part('nav'); ?>
    <section class="container" style="padding-top: 50px;">
        <div class="row">

            <h2 class="margin-bottom-20">Guest House Rooms </h2>
            <hr/>
            <div id="sectionRoom">
                <?php
                $argc = array(
                    'post_type' => 'room',
                    'category_name' => 'guest-house',
                    'orderby' => 'menu_order',
                    'order' => 'ASC',
                    'post_status' => 'publish',
                    'posts_per_page' => -1);
                $loop = new WP_Query($argc);
                //                var_dump($loop);
                //                    $categories = get_the_category();
                //                    $query = new WP_Query( 'posts_per_page= -1&cat='.$categories[0]->cat_ID );
                //                    if( $query->have_posts() ): while ( $query->have_posts() ): $query->the_post();
                //                    for($i=1;$i<=3; $i++):
                if ($loop->have_posts()): while ($loop->have_posts()) : $loop->the_post();
                    ?>
                    <div class="col-md-12 alpha omega bg-fafafa clearfix margin-bottom-20 wow fadeInRight"
                         style="min-height: 250px;">
                        <div class="col-md-4 alpha omega">
                            <?php
                            $postID = get_the_id();
                            $url = wp_get_attachment_url(get_post_thumbnail_id($postID));
                            $customField = get_post_custom($postID);
                            $room_plan = empty($customField["room_plan"][0]) ? '' : $customField["room_plan"][0];
                            $type = empty($customField["type"][0]) ? '' : $customField["type"][0];
                            $size = empty($customField["size"][0]) ? '' : $customField["size"][0];
                            $designer = empty($customField["designer"][0]) ? '' : $customField["designer"][0];
                            $price = empty($customField["price"][0]) ? 0 : $customField["price"][0];
                            $price = number_format($price);
                            $facilities = empty($customField["facilities"][0]) ? null : $customField["facilities"][0];
                            $recommend_price = get_post_meta($postID, 'recommend_price', true);
                            $recommend_price = is_array($recommend_price) ? @$recommend_price[intval(date_i18n('m')) - 1] : null;
                            $recommend_price = empty($recommend_price) ? null : number_format($recommend_price);

                            if (empty($facilities)) {
                                $arrayFacilities = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
                            } else {
                                $arrayFacilities = explode(',', $facilities);
                            }

                            if (!empty($url)) {
                                ?>
                                <section class="img_thumb"
                                         style="margin: 0px; padding: 0px; height: auto; overflow: hidden;">
                                    <a href="<?php the_permalink(); ?>">
                                        <img class="col-md-12 alpha omega" alt="<?php the_title(); ?>"
                                             src="<?php echo $url; ?>" style="width: auto; height: 360px;"/>
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
                        <div class="col-md-2 text-center" style="padding-top: 15px;">
                            <?php if ($room_plan): ?>
                                <img src="<?php echo $room_plan; ?>"
                                     style="max-width: 150px; max-height: 300px;"/>
                            <?php endif; ?>
                        </div>
                        <div class="col-md-6 alpha omega">
                            <a href="<?php the_permalink(); ?>"><h3><?php the_title(); ?></h3></a>
                            <p class="font-12 padding-10">
                                <?php echo $type ? "Type: $type <br/>" : ""; ?>
                                <?php echo $size ? "Size: $size sq.mtrs<br/>" : ""; ?>
                                <?php if ($price || $recommend_price) :?>
                                Price: <?php echo !$recommend_price ? $price : $recommend_price; ?> THB/night (Incl
                                Breakfast)
                        <?php endif; ?>
                            </p>
                            <p class="font-12 padding-10" style="">
                                <?php
                                the_excerpt();
                                ?>
                            </p>

                            <p class="padding-10">
                                <?php
                                if ($arrayFacilities[0]):
                                    ?>
                                    <img title="FREE WIFI"
                                         src="<?php echo get_template_directory_uri() . '/library/images/baansaladaeng-icon-wifi.png' ?>"
                                         style="width: 70px; height: 70px;"/>
                                <?php endif;
                                if ($arrayFacilities[1]):?>
                                    <img title="BREAKFAST"
                                         src="<?php echo get_template_directory_uri() . '/library/images/baansaladaeng-icon-breakfast.png' ?>"
                                         style="width: 70px; height: 70px;"/>
                                <?php endif;
                                if ($arrayFacilities[2]):?>
                                    <img title="EN-SUITE BATHROOM"
                                         src="<?php echo get_template_directory_uri() . '/library/images/baansaladaeng-icon-ensuite-bathroom.png' ?>"
                                         style="width: 70px; height: 70px;"/>
                                <?php endif;
                                if ($arrayFacilities[3]):?>
                                    <img title="FLAT SCREEN TV"
                                         src="<?php echo get_template_directory_uri() . '/library/images/baansaladaeng-icon-flat-tv.png' ?>"
                                         style="width: 70px; height: 70px;"/>
                                <?php endif;
                                if ($arrayFacilities[4]):?>
                                    <img title="MINI BAR"
                                         src="<?php echo get_template_directory_uri() . '/library/images/baansaladaeng-icon-mini-bar.png' ?>"
                                         style="width: 70px; height: 70px;"/>
                                <?php endif;
                                if ($arrayFacilities[5]):?>
                                    <img title="SAFETY DEPOSIT BOX"
                                         src="<?php echo get_template_directory_uri() . '/library/images/baansaladaeng-icon-safety-deposit-box.png' ?>"
                                         style="width: 70px; height: 70px;"/>
                                <?php endif;
                                if ($arrayFacilities[6]):?>
                                    <img title="KING SIZE BED"
                                         src="<?php echo get_template_directory_uri() . '/library/images/baansaladaeng-icon-king-size-bed.png' ?>"
                                         style="width: 70px; height: 70px;"/>
                                <?php endif;
                                if ($arrayFacilities[7]):?>
                                    <img title="QUEEN SIZE BED"
                                         src="<?php echo get_template_directory_uri() . '/library/images/baansaladaeng-icon-queen-size-bed.png' ?>"
                                         style="width: 70px; height: 70px;"/>
                                <?php endif;
                                if ($arrayFacilities[8]):?>
                                    <img title="TWIN BED"
                                         src="<?php echo get_template_directory_uri() . '/library/images/baansaladaeng-icon-twin-bed.png' ?>"
                                         style="width: 70px; height: 70px;"/>
                                <?php endif;
                                if ($arrayFacilities[9]):?>
                                    <img title="PRIVATE BALCONY"
                                         src="<?php echo get_template_directory_uri() . '/library/images/baansaladaeng-icon-private-balcony.png' ?>"
                                         style="width: 70px; height: 70px;"/>
                                <?php endif; ?>
                            </p>

                            <div class="col-md-8 alpha" style="">
                                <?php if ($recommend_price): ?>
                                    <span style="margin-top: 0px; padding-top: 10px; font-size: 20px;"><strike>PRICE
                                            : <?php echo $price; ?> BAHT</strike></span>
                                    <h3 style="margin-top: 0px; padding-top: 10px; color: red; padding-left: 0;">PRICE :
                                        <?php echo $recommend_price; ?> BAHT</h3>
                                <?php else: ?>
                                    <h3 style="margin-top: 0px; padding-top: 10px;">PRICE
                                        : <?php echo $price; ?> BAHT</h3>
                                <?php endif; ?>
                            </div>
                            <!--                            <div class="col-md-4 bg-ED2024" style="text-align: center; padding: 10px 0 10px 0; color: #fff; cursor: pointer;"-->
                            <!--                                onclick="$('form #frm_content_room').submit();">RESERVATION</div>-->

                            <form id="frm_content_room" class="form" method="get"
                                  action="<?php echo network_site_url('/') . "reservation"; ?>">
<!--                                <input type="hidden" value="true" name="booking_post"/>-->
                                <input type="hidden" value="1" name="step"/>
                                <input type="hidden" value="<?php the_title(); ?>" name="room_name"/>
                                <input type="hidden" value="<?php echo $postID; ?>" name="room_id"/>
                                <input type="hidden" value="" id="check_in_date" name="check_in_date"/>
                                <input type="hidden" value="" id="check_out_date" name="check_out_date"/>
                                <button class="col-md-4 col-xs-12 bg-ED2024 alpha omega"
                                        style="text-align: center; padding: 10px 0 10px 0; color: #fff; border: 0px;"
                                    >RESERVATION
                                </button>
                            </form>
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
    </section>
<?php get_footer(); ?>