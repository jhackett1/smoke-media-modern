<?php

// Include the options page file
	require_once( __DIR__ . '/admin/options.php');

	// Include the options page file
		require_once( __DIR__ . '/admin/front-page-settings.php');

	// Include the branding page file
		require_once( __DIR__ . '/gallery.php');

// Include the branding page file
	require_once( __DIR__ . '/admin/branding.php');

// Include the editor page file
	require_once( __DIR__ . '/admin/widgets.php');

	// Include the editor page file
		require_once( __DIR__ . '/admin/live-meta-box.php');

// Include the editor page file
	require_once( __DIR__ . '/admin/editor.php');

	// Include YT API functionality
		require_once( __DIR__ . '/weather/weather.php');

// Include YT API functionality
	require_once( __DIR__ . '/youtube/youtube.php');

// Include Audioboom API functionality
	require_once( __DIR__ . '/audioboom/audioboom.php');

// Include show scheduling functionality
	require_once( __DIR__ . '/marconi/marconi.php');

// Include Issuu API functionality
	require_once( __DIR__ . '/issuu/issuu.php');

	// Include radio Youtube functionality
		require_once( __DIR__ . '/radio-video/radio-video.php');

// Register scripts and styles
function get_styles(){
	wp_enqueue_style( 'Styles', get_stylesheet_uri() );
	wp_enqueue_style( 'FontAwesome', get_stylesheet_directory_uri() . '/font-awesome-4.7.0/css/font-awesome.min.css' );
	wp_enqueue_style( 'WeatherIcons', get_stylesheet_directory_uri() . '/weather/css/weather-icons.min.css' );
	wp_enqueue_style( 'Player skin', get_stylesheet_directory_uri() . '/css/smokeplayerskin.css' );
}
function get_scripts(){
	wp_enqueue_script( 'jquery', get_template_directory_uri() . '/js/jquery-3.1.1.min.js');
	wp_enqueue_script( 'app', get_template_directory_uri() . '/js/app.js');
	wp_enqueue_script( 'wow', get_template_directory_uri() . '/js/wow.js');
	wp_enqueue_script( 'jwplayer', get_template_directory_uri() . '/jwplayer-7.7.4/jwplayer.js');
	wp_enqueue_script( 'wavesurfer', get_template_directory_uri() . '/js/wavesurfer.js');
}
add_action( 'wp_enqueue_scripts', 'get_styles');
add_action( 'wp_enqueue_scripts', 'get_scripts');

//Fix user roles
function add_theme_caps() {
    // gets the author role
    $role = get_role( 'contributor' );
    $role->add_cap( 'upload_files' );
}
add_action( 'admin_init', 'add_theme_caps');
function add_theme_caps2() {
    // gets the author role
    $role = get_role( 'contributor' );
    $role->add_cap( 'edit_others_posts' );
}
add_action( 'admin_init', 'add_theme_caps2');
function add_theme_caps3() {
    // gets the author role
    $role = get_role( 'contributor' );
    $role->add_cap( 'edit_published_posts' );
}
add_action( 'admin_init', 'add_theme_caps3');
function remove_theme_caps() {
    // gets the author role
    $role = get_role( 'editor' );
    $role->remove_cap( 'publish_posts' );
}
add_action( 'admin_init', 'remove_theme_caps');

//Hide visual editor for everyone
add_filter('user_can_richedit' , create_function('' , 'return false;') , 50);

// Support catgory-specific single.php templates
add_filter('single_template', create_function('$t', 'foreach( (array) get_the_category() as $cat ) { if ( file_exists(TEMPLATEPATH . "/single-{$cat->term_id}.php") ) return TEMPLATEPATH . "/single-{$cat->term_id}.php"; } return $t;' ));

// Server-side livestream URL player AJAX handler
	function stream_ajax(){
	    header("Content-Type: text/html");
			echo get_option('stream_url');
			echo get_option('stream_type');
	    exit;
	}
	add_action('wp_ajax_nopriv_stream_ajax', 'stream_ajax');
	add_action('wp_ajax_stream_ajax', 'stream_ajax');


// Server-side post grid 'load-more' AJAX handler
function more_post_ajax(){
		// Check what offset has been requested
    $offset = $_POST["offset"];
		// Check how many posts are requested
    $ppp = $_POST["ppp"];
		// Check the current category
    $cat = $_POST["cat"];
    header("Content-Type: text/html");

    $args = array(
        'cat' => $cat,
        'posts_per_page' => $ppp,
        'offset' => $offset,
    );

		$ajax_query = new WP_Query($args);
		// Begin the loop
		if ($ajax_query->have_posts() ):
		// Create a counter variable to keep track of post numbers
		$counter = 1;
		?>
		  <ul id="category" class="limited-width headline-block wow fadeIn animated">
		<?php
		  // Start looping
		  while ( $ajax_query->have_posts() ): $ajax_query->the_post();
		    // Save post ID as var
		    $ID = get_the_ID();
		    // If current post ID exists in array, skip post and continue with loop
		    if (in_array($ID, $do_not_replicate)) { continue; };
		    // Stop looping after fourth post
		    if ($counter>8) { break; };
		    // Save current post ID to array
		    array_push($do_not_replicate, $ID);
		    ?>
		    <!--  -->
		    <!-- Display output here -->
				<?php
		    switch ($counter) {
		        case 1:
		            ?>
		            <li class="headline-item">
		              <?php the_post_thumbnail('large'); ?>
		              <h3><?php the_title(); ?></h3>
		              <?php the_category(); ?>
		              <div class="grad"></div>
		              <a class="cover" href="<?php the_permalink(); ?>"></a>
		            </li>
		            <?php
		            break;
		        case 2:
		            ?>
		            <li class="headline-item">
		              <?php the_post_thumbnail('large'); ?>
		              <h3><?php the_title(); ?></h3>
		              <?php the_category(); ?>
		              <div class="grad"></div>
		              <a class="cover" href="<?php the_permalink(); ?>"></a>
		            </li>
		            <?php
		            break;
		        case 3:
		            ?>
		              <ul class="horizontal-list">
		                <li class="horizontal-headline-item">
		                  <?php the_post_thumbnail('medium'); ?>
		                  <div>
		                    <h3><?php the_title(); ?></h3>
		                    <?php the_excerpt(); ?>
		                  </div>
		                  <a class="cover" href="<?php the_permalink(); ?>"></a>
		                </li>
		            <?php
		            break;
		        case 4:
		            ?>
		                <li class="horizontal-headline-item">
		                  <?php the_post_thumbnail('medium'); ?>
		                  <div>
		                    <h3><?php the_title(); ?></h3>
		                    <?php the_excerpt(); ?>
		                  </div>
		                  <a class="cover" href="<?php the_permalink(); ?>"></a>
		                </li>
		              </ul>
		            <?php
		            break;
		        case 5:
		            ?>
		              <ul class="horizontal-list">
		                <li class="horizontal-headline-item">
		                  <?php the_post_thumbnail('medium'); ?>
		                  <div>
		                    <h3><?php the_title(); ?></h3>
		                    <?php the_excerpt(); ?>
		                  </div>
		                  <a class="cover" href="<?php the_permalink(); ?>"></a>
		                </li>
		            <?php
		            break;
		        case 6:
		            ?>
		                <li class="horizontal-headline-item">
		                  <?php the_post_thumbnail('medium'); ?>
		                  <div>
		                    <h3><?php the_title(); ?></h3>
		                    <?php the_excerpt(); ?>
		                  </div>
		                  <a class="cover" href="<?php the_permalink(); ?>"></a>
		                </li>
		              </ul>
		            <?php
		            break;
		        case 7:
		            ?>
		            <li class="headline-item">
		              <?php the_post_thumbnail('large'); ?>
		              <h3><?php the_title(); ?></h3>
		              <?php the_category(); ?>
		              <div class="grad"></div>
		              <a class="cover" href="<?php the_permalink(); ?>"></a>
		            </li>
		            <?php
		            break;
		        case 8:
		            ?>
		            <li class="headline-item">
		              <?php the_post_thumbnail('large'); ?>
		              <h3><?php the_title(); ?></h3>
		              <?php the_category(); ?>
		              <div class="grad"></div>
		              <a class="cover" href="<?php the_permalink(); ?>"></a>
		            </li>
		            <?php
		            break;
		        default:
		            echo "";
		    }
		    // Advance the counter by one with each post
		    $counter++;
		    // Finish looping
		  endwhile;
		?>
		  </ul>

		<?php
		// And close out the loop completely
		endif;

    exit;
}

