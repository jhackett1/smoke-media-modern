<!doctype html>
<html <?php language_attributes(); ?> class="no-js">
	<head>
		<meta charset="<?php bloginfo('charset'); ?>">
		<title><?php wp_title('|','true','right'); ?><?php bloginfo('name'); ?> | <?php bloginfo('description'); ?></title>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="<?php bloginfo('description'); ?>">
		<?php wp_head(); ?>
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
