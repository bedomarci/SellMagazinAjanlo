<?php


namespace SellMagazin\PostUpdater;


use SellMagazin\Interfaces\Action_Register;
use SellMagazin\Queue\Batch_Suggestion_Calculation_Process;
use SellMagazin\Queue\Batch_Validity_Updater_Request;

class Batch_Calculation_Updater extends Action_Register {

	protected $hook = 'sell_magazin_suggestion_update_schedule';

	public function run( ...$args ) {
		$query_args = array(
			'post_type'   => 'post',
			'post_status' => 'publish',
			'posts_per_page' => '-1',
			'fields'      => 'ids',
		);
		$the_query  = new \WP_Query( $query_args );
		$posts      = $the_query->get_posts();

		$job = new Batch_Suggestion_Calculation_Process();

		foreach ( $posts as $post ) {
			$job->push_to_queue( $post );
		}

		$job->save()->dispatch();
	}
}