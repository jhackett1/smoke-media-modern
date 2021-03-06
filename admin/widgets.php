<?php

//Popular posts widget
class smoke_popular_widget extends WP_Widget {
  // Constructor to create new instance of class
  function __construct() {
    parent::__construct(
    // Base ID of your widget
    'smoke_popular_widget',
    // Widget name will appear in UI
    __('Smoke Popular Posts', 'wpb_widget_domain'),
    // Widget description
    array( 'description' => __( 'Display six recent popular posts', 'wpb_widget_domain' ), )
    );
  }

  // Creating widget front-end
  public function widget( $args, $instance ) {
    $title = apply_filters( 'widget_title', $instance['title'] );
    // Display pre-widget content, eg title
    echo $args['before_widget'];
    if ( ! empty( $title ) )
    echo $args['before_title'] . $title . $args['after_title'];

    // Widget content

    // Save the ID of the big post
    $queried_object = get_queried_object();
    $post_id = $queried_object->ID;

    $args = array(
			'meta_key'		=> 'smoke_post_views',
			'orderby'			=> 'meta_value_num',
      'cat'         => -309
		);
	  // Create the WP_query and pass in $cat parameter
	  $the_query = new WP_Query( $args );
	  if ( $the_query->have_posts() ) :
	  // Create a counter variable to track number of posts and set it to one
	  $counter = 1;
	  // Output a container <section> element
	  ?>
	    <ul>
	  <?php
	  // Start the loop
	  while ( $the_query->have_posts() ) : $the_query->the_post();
	  // Save post ID as var
	  $ID = get_the_ID();
    if ($ID === $post_id) { continue; };
	  // Stop looping after fourth post
	  if ($counter>4) { break; };
	  // Display posts, conditional on $counter value
	  ?>

		<li>
      <?php the_post_thumbnail('thumbnail'); ?>
			<div>
				<h3><?php the_title(); ?></h3>
			</div>
			<a class="cover" href="<?php the_permalink(); ?>"></a>
		</li>

	  <?php
	  // Increase the counter with every post to keep an accurate count
	  $counter++;
	  // Finish looping
	  endwhile;
	  // Clean up after WP_Query
	  wp_reset_postdata();
	  // Close the container element

	  ?>
	    </ul>
    </div>
    <?php
    else :
    ?>
    <?php endif;
    // Display post-widget content, eg title
  }

  // Save backend form options
  public function form( $instance ) {
    if ( isset( $instance[ 'title' ] ) ) {
      $title = $instance[ 'title' ];
    } else {
      $title = __( 'New title', 'wpb_widget_domain' );
    }
    // Display backend form options
    ?>
    <p>
      <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
      <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
    </p>
    <?php
  }

  // Update the widget in customiser on the fly
  public function update( $new_instance, $old_instance ) {
    $instance = array();
    $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
    return $instance;
  }
}
// Class smoke_popular_widget ends here


//Videos widget
class smoke_video_widget extends WP_Widget {
  // Constructor to create new instance of class
  function __construct() {
    parent::__construct(
    // Base ID of your widget
    'smoke_video_widget',
    // Widget name will appear in UI
    __('Smoke Video Widget', 'wpb_widget_domain'),
    // Widget description
    array( 'description' => __( 'Display three recent videos', 'wpb_widget_domain' ), )
    );
  }

  // Creating widget front-end
  public function widget( $args, $instance ) {
    $title = apply_filters( 'widget_title', $instance['title'] );
    // Display pre-widget content, eg title
    echo $args['before_widget'];
    if ( ! empty( $title ) )
    echo $args['before_title'] . $title . $args['after_title'];

    // Widget content

    // Don't do anything unless API key is set
    if (get_option('youtube_api_key')) {
      // The API endpoint URL with max-results and API key specified by theme option variables
      $url = 'https://www.googleapis.com/youtube/v3/search?channelId=UCxxVjVWC381ysuaZc9dgU1Q&part=snippet&key=' . get_option('youtube_api_key') . '&order=date&maxResults=3';
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

      if ($video_array) {
    }

    // Create a counter variable and leave it at 1 for now
    $counter = 1;
    echo '<ul>';
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
    echo '</ul>';
    }
    // Display post-widget content, eg title
    echo $args['after_widget'];
  }

  // Save backend form options
  public function form( $instance ) {
    if ( isset( $instance[ 'title' ] ) ) {
      $title = $instance[ 'title' ];
    } else {
      $title = __( 'New title', 'wpb_widget_domain' );
    }
    // Display backend form options
    ?>
    <p>
      <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
      <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
    </p>
    <?php
  }

  // Update the widget in customiser on the fly
  public function update( $new_instance, $old_instance ) {
    $instance = array();
    $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
    return $instance;
  }
}
// Class video_widget ends here

