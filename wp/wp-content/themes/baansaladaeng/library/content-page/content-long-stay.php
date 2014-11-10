<?php get_header(); ?>
<?php get_template_part('nav'); ?>
    <section class="container">
        <div class="row">

            <h2 class="text-center margin-bottom-20">Long Stay</h2><hr/>
            <div id="sectionRoom">
                <?php
                    $categories = get_the_category();
                    $query = new WP_Query( 'posts_per_page= -1&cat='.$categories[0]->cat_ID );
                    if( $query->have_posts() ): while ( $query->have_posts() ): $query->the_post();
//                    for($i=1;$i<=3; $i++):
                ?>
                    <div class="col-md-12 alpha omega bg-fafafa clearfix margin-bottom-20 wow fadeInRight" style="min-height: 250px;">
                        <div class="col-md-4 alpha omega">
                            <?php
                            $postID = get_the_id();
                            $url = wp_get_attachment_url( get_post_thumbnail_id($postID) );
                            if(!empty($url)){
                                ?>
                                <section class="img_thumb" style="margin: 0px; padding: 0px; width: 100%; height: 250px; overflow: hidden;">
                                    <a href="<?php echo the_permalink();?>">
                                        <img class="col-md-12 alpha omega" alt="<?php the_title();?>" src="<?php echo $url;?>" style="width: 100%; top: -25%;"/>
                                    </a>
                                </section>
                            <?php
                            } else {
                                ?>
                                <section class="img_thumb" style="margin: 0px; padding: 0px; width: 100%; height: 250px; overflow: hidden;">
                                    <a href="<?php echo the_permalink();?>">
                                        <img class="col-md-12 alpha omega" alt="<?php the_title();?>" src="<?php echo get_template_directory_uri();?>/library/images/no-thumb.png" style="width: 100%; top: -25%"/>
                                    </a>
                                </section>

                            <?php
                            }
                            ?>
                        </div>
                        <div class="col-md-8 alpha omega content-thumb">
                            <a href="<?php echo the_permalink();?>"><h3><?php the_title();?></h3></a>
                            <?php the_excerpt(); ?>
                            <h3 class="col-md-8" style="margin-top: 0px; padding-top: 10px;">PRICE : 1,300 BAHT</h3>
                            <a href="<?php echo the_permalink();?>">
                                <div class="col-md-4 bg-ED2024" style="text-align: center; padding: 10px 0 10px 0; color: #fff; ">RESERVATION</div>
                            </a>
                        </div><div class="clearfix"> </div>
                    </div><div class="clearfix"> </div>
                <?php
//                    endfor;
                        endwhile;
                    else:
                        echo "No data.";
                    endif;
                ?>
            </div>
            <div class="clearfix"> </div>

        </div>
    </section>
<?php get_footer(); ?>