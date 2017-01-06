<?php
// Don't do anything unless API key is set
  if (get_option('audioboom_api_key')) {

    // The API endpoint URL
      $url = 'http://audioboom.com/api/audio_clips?username=smokeradio';

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
      <section id="audio">
        <section class="limited-width">
          <h2 class='section-title limited-width'>Best Bits</h2>

            <ul class="slider" id="video-slider">

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
                    <h5><?php echo $duration; ?></h5>
                    <span class="play-icon"><i class="fa fa-headphones"></i></span>
                    <a class="cover" href="<?php echo $audio_permalink; ?>"></a>
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
      }
  // End the if statement
  }
