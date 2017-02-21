<!doctype html>
<html <?php language_attributes(); ?> class="no-js">
	<head>
		<meta charset="<?php bloginfo('charset'); ?>">
		<title><?php wp_title('|','true','right'); ?>Smoke Radio | By the students, for the students</title>
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

			<meta property="og:url" content="http://smokeradio.co.uk"/>
	    <meta property="og:title" content="Smoke Radio" />
	    <meta property="og:site_name" content="Smoke Radio" />
	    <meta property="og:description" content="By the students, for the students." />
	    <meta property="og:type" content="website" />
	    <meta property="og:image" content="<?php echo get_template_directory_uri() ?>/img/poster.jpg" />
	    <meta name="twitter:card" content="summary_large_image">
	    <meta name="twitter:site" content="@Smoke_Radio">
	    <meta name="twitter:creator" content="@Smoke_Radio">
	    <meta name="twitter:title" content="Smoke Radio">
	    <meta name="twitter:description" content="By the students, for the students.">
	    <meta name="twitter:image" content="<?php echo get_template_directory_uri() ?>/img/poster.jpg" >

		<?php
		}
		?>



	</head>
	<body <?php body_class('frontend'); ?>>

		<header class="site-header" id="radio">
			<div class="top-bar limited-width">
					<nav class="top-left-menu"><?php wp_nav_menu( array('theme_location' => 'top-left-radio',	) );?></nav>
					<nav class="top-right-menu mobile-hide"><?php wp_nav_menu( array('theme_location' => 'top-right',	) );?></nav>
			</div>
			<div class="limited-width middle">

				<a href="http://smoke.media/radio" id="site-logo-link">
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
							var desc = desc.split(/\s+/).slice(1,10).join(" ");
							var link = '<?php echo get_site_url() ?>' + '/shows/' + result.show.code;
		          // Display processed data
		          jQuery("#current-show h3").html(title);
		          jQuery("#current-show p").html(desc);
		          jQuery("#current-show a").attr('href', link);

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
					<a class="cover" href=""></a>
				</div>


			</div>
			<div class="primary-menu">
				<nav class="limited-width">
					<?php wp_nav_menu( array( 'theme_location' => 'primary-radio' ) ); ?>
					<a id="launch-player" href="javascript: void(0)"
						 onclick="window.open('http://smoke.media/player',
						'Listen Live',
						'width=350, height=600');
						 return false;">Listen live<i class="fa fa-headphones"></i>
					 </a>
				</nav>

			</div>
		</header>
