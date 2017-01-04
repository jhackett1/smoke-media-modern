<?php get_header();

echo get_query_var("video");

// Don't do anything unless API key is set
if (get_option('youtube_api_key')) {

  // The API endpoint URL to fetch a single post snippet from its ID

     $url = 'https://www.googleapis.com/youtube/v3/videos?id=' . $yt_id . '&part=snippet&key=' . get_option('youtube_api_key');

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

    // Take the ID and make it into a playable URL for jwplayer
    $yt_url = 'https://www.youtube.com/watch?v=' . $yt_id;

    // Create a title and save as a var
    $video_title = $video_array["items"][0]["snippet"]["title"];

    $vid_category = get_site_url() . "/videos";



echo get_query_var('video');

?>


<article class="limited-width video" <?php post_class(); ?>>
	<main>
		<section class="meta">
			<h2><a href="<?php echo $vid_category; ?>">TV</a> / <?php echo $video_title; ?></h2>
			<hr class="big">
      <h5><?php echo human_time_diff( strtotime($video_array["items"][0]["snippet"]["publishedAt"]), current_time('timestamp') ) . ' ago'; ?> </h5>
      <hr>
		</section>
    <section class="contents">
    	<!-- Post content -->
      <div id="videoPlayer">Loading the video player</div>
			<script type="text/javascript">
				var playerInstance = jwplayer("videoPlayer");
				playerInstance.setup({
				file: "<?php echo $yt_url; ?>",
        image: "<?php echo $video_array["items"][0]["snippet"]["thumbnails"]["standard"]["url"]; ?>",
				width: 640,
				height: 360,
				name: 'smokeplayerskin',
        stretching: "fill",
        autostart: 1
				});
			</script>
  		<p><?php echo $video_array["items"][0]["snippet"]["description"]; ?></p>

    </section>
    <hr>
    <!-- Share buttons-->
    <?php smoke_share_buttons(); ?>
    <hr class="big">
	</main>
	<sidebar>
    <?php dynamic_sidebar('video'); ?>
	</sidebar>
</article>


<?php
// Finish the if statement
}
get_footer(); ?>
