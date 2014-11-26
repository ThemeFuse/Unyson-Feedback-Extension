<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

/**
 * The path to the file for listing of reviews.
 * @param $theme_template
 * @return string
 */
function fw_ext_feedback_filter_change_comments_template( $theme_template ) {
	global $post;
	/** @var FW_Extension_FeedBack $ext_instance */
	$ext_instance = fw()->extensions->get( 'feedback' );

	if ( post_type_supports( $post->post_type, $ext_instance->supports_feature_name ) ) {
		$view = $ext_instance->locate_view_path('reviews');
		return ($view) ? $view : $theme_template;
	}

	return $theme_template;
}

add_filter( 'comments_template', 'fw_ext_feedback_filter_change_comments_template' );

/**
 * Registers support of feedback for post types checked in dashboard.
 */
function fw_ext_feedback_add_support() {

	/** @var FW_Extension_FeedBack $extension */
	$extension_instance = fw()->extensions->get( 'feedback' );

	$post_types = fw_get_db_ext_settings_option( 'feedback', 'post_types' );

	foreach ( $post_types as $slug => $value ) {
		add_post_type_support( $slug, 'comments' );
		add_post_type_support( $slug, $extension_instance->supports_feature_name );
	}
}

add_action( 'init', 'fw_ext_feedback_add_support' );


function fw_ext_feedback_filter_get_avatar_comment_types( $types ) {
	/** @var FW_Extension_FeedBack $extension */
	$extension_instance = fw()->extensions->get( 'feedback' );
	array_push( $types, $extension_instance->supports_feature_name );

	return $types;
}

add_filter( 'get_avatar_comment_types', 'fw_ext_feedback_filter_get_avatar_comment_types' );
