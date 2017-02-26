<?php get_header(); ?>

<h2 class="limited-width page-title"><?php  single_cat_title(); ?></h2>
<div class="limited-width">
<hr class="limited-width big" style="margin: 0 10px;"/>
</div>
<p class="limited-width category-desc"><?php echo strip_tags(category_description()); ?> </p>

<?php
// Make an empty array to store post IDs, avoiding replicate post display
$do_not_replicate = array();

// Get the current category ID and save as var
$current_cat = get_query_var('cat');

// Begin the loop
if (have_posts() ):
// Create a counter variable to keep track of post numbers
$counter = 1;
if(have_posts()){
  echo "<h2 class='section-title limited-width'>All " . get_cat_name($current_cat) . "</h2>";
}
?>
  <ul id="category" class="limited-width headline-block wow fadeIn animated elections">
<?php
  // Start looping
  while ( have_posts() ): the_post();
    // Save post ID as var
    $ID = get_the_ID();
    // If current post ID exists in array, skip post and continue with loop
    if (in_array($ID, $do_not_replicate)) { continue; };
    // Save current post ID to array
    array_push($do_not_replicate, $ID);
    ?>
    <!-- Display output here -->
    <li class="headline-item">
      <?php the_post_thumbnail('large'); ?>
      <h3><?php the_title(); ?></h3>
      <div class="grad"></div>
      <a class="cover" href="<?php the_permalink(); ?>"></a>
    </li>
    <?php
    // Advance the counter by one with each post
    $counter++;
    // Finish looping
  endwhile;
  // Fix the annoying unclosed markup problem that happens if only three posts are retrieved
  if ($counter === 4 || $counter === 6 ) {
    ?>
    <li class="horizontal-headline-item" style="background-color:rgba(0,0,0,0)">
    </li>
    </ul>
    <?php
  }
?>
  </ul>

<?php
endif;


get_footer();
