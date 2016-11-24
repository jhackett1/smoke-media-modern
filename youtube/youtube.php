<?php

// Prevent direct access to file
  defined( 'ABSPATH' ) or die( 'Cannot access pages directly' );

// Rewrite URLs into a human-friendly format
  add_action( 'init', 'youtube_init_internal' );
  function youtube_init_internal() {
    // Interpret urls of the form 'videos/???' as 'index.php?video=???'
		add_rewrite_rule( '^video/([^/]+)/?', 'index.php?video=$matches[1]', 'top' );
    // Interpret urls of the form 'videos' as 'index.php?video=???'
		add_rewrite_rule( '^videos/?', 'index.php?videos', 'top' );
  }

// Let wordpress know about a new URL query var, which can be queried in a page template to display info
  add_filter( 'query_vars', 'youtube_query_vars' );
  function youtube_query_vars( $query_vars ) {
    $query_vars[] = 'video';
    $query_vars[] = 'videos';
    return $query_vars;
  }

// Fetch the right template for a given request
add_action( 'parse_request', 'youtube_parse_request' );
function youtube_parse_request( &$wp ) {
  if ( array_key_exists( 'video', $wp->query_vars ) ) {
    $yt_id = $wp->query_vars['video'];
    include 'video-template.php';
    exit();
  }
  if ( array_key_exists( 'videos', $wp->query_vars ) ) {
    include 'video-category-template.php';
    exit();
  }
  return;
}
