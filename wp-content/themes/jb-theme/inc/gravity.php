<?php
/**
 * Library of functions useful for WordPress builds,
 * that rely on or are directly related to the 
 * Gravity Forms plugin.
 *
 * This file should only include generic, functions
 * that are not tied to a particular build.
 */

/* =================================================================
	Gravity Forms 

		- Add "Add form" to ACF options page
        - Ajax Spinner: https://thomasgriffin.io/change-default-gravity-forms-ajax-spinner/
        - Change submit input to button

 ================================================================= */

/* Gravity Form 'Add Form' button to appear on ACF 'Options' page Editor */ 
add_filter( 'gform_display_add_form_button', function($is_post_edit_page) {
	if ( isset( $_GET['page'] ) && $_GET['page'] == 'theme-general-settings' ) {
        return true;
    }

    return $is_post_edit_page;
});

/* Ajax Spinner */ 
add_filter( 'gform_ajax_spinner_url', function() {
	return 'data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7'; 
});

/* Change Submit input field to a button */
add_filter( 'gform_submit_button', 'form_submit_button', 10, 2 );
function form_submit_button( $button, $form ) {
    return "<button id='gform_submit_button_{$form['id']}'><span>{$form['button']['text']}</span></button>";
}