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
		'id' => 'acf_social',
		'title' => 'Social',
		'fields' => array (
			array (
				'key' => 'field_576493dff9214',
				'label' => 'GitHub',
				'name' => 'social_github',
				'type' => 'text',
				'instructions' => 'GitHub Username',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
			array (
				'key' => 'field_5764961c874db',
				'label' => 'Twitter',
				'name' => 'social_twitter',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
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
