<?php
// Display HTML code of Typekit ID field
function news_block_element()
{
  ?>
    <input type="text" name="news_block" id="news_block" value="<?php echo get_option('news_block'); ?>" />
    <p class="description">Give the numerical ID of this section's category.</p>
  <?php
}
function comment_block_element()
{
  ?>
    <input type="text" name="comment_block" id="comment_block" value="<?php echo get_option('comment_block'); ?>" />
    <p class="description">Give the numerical ID of this section's category.</p>
  <?php
}
function interviews_block_element()
{
  ?>
    <input type="text" name="interviews_block" id="interviews_block" value="<?php echo get_option('interviews_block'); ?>" />
    <p class="description">Give the numerical ID of this section's category.</p>
  <?php
}
function reviews_block_element()
{
  ?>
    <input type="text" name="reviews_block" id="reviews_block" value="<?php echo get_option('reviews_block'); ?>" />
    <p class="description">Give the numerical ID of this section's category.</p>
  <?php
}
function features_block_element()
{
  ?>
    <input type="text" name="features_block" id="features_block" value="<?php echo get_option('features_block'); ?>" />
    <p class="description">Give the numerical ID of this section's category.</p>
  <?php
}
function sports_block_element()
{
  ?>
    <input type="text" name="sports_block" id="sports_block" value="<?php echo get_option('sports_block'); ?>" />
    <p class="description">Give the numerical ID of this section's category.</p>
  <?php
}


function display_front_page_panel_fields()
{
  // Create a section of fields
  add_settings_section("front_page", "Category block IDs", null, "front-page-sections");
  // Add a single field
  add_settings_field("news_block", "News block?", "news_block_element", "front-page-sections", "front_page");
  // Automate saving of field to database
  register_setting("front-page-fields", "news_block");

  // Add a single field
  add_settings_field("comment_block", "Comment block?", "comment_block_element", "front-page-sections", "front_page");
  // Automate saving of field to database
  register_setting("front-page-fields", "comment_block");

  // Add a single field
  add_settings_field("interviews_block", "Interviews block?", "interviews_block_element", "front-page-sections", "front_page");
  // Automate saving of field to database
  register_setting("front-page-fields", "interviews_block");

  // Add a single field
  add_settings_field("reviews_block", "Reviews block?", "reviews_block_element", "front-page-sections", "front_page");
  // Automate saving of field to database
  register_setting("front-page-fields", "reviews_block");

  // Add a single field
  add_settings_field("features_block", "Features block?", "features_block_element", "front-page-sections", "front_page");
  // Automate saving of field to database
  register_setting("front-page-fields", "features_block");

  // Add a single field
  add_settings_field("sports_block", "Sports block?", "sports_block_element", "front-page-sections", "front_page");
  // Automate saving of field to database
  register_setting("front-page-fields", "sports_block");

}
add_action("admin_init", "display_front_page_panel_fields");
