<?php

// Include the options page file
	require_once( __DIR__ . '/admin/options.php');

// Include the branding page file
	require_once( __DIR__ . '/admin/branding.php');

// Include the editor page file
	require_once( __DIR__ . '/admin/widgets.php');

// Include the editor page file
	require_once( __DIR__ . '/admin/editor.php');

	// Include YT API functionality
		require_once( __DIR__ . '/weather/weather.php');

// Include YT API functionality
	require_once( __DIR__ . '/youtube/youtube.php');

// Register scripts and styles
wp_enqueue_style( 'Styles', get_stylesheet_uri() );
wp_enqueue_style( 'FontAwesome', get_stylesheet_directory_uri() . '/font-awesome-4.7.0/css/font-awesome.min.css' );
wp_enqueue_style( 'WeatherIcons', get_stylesheet_directory_uri() . '/weather/css/weather-icons.min.css' );
wp_enqueue_style( 'Player skin', get_stylesheet_directory_uri() . '/css/smokeplayerskin.css' );
wp_enqueue_script( 'jquery', get_template_directory_uri() . '/js/jquery-3.1.1.min.js');
wp_enqueue_script( 'app', get_template_directory_uri() . '/js/app.js');
wp_enqueue_script( 'wow', get_template_directory_uri() . '/js/wow.js');
wp_enqueue_script( 'jwplayer', get_template_directory_uri() . '/jwplayer-7.7.4/jwplayer.js');

// Register four navigation menu locations
register_nav_menus( array(
	'primary' => 'Primary',
  'top-left' => 'Top Left',
	'top-right' => 'Top Right',
	'footer' => 'Footer',
) );

// Register three widgetised sidebars
function register_widgets() {

	register_sidebar( array(
		'name'          => 'Single Post Sidebar',
		'id'            => 'post',
		'before_widget' => '<div class="widget">',
		'after_widget'  => '</div>',
	) );
  register_sidebar( array(
    'name'          => 'Page Sidebar',
    'id'            => 'page',
    'before_widget' => '<div class="widget">',
    'after_widget'  => '</div>',
  ) );
  register_sidebar( array(
		'name'          => 'Member Portal Sidebar',
		'id'            => 'member',
		'before_widget' => '<div class="widget">',
		'after_widget'  => '</div>',
	) );

};
add_action( 'widgets_init', 'register_widgets' );

// Theme supports logos
add_theme_support( 'custom-logo', array(
	'header-text' => array( 'site-title', 'site-description' ),
) );

// Theme supports featured images
add_theme_support( 'post-thumbnails' );

//Turn off TinyMCE
add_filter('user_can_richedit' , create_function('' , 'return false;') , 50);

// Eneque Typekit fonts
function theme_typekit() {
	$typekid_raw_id = get_option('typekit_id');
	$typekit_url = "https://use.typekit.net/" . $typekid_raw_id . ".js";
  wp_enqueue_script( 'theme_typekit', $typekit_url);
}
add_action( 'wp_enqueue_scripts', 'theme_typekit' );

function theme_typekit_inline() {
  if ( wp_script_is( 'theme_typekit', 'done' ) ) { ?>
  	<script type="text/javascript">try{Typekit.load();}catch(e){}</script>
<?php }
}
add_action( 'wp_head', 'theme_typekit_inline' );

//Add a new field to user profile
	function modify_contact_methods($profile_fields) {
		// Add new fields
		$profile_fields['twitter'] = 'Twitter profile';
		$profile_fields['position'] = 'Smoke Media role';
		return $profile_fields;
	}
	add_filter('user_contactmethods', 'modify_contact_methods');

// Add JW player license key to Footer
function add_jw_license_key(){
	?>
	<script>jwplayer.key="pTTOSzMuIAwNqrzL1q7qEPIr1EQfvglWbXCelA==";</script>
<?php
}
add_action ('wp_head', 'add_jw_license_key');

