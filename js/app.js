jQuery( document ).ready(function() {

  // Make the search button work
  jQuery('#search-button').click(function(){
      jQuery('#search-box').toggleClass("visible");
      jQuery('#search-field').focus();
  });

  // Make the slider buttons work
  jQuery('#slide-forward').click(function () {
      // Get the current width of a video tile and save to a var
      var width = 10 + jQuery( '.video-tile' ).width();
      // Get the current scroll position of the scrollbar
      var currentScrollLeft = jQuery('#video-slider').scrollLeft();
      // Calculate the new scroll position of the scrollbar
      var newScrollPos = width + currentScrollLeft;
      // Set the scrollbar of the slider to the new position
      jQuery('#video-slider').animate({scrollLeft:newScrollPos}, 200);
      return false;
  });
  jQuery('#slide-back').click(function () {
      // Get the current width of a video tile and save to a var
      var width = 10 + jQuery( '.video-tile' ).width();
      // Get the current scroll position of the scrollbar
      var currentScrollLeft = jQuery('#video-slider').scrollLeft();
      // Calculate the new scroll position of the scrollbar
      var newScrollPos = currentScrollLeft - width;
      // Set the scrollbar of the slider to the new position
      jQuery('#video-slider').animate({scrollLeft:newScrollPos}, 200);
      return false;
  });

});
