<?php
/* =================================================================

	Global Settings

 ================================================================= */

/* Misc Settings
=================================== */

/* WordPress by default, creates attachment pages for all media attached
to posts. They tend to be pointless, and no one one knows why they exist.
(That's a FACT.) Often, attachment pages are neglected and unstyled, and
look ugly. These pages will now be turned off by default. To turn them
back on, for whatever dumb reason, change this value to false. */
define("KILL_ATTACHMENT_PAGE", true); //(true/false)




/* =================================================================

	Theme Supports

================================================================= */

add_theme_support('post-thumbnails');
add_theme_support( 'title-tag' );
add_theme_support( 'html5', array( 'gallery', 'caption' ) );



/* =================================================================

	Required Files

	It's best to avoid editing these files directly! If you need
	to adjust something, do it in this functions.php file.

================================================================= */

/* Functions that require no configuration and are worth being in every WordPress theme. Also includes Mobile_Detect */
require_once('inc/core.php');

// Custom Posts Setup
// require_once( 'inc/customposts.php' );

// Custom Taxonomy Setup
// require_once( 'inc/customtax.php' );

// Custom Gutenberg Script
// require_once( 'inc/gutenberg.php' );

// Gravity forms specific functions
// if (class_exists('GFForms'))
// 	require_once( 'inc/gravity.php' );



/* ==========================================================================

	Htpasswd Settings

========================================================================= */

// define('HTA_USER', 'replace');
// define('HTA_PWD', 'replace');



/* ==========================================================================

	Mobile & Tablet Detection

========================================================================= */

if (!class_exists('Mobile_Detect')) {
	require_once( get_template_directory() . '/inc/Mobile_Detect.php' );
}
global $deviceType;
$detect = new Mobile_Detect;

$deviceType = ($detect->isMobile() ? ($detect->isTablet() ? 'tablet' : 'phone') : 'computer');




/* ==========================================================================

	Admin Simplification.

========================================================================== */

add_action( 'admin_menu', function() {
	remove_meta_box( 'commentsdiv', array('page', 'post'), 'normal' ); 		// Comments meta box
	remove_meta_box( 'authordiv', array('page', 'post'), 'normal' ); 			// Author meta box
	remove_meta_box( 'tagsdiv-post_tag', array('page', 'post'), 'side' ); 		// Post tags meta box
	// remove_meta_box( 'categorydiv', array('page', 'post'), 'side' ); 		// Category meta box
	// remove_meta_box( 'postexcerpt', array('page', 'post'), 'normal' ); 		// Excerpt meta box
	remove_meta_box( 'trackbacksdiv', array('page', 'post'), 'normal' ); 		// Trackbacks meta box
	// remove_meta_box( 'postcustom', array('page', 'post'), 'normal' ); 		// Custom fields meta box
	remove_meta_box( 'commentstatusdiv', array('page', 'post'), 'normal' ); 	// Comment status meta box
	// remove_meta_box( 'postimagediv', array('page', 'post'), 'side' ); 		// Featured image meta box
	// remove_meta_box( 'pageparentdiv', array('page', 'post'), 'side' ); 		// Page attributes meta box
	// remove_menu_page('index.php'); 							// Dashboard
	// remove_menu_page('edit.php'); 							// Posts
	// remove_menu_page('upload.php');							// Media
	remove_menu_page('link-manager.php'); 						// Links
	// remove_menu_page('edit.php?post_type=page'); 			// Pages
	remove_menu_page('edit-comments.php'); 						// Comments
	// remove_menu_page('themes.php'); 							// Appearance
	// remove_menu_page('plugins.php'); 						// Plugins
	// remove_menu_page('users.php'); 							// Users
	// remove_menu_page('tools.php'); 							// Tools
	// remove_menu_page('options-general.php'); 				// Settings
});




/* =================================================================

	Menus & Image Size

	JB-Core-Theme adds a 'primary' & 'footer' navigation by default.
	Specify any additional navigation menus and image sizes you
	may need for this build here.

================================================================= */
add_filter( 'intermediate_image_sizes_advanced', 'jb_remove_default_image_sizes' );

function jb_remove_default_image_sizes( $sizes ) {
	// unset( $sizes['thumbnail']); // 150px
	unset( $sizes['medium']); // 300px
	unset( $sizes['medium_large']); // 768px
	unset( $sizes['large']); // 1024px
	return $sizes;
}

add_action( 'after_setup_theme', function(){
	register_nav_menus(array('primary' => 'Primary Navigation'));
	register_nav_menus(array('footer' => 'Footer Navigation'));
}, 15 );



/* =================================================================

	Scripts & Styles

	Make adjustments / additions as necessary. If you are using
	Google Fonts, add them in here in the 'google-fonts' section.

================================================================= */

add_action( 'wp_enqueue_scripts', function() {

	/* filetime() portion is important! It will automatically flush out the old css or js file when you make a new change to said file! */

	/* All Public Pages
	------------------------ */

	wp_enqueue_style('google-fonts', 'https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap', array(), false, 'all');

	wp_enqueue_style('theme-css', get_stylesheet_directory_uri() . '/css/theme.css', array(), filemtime( get_stylesheet_directory() . '/css/theme.css'), 'all');

	wp_enqueue_style('style', get_stylesheet_directory_uri() . '/style.css', array('theme-css'), filemtime( get_stylesheet_directory() . '/style.css'), 'all');

});

// Redirects
function redirect_logged_in_users() {
    if (is_page('login') || is_page('register')) {
        if (is_user_logged_in()) {
            wp_safe_redirect(home_url());
            exit;
        }
    }
}
add_action('template_redirect', 'redirect_logged_in_users');

function redirect_logged_out_users() {
    if (!is_page('login') && !is_page('register')){
        if (!is_user_logged_in()) {
			wp_safe_redirect(home_url('/login'));
			exit;
		}
    }
}
add_action('template_redirect', 'redirect_logged_out_users');