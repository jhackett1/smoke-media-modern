<footer class="site-footer">
  <div class="footer-menu">
    <nav class="primary-menu"><?php wp_nav_menu( array( 'theme_location' => 'primary' ) ); ?></nav>
  </div>
  <?php
  // If a custom logo is set, display it
  if ( the_custom_logo() ) {
    the_custom_logo();
  }
  ?>
  <nav class="corporate-menu"><?php wp_nav_menu( array( 'theme_location' => 'footer' ) ); ?></nav>
  <div class="copyright">
    <p>&copy; <?php echo date('Y'); ?> <?php echo get_bloginfo('name'); ?> &middot; Developed by <a href="http://joshuahackett.com" target="blank">Joshua Hackett</a></p>
  </div>
</footer>
<?php wp_footer(); ?>
</body>
</html>
