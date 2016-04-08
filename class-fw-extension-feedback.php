<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

class FW_Extension_FeedBack extends FW_Extension {

	/**
	 * Feature name for post type's, to activate the module for a post type, you must use add_post_type_support () in action 'init'. This module will be replace the default comments.
	 * http://codex.wordpress.org/Function_Reference/add_post_type_support
	 * @var string
	 */
	public $supports_feature_name = 'fw-feedback';

	/**
	 * If currently global $post accept reviews
	 * @var bool
	 */
	public $accept_feedback = false;

	/**
	 * @internal
	 */
	public function _init() {
		{
			add_action( 'wp', array( $this, '_action_global_post_is_available' ) );
			add_action( 'wp_insert_comment', array( $this, '_action_wp_insert_comment' ), 9999, 2 );
			add_action( 'transition_comment_status', array( $this, '_action_transition_comment_status' ), 9999, 3 );
			add_action( 'init', array( $this, '_action_add_feedback_support' ), 9999 );
			add_action( 'admin_menu', array( $this, '_action_change_menu_label' ) );
		}

		{
			add_filter( 'preprocess_comment', array( $this, '_filter_pre_process_comment' ) );
			add_filter( 'admin_comment_types_dropdown', array( $this, '_filter_admin_comment_types_drop_down' ) );
			add_filter( 'comments_template', array( $this, '_filter_change_comments_template') );
			add_filter( 'get_avatar_comment_types', array( $this, '_filter_get_avatar_comment_types') );
		}
	}

	/**
	 * Registers support of feedback for post types checked in dashboard.
	 * @internal
	 */
	public function _action_add_feedback_support(){

		$post_types = fw_get_db_ext_settings_option( 'feedback', 'post_types', array('post' => true) );

		foreach ( $post_types as $slug => $value ) {
			add_post_type_support( $slug, 'comments' );
			add_post_type_support( $slug, $this->supports_feature_name );
		}
	}

	public function _action_change_menu_label() {
			global $menu;
			$menu[25][0] =  __( 'Feedback', 'fw' );
	}

	public function _filter_pre_process_comment( $comment_data ) {
		if ( post_type_supports( get_post_type( $comment_data['comment_post_ID'] ), $this->supports_feature_name ) ) {
			$comment_data['comment_type'] = $this->supports_feature_name;
		}

		return $comment_data;
	}


	/**
	 * @internal
	 */
	public function _filter_get_avatar_comment_types( $types ) {
		array_push( $types, $this->supports_feature_name );
		return $types;
	}

	/**
	 * The path to the file for listing of reviews.
	 *
	 * @param $theme_template
	 * @internal
	 * @return string
	 */
	public function _filter_change_comments_template( $theme_template ) {
		global $post;

		if ( post_type_supports( $post->post_type, $this->supports_feature_name ) ) {
			$view = $this->locate_view_path( 'reviews' );

			return ( $view ) ? $view : $theme_template;
		}

		return $theme_template;
	}

	/**
	 * @param $comment_types
	 * @internal
	 * @return mixed
	 */
	public function _filter_admin_comment_types_drop_down( $comment_types ) {

		if ( $this->feedback_on ) {
			$comment_types[ $this->supports_feature_name ] = __( 'Reviews', 'fw' );
		}

		return $comment_types;
	}

	/**
	 * Executed when global $post is available
	 */
	public function _action_global_post_is_available() {
		global $post;

		$this->accept_feedback = $post && post_type_supports( get_post_type( $post->ID ), $this->supports_feature_name );

		if ( ! ( $this->accept_feedback && $this->user_bought_product() ) ) {
			return;
		}
	}

	/**
	 * Check if user bought the current viewing product
	 */
	public function user_bought_product( $post_id = null, $user_id = null ) {
		return true;

	}

	/**
	 * Executed when new comment is posted
	 *
	 * @param int $comment_id
	 * @param object $comment
	 */
	public function _action_wp_insert_comment( $comment_id, $comment ) {

		if ( ! post_type_supports( get_post_type( $comment->comment_post_ID ), $this->supports_feature_name ) ) {
			return;
		}

		/** @var int $post_id */
		$post_id = $comment->comment_post_ID;
		/** @var int $user_id */
		$user_id = $comment->user_id;

		/** validate (decide if allow to create feedback) */
		do {
			$allow = true;

			if ( ! $this->user_bought_product( $post_id, $user_id ) ) {
				// cheater, does not bought product, but tries to post comment with injected form in html
				$allow = false;
				break;
			}

			/** to prevent the creation of responses to feedback */
			if ($comment->comment_parent != 0) {
				$allow = false;
				break;
			}

		} while ( false );


		$allow = apply_filters( 'fw_ext_feedback_allow_create', $allow, array(
			'feedback_id' => $comment_id,
			'post_id'     => $post_id,
			'user_id'     => $user_id,
			'comment'     => $comment
		) );

		if ( ! $allow ) {
			// delete this comment
			wp_delete_comment( $comment_id, true );

			return;
		}

		/**
		 * remove previous comments by this user on this post, only last feedback is saved
		 * user is allowed to have only one feedback per post
		 */
		if (apply_filters('fw:ext:feedback:remove-previous-comments', true, array(
			'post_id' => $post_id,
			'comment' => $comment,
		))) {
			foreach (
				get_comments(array(
					'post_id' => $post_id,
					'author_email' => $comment->comment_author_email
				)) as $cmnt
			) {
				/** @var object $cmnt */
				if ($comment_id != $cmnt->comment_ID) { // do not delete current comment
					wp_delete_comment($cmnt->comment_ID, true);
				}
			}
		}

		/** everything is ok, tell sub-modules to save other inputs values (feedback-stars, etc.) */

		do_action( 'fw_ext_feedback_insert', $comment_id, array(
			'active'  => is_numeric( $comment->comment_approved ) && $comment->comment_approved == 1,
			'post_id' => $post_id,
			'user_id' => $user_id
		) );
	}

	/**
	 * When comments status changed
	 * Only two states:
	 ** active   - true
	 ** inactive - false
	 *
	 * @param string $new_status
	 * @param string $old_status
	 * @param object $comment
	 */
	public function _action_transition_comment_status( $new_status, $old_status, $comment ) {
		if ( ! post_type_supports( get_post_type( $comment->comment_post_ID ), $this->supports_feature_name ) ) {
			return;
		}

		$active = $new_status === 'approved';

		do_action( 'fw_ext_feedback_status_changed', $active,
			array(
				'feedback_id' => $comment->comment_ID,
				'post_id'     => $comment->comment_post_ID,
			),
			array(
				'comment'            => $comment,
				'comment_status_new' => $new_status,
				'comment_status_old' => $old_status,
			)
		);
	}

	/**
	 * {@inheritdoc}
	 */
	public function _get_link() {
		return self_admin_url('edit-comments.php');
	}
}