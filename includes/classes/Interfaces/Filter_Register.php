<?php


namespace SellMagazin\Interfaces;


abstract class Filter_Register {

	protected $hook = '';
	protected $prioroty = 10;
	protected $accepted_args = 1;

	public function filter($data) {
		return $data;
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