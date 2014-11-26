<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

/**
 * Returns a custom Walker class object to use when rendering the reviews.
 */
function fw_ext_feedback_get_listing_walker() {
	return apply_filters( 'fw_ext_feedback_listing_walker', new Walker_Comment() );
}

/**
 * Returns array of post types that can accept feedback.
 */
function fw_ext_feedback_get_allowed_post_types() {
	$post_types = get_post_types( array(
			'public' => true
		), 'objects'
	);

	unset( $post_types['attachment'] );

	$result     = array();
	foreach ( $post_types as $key => $post_type ) {
		$result[ $key ] = $post_type->labels->name;
	}

	return $result;
}

/**
 * Displays information about the feedback for a specific post.
 *
 * @param null $post
 *
 * @return null
 */
function fw_ext_feedback( $post = null ) {

	if ( null === $post ) {
		$post = get_the_ID();
	}

	/** @var $feedback FW_Extension_FeedBack_Stars */
	$feedback = fw()->extensions->get( 'feedback' );

	if ( ! is_numeric( $post ) || ! post_type_supports( get_post_type( $post ), $feedback->supports_feature_name ) ) {
		echo '';
	} else {
		echo apply_filters( 'fw_ext_feedback', '', $post );
	}
}