<?php
/*
Template Name: Full Width Page
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
    <hr>
    <!-- Share buttons-->
	</main>
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
