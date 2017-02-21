<?php
// Meta boxes for the live event custom post type

// Register a meta box to contain fields for adding custom post meta
	add_action( 'add_meta_boxes', 'live_meta_box_setup' );
	function live_meta_box_setup()
	{
		add_meta_box( 'smoke_post_options', 'Live Event Options', 'live_post_options_content', 'live', 'side', 'high');
	}

// Callback function to fill the meta box with form input content, passing in the post object
	function live_post_options_content( $post )
	{
	// Fetch all post meta data and save as an array var
		$values = get_post_custom( $post->ID );
		// Save current values of particular meta keys as variables for display
    $feat_image_credit = isset( $values['feat_image_credit'] ) ? esc_attr( $values['feat_image_credit'][0] ) : "";
    $feat_video_url = isset( $values['feat_video_url'] ) ? esc_attr( $values['feat_video_url'][0] ) : "";
    $smoke_promoted = isset( $values['smoke_promoted'] ) ? $values['smoke_promoted'][0] : "";

	//What a nonce
		wp_nonce_field( 'smoke_post_options_nonce', 'meta_box_nonce' );
		// Display input fields, using variables above to show current values
	    ?>
			<p class="description">Use these controls to customise the live event.</p>
      <p>
        <label for="smoke_promoted">Promoted</label><br/>
        <input type="checkbox" id="smoke_promoted" name="smoke_promoted" <?php checked( $smoke_promoted, 'on' ); ?> />
        <p class="description">Send this article to the top of the homepage.</p>
        <hr>
      </p>
			<p>
		    <label for="feat_image_credit">Featured image credit</label><br/>
		    <input type="text" name="feat_image_credit" id="feat_image_credit" value="<?php echo $feat_image_credit; ?>"/>
			</p>
			<hr>
			<p>
				<label for="feat_video_url">Featured livestream URL</label><br/>
				<input type="text" name="feat_video_url" id="feat_video_url" value="<?php echo $feat_video_url; ?>"/>
			</p>
				<p class="description">Include a livestream video URL here to replace the featured image with other media.</p>
				<p class="description">A featured image <b>MUST</b> still be set.</p>
        <?php
	}

// Having registered the meta box and filled it with content, now we save the form inputs to the post meta table
	add_action( 'save_post', 'live_post_options_save' );
	// A function to save form inputs to the database
	function live_post_options_save( $post_id ){
		// If this is an autosave, do nothing
		if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
		// Verify the nonce before proceeding

		// if( !isset( $_POST['meta_box_nonce'] ) || !wp_verify_nonce( $_POST['meta_box_nonce'], 'my_meta_box_nonce' ) ) return;

		// Check user permissions before proceeding
		if( !current_user_can( 'edit_post' ) ) return;

    $allowed = array(
        'a' => array( // on allow a tags
            'href' => array() // and those anchors can only have href attribute
        )
    );
    // Save featured image credit field
    if( isset( $_POST['feat_image_credit'] ) )
        update_post_meta( $post_id, 'feat_image_credit', wp_kses( $_POST['feat_image_credit'], $allowed ) );
		// Save video ID field
    if( isset( $_POST['feat_video_url'] ) )
        update_post_meta( $post_id, 'feat_video_url', wp_kses( $_POST['feat_video_url'], $allowed ) );
    // Save promoted field
		$chk2 = isset( $_POST['smoke_promoted'][0] ) ? 'on' : 'off';
    	update_post_meta( $post_id, 'smoke_promoted', $chk2 );
	}
