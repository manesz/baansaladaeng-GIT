<?php
$getContent = @$_GET['get_content'];
if ($getContent != 'true') {
    get_header();
    get_template_part('nav');
}
?>

    <section class="container">
        <div class="row">

            <div class="service-head text-center">
                <h2><?php the_title(); ?></h2>
                <span> </span>
            </div>
            <!--- services-grids --->
            <div class="services-grids">
                <div class="col-md-12">
                    <div class="service-grid wow fadeInDown" data-wow-delay="0.4s">
                        <?php the_content(); ?>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
            <!--- services-grids --->
        </div>
    </section>

<?php
if ($getContent != "true") {
    get_footer();
}
?>