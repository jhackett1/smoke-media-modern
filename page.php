<?php
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
	<sidebar>
    <?php dynamic_sidebar( 'page' ); ?>
	</sidebar>
</article>
<?php


// What if there are no posts to show?
endwhile; else :
?>
<h3 id="notfound"><?php _e( "Sorry, we couldn't find what you're looking for." ); ?></h3>
<?php
// End the loop
endif;
get_footer();
