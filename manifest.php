<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

$manifest = array();

$manifest['name']        = __( 'FeedBack', 'fw' );
$manifest['description'] = __( 'Adds the possibility to leave feedback (comments, reviews and rating) about your products, articles, etc. This replaces the default comments system.', 'fw' );
$manifest['version'] = '1.0.10';
$manifest['display'] = true;
$manifest['standalone'] = true;

$manifest['github_update'] = 'ThemeFuse/Unyson-Feedback-Extension';
