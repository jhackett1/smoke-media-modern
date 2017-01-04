<?php
	//Prevents direct access to file
	defined( 'ABSPATH' ) or die( 'No direct access allowed!' );

	// Include the editor page file
		require_once( __DIR__ . '/now-next.php');

	add_action( 'init', 'marconi_init_internal' );
  // Rewrite URLS
	function marconi_init_internal() {
		add_rewrite_rule( 'shows/([a-zA-Z]{3})/([0-9]+)/?$', 'index.php?marconi_programme=$matches[1]&marconi_episode=$matches[2]', 'top' );
		add_rewrite_rule( 'shows/([a-zA-Z]{3})/?$', 'index.php?marconi_programme=$matches[1]', 'top' );
	}

  // Add query vars for episodes and shows
	add_filter( 'query_vars', 'marconi_query_vars' );
	function marconi_query_vars( $query_vars ) {

		$query_vars[] = 'marconi_episode';
		$query_vars[] = 'marconi_programme';
		return $query_vars;

	}

  // Get template files for shows and epsiodes
	add_action( 'parse_request', 'marconi_parse_request' );
	function marconi_parse_request( &$wp ) {
		if ( array_key_exists( 'marconi_episode', $wp->query_vars ) ) {

			$pcode = strtoupper($wp->query_vars['marconi_programme']);
			$prod_number = strtoupper($wp->query_vars['marconi_episode']);
			include 'show-episode-template.php';
			exit();

		} else if ( array_key_exists( 'marconi_programme', $wp->query_vars ) ) {

			$pcode = strtoupper($wp->query_vars['marconi_programme']);
			include 'show-template.php';
			exit();

		}
		return;
	}
