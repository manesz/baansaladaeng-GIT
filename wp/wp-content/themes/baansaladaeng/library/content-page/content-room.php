<?php get_header(); ?>
<?php get_template_part('nav'); ?>
    <section class="container" style="padding-top: 50px;">
        <div class="row">

            <h2 class="text-center margin-bottom-20">Rooms</h2>
            <hr/>
            <div id="sectionRoom">
                <?php
                $loop = new WP_Query(array('post_type' => 'room',/* 'posts_per_page' => 10*/));
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
                            $type = $customField["type"][0];
                            $size = $customField["size"][0];
                            $designer = $customField["designer"][0];
                            $price = number_format($customField["price"][0]);
                            $recommend_price = number_format($customField["recommend_price"][0]);
                            if (!empty($url)) {
                                ?>
                                <section class="img_thumb"
                                         style="margin: 0px; padding: 0px; height: 100%; overflow: hidden;">
                                    <a href="<?php echo the_permalink(); ?>">
                                        <img class="col-md-12 alpha omega" alt="<?php the_title(); ?>"
                                             src="<?php echo $url; ?>" style="width: 100%; height: 360px; top: -25%;"/>
                                    </a>
                                </section>
                            <?php
                            } else {
                                ?>
                                <section class="img_thumb"
                                         style="margin: 0px; padding: 0px; width: 100%; height: 360px; overflow: hidden;">
                                    <a href="<?php echo the_permalink(); ?>">
                                        <img class="col-md-12 alpha omega" alt="<?php the_title(); ?>"
                                             src="<?php echo get_template_directory_uri(); ?>/library/images/no-thumb.png"
                                             style="width: 100%; top: -25%"/>
                                    </a>
                                </section>

                            <?php
                            }
                            ?>
                        </div>
						<div class="col-md-2 text-center" style="padding-top: 15px;">
							<img src="<?php echo get_template_directory_uri().'/library/images/baansaladaeng_room_201.gif' ?>" style="width: auto; height: auto;"/>
						</div>
                        <div class="col-md-6 alpha omega">
                            <a href="<?php echo the_permalink(); ?>"><h3><?php the_title(); ?></h3></a>
                            <?php //the_excerpt();

                            ?>
                            <p class="font-12 padding-10">
                                Type: <?php echo $type; ?><br/>
                                Size: <?php echo $size; ?> sq.mtrs<br/>
                                Designer: <?php echo $designer; ?><br/>
                                Price: <?php echo $price; ?> THB/night (Incl Breakfast)
                            </p>
                            <p class="font-12 padding-10" style="">
                                <?php
                                $excerpt = get_the_content();
                                $excerpt = strip_shortcodes($excerpt);
                                $excerpt = strip_tags($excerpt);
                                $the_str = substr($excerpt, 0, 150);
                                $the_str = strlen($the_str) < strlen($excerpt) ? $the_str . '...': $the_str;
                                echo $the_str;
                                ?>
                            </p>
							<p class="padding-10">
								<img src="<?php echo get_template_directory_uri().'/library/images/baansaladaeng-icon-king-size-bed.png' ?>" style="width: 32px; height: 32px;"/>
								<img src="<?php echo get_template_directory_uri().'/library/images/baansaladaeng-icon-twin-bed.png' ?>" style="width: 32px; height: 32px;"/>
								<img src="<?php echo get_template_directory_uri().'/library/images/baansaladaeng-icon-mini-bar.png' ?>" style="width: 32px; height: 32px;"/>
								<img src="<?php echo get_template_directory_uri().'/library/images/baansaladaeng-icon-private-balcony.png' ?>" style="width: 32px; height: 32px;"/>
								<img src="<?php echo get_template_directory_uri().'/library/images/baansaladaeng-icon-queen-size-bed.png' ?>" style="width: 32px; height: 32px;"/>
								<img src="<?php echo get_template_directory_uri().'/library/images/baansaladaeng-icon-ensuite-bathroom.png' ?>" style="width: 32px; height: 32px;"/>
								<img src="<?php echo get_template_directory_uri().'/library/images/baansaladaeng-icon-flat-tv.png' ?>" style="width: 32px; height: 32px;"/>
								<img src="<?php echo get_template_directory_uri().'/library/images/baansaladaeng-icon-safety-deposit-box.png' ?>" style="width: 32px; height: 32px;"/>
								<img src="<?php echo get_template_directory_uri().'/library/images/baansaladaeng-icon-breakfast.png' ?>" style="width: 32px; height: 32px;"/>
								<img src="<?php echo get_template_directory_uri().'/library/images/baansaladaeng-icon-wifi.png' ?>" style="width: 32px; height: 32px;"/>
							</p>
                            <div class="col-md-8 alpha" style=""><h3 style="margin-top: 0px; padding-top: 10px;">PRICE : <?php echo $price; ?> BAHT</h3></div>
<!--                            <div class="col-md-4 bg-ED2024" style="text-align: center; padding: 10px 0 10px 0; color: #fff; cursor: pointer;"-->
<!--                                onclick="$('form #frm_content_room').submit();">RESERVATION</div>-->

                            <form id="frm_content_room" class="form" method="post" action="<?php echo network_site_url('/'). "reservation"; ?>">
                                <input type="hidden" value="true" name="booking_post"/>
                                <input type="hidden" value="1" name="step"/>
                                <input type="hidden" value="<?php the_title(); ?>" name="room_name"/>
                                <input type="hidden" value="<?php echo $postID; ?>" name="room_id"/>
                                <button class="col-md-4 col-xs-12 bg-ED2024 alpha omega" style="text-align: center; padding: 10px 0 10px 0; color: #fff; border: 0px;"
                                                         >RESERVATION</button>
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