add_action('wp_ajax_nopriv_more_post_ajax', 'more_post_ajax');
add_action('wp_ajax_more_post_ajax', 'more_post_ajax');


// Server-side post grid 'load-more' AJAX handler
function author_ajax(){
		// Check what offset has been requested
    $offset = $_POST["offset"];
		// Check how many posts are requested
    $ppp = $_POST["ppp"];
		// Check the current category
    $author = $_POST["author_id"];
    header("Content-Type: text/html");

    $args = array(
        'author' => $author,
        'posts_per_page' => $ppp,
        'offset' => $offset,
    );

		$ajax_query = new WP_Query($args);
		// Begin the loop
		if ($ajax_query->have_posts() ):
		// Create a counter variable to keep track of post numbers
		$counter = 1;
		?>
		  <ul id="category" class="limited-width headline-block wow fadeIn animated">
		<?php
		  // Start looping
		  while ( $ajax_query->have_posts() ): $ajax_query->the_post();
		    // Save post ID as var
		    $ID = get_the_ID();
		    // If current post ID exists in array, skip post and continue with loop
		    if (in_array($ID, $do_not_replicate)) { continue; };
		    // Stop looping after fourth post
		    if ($counter>8) { break; };
		    // Save current post ID to array
		    array_push($do_not_replicate, $ID);
		    ?>
		    <!--  -->
		    <!-- Display output here -->
				<?php
		    switch ($counter) {
		        case 1:
		            ?>
		            <li class="headline-item">
		              <?php the_post_thumbnail('large'); ?>
		              <h3><?php the_title(); ?></h3>
		              <?php the_category(); ?>
		              <div class="grad"></div>
		              <a class="cover" href="<?php the_permalink(); ?>"></a>
		            </li>
		            <?php
		            break;
		        case 2:
		            ?>
		            <li class="headline-item">
		              <?php the_post_thumbnail('large'); ?>
		              <h3><?php the_title(); ?></h3>
		              <?php the_category(); ?>
		              <div class="grad"></div>
		              <a class="cover" href="<?php the_permalink(); ?>"></a>
		            </li>
		            <?php
		            break;
		        case 3:
		            ?>
		              <ul class="horizontal-list">
		                <li class="horizontal-headline-item">
		                  <?php the_post_thumbnail('medium'); ?>
		                  <div>
		                    <h3><?php the_title(); ?></h3>
		                    <?php the_excerpt(); ?>
		                  </div>
		                  <a class="cover" href="<?php the_permalink(); ?>"></a>
		                </li>
		            <?php
		            break;
		        case 4:
		            ?>
		                <li class="horizontal-headline-item">
		                  <?php the_post_thumbnail('medium'); ?>
		                  <div>
		                    <h3><?php the_title(); ?></h3>
		                    <?php the_excerpt(); ?>
		                  </div>
		                  <a class="cover" href="<?php the_permalink(); ?>"></a>
		                </li>
		              </ul>
		            <?php
		            break;
		        case 5:
		            ?>
		              <ul class="horizontal-list">
		                <li class="horizontal-headline-item">
		                  <?php the_post_thumbnail('medium'); ?>
		                  <div>
		                    <h3><?php the_title(); ?></h3>
		                    <?php the_excerpt(); ?>
		                  </div>
		                  <a class="cover" href="<?php the_permalink(); ?>"></a>
		                </li>
		            <?php
		            break;
		        case 6:
		            ?>
		                <li class="horizontal-headline-item">
		                  <?php the_post_thumbnail('medium'); ?>
		                  <div>
		                    <h3><?php the_title(); ?></h3>
		                    <?php the_excerpt(); ?>
		                  </div>
		                  <a class="cover" href="<?php the_permalink(); ?>"></a>
		                </li>
		              </ul>
		            <?php
		            break;
		        case 7:
		            ?>
		            <li class="headline-item">
		              <?php the_post_thumbnail('large'); ?>
		              <h3><?php the_title(); ?></h3>
		              <?php the_category(); ?>
		              <div class="grad"></div>
		              <a class="cover" href="<?php the_permalink(); ?>"></a>
		            </li>
		            <?php
		            break;
		        case 8:
		            ?>
		            <li class="headline-item">
		              <?php the_post_thumbnail('large'); ?>
		              <h3><?php the_title(); ?></h3>
		              <?php the_category(); ?>
		              <div class="grad"></div>
		              <a class="cover" href="<?php the_permalink(); ?>"></a>
		            </li>
		            <?php
		            break;
		        default:
		            echo "";
		    }
		    // Advance the counter by one with each post
		    $counter++;
		    // Finish looping
		  endwhile;
		?>
		  </ul>

		<?php
		// And close out the loop completely
		endif;

    exit;
}

add_action('wp_ajax_nopriv_author_ajax', 'author_ajax');
add_action('wp_ajax_author_ajax', 'author_ajax');


// Register four navigation menu locations
register_nav_menus( array(
	'primary' => 'Primary',
  'top-left' => 'Top Left',
	'top-right' => 'Top Right',
	'footer' => 'Footer',

	'primary-radio' => 'Primary (Radio homepage)',
	'top-left-radio' => 'Top Left (Radio homepage)'
) );

