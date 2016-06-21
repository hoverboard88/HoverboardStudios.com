<?php
function hb_v2_cpts() {

	$labels = array(
    'name' => _x( 'Categories', 'taxonomy general name' ),
    'singular_name' => _x( 'Category', 'taxonomy singular name' ),
    'search_items' =>  __( 'Search Categories' ),
    'all_items' => __( 'All Categories' ),
    'parent_item' => __( 'Parent Category' ),
    'parent_item_colon' => __( 'Parent Category:' ),
    'edit_item' => __( 'Edit Category' ),
    'update_item' => __( 'Update Category' ),
    'add_new_item' => __( 'Add New Category' ),
    'new_item_name' => __( 'New Category Name' ),
    'menu_name' => __( 'Categories' ),
  );

	// create a new taxonomy
	register_taxonomy(
		'tech_category',
		'studies',
		array(
			'label' => __( 'Category' ),
			'rewrite' => array( 'slug' => 'project-category' ),
			'hierarchical' => true,
			'labels' => $labels,
		)
	);


	register_post_type( 'studies',
	// CPT Options
		array(
			'labels' => array(
				'name' => __( 'Case Studies' ),
				'singular_name' => __( 'Case Study' )
			),
			'supports' => array( 'excerpt', 'editor', 'title' ),
			'taxonomies' => array( 'tech_category' ),

			'public' => true,
			'has_archive' => true,
			'rewrite' => array('slug' => 'studies'),
		)
	);

}
add_action( 'init', 'hb_v2_cpts' );
