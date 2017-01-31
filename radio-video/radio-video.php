<?php

// Prevent direct access to file
  defined( 'ABSPATH' ) or die( 'Cannot access pages directly' );

// Rewrite URLs into a human-friendly format
  add_action( 'init', 'radio_video_init_internal' );
  function radio_video_init_internal() {
    // Interpret urls of the form 'radio/videos/???' as 'index.php?video=???'
		add_rewrite_rule( '^radio/video/([^/]+)/?', 'index.php?radio-video=$matches[1]', 'top' );
    // Interpret urls of the form 'radio/videos' as 'index.php?video=???'
		add_rewrite_rule( '^radio/videos/?', 'index.php?radio-videos', 'top' );
  }

// Let wordpress know about a new URL query var, which can be queried in a page template to display info
  add_filter( 'query_vars', 'radio_video_query_vars' );
  function radio_video_query_vars( $query_vars ) {
    $query_vars[] = 'radio-video';
    $query_vars[] = 'radio-videos';
    return $query_vars;
  }

// Fetch the right template for a given request
add_action( 'parse_request', 'radio_video_parse_request' );
function radio_video_parse_request( &$wp ) {
  if ( array_key_exists( 'radio-video', $wp->query_vars ) ) {
    $yt_id = $wp->query_vars['radio-video'];
    include 'radio-video-single.php';
    exit();
  }
  if ( array_key_exists( 'radio-videos', $wp->query_vars ) ) {
    include 'radio-video-category.php';
    exit();
  }
  return;
}
