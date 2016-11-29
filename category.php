<?get_header();?>
<h2 class="limited-width page-title"><?php single_cat_title(); ?></h2>
<hr class="limited-width"/>
<p class="limited-width category-desc"><?php echo strip_tags(category_description()); ?> </p>
<?php

// Make an empty array to store post IDs, avoiding replicate post display
$do_not_replicate = array();


//
//
//
// Start by checking if subcategories exist. If so, display each separately by getting ID array, then using foreach loop and WP_Query
//
//
//

// Get the current category ID and save as var
$current_cat = get_query_var('cat');
echo 'Current category ID: ' . $current_cat . '<br>';
// Save subcategory IDs to array which WP_Query can loop through
$subcats = get_term_children( $current_cat, 'category' );
// Loop through subcat IDs
foreach ($subcats as $subcat) {
  // Set up query arguments
  $args = array(
    'cat' => $subcat,
    'posts_per_page' => 4
  );
  // Create the query object
  $subcat_query = new WP_Query( $args );
  // Begin the loop
  if ( $subcat_query->have_posts() ):
  // Create a counter variable to keep track of post numbers
  $counter = 1;
    // Start looping
    while ( $subcat_query->have_posts() ): $subcat_query->the_post();
      // Save post ID as var
      $ID = get_the_ID();
      // Save current post ID to array
      array_push($do_not_replicate, $ID);
      ?>
      <!--  -->
      <!-- Display output here -->
      <!--  -->
      <?php
      // Advance the counter by one with each post
      $counter++;
      // Finish looping
    endwhile;
  // And close out the loop completely
  endif;
}

//
//
// Now, display posts without any subcategories in a standard loop
//
//

if (have_posts() ) :
$counter = 1;
?>
  <section class="limited-width post-box">
<?php
// Start the loop
while (have_posts() ) : the_post();

// Save post ID as var
$ID = get_the_ID();
// Stop looping after fourth post
if ($counter>8) { break; };
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
  }elseif($counter === 4){
  // And fourth like this
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
  </section>
  <?php
  }elseif($counter === 5){
  // And fifth like this
  ?>
  <section class="limited-width post-box">
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
  }elseif($counter === 6){
  // Sixth like this
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
  }elseif($counter===7){
  // Seventh like this
  ?>
  <div class="post tile">
    <?php the_post_thumbnail('large'); ?>
    <h3><?php the_title(); ?></h3>
    <?php the_category(); ?>
    <div class="grad"></div>
    <a class="cover" href="<?php the_permalink(); ?>"></a>
  </div>
  <?php
  }elseif($counter===8){
  // Eighth like this
  ?>
  <div class="post tile">
    <?php the_post_thumbnail('large'); ?>
    <h3><?php the_title(); ?></h3>
    <?php the_category(); ?>
    <div class="grad"></div>
    <a class="cover" href="<?php the_permalink(); ?>"></a>
  </div>
  </section>
  <?php
}

// Increase the counter with every post to keep an accurate count
$counter++;
// Finish looping
endwhile;
// Close the container element
?>
  </section>
<?php
// What if there are no posts returned?
else :
?>
	<p><?php _e( 'Sorry, no posts matched your criteria.' ); ?></p>
<?php
endif;


get_footer();
