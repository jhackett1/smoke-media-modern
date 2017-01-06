<?php get_header(); ?>

<h2 class="limited-width page-title">Print editions</h2>
<div class="limited-width">
  <hr class="limited-width big" style="margin: 0 10px;"/>
</div>
<p class="limited-width category-desc">See recent back issues of the QH and Smoke Mag </p>

<?php

// Only do stuff if there's an API key and option set
if (get_option('issuu_api_key') && get_option('issuu_api_secret')) {
  // Retrieve the API key from db
  $key = get_option('issuu_api_key');
  // Create the MD5 has needed to sign the request
  $signature = md5( $raw_sig = get_option('issuu_api_secret') . "accesspublic" . "actionissuu.documents.list" . "apiKey" . $key . "documentSortBypublishDateformatjsonresultOrderdesc" );
  // Assemble the url to request
  $url = "http://api.issuu.com/1_0?action=issuu.documents.list&apiKey=" . $key . "&access=public&documentSortBy=publishDate&resultOrder=desc&format=json&signature=" . $signature;

  // Get a response from the Issuu API using cURL
  $ch = curl_init();
  // This API needs SSL to work
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
  $docs_array = json_decode($result, true);
  // Create a counter to keep track of number of issues displayed
  $counter = 1;
  // Display stuff
  echo "<ul class='issues limited-width'>";
  foreach ($docs_array["rsp"]["_content"]["result"]["_content"] as $issue) {
    // Stop after the 9th post
    if ($counter > 9) { break; }
    // Display an issue
    echo "<li class='issue-tile'>";
    $img_url = "http://image.issuu.com/" . $issue["document"]["documentId"] . "/jpg/page_1_thumb_large.jpg";
    echo "<img src='" . $img_url . "'/>";
    echo '<span class="play-icon"><i class="fa fa-newspaper-o"></i></span>';
    echo "<h3>" . $issue["document"]["title"] . "</h3>";
    echo "<p>" . $issue["document"]["description"] . "</p>";
    $permalink = "http://issuu.com/" . $issue["document"]["username"] . "/docs/" . $issue["document"]["name"];
    echo "<a class=cover target='blank' href='" . $permalink . "'></a>";
    echo "</li>";
    // Iterate the counter
    $counter++;
  }
  echo "</ul>";
  // Display more on issue
  if (get_option('issuu_page')) {
      echo '<a id="issuu" target="blank" href="' . get_option('issuu_page') . '"><span class="button" id="more-posts">More on Issuu</span></a>';
  }
}
get_footer();
