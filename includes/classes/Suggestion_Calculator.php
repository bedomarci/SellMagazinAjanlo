<?php
/**
 * Created by PhpStorm.
 * User: bedom
 * Date: 10/12/2020
 * Time: 5:52 PM
 */

namespace SellMagazin;

use DateTime;
use DateTimeZone;

class Suggestion_Calculator {
	private $post_id;

	private $post;
	private $metas;
	private $suggestion_lookup_tags;
	private $suggestion_tags;
	private $number_of_suggestion_calculation;

	/**
	 * Suggestion_Calculator constructor.
	 */
	public function __construct( $post_id ) {
		$this->post_id                          = $post_id;
		$this->post                             = get_post( $this->post_id );
		$this->metas                            = get_post_meta( $this->post_id );
		$this->suggestion_lookup_tags           = get_post_meta( $this->post_id, 'suggestion-lookup-tags', true );
		$this->suggestion_tags                  = get_post_meta( $this->post_id, 'suggestion-tags', true );
		$option                                 = get_option( 'suggestion_calculator_settings_option_name' );
		$this->number_of_suggestion_calculation = $option ? $option['number_of_suggestion_calculation'] : 20;
	}

	public function calculate() {
		$post_suggestion_ids = array();
		$post_suggestion_ids = array_merge( $post_suggestion_ids, $this->get_sponsored_content() );
//        $post_ids = array_merge($post_ids, $this->get_highlighted_content());
//        $post_ids = array_merge($post_ids, $this->get_civil_content());
		$post_suggestion_ids = $this->remove_this_post( $post_suggestion_ids );
//	    $post_suggestion_ids = $this->remove_duplicates($post_suggestion_ids);
		$post_suggestion_ids = $this->fill_missing_places( $post_suggestion_ids );
		$this->update_post( $post_suggestion_ids );
	}

	public function update_post( $post_suggestion_ids ) {
		$tz  = new DateTimeZone( wp_timezone_string() );
		$now = new DateTime( "now", $tz );
		sell_log( '(' . $this->post_id . ') End of calculation: ' . implode( ', ', $post_suggestion_ids ) );
		update_post_meta( $this->post_id, 'suggestion_last_update', $now->format( 'm/d H:i:s' ) );
		update_post_meta( $this->post_id, 'suggestions', $post_suggestion_ids );
	}


	private function get_sponsored_content() {
		$post_ids = [];
		foreach ( $this->suggestion_lookup_tags as $tag ) {
			$query_args = array(
				'post_type'      => 'post',
				'post_status'    => 'publish',
				'fields'         => 'ids',
				'posts_per_page' => '-1',
				'meta_query'     => array(
					'0'        => array(
						'key'     => 'highlight',
						'value'   => 0,
						'compare' => '=',
					),
					'1'        => array(
						'key'     => 'commercial_nature',
						'value'   => 'sponsored',
						'compare' => 'LIKE',
					),
					'2'        => array(
						'key'     => 'sellmagazin_suggestion_valid',
						'value'   => 1,
						'compare' => '=',
					),
					'3'        => array(
						'key'     => 'suggestion-tags',
						'value'   => '"' . $tag . '"',
						'compare' => 'LIKE',
					),
					'relation' => 'AND',
				),
			);
			$the_query  = new \WP_Query( $query_args );
			$posts      = $the_query->get_posts();
			sell_log( print_r( $posts, true ), true );
			$post_ids = array_merge( $post_ids, $posts );
		}

		return $post_ids;
	}

	private function get_highlighted_content() {
//		$query_args = array(
//			'post_type'      => 'post',
//			'post_status'    => 'publish',
//			'fields'         => 'ids',
//			'posts_per_page' => '1',
//			'meta_query'     => array(
//				'0'        => array(
//					'key'     => 'highlight',
//					'value'   => 1,
//					'compare' => '=',
//				),
//				'1'        => array(
//					'key'     => 'sellmagazin_suggestion_valid',
//					'value'   => 1,
//					'compare' => '=',
//				),
//				'relation' => 'AND',
//			),
//		);
//		$the_query  = new \WP_Query( $query_args );
//
//		return $the_query->get_posts();

		$highlighted_post_id = get_option( 'highlighted_post_id', - 1 );

		return ( $highlighted_post_id == - 1 ) ? [] : [ $highlighted_post_id ];
	}

	private function get_civil_content() {
		$post_ids = [];
//        sell_log(print_r($this->suggestion_lookup_tags, true));
		foreach ( $this->suggestion_lookup_tags as $tag ) {
			$query_args = array(
				'post_type'      => 'post',
				'post_status'    => 'publish',
				'fields'         => 'ids',
				'posts_per_page' => '-1',
				'meta_query'     => array(
					'0'        => array(
						'key'     => 'highlight',
						'value'   => 0,
						'compare' => '=',
					),
					'1'        => array(
						'key'     => 'commercial_nature',
						'value'   => 'civil',
						'compare' => 'LIKE',
					),
					'2'        => array(
						'key'     => 'sellmagazin_suggestion_valid',
						'value'   => 1,
						'compare' => '=',
					),
					'3'        => array(
						'key'     => 'suggestion-tags',
						'value'   => '"' . $tag . '"',
						'compare' => 'LIKE',
					),
					'relation' => 'AND',
				),
			);
			$the_query  = new \WP_Query( $query_args );
			$posts      = $the_query->get_posts();
//            sell_log(print_r($posts, true));
			$post_ids = array_merge( $post_ids, $posts );
		}

		return $post_ids;
	}

	private function remove_this_post( $post_ids ) {
		$to_remove = array( $this->post_id );

		return array_diff( $post_ids, $to_remove );
	}

	private function remove_duplicates( $post_ids ) {
		return array_unique( $post_ids );
	}

	private function fill_missing_places( $post_ids ) {
		$current_number_of_suggestions = count( $post_ids );
		if ( $current_number_of_suggestions < $this->number_of_suggestion_calculation ) {

			$number_of_missing = $this->number_of_suggestion_calculation - $current_number_of_suggestions;
			$post_ids          = array_merge( $post_ids, array_fill( 0, $number_of_missing, 1 ) ); //TODO -1 gyel kell feltolteni
//			$post_ids          = array_merge( $post_ids, array_fill( 0, $number_of_missing, -1 ) );

		}

		return $post_ids; //TODO: fill missing places in suggestion array
	}

}