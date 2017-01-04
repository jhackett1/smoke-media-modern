<?php
// Don't do anything unless API key is set
if (get_option('youtube_api_key')) {

  // The API endpoint URL with max-results and API key specified by theme option variables
    $url = 'https://www.googleapis.com/youtube/v3/search?channelId=UCxxVjVWC381ysuaZc9dgU1Q&part=snippet&key=' . get_option('youtube_api_key') . '&order=date&maxResults=' . get_option('vid_number');
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
    ?>


    <section id="videos">
      <section class="limited-width">
        <h2 class='section-title limited-width'>Smoke TV</h2>

          <ul class="slider" id="video-slider">

          <?php
          // Create a counter variable and leave it at 1 for now
            $counter = 1;
          // Get every video, store as array $video and display in a loop
            foreach($video_array["items"] as $video){

              // Set the description as a var
              $description = $video["snippet"]["description"];
              // Shorten the descriptions to a sensible length
              if (strlen($description) > 100) {
                  $descriptionCut = substr($description, 0, 100);
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
           ?>

          </ul>
         <div class="slide-nav">
           <span id="slide-back" class="button"><i class="fa fa-caret-left"></i></span>
           <span id="slide-forward" class="button"><i class="fa fa-caret-right"></i></span>
         </div>
       </section>
    </section>
    <?php

// End the if statement
}
