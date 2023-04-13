<?php
// Allow SVG
add_filter( 'wp_check_filetype_and_ext', function($data, $file, $filename, $mimes) {
 
    global $wp_version;
    if ( $wp_version !== '4.7.1' ) {
       return $data;
    }
   
    $filetype = wp_check_filetype( $filename, $mimes );
   
    return [
        'ext'             => $filetype['ext'],
        'type'            => $filetype['type'],
        'proper_filename' => $data['proper_filename']
    ];
   
  }, 10, 4 );


if(! function_exists('rainbow_mime_types')){
    function rainbow_mime_types( $mimes ){
        $mimes['svg'] = 'image/svg+xml';
        return $mimes;
    }
    add_filter( 'upload_mimes', 'rainbow_mime_types' );
}

   
