<?php

/* Simple function (that should be built into WordPress!) that greatly simplifies the creation of custom taxonomies.
 * 
 * @param  string 		$tax  				(REQUIRED)  The slug of the new Taxonomy type.
 * @param  array/string  $posttypes 		(REQUIRED)  An array of post types to attach the Taxonomy to. 
 *											Also accepts one posttype as a string. 
 * @param  string 		$tax_name 			(REQUIRED)  Plural name of Taxonomy (e.g., Companies)
 * @param  string 		$tax_singular_name 	(Optional) 	Singular name of Taxonomy. Defaults to $tax_name. (e.g., Company)
 * @param  boolean 		$hierarchical 		(Optional) 	Should it have heiracthy like a Category (true), 
 *											or not like a Tag (false). Defaults to True. 	
 * @param  string 		$text_domain 		(Optional) 	Theme domain
 * @return void
 */

function jb_custom_taxonomy($tax, $posttypes, $tax_name, $tax_singular_name, $hierarchical=true, $text_domain='jb-theme') {

	// Add new taxonomy, make it hierarchical (like categories)
	$labels = array(
		'name'              => $tax_name,
		'singular_name'     => $tax_singular_name,
		'search_items'      => 'Search '.$tax_name,
		'all_items'         => 'All '.$tax_name,
		'parent_item'       => 'Parent '.$tax_singular_name,
		'parent_item_colon' => 'Parent '.$tax_singular_name.':',
		'edit_item'         => 'Edit '.$tax_singular_name,
		'update_item'       => 'Update '.$tax_singular_name,
		'add_new_item'      => 'Add New '.$tax_singular_name,
		'new_item_name'     => 'New '.$tax_singular_name.' Name',
		'menu_name'         => $tax_singular_name,
	);

	$args = array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_in_rest' 		=> true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => $tax ),
	);

	register_taxonomy( $tax, $posttypes, $args );

}