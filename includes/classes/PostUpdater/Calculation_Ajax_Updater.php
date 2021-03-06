<?php


namespace SellMagazin\PostUpdater;


use SellMagazin\Interfaces\Action_Register;
use SellMagazin\Queue\Suggestion_Calculation_Request;
use SellMagazin\Calculator\Suggestion_Calculator;

class Calculation_Ajax_Updater extends Action_Register {
	protected $hook = 'wp_ajax_recalculate_suggestion';

	public function run(...$args) {
		$job = new Suggestion_Calculation_Request();
		$job->set_post_id( $_POST['post_id'] )->dispatch();

//		do_action('sell_magazin_suggestion_update_schedule');

	}

}