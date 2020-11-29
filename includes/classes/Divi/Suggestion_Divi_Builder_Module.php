<?php


namespace SellMagazin\Divi;

use ET_Builder_Module_Blog;

class Suggestion_Divi_Builder_Module extends ET_Builder_Module_Blog {

	public $vb_support = 'off';
	protected $highlighted_post_id = - 1;

	public function init() {
		parent::init();
		$this->name   = 'Cikk ajánló';
		$this->plural = 'Cikk ajánlók';
		$this->slug   = 'sell_post_suggestion';

		$this->highlighted_post_id = get_option( 'highlighted_post_id', - 1 );

		add_filter( 'post_class', array( $this, 'add_highlighted_class' ), 10, 5 );
	}

	function add_highlighted_class( $classes, $class, $post_id ) {
		if ( $this->highlighted_post_id == $post_id ) {
			$classes[] = 'highlighted-post';
		}

		return $classes;
	}

	public function get_fields() {
		$fields = parent::get_fields();


//		$fields['suggestion_index'] = array(
//			'label'            => 'Ajánló sorszáma',
//			'type'             => 'text',
//			'option_category'  => 'configuration',
//			'description'      => 'Válassz, hogy hanyadik ajánlást jelenítse meg az oldalon ez a modul!',
//			'computed_affects' => array(
//				'__posts',
//			),
//			'toggle_slug'      => 'main_content',
//			'default'          => 1,
//		);
		unset( $fields['post_type'] );
		unset( $fields['use_current_loop'] );
		unset( $fields['include_categories'] );


		return $fields;
	}

	public function render( $attrs, $content = null, $render_slug ) {
		global $post, $wp_query, $wp_the_query, $suggestion_query;
		$this->props['use_current_loop']   = 1; //tricking module to use my fake main query. Haha, it is the suggestion query.
		$this->props['include_categories'] = null; //otherwise PHP error is thrown from parent.
		$suggestion_ids                    = get_post_meta( $post->ID, 'suggestions', true ); //Here we go.

		if ( is_null( $suggestion_query ) ) {//Run the query only once if multiple module is used on the page.
			$suggestion_query = new \WP_Query( array(
				'post_type' => 'post',
				'post__in'  => $suggestion_ids,
				'orderby'   => 'post__in'
			) );
		}

//		echo var_dump($suggestion_ids);
//		echo var_dump(wp_list_pluck($suggestion_query->get_posts(), 'ID'));
//		die();
		$original_query = $wp_the_query;
		$wp_query       = $suggestion_query;
		$output         = parent::render( $attrs, $content, $render_slug );
		$wp_the_query   = $wp_query = $original_query;

//		wp_reset_postdata();

		return $output;
	}

}