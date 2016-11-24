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
  function vid_number_element()
  {
  	?>
      <select name="vid_number" id="vid_number">
        <option value="6" <?php if('6' === get_option('vid_number')){ echo "selected";}; ?>>6</option>
        <option value="9" <?php if('9' === get_option('vid_number')){ echo "selected";}; ?>>9</option>
        <option value="12" <?php if('12' === get_option('vid_number')){ echo "selected";}s; ?>>12</option>
      </select>
  		<p class="description">How many video tiles should be displayed on the homepage?</p>
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

  function weather_api_element()
  {
    ?>
      <input type="text" name="weather_api_key" id="weather_api_key" value="<?php echo get_option('weather_api_key'); ?>" />
      <p class="description">This theme uses the <a href="http://www.metoffice.gov.uk/datapoint/" target="blank">Met Office Datapoint API</a> to display weather forecasts for the London area. Remove API key to disable this feature.</p>
    <?php
  }

  function issuu_api_element()
  {
    ?>
      <input type="text" name="issuu_api_key" id="wissuu_api_key" value="<?php echo get_option('issuu_api_key'); ?>" />
    <?php
  }
  function issuu_secret_element()
  {
    ?>
      <input type="text" name="issuu_api_secret" id="wissuu_api_secret" value="<?php echo get_option('issuu_api_secret'); ?>" />
      <p class="description">This theme uses the <a href="http://developers.issuu.com/api/" target="blank">Issuu API</a> to integrate printed issues. This will not work correctly without a valid API key & secret.</p>
    <?php
  }

  function youtube_api_element()
  {
    ?>
      <input type="text" name="youtube_api_key" id="youtube_api_key" value="<?php echo get_option('youtube_api_key'); ?>" />
      <p class="description">This theme uses the <a href="https://developers.google.com/youtube/v3/" target="blank">Youtube Data API</a>. Give the API key here. Without this, Youtube integration won't work properly.</p>
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
  function stream_type_element()
  {
  	?>
    <select name="stream_type" id="stream_type">
      <option value="RTMP" <?php if('RTMP' === get_option('stream_type')){ echo "selected";}; ?>>RTMP</option>
      <option value="HTTP" <?php if('HTTP' === get_option('stream_type')){ echo "selected";}; ?>>HTTP</option>
    </select>
  		<p class="description">This affects the player needed to play out the stream. Flash media streams are RTMP. Shoutcast/Icecast streams are HTTP.</p>
    <?php
  }

// Display HTML code of FB element
  function facebook_element()
  {
  	?>
    	<input type="text" name="facebook_link" id="facebook_link" value="<?php echo get_option('facebook_link'); ?>" />
    <?php
  }
// Display HTML code of Twitter element
  function twitter_element()
  {
  	?>
    	<input type="text" name="twitter_link" id="twitter_link" value="<?php echo get_option('twitter_link'); ?>" />
    <?php
  }
// Display HTML code of Youtube element
  function yt_element()
  {
  	?>
    	<input type="text" name="yt_link" id="yt_link" value="<?php echo get_option('yt_link'); ?>" />
    <?php
  }

function display_theme_panel_fields()
{

  // Create a section of fields
	add_settings_section("frontpage-section", "Front page", null, "theme-options");
	// Add a single field
	add_settings_field("vid_number", "How many videos to display?", "vid_number_element", "theme-options", "frontpage-section");
	// Automate saving of field to database
  register_setting("section", "vid_number");

	// Create a section of fields
	add_settings_section("typekit-section", "API keys and codes", null, "theme-options");
	// Add a single field
	add_settings_field("typekit_id", "Typekit Kit ID", "typekit_id_element", "theme-options", "typekit-section");
	// Automate saving of field to database
  register_setting("section", "typekit_id");
  // Add a single field
	add_settings_field("youtube_api_key", "Youtube API Key", "youtube_api_element", "theme-options", "typekit-section");
	// Automate saving of field to database
  register_setting("section", "youtube_api_key");
  // Add a single field
  add_settings_field("weather_api_key", "Met Office API Key", "weather_api_element", "theme-options", "typekit-section");
  // Automate saving of field to database
  register_setting("section", "weather_api_key");
  // Automate saving of field to database
  register_setting("section", "youtube_api_key");
  // Add a single field
  add_settings_field("issuu_api_key", "Issuu API Key", "issuu_api_element", "theme-options", "typekit-section");
  // Automate saving of field to database
  register_setting("section", "issuu_api_key");
  // Add a single field
  add_settings_field("issuu_api_secret", "Issuu API Secret", "issuu_secret_element", "theme-options", "typekit-section");
  // Automate saving of field to database
  register_setting("section", "issuu_api_secret");


  // Create a section of fields
	add_settings_section("broadcast-section", "Broadcast", null, "theme-options");
	// Add a single field
	add_settings_field("stream URL", "Output Stream URL", "stream_url_element", "theme-options", "broadcast-section");
	// Automate saving of field to database
  register_setting("section", "stream_url");
  // Add a single field
	add_settings_field("stream type", "Output Stream Type", "stream_type_element", "theme-options", "broadcast-section");
	// Automate saving of field to database
  register_setting("section", "stream_type");

  // Create a section of fields
	add_settings_section("social-section", "Social media links", null, "theme-options");
  // Add single fields
	add_settings_field("facebook_link", "Facebook Link", "facebook_element", "theme-options", "social-section");
	// Automate saving of field to database
  register_setting("section", "facebook_link");
  // Add single fields
	add_settings_field("twitter_link", "Twitter Link", "twitter_element", "theme-options", "social-section");
	// Automate saving of field to database
  register_setting("section", "twitter_link");
  // Add single fields
	add_settings_field("yt_link", "Youtube Link", "yt_element", "theme-options", "social-section");
	// Automate saving of field to database
  register_setting("section", "yt_link");

}
add_action("admin_init", "display_theme_panel_fields");
