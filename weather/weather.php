<?php

// Query the Met Office Datapoint API for an hourly weather forecast, displaying temperature, precip probability and weather type
function the_weather(){
  // Don't do anything unless API is set
  if (get_option('weather_api_key')) {
    // Get a five-day forecast for the Westminster (id 354160) area, using a theme option field to pass in API key
    $resp = file_get_contents('http://datapoint.metoffice.gov.uk/public/data/val/wxfcs/all/json/354160?res=daily&key='. get_option('weather_api_key'));
    // Turn the json response into an associative array
    $weather_array = json_decode($resp, true);
    // Check you've actually recieved something from the API before proceeding
    if ($weather_array) {

      echo '<section class="dateweather limited-width"><div>' . date( 'l j F Y' ) . '</div>';

      // Start a container
      echo '<div class="weather">';

      // Get the current hour and save as a $now var
      $now = date('G');
      // If daytime, set day var to 0, else, set it to 1 for nighttime
      if ($now > 7 && $now < 20) { $day = 0; } else { $day = 1; }

      // If it's night, get night temperature, if not, get day temperature
      if($day){
          $temperature = $weather_array['SiteRep']['DV']['Location']['Period'][0]['Rep'][$day]['Nm'];
      }else{
          $temperature = $weather_array['SiteRep']['DV']['Location']['Period'][0]['Rep'][$day]['Dm'];
      };

      // Get the weather type and set as var
      $type = $weather_array['SiteRep']['DV']['Location']['Period'][0]['Rep'][$day]['W'];

      // Show icons for different weather types
      switch ($type) {
        case '0':
          echo '<i class="wi wi-night-clear"></i>';
          break;
        case '1':
          echo '<i class="wi wi-day-sunny"></i>';
          break;
        case '2':
          echo '<i class="wi wi-night-alt-cloudy"></i>';
          break;
        case '3':
          echo '<i class="wi wi-day-cloudy"></i>';
          break;
        case '5':
          echo '<i class="wi wi-day-fog"></i>';
          break;
        case '6':
          echo '<i class="wi wi-fog"></i>';
          break;
        case '7':
          echo '<i class="wi wi-cloudy"></i>';
          break;
        case '8':
          echo '<i class="wi wi-cloudy"></i>';
          break;
        case '9':
          echo '<i class="wi wi-night-alt-showers"></i>';
          break;
        case '10':
          echo '<i class="wi wi-day-showers"></i>';
          break;
        case '11':
          echo '<i class="wi wi-showers"></i>';
          break;
        case '12':
          echo '<i class="wi wi-showers"></i>';
          break;
        case '13':
          echo '<i class="wi wi-night-alt-rain"></i>';
          break;
        case '14':
          echo '<i class="wi wi-day-rain"></i>';
          break;
        case '15':
          echo '<i class="wi wi-rain"></i>';
          break;
        case '16':
          echo '<i class="wi wi-night-alt-sleet"></i>';
          break;
        case '17':
          echo '<i class="wi wi-day-sleet"></i>';
          break;
        case '18':
          echo '<i class="wi wi-day-sleet"></i>';
          break;
        case '19':
          echo '<i class="wi wi-night-hail"></i>';
          break;
        case '20':
          echo '<i class="wi wi-day-hail"></i>';
          break;
        case '21':
          echo '<i class="wi wi-hail"></i>';
          break;
        case '22':
          echo '<i class="wi wi-night-alt-snow"></i>';
          break;
        case '23':
          echo '<i class="wi wi-day-snow"></i>';
          break;
        case '24':
          echo '<i class="wi wi-snow"></i>';
          break;
        case '25':
          echo '<i class="wi wi-night-alt-snow"></i>';
          break;
        case '26':
          echo '<i class="wi wi-day-snow"></i>';
          break;
        case '27':
          echo '<i class="wi wi-snow"></i>';
          break;
        case '28':
          echo '<i class="wi wi-night-alt-snow-thunderstorm"></i>';
          break;
        case '29':
          echo '<i class="wi wi-day-snow-thunderstorm"></i>';
          break;
        case '30':
          echo '<i class="wi wi-thunderstorm"></i>';
          break;
      }
      // Echo out temperature
      echo $temperature . '°C ';
      echo 'in London';
      // Close the container element
      echo '</div></section>';
      // Finish the if statement
    }
  }
// Close out the function
}