// Register three widgetised sidebars
function register_widgets() {

	register_sidebar( array(
		'name'          => 'Article Sidebar',
		'id'            => 'post',
		'before_widget' => '<div class="widget %2$s">',
		'after_widget'  => '</div>',
	) );
  register_sidebar( array(
    'name'          => 'Page Sidebar',
    'id'            => 'page',
    'before_widget' => '<div class="widget %2$s">',
    'after_widget'  => '</div>',
  ) );
	register_sidebar( array(
		'name'          => 'Radio Article Sidebar',
		'id'            => 'radio',
		'before_widget' => '<div class="widget %2$s">',
		'after_widget'  => '</div>',
	) );
  register_sidebar( array(
		'name'          => 'Member Portal Sidebar',
		'id'            => 'member',
		'before_widget' => '<div class="widget %2$s">',
		'after_widget'  => '</div>',
	) );
	register_sidebar( array(
		'name'          => 'Radio Homepage Sidebar',
		'id'            => 'radio-home',
		'before_widget' => '<div class="widget %2$s">',
		'after_widget'  => '</div>',
	) );
	register_sidebar( array(
		'name'          => 'Member Portal Sidebar',
		'id'            => 'members',
		'before_widget' => '<div class="widget %2$s">',
		'after_widget'  => '</div>',
	) );
	register_sidebar( array(
		'name'          => 'Live Event Sidebar',
		'id'            => 'live',
		'before_widget' => '<div class="widget %2$s">',
		'after_widget'  => '</div>',
	) );
};
add_action( 'widgets_init', 'register_widgets' );


add_action( 'init', 'liveblogs_init' );
function liveblogs_init() {

	$labels = array(
		'name'               => _x( 'Live Events', 'post type general name', 'your-plugin-textdomain' ),
		'singular_name'      => _x( 'Live Event', 'post type singular name', 'your-plugin-textdomain' ),
		'menu_name'          => _x( 'Live Events', 'admin menu', 'your-plugin-textdomain' ),
		'name_admin_bar'     => _x( 'Live Event', 'add new on admin bar', 'your-plugin-textdomain' ),
		'add_new'            => _x( 'Add New', 'live event', 'your-plugin-textdomain' ),
		'add_new_item'       => __( 'Add New Live Event', 'your-plugin-textdomain' ),
		'new_item'           => __( 'New Live Event', 'your-plugin-textdomain' ),
		'edit_item'          => __( 'Edit Live Event', 'your-plugin-textdomain' ),
		'view_item'          => __( 'View Live Event', 'your-plugin-textdomain' ),
		'all_items'          => __( 'All Live Events', 'your-plugin-textdomain' ),
		'search_items'       => __( 'Search Live Events', 'your-plugin-textdomain' ),
		'parent_item_colon'  => __( 'Parent Live Events:', 'your-plugin-textdomain' ),
		'not_found'          => __( 'No live events found.', 'your-plugin-textdomain' ),
		'not_found_in_trash' => __( 'No live events found in Trash.', 'your-plugin-textdomain' ),
		'register_meta_box_cb' => 'add_events_metaboxes'
	);
	$args = array(
		'labels'             => $labels,
    'description'        => __( 'Liveblogs and audio/video streams.', 'your-plugin-textdomain' ),
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'live' ),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => null,
		'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'liveblog' ),
		// This is where we add taxonomies to our CPT
		'taxonomies'          => array( 'category' )
	);
	register_post_type( 'live', $args );
	// Don't let liveblogs be added to vanilla posts, only live events
	remove_post_type_support( 'post', 'liveblog' );
}


// Show live events on category pages




// Theme supports logos
add_theme_support( 'custom-logo', array(
	'header-text' => array( 'site-title', 'site-description' ),
) );

// Remove rubbish inline CSS from gallery shortcode
add_filter( 'use_default_gallery_style', '__return_false' );

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
// add_action( 'wp_enqueue_scripts', 'theme_typekit' );






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


// Prevent post media from linking to attachment page by default
	function wpb_imagelink_setup() {
		$image_set = get_option( 'image_default_link_type' );
		if ($image_set !== 'none') {
			update_option('image_default_link_type', 'none');
		}
	}
	add_action('admin_init', 'wpb_imagelink_setup', 10);

// Function to display standfirst
	function smoke_standfirst($ID){
		if (get_post_meta( $ID, 'standfirst')) {
			$standfirst = get_post_meta( $ID, 'standfirst')[0];
		} else {
			$standfirst = 0;
		}
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
		if (get_post_meta( $ID, 'byline')) {
			$byline = get_post_meta( $ID, 'byline')[0];
		} else {
			$byline = 0;
		}


		if($byline){
			echo $byline;
		}else{
			the_author_posts_link();
		}
	}

	//Function to display star ratings on front page and category pages
		function smoke_rating_headline($ID){
			// Retrieve metadata and save as var
				if (get_post_meta( $ID, 'star_rating')) {
					$star_rating = get_post_meta( $ID, 'star_rating')[0];
				} else {
					$star_rating = 0;
				}

				if ( $star_rating ){
					// Display container element
					echo "<div>";
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
					echo "</div>";
				}
		}


//Function to display star ratings on single pages
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

// A function to add a media icon to the post title
	function add_media_icon($the_title, $id){
		// Only show on archive and front pages
		if(!is_single() && !is_admin()){
			// Save the retrieved metadata as a var
			if (get_post_meta( $id, 'feat_video_url')) {
				$featured_video_url = get_post_meta( $id, 'feat_video_url')[0];
			} else {
				$featured_video_url = 0;
			}
			if ($featured_audio_embed = get_post_meta( $id, 'feat_audio_embed')) {
				$featured_audio_embed = get_post_meta( $id, 'feat_audio_embed')[0];
			} else {
				$featured_audio_embed = 0;
			}
			// Depending on which meta is set, add icons to the post title
			if($featured_video_url){
				$the_title =  '<i class="media fa fa-play-circle"></i> ' . $the_title;
			}elseif($featured_audio_embed){
				$the_title =  '<i class="media fa fa-headphones"></i> ' . $the_title;
			}else{};
		};
	return $the_title;
	};

	add_filter('the_title', 'add_media_icon', 10, 2);



