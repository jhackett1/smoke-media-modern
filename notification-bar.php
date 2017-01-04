<?php

$the_query = new WP_Query( array(
  'cat' => 'news',
  'posts_per_page' => 1,
  'date_query' => array(
        'after' => strtotime('-6 hours')
  )
) );

if ( $the_query->have_posts() ) :
while ( $the_query->have_posts() ) : $the_query->the_post();
?>

<?php echo get_site_url() ?>

<section id="notification-bar" style="visibility: hidden">
  <h2><?php the_title(); ?><span> / <?php echo human_time_diff( get_the_time('U'), current_time('timestamp') ) . ' ago'; ?></span></h2>
  <i class="fa fa-close"></i>
  <a class=cover href="<?php the_permalink(); ?>"></a>
</section>

<script>
  // Check if the cookie exists, and if not, trigger the display of the notificationbar
  if (document.cookie.indexOf("smoke_notification") == -1) {
    jQuery("#notification-bar").addClass("wow animated fadeInUp");
  }
  // On click of the bar,save a cookie
  jQuery('#notification-bar').click(function(){
    document.cookie = "smoke_notification=closed";
  });
  // On click of the close icon, hide the bar and save a global cookie
  jQuery('.fa-close').click(function(){
    jQuery("#notification-bar").css("display", "none");
    document.cookie = "smoke_notification=closed; path=/;";
  });
</script>

<?php
endwhile;
endif;
