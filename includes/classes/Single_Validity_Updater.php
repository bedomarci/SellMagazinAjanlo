<?php
/**
 * Created by PhpStorm.
 * User: bedom
 * Date: 10/16/2020
 * Time: 12:54 AM
 */

namespace SellMagazin;


use DateTime;
use DateTimeZone;

class Single_Validity_Updater
{
    function handle($meta_id, $post_id, $meta_key, $meta_value)
    {
        if ($meta_key != 'validity_period_start' && $meta_key != 'validity_period_end') return;
        sell_log("$meta_id, $post_id, $meta_key, $meta_value");

        $validity_start = get_post_meta($post_id, 'validity_period_start', true);
        $validity_end = get_post_meta($post_id, 'validity_period_end', true);
        $tz = new DateTimeZone(wp_timezone_string());
        $now = new DateTime("now", $tz);
        $validity_start = new DateTime($validity_start, $tz);
        $validity_end = new DateTime($validity_end, $tz);


//        sell_log($now->getTimestamp());
//        sell_log($validity_start->getTimestamp());
//        sell_log($validity_end->getTimestamp());
//        sell_log($validity_start->format("Y-m-d H:i:s"));
//        sell_log($validity_end->format("Y-m-d H:i:s"));

        $is_valid = (int)($validity_start <= $now && $validity_end >= $now);
        update_post_meta($post_id, 'sellmagazin_suggestion_valid', $is_valid);
    }

}