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









  // For the slider




  // Get number of slides and save as var
  slideQuant = jQuery("div.gallery ul.content").children().size();
  // Get the width of a single slide and save as a var
  slideWidth = parseInt(jQuery("div.gallery ul.content li:first-of-type").width());
  // Total width of the gallery slides
  maxWidth = slideWidth * slideQuant;
  maxLeft = -maxWidth;

  // What do do when the "advance slide" button is clicked
  jQuery('div.gallery span.nav:last-of-type').click(function () {
      // Get the current scroll position of the scrollbar
      var currentLeft = parseInt(jQuery('div.gallery ul.content li.gallery-item:first-of-type').css( "margin-left" ));
      // Calculate the new scroll position of the scrollbar
      var newLeft = currentLeft - slideWidth;
      // Action the thing if there is a slide to scroll to
      if (newLeft > maxLeft) {
        // Set the scrollbar of the slider to the new position
        jQuery('div.gallery ul.content li.gallery-item:first-of-type').animate({'margin-left':newLeft}, 100);
        jQuery('div.gallery span.nav:first-of-type').removeClass('off');
      } else {
        jQuery('div.gallery span.nav:last-of-type').addClass('off');
      }
      return false;
  });



  // What do do when the "previous slide" button is clicked
  jQuery('div.gallery span.nav:first-of-type').click(function () {
      // Get the current scroll position of the scrollbar
      var currentLeft = parseInt(jQuery('div.gallery ul.content li.gallery-item:first-of-type').css( "margin-left" ));
      // Calculate the new scroll position of the scrollbar
      var newLeft = currentLeft + slideWidth;
      // Action the thing if there is a slide to scroll to
      if (newLeft <= 0) {
        // Set the scrollbar of the slider to the new position
        jQuery('div.gallery ul.content li.gallery-item:first-of-type').animate({'margin-left':newLeft}, 100);
        jQuery('div.gallery span.nav:last-of-type').removeClass('off');
      } else {
        jQuery('div.gallery span.nav:first-of-type').addClass('off');
      }
      return false;
  });







});
