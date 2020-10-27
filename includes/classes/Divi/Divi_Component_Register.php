<?php


namespace SellMagazin\Divi;


class Divi_Component_Register extends \SellMagazin\Interfaces\Action_Register {
	protected $hook = 'et_builder_modules_loaded';

	public function run(...$args) {
		new Suggestion_Divi_Builder_Module();
	}
}