//Subscribe widget
class smoke_subscribe_widget extends WP_Widget {
  // Constructor to create new instance of class
  function __construct() {
    parent::__construct(
    // Base ID of your widget
    'smoke_subscribe_widget',
    // Widget name will appear in UI
    __('Smoke Subscribe Widget', 'wpb_widget_domain'),
    // Widget description
    array( 'description' => __( 'Subscribe to the Smoke mailing list.', 'wpb_widget_domain' ), )
    );
  }

  // Creating widget front-end
  public function widget( $args, $instance ) {
    $title = apply_filters( 'widget_title', $instance['title'] );
    // Display pre-widget content, eg title
    echo $args['before_widget'];
    if ( ! empty( $title ) )
    echo $args['before_title'] . $title . $args['after_title'];

    // Widget content
		?>
		<div id="mc_embed_signup">
  		<form action="//media.us13.list-manage.com/subscribe/post?u=bae3fdf7dc6f735f144847240&amp;id=ffaab9e48d" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
        <div id="mc_embed_signup_scroll">
    			<input type="email" value="" name="EMAIL" class="email" id="mce-EMAIL" placeholder="Email" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Email'" required>
    		  <input type="submit" value="Subscribe" name="subscribe" id="mc-embedded-subscribe" class="button">
          <div class="mc-field-group input-group" style="display: none;">
            <ul>
              <li><input type="checkbox" value="1" name="group[7153][1]" id="mce-group[7153]-7153-0" checked><label for="mce-group[7153]-7153-0">QH</label></li>
              <li><input type="checkbox" value="2" name="group[7153][2]" id="mce-group[7153]-7153-1" checked><label for="mce-group[7153]-7153-1">Magazine</label></li>
              <li><input type="checkbox" value="4" name="group[7153][4]" id="mce-group[7153]-7153-2" checked><label for="mce-group[7153]-7153-2">Radio</label></li>
              <li><input type="checkbox" value="8" name="group[7153][8]" id="mce-group[7153]-7153-3" checked><label for="mce-group[7153]-7153-3">TV</label></li>
            </ul>
          </div>
    		  <div style="position: absolute; left: -5000px;" aria-hidden="true"><input type="text" name="b_bae3fdf7dc6f735f144847240_ffaab9e48d" tabindex="-1" value=""></div>
  		  </div>
        <p>Get on our mailing list to contribute.</p>
  		</form>
		</div>

		<?php
    // Display post-widget content, eg title
    echo $args['after_widget'];
  }

  // Save backend form options
  public function form( $instance ) {
    if ( isset( $instance[ 'title' ] ) ) {
      $title = $instance[ 'title' ];
    } else {
      $title = __( 'New title', 'wpb_widget_domain' );
    }
    // Display backend form options
    ?>
    <p>
      <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
      <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
    </p>
    <?php
  }

  // Update the widget in customiser on the fly
  public function update( $new_instance, $old_instance ) {
    $instance = array();
    $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
    return $instance;
  }
}
// Class video_widget ends here


//Audioboom widget
class smoke_audio_widget extends WP_Widget {
  // Constructor to create new instance of class
  function __construct() {
    parent::__construct(
    // Base ID of your widget
    'smoke_audio_widget',
    // Widget name will appear in UI
    __('Smoke Audioboom Widget', 'wpb_widget_domain'),
    // Widget description
    array( 'description' => __( 'Display three recent Audioboom podcasts', 'wpb_widget_domain' ), )
    );
  }

  // Creating widget front-end
  public function widget( $args, $instance ) {
    $title = apply_filters( 'widget_title', $instance['title'] );
    // Display pre-widget content, eg title
    echo $args['before_widget'];
    if ( ! empty( $title ) )
    echo $args['before_title'] . $title . $args['after_title'];

    // Widget content

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
    }
    if ($boo_array) {
      echo "";
    // Create a counter variable and leave it at 1 for now
      $counter = 1;
      echo '<ul>';
    // Get every video, store as array $video and display in a loop
      foreach($boo_array["body"]["audio_clips"] as $boo){
        // Stop looping after third post
        if ($counter>3) { break; };
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
    echo '</ul>';
  }
    // Display post-widget content, eg title
    echo $args['after_widget'];
  }

  // Save backend form options
  public function form( $instance ) {
    if ( isset( $instance[ 'title' ] ) ) {
      $title = $instance[ 'title' ];
    } else {
      $title = __( 'New title', 'wpb_widget_domain' );
    }
    // Display backend form options
    ?>
    <p>
      <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
      <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
    </p>
    <?php
  }

