<?php

class FW_Feedback_Stars_Walker extends Walker_Comment {
	/**
	 * Output a comment in the HTML5 format.
	 *
	 * @access protected
	 * @since 3.6.0
	 *
	 * @see wp_list_comments()
	 *
	 * @param object $comment Comment to display.
	 * @param int $depth Depth of comment.
	 * @param array $args An array of arguments.
	 */
	protected function html5_comment( $comment, $depth, $args ) {
		/** @var $ext_instance FW_Extension_FeedBack_Stars */
		$ext_instance = fw()->extensions->get( 'feedback-stars' );
		if ( file_exists( $ext_instance->locate_view_path( 'listing-review-html5' ) ) ) {
			fw_render_view( $ext_instance->locate_view_path( 'listing-review-html5' ), array(
				'comment'      => $comment,
				'depth'        => $depth,
				'args'         => $args,
				'has_children' => $this->has_children,
				'stars_number' => $ext_instance->get_max_rating(),
				'rate'         => get_comment_meta( $comment->comment_ID, $ext_instance->field_name, true )
			), false );

			return;
		};
		$tag = ( 'div' === $args['style'] ) ? 'div' : 'li';
		?>
		<<?php echo $tag; ?> id="comment-<?php comment_ID(); ?>" <?php comment_class( $this->has_children ? 'parent' : '' ); ?>>
		<article id="div-comment-<?php comment_ID(); ?>" class="comment-body">
			<footer class="comment-meta">
				<div class="comment-author vcard">
					<?php if ( 0 != $args['avatar_size'] ) {
						echo get_avatar( $comment, $args['avatar_size'] );
					} ?>
					<?php echo '<b class="fn">' . get_comment_author_link() .'</b> <span class="says">' . __( 'says', 'fw' ).':</span>'; ?>
				</div>
				<!-- .comment-author -->

				<div class="comment-metadata">
					<a href="<?php echo esc_url( get_comment_link( $comment->comment_ID, $args ) ); ?>">
						<time datetime="<?php comment_time( 'c' ); ?>">
							<?php printf( _x( '%1$s at %2$s', '1: date, 2: time', 'fw' ), get_comment_date(), get_comment_time() ); ?>
						</time>
					</a>
					<?php edit_comment_link( __( 'Edit', 'fw' ), '<span class="edit-link">', '</span>' ); ?>

				</div>
				<!-- .comment-metadata -->

				<?php if ( '0' == $comment->comment_approved ) : ?>
					<p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'fw' ); ?></p>
				<?php endif; ?>
			</footer>
			<!-- .comment-meta -->

			<div class="comment-content">
				<?php comment_text(); ?>
			</div>
			<!-- .comment-content -->

			<div class="reply">
				<?php comment_reply_link( array_merge( $args, array(
					'add_below' => 'div-comment',
					'depth'     => $depth,
					'max_depth' => $args['max_depth']
				) ) ); ?>
			</div>
			<!-- .reply -->
		</article><!-- .comment-body -->
	<?php
	}

	/**
	 * Output a single comment.
	 *
	 * @access protected
	 * @since 3.6.0
	 *
	 * @see wp_list_comments()
	 *
	 * @param object $comment Comment to display.
	 * @param int    $depth   Depth of comment.
	 * @param array  $args    An array of arguments.
	 */
	protected function comment( $comment, $depth, $args ) {
		/** @var $ext_instance FW_Extension_FeedBack_Stars */
		$ext_instance = fw()->extensions->get( 'feedback-stars' );
		if ( file_exists( $ext_instance->locate_view_path( 'listing-review-html5' ) ) ) {
			fw_render_view( $ext_instance->locate_view_path( 'listing-review' ), array(
				'comment'      => $comment,
				'depth'        => $depth,
				'args'         => $args,
				'has_children' => $this->has_children,
				'stars_number' => $ext_instance->get_max_rating(),
				'rate'         => get_comment_meta( $comment->comment_ID, $ext_instance->field_name, true )
			), false );

			return;
		};
		if ( 'div' == $args['style'] ) {
			$tag = 'div';
			$add_below = 'comment';
		} else {
			$tag = 'li';
			$add_below = 'div-comment';
		}
		?>
		<<?php echo $tag; ?> <?php comment_class( $this->has_children ? 'parent' : '' ); ?> id="comment-<?php comment_ID(); ?>">
		<?php if ( 'div' != $args['style'] ) : ?>
			<div id="div-comment-<?php comment_ID(); ?>" class="comment-body">
		<?php endif; ?>
		<div class="comment-author vcard">
			<?php if ( 0 != $args['avatar_size'] ) echo get_avatar( $comment, $args['avatar_size'] ); ?>
			<?php echo '<cite class="fn">' . get_comment_author_link() . '</cite> <span class="says">' . __( 'says', 'fw' ) . ':</span>' ?>
		</div>
		<?php if ( '0' == $comment->comment_approved ) : ?>
			<em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'fw' ) ?></em>
			<br />
		<?php endif; ?>

		<div class="comment-meta commentmetadata"><a href="<?php echo esc_url( get_comment_link( $comment->comment_ID, $args ) ); ?>">
				<?php
				/* translators: 1: date, 2: time */
				printf( __( '%1$s at %2$s', 'fw' ), get_comment_date(),  get_comment_time() ); ?></a><?php edit_comment_link( __( '(Edit)', 'fw' ), '&nbsp;&nbsp;', '' );
			?>
		</div>

		<?php comment_text( get_comment_id(), array_merge( $args, array( 'add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>

		<div class="reply">
			<?php comment_reply_link( array_merge( $args, array( 'add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
		</div>
		<?php if ( 'div' != $args['style'] ) : ?>
			</div>
		<?php endif; ?>
	<?php
	}
}