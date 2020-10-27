<?php


namespace SellMagazin\PostUpdater;


use SellMagazin\Queue\Suggestion_Calculation_Request;

class Calculation_Updater extends \SellMagazin\Interfaces\Action_Register {
	protected $hook = 'save_post_post';
	protected $accepted_args = 1;

	public function run(...$args) {
		$post_id = $args[0];
		$job = new Suggestion_Calculation_Request();
		$job->set_post_id( $post_id )->dispatch();
	}
}