// Function to provide a default fallback image if no thumbnail is provided
	function smoke_fallback_thumbnail($html, $post_id){
		// Where is the fallback image?
		if (!is_page() && !is_single()){
			$url = get_template_directory_uri() . '/img/fallback1.jpg';
			$fallback = '<img src="' . $url . '"/>';
		}

		// If there is an image set, return it. Else, return a fallback image html
		if ($html){
			return $html;
		}else{
			return $fallback;
		}
	};

	add_filter('post_thumbnail_html', 'smoke_fallback_thumbnail', 10, 2);


	add_filter( 'body_class', 'custom_class' );
	function custom_class( $classes ) {
	    if ( get_query_var('video')) {
	        $classes[] = 'example';
	    }
	    return $classes;
	}

	// Function to retrieve featured video with image fallback
		function live_video_image($ID){
			// Save the retrieved metadata as a var
			$featured_video_url = get_post_meta( $ID, 'feat_video_url')[0];
			// If the var is set and the URL is valid, then display a player
			if($featured_video_url){
				echo '<div class="yt-container">';
				echo wp_oembed_get( $featured_video_url );
				echo '</div>';
			}elseif($featured_audio_embed){
				echo wp_oembed_get( $featured_audio_embed );
			}else{
				// If the var is not set (i.e. no video specified), display the featured image
				the_post_thumbnail('large');
				// And its caption, if set
				if( get_post_meta( $ID, 'feat_image_credit', true ) ){ ?>
					<figcaption>Image: <?php echo get_post_meta( $ID, 'feat_image_credit', true )?></figcaption>
				<?php }
			}
		}



// Function to retrieve featured video with image fallback
	function featured_video_image($ID){
		// Save the retrieved metadata as a var
		if (get_post_meta( $ID, 'feat_video_url')) {
			$featured_video_url = get_post_meta( $ID, 'feat_video_url')[0];
		} else {
			$featured_video_url = 0;
		}
		if (get_post_meta( $ID, 'feat_audio_embed')) {
			$featured_audio_embed = get_post_meta( $ID, 'feat_audio_embed')[0];
		} else {
			$featured_audio_embed = 0;
		}



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
		}elseif($featured_audio_embed){
			echo wp_oembed_get( $featured_audio_embed );
		}else{
			// If the var is not set (i.e. no video specified), display the featured image
			the_post_thumbnail('large');
			// And its caption, if set
			if( get_post_meta( $ID, 'feat_image_credit', true ) ){ ?>
				<figcaption>Image: <?php echo get_post_meta( $ID, 'feat_image_credit', true )?></figcaption>
			<?php }
		}
	}

// Responsive youtube container
function alx_embed_html( $html ) {
    return '<div class="yt-container">' . $html . '</div>';
}
add_filter( 'embed_oembed_html', 'alx_embed_html', 10, 3 );
add_filter( 'video_embed_html', 'alx_embed_html' ); // Jetpack

// Function to show the author box unless a byline is set
	function smoke_author_box($ID){
		if ( get_post_meta( $ID, 'byline')) {
			$byline = get_post_meta( $ID, 'byline')[0];
		} else {
			$byline = 0;
		}

		if (!$byline){
			?>
			<section class="author-profile">
	      <? echo get_avatar( get_the_author_meta( 'ID' ) ); ?>
	      <div>
	        <h4><?php the_author_posts_link(); ?></h4>
	        <h5><?php the_author_meta( 'position'); ?></h5>
	        <p><?php the_author_meta( 'description'); ?></p>
					<?php
						if(get_the_author_meta('twitter')){
							echo '<a target="blank" href="http://twitter.com/' . get_the_author_meta('twitter') . '"><i class="fa fa-twitter"></i>' . get_the_author_meta('twitter') . '</a>';
						}
					?>
	      </div>
	    </section>
			<?php
		}
	}

	// Function to set up share buttons
		function smoke_share_buttons(){
			// Echo out empty container for scirpt to work on
			echo '<div class="share-buttons" id="share-buttons"></div>';
			?>
			<script>
			// LET'S MAKE SOME BETTER SHARE BUTTONS

			// Save the permalink as a var
			var post_url = window.location.href;
			// Save the post title (or whatever is in the H2 tag) as a var
			var post_title = document.getElementsByTagName("h2")[0].textContent;
			// Trim show / video / and other preceding attributes in the H2 for a cleaner result
			var post_title = post_title.substring(post_title.indexOf("/") + 2);
			// Set post thumbnail as var
			var post_thumb = "<?php echo wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' )[0]; ?>";

			// Process vars into uniform sharing urls
			var facebookURL = "http://www.facebook.com/sharer/sharer.php?u=" + post_url;
			var twitterURL = "https://twitter.com/intent/tweet?text=" + post_title + "&amp;url=" + post_url + "&amp;via=Media_Smoke";
			// If image exists, set a pinterest url too
			if (post_thumb) {
				var pinterestURL = "https://pinterest.com/pin/create/button/?url=" + post_url + "&amp;media=" + post_thumb + "&amp;description=" + post_title;
			}
			var whatsappURL = "whatsapp://send?text=" + post_title + " " + post_url;
			var emailURL = "mailto:?subject=" + post_title + "&body=" + post_url;

			// Put it into practice, giving Pinterest special treatment
			if (pinterestURL) {
				document.getElementById("share-buttons").innerHTML = "<span>Share</span><a href='" + facebookURL + "' target='blank'><i class='fa fa-facebook'></i></a><a href='" + twitterURL + "' target='blank'><i class='fa fa-twitter'></i></a><a href='" + pinterestURL + "' target='blank'><i class='fa fa-pinterest'></i></a><a href='" + whatsappURL + "' target='blank'><i class='fa fa-whatsapp'></i></a><a href='" + emailURL + "' target='blank'><i class='fa fa-envelope'></i></a>";
			} else {
				document.getElementById("share-buttons").innerHTML = "<span>Share</span><a href='" + facebookURL + "' target='blank'><i class='fa fa-facebook'></i></a><a href='" + twitterURL + "' target='blank'><i class='fa fa-twitter'></i></a><a href='" + whatsappURL + "' target='blank'><i class='fa fa-whatsapp'></i></a><a href='" + emailURL + "' target='blank'><i class='fa fa-envelope'></i></a>";
			}
			</script>
			<?php
		}

// Add custom links to the top-rigth menu location for login-out
	add_filter( 'wp_nav_menu_items', 'smoke_loginout_menu_link', 10, 2 );
	add_filter( 'wp_nav_menu_items', 'smoke_listen_menu_link', 10, 2 );
	add_filter( 'wp_nav_menu_items', 'smoke_back_menu_link', 10, 2 );
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
		 $issues= '<li><a href="' . get_site_url() . '/issues">Print editions</a></li>';
		 $items .= $issues ;
	 }
	   if ($args->theme_location == 'top-left') {
			$listen_live = <<<EOD
			<li>
			<a href="javascript: void(0)"
							 onclick="window.open('http://smoke.media/player',
							'windowname1',
							'width=350, height=600');
							 return false;">Listen live<i class="fa fa-headphones"></i></a></li>
