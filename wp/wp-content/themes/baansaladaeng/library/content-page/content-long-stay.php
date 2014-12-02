<?php get_header(); ?>
<?php get_template_part('nav'); ?>
    <section class="container" style="padding-top: 50px;">
        <div class="row">

            <h2 class="text-center margin-bottom-20">Rooms</h2>
            <hr/>
            <div id="sectionRoom">
                <?php
                $loop = new WP_Query(array(
                    'post_type' => 'room',
                    'orderby' => 'date',
                    'category_name' => 'long-stay', //name of category by slug
                    'order' => 'DESC',
                    'posts_per_page' => -1));
                if ($loop->have_posts()): while ($loop->have_posts()) : $loop->the_post();
                    ?>
                    <div class="col-md-12 alpha omega bg-fafafa clearfix margin-bottom-20 wow fadeInRight"
                         style="min-height: 250px;">
                        <div class="col-md-4 alpha omega">
                            <?php
                            $postID = get_the_id();
                            $url = wp_get_attachment_url(get_post_thumbnail_id($postID));
                            $customField = get_post_custom($postID);
                            $room_plan = $customField["room_plan"][0];
                            $type = $customField["type"][0];
                            $size = $customField["size"][0];
                            $designer = $customField["designer"][0];
                            $price = number_format($customField["price"][0]);
                            $recommend_price = get_post_meta($postID, 'recommend_price', true);
                            $recommend_price = is_array($recommend_price) ? @$recommend_price[intval(date_i18n('m')) - 1] : null;
                            $recommend_price = empty($recommend_price) ? null : number_format($recommend_price);

                            $facilities = $customField["facilities"][0];
                            if (empty($facilities)) {
                                $arrayFacilities = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
                            } else {
                                $arrayFacilities = explode(',', $facilities);
                            }

                            if (!empty($url)) {
                                ?>
                                <section class="img_thumb"
                                         style="margin: 0px; padding: 0px; height: auto; overflow: hidden;">
                                    <a href="<?php the_permalink(); ?>?long-stay=true">
                                        <img class="col-md-12 alpha omega" alt="<?php the_title(); ?>"
                                             src="<?php echo $url; ?>" style="width: auto; height: 360px; left: -15%;"/>
                                    </a>
                                </section>
                            <?php
                            } else {
                                ?>
                                <section class="img_thumb"
                                         style="margin: 0px; padding: 0px; width: auto; height: 360px; overflow: hidden;">
                                    <a href="<?php the_permalink(); ?>?long-stay=true">
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
                            <img src="<?php echo $room_plan; ?>"
                                 style="width: auto; height: auto;"/>
                        </div>
                        <div class="col-md-6 alpha omega">
                            <a href="<?php the_permalink(); ?>?long-stay=true"><h3><?php the_title(); ?></h3></a>
                            <?php //the_excerpt();

                            ?>
                            <p class="font-12 padding-10">
                                Type: <?php echo $type; ?><br/>
                                Size: <?php echo $size; ?> sq.mtrs<br/>
                                Designer: <?php echo $designer; ?><br/>
                                Price: <?php echo !$recommend_price ? $price : $recommend_price; ?> THB/night (Incl
                                Breakfast)
                            </p>

                            <p class="font-12 padding-10" style="">
                                <?php
                                $excerpt = get_the_content();
                                $excerpt = strip_shortcodes($excerpt);
                                $excerpt = strip_tags($excerpt);
                                $the_str = substr($excerpt, 0, 150);
                                $the_str = strlen($the_str) < strlen($excerpt) ? $the_str . '...' : $the_str;
                                echo $the_str;
                                ?>
                            </p>

                            <p class="padding-10">
                                <?php
                                if ($arrayFacilities[0]):
                                    ?>
                                    <img title="FREE WIFI"
                                         src="<?php echo get_template_directory_uri() . '/library/images/baansaladaeng-icon-wifi.png' ?>"
                                         style="width: 32px; height: 32px;"/>
                                <?php endif;
                                if ($arrayFacilities[1]):?>
                                    <img title="BREAKFAST"
                                         src="<?php echo get_template_directory_uri() . '/library/images/baansaladaeng-icon-breakfast.png' ?>"
                                         style="width: 32px; height: 32px;"/>
                                <?php endif;
                                if ($arrayFacilities[2]):?>
                                    <img title="EN-SUITE BATHROOM"
                                         src="<?php echo get_template_directory_uri() . '/library/images/baansaladaeng-icon-ensuite-bathroom.png' ?>"
                                         style="width: 32px; height: 32px;"/>
                                <?php endif;
                                if ($arrayFacilities[3]):?>
                                    <img title="FLAT SCREEN TV"
                                         src="<?php echo get_template_directory_uri() . '/library/images/baansaladaeng-icon-flat-tv.png' ?>"
                                         style="width: 32px; height: 32px;"/>
                                <?php endif;
                                if ($arrayFacilities[4]):?>
                                    <img title="MINI BAR"
                                         src="<?php echo get_template_directory_uri() . '/library/images/baansaladaeng-icon-mini-bar.png' ?>"
                                         style="width: 32px; height: 32px;"/>
                                <?php endif;
                                if ($arrayFacilities[5]):?>
                                    <img title="SAFETY DEPOSIT BOX"
                                         src="<?php echo get_template_directory_uri() . '/library/images/baansaladaeng-icon-safety-deposit-box.png' ?>"
                                         style="width: 32px; height: 32px;"/>
                                <?php endif;
                                if ($arrayFacilities[6]):?>
                                    <img title="KING SIZE BED"
                                         src="<?php echo get_template_directory_uri() . '/library/images/baansaladaeng-icon-king-size-bed.png' ?>"
                                         style="width: 32px; height: 32px;"/>
                                <?php endif;
                                if ($arrayFacilities[7]):?>
                                    <img title="QUEEN SIZE BED"
                                         src="<?php echo get_template_directory_uri() . '/library/images/baansaladaeng-icon-queen-size-bed.png' ?>"
                                         style="width: 32px; height: 32px;"/>
                                <?php endif;
                                if ($arrayFacilities[8]):?>
                                    <img title="TWIN BED"
                                         src="<?php echo get_template_directory_uri() . '/library/images/baansaladaeng-icon-twin-bed.png' ?>"
                                         style="width: 32px; height: 32px;"/>
                                <?php endif;
                                if ($arrayFacilities[9]):?>
                                    <img title="PRIVATE BALCONY"
                                         src="<?php echo get_template_directory_uri() . '/library/images/baansaladaeng-icon-private-balcony.png' ?>"
                                         style="width: 32px; height: 32px;"/>
                                <?php endif; ?>
                            </p>

                            <div class="col-md-8 alpha" style="">
                                <?php if ($recommend_price): ?>
                                    <span style="margin-top: 0px; padding-top: 10px; font-size: 20px;">PRICE : <?php echo $price; ?> BAHT</span>
                                    <h3 style="margin-top: 0px; padding-top: 10px; color: red; padding-left: 0;">PRICE :
                                        <?php echo $recommend_price; ?> BAHT</h3>
                                <?php else: ?>
                                    <h3 style="margin-top: 0px; padding-top: 10px;">PRICE
                                        : <?php echo $price; ?> BAHT</h3>
                                <?php endif; ?>
                            </div>
                            <!--                            <div class="col-md-4 bg-ED2024" style="text-align: center; padding: 10px 0 10px 0; color: #fff; cursor: pointer;"-->
                            <!--                                onclick="$('form #frm_content_room').submit();">RESERVATION</div>-->

<!--                            <form id="frm_content_room" class="form" method="post"-->
<!--                                  action="--><?php //echo network_site_url('/') . "reservation"; ?><!--">-->
<!--                                <input type="hidden" value="true" name="booking_post"/>-->
<!--                                <input type="hidden" value="1" name="step"/>-->
<!--                                <input type="hidden" value="--><?php //the_title(); ?><!--" name="room_name"/>-->
<!--                                <input type="hidden" value="--><?php //echo $postID; ?><!--" name="room_id"/>-->
<!--                                <input type="hidden" value="" id="check_in_date" name="check_in_date"/>-->
<!--                                <input type="hidden" value="" id="check_out_date" name="check_out_date"/>-->
<!--                                <button class="col-md-4 col-xs-12 bg-ED2024 alpha omega"-->
<!--                                        style="text-align: center; padding: 10px 0 10px 0; color: #fff; border: 0px;"-->
<!--                                    >RESERVATION-->
<!--                                </button>-->
<!--                            </form>-->
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