//Shorten excerpts
			 function custom_excerpt_length( $length ) {
			return 10;
		}
		add_filter( 'excerpt_length', 'custom_excerpt_length', 15 );

//Replace excerpt ending with something better
	function new_excerpt_more( $more ) {
		return '...';
	}
	add_filter('excerpt_more', 'new_excerpt_more');

// Get rid of the whole post tags taxonomy
	function unregister_tags(){
	    register_taxonomy('post_tag', array());
	}
	add_action('init', 'unregister_tags');


// Add social links to the top-right menu
	add_filter( 'wp_nav_menu_items', 'smoke_social_links', 10, 2 );

	function smoke_social_links( $items, $args ) {
	   if ($args->theme_location == 'top-right') {
			 if ( get_option('twitter_link') ) {
					$items = '<li class="right"><a target="blank" href="'. get_option('twitter_link') .'">' . '<i class="fa fa-twitter"></i></a></li>' . $items;
			 }
			 if ( get_option('yt_link') ) {
					$items = '<li class="right"><a target="blank" href="'. get_option('yt_link') .'">' . '<i class="fa fa-youtube-play"></i></a></li>' . $items;
			 }
      if ( get_option('facebook_link') ) {
         $items = '<li class="right"><a target="blank" href="'. get_option('facebook_link') .'">' . '<i class="fa fa-facebook"></i></a></li>' . $items;
      }


	   }
	   return $items;
	}

