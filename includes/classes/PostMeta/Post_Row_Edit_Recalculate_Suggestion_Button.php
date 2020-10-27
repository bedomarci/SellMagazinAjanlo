<?php


namespace SellMagazin\PostMeta;


class Post_Row_Edit_Recalculate_Suggestion_Button extends \SellMagazin\Interfaces\Filter_Register {
	protected $hook = 'post_row_actions';

	public function filter($actions) {
		if ( get_current_screen()->post_type != 'post' ) {
			return '';
		}
		global $post;
		$actions['recalculate'] = '<a class="quick-recalculate-suggestion" href="#" title="" data-id="' . $post->ID . '" rel="permalink">Ajánlatok újraszámolása<span></span></a>';

		return $actions;
	}
}