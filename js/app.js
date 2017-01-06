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

// Make tabbed widgets work
  // When a label is clicked, do stuff
  jQuery("ul.labels li").click(function(){
    // Find out which one was clicked and save the index as an integer var starting at 1 for first element
      var index = jQuery("ul.labels li").index(this) + 1;
      // Remove active class from all elements
      jQuery("ul.labels li").removeClass("active");
      jQuery("ul.content li").removeClass("active");
      // Re-add the class to the right elements based on the var calculated earlier
      jQuery("ul.labels li:nth-of-type(" + index + ")").addClass("active");
      jQuery("ul.content li:nth-of-type(" + index + ")").addClass("active");
  });

});