// Function to display standfirst
	function smoke_standfirst($ID){
		$standfirst = get_post_meta( $ID, 'standfirst')[0];
		if ( $standfirst ){
			// Replace return key with p tags
			$standfirst = str_replace('
', '</p><p class="highlight">', $standfirst);
			// Echo out results
			echo '<div class="standfirst"><p class="highlight">' . $standfirst . '</p></div><hr>';
		}
	}

//Function to display the byline
	function smoke_byline($ID){
		$byline = get_post_meta( $ID, 'byline')[0];
		if($byline){
			echo $byline;
		}else{
			the_author();
		}
	}

//Function to display star ratings
	function smoke_rating($ID){
		// Retrieve metadata and save as var
			$star_rating = get_post_meta( $ID, 'star_rating')[0];
			if ( $star_rating ){
				// Display container element
				echo "<div class='star-rating'><span>" . $star_rating . "/5</span>";
				// Display full stars
				for ($i=0; $i < $star_rating; $i++) {
					echo "<i class='fa fa-star'></i>";
				}
				// Get difference between star rating and 5, then echo remaining empty stars
				$white_stars = 5 - $star_rating;
				for ($i=0; $i < $white_stars; $i++) {
					echo "<i class='fa fa-star-o'></i>";
				}
				// Close container element
				echo "</div><hr>";
			}
	}

// Function to retrieve featured video with image fallback
	function featured_video_image($ID){
		// Save the retrieved metadata as a var
		$featured_video_url = get_post_meta( $ID, 'feat_video_url')[0];
		// If the var is set and the URL is valid, then display a player
		if($featured_video_url){
			?>
			<div id="videoPlayer">Loading the video player</div>
			<script type="text/javascript">
				var playerInstance = jwplayer("videoPlayer");
				playerInstance.setup({
				file: "<?php echo $featured_video_url; ?>",
				width: 640,
				height: 360,
				name: 'smokeplayerskin'
				});
			</script>
			<?php
		}else{
			// If the var is not set (i.e. no video specified), display the featured image
			the_post_thumbnail('large');
			// And its caption, if set
			if( get_post_meta( $ID, 'feat_image_credit', true ) ){ ?>
				<figcaption>Image: <?php echo get_post_meta( $ID, 'feat_image_credit', true )?></figcaption>
			<?php }
		}
	}

// Function to show the author box unless a byline is set
	function smoke_author_box($ID){
		$byline = get_post_meta( $ID, 'byline')[0];
		if (!$byline){
			?>
			<section class="author-profile">
	      <? echo get_avatar( get_the_author_meta( 'ID' ) ); ?>
	      <div>
	        <h4><?php the_author(); ?></h4>
	        <h5><?php the_author_meta( 'position'); ?></h5>
	        <p><?php the_author_meta( 'description'); ?></p>
	      </div>
	    </section>
			<?php
		}
	}

// Function to set up share buttons
	function smoke_share_buttons(){
		// Prepare the permalink and post title for inclusion in share intent URLs
		$postURL = urlencode( get_permalink() );
		$postTitle = str_replace( ' ', '%20', get_the_title() );
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

// Add custom links to the top-rigth menu location for login-out
	add_filter( 'wp_nav_menu_items', 'smoke_loginout_menu_link', 10, 2 );
	add_filter( 'wp_nav_menu_items', 'smoke_listen_menu_link', 10, 2 );

	function smoke_loginout_menu_link( $items, $args ) {
	   if ($args->theme_location == 'top-right') {
	      if (is_user_logged_in()) {
	         $items .= '<li class="right"><a href="'. wp_logout_url() .'">'. __("Log Out") .'<i class="fa fa-sign-out"></i></a></li>';
	      } else {
	         $items .= '<li class="right"><a href="'. wp_login_url(get_permalink()) .'">'. __("Log In") .'</a></li>';
	      }
				$items .= '<li class="left" id="search-button"><a href="#">Search<i class="fa fa-search"></i>' . get_template_part('searchform') . '</a></li>';
	   }
	   return $items;
	}

	function smoke_listen_menu_link( $items, $args ) {
	   if ($args->theme_location == 'top-left') {
       $items .= '<li class="right"><a href="http://uwsu.com/player/index.php"
				 onclick="return !window.open(this.href, "Listen Live", "resizable=no,width=300,height=615")"
				 target="_blank">Listen Live <i class="fa fa-headphones"></i></a></li>';
	   }
	   return $items;
	}

// Register a meta box to contain fields for adding custom post meta
	add_action( 'add_meta_boxes', 'smoke_meta_box_setup' );
	function smoke_meta_box_setup()
	{
		add_meta_box( 'smoke_post_options', 'Smoke Post Options', 'smoke_post_options_content', 'post', 'side', 'high');
	}

// Callback function to fill the meta box with form input content, passing in the post object
	function smoke_post_options_content( $post )
	{
		// Fetch all post meta data and save as an array var
		$values = get_post_custom( $post->ID );
		// Save current values of particular meta keys as variables for display
		$byline = isset( $values['byline'] ) ? esc_attr( $values['byline'][0] ) : "";
		$full_width_image = isset( $values['full_width_image'] ) ? esc_attr( $values['full_width_image'][0] ) : "";
		$feat_image_credit = isset( $values['feat_image_credit'] ) ? esc_attr( $values['feat_image_credit'][0] ) : "";
		$feat_video_url = isset( $values['feat_video_url'] ) ? esc_attr( $values['feat_video_url'][0] ) : "";
		$star_rating = isset( $values['star_rating'] ) ? esc_attr( $values['star_rating'][0] ) : "";
		$smoke_promoted = isset( $values['smoke_promoted'] ) ? esc_attr( $values['smoke_promoted'][0] ) : "";
		//What a nonce
		wp_nonce_field( 'smoke_post_options_nonce', 'meta_box_nonce' );
		// Display input fields, using variables above to show current values
	    ?>
			<p class="description">Use these controls to customise your article's appearence.</p>
			<p>
				<label for="promoted">Promoted?</label><br/>
				<input type="checkbox" name="smoke_promoted" id="smoke_promoted" <?php checked( $smoke_promoted, 'on' ); ?>/>

				<p class="description">Send this article to the top of the homepage.</p>
				<hr>
			</p>
			<p>
				<label for="byline">Byline</label><br/>
				<input type="text" name="byline" id="byline" value="<?php echo $byline; ?>"/>
				<p class="description">If this article was written by a contributor, give their name to replace your own.</p>
				<hr>
			</p>
			<p>
				<label for="full_width_image">Full-width featured image?</label><br/>
				<input type="checkbox" name="full_width_image" id="full_width_image" <?php checked( $full_width_image, 'on' ); ?>/>
			</p>
			<p>
		    <label for="feat_image_credit">Featured image credit</label><br/>
		    <input type="text" name="feat_image_credit" id="feat_image_credit" value="<?php echo $feat_image_credit; ?>"/>
			</p>
			<p>
	      <label for="star_rating">Star rating</label><br/>
	      <select name="star_rating" id="star_rating">
	          <option value="" <?php selected( $star_rating, 'none' ); ?>>None</option>
				    <option value="1" <?php selected( $star_rating, '1' ); ?>>1</option>
				    <option value="2" <?php selected( $star_rating, '2' ); ?>>2</option>
				    <option value="3" <?php selected( $star_rating, '3' ); ?>>3</option>
				    <option value="4" <?php selected( $star_rating, '4' ); ?>>4</option>
				    <option value="5" <?php selected( $star_rating, '5' ); ?>>5</option>
	      </select>
			</p>
			<hr>
			<p>
				<label for="feat_video_url">Featured video URL</label><br/>
				<input type="text" name="feat_video_url" id="feat_video_url" value="<?php echo $feat_video_url; ?>"/>
			</p>
				<p class="description">Include a Youtube URL here to replace the featured image with a video.</p>
				<p class="description">A featured image <b>MUST</b> still be set.</p>
			<hr>
			<p>
				<label for="standfirst">Standfirst</label><br/>
				<textarea type="text" rows="6" name="standfirst" id="standfirst" value="<?php echo $standfirst; ?>"><?php echo $standfirst; ?></textarea>
			</p>
				<p class="description">Display bullet point highlights here. For a new bullet point, start a <b>new line</b>.</p>
	    <?php
	}

// Having registered the meta box and filled it with content, now we save the form inputs to the post meta table
	add_action( 'save_post', 'smoke_post_options_save' );
	// A function to save form inputs to the database
	function smoke_post_options_save( $post_id ){
		// If this is an autosave, do nothing
		if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
		// Verify the nonce before proceeding

		// if( !isset( $_POST['meta_box_nonce'] ) || !wp_verify_nonce( $_POST['meta_box_nonce'], 'my_meta_box_nonce' ) ) return;

		// Check user permissions before proceeding
		if( !current_user_can( 'edit_post' ) ) return;

    $allowed = array(
        'a' => array( // on allow a tags
            'href' => array() // and those anchors can only have href attribute
        )
    );

    // Save full width image field
		if( isset( $_POST['full_width_image'] ) )
				update_post_meta( $post_id, 'full_width_image', esc_attr( $_POST['full_width_image'] ) );
    // Save featured image credit field
    if( isset( $_POST['feat_image_credit'] ) )
        update_post_meta( $post_id, 'feat_image_credit', wp_kses( $_POST['feat_image_credit'], $allowed ) );
		// Save video ID field
    if( isset( $_POST['feat_video_url'] ) )
        update_post_meta( $post_id, 'feat_video_url', wp_kses( $_POST['feat_video_url'], $allowed ) );
    // Save star rating field
    if( isset( $_POST['star_rating'] ) )
        update_post_meta( $post_id, 'star_rating', esc_attr( $_POST['star_rating'] ) );
		// Save standfirst field
    if( isset( $_POST['standfirst'] ) )
        update_post_meta( $post_id, 'standfirst', esc_attr( $_POST['standfirst'] ) );
		// Save byline field
    if( isset( $_POST['byline'] ) )
        update_post_meta( $post_id, 'byline', esc_attr( $_POST['byline'] ) );
		// Save promoted field
	  if( isset( $_POST['smoke_promoted'] ) )
	      update_post_meta( $post_id, 'smoke_promoted', esc_attr( $_POST['smoke_promoted'] ) );
	}
