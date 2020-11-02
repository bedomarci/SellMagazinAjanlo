<?php


namespace SellMagazin\PostMeta;


use SellMagazin\Interfaces\Action_Register;

class Post_Suggestion_Meta_Register extends Action_Register {

	protected $hook = 'init';

	public function run(...$args) {
		register_post_meta( 'post', 'suggestions', array(
			'show_in_rest' => false,
			'type'         => 'array',
		) );
		register_post_meta( 'post', 'suggestion_last_update', array(
			'show_in_rest' => false,
			'type'         => 'string',
		) );
		register_post_meta( 'post', 'sellmagazin_suggestion_valid', array(
			'show_in_rest' => false,
			'type'         => 'number',
		) );
	}

}