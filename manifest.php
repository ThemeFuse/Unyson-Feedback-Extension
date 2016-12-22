<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

$manifest = array();

$manifest['name']        = __( 'FeedBack', 'fw' );
$manifest['description'] = __( 'Adds the possibility to leave feedback (comments, reviews and rating) about your products, articles, etc. This replaces the default comments system.', 'fw' );
$manifest['version'] = '1.0.13';
$manifest['display'] = true;
$manifest['standalone'] = true;
$manifest['github_repo'] = 'https://github.com/ThemeFuse/Unyson-Feedback-Extension';
$manifest['uri'] = 'http://manual.unyson.io/en/latest/extension/feedback/index.html#content';
$manifest['author'] = 'ThemeFuse';
$manifest['author_uri'] = 'http://themefuse.com/';

$manifest['github_update'] = 'ThemeFuse/Unyson-Feedback-Extension';
