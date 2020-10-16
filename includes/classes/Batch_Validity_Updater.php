<?php
/**
 * Created by PhpStorm.
 * User: bedom
 * Date: 10/14/2020
 * Time: 12:39 AM
 */

namespace SellMagazin;


class Batch_Validity_Updater
{

    public function update()
    {
        $all_posts = $this->get_all_post_with_interval();
        $valid_posts = $this->get_all_valid_post();
        foreach ($all_posts as $post) {
            $is_valid = in_array($post, $valid_posts);
            update_post_meta($post, 'sellmagazin_suggestion_valid', (int)$is_valid);
        }
        wp_reset_postdata();
    }

    private function get_all_post_with_interval()
    {
        $args = array(
            'fields' => 'ids',
            'posts_per_page' => -1,
            'post_type' => 'post',
            'meta_query' => array(
                array(
                    'key' => 'validity_period_start',
                ),
                array(
                    'key' => 'validity_period_end',
                ),
            ),
        );
        $query = new \WP_query();
        $query->query($args);
        return $query->get_posts();

    }

    private function get_all_valid_post()
    {
        $now = date('Ymd');
        $args = array(
            'post_type' => 'post',
            'posts_per_page' => -1,
            'fields' => 'ids',
            'meta_query' => array(
                array(
                    'key' => 'validity_period_start',
                    'value' => $now,
                    'type' => 'DATE',
                    'compare' => '<='
                ),
                array(
                    'key' => 'validity_period_end',
                    'value' => $now,
                    'type' => 'DATE',
                    'compare' => '>='
                ),
            )
        );
        $query = new \WP_query();
        $query->query($args);
        return $query->get_posts();
    }


}