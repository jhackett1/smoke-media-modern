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
?>

<?php
// Save layout at 1 if full width, 0 if standard
if (get_post_meta( get_the_id(), 'full_width_image')) {
	$layout = get_post_meta( get_the_id(), 'full_width_image')[0];
} else {
	$layout = 0;
}


// Save post ID as var
$ID = get_the_ID();
// Save current post ID to array
array_push($do_not_replicate, $ID);
// Call the function to set and update post view counter with every view
track_post_views( $ID );

// If layout is on, get a full-width feature layout, else return the standard layout
if ($layout === 'on') {
	?>
	<section class="full-width-image">
		<?php
		the_post_thumbnail();
		if( get_post_meta( $post->ID, 'feat_image_credit', true ) ){ ?>
			<div class="limited-width full-width-credit">Image: <?php echo get_post_meta( $post->ID, 'feat_image_credit', true )?></div>
		<?php } ?>
	</section>
	<article class="limited-width full-width-template">
		<main>
			<section class="meta">
				<h2><?php the_title(); ?></h2>
				<hr class="big">
	      <h5><?php the_category(); ?> &middot; <span><?php echo human_time_diff( get_the_time('U'), current_time('timestamp') ) . ' ago'; ?></span> &middot; <span>By <?php	smoke_byline($post->ID); ?></span></h5>
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
	    <?php comments_template(); ?>
	    <hr>
	    <!-- Share buttons-->
	    <?php smoke_share_buttons(); ?>
	    <hr class="big">
	    <!-- Author profile -->
			<?php smoke_author_box($post->ID); ?>
		</main>
		<sidebar>
			<?php if (in_category("radio")) {
				dynamic_sidebar("radio");
			} else {
				dynamic_sidebar("post");
			} ?>
		</sidebar>
	</article>
<?php
// And the standard layout to be displayed if $layout is off
} else {
?>
<article class="limited-width">
	<main>
		<section class="meta">
			<h2><?php the_title(); ?></h2>
			<hr class="big">
      <h5><?php the_category(); ?> &middot; <?php echo human_time_diff( get_the_time('U'), current_time('timestamp') ) . ' ago'; ?> &middot; By <?php	smoke_byline($post->ID); ?> </h5>
      <figure>
				<!-- Featured media -->
				<?php featured_video_image($post->ID); ?>
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
    <?php comments_template(); ?>
    <hr>
    <!-- Share buttons-->
    <?php smoke_share_buttons(); ?>
    <hr class="big">
    <!-- Author profile -->
		<?php smoke_author_box($post->ID); ?>
	</main>
	<sidebar>
    <?php
		// Get the right sidebar based on whether this is a radio article, live event or not
		if (in_category("radio")) {
			dynamic_sidebar("radio");
		} elseif (in_category("training")) {
			dynamic_sidebar("page");
		} else {
			dynamic_sidebar("post");
		}
		?>
	</sidebar>
</article>
<?php
}
// Put related bosts below every article
echo '<article class="limited-width">';
$cat = get_the_category();
related_headlines_section($cat{0}->term_id, 'Related', $do_not_replicate);
popular_headlines_section();
echo '</article>';

// What if there are no posts to show?
endwhile; else :
?>
<h3 id="notfound"><?php _e( "Sorry, we couldn't find what you're looking for." ); ?></h3>
<?php
// End the loop
endif;
get_footer();
