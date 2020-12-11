<?php
/**
 * Created by PhpStorm.
 * User: bedom
 * Date: 10/16/2020
 * Time: 12:54 AM
 */

namespace SellMagazin\PostUpdater;


use DateTime;
use DateTimeZone;
use SellMagazin\Interfaces\Action_Register;

class Single_Validity_Updater extends Action_Register {
	protected $hook = 'update_post_meta';
	protected $accepted_args = 4;

	public function run( ...$args ) {
		$meta_id    = $args[0];
		$post_id    = $args[1];
		$meta_key   = $args[2];
		$meta_value = $args[3];
		if ( $meta_key != 'validity_period_start' && $meta_key != 'validity_period_end' ) {
			return;
		}
		$validity_start = get_post_meta( $post_id, 'validity_period_start', true );
		$validity_end   = get_post_meta( $post_id, 'validity_period_end', true );
		$tz             = new DateTimeZone( wp_timezone_string() );
		$now            = new DateTime( "now", $tz );
		$validity_start = new DateTime( $validity_start, $tz );
		$validity_end   = new DateTime( $validity_end, $tz );

		sell_log("updated ". $post_id);
		$is_valid = (int) ( $validity_start <= $now && $validity_end >= $now );
		update_post_meta( $post_id, 'sellmagazin_suggestion_valid', $is_valid );
	}

}