<?php


namespace SellMagazin\Divi;

use ET_Builder_Module_Blog;

class Archive_Divi_Builder_Module extends ET_Builder_Module_Blog {

	public $vb_support = 'off';

	public function init() {
		parent::init();
		$this->name   = 'Arhívum évad';
		$this->plural = 'Arhívum évad';
		$this->slug   = 'sell_archive';

	}

	public function get_fields() {
		$fields = parent::get_fields();

		$fields['archive_year'] = array(
			'label'            => 'Évad"',
			'type'             => 'text',
			'option_category'  => 'configuration',
			'description'      => 'Válassz, hogy hanyadik évad arhívjait jelenítse meg az oldalon ez a modul!',
			'computed_affects' => array(
				'__posts',
			),
			'toggle_slug'      => 'main_content',
			'default'          => date( "Y" ),
		);
		unset( $fields['post_type'] );
		unset( $fields['post_offset'] );
		unset( $fields['use_current_loop'] );
		unset( $fields['include_categories'] );
		return $fields;
	}

	public function render( $attrs, $content = null, $render_slug ) {
		global $post, $wp_query, $wp_the_query, $archive_query;
		$this->props['use_current_loop']   = 1; //tricking module to use my fake main query. Haha, it is the suggestion query.
		$this->props['include_categories'] = null; //otherwise PHP error is thrown from parent.
		$year                              = $this->props['archive_year']; //otherwise PHP error is thrown from parent.

		$archive_query  = new \WP_Query( array(
			'post_type' => 'archiv',
			'orderby' => 'date',
			'order'   => 'ASC',
			'tax_query' => array(
				array (
					'taxonomy' => 'evad',
					'field' => 'slug',
					'terms' => $year,
				)
			),
		) );
		$original_query = $wp_the_query;
		$wp_query       = $archive_query;
		$output         = parent::render( $attrs, $content, $render_slug );
		$wp_the_query   = $wp_query = $original_query;

		return $output;
	}

}