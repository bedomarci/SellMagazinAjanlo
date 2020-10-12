<?php
/**
 * Created by PhpStorm.
 * User: bedom
 * Date: 10/12/2020
 * Time: 5:43 PM
 */

class Suggestion_Calculation_Request extends WP_Async_Request
{
    /**
     * Handle
     *
     * Override this method to perform any actions required
     * during the async request.
     */

    protected $postId;

    /**
     * Suggestion_Calculation_Request constructor.
     * @param $postId
     */
    public function __construct($postId)
    {
        $this->postId = $postId;
    }


    protected function handle()
    {
        $calculator = new Suggestion_Calculator($this->postId);
        $calculator->calculate();
    }
}