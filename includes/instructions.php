<?php

$format_types = array(
	__( 'Dates', 'captain-countdown' ) => array(
		'n/j/Y',
		'F j, Y',
		'Y-m-d'
	),
	__( 'Times', 'captain-countdown' ) => array(
		'g:i a',
		'H:i:s',
		'H:i'
	)
);

$colors = array(
	'#000000' => 'Black',
	'#FFFFFF' => 'White',
	'#FF0000' => 'Red',
	'#00FF00' => 'Green',
	'#0000FF' => 'Blue'
);

$title =  __( 'Countdown To My Special Day!', 'captain-countdown' );

$offsets = $this->get_offsets();
$gm_date = gmdate( 'Y-m-d H:i:s' );
$my_date = $this->get_my_date( $gm_date );

?>

<div class='wrap'>

	<h2>
		Captain Countdown Clock <?php _e( 'Instructions', 'captain-countdown' ); ?>
	</h2>

	<p>
		<strong>
			<?php _e( 'First, let\'s make sure your website shows the time you want it to show', 'captain-countdown' ); ?>:
		</strong>
	</p>

	<form id="captain-countdown-settings-form" method="post" action="options.php" autocomplete="off">
		<?php

		settings_fields( 'captain_countdown_settings' );
		do_settings_sections( 'captain_countdown_settings' );

		?>
		<input id="captain-countdown-offset" type="hidden" value="" name="captain_countdown_offset">
	</form>

	<div class="captain-countdown-code">
		<form autocomplete="off">
			<table class="table">
				<tr>
					<th>
						<?php _e( 'Current time on your website/server', 'captain-countdown' ); ?>
					</th>
					<td>
						<div
							class="captain-countdown-timer"
							data-direction="up"
							data-datetime="<?php echo $gm_date; ?>"></div>
					</td>
				</tr>
				<tr>
					<th>
						<?php _e( 'Make adjustments as needed', 'captain-countdown' ); ?>
					</th>
					<td>
						<?php _e( 'The website/server date/time is', 'captain-countdown' ); ?>
						<select id="captain_countdown_over_under">
							<option value="over"<?php if ( $offsets[ \CaptainCountdown\Controller::OFFSET_OVER_UNDER ] != 'under' ) { ?> selected<?php } ?>>
								<?php _e( 'Ahead', 'captain-countdown' ); ?>
							</option>
							<option value="under"<?php if ( $offsets[ \CaptainCountdown\Controller::OFFSET_OVER_UNDER ] == 'under' ) { ?> selected<?php } ?>>
								<?php _e( 'Behind', 'captain-countdown' ); ?>
							</option>
						</select>
						<br>
						<?php _e( 'by', 'captain-countdown' ); ?>
						<select id="captain_countdown_years">
							<?php for ($x=0; $x<=100; $x++) { ?>
								<option value="<?php echo $x; ?>"<?php if ( $offsets[ \CaptainCountdown\Controller::OFFSET_YEARS ] == $x ) { ?> selected<?php } ?>>
									<?php echo $x; ?>
									<?php _e( 'yr(s)', 'captain-countdown' ); ?>
								</option>
							<?php } ?>
						</select>
						<select id="captain_countdown_days">
							<?php for ($x=0; $x<=364; $x++) { ?>
								<option value="<?php echo $x; ?>"<?php if ( $offsets[ \CaptainCountdown\Controller::OFFSET_DAYS ] == $x ) { ?> selected<?php } ?>>
									<?php echo $x; ?>
									<?php _e( 'day(s)', 'captain-countdown' ); ?>
								</option>
							<?php } ?>
						</select>
						<select id="captain_countdown_hours">
							<?php for ($x=0; $x<=23; $x++) { ?>
								<option value="<?php echo $x; ?>"<?php if ( $offsets[ \CaptainCountdown\Controller::OFFSET_HOURS ] == $x ) { ?> selected<?php } ?>>
									<?php echo $x; ?>
									<?php _e( 'hr(s)', 'captain-countdown' ); ?>
								</option>
							<?php } ?>
						</select>
						<select id="captain_countdown_minutes">
							<?php for ($x=0; $x<=59; $x++) { ?>
								<option value="<?php echo $x; ?>"<?php if ( $offsets[ \CaptainCountdown\Controller::OFFSET_MINUTES ] == $x ) { ?> selected<?php } ?>>
									<?php echo $x; ?>
									<?php _e( 'min(s)', 'captain-countdown' ); ?>
								</option>
							<?php } ?>
						</select>
						<select id="captain_countdown_seconds">
							<?php for ($x=0; $x<=59; $x++) { ?>
								<option value="<?php echo $x; ?>"<?php if ( $offsets[ \CaptainCountdown\Controller::OFFSET_SECONDS ] == $x ) { ?> selected<?php } ?>>
									<?php echo $x; ?>
									<?php _e( 'sec(s)', 'captain-countdown' ); ?>
								</option>
							<?php } ?>
						</select>
					</td>
				</tr>
				<tr>
					<th></th>
					<td>
						<input name="submit" id="captain-countdown-settings-submit" class="button button-primary" value="<?php _e( 'Save Adjustments', 'captain-countdown' ); ?>" type="submit">
					</td>
				</tr>
				<tr>
					<th>
						<?php _e( 'Time that will be shown to your visitors', 'captain-countdown' ); ?>
					</th>
					<td>
						<div
							class="captain-countdown-timer"
							data-direction="up"
							data-datetime="<?php echo $my_date; ?>"></div>
					</td>
				</tr>
			</table>
		</form>
	</div>

	<p>
		<strong>
			<?php _e( 'Add the following shortcode to your page', 'captain-countdown' ); ?>:
		</strong>
	</p>

	<p class="captain-countdown-code">

		[captain_countdown date="<?php echo date( $format_types[ __( 'Dates', 'captain-countdown' ) ][0], time() ); ?>" time="5:00 pm" title="<?php echo $title; ?>" format="usa"]

	</p>

	<p>
		<strong>
			<?php _e( 'Most date and time formats will work', 'captain-countdown' ); ?>:
		</strong>
	</p>

	<blockquote>
		<?php foreach ( $format_types as $type => $formats ) { ?>
			<strong>
				<?php echo $type; ?>
			</strong>
			<blockquote>
				<?php foreach ($formats as $format) { ?>
					<li>
						<?php echo date( $format, strtotime( date( 'Y-m-d' ) . ' 17:00:00' ) ); ?>
					</li>
				<?php } ?>
			</blockquote>
		<?php } ?>
	</blockquote>

	<p>
		<strong>
			<?php _e( 'Note', 'captain-countdown' ); ?>:
		</strong>
		<?php _e( 'The "date" option is required and the "time" option is optional.', 'captain-countdown' ); ?>
	</p>

	<p>
		<strong>
			<?php _e( 'If you specify "usa" for the format, your date will look like this', 'captain-countdown' ); ?>:
		</strong>
	</p>
	<blockquote>
		<?php echo $this->months[ date('n') ] . ' ' . date( 'j, Y' ); ?>
	</blockquote>

	<p>
		<strong>
			<?php _e( 'Leave the format attribute blank (or remove it completely) for the default date display', 'captain-countdown' ); ?>:
		</strong>
	</p>
	<blockquote>
		<?php echo date( 'j' ) . ' ' .$this->months[ date('n') ] . ' ' . date( 'Y' ); ?>
	</blockquote>

	<h3>
		<?php _e( 'Other Shortcode Options', 'captain-countdown' ); ?>
	</h3>

	<p>
		<strong>
			<?php _e( 'Change the background color or image (default is none)', 'captain-countdown' ); ?>:
		</strong>
	</p>

	<p class="captain-countdown-code">

		[captain_countdown date="<?php echo date( $format_types[ __( 'Dates', 'captain-countdown' ) ][0], time() ); ?>" title="<?php echo $title; ?>" background="#FF0000"]

	</p>

	<p class="captain-countdown-code">

		[captain_countdown date="<?php echo date( $format_types[ __( 'Dates', 'captain-countdown' ) ][0], time() ); ?>" title="<?php echo $title; ?>" background="http://mysite.com/path/to/background.png"]

	</p>

	<p>
		<strong>
			<?php _e( 'Change the text color (default is black)', 'captain-countdown' ); ?>:
		</strong>
	</p>

	<p class="captain-countdown-code">

		[captain_countdown date="<?php echo date( $format_types[ __( 'Dates', 'captain-countdown' ) ][0], time() ); ?>" title="<?php echo $title; ?>" text="#FFFFFF"]

	</p>

	<p>
		<strong>
			<?php _e( 'Change the border color (default is none)', 'captain-countdown' ); ?>:
		</strong>
	</p>

	<p class="captain-countdown-code">

		[captain_countdown date="<?php echo date( $format_types[ __( 'Dates', 'captain-countdown' ) ][0], time() ); ?>" title="<?php echo $title; ?>" border="#000000"]

	</p>

	<p>
		<strong>
			<?php _e( 'You can use common color names instead of hex values as well', 'captain-countdown' ); ?>:
		</strong>
	</p>

	<blockquote>
		<?php foreach ( $colors as $hex => $name ) { ?>
			&raquo;
			<?php _e( 'Use', 'captain-countdown' ); ?>
			"<?php echo $hex; ?>"
			<?php _e( 'or', 'captain-countdown' ); ?>
			"<?php echo $name; ?>"
			<?php _e( 'for', 'captain-countdown' ); ?>
			<?php _e( $name, 'captain-countdown' ); ?>
			<br>
		<?php } ?>
	</blockquote>

	<p>
		<a href="http://www.w3schools.com/colors/colors_hex.asp" target="_blank"><?php _e( 'Click here', 'captain-countdown' ); ?></a>
		<?php _e( 'for more color options.', 'captain-countdown' ); ?>
	</p>

</div>