<?php
/**
*
* This file serves as a place to put awesome filters and functions that are of a "Set it and forget it"
* nature. That is, functions that once placed in here, will not need to be actively called or reference
* or thought about again.
*
* So if it's a function that you'll basically never need to reference again, but always want it to be
* running, than plop it in here!
*
* Also includes Mobile_Detect
*
*/



/* ===================================
    Initial Theme Setup
   =================================== */

add_action( 'after_setup_theme', 'jb_defaults', 11 );

function jb_defaults() {

    // remove junk from head
    // remove_action('wp_head', 'rsd_link');
    remove_action('wp_head', 'wp_generator');
    // remove_action('wp_head', 'feed_links', 2);
    // remove_action('wp_head', 'index_rel_link');
    remove_action('wp_head', 'wlwmanifest_link');
    // remove_action('wp_head', 'feed_links_extra', 3);
    // remove_action('wp_head', 'start_post_rel_link', 10, 0);
    // remove_action('wp_head', 'parent_post_rel_link', 10, 0);
    // remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0);
    // remove_action('wp_head', 'feed_links_extra', 3);
    // remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
    remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);

    // Remove Admin Bar
    add_filter( 'show_admin_bar', '__return_false' );

    add_filter('use_default_gallery_style', '__return_null');
}



/* ===================================
    Bypass to switch views
   =================================== */

function get_browser_mobile_classes() {
    $detect = new Mobile_Detect;

    global $deviceType;
    $browser = '';

    /* Super simple browser detection, add to body class */
    if(isset($_SERVER['HTTP_USER_AGENT'])){
        $agent = $_SERVER['HTTP_USER_AGENT'];
    }

    $os = '';
    if( $detect->isiOS() )
        $os = 'ios ';
    else if( $detect->isAndroidOS() )
        $os = 'android ';

    if(strlen(strstr($agent,"Chrome")) > 0 ){
        $browser = 'chrome ';
    }
    else if(strlen(strstr($agent,"Safari")) > 0 ){
        $browser = 'safari ';
    }

    return $os.$browser.$deviceType;
}



// Creating a custom hook for right after the open body tag
function jb_body_begin() {
    do_action('jb_body_begin');
}


/* Allow filtering by PDF in media manager
http://wp.tutsplus.com/articles/tips-articles/quick-tip-add-extra-media-type-filters-to-the-wordpress-media-manager/ */
add_filter( 'post_mime_types', 'modify_post_mime_types' );
function modify_post_mime_types( $post_mime_types ) {

    // select the mime type, here: 'application/pdf'
    // then we define an array with the label values
    $post_mime_types['application/pdf'] = array( __( 'PDFs' ), __( 'Manage PDFs' ), _n_noop( 'PDF <span class="count">(%s)</span>', 'PDFs <span class="count">(%s)</span>' ) );

    // then we return the $post_mime_types variable
    return $post_mime_types;
}



/* http://wordpress.stackexchange.com/questions/188635/view-wordpress-page-template-usage-or-unused
Adds a count (1) next the template dropdown, to easily see which templates are being used already
and which are not. */
add_filter( 'theme_page_templates', function( $page_templates, $obj, $post ) {
    // // Only use on local dev builds.
    // if (!DEV)
    //     return $page_templates;

    // Restrict to the post.php loading
    if( ! did_action( 'load-post.php' ) )
        return $page_templates;

    foreach( (array) $page_templates as $key => $template )
    {
        $posts = get_posts(
            array(
                'post_type'      => 'any',
                'post_status'    => 'any',
                'posts_per_page' => 10,
                'fields'         => 'ids',
                'meta_query'     => array(
                    array(
                        'key'       => '_wp_page_template',
                        'value'     => $key,
                        'compare'   => '=',
                    )
                )
            )
        );

        $count = count( $posts );

        // Add the count to the template name in the dropdown. Use 10+ for >= 10
        $page_templates[$key] = sprintf(
            '%s (%s)',
            $template,
             $count >= 10 ? '10+' : $count
        );
    }
    return $page_templates;
}, 10, 3 );



/* http://wpsites.net/wordpress-tips/5-ways-to-redirect-attachment-pages-to-the-parent-post-url/ */
if (KILL_ATTACHMENT_PAGE)
    add_action( 'template_redirect', 'jb_attachment_redirect' );
    function jb_attachment_redirect() {
        global $post;

        if ( is_attachment() && isset($post->post_parent) && is_numeric($post->post_parent) && ($post->post_parent != 0) ) :
            // If attached, redirect to the post it's attached to
            wp_redirect( get_permalink( $post->post_parent ), 301 );
            exit();
            wp_reset_postdata();
        elseif ( is_attachment() & is_single() ) :
            // If not attached, redirect to the home
            wp_redirect( '/', 301 );
        endif;
    }





/*
Add Featured Thumbnails to Admin Post Columns
http://wpsnipp.com/index.php/functions-php/add-featured-thumbnail-to-admin-post-columns
*/
add_filter('manage_posts_columns', 'jb_posts_columns', 5);
add_action('manage_posts_custom_column', 'jb_posts_custom_columns', 5, 2);
function jb_posts_columns($defaults){
    $defaults['riv_post_thumbs'] = __('Thumbs');
    return $defaults;
}
function jb_posts_custom_columns($column_name, $id){
        if($column_name === 'riv_post_thumbs'){
        echo the_post_thumbnail( 'thumbnail' );
    }
}

// Edit dns prefetch for old Google Font call
add_filter( 'wp_resource_hints', function( $urls ) {
    foreach ($urls as $key => $url) {
		// Remove existing prefect for google fonts
		if( 'fonts.googleapis.com' === $url ) { unset( $urls[ $key ] ); }
    }
    return $urls;
} );

// Add new preconnect code for Google Fonts
function jb_gfont_preconnect ($urls, $relation_type) {
	if ( 'preconnect' === $relation_type) {
		$urls[] = 'https://fonts.gstatic.com';
	}
	return $urls;
}
add_filter ( 'wp_resource_hints', 'jb_gfont_preconnect', 10, 2);