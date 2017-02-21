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
          QTags.addButton( 'eg_sp', 'spoiler warning', '<span class="spoiler">Spoiler Warning</span>', '', 'q', 'Preformatted text tag', 111 );
          QTags.addButton( 'eg_ch', 'schedule', '[schedule]', '', 'h', 'Schedule grid', 201 );
          QTags.addButton( 'eg_sp', 'tabbed content', '\
<section class="tabbed"> \
<ul class="labels">\
<li class="active">Tab 1</li>\
<li>Tab 2</li>\
<li>Tab 3</li>\
</ul>\
<ul class="content">\
<li class="active">Tab 1 content</li>\
<li>Tab 2 content</li>\
<li>Tab 3 content</li>\
</ul>\
</section>', '', 'q', 'Preformatted text tag', 111 );
          QTags.addButton( 'eg_ch', 'crosshead', '<h3>', '</h3>', 'h', 'Crossheading', 201 );


        </script>
    <?php
    }
  }
  add_action( 'admin_print_footer_scripts', 'add_quicktags' );

// Get rid of nbsp because we hate it
  function remove_empty_lines( $content ){
    // replace empty lines
    $content = preg_replace("/&nbsp;/", "", $content);
    return $content;
  }
  add_action('content_save_pre', 'remove_empty_lines');
