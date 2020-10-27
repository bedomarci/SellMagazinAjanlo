<?php
/**
 * Created by PhpStorm.
 * User: bedom
 * Date: 10/15/2020
 * Time: 1:21 PM
 */

namespace SellMagazin\PostUpdater;


use SellMagazin\Interfaces\Action_Register;

class Highlight_Updater extends Action_Register {

	protected $hook = 'save_post_post';
	protected $accepted_args = 4;
	protected $post_id;

	public function run( ...$args ) {
		$this->post_id = $args[0];
		$highlight = $_POST['acf']['field_highlight'];

		$query = $this->get_highlighted_posts_query();

		$has_previous_highlight = $query->found_posts;

		if ( ! defined( 'highlight_option_updated' ) ) {
			if ( ! $has_previous_highlight && ! $highlight ) {
				update_option( 'highlighted_post_id', - 1 );
			}
			if ( $highlight ) {
				update_option( 'highlighted_post_id', $this->post_id );
			}
		}
		define( 'highlight_option_updated' );

		if ( $has_previous_highlight ) {
			$highlighted_post_ids = $query->get_posts();

			foreach ( $highlighted_post_ids as $id ) {
				update_post_meta( $id, 'highlight', 0 );
			}
			wp_reset_postdata();
		}
	}

	function get_highlighted_posts_query() {
		$query_args = array(
			'post_type'      => 'post',
			'post_status'    => 'publish',
			'post__not_in'   => array($this->post_id),
			'fields'         => 'ids',
			'posts_per_page' => '-1',
			'meta_query'     => array(
				'0' => array(
					'key'     => 'highlight',
					'value'   => 1,
					'compare' => '=',
				),
			),
		);
		$the_query  = new \WP_Query( $query_args );

		return $the_query;
	}
}