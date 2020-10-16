<?php
/**
 * Created by PhpStorm.
 * User: bedom
 * Date: 10/15/2020
 * Time: 1:21 PM
 */

namespace SellMagazin;


class Highlight_Updater
{

    function handle($meta_id, $post_id, $meta_key, $meta_value)
    {
        if ($meta_key != 'highlight' && $meta_value != 1) return;

        $highlighted_post_ids = $this->get_highlighted_posts();

        foreach ($highlighted_post_ids as $id) {
            if ($id == $post_id) continue;
            update_post_meta($id, 'highlight', 0);
        }
        wp_reset_postdata();
    }

    function get_highlighted_posts()
    {
        $query_args = array(
            'post_type' => 'post',
            'post_status' => 'publish',
            'fields' => 'ids',
            'posts_per_page' => '-1',
            'meta_query' => array(
                '0' => array(
                    'key' => 'highlight',
                    'value' => 1,
                    'compare' => '=',
                ),
            ),
        );
        $the_query = new \WP_Query($query_args);
        return $the_query->get_posts();
    }
}