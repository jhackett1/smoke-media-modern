<? get_header(); ?>

<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

<article class="limited-width">
	<main>
		<div class="meta">
			<?php the_post_thumbnail(); ?>
			<h2><a href="<? the_permalink(); ?>"><?php the_title(); ?></a></h2>
			<hr class="big">
			<h5><?php the_category(); ?> &middot; <?php echo human_time_diff( get_the_time('U'), current_time('timestamp') ) . ' ago'; ?> &middot; By <?php the_author(); ?> </h5>
			<hr>
		</div>
		<?php the_content(); ?>
	</main>
	<sidebar>
	</sidebar>
</article>

<?php endwhile; else : ?>
<h3 id="notfound"><?php _e( "Sorry, we couldn't find what you're looking for." ); ?></h3>
<?php endif; ?>

	<!-- Example media player -->
	<!-- <div id="myElement">Loading the player...</div>
	<script type="text/javascript">
	var playerInstance = jwplayer("myElement");
	playerInstance.setup({
	file: "https://www.youtube.com/watch?v=R1-Ef54uTeU",
	width: 640,
	height: 360,
	name: 'smokeplayerskin'
	});
	</script> -->

<?php get_footer(); ?>
