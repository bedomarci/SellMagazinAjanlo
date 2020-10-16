<?php
/**
 * Created by PhpStorm.
 * User: bedom
 * Date: 10/14/2020
 * Time: 1:40 AM
 */

namespace SellMagazin;

use WP_Async_Request;


class Batch_Validity_Updater_Request extends WP_Async_Request
{

    protected $action = 'validity_calculation';


    protected function handle()
    {
        $updater = new Batch_Validity_Updater();
        $updater->update();
    }
}