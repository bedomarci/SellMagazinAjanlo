<?php


namespace SellMagazin\Queue;




class Async_Job_Register extends \SellMagazin\Interfaces\Action_Register {
	protected $hook = 'plugins_loaded';

	public function run(...$args) {
		new Suggestion_Calculation_Request();
		new Batch_Suggestion_Calculation_Process();
		new Batch_Validity_Updater_Request();
	}
}