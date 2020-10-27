<?php
/**
 * Created by PhpStorm.
 * User: bedom
 * Date: 10/12/2020
 * Time: 5:43 PM
 */

namespace SellMagazin\Queue;


class Suggestion_Calculation_Process extends \WP_Background_Process
{

    protected $action = "batch_suggestion_calculation";


    protected function task($item)
    {
        sell_log("Process task " . print_r($item, true) . " (by " . get_current_user_id() . ") @" . getmypid());
//        $calculator = new Suggestion_Calculator($item);
//        $calculator->calculate();
        return false;
    }
}