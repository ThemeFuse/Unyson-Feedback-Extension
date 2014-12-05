<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

function _action_fw_ext_feedback_stars_fw_ext_feedback_listing_walker() {
	require dirname( __FILE__ ) . '/includes/extends/class-fw-feedback-stars-walker.php';

	return new FW_Feedback_Stars_Walker();
}

add_filter( 'fw_ext_feedback_listing_walker', '_action_fw_ext_feedback_stars_fw_ext_feedback_listing_walker' );