<?php
/* 
* Plugin Name: Recipes
* Plugin URI: http://phoenix.sheridanc.on.ca/~ccit3443
* Description: Creating and inserting new recipes reviews
* Author: Hala Ayyad, Alaa Harb, Mohammed Hussein
* Author URI: http://phoenix.sheridanc.on.ca/~ccit3443
* Version: 1.0 
*/

function glutenfree_register_post_type () {

	$labels = array(
		'name' => 'Gluten Free Recipes',
		'singular' => 'Gluten Free',
		'add_new' => 'Add New Post',
		'all_items' => 'All Posts',
		'add_new_item' => 'Add New Posts',
		'edit_item' => 'Edit Post',
		'view_item' => 'View Post',
		'search_item' => 'Search Posts',

		);

	$args= array( 
		'public' => true, 
		'labels' => $labels,
		'has_archive' => true,
		'capability_type' => 'post',
		'hierarchical' => true,
		'rewrite' => array ( 
			'slug' => 'glutenfree',
			'with_front' => FALSE
			),

		'supports' => array(
			'title',
			'editor',
			'excerpt',
			'thumbnail',
			'taxonomy',

		),

		'taxonomies' => array ('category', 'post_tag'),
		'exclude_from_search' => false


	);

	register_post_type('glutenfree', $args);

}
add_action ('init', 'glutenfree_register_post_type');
