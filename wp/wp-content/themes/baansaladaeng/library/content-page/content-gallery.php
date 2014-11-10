<?php
$classImageGallery = new ImageGallery($wpdb);
$arrayImageGallery = $classImageGallery->getList();
?>
<?php get_header(); ?>
<?php get_template_part('nav'); ?>
<?php get_template_part('booking', 'bar'); ?>

    <div class="portfolio-works">
        <?php foreach ($arrayImageGallery as $key => $value):
            $imagePath = $value->image_path ? $value->image_path :
            get_template_directory_uri() . '/library/images/no-thumb.png';
            ?>
            <div class="col-md-4 portfolio-work-grid wow bounceIn" data-wow-delay="0.4s"
                 style="height: 300px; overflow: hidden;">
                <div class="portfolio-work-grid-pic">
                    <a href="<?php echo $value->link ? $value->link : "#"; ?>">
                        <img src="<?php echo $imagePath; ?>"
                             title="<?php echo $value->title; ?>" style="top: -20%;"/>
                    </a>
                </div>
                <div class="portfolio-work-grid-caption">
                    <a href="<?php echo $value->link ? $value->link : "#"; ?>">
                        <h4><?php echo $value->title; ?></h4></a>
                    <a href="<?php echo $value->link ? $value->link : "#"; ?>">
                        <p><?php echo $value->description; ?></p></a>
                </div>
            </div>
        <?php endforeach; ?>
        <div class="clearfix"></div>
    </div>

<?php get_footer(); ?>