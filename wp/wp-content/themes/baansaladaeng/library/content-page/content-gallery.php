<?php
$classImageGallery = new ImageGallery($wpdb);
$arrayImageGallery = $classImageGallery->getList();
?>
<?php get_header(); ?>
<?php get_template_part('nav'); ?>
<?php get_template_part('booking', 'bar'); ?>

    <div class="portfolio-works" style="padding-top: 50px;">
        <?php foreach ($arrayImageGallery as $key => $value):
            $imagePath = $value->image_path ? $value->image_path :
            get_template_directory_uri() . '/library/images/no-thumb.png';
            ?>
            <div class="col-md-4 portfolio-work-grid wow bounceIn" data-wow-delay="0.4s"
                 style="height: 300px; overflow: hidden;">
                <div class="portfolio-work-grid-pic">
					<a href="<?php echo $imagePath; ?>" class="example-image-link"  data-lightbox="example-set" data-title="<?php $value->title ?>">
						<img src="<?php echo $imagePath; ?>" class="example-image" alt="<?php $value->title ?>"/>
					</a>
                </div>
            </div>
        <?php endforeach; ?>
        <div class="clearfix"></div>
    </div>

<?php get_footer(); ?>