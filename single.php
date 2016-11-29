<?php
get_header();
// Start the loop
if ( have_posts() ) :

	// Make an empty array to store post IDs, avoiding replicate post display
	$do_not_replicate = array();

	while ( have_posts() ) : the_post();
?>

<?php
// Save layout at 1 if full width, 0 if standard
$layout = get_post_meta( get_the_id(), 'full_width_image')[0];

// Save post ID as var
$ID = get_the_ID();
// Save current post ID to array
array_push($do_not_replicate, $ID);

// If layout is on, get a full-width feature layout, else return the standard layout
if ($layout === on) {
	?>
	<section class="full-width-image">
		<?php
		the_post_thumbnail('large');
		if( get_post_meta( $post->ID, 'feat_image_credit', true ) ){ ?>
			<div class="limited-width full-width-credit">Image: <?php echo get_post_meta( $post->ID, 'feat_image_credit', true )?></div>
		<?php } ?>
	</section>
	<article class="limited-width full-width-template">
		<main>
			<section class="meta">
				<h2><?php the_title(); ?></h2>
				<hr class="big">
	      <h5><?php the_category(); ?> &middot; <?php echo human_time_diff( get_the_time('U'), current_time('timestamp') ) . ' ago'; ?> &middot; By <?php	smoke_byline($post->ID); ?> </h5>
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
	    <?php get_comments(); ?>
	    <hr>
	    <!-- Share buttons-->
	    <?php smoke_share_buttons(); ?>
	    <hr class="big">
	    <!-- Author profile -->
			<?php smoke_author_box($post->ID); ?>
		</main>
		<sidebar>
	    <?php get_sidebar(); ?>
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
    <?php get_comments(); ?>
    <hr>
    <!-- Share buttons-->
    <?php smoke_share_buttons(); ?>
    <hr class="big">
    <!-- Author profile -->
		<?php smoke_author_box($post->ID); ?>
	</main>
	<sidebar>
    <?php get_sidebar(); ?>
	</sidebar>

</article>
<?php

$cat = get_the_category();
related_posts_section($cat[1], 'Related', $do_not_replicate);

}
// What if there are no posts to show?
endwhile; else :
?>
	<p><?php _e( 'Sorry, no posts matched your criteria.' ); ?></p>
<?php
// End the loop
endif;
get_footer();
