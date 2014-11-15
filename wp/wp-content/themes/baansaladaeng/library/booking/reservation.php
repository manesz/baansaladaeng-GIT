<?php
/**
 * Created by PhpStorm.
 * User: Rux
 * Date: 10/10/2557
 * Time: 13:13 น.
 */
$thisMonth = date_i18n('m');
$thisYear = date_i18n('Y');
$getMonth = @$_POST['rmonth'];
$getYear = @$_POST['ryear'];

$arrayMonth = array(
    1 => "Janaury",
    2 => "February",
    3 => "March",
    4 => "April",
    5 => "May",
    6 => "June",
    7 => "July",
    8 => "August",
    9 => "September",
    10 => "October",
    11 => "November",
    12 => "December",
);
?>
<aside id="text-2" class="widget widget_text">
    <h1 class="widget-title">RESERVATION</h1>

    <div class="textwidget">
        <form method="post" action="<?php echo get_site_url(); ?>/booking/">
            <input type="hidden" name="reservation" value="true">
            <select name="rmonth" id='rmonth'>
                <?php foreach ($arrayMonth as $key => $value): ?>
                    <?php if ($thisMonth <= $key): ?>
                        <option <?php echo $getMonth == $key ? "selected" : ""; ?>
                            value="<?php echo $key; ?>"><?php echo $value; ?></option>
                    <?php endif; ?>
                <?php endforeach; ?>
            </select>
            <select name="ryear" id='ryear'>
                <?php for ($i = $thisYear; $i < $thisYear + 5; $i++) { ?>
                    <option <?php echo $getYear == $i ? "selected" : ""; ?>
                        value='<?php echo $i; ?>'><?php echo $i; ?></option>
                <?php } ?>
            </select>
            <input type="submit" value="check"/>
        </form>
    </div>
</aside>
