<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}
$options = array(
	'general-tab' => array(
		'title'   => '',
		'type'    => 'box',
		'options' => array(
			'post_types' => array(
				'label'   => __( 'Activate for', 'fw' ),
				'type'    => 'checkboxes',
				'choices' => fw_ext_feedback_get_allowed_post_types(),
				'value'   => array(
					'post' => true
				),
				'desc'    => __( 'Select the options you want the Feedback extension to be activated for', 'fw' )
			),
			apply_filters( 'fw_ext_feedback_settings_options', array() )
		)
	)
);