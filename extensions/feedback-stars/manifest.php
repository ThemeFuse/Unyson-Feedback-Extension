<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

$manifest = array();

$manifest['name']        = __( 'FeedBack Stars', 'fw' );
$manifest['description'] = __( 'Allows visitors to appreciate a post using star rating', 'fw' );
$manifest['version'] = '1.0.0';
$manifest['display'] = 'feedback';
$manifest['standalone'] = true;
