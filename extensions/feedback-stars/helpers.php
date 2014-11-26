<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

/**
 * Returns brief information about the votes on a post.
 * @param null $post
 *
 * @return mixed
 */
function fw_ext_feedback_stars_get_post_rating( $post = null ) {
	/** @var $instance FW_Extension_FeedBack_Stars */
	$instance = fw()->extensions->get( 'feedback-stars' );

	return $instance->get_post_rating( $post );
}

/**
 * Returns detailed information about the votes on a post.
 * @param null $post
 *
 * @return mixed
 */
function fw_ext_feedback_stars_get_post_detailed_rating( $post ) {
	/** @var $instance FW_Extension_FeedBack_Stars */
	$instance = fw()->extensions->get( 'feedback-stars' );

	return $instance->get_post_detailed_rating( $post );
}