EOD;
 		$items .= $listen_live ;
		}
	   return $items;
	}

	function smoke_back_menu_link( $items, $args ) {
	   if ($args->theme_location == 'top-left-radio') {
			$go_back = '<li><a href="' . get_site_url() . '">Smoke Media</a></li>';
 			$items .= $go_back ;
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
		$full_width_image = isset( $values['full_width_image'] ) ? $values['full_width_image'][0] : "";
		$feat_image_credit = isset( $values['feat_image_credit'] ) ? esc_attr( $values['feat_image_credit'][0] ) : "";
		$feat_audio_embed = isset( $values['feat_audio_embed'] ) ? esc_attr( $values['feat_audio_embed'][0] ) : "";
		$feat_video_url = isset( $values['feat_video_url'] ) ? esc_attr( $values['feat_video_url'][0] ) : "";
		$star_rating = isset( $values['star_rating'] ) ? esc_attr( $values['star_rating'][0] ) : "";
		$smoke_promoted = isset( $values['smoke_promoted'] ) ? $values['smoke_promoted'][0] : "";

		//What a nonce
		wp_nonce_field( 'smoke_post_options_nonce', 'meta_box_nonce' );
		// Display input fields, using variables above to show current values
	    ?>
			<p class="description">Use these controls to customise your article's appearence.</p>
			<p>
				<label for="smoke_promoted">Promoted</label><br/>
				<input type="checkbox" id="smoke_promoted" name="smoke_promoted" <?php checked( $smoke_promoted, 'on' ); ?> />
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
				<input type="checkbox" id="full_width_image" name="full_width_image" <?php checked( $full_width_image, 'on' ); ?> />
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
			<p>
				<label for="feat_audio_embed">Featured audio URL</label><br/>
				<input type="text" name="feat_audio_embed" id="feat_audio_embed" value="<?php echo $feat_audio_embed; ?>"/>
			</p>
				<p class="description">Include a Youtube URL, OR an Audioboom/Soundcloud URL here to replace the featured image with other media.</p>
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
		$chk = isset( $_POST['full_width_image'][0] ) ? 'on' : 'off';
    	update_post_meta( $post_id, 'full_width_image', $chk );
    // Save featured image credit field
    if( isset( $_POST['feat_image_credit'] ) )
        update_post_meta( $post_id, 'feat_image_credit', wp_kses( $_POST['feat_image_credit'], $allowed ) );
		// Save video ID field
    if( isset( $_POST['feat_video_url'] ) )
        update_post_meta( $post_id, 'feat_video_url', wp_kses( $_POST['feat_video_url'], $allowed ) );
		// Save audio field
    if( isset( $_POST['feat_audio_embed'] ) )
        update_post_meta( $post_id, 'feat_audio_embed', wp_kses( $_POST['feat_audio_embed'], $allowed ) );
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
		$chk2 = isset( $_POST['smoke_promoted'][0] ) ? 'on' : 'off';
    	update_post_meta( $post_id, 'smoke_promoted', $chk2 );

	}


	// A function for display of a section of posts, accepting a category ID, title string and the $do_not_replicate array as parameters

	// Display a block of posts
	function related_headlines_section($cat, $title, &$do_not_replicate){
	  // Create the WP_query and pass in $cat parameter
	  $the_query = new WP_Query( array('cat' => $cat ) );
	  if ( $the_query->have_posts() ) :
	  // Create a counter variable to track number of posts and set it to one
	  $counter = 1;
	  // If title parameter is set, display the string as a <h2>
	  if($title){
	    echo "<h2 class='section-title limited-width'>" . $title . "</h2>";
	  }
	  // Output a container <section> element
	  ?>
	    <ul class="limited-width headline-block">
	  <?php
	  // Start the loop
	  while ( $the_query->have_posts() ) : $the_query->the_post();
	  // Save post ID as var
	  $ID = get_the_ID();
	  // If current post ID exists in array, skip post and continue with loop
	  if (in_array($ID, $do_not_replicate)) { continue; };
	  // Stop looping after fourth post
	  if ($counter>4) { break; };
	  // Save current post ID to array
	  array_push($do_not_replicate, $ID);
	  // Display posts, conditional on $counter value
	  ?>
	  <?php if ($counter<3):
	    //Display first two posts like so
	  ?>
	    <li class="headline-item">
	      <?php the_post_thumbnail('large'); ?>
	      <h3><?php the_title(); ?></h3>
	      <?php the_category(); ?>
	      <div class="grad"></div>
	      <a class="cover" href="<?php the_permalink(); ?>"></a>
	    </li>
	  <?php elseif ($counter === 3):
	    //The third post, with the opening horizontal container
	  ?>
	    <ul class="horizontal-list">
	      <li class="horizontal-headline-item">
	        <?php the_post_thumbnail('medium'); ?>
	        <div>
	          <h3><?php the_title(); ?></h3>
	          <?php the_excerpt(); ?>
	        </div>
	        <a class="cover" href="<?php the_permalink(); ?>"></a>
	      </li>
	  <?php else:
	    //The fourth/last post, with the closing horizontal container
	  ?>
	      <li class="horizontal-headline-item">
	        <?php the_post_thumbnail('medium'); ?>
	        <div>
	          <h3><?php the_title(); ?></h3>
	          <?php the_excerpt(); ?>
	        </div>
	        <a class="cover" href="<?php the_permalink(); ?>"></a>
	      </li>
	    </ul>
	  <?php endif; ?>

	  <?php
	  // Increase the counter with every post to keep an accurate count
	  $counter++;
	  // Finish looping
	  endwhile;
	  // Clean up after WP_Query
	  wp_reset_postdata();
	  // Close the container element
	  ?>
	    </ul>
	  <?php
	  // What if there are no posts returned?
	  else :
	  ?>
	  <?php endif;
	}

// Track post views
	function track_post_views($postID){
		// Create a meta key
		$count_key = 'smoke_post_views';
		// Set the count var to the value of that key
		$count = get_post_meta($postID, $count_key, true);
		// If there's nothing in count, set it to zero and save. Else, increase the value by one and save.
		if($count==''){
				$count = 0;
				delete_post_meta($postID, $count_key);
				add_post_meta($postID, $count_key, '0');
		}else{
				$count++;
				update_post_meta($postID, $count_key, $count);
		}
	}

//To keep the view count accurate, lets get rid of prefetching
	remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);

