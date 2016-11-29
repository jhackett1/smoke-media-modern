<? get_header();

// Display the weather and date
the_weather();

// Make an empty array to store post IDs, avoiding replicate post display
$do_not_replicate = array();

// A function for display of a section of posts, accepting a category ID, title string and the $do_not_replicate array as parameters
function frontpage_posts_section($cat, $title, &$do_not_replicate){
  // WP_Query arguments
  $args = array(
    'cat' => $cat
  );
  // Create the WP_query
  $the_query = new WP_Query( $args );
  if ( $the_query->have_posts() ) :
  // Create a counter variable to track number of posts
  $counter = 1;
  // If title parameter is set, display the string as a <h2>
  if($title){
  echo "<h2 class='section-title limited-width'>" . $title . "</h2>";
  }
  // Output a container <section> element
  ?>
    <section class="limited-width post-box">
  <?php
  // Start the loop
  while ( $the_query->have_posts() ) : $the_query->the_post();
  // Save post ID as var
  $ID = get_the_ID();
  // If current post ID exists in array, skip post and continue with loop
  if (in_array($ID, $do_not_replicate)) { continue; };
  // Stop looping after fourth post
  if ($counter>4) { break; };
  // Save current post ID to array
  array_push($do_not_replicate, $ID);
  // Style the first two posts this way
  if ($counter<3){
  // Display first two posts as big tiles
  ?>
    <div class="post tile">
      <?php the_post_thumbnail('large'); ?>
      <h3><?php the_title(); ?></h3>
      <?php the_category(); ?>
      <div class="grad"></div>
      <a class="cover" href="<?php the_permalink(); ?>"></a>
    </div>
  <?php
  }elseif($counter===3){
  // And third like this, with a container element
  ?>
  <div class="horizontaliser">
    <div class="post list">
      <?php the_post_thumbnail('large'); ?>
      <div>
        <h3><?php the_title(); ?></h3>
        <?php the_excerpt(); ?>
      </div>
      <a class="cover" href="<?php the_permalink(); ?>"></a>
    </div>
  <?php
  }else{
  // And last/fourth like this
  ?>
    <div class="post list">
      <?php the_post_thumbnail('large'); ?>
      <div>
        <h3><?php the_title(); ?></h3>
        <?php the_excerpt(); ?>
      </div>
      <a class="cover" href="<?php the_permalink(); ?>"></a>
    </div>
  </div>
  <?php
  }
  // Increase the counter with every post to keep an accurate count
  $counter++;
  // Finish looping
  endwhile;
  // Clean up after WP_Query
  wp_reset_postdata();
  // Close the container element
  ?>
    </section>
  <?php
  // What if there are no posts returned?
  else :
  ?>
  	<p><?php _e( 'Sorry, no posts matched your criteria.' ); ?></p>
  <?php endif;
}

// More specialised function to display a slightly different section meant for news posts
function frontpage_news_posts_section($cat, $title, &$do_not_replicate){
  // WP_Query arguments
  $args = array(
    'cat' => $cat
  );
  // Create the WP_query
  $the_query = new WP_Query( $args );
  if ( $the_query->have_posts() ) :
  // Create a counter variable to track number of posts
  $counter = 1;
  // If title parameter is set, display the string as a <h2>
  if($title){
  echo "<h2 class='section-title limited-width'>" . $title . "</h2>";
  }
  // Output a container <section> element
  ?>
    <section class="limited-width post-box">
  <?php
  // Start the loop
  while ( $the_query->have_posts() ) : $the_query->the_post();
  // Save post ID as var
  $ID = get_the_ID();
  // If current post ID exists in array, skip post and continue with loop
  if (in_array($ID, $do_not_replicate)) { continue; };
  // Stop looping after fourth post
  if ($counter>5) { break; };
  // Save current post ID to array
  array_push($do_not_replicate, $ID);
  // Style the first two posts this way
  if ($counter===1){
  // Display first post as big tiles
  ?>
    <div class="post tile">
      <?php the_post_thumbnail('large'); ?>
      <h3><?php the_title(); ?></h3>
      <?php the_category(); ?>
      <div class="grad"></div>
      <a class="cover" href="<?php the_permalink(); ?>"></a>
    </div>
  <?php
}elseif($counter===2 or $counter===4){
  // And 2nd and 4th like this
  ?>
  <div class="horizontaliser">
    <div class="post list">
      <?php the_post_thumbnail('large'); ?>
      <div>
        <h3><?php the_title(); ?></h3>
        <?php the_excerpt(); ?>
      </div>
      <a class="cover" href="<?php the_permalink(); ?>"></a>
    </div>
  <?php
  }else{
  // And last/fourth like this
  ?>
    <div class="post list">
      <?php the_post_thumbnail('large'); ?>
      <div>
        <h3><?php the_title(); ?></h3>
        <?php the_excerpt(); ?>
      </div>
      <a class="cover" href="<?php the_permalink(); ?>"></a>
    </div>
  </div>
  <?php
  }
  // Increase the counter with every post to keep an accurate count
  $counter++;
  // Finish looping
  endwhile;
  // Clean up after WP_Query
  wp_reset_postdata();
  // Close the container element
  ?>
    </section>
  <?php
  // What if there are no posts returned?
  else :
  ?>
  	<p><?php _e( 'Sorry, no posts matched your criteria.' ); ?></p>
  <?php endif;
}

