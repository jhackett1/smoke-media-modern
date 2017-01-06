<?php

  // Display a block of posts
  function campaign_block($cat, $title , &$do_not_replicate){
    // Create the WP_query and pass in $cat parameter
    $the_query = new WP_Query( array('cat' => $cat ) );
    if ( $the_query->have_posts() ) :
    // Create a counter variable to track number of posts and set it to one
    $counter = 1;
    // If title parameter is set, display the string as a <h2>
    if($title){
      echo "<h2 class='section-title limited-width'>" . $title . "</h2>";
    }
    // Output a container <section> element
    ?>
      <ul class="limited-width headline-block wow fadeIn animated" data-wow-duration="0.3s">
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
    // Display posts, conditional on $counter value
    ?>
    <?php if ($counter<3):
      //Display first two posts like so
    ?>
      <li class="headline-item wow fadeIn animated" data-wow-duration="0.3s">
        <?php the_post_thumbnail('large'); ?>
        <h3><?php the_title(); ?></h3>
        <?php the_category(); ?>
        <div class="grad"></div>
        <a class="cover" href="<?php the_permalink(); ?>"></a>
      </li>
    <?php elseif ($counter === 3):
      //The third post, with the opening horizontal container
    ?>
      <ul class="horizontal-list">
        <li class="horizontal-headline-item">
          <?php the_post_thumbnail('medium'); ?>
          <div>
            <h3><?php the_title(); ?></h3>
            <?php the_excerpt(); ?>
          </div>
          <a class="cover" href="<?php the_permalink(); ?>"></a>
        </li>
    <?php else:
      //The fourth/last post, with the closing horizontal container
    ?>
        <li class="horizontal-headline-item">
          <?php the_post_thumbnail('medium'); ?>
          <div>
            <h3><?php the_title(); ?></h3>
            <?php the_excerpt(); ?>
          </div>
          <a class="cover" href="<?php the_permalink(); ?>"></a>
        </li>
      </ul>
    <?php endif; ?>

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
    <?php
    // What if there are no posts returned?
    else :
    ?>
    	<p><?php _e( 'Sorry, no posts matched your criteria.' ); ?></p>
    <?php endif;
  }
