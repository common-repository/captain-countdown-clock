<?php

$container_styles = array();
$div_styles = array();

if ( strlen( $this->get_attribute( 'background' ) ) > 0 )
{
	if ( substr( $this->get_attribute( 'background' ), 0, 1 ) == '/' || substr( $this->get_attribute( 'background' ), 0, 4 ) == 'http' )
	{
		$container_styles[] = 'background:url(' . $this->get_attribute( 'background' ) . ')';
	}
	else
	{
		$container_styles[] = 'background:' . $this->get_attribute( 'background' );
	}
}
if ( strlen( $this->get_attribute( 'text' ) ) > 0 )
{
	$container_styles[] = 'color:' . $this->get_attribute( 'text' );
	$div_styles[] = 'color:' . $this->get_attribute( 'text' );
}
if ( strlen( $this->get_attribute( 'border' ) ) > 0 )
{
	$container_styles[] = 'border:1px solid ' . $this->get_attribute( 'border' );
}

$today_date = $this->get_my_date();
$target_date = $this->get_attribute( 'date' ) . ( ( strlen( $this->get_attribute( 'time' ) ) > 0 ) ? ' ' . $this->get_attribute( 'time' ) : ' 00:00:00' );

if ( strtotime( $today_date ) >= strtotime( $target_date ) )
{
	return;
}

$difference = strtotime( $target_date ) - strtotime( $today_date );
$date_parts = $this->get_date_parts( $difference );

?>

<div class="captain-countdown-container" style="<?php echo implode( ';', $container_styles ); ?>">
	<?php if ( strlen( $this->get_attribute( 'title' ) ) > 0 ) { ?>
		<div class="captain-countdown-title" style="<?php echo implode( ';', $div_styles ); ?>">
			<?php echo strip_tags( $this->get_attribute( 'title' ) ); ?>
		</div>
	<?php } ?>
	<div class="captain-countdown-counter" style="<?php echo implode( ';', $div_styles ); ?>">
		<div class="timerSupport">
			If captain countdown clock is not working please visit <a href="http://www.thetimenow.com/javascript/clock" rel="nofollow" target="_blank">TheTimeNow Javascript Clocks</a> for support.
		</div>
		<div
			class="captain-countdown-timer"
			data-direction="down"
			data-datetime="<?php echo $today_date; ?>"
			data-target="<?php echo $target_date; ?>">

			<?php if ( $date_parts['years'] > 0 ) { ?>
				<span class="captain-countdown-years" data-singular="<?php _e( 'Year', 'captain-countdown' ); ?>" data-plural="<?php _e( 'Years', 'captain-countdown' ); ?>">
					<?php echo $date_parts['years'] . ' ' . ( ( $date_parts['years'] == 1 ) ? __( 'Year', 'captain-countdown' ) : __( 'Years', 'captain-countdown' ) ); ?>
					<br>
				</span>
			<?php } ?>

			<span class="captain-countdown-days" data-singular="<?php _e( 'Day', 'captain-countdown' ); ?>" data-plural="<?php _e( 'Days', 'captain-countdown' ); ?>">
				<?php if ( $date_parts['days'] > 0 ) { ?>
					<?php echo $date_parts['days'] . ' ' . ( ( $date_parts['days'] == 1 ) ? __( 'Day', 'captain-countdown' ) : __( 'Days', 'captain-countdown' ) ); ?>
					<br>
				<?php } ?>
			</span>

			<span class="captain-countdown-time">
				<?php

				echo str_pad( $date_parts['hours'], 2, '0', STR_PAD_LEFT);
				echo ':';
				echo str_pad( $date_parts['minutes'], 2, '0', STR_PAD_LEFT);
				echo ':';
				echo str_pad( $date_parts['seconds'], 2, '0', STR_PAD_LEFT);

				?>
			</span>

		</div>
	</div>
	<div class="captain-countdown-date" style="<?php echo implode( ';', $div_styles ); ?>">
		<?php echo date( ( ( $this->get_attribute( 'format' ) == 'usa' ) ? 'F j, Y' : 'j F Y' ), strtotime( $this->get_attribute( 'date' ) ) ); ?>
		<?php if ( strlen( $this->get_attribute( 'time' ) ) > 0 ) { ?>
			<br><?php echo date( 'g:i a', strtotime( $this->get_attribute( 'time' ) ) ); ?>
		<?php } ?>
	</div>
</div>