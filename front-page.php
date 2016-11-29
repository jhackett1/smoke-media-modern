<? get_header();

// Display the weather and date
the_weather();

// Make an empty array to store post IDs, avoiding replicate post display
$do_not_replicate = array();

// Display a block of posts
function headlines_section($cat, $title, &$do_not_replicate){
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
    <section class="limited-width headlines">
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
  // Display
  ?>

  <?php
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
headlines_section('news', 0, $do_not_replicate);

get_footer(); ?>
