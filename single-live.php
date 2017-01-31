<?php
// Get the correct header based on whether we're a radio article or not
if (in_category("radio")) {
	get_header("radio");
} else {
	get_header();
}
// Start the loop
if ( have_posts() ) :
	// Make an empty array to store post IDs, avoiding replicate post display
	$do_not_replicate = array();
	while ( have_posts() ) : the_post();

		// Save post ID as var
		$ID = get_the_ID();
		// Save current post ID to array
		array_push($do_not_replicate, $ID);
		// Call the function to set and update post view counter with every view
		track_post_views( $ID );

		?>
		<article class="limited-width">
			<main>
				<section class="meta">
					<h2><span>Live /</span> <?php the_title(); ?></h2>
					<hr class="big">
		      <h5><span id="live"></span><?php the_category(); ?> &middot; <?php echo human_time_diff( get_the_time('U'), current_time('timestamp') ) . ' ago'; ?></h5>
		      <figure>
						<!-- Featured media -->
						<?php live_video_image($post->ID); ?>
		      </figure>
		      <hr>
				</section>
		    <section class="contents">
					<!-- Star ratings -->
					<?php smoke_rating($post->ID); ?>
		    	<!-- Standfirst -->
					<?php smoke_standfirst($post->ID); ?>
		    	<!-- Post content -->
		  		<?php the_content(); ?>
		    </section>
		    <hr>
		    <!-- Share buttons-->
		    <?php smoke_share_buttons(); ?>
		    <hr class="big">
			</main>
			<sidebar>
		    <?php
				// Get the right sidebar
					dynamic_sidebar("live");
				?>
			</sidebar>
		</article>
		<?php
		// Put related bosts below every article
		echo '<article class="limited-width">';
		$cat = get_the_category();
		related_headlines_section($cat{0}->term_id, 'Related', $do_not_replicate);
		popular_headlines_section();
		echo '</article>';

	// What if there are no posts to show?
	endwhile;
else :
	?>
	<h3 id="notfound"><?php _e( "Sorry, we couldn't find what you're looking for." ); ?></h3>
	<?php
// End the loop
endif;
get_footer();
