<?php
get_header();
// Start the loop
if ( have_posts() ) : while ( have_posts() ) : the_post();
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
// What if there are no posts to show?
endwhile; else :
?>
	<p><?php _e( 'Sorry, no posts matched your criteria.' ); ?></p>
<?php
// End the loop
endif;
get_footer();
