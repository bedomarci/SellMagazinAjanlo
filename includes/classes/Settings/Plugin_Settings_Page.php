<?php


namespace SellMagazin\Settings;


use SellMagazin\Interfaces\Action_Register;

class Plugin_Settings_Page extends Action_Register {
//	private $suggestion_calculator_settings_options;
	protected $hook = 'admin_menu';

	public function run(...$args) {
		add_options_page(
			'Cikk Ajánló', // page_title
			'Cikk Ajánló', // menu_title
			'manage_options', // capability
			'suggestion-calculator-settings', // menu_slug
			array( $this, 'suggestion_calculator_settings_create_admin_page' ) // function
		);
	}

	public function suggestion_calculator_settings_create_admin_page() {
//		$this->suggestion_calculator_settings_options = get_option( 'suggestion_calculator_settings_option_name' ); ?>

        <div class="wrap">
            <h2>Suggestion Calculator Settings</h2>
            <p></p>
			<?php settings_errors(); ?>

            <form method="post" action="options.php">
				<?php
				settings_fields( 'suggestion_calculator_settings_option_group' );
				do_settings_sections( 'suggestion-calculator-settings-admin' );
				submit_button();
				?>
            </form>
        </div>
		<?php
	}
}