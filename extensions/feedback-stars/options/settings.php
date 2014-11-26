<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

$options['feedback_stars_stars_number'] = array(
	'label'   => __( 'Rating System', 'fw' ),
	'type'    => 'radio-text',
	'value'   => '5',
	'desc'    => __( 'Enter the number of stars you want in the rating system', 'fw' ),
	'choices' => array(
		'5'  => __( '5 stars', 'fw' ),
		'7'  => __( '7 stars', 'fw' ),
		'10' => __( '10 stars', 'fw' ),
	),
);