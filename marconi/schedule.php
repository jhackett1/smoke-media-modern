<?php
function schedule() {
  // The API endpoint URL for the schedule
  $url = 'https://marconi.smokeradio.co.uk/api/schedule.php';
  // Get a response from Marconi API using cURL
  $ch = curl_init();
  // Use SSL to work
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
  curl_setopt($ch, CURLOPT_HEADER, false);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_REFERER, $url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
  // Save the response as $result
  $result = curl_exec($ch);
  // Your work is done, cURL
  curl_close($ch);

  // Convert the result into an associative array
  $sched = json_decode($result, true);

  // Declare a function which searches the show array based on a specified key-value pair
  function search($array, $key, $value){
    // Create an empty array to hold results
    $results = array();
    // Check that the array passed in actually exists
    if (is_array($array)) {
      // Select the $results array
      if (isset($array[$key]) && $array[$key] == $value) {
        $results[] = $array;
      }
      // Perform the search using a foreach loop, logging each result array to a new array called $results
      foreach ($array as $subarray) {
        $results = array_merge($results, search($subarray, $key, $value));
      }
    }
    // Then pass out the populated search results
    return $results;
  };

  // Only proceed if you actually got something useful from the APi
    if ($sched["success"]===1) {

      ?>
      <div class="schedule">
        <ul class="day-labels">
          <li>Monday</li>
          <li>Tuesday</li>
          <li>Wednesday</li>
          <li>Thursday</li>
          <li>Friday</li>
          <li>Saturday</li>
          <li>Sunday</li>
        </ul>
        <ul class="show-grid">
          <ul class="hour-labels">
            <li>Midnight</li>
            <li>1am</li>
            <li>2am</li>
            <li>3am</li>
            <li>4am</li>
            <li>5am</li>
            <li>6am</li>
            <li>7am</li>
            <li>8am</li>
            <li>9am</li>
            <li>10am</li>
            <li>11am</li>
            <li>Midday</li>
            <li>1pm</li>
            <li>2pm</li>
            <li>3pm</li>
            <li>4pm</li>
            <li>5pm</li>
            <li>6pm</li>
            <li>7am</li>
            <li>8pm</li>
            <li>9pm</li>
            <li>10pm</li>
            <li>11pm</li>
          </ul>
      <?php

      // For loop to fetch a day of schedule items at a time
      for ($day=0; $day < 7; $day++) {
        // Display labels for each hour

        echo "<ul class='day'>";
        $day_of_shows = $sched['schedule'][$day];
        // Nested for loop for each hour, starting at 1am, going until the next midnight
        for ($hour=0; $hour < 24 ; $hour++) {

            // Process the current hour into the API's format
            $tx_time = str_pad($hour, 2, '0', STR_PAD_LEFT) . ":00:00";
            // Perform the search
            $show = search($sched['schedule'][$day], 'tx_time', $tx_time);

            // Process a show permalink
            $link = get_site_url() . "/shows/" . $show[0]['code'];
            // Display show data

            if (!empty($show)) {
              echo "<li class='show'>";
              echo "<h4>" . $show[0]['title'] . "</h4>";
              echo "<p>" . substr($show[0]['tx_time'], 0, -3) . "</p>";
              echo "<a href='" . $link . "' class='cover'></a>";
            } else{
              echo "<li>";
            }
            echo "</li>";

        // Finish the hourly for loop
        }

        // Close daily container element
        echo "<hr></ul>";
      //Finish the daily for loop
      }
      ?>
          </ul>
        </div>

        <script>
        jQuery('document').ready(function(){
            // Highlight the current day of shows using jQ
            // Get the current day as an integer between 0 and 6, starting on Sunday
            var date = new Date();
            var day_int = date.getDay();
            // Light up the current day's shows
            switch(day_int) {
              case 0:
              // Sunday
                  jQuery(".day:nth-of-type(8) li").css("background-color", "#eaced2").addClass("on-today");
                  jQuery(".day-labels li:nth-of-type(7)").css("background-color", "#AC3E4A").css("color", "#fafafa");
                  break;
              case 1:
              // Monday
                  jQuery(".day:nth-of-type(2) li").css("background-color", "#eaced2").addClass("on-today");
                  jQuery(".day-labels li:nth-of-type(1)").css("background-color", "#AC3E4A").css("color", "#fafafa");
                  break;
              case 2:
              // etc...
                  jQuery(".day:nth-of-type(3) li").css("background-color", "#eaced2").addClass("on-today");
                  jQuery(".day-labels li:nth-of-type(2)").css("background-color", "#AC3E4A").css("color", "#fafafa");
                  break;
              case 3:
                  jQuery(".day:nth-of-type(4) li").css("background-color", "#eaced2").addClass("on-today");
                  jQuery(".day-labels li:nth-of-type(3)").css("background-color", "#AC3E4A").css("color", "#fafafa");
                  break;
              case 4:
                  jQuery(".day:nth-of-type(5) li").css("background-color", "#eaced2").addClass("on-today");
                  jQuery(".day-labels li:nth-of-type(4)").css("background-color", "#AC3E4A").css("color", "#fafafa");
                  break;
              case 5:
                  jQuery(".day:nth-of-type(6) li").css("background-color", "#eaced2").addClass("on-today");
                  jQuery(".day-labels li:nth-of-type(5)").css("background-color", "#AC3E4A").css("color", "#fafafa");
                  break;
              case 6:
                  jQuery(".day:nth-of-type(7) li").css("background-color", "#eaced2").addClass("on-today");
                  jQuery(".day-labels li:nth-of-type(6)").css("background-color", "#AC3E4A").css("color", "#fafafa");
                  break;
              default:
            };

            //Get hours as an integer which will vary between 0 and 24
            var hour = date.getHours() + 1;
            jQuery(".day li:nth-of-type(" + hour + ")").addClass("on-air");

            // Update grid schedule to scroll to current time position
            //Get hours as an integer which will vary between 0 and 24
            var h = date.getHours();
            // Save the width of the schedule as a var
            var width = 3672;
            // Divide hours by 24 to get a decimal, then multiply the width of the schedule by that decimal to get the number of pixels to scroll by
            var scrollpos = h / 24 * width;
            // Put it into practice
            jQuery( "ul.show-grid" ).animate({
                scrollLeft: scrollpos
            }, 500);
          // Finish document ready function
          });
        </script>

      <?php

    //Close the if statement
  } else {
    // What if $sched isn't set/API down?
    echo "<p>The schedule isn't available at the moment, but it'll be back up soon!</p>";
  }
}
// Register the shortcode, awkwardly
// add_shortcode("schedule", schedule);



add_shortcode( 'schedule', 'schedule' );
