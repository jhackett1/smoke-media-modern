<?php get_header();

?>

<h2 class="page-title limited-width"><?php echo single_cat_title(); ?></h2>
<hr class="limited-width">

<?php
// Create an empty array to store post IDs upon being looped through, preventing duplicate display
$do_not_replicate = array();
// Get the current category by checking the URL query vars
$current_cat = get_category( get_query_var( 'cat' ) );
// Get the cat ID out of that retrieved category object
$cat_id = $current_cat->cat_ID;
// Get the child category IDs and save them as an array var
$catlist = get_categories(
        array(
        'child_of' => $cat_id,
        'orderby' => 'id',
        'order' => 'DESC',
        'hide_empty' => '0',
        'fields' => 'ids'
        ) );
// Loop through the array of subcategory IDs, starting a WP_query for each
foreach ($catlist as $subcat_loop) {

    $title = get_cat_name($subcat_loop);
    // WP_Query arguments
    $args = array(
      'cat' => $subcat_loop
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
      <section id="featured" class="limited-width">
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
        <?php the_post_thumbnail('medium'); ?>
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
        <?php the_post_thumbnail('medium'); ?>
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
        <?php the_post_thumbnail('medium'); ?>
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



get_footer(); ?>
