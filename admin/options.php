<?php
//
// Add and populate theme settings panels
//

// Add a menu option for the options page we create
  function add_theme_menu_items()
  {
  	add_menu_page("More settings", "More settings", "manage_options", "theme-panel", "theme_settings_page", null, 99);
  }
  add_action("admin_menu", "add_theme_menu_items");


// Create theme options page
  function theme_settings_page()
  {
      ?>
  	    <div class="wrap">
  	    <h1>More Theme Settings</h1>
  			<p>Adjust advanced aspects of the Smoke Media website. Only for people who know what they're doing.</p>
  	    <form method="post" action="options.php">
  	        <?php
  	            settings_fields("section");
  	            do_settings_sections("theme-options");
  	            submit_button();
  	        ?>
  	    </form>
  		</div>
  	<?php
  }

// Display HTML code of a category picker
  function featured_cat_element()
  {
  	?>
      <?php
        wp_dropdown_categories( array(
          'selected' => get_option('featured_cat'),
          'name' => "featured_cat",
          'id' => "featured_cat"
        ) );
      ?>
  		<p class="description">Which category should serve as the promoted/featured category at the top of the homepage?.</p>
    <?php
  }

// Display HTML code of Typekit ID field
  function typekit_id_element()
  {
  	?>
    	<input type="text" name="typekit_id" id="typekit_id" value="<?php echo get_option('typekit_id'); ?>" />
  		<p class="description">This theme uses <a target="blank" href="https://helpx.adobe.com/typekit/using/add-fonts-website.html">Typekit fonts</a>. Give the ID of the kit here. Without this, fonts may not display properly.</p>
    <?php
  }

// Display HTML code of stream URL element
  function stream_url_element()
  {
  	?>
    	<input type="text" name="stream_url" id="stream_url" value="<?php echo get_option('stream_url'); ?>" />
  		<p class="description">Give the full URL of the Smoke Radio output stream here. The player will connect to this.</p>
    <?php
  }

function display_theme_panel_fields()
{

  // Create a section of fields
	add_settings_section("frontpage-section", "Front page", null, "theme-options");
	// Add a single field
	add_settings_field("featured_cat", "Featured category?", "featured_cat_element", "theme-options", "frontpage-section");
	// Automate saving of field to database
  register_setting("section", "featured_cat");

	// Create a section of fields
	add_settings_section("typekit-section", "Adobe Typekit", null, "theme-options");
	// Add a single field
	add_settings_field("typekit_id", "Typekit Kit ID", "typekit_id_element", "theme-options", "typekit-section");
	// Automate saving of field to database
  register_setting("section", "typekit_id");

  // Create a section of fields
	add_settings_section("broadcast-section", "Broadcast", null, "theme-options");
	// Add a single field
	add_settings_field("stream URL", "Output Stream URL", "stream_url_element", "theme-options", "broadcast-section");
	// Automate saving of field to database
  register_setting("section", "stream_url");

}
add_action("admin_init", "display_theme_panel_fields");
