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
		if ( ! array_key_exists( 'acf', $_POST ) ) {
			return;
		}
		$this->post_id = $args[0];
		$is_this_post_highlight     = $_POST['acf']['field_highlight'];

		$previous_highlight_id     = get_option( 'highlighted_post_id', - 1 );
		$has_previous_highlight = $previous_highlight_id != - 1;

		$next_highlight_id = - 1;
		if ( $previous_highlight_id == $this->post_id ) {
			if ( $is_this_post_highlight ) {
				$next_highlight_id = $this->post_id;
			}
		} else {
			if ( $is_this_post_highlight ) {
				$next_highlight_id = $this->post_id;
			} else {
				$next_highlight_id = $previous_highlight_id;
			}

			if ($has_previous_highlight) {
				update_post_meta( $previous_highlight_id, 'highlight', 0 );
			}

		}
		update_option( 'highlighted_post_id', $next_highlight_id );

	}
}