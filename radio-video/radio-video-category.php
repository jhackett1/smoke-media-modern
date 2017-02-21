<?php get_header('radio');

// Don't do anything unless API key is set
if (get_option('youtube_api_key')) {
  // The API endpoint URL with max-results and API key specified by theme option variables
  $url = 'https://www.googleapis.com/youtube/v3/search?channelId=UCCG_RzmGLUFQsm4aVyh76KQ&pagetoken=&part=snippet&key=' . get_option('youtube_api_key') . '&order=date&maxResults=' . get_option('vid_number');

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
}

    if ($video_array) {
?>

<h2 class="limited-width page-title">Videos</h2>
<div class="limited-width">
<hr class="limited-width big" style="margin: 0 10px;"/>
</div>
<p class="limited-width category-desc">Videos from Smoke Radio events and projects.</p>
<ul class="videos limited-width">

<?php
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
  echo "</ul>";
// Display an empty container to fill with ajaxed content
  echo '<div id="ajax-container"></div>';
// Display a button to trigger the ajax call
  echo '<span class="button" id="more-posts">Load more</span>';
// And close out the loop completely
?>





<script>
// Client-side AJAX handler
  var ajaxUrl = '<?php echo admin_url('admin-ajax.php')?>';
  var next_page_token = '<?php echo $video_array["nextPageToken"]; ?>';

// On click, make the AJAX call and display response
  jQuery("#more-posts").on("click",function(){ // When btn is pressed.
      jQuery("#more-posts").attr("disabled",true); // Disable the button, temp.
      jQuery.post(ajaxUrl, {
          action: "more_radio_vids_ajax",
          token: next_page_token
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

get_footer();
