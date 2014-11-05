
<?php
/*
 * This is the default post format.
 *
 * So basically this is a regular post. if you don't want to use post formats,
 * you can just copy ths stuff in here and replace the post format thing in
 * single.php.
 *
 * The other formats are SUPER basic so you can style them as you like.
 *
 * Again, If you want to remove post formats, just delete the post-formats
 * folder and replace the function below with the contents of the "format.php" file.
*/
?>

<h1><?php the_title(); ?></h1>
<article id="post-<?php the_ID(); ?>" class="cf container" role="article" itemscope itemtype="http://schema.org/BlogPosting">
    <div class="row">
        <header class="article-header">
            <h2 class="col-md-12" itemprop="headline">
                <?php the_title(); ?>
                <span class="font-color-999 font-size-14"><!-- Description of post --></span>
            </h2>
        </header>
        <hr class=""/>
        <section class="entry-content cf" itemprop="articleBody">
            <div class="portfolio-works col-md-12 margin-bottom-20">
                <?php for($i=1;$i<=9;$i++):?>
                    <div class="col-md-4 portfolio-work-grid wow bounceIn" data-wow-delay="0.4s">
                        <div class="portfolio-work-grid-pic">
                            <img src="libs/images/room-01.jpg" title="name" />
                        </div>
                    </div>
                <?php endfor; ?>
                <div class="clearfix"> </div>
            </div>
            <div class="text-center col-md-3 portfolio-work-grid wow bounceIn margin-bottom-20" data-wow-delay="0.4s">
                <div class="portfolio-work-grid-pic">
                    <img src="libs/images/room-10-1.gif" title="name" />
                </div>
            </div>
            <div class="col-md-9 wow fadeInLeft margin-bottom-20" data-wow-delay="1s">
                <p>
                <table class="">
                    <tr>
                        <td>Type:</td>
                        <td>Double King Size</td>
                    </tr>
                    <tr>
                        <td>Size:</td>
                        <td>45 sq.mtrs</td>
                    </tr>
                    <tr>
                        <td>Designer:</td>
                        <td>Nattawut Lamlertwittaya</td>
                    </tr>
                    <tr>
                        <td>Price:</td>
                        <td>2300 THB/night (Incl.Breakfast)</td>
                    </tr>
                </table>
                </p>
                <p class="font-color-999">
                    Inside or out, spoil yourself in our Mediterranean suite.  The panoramic windows give you views across the city.  Your own private, secluded sun deck comes with two loungers and an al fresco rain shower to help you cool off after long days soaking up the sun's rays.
                </p>


            </div>
        </section>
        <footer class="article-footer">

            <?php printf( __( 'Filed under: %1$s', 'bonestheme' ), get_the_category_list(', ') ); ?>

            <?php the_tags( '<p class="tags"><span class="tags-title">' . __( 'Tags:', 'bonestheme' ) . '</span> ', ', ', '</p>' ); ?>

        </footer> <?php // end article footer ?>
    </div>
</article> <?php // end article ?>