<?php
	$resp = file_get_contents('https://marconi.smokeradio.co.uk/api/episode_info.php?code='.$pcode.$prod_number);
	$prog = json_decode($resp, true);
	if (!$prog['success']) {
		header('HTTP/1.1 404 Not Found');
	}
?>
<?php get_header(); ?>

<div class="single_container">
	<?php if ($prog['success']) { ?>
		<div class="content">
			<div class="single_meta">
				<h2><?php echo $prog['episode']['title']; ?></h2>
				<hr>
			</div>
			<?php echo $prog['episode']['long_desc']; ?>
		</div>
	<?php } else { ?>
		<div class="content">
			<div class="single_meta">
				<h2>Episode not found</h2>
				<hr>
			</div>
			<p>We couldn't find that episode. Double-check the address and try again.</p>
		</div>
	<?php } ?>

	<div id="sidebar">
		<?php dynamic_sidebar( 'home' ); ?>
	</div>
</div>

</article>
<?php get_footer(); ?>
