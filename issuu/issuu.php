<?php

// Prevent direct access to file
  defined( 'ABSPATH' ) or die( 'Cannot access pages directly' );

// Rewrite URLs into a human-friendly format
  add_action( 'init', 'issuu_init_internal' );
  function issuu_init_internal() {
    // Interpret urls of the form 'videos/???' as 'index.php?video=???'
		add_rewrite_rule( '^issue/([^/]+)/?', 'index.php?issue=$matches[1]', 'top' );
    // Interpret urls of the form 'videos' as 'index.php?video=???'
		add_rewrite_rule( '^issues/?', 'index.php?issues', 'top' );
  }

// Let wordpress know about a new URL query var, which can be queried in a page template to display info
  add_filter( 'query_vars', 'issuu_query_vars' );
  function issuu_query_vars( $query_vars ) {
    $query_vars[] = 'issue';
    $query_vars[] = 'issues';
    return $query_vars;
  }

// Fetch the right template for a given request
add_action( 'parse_request', 'issuu_parse_request' );
function issuu_parse_request( &$wp ) {
  if ( array_key_exists( 'issue', $wp->query_vars ) ) {
    $issuu_id = $wp->query_vars['issue'];
    include 'issuu-single.php';
    exit();
  }
  if ( array_key_exists( 'issues', $wp->query_vars ) ) {
    include 'issuu-category.php';
    exit();
  }
  return;
}