// Display a block of six popular posts from the last month
	function popular_headlines_section(){
		// Set up arguments for WP_query
		$args = array(
			'meta_key'		=> 'smoke_post_views',
			'orderby'			=> 'meta_value_num'
		);
	  // Create the WP_query and pass in $cat parameter
	  $the_query = new WP_Query( $args );
	  if ( $the_query->have_posts() ) :
	  // Create a counter variable to track number of posts and set it to one
	  $counter = 1;
	  // Display the title as a <h2>
	    echo "<h2 class='section-title limited-width'>Most popular</h2>";
	  // Output a container <section> element
	  ?>
	    <ul class="limited-width popular-headline-block">
	  <?php
	  // Start the loop
	  while ( $the_query->have_posts() ) : $the_query->the_post();
	  // Save post ID as var
	  $ID = get_the_ID();
	  // Stop looping after fourth post
	  if ($counter>6) { break; };
	  // Display posts, conditional on $counter value
	  ?>

		<li class="headline-item">
			<span><?php echo $counter; ?></span>
			<div>
				<h3><?php the_title(); ?></h3>
				<?php the_excerpt(); ?>
			</div>
			<a class="cover" href="<?php the_permalink(); ?>"></a>
		</li>

	  <?php
	  // Increase the counter with every post to keep an accurate count
	  $counter++;
	  // Finish looping
	  endwhile;
	  // Clean up after WP_Query
	  wp_reset_postdata();
	  // Close the container element
	  ?>
	    </ul>
	  <?php
	  // What if there are no posts returned?
	  else :
	  ?>
	  <?php endif;
	}

		// Display a block of six popular posts from the last month
			function author_popular_headlines_section($author_id){
				// Set up arguments for WP_query
				$args = array(
					'meta_key'		=> 'smoke_post_views',
					'orderby'			=> 'meta_value_num',
					'author' 		=> $author_id
				);
			  // Create the WP_query and pass in $cat parameter
			  $the_query = new WP_Query( $args );
			  if ( $the_query->have_posts() ) :
			  // Create a counter variable to track number of posts and set it to one
			  $counter = 1;
			  // Display the title as a <h2>
			    echo "<h2 class='section-title limited-width'>Popular by " . get_author_name($author_id) . "</h2>";
			  // Output a container <section> element
			  ?>
			    <ul class="limited-width popular-headline-block">
			  <?php
			  // Start the loop
			  while ( $the_query->have_posts() ) : $the_query->the_post();
			  // Save post ID as var
			  $ID = get_the_ID();
			  // Stop looping after fourth post
			  if ($counter>6) { break; };
			  // Display posts, conditional on $counter value
			  ?>

				<li class="headline-item">
					<span><?php echo $counter; ?></span>
					<div>
						<h3><?php the_title(); ?></h3>
						<?php the_excerpt(); ?>
					</div>
					<a class="cover" href="<?php the_permalink(); ?>"></a>
				</li>

			  <?php
			  // Increase the counter with every post to keep an accurate count
			  $counter++;
			  // Finish looping
			  endwhile;
			  // Clean up after WP_Query
			  wp_reset_postdata();
			  // Close the container element
			  ?>
			    </ul>
			  <?php
			  // What if there are no posts returned?
			  else :
			  ?>
			  <?php endif;
			}




	// Display a block of six popular posts from the last month
		function category_popular_headlines_section($cat){
			// Set up arguments for WP_query
			$args = array(
				'meta_key'		=> 'smoke_post_views',
				'orderby'			=> 'meta_value_num',
				'cat' 		=> $cat
			);
		  // Create the WP_query and pass in $cat parameter
		  $the_query = new WP_Query( $args );
		  if ( $the_query->have_posts() ) :
		  // Create a counter variable to track number of posts and set it to one
		  $counter = 1;
		  // Display the title as a <h2>
		    echo "<h2 class='section-title limited-width'>Popular " . get_cat_name($cat) . "</h2>";
		  // Output a container <section> element
		  ?>
		    <ul class="limited-width popular-headline-block">
		  <?php
		  // Start the loop
		  while ( $the_query->have_posts() ) : $the_query->the_post();
		  // Save post ID as var
		  $ID = get_the_ID();
		  // Stop looping after fourth post
		  if ($counter>6) { break; };
		  // Display posts, conditional on $counter value
		  ?>

			<li class="headline-item">
				<span><?php echo $counter; ?></span>
				<div>
					<h3><?php the_title(); ?></h3>
					<?php the_excerpt(); ?>
				</div>
				<a class="cover" href="<?php the_permalink(); ?>"></a>
			</li>

		  <?php
		  // Increase the counter with every post to keep an accurate count
		  $counter++;
		  // Finish looping
		  endwhile;
		  // Clean up after WP_Query
		  wp_reset_postdata();
		  // Close the container element
		  ?>
		    </ul>
		  <?php
		  // What if there are no posts returned?
		  else :
		  ?>
		  <?php endif;
		}

