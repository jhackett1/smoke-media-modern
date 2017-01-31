<?php
/*
Template Name: Member Portal
*/
get_header();
// Start the loop
if ( have_posts() ) :

	while ( have_posts() ) : the_post();
?>
<article class="limited-width page">
	<main>
		<section class="meta">
			<h2><?php the_title(); ?></h2>
			<hr class="big">
		</section>
    <section class="contents">
    	<!-- Post content -->
  		<?php the_content(); ?>
		</section>
		
	    <?php
      // Display a block of posts
      function training_headlines_section($cat){
        // Create the WP_query and pass in $cat parameter
        $the_query = new WP_Query( array('cat' => $cat ) );
        if ( $the_query->have_posts() ) :
        // Create a counter variable to track number of posts and set it to one
        $counter = 1;
        // Output a container <section> element
        ?>
          <ul class="training-block wow fadeIn animated" data-wow-duration="0.3s">
        <?php
        // Start the loop
        while ( $the_query->have_posts() ) : $the_query->the_post();
        // Save post ID as var
        $ID = get_the_ID();
        // Stop looping after fourth post
        if ($counter>4) { break; };
        // Save current post ID to array
        ?>
          <li class="training-item wow fadeIn animated" data-wow-duration="0.3s">
            <?php the_post_thumbnail('large'); ?>
            <h3><?php the_title(); ?></h3>
            <p><?php the_excerpt(); ?></p>
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
        <?php
        // What if there are no posts returned?
        else :
        ?>
        	<p><?php _e( 'Sorry, no posts matched your criteria.' ); ?></p>
        <?php endif;
      }

			if (get_option('training_cat')) {
			  $cat = get_option('training_cat');
			} else {
			  $cat = 'training';
			}

    training_headlines_section($cat);
		// Display an empty container to fill with ajaxed content
		  echo '<div id="ajax-container"></div>';
		// Display a button to trigger the ajax call
		  echo '<span class="button" id="more-posts">Load more</span>';
	  ?>
		<script>
		// Client-side AJAX handler
		  var ajaxUrl = '<?php echo admin_url('admin-ajax.php')?>';
		  var page = 1; // What page we are on.
		  var ppp = 4; // Post per page
		  var category = '<?php echo $cat; ?>';

		// On click, make the AJAX call and display response
		  jQuery("#more-posts").on("click",function(){ // When btn is pressed.
		      jQuery("#more-posts").attr("disabled",true); // Disable the button, temp.
		      jQuery.post(ajaxUrl, {
		          action: "training_ajax",
		          offset: (page * ppp) + 1,
		          ppp: ppp,
		          cat: category
		      }).success(function(posts){
		          page++;
		          jQuery("#ajax-container").append(posts);
		          jQuery("#more_posts").attr("disabled",false);
		      });
		  });

		</script>

    <hr>
    <!-- Share buttons-->
	</main>
	<sidebar>
    <?php dynamic_sidebar( 'members' ); ?>
	</sidebar>
</article>
<?php


// What if there are no posts to show?
endwhile; else :
?>
	<p><?php _e( 'Sorry, no posts matched your criteria.' ); ?></p>
<?php
// End the loop
endif;
get_footer();
