<?php
// Smoke Radio custom homepage

// Fetch the custom branded header
get_header('radio');
// Make an empty array to store post IDs, avoiding replicate post display
$do_not_replicate = array();


// Display a block of posts
function headlines_section($cat, $title, &$do_not_replicate){
  // Create the WP_query and pass in $cat parameter
  $the_query = new WP_Query( array('meta_key'		=> 'smoke_promoted', 'meta_value'	=> 'on', 'cat' => $cat ) );
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

headlines_section(308, '', $do_not_replicate);
get_template_part('audioboom/audioboom-section');

?>

<section id="shows-twitter" class="limited-width" style="margin-bottom: 30px">
  <aside>
    <?php
        // Display a block of posts
        function interview_headlines_section($cat, $title, &$do_not_replicate){
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
            <ul class="headline-block wow fadeIn animated" data-wow-duration="0.3s" id="interviews">
          <?php
          // Start the loop
          while ( $the_query->have_posts() ) : $the_query->the_post();
          // Save post ID as var
          $ID = get_the_ID();
          // If current post ID exists in array, skip post and continue with loop
          if (in_array($ID, $do_not_replicate)) { continue; };
          // Stop looping after fourth post
          if ($counter>6) { break; };
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
          <?php elseif ($counter === 3 || $counter === 5):
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

      interview_headlines_section(308, 'Latest', $do_not_replicate);
  ?>

  </aside>
  <aside class="padded">
    <?php dynamic_sidebar('radio-home'); ?>
  </aside>
</section>
<?php
get_footer();
