<?php
/* 
* Plugin Name: Gluten Free Recipes
* Plugin URI: http://phoenix.sheridanc.on.ca/~ccit3443
* Description: Custom post types for gluten free recipes 
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
			

		),

		
		'exclude_from_search' => false


	);
// Registers a custom taxonomy (categories) for the gluten free custom post
	register_taxonomy("glutenfree", array("glutenfree"), array("hierarchical" => true, "label" => "Categories of Gluten Free", "singular_label" => "typesofglutenfree", "rewrite" => true));
	register_post_type('glutenfree', $args);

}
add_action ('init', 'glutenfree_register_post_type');


//shortcode for displaying gluten free posts
//code was found on (http://code.tutsplus.com/tutorials/create-a-shortcode-to-list-posts-with-multiple-parameters--wp-32199) 
//it was CHANGED to suit our needs.  
add_shortcode( 'glutenfreesc', 'glutenfreesc' );
function glutenfreesc( $atts ) {
    ob_start();
    $query = new WP_Query( array(
        'post_type' => 'glutenfree',
        'order' => 'ASC',
        'posts_per_page' => 3,
        'orderby' => 'date',
    ) );
    if ( $query->have_posts() ) { ?>
    <h2>Try the latest Gluten Free Recipe!</h2>
        <ul class="clothes-listing">
            <?php while ( $query->have_posts() ) : $query->the_post(); ?>
            <li id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>

            </li>
            <?php endwhile;
            wp_reset_postdata(); ?>
        </ul>
    <?php $myvariable = ob_get_clean();
    return $myvariable;
    }
}