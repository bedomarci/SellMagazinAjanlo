<?php


namespace SellMagazin\Settings;


use SellMagazin\Interfaces\Action_Register;

class Plugin_Settings_Init extends Action_Register {
	private $suggestion_calculator_settings_options;

	protected $hook = 'admin_init';

	public function __construct() {
		$this->suggestion_calculator_settings_options = get_option( 'suggestion_calculator_settings_option_name' );
	}

	public function run(...$args) {
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
			$sanitary_values['number_of_suggestion_calculation'] = (int) ( $input['number_of_suggestion_calculation'] );
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