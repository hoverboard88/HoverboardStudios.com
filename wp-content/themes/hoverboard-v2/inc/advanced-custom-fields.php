<?php
if(function_exists("register_field_group"))
{
	register_field_group(array (
		'id' => 'acf_attributes',
		'title' => 'Attributes',
		'fields' => array (
			array (
				'key' => 'field_57648d8cee781',
				'label' => 'Color',
				'name' => 'category-icon-color',
				'type' => 'select',
				'instructions' => 'Select color for category icon.',
				'required' => 1,
				'choices' => array (
					'blue' => 'Blue',
					'purple' => 'Purple',
					'red' => 'Red',
					'red-light' => 'Red (light)',
					'teal' => 'Teal',
					'green' => 'Green',
				),
				'default_value' => 'blue',
				'allow_null' => 0,
				'multiple' => 0,
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'ef_taxonomy',
					'operator' => '==',
					'value' => 'category',
					'order_no' => 0,
					'group_no' => 0,
				),
			),
		),
		'options' => array (
			'position' => 'normal',
			'layout' => 'no_box',
			'hide_on_screen' => array (
			),
		),
		'menu_order' => 0,
	));
	register_field_group(array (
		'id' => 'acf_case-study',
		'title' => 'Case Study',
		'fields' => array (
			array (
				'key' => 'field_5764a2fd9a7e2',
				'label' => 'Url',
				'name' => 'study_url',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'none',
				'maxlength' => '',
			),
			array (
				'key' => 'field_5764a3549a7e3',
				'label' => 'Screenshot (Desktop)',
				'name' => 'study_screenshot_desk',
				'type' => 'image',
				'required' => 1,
				'save_format' => 'object',
				'preview_size' => 'medium',
				'library' => 'all',
			),
			array (
				'key' => 'field_5764a3809a7e4',
				'label' => 'Screenshot (Mobile)',
				'name' => 'study_screenshot_mobile',
				'type' => 'image',
				'save_format' => 'object',
				'preview_size' => 'thumbnail',
				'library' => 'all',
			),
			array (
				'key' => 'field_5764a3bf9a7e5',
				'label' => 'Conclusion',
				'name' => 'study_conclusion',
				'type' => 'wysiwyg',
				'instructions' => 'One paragraph',
				'required' => 1,
				'default_value' => '',
				'toolbar' => 'basic',
				'media_upload' => 'no',
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'studies',
					'order_no' => 0,
					'group_no' => 0,
				),
			),
		),
		'options' => array (
			'position' => 'normal',
			'layout' => 'no_box',
			'hide_on_screen' => array (
			),
		),
		'menu_order' => 0,
	));
	register_field_group(array (
		'id' => 'acf_social',
		'title' => 'Social',
		'fields' => array (
			array (
				'key' => 'field_5764962e874dc',
				'label' => 'LinkedIn',
				'name' => 'social_linkedin',
				'type' => 'text',
				'instructions' => 'Username',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'ef_user',
					'operator' => '==',
					'value' => 'all',
					'order_no' => 0,
					'group_no' => 0,
				),
			),
		),
		'options' => array (
			'position' => 'normal',
			'layout' => 'no_box',
			'hide_on_screen' => array (
			),
		),
		'menu_order' => 0,
	));
}
