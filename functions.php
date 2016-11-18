<?php

// Register scripts and styles
wp_enqueue_style( 'Styles', get_stylesheet_uri() );
wp_enqueue_style( 'FontAwesome', get_stylesheet_directory_uri() . '/font-awesome-4.7.0/css/font-awesome.min.css' );
wp_enqueue_script( 'jquery', get_template_directory_uri() . '/js/jquery-3.1.1.min.js');
wp_enqueue_script( 'app', get_template_directory_uri() . '/js/app.js');
wp_enqueue_script( 'wow', get_template_directory_uri() . '/js/wow.js');

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
		'id'            => 'post-sidebar',
		'before_widget' => '<div>',
		'after_widget'  => '</div>',
	) );
  register_sidebar( array(
    'name'          => 'Page Sidebar',
    'id'            => 'page-sidebar',
    'before_widget' => '<div>',
    'after_widget'  => '</div>',
  ) );
  register_sidebar( array(
		'name'          => 'Member Portal Sidebar',
		'id'            => 'member-sidebar',
		'before_widget' => '<div>',
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

//Shorten excerpts
			 function custom_excerpt_length( $length ) {
			return 15;
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

// Include the options page file
	require_once( __DIR__ . '/admin/options.php');

// Include the branding page file
	require_once( __DIR__ . '/admin/branding.php');

// Include the editor page file
	require_once( __DIR__ . '/admin/editor.php');
