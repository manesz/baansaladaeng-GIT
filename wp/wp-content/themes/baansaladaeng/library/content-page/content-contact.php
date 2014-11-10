<?php

$objClassContact = new Contact($wpdb);
$arrayContact = $objClassContact->getContact(1);
if ($arrayContact) {
    extract((array)$arrayContact[0]);
}
$latitude = @$latitude ? $latitude : "13.72631";
$longitude = @$longitude ? $longitude : "100.537379";

get_header(); ?>
<?php get_template_part('nav'); ?>
    <style>
        table tr td {
            padding: 10px;
        }
    </style>

    <div class="container min-height-540">
        <div class="row">

            <!-- google map -->
            <section id="maps" class="margin-bottom-20" style="">
                <div id="map_canvas" class="map rounded wow fadeIn" data-wow-delay="0.4s"
                     style="width: 100%; height: 500px; background: #ddd;"></div>
            </section>

            <div class="col-md-12 wow fadeInLeft margin-bottom-20" data-wow-delay="1s">
                <h2>Contact</h2>
                <img src="<?php echo get_template_directory_uri(); ?>/library/images/map.jpg" class="col-md-6 pull-left"
                     style=""/>

                <p>
                    Baan Saladaeng<br/>
                    69/2 Soi Saladaeng,( dead-end soi opposite MK Gold restaurant ) Silom, Bangrak, Bangkok 10500
                    Thailand.<br/>
                    Tel : +66 (0) 2636 3038 (24 Hours everyday) Fax : +66 (0) 2636 3039<br/><br/>

                    Address in Thai : เลขที่ 69/2 ซอยศาลาแดง , แขวงสีลม เขตบางรัก กรุงเทพ ฯ 10500 ( บ้านศาลาแดง
                    บูติกเกสเฮ้าส์ อยู่ในซอยตัน ข้างตลาดนัด ตรงข้ามร้านสุกี้ เอ็มเค โกล ( MK gold restaurant )
                    หากต้องการสอบถามเส้นทาง กรุณาติดต่อเบอร์มือถือ 089 925 2329 หรือ 089 201 0040
                </p>

                <p class="font-color-999">
                    Baan Saladaeng is centrally located near many of Bangkok’s most of the famous places. We are within
                    walking distance (only a few minutes) to the Subway (MRTA), the Skytrain (BTS), Robinson Department
                    Store, Silom Complex, Patpong and the nightlife on Silom Road. All other places are easily reachable
                    by Taxi or public transport e.g.: The Grand Palace, Wat Arun, Khao San Road, Wat Pho etc<br/><br/>

                    Silom - Patpong, Soi 4, Soi 2, Soi Twilight, etc...<br/>
                    Silom is without question one on the city’s most important financial districts by day and by night
                    hosts some of the city’s most famous nightlife. Silom Road is Bangkok’s’ most cosmopolitan
                    street.<br/><br/>

                    As well as being a major shopping destination, Silom is also an entertainment district; with the
                    infamous Patpong, where the market starts at 20.00pm every evening between all the bars and shows,
                    there is also Soi Thaniya (Little Tokyo in Bangkok) with an amazing array of bars and shows.
                    Parallel to Silom Road runs Sathorn Road which is another business district and home to many of the
                    cities foreign Embassies and International Banks.<br/><br/>

                    Silom at night has many interesting walking streets, off Silom Road there are many side streets,
                    called Soi. Popular Soi’s are Soi 4 and Soi 2, both attracting mainly gay visitors from all over the
                    world a and locals alike. This is a must to visit in the evening for everybody. In Soi 4 there are
                    many bars with outdoor terraces where you enjoy your drink and watch the world pass by.<br/><br/>

                    In Patpong, you will find the Girlie Bars and Shows, In Surawong (parallel to Silom) are bars and
                    shows where boys perform in a variety of shows.<br/><br/>

                    Although Silom Road can be hectic, full of food stalls and vendors trying to sell their wares, it is
                    a fantastic experience to discover and explore interesting road. Walk slow, no rush, take in life as
                    local Thai do, don’t rush and enjoy!<br/><br/>

                    On Silom Road you will find the BTS Skytrain and MRT Subway plus a plenty supply of Taxi’s and Tuk
                    Tuk’s, the choice is yours.<br/><br/>

                    Safety; Bangkok is a major city, one of the world’s biggest ones. Although Bangkok is huge and
                    chaotic, the city is reasonable safe compare with other major cities around the world. Enjoy the
                    city, respect the local people and you have a great and trouble free Holiday!<br/><br/>

                    BANGKOK SHOPPING<br/>
                    Central World-MBK-Central Chidlom-Silom Complex- Siam Paragon-Gaysorn Plaza –Siam Center Jatujak -
                    (Weekend Market)<br/>
                    Bangkok is famous for shopping! There are so many Shopping Centre’s and markets in the city there
                    simply are not enough space here to list them.<br/>
                    Some popular places to visit include: Central World is a largest shopping mall in South East Asia
                    and Bangkok larger than for example Hong Kong's Ocean Terminal.. In 2006, 550,000 square metre
                    shopping mall was opened, topping that of its nearby rival Siam Paragon which is Bangkok’s premier
                    luxury Shopping Mall and contains Siam Ocean World which is the largest aquarium in the Southern
                    Hemisphere.<br/>
                    Siam Center and Siam Discovery loactred side by side can be found nearby adajacent to Siam BTS
                    Station. Directly opposite Siam BTS Station is Siam Square, where you will find a wide range of
                    shops and services, including restaurants, cafes, designer clothing boutique and the famous Hard
                    Rock Café. Shoppers vary from teenagers, University students to office workers. Is certainly a
                    vibrant and thriving area, well worth a visit.<br/><br/>

                    Need a new mobile? Need a reproduction of a painting? Go to MBK! This busy Shopping Mall attracts
                    over 120,000 people a day, walk around and see for yourself why this Shopping Mall is popular among
                    the Thai people.<br/><br/>

                    At the weekend (Saturday and Sunday) a must see is a visit to the Weekend-market Jatujak. It is
                    easily associable via the BTS (MorChit Station) and the MRT (Khempang Pet Station). At this world
                    famous market you find household items, clothing, Thai handicrafts, religious artifacts,
                    collectibles, food, and live animals. There are 1000’s of stalls selling everything. If you cannot
                    find what you want here then if does not exist. It is warm and busy but the atmosphere is relaxed,
                    enjoy it. Once you are tired of shopping there are so many places to relax, take a nice massage to
                    relax, have a drink at one of those popular Bars. In Bangkok everything is possible, you can even
                    Ice-skate downtown Bangkok!<br/><br/>

                    Useful tourist information on Bangkok can be obtained from the official website of the Bangkok
                    Tourism Division: http://www.bangkoktourist.com/
                </p>

            </div>
        </div>
    </div>

    <!-- JS script -->
    <script type="text/javascript">
        $(function () {
            demo.add(function () {
                $('#map_canvas').gmap({
                    'center': '<?php echo $latitude; ?>,<?php echo $longitude; ?>',
                    'zoom': 15,
                    'disableDefaultUI': false, 'callback': function () {
                        var self = this;
                        self.addMarker({'position': this.get('map').getCenter() }).click(function () {
                            self.openInfoWindow({ 'content': 'Hello World!' }, this);
                        });
                    }});
            }).load();
        });
    </script>
<?php get_footer(); ?>