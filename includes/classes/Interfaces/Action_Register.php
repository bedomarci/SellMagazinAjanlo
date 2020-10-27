<?php


namespace SellMagazin\Interfaces;


abstract class Action_Register {

	protected $hook = 'init';
	protected $prioroty = 10;
	protected $accepted_args = 1;

	public function run(...$args) {
		wp_die( "Action callback is not implemented in " . __CLASS__ . "!" );
	}

	/**
	 * @return string
	 */
	public function get_hook(): string {
		return $this->hook;
	}

	/**
	 * @return int
	 */
	public function get_prioroty(): int {
		return $this->prioroty;
	}

	/**
	 * @return int
	 */
	public function get_accepted_args(): int {
		return $this->accepted_args;
	}

}