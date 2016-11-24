<?php
//
// Customisations of the wordpress post text editor
//

// Get rid of unnecessary quicktag buttons
  function remove_quicktags( $qtInit ) {
      $qtInit['buttons'] = 'strong,em,link,block,fullscreen';
      return $qtInit;
  }
  add_filter('quicktags_settings', 'remove_quicktags');

// Add some new custom quicktag buttons to the editor with the quicktags JS API
  function add_quicktags() {
    if (wp_script_is('quicktags')){
    ?>
        <script type="text/javascript">
          QTags.addButton( 'eg_hr', 'horizontal rule', '<hr />', '', 'h', 'Horizontal rule line', 201 );
          QTags.addButton( 'eg_ch', 'crosshead', '<h3>', '</h3>', 'h', 'Crossheading', 201 );
          QTags.addButton( 'eg_sp', 'spoiler warning', '<span class="spoiler">Spoiler Warning</span>', '', 'q', 'Preformatted text tag', 111 );
        </script>
    <?php
    }
  }
  add_action( 'admin_print_footer_scripts', 'add_quicktags' );