// More specialised function to display a slightly different section meant for news posts
function promoted_posts_section($title, &$do_not_replicate){
  // WP_Query arguments
  $args = array(
  	'meta_key'		=> 'smoke_promoted',
  	'meta_value'	=> 'on'
  );
  // Create the WP_query
  $the_query = new WP_Query( $args );
  if ( $the_query->have_posts() ) :
  // Create a counter variable to track number of posts
  $counter = 1;
  // If title parameter is set, display the string as a <h2>
  if($title){
  echo "<h2 class='section-title limited-width'>" . $title . "</h2>";
  }
  // Output a container <section> element
  ?>
    <section class="limited-width post-box">
  <?php
  // Start the loop
  while ( $the_query->have_posts() ) : $the_query->the_post();
  // Save post ID as var
  $ID = get_the_ID();
  // If current post ID exists in array, skip post and continue with loop
  if (in_array($ID, $do_not_replicate)) { continue; };
  // Stop looping after fourth post
  if ($counter>4) { break; };
  // Save current post ID to array
  array_push($do_not_replicate, $ID);
  // Style the first two posts this way
  if ($counter<3){
  // Display first two posts as big tiles
  ?>
    <div class="post tile">
      <?php the_post_thumbnail('large'); ?>
      <h3><?php the_title(); ?></h3>
      <?php the_category(); ?>
      <div class="grad"></div>
      <a class="cover" href="<?php the_permalink(); ?>"></a>
    </div>
  <?php
  }elseif($counter===3){
  // And third like this, with a container element
  ?>
  <div class="horizontaliser">
    <div class="post list">
      <?php the_post_thumbnail('large'); ?>
      <div>
        <h3><?php the_title(); ?></h3>
        <?php the_excerpt(); ?>
      </div>
      <a class="cover" href="<?php the_permalink(); ?>"></a>
    </div>
  <?php
  }else{
  // And last/fourth like this
  ?>
    <div class="post list">
      <?php the_post_thumbnail('large'); ?>
      <div>
        <h3><?php the_title(); ?></h3>
        <?php the_excerpt(); ?>
      </div>
      <a class="cover" href="<?php the_permalink(); ?>"></a>
    </div>
  </div>
  <?php
  }
  // Increase the counter with every post to keep an accurate count
  $counter++;
  // Finish looping
  endwhile;
  // Clean up after WP_Query
  wp_reset_postdata();
  // Close the container element
  ?>
    </section>
  <?php
  // What if there are no posts returned?
  else :
  ?>
  	<p><?php _e( 'Sorry, no posts matched your criteria.' ); ?></p>
  <?php endif;
}

// More specialised function to display a slightly different section meant for news posts
function frontpage_comment_posts_section($cat, $title, &$do_not_replicate){
  // WP_Query arguments
  $args = array(
    'cat' => $cat
  );
  // Create the WP_query
  $the_query = new WP_Query( $args );
  if ( $the_query->have_posts() ) :
  // Create a counter variable to track number of posts
  $counter = 1;
  // If title parameter is set, display the string as a <h2>
  if($title){
  echo "<h2 class='section-title limited-width'>" . $title . "</h2>";
  }
  // Output a container <section> element
  ?>
    <section id="comment" class="limited-width post-box">
  <?php
  // Start the loop
  while ( $the_query->have_posts() ) : $the_query->the_post();
  // Save post ID as var
  $ID = get_the_ID();
  // If current post ID exists in array, skip post and continue with loop
  if (in_array($ID, $do_not_replicate)) { continue; };
  // Stop looping after fourth post
  if ($counter>5) { break; };
  // Save current post ID to array
  array_push($do_not_replicate, $ID);
  // Style the first two posts this way
  if ($counter===1){
  // Display first post as big tiles
  ?>
    <div class="post tile">
      <?php the_post_thumbnail('large'); ?>
      <h3><?php the_title(); ?></h3>
      <?php the_category(); ?>
      <div class="grad"></div>
      <a class="cover" href="<?php the_permalink(); ?>"></a>
    </div>
  <?php
}elseif($counter===2 or $counter===4){
  // And 2nd and 4th like this
  ?>
  <div class="horizontaliser">
    <div class="comment post list">
      <div>
        <h3><?php the_title(); ?></h3>
        <?php the_excerpt(); ?>
      </div>
      <a class="cover" href="<?php the_permalink(); ?>"></a>
    </div>
  <?php
  }else{
  // And last/fourth like this
  ?>
    <div class="comment post list">
      <div>
        <h3><?php the_title(); ?></h3>
        <?php the_excerpt(); ?>
      </div>
      <a class="cover" href="<?php the_permalink(); ?>"></a>
    </div>
  </div>
  <?php
  }
  // Increase the counter with every post to keep an accurate count
  $counter++;
  // Finish looping
  endwhile;
  // Clean up after WP_Query
  wp_reset_postdata();
  // Close the container element
  ?>
    </section>
  <?php
  // What if there are no posts returned?
  else :
  ?>
  	<p><?php _e( 'Sorry, no posts matched your criteria.' ); ?></p>
  <?php endif;
}






// Call the functions and populat the homepage
  promoted_posts_section(0, $do_not_replicate);
  frontpage_news_posts_section(2, 'News', $do_not_replicate);
  get_template_part('youtube/youtube-section');
  frontpage_comment_posts_section(9, 'Comment', $do_not_replicate);
  frontpage_posts_section(4, 'Features', $do_not_replicate);
  frontpage_posts_section(40, 'Sport', $do_not_replicate);

?>




<?php get_footer(); ?>
