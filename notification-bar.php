<?php

$the_query = new WP_Query( array(
  'cat' => 'news',
  'posts_per_page' => 1
) );

if ( $the_query->have_posts() ) :
while ( $the_query->have_posts() ) : $the_query->the_post();
?>

<section id="notification-bar">

  <h2><?php the_title(); ?><span> / <?php echo human_time_diff( get_the_time('U'), current_time('timestamp') ) . ' ago'; ?></span></h2>
  <i class="fa fa-close"></i>
  <a class=cover href="<?php the_permalink(); ?>"></a>

</section>

<?php
endwhile;
endif;
