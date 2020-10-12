<?php
/**
 * Created by PhpStorm.
 * User: bedom
 * Date: 10/12/2020
 * Time: 5:43 PM
 */

class Suggestion_Calculation_Process extends WP_Background_Process
{

    /**
     * Task
     *
     * Override this method to perform any actions required on each
     * queue item. Return the modified item for further processing
     * in the next pass through. Or, return false to remove the
     * item from the queue.
     *
     * @param mixed $item Queue item to iterate over.
     *
     * @return mixed
     */
    protected function task($item)
    {
        $calculator = new Suggestion_Calculator($item);
        $calculator->calculate();
    }
}