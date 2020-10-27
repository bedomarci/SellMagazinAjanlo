<?php


namespace SellMagazin\PostMeta;


use SellMagazin\Interfaces\Action_Register;

class Post_Suggestion_Custom_Fields_Register extends Action_Register {

	protected $hook = 'acf/init';

	public function run(...$args) {
		acf_add_local_field_group( array(
			'key'                   => 'group_suggestion_fields',
			'title'                 => 'Cikk ajánlás',
			'fields'                => array(
				array(
					'key'               => 'field_validity_period_start',
					'label'             => 'Aktivitás kezdete',
					'name'              => 'validity_period_start',
					'type'              => 'date_picker',
					'instructions'      => 'Ajánlási aktivitás kezdete',
					'required'          => 1,
					'conditional_logic' => 0,
					'wrapper'           => array(
						'width' => '',
						'class' => '',
						'id'    => '',
					),
					'display_format'    => 'Y/m/d',
					'return_format'     => 'Y/m/d',
					'first_day'         => 1,
				),
				array(
					'key'               => 'field_validity_period_end',
					'label'             => 'Aktivitás vége',
					'name'              => 'validity_period_end',
					'type'              => 'date_picker',
					'instructions'      => 'Ajánlási aktivitás vége',
					'required'          => 1,
					'conditional_logic' => 0,
					'wrapper'           => array(
						'width' => '',
						'class' => '',
						'id'    => '',
					),
					'display_format'    => 'Y/m/d',
					'return_format'     => 'Y/m/d',
					'first_day'         => 1,
				),
				array(
					'key'               => 'field_commercial_nature',
					'label'             => 'Kereskedelmi jelleg',
					'name'              => 'commercial_nature',
					'type'              => 'select',
					'instructions'      => '',
					'required'          => 1,
					'conditional_logic' => 0,
					'wrapper'           => array(
						'width' => '',
						'class' => '',
						'id'    => '',
					),
					'choices'           => array(
						'sponsored' => 'Szponzorált',
						'civil'     => 'Közérdekű',
					),
					'default_value'     => 'civil',
					'allow_null'        => 0,
					'multiple'          => 0,
					'ui'                => 0,
					'return_format'     => 'value',
					'ajax'              => 0,
					'placeholder'       => '',
				),
				array(
					'key'               => 'field_highlight',
					'label'             => 'Kiemelés',
					'name'              => 'highlight',
					'type'              => 'true_false',
					'instructions'      => '',
					'required'          => 0,
					'conditional_logic' => 0,
					'wrapper'           => array(
						'width' => '',
						'class' => '',
						'id'    => '',
					),
					'message'           => '',
					'default_value'     => 0,
					'ui'                => 1,
					'ui_on_text'        => 'Igen',
					'ui_off_text'       => 'Nem',
				),
				array(
					'key'               => 'field_suggestion_lookup_tags',
					'label'             => 'Ajánlási cimkék',
					'name'              => 'suggestion_lookup_tags',
					'type'              => 'taxonomy',
					'instructions'      => 'Ehhez a cikkhez ajánlott további cikkek keresőcimkéi',
					'required'          => 1,
					'conditional_logic' => 0,
					'wrapper'           => array(
						'width' => '',
						'class' => '',
						'id'    => '',
					),
					'taxonomy'          => 'ajanlasi_cimke',
					'field_type'        => 'multi_select',
					'allow_null'        => 0,
					'add_term'          => 1,
					'save_terms'        => 0,
					'load_terms'        => 0,
					'return_format'     => 'id',
					'multiple'          => 0,
				),
				array(
					'key'               => 'field_suggestion_tags',
					'label'             => 'Saját cimkék',
					'name'              => 'suggestion_tags',
					'type'              => 'taxonomy',
					'instructions'      => '',
					'required'          => 1,
					'conditional_logic' => 0,
					'wrapper'           => array(
						'width' => '',
						'class' => '',
						'id'    => '',
					),
					'taxonomy'          => 'ajanlasi_cimke',
					'field_type'        => 'multi_select',
					'allow_null'        => 0,
					'add_term'          => 1,
					'save_terms'        => 0,
					'load_terms'        => 0,
					'return_format'     => 'object',
					'multiple'          => 0,
				),
			),
			'location'              => array(
				array(
					array(
						'param'    => 'post_type',
						'operator' => '==',
						'value'    => 'post',
					),
				),
			),
			'menu_order'            => 0,
			'position'              => 'side',
			'style'                 => 'default',
			'label_placement'       => 'top',
			'instruction_placement' => 'label',
			'hide_on_screen'        => array(
				'format',
				'slug',
			),
			'active'                => true,
			'description'           => '',
		) );
	}
}