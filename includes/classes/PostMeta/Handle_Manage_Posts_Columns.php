<?php


namespace SellMagazin\PostMeta;


class Handle_Manage_Posts_Columns extends \SellMagazin\Interfaces\Action_Register {
	protected $hook = 'manage_post_posts_custom_column';
	protected $accepted_args = 2;

	public function run( ...$args ) {
		$column_name = $args[0];
		$post_id     = $args[1];

		$terms = get_terms( array(
			'taxonomy' => 'ajanlasi_cimke',
			'hide_empty' => false,
			'object_ids' => [],
		) );

		if ( $column_name == 'suggestion_tags' || $column_name == 'suggestion_lookup_tags' ) {
			$tags = get_post_meta( $post_id, $column_name, true );
			if (!is_array($tags)) return;
//			$tag_terms = [];
			$terms = get_terms( array(
				'taxonomy' => 'ajanlasi_cimke',
				'hide_empty' => false,
				'term_taxonomy_id' => $tags,
				'fields'=> 'id=>name',
			) );
//			foreach ($tags as $tag)
//				$tag_terms[]= get_field('ajanlasi_cimke_'.$tag);


			echo implode(', ', $terms);
//			echo print_r(gettype($tags), true);
//			echo print_r(($terms), true);
		}
	}


}