// Display an info bar on the homepage
	function info_bar(){
		// Open section
    echo '<section class="info-bar limited-width mobile-hide">';
		// Display date
		echo '<div>' . date( 'l j F Y' ) . '</div>';
		// Display weather
		echo '<aside>';
		the_weather();
		// Display current radio show
		echo '<div id="current-show">';
		echo '<i class="fa fa-headphones"></i>';
		echo '<h4>Jukebox</h4>';
		echo '<span>On now</span>';

		?>
		<script>
		function showInfoData(){
      // Make the ajax request
      jQuery.ajax({url: "https://marconi.smokeradio.co.uk/api/now_playing.php", success: function(result){
        // Check if there's a show on air
        var showExists = result.success;
				console.log(showExists);
        // If there's a show on air, show the (normally hidden) box
        if (showExists == 1){
          // Display the programme info box
          jQuery("#current-show").css("display", "flex");
          // Pull specific fields from API and process for display
          var title = result.show.title;
          // Display processed data
          jQuery("#current-show h4").html(title);
        } else {
					// If there's no show on, just hide the box
          jQuery("#current-show").css("display", "none");
        }
      }});
      // Check for new data every 60 seconds
      setTimeout(showInfoData, 60000);
    }
    // Call the function
    showInfoData();
		</script>
		<?php

		echo '</div>';
		echo '</aside>';
		// Close section
		echo '</section>';

	}

	// Server-side post grid 'load-more' AJAX handler
	function search_ajax(){
			// Check what offset has been requested
	    $offset = $_POST["offset"];
			// Check how many posts are requested
	    $ppp = $_POST["ppp"];
			// Check the current query
	    $query = $_POST["query"];
	    header("Content-Type: text/html");
			// Query args
	    $args = array(
					's' => $query,
	        'posts_per_page' => $ppp,
	        'offset' => $offset,
	    );
			// Create WP_Query
			$ajax_query = new WP_Query($args);
			// Begin the loop
			if ($ajax_query->have_posts() ):
			// Create a counter variable to keep track of post numbers
			$counter = 1;
			?>
			  <ul id="category" class="limited-width headline-block wow fadeIn animated">
			<?php
			  // Start looping
			  while ( $ajax_query->have_posts() ): $ajax_query->the_post();
			    // Save post ID as var
			    $ID = get_the_ID();
			    // If current post ID exists in array, skip post and continue with loop
			    if (in_array($ID, $do_not_replicate)) { continue; };
			    // Stop looping after fourth post
			    if ($counter>8) { break; };
			    // Save current post ID to array
			    array_push($do_not_replicate, $ID);
			    ?>
			    <!--  -->
			    <!-- Display output here -->
					<?php
			    switch ($counter) {
			        case 1:
			            ?>
			            <li class="headline-item">
			              <?php the_post_thumbnail('large'); ?>
			              <h3><?php the_title(); ?></h3>
			              <?php the_category(); ?>
			              <div class="grad"></div>
			              <a class="cover" href="<?php the_permalink(); ?>"></a>
			            </li>
			            <?php
			            break;
			        case 2:
			            ?>
			            <li class="headline-item">
			              <?php the_post_thumbnail('large'); ?>
			              <h3><?php the_title(); ?></h3>
			              <?php the_category(); ?>
			              <div class="grad"></div>
			              <a class="cover" href="<?php the_permalink(); ?>"></a>
			            </li>
			            <?php
			            break;
			        case 3:
			            ?>
			              <ul class="horizontal-list">
			                <li class="horizontal-headline-item">
			                  <?php the_post_thumbnail('medium'); ?>
			                  <div>
			                    <h3><?php the_title(); ?></h3>
			                    <?php the_excerpt(); ?>
			                  </div>
			                  <a class="cover" href="<?php the_permalink(); ?>"></a>
			                </li>
			            <?php
			            break;
			        case 4:
			            ?>
			                <li class="horizontal-headline-item">
			                  <?php the_post_thumbnail('medium'); ?>
			                  <div>
			                    <h3><?php the_title(); ?></h3>
			                    <?php the_excerpt(); ?>
			                  </div>
			                  <a class="cover" href="<?php the_permalink(); ?>"></a>
			                </li>
			              </ul>
			            <?php
			            break;
			        case 5:
			            ?>
			              <ul class="horizontal-list">
			                <li class="horizontal-headline-item">
			                  <?php the_post_thumbnail('medium'); ?>
			                  <div>
			                    <h3><?php the_title(); ?></h3>
			                    <?php the_excerpt(); ?>
			                  </div>
			                  <a class="cover" href="<?php the_permalink(); ?>"></a>
			                </li>
			            <?php
			            break;
			        case 6:
			            ?>
			                <li class="horizontal-headline-item">
			                  <?php the_post_thumbnail('medium'); ?>
			                  <div>
			                    <h3><?php the_title(); ?></h3>
			                    <?php the_excerpt(); ?>
			                  </div>
			                  <a class="cover" href="<?php the_permalink(); ?>"></a>
			                </li>
			              </ul>
			            <?php
			            break;
			        case 7:
			            ?>
			            <li class="headline-item">
			              <?php the_post_thumbnail('large'); ?>
			              <h3><?php the_title(); ?></h3>
			              <?php the_category(); ?>
			              <div class="grad"></div>
			              <a class="cover" href="<?php the_permalink(); ?>"></a>
			            </li>
			            <?php
			            break;
			        case 8:
			            ?>
			            <li class="headline-item">
			              <?php the_post_thumbnail('large'); ?>
			              <h3><?php the_title(); ?></h3>
			              <?php the_category(); ?>
			              <div class="grad"></div>
			              <a class="cover" href="<?php the_permalink(); ?>"></a>
			            </li>
			            <?php
			            break;
			        default:
			            echo "";
			    }
			    // Advance the counter by one with each post
			    $counter++;
			    // Finish looping
			  endwhile;
			?>
			  </ul>
			<?php
			// And close out the loop completely
			endif;
	    exit;
	}
	add_action('wp_ajax_nopriv_search_ajax', 'search_ajax');
	add_action('wp_ajax_search_ajax', 'search_ajax');

	// Server-side post grid 'load-more' AJAX handler
	function training_ajax(){
			// Check what offset has been requested
	    $offset = $_POST["offset"];
			// Check how many posts are requested
	    $ppp = $_POST["ppp"];
			// Check the current query
	    $cat = $_POST["cat"];
	    header("Content-Type: text/html");
			// Query args
	    $args = array(
					'cat' => $cat,
	        'posts_per_page' => $ppp,
	        'offset' => $offset,
	    );
			// Create WP_Query
			$ajax_query = new WP_Query($args);
			// Begin the loop
			if ($ajax_query->have_posts() ):
			// Create a counter variable to keep track of post numbers
			$counter = 1;
			?>
          <ul class="training-block wow fadeIn animated" data-wow-duration="0.3s">
			<?php
			  // Start looping
			  while ( $ajax_query->have_posts() ): $ajax_query->the_post();
			    // Save post ID as var
			    $ID = get_the_ID();
			    // Stop looping after fourth post
			    if ($counter>8) { break; };
			    ?>
						<li class="training-item wow fadeIn animated" data-wow-duration="0.3s">
	            <?php the_post_thumbnail('large'); ?>
	            <h3><?php the_title(); ?></h3>
	            <p><?php the_excerpt(); ?></p>
	            <a class="cover" href="<?php the_permalink(); ?>"></a>
	          </li>
			    <?php
			    // Advance the counter by one with each post
			    $counter++;
			    // Finish looping
			  endwhile;
			?>
			  </ul>
			<?php
			// And close out the loop completely
			endif;
	    exit;
	}
	add_action('wp_ajax_nopriv_training_ajax', 'training_ajax');
	add_action('wp_ajax_training_ajax', 'training_ajax');

// Server-side post grid 'load-more' AJAX handler
function more_vids_ajax(){
	// Check what offset has been requested
	$token = $_POST["token"];
	header("Content-Type: text/html");
	// Don't do anything unless API key is set
	if (get_option('youtube_api_key')) {
	  // The API endpoint URL with max-results and API key specified by theme option variables
	  $url = 'https://www.googleapis.com/youtube/v3/search?channelId=UCxxVjVWC381ysuaZc9dgU1Q&pageToken=' . $token . '&part=snippet&key=' . get_option('youtube_api_key') . '&order=date&maxResults=' . get_option('vid_number');
	  // Get a response from Youtube Data API using cURL
	  $ch = curl_init();
	  // This API needs SSL to work
	  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
	  curl_setopt($ch, CURLOPT_HEADER, false);
	  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
	  curl_setopt($ch, CURLOPT_URL, $url);
	  curl_setopt($ch, CURLOPT_REFERER, $url);
	  curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	  // Save the response as $result
	  $result = curl_exec($ch);
	  // Your work is done, cURL
	  curl_close($ch);
	  // Convert the result into an associative array
	  $video_array = json_decode($result, true);
		?> <ul class="videos limited-width"> <?php
		// Create a counter variable and leave it at 1 for now
		$counter = 1;
		// Get every video, store as array $video and display in a loop
		foreach($video_array["items"] as $video){
		  // Set the description as a var
		  $description = $video["snippet"]["description"];
		  // Shorten the descriptions to a sensible length
		  if (strlen($description) > 200) {
		      $descriptionCut = substr($description, 0, 200);
		      // make sure it ends in a whole word
		      $description = substr($descriptionCut, 0, strrpos($descriptionCut, ' ')).'...';
		  }
		  // Set the URL as a var
		  $video_permalink = get_site_url() . "/video/" . $video["id"]["videoId"];
		  ?>
		    <li class="video-tile">
		      <img src="<?php echo $video["snippet"]["thumbnails"]["high"]["url"]; ?>"/>
		      <h3><?php echo $video["snippet"]["title"]; ?></h3>
		      <p><?php echo $description; ?></p>
		      <span class="play-icon"><i class="fa fa-play"></i></span>
		      <a class="cover" href="<?php echo $video_permalink; ?>"></a>
		    </li>
		  <?php
		// Iterate the counter
		$counter++;
		}
		}
		?>
		</ul>
		<script>
		var next_page_token = '<?php echo $video_array["nextPageToken"]; ?>';
		</script>
	<?php
	exit;
}
add_action('wp_ajax_nopriv_more_vids_ajax', 'more_vids_ajax');
add_action('wp_ajax_more_vids_ajax', 'more_vids_ajax');















