<?php get_header("radio");

// Get show info from Marconi API
$resp = file_get_contents('https://marconi.smokeradio.co.uk/api/programme_info.php?code='.$pcode);
$prog = json_decode($resp, true);
// Give an error if the show wasn't found
if (!$prog['success']) {
  header('HTTP/1.1 404 Not Found');
}

?>

<article class="limited-width">
	<main>
  <?php if ($prog['success']) {

    // Process duration
    $duration = $prog['show']['tx_duration'] /60/60;
    if($duration===1){
      $duration = $duration . " hour";
    } else {
      $duration = $duration . " hours";
    };

    // Schedule link
    $schedule_link = get_site_url() . "/schedule/";

    // Process time
    $time = "From " . ltrim(date('h:i a', strtotime($prog['show']['tx_time'])), '0');

    //Process image
    if ($prog['show']['icon']) {
      $icon = $prog['show']['icon'];
      $image = "<img src='" . $icon . "'/>";
    }


    // Process show description into a useful var with a fallback
    if ($prog['show']['long_desc']) {
      $description = $prog['show']['long_desc'];
    } elseif($prog['show']['medium_desc']) {
      $description = $prog['show']['medium_desc'];
    } elseif($prog['show']['short_desc']) {
      $description = $prog['show']['short_desc'];
    } else {
      $description = "Just another Smoke Radio show!";
    };


    // Process days
    $day_raw = $prog['show']['tx_days'];
    switch ($day_raw) {
      // Monday
      case '1000000':
        $day = "Mondays";
        break;
      // Tuesday
      case '0100000':
        $day = "Tuesdays";
        break;
      // etc...
      case '0010000':
        $day = "Wednesdays";
        break;
      case '0001000':
        $day = "Thursdays";
        break;
      case '0000100':
        $day = "Fridays";
        break;
      case '0000010':
        $day = "Saturdays";
        break;
      case '0000001':
        $day = "Sundays";
        break;
      default:
        $day = "Multiple days";
        break;
    }

     ?>
		<section class="meta">
			<h2><a href="<?php echo $schedule_link; ?>">Show</a> / <?php echo $prog['show']['title']; ?></h2>
			<hr class="big">
			<h5><?php echo $day; ?> <?php echo $time; ?> &middot; <?php echo $duration; ?></h5>
      <figure>
				<!-- Featured media -->
				<?php echo $image; ?>
      </figure>
      <hr>
		</section>
    <section class="contents">
    	<!-- Post content -->
  		<p><?php echo $description; ?></p>
    </section>
    <hr>
    <!-- Share buttons-->
    <?php smoke_share_buttons(); ?>
    <hr class="big">
  <?php } else { ?>
        <!-- No show found! -->
  <?php } ?>
    </main>
    <sidebar>
      <?php dynamic_sidebar('radio'); ?>
    </sidebar>
  </article>

<?php get_footer(); ?>
