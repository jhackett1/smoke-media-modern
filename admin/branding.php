<?php
//
// Tweaks to the Wordpress admin panels to remove Wordpress branding and add in Smoke branding
//

// Replace the "Thank you for creating with Wordpress" message with something better"
	function wpse_edit_footer() {
	    add_filter( 'admin_footer_text', 'wpse_edit_text', 11 );
	}
	function wpse_edit_text($content) {
	    return "Something not working? Contact the <a href='mailto:" . get_bloginfo('admin_email') . "'>student media coordinator</a>.";
	}
	add_action( 'admin_init', 'wpse_edit_footer' );

// Remove Wordpress menu option from admin bar
  function remove_wp_logo( $wp_admin_bar ) {
    $wp_admin_bar->remove_node('wp-logo');
  }
  add_action('admin_bar_menu', 'remove_wp_logo', 999);

// Make the default admin colour scheme Midnight
  function set_default_admin_color($user_id) {
  	$args = array(
  		'ID' => $user_id,
  		'admin_color' => 'midnight'
  	);
  	wp_update_user( $args );
  }
  add_action('user_register', 'set_default_admin_color');

// Change login page logo URL from wordpress.org to site URL
function change_login_logo_url() {
  return get_bloginfo( 'url' );
}
add_filter( 'login_headerurl', 'change_login_logo_url' );

function my_login_logo_url_title() {
return get_bloginfo( 'name' );
}
add_filter( 'login_headertitle', 'my_login_logo_url_title' );


// Rename posts taxonomy to articles
  function revcon_change_post_label() {
      global $menu;
      global $submenu;
      $menu[5][0] = 'Articles';
      $submenu['edit.php'][5][0] = 'Articles';
      $submenu['edit.php'][10][0] = 'Add Article';
      $submenu['edit.php'][16][0] = 'Articles Tags';
  }
  function revcon_change_post_object() {
      global $wp_post_types;
      $labels = &$wp_post_types['post']->labels;
      $labels->name = 'Articles';
      $labels->singular_name = 'Article';
      $labels->add_new = 'Add Article';
      $labels->add_new_item = 'Add Article';
      $labels->edit_item = 'Edit Article';
      $labels->new_item = 'Article';
      $labels->view_item = 'View Articles';
      $labels->search_items = 'Search Articles';
      $labels->not_found = 'No Articles found';
      $labels->not_found_in_trash = 'No Articles found in Trash';
      $labels->all_items = 'All Articles';
      $labels->menu_name = 'Articles';
      $labels->name_admin_bar = 'Article';
  }

  add_action( 'admin_menu', 'revcon_change_post_label' );
  add_action( 'init', 'revcon_change_post_object' );
