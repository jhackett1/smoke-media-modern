<?get_header();?>
<h2 class="limited-width page-title"><span>Results / </span><?php echo get_search_query(); ?></h2>
<hr class="limited-width"/>
<?php

// Make an empty array to store post IDs, avoiding replicate post display
$do_not_replicate = array();

// Start by checking if subcategories exist. If so, display each separately by getting ID array, then using foreach loop and WP_Query

// Get the current category ID and save as var
$current_cat = get_query_var('cat');

//
//
// Now, display posts without any subcategories in a standard loop
//
//

// Begin the loop
if (have_posts() ):
// Create a counter variable to keep track of post numbers
$counter = 1;
?>
  <ul id="category" class="limited-width headline-block wow fadeIn animated">
<?php
  // Start looping
  while ( have_posts() ): the_post();
    // Save post ID as var
    $ID = get_the_ID();
    // If current post ID exists in array, skip post and continue with loop
    if (in_array($ID, $do_not_replicate)) { continue; };
    // Stop looping after fourth post
    if ($counter>8) { break; };
    // Save current post ID to array
    array_push($do_not_replicate, $ID);
    ?>
    <!-- Display output here -->
    <?php
    switch ($counter) {
        case 1:
            ?>
            <li class="headline-item">
              <?php the_post_thumbnail('large'); ?>
              <h3><?php the_title(); ?></h3>
              <?php the_category(); ?>
              <div class="grad"></div>
              <a class="cover" href="<?php the_permalink(); ?>"></a>
            </li>
            <?php
            break;
        case 2:
            ?>
            <li class="headline-item">
              <?php the_post_thumbnail('large'); ?>
              <h3><?php the_title(); ?></h3>
              <?php the_category(); ?>
              <div class="grad"></div>
              <a class="cover" href="<?php the_permalink(); ?>"></a>
            </li>
            <?php
            break;
        case 3:
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
            <?php
            break;
        case 4:
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
            <?php
            break;
        case 5:
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
            <?php
            break;
        case 6:
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
            <?php
            break;
        case 7:
            ?>
            <li class="headline-item">
              <?php the_post_thumbnail('large'); ?>
              <h3><?php the_title(); ?></h3>
              <?php the_category(); ?>
              <div class="grad"></div>
              <a class="cover" href="<?php the_permalink(); ?>"></a>
            </li>
            <?php
            break;
        case 8:
            ?>
            <li class="headline-item">
              <?php the_post_thumbnail('large'); ?>
              <h3><?php the_title(); ?></h3>
              <?php the_category(); ?>
              <div class="grad"></div>
              <a class="cover" href="<?php the_permalink(); ?>"></a>
            </li>
            <?php
            break;
        default:
            echo "";
    }
    // Advance the counter by one with each post
    $counter++;
    // Finish looping
  endwhile;
?>
  </ul>

<?php
// Display an empty container to fill with ajaxed content
  echo '<div id="ajax-container"></div>';
// Display a button to trigger the ajax call
  echo '<span class="button" id="more-posts">Load more</span><hr class="limited-width"/>';
// And close out the loop completely
popular_headlines_section();
endif;



//
//
// Finish by displaying popular posts from within the chosen category
//
//

?>

<script>
// Client-side AJAX handler
  var ajaxUrl = '<?php echo admin_url('admin-ajax.php')?>';
  var page = 1; // What page we are on.
  var ppp = 8; // Post per page
  var q = '<?php echo get_search_query(); ?>'

// On click, make the AJAX call and display response
  jQuery("#more-posts").on("click",function(){ // When btn is pressed.
      jQuery("#more-posts").attr("disabled",true); // Disable the button, temp.
      jQuery.post(ajaxUrl, {
          action: "search_ajax",
          offset: (page * ppp) + 1,
          ppp: ppp,
          query: q
      }).success(function(posts){
          page++;
          jQuery("#ajax-container").append(posts);
          jQuery("#more_posts").attr("disabled",false);
      });
  });

</script>
<?php

get_footer();
