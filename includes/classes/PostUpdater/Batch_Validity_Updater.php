<?php
/**
 * Created by PhpStorm.
 * User: bedom
 * Date: 10/14/2020
 * Time: 12:39 AM
 */

namespace SellMagazin\PostUpdater;


use SellMagazin\Interfaces\Action_Register;
use SellMagazin\Queue\Batch_Validity_Updater_Request;

class Batch_Validity_Updater extends Action_Register {

	protected $hook = 'sell_magazin_validity_update_schedule';

	public function run(...$args) {
		$job = new Batch_Validity_Updater_Request();
		$job->dispatch();
	}
}