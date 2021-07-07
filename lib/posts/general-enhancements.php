<?php

//
//
// on upload, automatically add image title and alt
//
//
// add_action( 'add_attachment', 'my_set_image_meta_upon_image_upload' );
// function my_set_image_meta_upon_image_upload( $post_ID ) {

//   // Check if uploaded file is an image, else do nothing

// 	if ( wp_attachment_is_image( $post_ID ) ) {

// 		$my_image_title = get_post( $post_ID )->post_title;

// 		// Sanitize the title:  remove hyphens, underscores & extra spaces:
// 		$my_image_title = preg_replace( '%\s*[-_\s]+\s*%', ' ',  $my_image_title );

// 		// Sanitize the title:  capitalize first letter of every word (other letters lower case):
// 		$my_image_title = ucwords( strtolower( $my_image_title ) );

// 		// Create an array with the image meta (Title, Caption, Description) to be updated
// 		// Note:  comment out the Excerpt/Caption or Content/Description lines if not needed
// 		$my_image_meta = array(
// 			'ID'    => $post_ID,      // Specify the image (ID) to be updated
// 			'post_title'  => $my_image_title,   // Set image Title to sanitized title
// 			// 'post_excerpt'  => $my_image_title,   // Set image Caption (Excerpt) to sanitized title
// 			// 'post_content'  => $my_image_title,   // Set image Description (Content) to sanitized title
// 		);

// 		// Set the image Alt-Text
// 		update_post_meta( $post_ID, '_wp_attachment_image_alt', $my_image_title );

// 		// Set the image meta (e.g. Title, Excerpt, Content)
// 		wp_update_post( $my_image_meta );

// 	}
// }



//
//
// set updated featured image w/ acf image
//
//
function acf_set_featured_image( $value, $post_id, $field  ){
	$id = $value;
	if( ! is_numeric( $id ) ){
		$data = json_decode( stripcslashes($id), true );
		$id = $data['cropped_image'];
	}
	if($value){
		update_post_meta( $post_id, '_thumbnail_id', $id );
	}
	return $value;
}

// acf/update_value/name={$field_name} - filter for a specific field based on it's name
add_filter( 'acf/update_value/name=fancySquare_featured_img', 'acf_set_featured_image', 10, 3 );


function acf_set_featured_image_b( $value, $post_id, $field  ){
	$id = $value;
	if( ! is_numeric( $id ) ){
		$data = json_decode( stripcslashes($id), true );
		$id = $data['cropped_image'];
	}
	if($value){
		update_post_meta( $post_id, '_thumbnail_id', $id );
	}
	return $value;
}

// acf/update_value/name={$field_name} - filter for a specific field based on it's name
add_filter( 'acf/update_value/name=interviewee_image', 'acf_set_featured_image_b', 10, 3 );


//
//
// make jpeg quality 100 be default, smush after
//
//
add_filter('jpeg_quality', function($arg){return 100;});


//
//
// enque scripts
//
//
add_action( 'wp_enqueue_scripts', 'fancySquares_enqueue_scripts' );

function fancySquares_enqueue_scripts() {

	// wp_enqueue_script("vue-js", get_template_directory_uri () . "/public/scripts/vue.js",'',filemtime(get_stylesheet_directory() . '/public/scripts/vue.js'), true);
    // if(is_single()){
    //      wp_enqueue_script( 'wp-mediaelement' );
    //      wp_enqueue_style( 'wp-mediaelement' );
    // }


}

function replace_core_jquery_version() {
	wp_deregister_script( 'jquery-core' );
	wp_register_script( 'jquery-core', "https://code.jquery.com/jquery-3.1.1.min.js", array(), '3.1.1' );
	wp_deregister_script( 'jquery-migrate' );
	wp_enqueue_script( 'jquery-migrate', "https://code.jquery.com/jquery-migrate-3.0.0.min.js", array(), '3.0.0' );
}
add_action( 'wp_enqueue_scripts', 'replace_core_jquery_version' );


//
//
// clear transients automatically
//
//
// if ( ! function_exists('purge_transients') ) {
// 	function purge_transients($older_than = '12 hours', $safemode = true) {
// 		global $wpdb;
// 		$older_than_time = strtotime('-' . $older_than);
// 		if ($older_than_time > time() || $older_than_time < 1) {
// 			return false;
// 		}
// 		$transients = $wpdb->get_col(
// 			$wpdb->prepare( "
// 					SELECT REPLACE(option_name, '_transient_timeout_', '') AS transient_name
// 					FROM {$wpdb->options}
// 					WHERE option_name LIKE '\_transient\_timeout\__%%'
// 						AND option_value < %s
// 			", $older_than_time)
// 		);
// 		if ($safemode) {
// 			foreach($transients as $transient) {
// 				get_transient($transient);
// 			}
// 		} else {
// 			$options_names = array();
// 			foreach($transients as $transient) {
// 				$options_names[] = '_transient_' . $transient;
// 				$options_names[] = '_transient_timeout_' . $transient;
// 			}
// 			if ($options_names) {
// 				$options_names = array_map(array($wpdb, 'escape'), $options_names);
// 				$options_names = "'". implode("','", $options_names) ."'";

// 				$result = $wpdb->query( "DELETE FROM {$wpdb->options} WHERE option_name IN ({$options_names})" );
// 				if (!$result) {
// 					return false;
// 				}
// 			}
// 		}
// 		return $transients;
// 	}
// }
// function purge_transients_activation () {
// 	if (!wp_next_scheduled('purge_transients_cron')) {
// 		wp_schedule_event( time(), 'daily', 'purge_transients_cron');
// 	}
// }
// register_activation_hook(__FILE__, 'purge_transients_activation');
// function purge_transients_deactivation () {
// 	if (wp_next_scheduled('purge_transients_cron')) {
// 		wp_clear_scheduled_hook('purge_transients_cron');
// 	}
// }
// register_deactivation_hook(__FILE__, 'purge_transients_deactivation');
// function do_purge_transients_cron () {
// 	purge_transients();
// }
// add_action('purge_transients_cron', 'do_purge_transients_cron');
