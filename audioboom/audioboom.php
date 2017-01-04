<?php

// Prevent direct access to file
  defined( 'ABSPATH' ) or die( 'Cannot access pages directly' );

  // Rewrite URLs into a human-friendly format
    add_action( 'init', 'audioboom_init_internal' );
    function audioboom_init_internal() {
      // Interpret urls of the form 'videos/???' as 'index.php?video=???'
  		add_rewrite_rule( '^audio/([^/]+)/?', 'index.php?audio=$matches[1]', 'top' );
      // Interpret urls of the form 'videos' as 'index.php?video=???'
  		add_rewrite_rule( '^audios/?', 'index.php?audios', 'top' );
    }

  // Let wordpress know about a new URL query var, which can be queried in a page template to display info
    add_filter( 'query_vars', 'audioboom_query_vars' );
    function audioboom_query_vars( $query_vars ) {
      $query_vars[] = 'audio';
      $query_vars[] = 'audios';
      return $query_vars;
    }

  // Fetch the right template for a given request
  add_action( 'parse_request', 'audioboom_parse_request' );
  function audioboom_parse_request( &$wp ) {
    if ( array_key_exists( 'audio', $wp->query_vars ) ) {
      $audio_id = $wp->query_vars['audio'];
      include 'audioboom-single.php';
      exit();
    }
    if ( array_key_exists( 'audios', $wp->query_vars ) ) {
      include 'audioboom-category.php';
      exit();
    }
    return;
  }


  // Function to set up share buttons
  	function smoke_audioboom_share_buttons($wp, $audio_title){
  		// Prepare the permalink and post title for inclusion in share intent URLs
      $audio_permalink = get_site_url() . "/audio/" . $wp->query_vars['audio'];
  		$postURL = urlencode( $audio_permalink );
  		$postTitle = str_replace( ' ', '%20', $audio_title );
  		$postThumbnail = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
  		// Create hyperlinks using share intents
  		$facebookURL = "http://www.facebook.com/sharer/sharer.php?u=" . $postURL;
  		$twitterURL = 'https://twitter.com/intent/tweet?text='.$postTitle.'&amp;url='.$postURL.'&amp;via=Media_Smoke';
  		$pinterestURL = 'https://pinterest.com/pin/create/button/?url='.$postURL.'&amp;media='.$postThumbnail[0].'&amp;description='.$postTitle;
  		$whatsappURL = 'whatsapp://send?text='.$postTitle . ' ' . $postURL;
  		$emailURL = 'mailto:?subject=' . $postTitle . '&body=' . $postURL;
  		// Display button markup
  		echo '<div class="share-buttons"><span>Share</span>';
  		echo '<a href="' . $facebookURL . '" target="blank"><i class="fa fa-facebook"></i></a>';
  		echo '<a href="' . $twitterURL . '" target="blank"><i class="fa fa-twitter"></i></a>';
  		echo '<a href="' . $pinterestURL . '" target="blank"><i class="fa fa-pinterest"></i></a>';
  		echo '<a href="' . $whatsappURL . '" target="blank"><i class="fa fa-whatsapp"></i></a>';
  		echo '<a href="' . $emailURL . '" target="blank"><i class="fa fa-envelope"></i></a>';
  		echo '</div>';
  	}
