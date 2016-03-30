<?php
/* 
* Plugin Name: Gluten Free Recipes
* Plugin URI: http://phoenix.sheridanc.on.ca/~ccit3443
* Description: Custom post types for gluten free recipes 
* Author: Hala Ayyad, Alaa Harb, Mohammed Hussein
* Author URI: http://phoenix.sheridanc.on.ca/~ccit3443
* Version: 1.0 
*/


// creating the custom post type 
function glutenfree_register_post_type () {

	
	//changing the labels on the post page
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
    <div class="glutenfree-div">
    	<h2>Try the latest Gluten Free Recipe!</h2>
            <?php while ( $query->have_posts() ) : $query->the_post(); ?>
            <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <a class="glutenfree-listing" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
	</div>
<?php if ( has_post_thumbnail() ) : ?>
	<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
	<img src="<?php the_post_thumbnail_url(); ?>"  width="280";/>
	</a>
	
<?php endif; ?>
	
	<?php endwhile;
            wp_reset_postdata(); ?>

</div>               
    <?php $myvariable = ob_get_clean();
    return $myvariable;
    }
}


//enqueing the stylesheet (this code is from https://wpgurus.net/enqueue-scripts-style-sheets-on-shortcode-pages/)

function prefix_enqueue($posts) {

if ( empty($posts) || is_admin() )
		return $posts;
 
	$found = false;
	foreach ($posts as $post) {
		if ( has_shortcode($post->post_content, 'glutenfreesc') ){
			$found = true;
			break;
		}
	}

 //if any shortcodes are found on the page, enqueue stylesheet mentioned above (in this case, /mystyle.css is what will be enqueued)
	if ($found){
		wp_enqueue_style("prefix-style", plugins_url("/mystyle.css", __FILE__), array(), "1.0", "all");
	}
	return $posts;
}

add_action('the_posts', 'prefix_enqueue' );
?>
