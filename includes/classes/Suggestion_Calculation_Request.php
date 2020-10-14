<?php
/**
 * Created by PhpStorm.
 * User: bedom
 * Date: 10/12/2020
 * Time: 5:43 PM
 */

namespace SellMagazin;

use WP_Async_Request;

class Suggestion_Calculation_Request extends WP_Async_Request
{
    protected $action = "single_suggestion_calculation";

    public function set_post_id($postId)
    {
        $this->data(array('post_id' => $postId));
        return $this;
    }

    protected function handle()
    {

//        $message = "on dispatch " . $_POST['post_id'];
//        sell_log($message);
        $calculator = new Suggestion_Calculator($_POST['post_id']);
        $calculator->calculate();
    }
}