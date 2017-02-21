

<!doctype html>
<html <?php language_attributes(); ?> class="no-js">
	<head>
		<meta charset="<?php bloginfo('charset'); ?>">
		<title><?php wp_title('|','true','right'); ?><?php bloginfo('name'); ?> | <?php bloginfo('description'); ?></title>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="<?php bloginfo('description'); ?>">
		<script src="https://use.typekit.net/twm4qpo.js"></script>
		<script>try{Typekit.load({ async: true });}catch(e){}</script>
		<?php wp_head(); ?>

	  <meta property="fb:app_id" content="1134129026651501" />

	  <!-- if page is content page -->
	  <?php if (is_single()){
	  $feat = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'ogimg' );
	  $feat = $feat[0];
	  ?>

	    <meta property="og:url" content="<?php the_permalink() ?>"/>
	    <meta property="og:title" content="<?php single_post_title(''); ?>" />
	    <meta property="og:description" content="<?php echo strip_tags(get_the_excerpt()); ?>" />
	    <meta property="og:type" content="article" />
	    <meta property="og:image" content="<?php echo $feat; ?>" />
	    <meta name="twitter:card" content="summary_large_image">
	    <meta name="twitter:site" content="@Smoke_Radio">
	    <meta name="twitter:creator" content="@Smoke_Radio">
	    <meta name="twitter:title" content="<?php the_title(); ?>">
	    <meta name="twitter:description" content="<?php echo strip_tags(get_the_excerpt()); ?>">
	    <meta name="twitter:image" content="<?php echo $feat; ?>">

	  <?php } else { ?>

	    <meta property="og:site_name" content="<?php bloginfo('name'); ?>" />
	    <meta property="og:description" content="<?php bloginfo('description'); ?>" />
	    <meta property="og:type" content="website" />
	    <meta property="og:image" content="<?php echo get_template_directory_uri() ?>/img/poster.jpg" />
	    <meta name="twitter:card" content="summary_large_image">
	    <meta name="twitter:site" content="@Media_Smoke">
	    <meta name="twitter:creator" content="@Media_Smoke">
	    <meta name="twitter:title" content="<?php bloginfo('name'); ?>">
	    <meta name="twitter:description" content="<?php bloginfo('description'); ?>">
	    <meta name="twitter:image" content="<?php echo get_template_directory_uri() ?>/img/poster.jpg" >

		<?php
		}
		?>





	</head>
	<body <?php body_class('frontend'); ?>>

		<header class="site-header">
			<div class="top-bar limited-width">
					<nav class="top-left-menu"><?php wp_nav_menu( array( 'theme_location' => 'top-left' ) ); ?></nav>
					<nav class="top-right-menu mobile-hide"><?php wp_nav_menu( array('theme_location' => 'top-right',	) );?></nav>
			</div>
			<div class="limited-width">
				<?php
				// If a custom logo is set, display it
				if ( the_custom_logo() ) {
					the_custom_logo();
				}
				?>
			</div>
			<div class="primary-menu">
				<nav class="limited-width"><?php wp_nav_menu( array( 'theme_location' => 'primary' ) ); ?></nav>
			</div>
		</header>