  // Update the widget in customiser on the fly
  public function update( $new_instance, $old_instance ) {
    $instance = array();
    $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
    return $instance;
  }
}
// Class audio_widget ends here






//Subscribe widget
class smoke_tweets_widget extends WP_Widget {
  // Constructor to create new instance of class
  function __construct() {
    parent::__construct(
    // Base ID of your widget
    'smoke_tweets_widget',
    // Widget name will appear in UI
    __('Smoke Twitter Widget', 'wpb_widget_domain'),
    // Widget description
    array( 'description' => __( 'See recent tweets from Smoke.', 'wpb_widget_domain' ), )
    );
  }

  // Creating widget front-end
  public function widget( $args, $instance ) {
    $title = apply_filters( 'widget_title', $instance['title'] );
    // Display pre-widget content, eg title
    echo $args['before_widget'];
    if ( ! empty( $title ) )
    echo $args['before_title'] . $title . $args['after_title'];

    // Widget content
		?>
    <a class="twitter-timeline" data-chrome="transparent noheader nofooter" data-height="500" href="https://twitter.com/dinosaurlord/lists/smoke"></a> <script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>
		<?php
    // Display post-widget content, eg title
    echo $args['after_widget'];
  }

  // Save backend form options
  public function form( $instance ) {
    if ( isset( $instance[ 'title' ] ) ) {
      $title = $instance[ 'title' ];
    } else {
      $title = __( 'New title', 'wpb_widget_domain' );
    }
    // Display backend form options
    ?>
    <p>
      <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
      <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
    </p>
    <?php
  }

  // Update the widget in customiser on the fly
  public function update( $new_instance, $old_instance ) {
    $instance = array();
    $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
    return $instance;
  }
}
// Class video_widget ends here





















//Subscribe widget
class smoke_jobs_widget extends WP_Widget {
  // Constructor to create new instance of class
  function __construct() {
    parent::__construct(
    // Base ID of your widget
    'smoke_jobs_widget',
    // Widget name will appear in UI
    __('Smoke Jobs Widget', 'wpb_widget_domain'),
    // Widget description
    array( 'description' => __( 'See recent jobs, powered by Journalism.co.uk.', 'wpb_widget_domain' ), )
    );
  }

  // Creating widget front-end
  public function widget( $args, $instance ) {
    $title = apply_filters( 'widget_title', $instance['title'] );
    // Display pre-widget content, eg title
    echo $args['before_widget'];
    if ( ! empty( $title ) )
    echo $args['before_title'] . $title . $args['after_title'];

    // Widget content
    // This is where the data comes from
    $url = 'http://www.holdthefrontpage.co.uk/jobsboard/rss/all/';
    // Get a response from the RSS feed using cURL
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
    // Get the XML as a var
    $xml=simplexml_load_string($result) or die();
    // Turn the XML into JSON
    $json = json_encode($xml);
    // Then turn the JSON into an array
    $array = json_decode($json, true);
    // Create a counter
    $counter = 1;
    // Container
    echo "<ul class='jobs'>";
    foreach ($array["channel"]["item"] as $job) {
      // Process added date
      $added = substr($job['pubDate'], 0, -15);
      // Stop after fifth loop
      if ($counter>4) { break; };
      echo "<li class='job'>";
      echo "<h4>" . $job['title'] . "</h4>";
      echo "<a class='cover' target='blank' href=" . $job['link'] . "></a>";
      echo "<p>Added " . $added . "</p>";
      echo "</li>";
      // Iterate counter
      $counter++;
    }
    // Close container
    echo "</ul>";
    echo "<a href='http://www.holdthefrontpage.co.uk' target='blank'><span>More on Hold the Front Page<i class='fa fa-arrow-right'></i></span></a>";
    // Display post-widget content, eg title
    echo $args['after_widget'];
  }

  // Save backend form options
  public function form( $instance ) {
    if ( isset( $instance[ 'title' ] ) ) {
      $title = $instance[ 'title' ];
    } else {
      $title = __( 'New title', 'wpb_widget_domain' );
    }
    // Display backend form options
    ?>
    <p>
      <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
      <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
    </p>
    <?php
  }

  // Update the widget in customiser on the fly
  public function update( $new_instance, $old_instance ) {
    $instance = array();
    $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
    return $instance;
  }
}
// Class video_widget ends here















// Register and load the widgets
function smoke_load_widgets() {
	register_widget( 'smoke_video_widget' );
  register_widget( 'smoke_subscribe_widget' );
  register_widget( 'smoke_popular_widget' );
  register_widget( 'smoke_audio_widget' );
  register_widget( 'smoke_tweets_widget' );
    register_widget( 'smoke_jobs_widget' );
}
add_action( 'widgets_init', 'smoke_load_widgets' );
