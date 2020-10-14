<?php
/**
 * Created by PhpStorm.
 * User: bedom
 * Date: 10/14/2020
 * Time: 1:40 AM
 */

namespace SellMagazin;

use WP_Async_Request;


class Validity_Calculation_Request extends WP_Async_Request
{

    protected $action = 'validity_calculation';

    /**
     * Handle
     *
     * Override this method to perform any actions required
     * during the async request.
     */
    protected function handle()
    {
//        $calculator = new Validity_Calculator();
//        $calculator->calculate();
        sell_log('validity calculation happened');
    }
}