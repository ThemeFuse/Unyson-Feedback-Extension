<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}
/**
 * Displays information about the votes allocated to a post.
 * @var int $stars_number
 * @var array $rating
 */
if(!intval($rating['count'])) {
	return;
}
?>
<!--Rating-->
<div class="wrap-rating header qtip-rating">
	<div class="rating">
		<?php for ( $i = 1; $i <= $stars_number; $i ++ ) {
			$voted = ( $i <= round( $rating['average'] ) ) ? ' voted' : '';
			echo '<span class="fa fa-star' . $voted . '" data-vote="' . $i . '"></span>';
		}?>
	</div>
	<input type="hidden" name="rate" id="rate" value="5">
</div>
<div class="qtip-rating-html">
	<span class="title-tip"><?php echo round($rating['average'], 2); ?> <?php echo sprintf(__('Based on %s Votes', 'fw'), $rating['count']); ?></span>
	<ul class="list-note">
			<?php   foreach($rating['stars'] as $star => $info) : ?>
						<li>
							<span class="note"><?php echo $star;?> <i class="fa fa-star"></i></span>
							<div class="wrap-bar">
								<span class="rating-bar"></span>
								<span class="rating-bar-progress" style="width: <?php echo esc_attr($info['as_percentage']); ?>%;"></span>
							</div>
							<span class="total"><?php echo $info['count']; ?></span>
						</li>
			<?php	endforeach; ?>
		<?php

		?>
	</ul>
</div>
<!--/Rating-->