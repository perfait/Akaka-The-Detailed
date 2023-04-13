<?php
add_action('wp_enqueue_scripts', 'inbio_child_enqueue_styles', 20);
function inbio_child_enqueue_styles() {
    wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');
    if ( is_rtl() ) {
        wp_enqueue_style( 'parent-rtl', get_template_directory_uri() . '/style-rtl.css');
    }
     wp_enqueue_style('inbio-child-style', get_stylesheet_uri() );

}


// Remove Archive Title Prefix
add_filter( 'get_the_archive_title_prefix', '__return_empty_string' );

