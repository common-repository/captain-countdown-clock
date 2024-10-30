<?php

namespace CaptainCountdown;


class Controller {

	const VERSION = '1.0.6';
	const VERSION_JS = '1.0.1';
	const VERSION_CSS = '1.0.5';

	const OPTION_VERSION = 'captain_countdown_version';

	const OFFSET_YEARS = 0;
	const OFFSET_DAYS = 1;
	const OFFSET_HOURS = 2;
	const OFFSET_MINUTES = 3;
	const OFFSET_SECONDS = 4;
	const OFFSET_OVER_UNDER = 5;

	public $attributes;
	public $months;

	/**
	 *
	 */
	public function activate()
	{
		add_option( self::OPTION_VERSION, self::VERSION );
	}

	/**
	 *
	 */
	public function init()
	{
		$this->months = array(
			1 => __( 'January', 'captain-countdown' ),
			2 => __( 'February', 'captain-countdown' ),
			3 => __( 'March', 'captain-countdown' ),
			4 => __( 'April', 'captain-countdown' ),
			5 => __( 'May', 'captain-countdown' ),
			6 => __( 'June', 'captain-countdown' ),
			7 => __( 'July', 'captain-countdown' ),
			8 => __( 'August', 'captain-countdown' ),
			9 => __( 'September', 'captain-countdown' ),
			10 => __( 'October', 'captain-countdown' ),
			11 => __( 'November', 'captain-countdown' ),
			12 => __( 'December', 'captain-countdown' ),
		);

		wp_enqueue_script( 'captain-countdown-js', plugin_dir_url( dirname( __FILE__ ) ) . 'js/captain-countdown.js', array( 'jquery' ), (WP_DEBUG) ? time() : self::VERSION_JS, TRUE );
		wp_enqueue_script( 'captain-countdown-moment-js', plugin_dir_url( dirname( __FILE__ ) ) . 'js/moment.min.js', array(), (WP_DEBUG) ? time() : self::VERSION_JS, TRUE );
		wp_enqueue_style( 'captain-countdown-css', plugin_dir_url( dirname( __FILE__ ) ) . 'css/captain-countdown.css', array(), (WP_DEBUG) ? time() : self::VERSION_CSS );
	}

	/**
	 * @param $attributes
	 *
	 * @return string
	 */
	public function short_code( $attributes )
	{
		$this->attributes = shortcode_atts( array(
			'date' => date( 'n/j/Y', strtotime( date('n/j/Y') . ' + 1 year' ) ),
			'time' => '',
			'title' => '',
			'format' => '',
			'background' => '',
			'text' => '#000000',
			'border' => ''
		), $attributes );

		ob_start();
		include( dirname( __DIR__ ) . '/includes/shortcode.php');
		$output = ob_get_contents();
		ob_end_clean();
		return $output;
	}

	/**
	 * @param $attribute
	 *
	 * @return string
	 */
	public function get_attribute( $attribute )
	{
		if ( is_array( $this->attributes ) && array_key_exists( $attribute, $this->attributes ) )
		{
			return $this->attributes[ $attribute ];
		}

		return '';
	}

	/**
	 * @param array $links
	 *
	 * @return array
	 */
	public function instructions_link( $links )
	{
		$link = '<a href="options-general.php?page=' . plugin_basename( dirname( __DIR__ ) ) . '">' . __( 'Instructions', 'captain-countdown' ) . '</a>';
		$links[] = $link;
		return $links;
	}

	/**
	 *
	 */
	public function instructions_page()
	{
		add_options_page(
			'Captain Countdown Clock ' . __( 'Instructions', 'captain-countdown' ),
			'Captain Countdown',
			'manage_options',
			plugin_basename( dirname( __DIR__ ) ),
			array( $this, 'print_instructions_page')
		);
	}

	/**
	 *
	 */
	public function print_instructions_page()
	{
		include( dirname( __DIR__ ) . '/includes/instructions.php' );
	}

	public function register_settings()
	{
		register_setting( 'captain_countdown_settings', 'captain_countdown_offset' );
	}

	/**
	 * @return array
	 */
	public function get_offsets()
	{
		$offset = get_option( 'captain_countdown_offset' );
		$default_offsets = array(
			self::OFFSET_YEARS => 0,
			self::OFFSET_DAYS => 0,
			self::OFFSET_HOURS => 0,
			self::OFFSET_MINUTES => 0,
			self::OFFSET_SECONDS => 0,
			self::OFFSET_OVER_UNDER => 'over');

		if ( ! empty( $offset ) )
		{
			$offsets = explode( '|', $offset );
			if ( count( $offsets ) == 5 )
			{
				foreach ( $offsets as $index => $offset )
				{
					$default_offsets[ $index ] = ( ! is_numeric( $offset ) ) ? 0 : $offset;

					if ( $offset < 0 )
					{
						$default_offsets[ self::OFFSET_OVER_UNDER ] = 'under';
					}
				}
			}
		}

		return $default_offsets;
	}

	/**
	 * @param null $date
	 *
	 * @return bool|string
	 */
	public function get_my_date( $date=NULL )
	{
		$date = ( $date === NULL ) ? gmdate( 'Y-m-d H:i:s' ) : $date;
		$offsets = $this->get_offsets();
		$date = ( is_numeric( $date ) ) ? $date : strtotime( $date );
		foreach ( $offsets as $index => $offset )
		{
			if ( $offset != 0 )
			{
				switch ($index)
				{
					case self::OFFSET_YEARS:
						$date = strtotime( date( 'Y-m-d H:i:s', $date ) . ' - ' . $offset . ' years' );
						break;
					case self::OFFSET_DAYS:
						$date = strtotime( date( 'Y-m-d H:i:s', $date ) . ' - ' . $offset . ' days' );
						break;
					case self::OFFSET_HOURS:
						$date = strtotime( date( 'Y-m-d H:i:s', $date ) . ' - ' . $offset . ' hours' );
						break;
					case self::OFFSET_MINUTES:
						$date = strtotime( date( 'Y-m-d H:i:s', $date ) . ' - ' . $offset . ' minutes' );
						break;
					case self::OFFSET_SECONDS: /* second */
						$date = strtotime( date( 'Y-m-d H:i:s', $date ) . ' - ' . $offset . ' seconds' );
						break;
				}
			}
		}

		return date( 'Y-m-d H:i:s', $date );
	}

	/**
	 * @param $seconds
	 *
	 * @return array
	 */
	public function get_date_parts( $seconds )
	{
		$parts = array(
			'years' => intval( $seconds / ( 60*60*24*365 ) ),
			'days' => 0,
			'hours' => 0,
			'minutes' => 0,
			'seconds' => 0
		);

		$seconds -= ( $parts['years'] * ( 60*60*24*365 ) );

		$parts['days'] = intval( $seconds / ( 60*60*24 ) );
		$seconds -= ( $parts['days'] * ( 60*60*24 ) );

		$parts['hours'] = intval( $seconds / ( 60*60 ) );
		$seconds -= ( $parts['hours'] * ( 60*60 ) );

		$parts['minutes'] = intval( $seconds / ( 60 ) );
		$seconds -= ( $parts['minutes'] * ( 60 ) );

		$parts['seconds'] = $seconds;

		return $parts;
	}
}