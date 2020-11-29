<?php
/**
 * Created by PhpStorm.
 * User: bedom
 * Date: 10/14/2020
 * Time: 1:40 AM
 */

namespace SellMagazin\Queue;


use SellMagazin\Calculator\Batch_Validity_Calculator;
use SellMagazin\PostUpdater\Batch_Validity_Updater;

class Batch_Validity_Updater_Request extends \WP_Async_Request {

	protected $action = 'validity_calculation';

	protected function handle() {
        $calculator = new Batch_Validity_Calculator();
        $calculator->calculate();
	}
}