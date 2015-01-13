<?php

$objClassContact = new Contact($wpdb);
$arrayContact = $objClassContact->getContact(1);
if ($arrayContact) {
    extract((array)$arrayContact[0]);
}
$latitude = @$latitude ? $latitude : "13.72631";
$longitude = @$longitude ? $longitude : "100.537379";

$printVersion = get_the_content("http://127.0.0.1:11001/baansaladaeng-GIT/wp/print-version/");
$printVersion = trim(preg_replace('/\s\s+/', ' ', $printVersion));
$printVersion = str_replace("'", '"', $printVersion);

get_header(); ?>
<?php get_template_part('nav'); ?>
    <style>
        table tr td {
            padding: 10px;
        }
    </style>

    <div class="container min-height-540" style="padding-top: 50px;">
        <div class="row">

            <h2 class="margin-bottom-20">Contact</h2>
            <hr/>
            <!-- google map -->
            <section id="maps" class="margin-bottom-20" style="">
                <div id="map_canvas" class="map rounded wow fadeIn" data-wow-delay="0.4s"
                     style="width: 100%; height: 500px; background: #ddd;"></div>
            </section>

            <div class="col-md-12 wow fadeInLeft margin-bottom-20" data-wow-delay="1s">
                <?php the_content(); ?>
            </div>

<!--            <div class="col-md-12 wow fadeInLeft margin-bottom-20" data-wow-delay="1s">-->
<!--                <div class="col-md-4"-->
<!--                     style="text-align: center; padding: 10px 0 10px 0; color: #fff; ">-->
<!--                    <button id="btn_print"-->
<!--                            class="btn btn-default col-md-12 col-xs-12 alpha omega btn-service wow fadeIn animated">-->
<!--                        Print-->
<!--                    </button>-->
<!--                </div>-->
<!--            </div>-->
            <div id="print_version"><?php
                $page = get_page_by_title('Print Version');
                $content = apply_filters('the_content', $page->post_content);
                echo $content;
                ?></div>
            <style type="text/css">

                #btn_print {
                    display: block;
                }

                #print_version {
                    display: none;
                }

                @media print {
                    #btn_print {
                        display: none;
                    }
                }
            </style>

        </div>
    </div>
    <head>
    </head>
    <!-- JS script -->
    <script type="text/javascript">
        $(function () {
//            demo.add(function () {
            $('#map_canvas').gmap({
                'center': '<?php echo $latitude; ?>,<?php echo $longitude; ?>',
                'zoom': 15,
                'disableDefaultUI': false, 'callback': function () {
                    var self = this;
                    self.addMarker({'position': this.get('map').getCenter() }).click(function () {
                        self.openInfoWindow({ 'content': 'Baansaladaeng' }, this);
                    });
                }});
//            }).load();


            $("#btn_print").click(function () {
                PopupPrint();
            });
        });


        function PopupPrint() {
            var $contents = $("#print_version").html();
            var mywindow = window.open('', 'my div', 'height=400,width=600');
            mywindow.document.write('<html><head><title>Contact</title>');
            mywindow.document.write('</head><body style="text-align: center;">');
            mywindow.document.write($contents);
            mywindow.document.write('</body></html>');

            mywindow.document.close(); // necessary for IE >= 10
            mywindow.focus(); // necessary for IE >= 10

            mywindow.print();
            mywindow.close();
        }
    </script>
<?php get_footer(); ?>