<?php
// Remove Gutenberg Block Library CSS from loading on the frontend
function jb_remove_wp_block_library_css(){
    wp_dequeue_style( 'wp-block-library' );
    wp_dequeue_style( 'wp-block-library-theme' );
} 
add_action( 'wp_enqueue_scripts', 'jb_remove_wp_block_library_css', 100 );