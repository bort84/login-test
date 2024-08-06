<?php

/* Simple function (that should be built into WordPress!) that greatly simplifies the creation of custom taxonomies.
 * 
 * @param  string			$post_type						(REQUIRED)  The slug of the new Post type.
 * @param  string 		$post_name 						(REQUIRED)  Plural name of Post (e.g., Books)
 * @param  string 		$post_singular_name 	(Optional) 	Singular name of Taxonomy. Defaults to $tax_name. (e.g., Book)
 * @param  boolean 		$is_public 						(Optional) 	Set whether users will be able to see the post
 * @param  array 			$extras 							(Optional) 	Additional settings to overwrite defaults
 * 
 * @return void
 */

function jb_custom_posts($post_type, $post_name, $post_singular_name, $is_public=false, $extras=[]) {
	$labels = array(
		'name'                  => $post_name,
		'singular_name'         => $post_singular_name,
		'menu_name'             => $post_name, 'Admin Menu text',
		'name_admin_bar'        => $post_singular_name,
		'add_new'               => 'Add New '.$post_singular_name,
		'add_new_item'          => 'Add New '.$post_singular_name,
		'new_item'              => 'New '.$post_singular_name,
		'edit_item'             => 'Edit '.$post_singular_name,
		'view_item'             => 'View '.$post_singular_name,
		'all_items'             => 'All '.$post_name,
		'search_items'          => 'Search '.$post_name,
		'parent_item_colon'     => 'Parent '.$post_name.':',
		'not_found'             => 'No '.$post_name.' found.',
		'not_found_in_trash'    => 'No '.$post_name.' found in Trash.',
	);

	$args = array(
		'labels'             => $labels,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'show_in_rest' 		 => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => $post_type ),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => null,
		'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' ),
	);

	$args = array_merge($args, $extras);

	if(!$is_public) {
		$args = array_merge($args, array(
			'public' 				=> false,
			'has_archive' 	=> false,
			'rewrite' 			=> false
		));
	}

	register_post_type( $post_type, $args );
}