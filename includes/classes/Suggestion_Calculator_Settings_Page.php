<?php


namespace SellMagazin;


class Suggestion_Calculator_Settings_Page {
	private $suggestion_calculator_settings_options;

	public function __construct() {
		add_action( 'admin_menu', array( $this, 'suggestion_calculator_settings_add_plugin_page' ) );
		add_action( 'admin_init', array( $this, 'suggestion_calculator_settings_page_init' ) );
	}

	public function suggestion_calculator_settings_add_plugin_page() {
		add_options_page(
			'Cikk Ajánló', // page_title
			'Cikk Ajánló', // menu_title
			'manage_options', // capability
			'suggestion-calculator-settings', // menu_slug
			array( $this, 'suggestion_calculator_settings_create_admin_page' ) // function
		);
	}

	public function suggestion_calculator_settings_create_admin_page() {
		$this->suggestion_calculator_settings_options = get_option( 'suggestion_calculator_settings_option_name' ); ?>

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
	<?php }

	public function suggestion_calculator_settings_page_init() {
		register_setting(
			'suggestion_calculator_settings_option_group', // option_group
			'suggestion_calculator_settings_option_name', // option_name
			array( $this, 'suggestion_calculator_settings_sanitize' ) // sanitize_callback
		);

		add_settings_section(
			'suggestion_calculator_settings_setting_section', // id
			'Ajánlások számítása', // title
			array( $this, 'suggestion_calculator_settings_section_info' ), // callback
			'suggestion-calculator-settings-admin' // page
		);

		add_settings_field(
			'number_of_suggestion_calculation', // id
			'Cikkenként számolt ajánkások száma', // title
			array( $this, 'number_of_suggestion_calculation_callback' ), // callback
			'suggestion-calculator-settings-admin', // page
			'suggestion_calculator_settings_setting_section' // section
		);
	}

	public function suggestion_calculator_settings_sanitize( $input ) {
		$sanitary_values = array();
		if ( isset( $input['number_of_suggestion_calculation'] ) ) {
			$sanitary_values['number_of_suggestion_calculation'] = (int)( $input['number_of_suggestion_calculation'] );
		}

		return $sanitary_values;
	}

	public function suggestion_calculator_settings_section_info() {

	}

	public function number_of_suggestion_calculation_callback() {
		printf(
			'<input class="regular-text" type="number" name="suggestion_calculator_settings_option_name[number_of_suggestion_calculation]" id="number_of_suggestion_calculation" value="%s">',
			isset( $this->suggestion_calculator_settings_options['number_of_suggestion_calculation'] ) ? esc_attr( $this->suggestion_calculator_settings_options['number_of_suggestion_calculation'] ) : ''
		);
	}

}