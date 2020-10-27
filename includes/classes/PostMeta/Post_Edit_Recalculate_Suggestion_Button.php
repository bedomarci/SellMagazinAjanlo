<?php


namespace SellMagazin\PostMeta;


class Post_Edit_Recalculate_Suggestion_Button extends \SellMagazin\Interfaces\Action_Register {
	protected $hook = 'post_submitbox_misc_actions';

	public function run(...$args) {
		global $post;
		if ( get_current_screen()->post_type != 'post' ) {
			return;
		}
		?>
        <div class="misc-pub-section curtime misc-pub-curtime">
            Ajánlások ideje: <b><?php echo get_post_meta( $post->ID, 'suggestion_last_update', true ) ?></b>
        </div>
        <div style="padding: 10px; text-align: left" id="recalculate-suggestion">
            <span class="spinner"></span>
            <button class=" button" data-id="<?php echo $post->ID ?>">Ajánlat újraszámítás indítása</button>
        </div>
		<?php
	}
}