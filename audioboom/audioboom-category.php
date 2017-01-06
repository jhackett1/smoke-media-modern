<?php get_header('radio');

// Don't do anything unless API key is set
  if (get_option('audioboom_api_key')) {

    // The API endpoint URL
      $url = 'http://audioboom.com/api/audio_clips?username=smokeradio&page[items]=9';

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

    if ($boo_array) {
?>

<h2 class="limited-width page-title">Best Bits</h2>
<div class="limited-width">
<hr class="limited-width big" style="margin: 0 10px;"/>
</div>
<p class="limited-width category-desc">Highlights of Smoke Radio, via Audioboom</p>
<ul class="videos limited-width">

<?php
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

// Display an empty container to fill with ajaxed content
  echo '<div id="ajax-container"></div>';
// Display a button to trigger the ajax call
  echo '<span class="button" id="more-posts">Load more</span>';
// And close out the loop completely
?>

</ul>

<script>
// Client-side AJAX handler
  var ajaxUrl = '<?php echo admin_url('admin-ajax.php')?>';
  var page = 2;
// On click, make the AJAX call and display response
  jQuery("#more-posts").on("click",function(){ // When btn is pressed.
      jQuery("#more-posts").attr("disabled",true); // Disable the button, temp.
      jQuery.post(ajaxUrl, {
          action: "more_audio_ajax",
          page: page
      }).success(function(posts){
          jQuery("#ajax-container").append(posts);
          jQuery("#more_posts").attr("disabled",false);
      });
  });
</script>

<?php
} else{
  ?>
  <h3 id="notfound"><?php _e( "Sorry, we couldn't find what you're looking for." ); ?></h3>
  <?php
}

}
get_footer();
