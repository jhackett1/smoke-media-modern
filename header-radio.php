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

		<header class="site-header" id="radio">
			<div class="top-bar limited-width">
					<nav class="top-left-menu"><?php wp_nav_menu( array('theme_location' => 'top-left-radio',	) );?></nav>
					<nav class="top-right-menu mobile-hide"><?php wp_nav_menu( array('theme_location' => 'top-right',	) );?></nav>
			</div>
			<div class="limited-width middle">

				<a href="<?php echo get_category_link( 487 ); ?>" id="site-logo-link">
					<img class="custom-logo" src="<?php echo get_template_directory_uri(); ?>/img/radio.png"/>
				</a>



				<script>
				function showInfoData(){
		      // Make the ajax request
		      jQuery.ajax({url: "https://marconi.smokeradio.co.uk/api/now_playing.php", success: function(result){
		        // Check if there's a show on air
		        var showExists = result.success;
						console.log(showExists);
		        // If there's a show on air, show the (normally hidden) box
		        if (showExists == 1){
		          // Display the programme info box
		          jQuery("#current-show").css("display", "block");
		          // Pull specific fields from API and process for display
		          var title = result.show.title;
							var desc = result.show.short_desc;
		          // Display processed data
		          jQuery("#current-show h3").html(title);
		          jQuery("#current-show p").html(desc);
		        } else {
							// Display the programme info box
							jQuery("#current-show").css("display", "none");
		        }
		      }});
		      // Check for new data every 60 seconds
		      setTimeout(showInfoData, 60000);
		    }
		    // Call the function
		    showInfoData();
				</script>

				<div class="mobile-hide" id="current-show">
					<h4>On now</h4>
					<h3></h3>
					<p></p>
				</div>


			</div>
			<div class="primary-menu">
				<nav class="limited-width">
					<?php wp_nav_menu( array( 'theme_location' => 'primary-radio' ) ); ?>
					<a id="launch-player" href="javascript: void(0)"
						 onclick="window.open('/wordpress/player',
						'Listen Live',
						'width=350, height=600');
						 return false;">Listen live<i class="fa fa-headphones"></i>
					 </a>
				</nav>

			</div>
		</header>