// Server-side post grid 'load-more' AJAX handler
function more_radio_vids_ajax(){
	// Check what offset has been requested
	$token = $_POST["token"];
	header("Content-Type: text/html");
	// Don't do anything unless API key is set
	if (get_option('youtube_api_key')) {
	  // The API endpoint URL with max-results and API key specified by theme option variables
	  $url = 'https://www.googleapis.com/youtube/v3/search?channelId=UCCG_RzmGLUFQsm4aVyh76KQ&pageToken=' . $token . '&part=snippet&key=' . get_option('youtube_api_key') . '&order=date&maxResults=' . get_option('vid_number');
	  // Get a response from Youtube Data API using cURL
	  $ch = curl_init();
	  // This API needs SSL to work
	  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
	  curl_setopt($ch, CURLOPT_HEADER, false);
	  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
	  curl_setopt($ch, CURLOPT_URL, $url);
	  curl_setopt($ch, CURLOPT_REFERER, $url);
	  curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	  // Save the response as $result
	  $result = curl_exec($ch);
	  // Your work is done, cURL
	  curl_close($ch);
	  // Convert the result into an associative array
	  $video_array = json_decode($result, true);
		?> <ul class="videos limited-width"> <?php
		// Create a counter variable and leave it at 1 for now
		$counter = 1;
		// Get every video, store as array $video and display in a loop
		foreach($video_array["items"] as $video){
		  // Set the description as a var
		  $description = $video["snippet"]["description"];
		  // Shorten the descriptions to a sensible length
		  if (strlen($description) > 200) {
		      $descriptionCut = substr($description, 0, 200);
		      // make sure it ends in a whole word
		      $description = substr($descriptionCut, 0, strrpos($descriptionCut, ' ')).'...';
		  }
		  // Set the URL as a var
		  $video_permalink = get_site_url() . "/radio/video/" . $video["id"]["videoId"];
		  ?>
		    <li class="video-tile">
		      <img src="<?php echo $video["snippet"]["thumbnails"]["high"]["url"]; ?>"/>
		      <h3><?php echo $video["snippet"]["title"]; ?></h3>
		      <p><?php echo $description; ?></p>
		      <span class="play-icon"><i class="fa fa-play"></i></span>
		      <a class="cover" href="<?php echo $video_permalink; ?>"></a>
		    </li>
		  <?php
		// Iterate the counter
		$counter++;
		}
		}
		?>
		</ul>
		<script>
		var next_page_token = '<?php echo $video_array["nextPageToken"]; ?>';
		</script>
	<?php
	exit;
}
add_action('wp_ajax_nopriv_more_radio_vids_ajax', 'more_radio_vids_ajax');
add_action('wp_ajax_more_radio_vids_ajax', 'more_radio_vids_ajax');
















// Server-side post grid 'load-more' AJAX handler
function more_audio_ajax(){
	// Check what offset has been requested
	$page = $_POST["page"];
	header("Content-Type: text/html");

	// Don't do anything unless API key is set
	  if (get_option('audioboom_api_key')) {
	    // The API endpoint URL
	      $url = 'http://audioboom.com/api/audio_clips?username=smokeradio&page[items]=9&page[number]=' . $page;
	    // Get a response from Audioboom API using cURL
	      $ch = curl_init();
	      // This API needs SSL to work
	      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
	      curl_setopt($ch, CURLOPT_HEADER, false);
	      curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
	      curl_setopt($ch, CURLOPT_URL, $url);
	      curl_setopt($ch, CURLOPT_REFERER, $url);
	      curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	      // Save the response as $result
	      $result = curl_exec($ch);
	      // Your work is done, cURL
	      curl_close($ch);
	      // Convert the result into an associative array
	      $boo_array = json_decode($result, true);

		echo '<ul class="videos limited-width">';
	// Create a counter variable and leave it at 1 for now
	  $counter = 1;
	// Get every video, store as array $video and display in a loop
	  foreach($boo_array["body"]["audio_clips"] as $boo){
	    // Stop looping after fourth post
	    if ($counter>9) { break; };
	    // Set the description as a var
	    $description = $boo["description"];
	    // Shorten the descriptions to a sensible length
	    if (strlen($description) > 100) {
        $descriptionCut = substr($description, 0, 100);
        // make sure it ends in a whole word
        $description = substr($descriptionCut, 0, strrpos($descriptionCut, ' ')).'...';
	    }
	    $duration = round($boo["duration"] / 60) . " mins";
	    // Set the URL as a var
	    $audio_permalink = get_site_url() . "/audio/" . $boo["id"];
	  	?>
	    <li class="video-tile">
	      <img src="<?php echo $boo["urls"]["post_image"]["original"]; ?>"/>
	      <h3><?php echo $boo["title"]; ?></h3>
	      <p><?php echo $description; ?></p>
	      <span class="play-icon"><i class="fa fa-headphones"></i></span>
	      <a class="cover" href="<?php echo $audio_permalink; ?>"></a>
	    </li>
		  <?php
			// Iterate the counter
			$counter++;
		}

	?>
	</ul>
	<script>
	var page = page + 1;
	</script>
	<?php
	echo '</ul>';
}
	exit;
}
add_action('wp_ajax_nopriv_more_audio_ajax', 'more_audio_ajax');
add_action('wp_ajax_more_audio_ajax', 'more_audio_ajax');


function my_login_stylesheet() {
    wp_enqueue_style( 'custom-login', get_stylesheet_directory_uri() . '/style.css' );
<<<<<<< HEAD
}
add_action( 'login_enqueue_scripts', 'my_login_stylesheet' );




function add_custom_post_type_to_query( $query ) {
    if ( $query->is_main_query() && $query->is_category() ) {
        $query->set( 'post_type', array('post', 'live') );
    }
}
add_action( 'pre_get_posts', 'add_custom_post_type_to_query');
=======
}
add_action( 'login_enqueue_scripts', 'my_login_stylesheet' );
>>>>>>> origin/master
