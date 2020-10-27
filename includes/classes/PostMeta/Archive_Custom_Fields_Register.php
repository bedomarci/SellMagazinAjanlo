<?php


namespace SellMagazin\PostMeta;


use SellMagazin\Interfaces\Action_Register;

class Archive_Custom_Fields_Register extends Action_Register {

	protected $hook = 'acf/init';

	public function run(...$args) {
		acf_add_local_field_group( array(
			'key'                   => 'group_archive_fields',
			'title'                 => 'Archívum mezői',
			'fields'                => array(
				array(
					'key'               => 'field_link_pdf',
					'label'             => 'PDF Link',
					'name'              => 'link_pdf',
					'type'              => 'url',
					'instructions'      => '',
					'required'          => 0,
					'conditional_logic' => 0,
					'wrapper'           => array(
						'width' => '',
						'class' => '',
						'id'    => '',
					),
					'default_value'     => '',
					'placeholder'       => '',
				),
				array(
					'key'               => 'field_link_flip',
					'label'             => 'Lapozó link',
					'name'              => 'link_flip',
					'type'              => 'url',
					'instructions'      => '',
					'required'          => 0,
					'conditional_logic' => 0,
					'wrapper'           => array(
						'width' => '',
						'class' => '',
						'id'    => '',
					),
					'default_value'     => '',
					'placeholder'       => '',
				),
				array(
					'key'               => 'field_preview_1',
					'label'             => 'Látvány 1',
					'name'              => 'preview_1',
					'type'              => 'image',
					'instructions'      => '',
					'required'          => 0,
					'conditional_logic' => 0,
					'wrapper'           => array(
						'width' => '',
						'class' => '',
						'id'    => '',
					),
					'return_format'     => 'url',
					'preview_size'      => 'medium',
					'library'           => 'all',
					'min_width'         => '',
					'min_height'        => '',
					'min_size'          => '',
					'max_width'         => '',
					'max_height'        => '',
					'max_size'          => '',
					'mime_types'        => '',
				),
				array(
					'key'               => 'field_preview_2',
					'label'             => 'Látvány 2',
					'name'              => 'preview_2',
					'type'              => 'image',
					'instructions'      => '',
					'required'          => 0,
					'conditional_logic' => 0,
					'wrapper'           => array(
						'width' => '',
						'class' => '',
						'id'    => '',
					),
					'return_format'     => 'url',
					'preview_size'      => 'medium',
					'library'           => 'all',
					'min_width'         => '',
					'min_height'        => '',
					'min_size'          => '',
					'max_width'         => '',
					'max_height'        => '',
					'max_size'          => '',
					'mime_types'        => '',
				),
			),
			'location'              => array(
				array(
					array(
						'param'    => 'post_type',
						'operator' => '==',
						'value'    => 'archiv',
					),
				),
			),
			'menu_order'            => 0,
			'position'              => 'normal',
			'style'                 => 'default',
			'label_placement'       => 'top',
			'instruction_placement' => 'label',
			'hide_on_screen'        => array(
				0 => 'discussion',
				1 => 'comments',
				2 => 'author',
				3 => 'tags',
			),
			'active'                => true,
			'description'           => '',
		) );

	}
}