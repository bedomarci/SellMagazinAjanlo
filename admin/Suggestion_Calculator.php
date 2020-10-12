<?php
/**
 * Created by PhpStorm.
 * User: bedom
 * Date: 10/12/2020
 * Time: 5:52 PM
 */

class Suggestion_Calculator
{
    private $postId;

    /**
     * Suggestion_Calculator constructor.
     */
    public function __construct($postId)
    {
        $this->postId = $postId;
    }

    public function calculate() {
        error_log(time() . "");
    }

    public function update_post() {

    }
}