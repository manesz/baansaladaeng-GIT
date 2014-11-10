<?php get_header(); ?>
<?php get_template_part('nav'); ?>
    <style>
        table tr td { padding : 10px; }
    </style>

    <div class="container min-height-540">
        <div class="row">
            <div class="col-md-12 wow fadeInLeft margin-bottom-20" data-wow-delay="1s">
                <h2>Promotion</h2>
                <span class="font-color-999 font-size-14">BaanSaladaeng has served you the best price on the best location of Bangkok  !!! </span><span class="font-color-red">Don't miss...</span>
                <p>
                <table class="table-bordered" style="width: 100%">
                    <tr>
                        <td style="width: 20%">Rate / Night</td>
                        <td style="width: 20%">Regular rate / night</td>
                        <td style="width: 20%">Sep</td>
                        <td style="width: 20%">Oct</td>
                        <td style="width: 20%">Nov-Dec</td>
                        <td style="width: 20%">REDERVATION</td>
                    </tr>
                    <?php for($i=1; $i<=6; $i++):?>
                        <tr>
                            <td style="width: 20%">Room 201</td>
                            <td style="width: 20%">1,300 THB</td>
                            <td style="width: 20%">1,249 THB</td>
                            <td style="width: 20%">1,249 THB</td>
                            <td style="width: 20%">1,249 THB</td>
                            <td style="width: 20%"><a href="booking-page.php"><button class="col-md-12 alpha omega btn-service wow fadeIn" data-wow-delay="0.4s">RESERVATION</button></a></td>
                        </tr>
                    <?php endfor; ?>
                </table>
                </p>
                <p class="font-color-999 font-size-12">
                    *** NOTE  Rates above are net , come with free breakfast for 2 people + Free WI FI<br/>
                    ( Effective on year 2014 only )<br/><br/>

                    *** Our booking system is unable adjust price after discount , therefore rate shown on booking confirmation will be normal price . Actual cost will be charged upon arrival .
                </p>
            </div>
        </div>
    </div>
<?php get_footer(); ?>