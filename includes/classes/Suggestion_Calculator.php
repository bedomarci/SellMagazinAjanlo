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
    }

    public function calculate()
    {
//        $this->post = get_post($this->post_id);
//        $this->metas = get_post_meta($this->post_id);
//        $this->suggestion_lookup_tags = get_post_meta($this->post_id, 'suggestion-lookup-tags', true);
//        $this->suggestion_tags = get_post_meta($this->post_id, 'suggestion-tags', true);
//        update_post_meta($this->post_id, 'sellmagazin_suggestion_last_update', date('m/d H:i:s'));
//        return $this->suggestion_tags;
        sell_log("calculation: " . $this->post_id . " (by " . get_current_user_id() . ") @" . getmypid());
    }

    public function update_post()
    {

    }


    private function get_sponsored_content($post, $metas)
    {


    }

    private function get_highlighted_content()
    {
        $query_args = array(
            'post_type' => 'post',
            'meta_query' => array(
                '0' => array(
                    'key' => 'highilight',
                    'value' => '1',
                    'compare' => '=',
                ),
                'relation' => 'AND',
            ),
        );
        $the_query = new WP_Query( $query_args );
    }

    private function get_civil_content()
    {

    }
}