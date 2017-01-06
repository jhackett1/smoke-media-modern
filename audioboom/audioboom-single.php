<?php get_header('radio');
// Don't do anything unless API key is set
if (get_option('audioboom_api_key')) {
  // The API endpoint URL to fetch a single post snippet from its ID
    $url = 'http://audioboom.com/api/audio_clips/' . $audio_id;
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
    $audio_array = json_decode($result, true);

    $audio_source_url = $audio_array['body']['audio_clip']['urls']['detail'];
    $audio_category = get_site_url() . "/audios";
    ?>

<article class="limited-width audio" <?php post_class(); ?>>
	<main>
		<section class="meta">
			<h2><a href="<?php echo $audio_category; ?>">Best bits</a> / <?php echo $audio_array['body']['audio_clip']['title']; ?></h2>
			<hr class="big">
      <h5><?php echo human_time_diff( strtotime($audio_array['body']['audio_clip']['uploaded_at']), current_time('timestamp') ) . ' ago'; ?> &middot; <?php echo round($audio_array['body']['audio_clip']["duration"] / 60) . " mins"; ?> </h5>
      <hr>
		</section>
    <section class="contents">
    	<!-- Post content -->
      <iframe width="100%" height="300" style="background-color:transparent; display:block; max-width: 700px;" frameborder="0" allowtransparency="allowtransparency" scrolling="no" src="//embeds.<?php echo substr($audio_source_url, 8); ?>/embed/v4?eid=AQAAADY3Y1h2-FAA" title="audioBoom player"></iframe>
  		<p><?php echo $audio_array['body']['audio_clip']['description']; ?></p>
    </section>
    <hr>
    <!-- Share buttons-->
    <?php smoke_share_buttons(); ?>
    <hr class="big">
	</main>
	<sidebar>
    <?php dynamic_sidebar('radio'); ?>
	</sidebar>
</article>

<?php
// Finish the if statement
}
get_footer(); ?>
