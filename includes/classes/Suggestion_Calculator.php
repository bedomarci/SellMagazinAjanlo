<?php
/**
 * Created by PhpStorm.
 * User: bedom
 * Date: 10/12/2020
 * Time: 5:52 PM
 */

namespace SellMagazin;

class Suggestion_Calculator
{
    private $post_id;

    private $post;
    private $metas;
    private $suggestion_lookup_tags;
    private $suggestion_tags;

    /**
     * Suggestion_Calculator constructor.
     */
    public function __construct($post_id)
    {
        $this->post_id = $post_id;
        $this->post = get_post($this->post_id);
        $this->metas = get_post_meta($this->post_id);
        $this->suggestion_lookup_tags = get_post_meta($this->post_id, 'suggestion-lookup-tags', true);
        $this->suggestion_tags = get_post_meta($this->post_id, 'suggestion-tags', true);
    }

    public function calculate()
    {
        $this->update_calculation_date();
        $post_ids = array();
        $post_ids = array_merge($post_ids, $this->get_sponsored_content());
//        $post_ids = array_merge($post_ids, $this->get_highlighted_content());
//        $post_ids = array_merge($post_ids, $this->get_civil_content());
//        $post_ids = $this->remove_this_post($post_ids);
        $post_ids = $this->remove_duplicates($post_ids);

        sell_log('End of calculation: ' . print_r($post_ids, true));
    }

    public function update_post()
    {

    }


    private function get_sponsored_content()
    {
        $post_ids = [];
        sell_log(print_r($this->suggestion_lookup_tags, true));
        foreach ($this->suggestion_lookup_tags as $tag) {
            sell_log("-$tag-");
            $query_args = array(
                'post_type' => 'post',
                'post_status' => 'publish',
                'fields' => 'ids',
                'posts_per_page' => '-1',
                'meta_query' => array(
                    '0' => array(
                        'key' => 'highlight',
                        'value' => 0,
                        'compare' => '=',
                    ),
                    '1' => array(
                        'key' => 'sellmagazin_suggestion_valid',
                        'value' => 1,
                        'compare' => '=',
                    ),
                    '2' => array(
                        'key' => 'suggestion-tags',
                        'value' => '"' . $tag . '"',
                        'compare' => 'LIKE',
                    ),
                    'relation' => 'AND',
                ),
            );
            $the_query = new \WP_Query($query_args);
            $posts = $the_query->get_posts();
            sell_log(print_r($posts, true));
            $post_ids = array_merge($post_ids, $posts);
        }
        return $post_ids;
    }

    private function get_highlighted_content()
    {
        $query_args = array(
            'post_type' => 'post',
            'post_status' => 'publish',
            'fields' => 'ids',
            'posts_per_page' => '1',
            'meta_query' => array(
                '0' => array(
                    'key' => 'highlight',
                    'value' => 1,
                    'compare' => '=',
                ),
                '1' => array(
                    'key' => 'sellmagazin_suggestion_valid',
                    'value' => 1,
                    'compare' => '=',
                ),
                'relation' => 'AND',
            ),
        );
        $the_query = new \WP_Query($query_args);
        return $the_query->get_posts();
    }

    private function get_civil_content()
    {
        return [];
    }

    private function remove_this_post ($post_ids) {
        $to_remove = array($this->post_id);
        return array_diff($post_ids, $to_remove);
    }

    private function remove_duplicates($post_ids){
        return array_unique($post_ids);
    }

    private function fill_missing_places($post_ids) {
        return $post_ids;
    }

    private function update_calculation_date() {
        update_post_meta($this->post_id, 'sellmagazin_suggestion_last_update', date('m/d H:i:s'));

    }
}