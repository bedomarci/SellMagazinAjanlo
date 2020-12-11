<?php


namespace SellMagazin\PostMeta;


class Register_Manage_Posts_Columns extends \SellMagazin\Interfaces\Filter_Register {
	protected $hook = 'manage_post_posts_columns';

	public function filter( $data ) {
		$data['suggestion_tags'] = "Saját cimkék";
		$data['suggestion_lookup_tags'] = "Ajánlási cimkék";
		unset($data['author']);
		unset($data['tags']);
		return $data;
	}

}