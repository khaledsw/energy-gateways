<?php
/**
 * WooCommerce Formatting
 *
 * Functions for formatting data.
 *
 * @author 		WooThemes
 * @category 	Core
 * @package 	WooCommerce/Functions
 * @version     2.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Sanitize taxonomy names. Slug format (no spaces, lowercase).
 *
 * urldecode is used to reverse munging of UTF8 characters.
 *
 * @param mixed $taxonomy
 * @return string
 */
function wc_sanitize_taxonomy_name( $taxonomy ) {
	return apply_filters( 'sanitize_taxonomy_name', urldecode( sanitize_title( $taxonomy ) ), $taxonomy );
}

/**
 * Sanitize permalink values before insertion into DB.
 *
 * Cannot use wc_clean because it sometimes strips % chars and breaks the user's setting.
 *
 * @since  2.6.0
 * @param  string $value
 * @return string
 */
function wc_sanitize_permalink( $value ) {
	global $wpdb;

	$value = $wpdb->strip_invalid_text_for_column( $wpdb->options, 'option_value', $value );

	if ( is_wp_error( $value ) ) {
		$value = '';
	}

	$value = esc_url_raw( $value );
	$value = str_replace( 'http://', '', $value );
	return untrailingslashit( $value );
}

/**
 * Gets the filename part of a download URL.
 *
 * @param string $file_url
 * @return string
 */
function wc_get_filename_from_url( $file_url ) {
	$parts = parse_url( $file_url );
	if ( isset( $parts['path'] ) ) {
		return basename( $parts['path'] );
	}
}

/**
 * Normalise dimensions, unify to cm then convert to wanted unit value.
 *
 * Usage:
 * wc_get_dimension(55, 'in');
 * wc_get_dimension(55, 'in', 'm');
 *
 * @param int|float $dimension
 * @param string $to_unit 'in', 'm', 'cm', 'm'
 * @param string $from_unit (optional) 'in', 'm', 'cm', 'm'
 * @return float
 */
function wc_get_dimension( $dimension, $to_unit, $from_unit = '' ) {
	$to_unit = strtolower( $to_unit );

	if ( empty( $from_unit ) ) {
		$from_unit = strtolower( get_option( 'woocommerce_dimension_unit' ) );
	}

	// Unify all units to cm first.
	if ( $from_unit !== $to_unit ) {
		switch ( $from_unit ) {
			case 'in' :
				$dimension *= 2.54;
				break;
			case 'm' :
				$dimension *= 100;
				break;
			case 'mm' :
				$dimension *= 0.1;
				break;
			case 'yd' :
				$dimension *= 91.44;
				break;
		}

		// Output desired unit.
		switch ( $to_unit ) {
			case 'in' :
				$dimension *= 0.3937;
				break;
			case 'm' :
				$dimension *= 0.01;
				break;
			case 'mm' :
				$dimension *= 10;
				break;
			case 'yd' :
				$dimension *= 0.010936133;
				break;
		}
	}

	return ( $dimension < 0 ) ? 0 : $dimension;
}

/**
 * Normalise weights, unify to kg then convert to wanted unit value.
 *
 * Usage:
 * wc_get_weight(55, 'kg');
 * wc_get_weight(55, 'kg', 'lbs');
 *
 * @param int|float $weight
 * @param string $to_unit 'g', 'kg', 'lbs', 'oz'
 * @param string $from_unit (optional) 'g', 'kg', 'lbs', 'oz'
 * @return float
 */
function wc_get_weight( $weight, $to_unit, $from_unit = '' ) {
	$to_unit = strtolower( $to_unit );

	if ( empty( $from_unit ) ) {
		$from_unit = strtolower( get_option( 'woocommerce_weight_unit' ) );
	}

	// Unify all units to kg first.
	if ( $from_unit !== $to_unit ) {
		switch ( $from_unit ) {
			case 'g' :
				$weight *= 0.001;
				break;
			case 'lbs' :
				$weight *= 0.453592;
				break;
			case 'oz' :
				$weight *= 0.0283495;
				break;
		}

		// Output desired unit.
		switch ( $to_unit ) {
			case 'g' :
				$weight *= 1000;
				break;
			case 'lbs' :
				$weight *= 2.20462;
				break;
			case 'oz' :
				$weight *= 35.274;
				break;
		}
	}

	return ( $weight < 0 ) ? 0 : $weight;
}

/**
 * Trim trailing zeros off prices.
 *
 * @param mixed $price
 * @return string
 */
function wc_trim_zeros( $price ) {
	return preg_replace( '/' . preg_quote( wc_get_price_decimal_separator(), '/' ) . '0++$/', '', $price );
}

/**
 * Round a tax amount.
 *
 * @param mixed $tax
 * @return double
 */
function wc_round_tax_total( $tax ) {
	$dp = wc_get_price_decimals();

	// @codeCoverageIgnoreStart
	if ( version_compare( phpversion(), '5.3', '<' ) ) {
		$rounded_tax = round( $tax, $dp );
	} else {
		// @codeCoverageIgnoreEnd
		$rounded_tax = round( $tax, $dp, WC_TAX_ROUNDING_MODE );
	}
	return apply_filters( 'wc_round_tax_total', $rounded_tax, $tax, $dp, WC_TAX_ROUNDING_MODE );
}

/**
 * Make a refund total negative.
 * @return float
 */
function wc_format_refund_total( $amount ) {
	return $amount * -1;
}

/**
 * Format decimal numbers ready for DB storage.
 *
 * Sanitize, remove locale formatting, and optionally round + trim off zeros.
 *
 * @param  float|string $number Expects either a float or a string with a decimal separator only (no thousands)
 * @param  mixed $dp number of decimal points to use, blank to use woocommerce_price_num_decimals, or false to avoid all rounding.
 * @param  bool $trim_zeros from end of string
 * @return string
 */
function wc_format_decimal( $number, $dp = false, $trim_zeros = false ) {
	$locale   = localeconv();
	$decimals = array( wc_get_price_decimal_separator(), $locale['decimal_point'], $locale['mon_decimal_point'] );

	// Remove locale from string
	if ( ! is_float( $number ) ) {
		$number = wc_clean( str_replace( $decimals, '.', $number ) );
	}

	if ( $dp !== false ) {
		$dp     = intval( $dp == "" ? wc_get_price_decimals() : $dp );
		$number = number_format( floatval( $number ), $dp, '.', '' );

	// DP is false - don't use number format, just return a string in our format
	} elseif ( is_float( $number ) ) {
		$number = wc_clean( str_replace( $decimals, '.', strval( $number ) ) );
	}

	if ( $trim_zeros && strstr( $number, '.' ) ) {
		$number = rtrim( rtrim( $number, '0' ), '.' );
	}

	return $number;
}

/**
 * Convert a float to a string without locale formatting which PHP adds when changing floats to strings.
 * @param  float $float
 * @return string
 */
function wc_float_to_string( $float ) {
	if ( ! is_float( $float ) ) {
		return $float;
	}

	$locale = localeconv();
	$string = strval( $float );
	$string = str_replace( $locale['decimal_point'], '.', $string );

	return $string;
}

/**
 * Format a price with WC Currency Locale settings.
 * @param  string $value
 * @return string
 */
function wc_format_localized_price( $value ) {
	return str_replace( '.', wc_get_price_decimal_separator(), strval( $value ) );
}

/**
 * Format a decimal with PHP Locale settings.
 * @param  string $value
 * @return string
 */
function wc_format_localized_decimal( $value ) {
	$locale = localeconv();
	return str_replace( '.', $locale['decimal_point'], strval( $value ) );
}

/**
 * Clean variables using sanitize_text_field. Arrays are cleaned recursively.
 * Non-scalar values are ignored.
 * @param string|array $var
 * @return string|array
 */
function wc_clean( $var ) {
	if ( is_array( $var ) ) {
		return array_map( 'wc_clean', $var );
	} else {
		return is_scalar( $var ) ? sanitize_text_field( $var ) : $var;
	}
}

/**
 * Sanitize a string destined to be a tooltip.
 *
 * @since 2.3.10 Tooltips are encoded with htmlspecialchars to prevent XSS. Should not be used in conjunction with esc_attr()
 * @param string $var
 * @return string
 */
function wc_sanitize_tooltip( $var ) {
	return htmlspecialchars( wp_kses( html_entity_decode( $var ), array(
		'br'     => array(),
		'em'     => array(),
		'strong' => array(),
		'small'  => array(),
		'span'   => array(),
		'ul'     => array(),
		'li'     => array(),
		'ol'     => array(),
		'p'      => array(),
    ) ) );
}

/**
 * Merge two arrays.
 *
 * @param array $a1
 * @param array $a2
 * @return array
 */
function wc_array_overlay( $a1, $a2 ) {
	foreach ( $a1 as $k => $v ) {
		if ( ! array_key_exists( $k, $a2 ) ) {
			continue;
		}
		if ( is_array( $v ) && is_array( $a2[ $k ] ) ) {
			$a1[ $k ] = wc_array_overlay( $v, $a2[ $k ] );
		} else {
			$a1[ $k ] = $a2[ $k ];
		}
	}
	return $a1;
}

/**
 * Formats a stock amount by running it through a filter.
 * @param  int|float $amount
 * @return int|float
 */
function wc_stock_amount( $amount ) {
	return apply_filters( 'woocommerce_stock_amount', $amount );
}

/**
 * Get the price format depending on the currency position.
 *
 * @return string
 */
function get_woocommerce_price_format() {
	$currency_pos = get_option( 'woocommerce_currency_pos' );
	$format = '%1$s%2$s';

	switch ( $currency_pos ) {
		case 'left' :
			$format = '%1$s%2$s';
		break;
		case 'right' :
			$format = '%2$s%1$s';
		break;
		case 'left_space' :
			$format = '%1$s&nbsp;%2$s';
		break;
		case 'right_space' :
			$format = '%2$s&nbsp;%1$s';
		break;
	}

	return apply_filters( 'woocommerce_price_format', $format, $currency_pos );
}

/**
 * Return the thousand separator for prices.
 * @since  2.3
 * @return string
 */
function wc_get_price_thousand_separator() {
	$separator = stripslashes( get_option( 'woocommerce_price_thousand_sep' ) );
	return $separator;
}

/**
 * Return the decimal separator for prices.
 * @since  2.3
 * @return string
 */
function wc_get_price_decimal_separator() {
	$separator = stripslashes( get_option( 'woocommerce_price_decimal_sep' ) );
	return $separator ? $separator : '.';
}

/**
 * Return the number of decimals after the decimal point.
 * @since  2.3
 * @return int
 */
function wc_get_price_decimals() {
	return absint( get_option( 'woocommerce_price_num_decimals', 2 ) );
}

/**
 * Format the price with a currency symbol.
 *
 * @param float $price
 * @param array $args (default: array())
 * @return string
 */
function wc_price( $price, $args = array() ) {
	extract( apply_filters( 'wc_price_args', wp_parse_args( $args, array(
		'ex_tax_label'       => false,
		'currency'           => '',
		'decimal_separator'  => wc_get_price_decimal_separator(),
		'thousand_separator' => wc_get_price_thousand_separator(),
		'decimals'           => wc_get_price_decimals(),
		'price_format'       => get_woocommerce_price_format()
	) ) ) );

	$negative        = $price < 0;
	$price           = apply_filters( 'raw_woocommerce_price', floatval( $negative ? $price * -1 : $price ) );
	$price           = apply_filters( 'formatted_woocommerce_price', number_format( $price, $decimals, $decimal_separator, $thousand_separator ), $price, $decimals, $decimal_separator, $thousand_separator );

	if ( apply_filters( 'woocommerce_price_trim_zeros', false ) && $decimals > 0 ) {
		$price = wc_trim_zeros( $price );
	}

	$formatted_price = ( $negative ? '-' : '' ) . sprintf( $price_format, '<span class="woocommerce-Price-currencySymbol">' . get_woocommerce_currency_symbol( $currency ) . '</span>', $price );
	$return          = '<span class="woocommerce-Price-amount amount">' . $formatted_price . '</span>';

	if ( $ex_tax_label && wc_tax_enabled() ) {
		$return .= ' <small class="woocommerce-Price-taxLabel tax_label">' . WC()->countries->ex_tax_or_vat() . '</small>';
	}

	return apply_filters( 'wc_price', $return, $price, $args );
}

/**
 * let_to_num function.
 *
 * This function transforms the php.ini notation for numbers (like '2M') to an integer.
 *
 * @param $size
 * @return int
 */
function wc_let_to_num( $size ) {
	$l   = substr( $size, -1 );
	$ret = substr( $size, 0, -1 );
	switch ( strtoupper( $l ) ) {
		case 'P':
			$ret *= 1024;
		case 'T':
			$ret *= 1024;
		case 'G':
			$ret *= 1024;
		case 'M':
			$ret *= 1024;
		case 'K':
			$ret *= 1024;
	}
	return $ret;
}

/**
 * WooCommerce Date Format - Allows to change date format for everything WooCommerce.
 *
 * @return string
 */
function wc_date_format() {
	return apply_filters( 'woocommerce_date_format', get_option( 'date_format' ) );
}

/**
 * WooCommerce Time Format - Allows to change time format for everything WooCommerce.
 *
 * @return string
 */
function wc_time_format() {
	return apply_filters( 'woocommerce_time_format', get_option( 'time_format' ) );
}

/**
 * WooCommerce Timezone - helper to retrieve the timezone string for a site until.
 * a WP core method exists (see https://core.trac.wordpress.org/ticket/24730).
 *
 * Adapted from https://secure.php.net/manual/en/function.timezone-name-from-abbr.php#89155.
 *
 * @since 2.1
 * @return string a valid PHP timezone string for the site
 */
function wc_timezone_string() {

	// if site timezone string exists, return it
	if ( $timezone = get_option( 'timezone_string' ) ) {
		return $timezone;
	}

	// get UTC offset, if it isn't set then return UTC
	if ( 0 === ( $utc_offset = get_option( 'gmt_offset', 0 ) ) ) {
		return 'UTC';
	}

	// adjust UTC offset from hours to seconds
	$utc_offset *= 3600;

	// attempt to guess the timezone string from the UTC offset
	$timezone = timezone_name_from_abbr( '', $utc_offset, 0 );

	// last try, guess timezone string manually
	if ( false === $timezone ) {
		$is_dst = date( 'I' );

		foreach ( timezone_abbreviations_list() as $abbr ) {
			foreach ( $abbr as $city ) {
				if ( $city['dst'] == $is_dst && $city['offset'] == $utc_offset ) {
					return $city['timezone_id'];
				}
			}
		}

		// fallback to UTC
		return 'UTC';
	}

	return $timezone;
}

if ( ! function_exists( 'wc_rgb_from_hex' ) ) {

	/**
	 * Hex darker/lighter/contrast functions for colours.
	 *
	 * @param mixed $color
	 * @return string
	 */
	function wc_rgb_from_hex( $color ) {
		$color = str_replace( '#', '', $color );
		// Convert shorthand colors to full format, e.g. "FFF" -> "FFFFFF"
		$color = preg_replace( '~^(.)(.)(.)$~', '$1$1$2$2$3$3', $color );

		$rgb      = array();
		$rgb['R'] = hexdec( $color[0].$color[1] );
		$rgb['G'] = hexdec( $color[2].$color[3] );
		$rgb['B'] = hexdec( $color[4].$color[5] );

		return $rgb;
	}
}

if ( ! function_exists( 'wc_hex_darker' ) ) {

	/**
	 * Hex darker/lighter/contrast functions for colours.
	 *
	 * @param mixed $color
	 * @param int $factor (default: 30)
	 * @return string
	 */
	function wc_hex_darker( $color, $factor = 30 ) {
		$base  = wc_rgb_from_hex( $color );
		$color = '#';

		foreach ( $base as $k => $v ) {
			$amount      = $v / 100;
			$amount      = round( $amount * $factor );
			$new_decimal = $v - $amount;

			$new_hex_component = dechex( $new_decimal );
			if ( strlen( $new_hex_component ) < 2 ) {
				$new_hex_component = "0" . $new_hex_component;
			}
			$color .= $new_hex_component;
		}

		return $color;
	}
}

if ( ! function_exists( 'wc_hex_lighter' ) ) {

	/**
	 * Hex darker/lighter/contrast functions for colours.
	 *
	 * @param mixed $color
	 * @param int $factor (default: 30)
	 * @return string
	 */
	function wc_hex_lighter( $color, $factor = 30 ) {
		$base  = wc_rgb_from_hex( $color );
		$color = '#';

		foreach ( $base as $k => $v ) {
			$amount      = 255 - $v;
			$amount      = $amount / 100;
			$amount      = round( $amount * $factor );
			$new_decimal = $v + $amount;

			$new_hex_component = dechex( $new_decimal );
			if ( strlen( $new_hex_component ) < 2 ) {
				$new_hex_component = "0" . $new_hex_component;
			}
			$color .= $new_hex_component;
		}

		return $color;
	}
}

if ( ! function_exists( 'wc_light_or_dark' ) ) {

	/**
	 * Detect if we should use a light or dark colour on a background colour.
	 *
	 * @param mixed $color
	 * @param string $dark (default: '#000000')
	 * @param string $light (default: '#FFFFFF')
	 * @return string
	 */
	function wc_light_or_dark( $color, $dark = '#000000', $light = '#FFFFFF' ) {

		$hex = str_replace( '#', '', $color );

		$c_r = hexdec( substr( $hex, 0, 2 ) );
		$c_g = hexdec( substr( $hex, 2, 2 ) );
		$c_b = hexdec( substr( $hex, 4, 2 ) );

		$brightness = ( ( $c_r * 299 ) + ( $c_g * 587 ) + ( $c_b * 114 ) ) / 1000;

		return $brightness > 155 ? $dark : $light;
	}
}

if ( ! function_exists( 'wc_format_hex' ) ) {

	/**
	 * Format string as hex.
	 *
	 * @param string $hex
	 * @return string
	 */
	function wc_format_hex( $hex ) {

		$hex = trim( str_replace( '#', '', $hex ) );

		if ( strlen( $hex ) == 3 ) {
			$hex = $hex[0] . $hex[0] . $hex[1] . $hex[1] . $hex[2] . $hex[2];
		}

		return $hex ? '#' . $hex : null;
	}
}

/**
 * Format the postcode according to the country and length of the postcode.
 *
 * @param string $postcode
 * @param string $country
 * @return string Formatted postcode.
 */
function wc_format_postcode( $postcode, $country ) {
	$postcode = wc_normalize_postcode( $postcode );

	switch ( $country ) {
		case 'CA' :
		case 'GB' :
			$postcode = trim( substr_replace( $postcode, ' ', -3, 0 ) );
			break;
		case 'BR' :
			$postcode = trim( substr_replace( $postcode, '-', -3, 0 ) );
			break;
		case 'JP' :
			$postcode = trim( substr_replace( $postcode, '-', 3, 0 ) );
			break;
		case 'PT' :
			$postcode = trim( substr_replace( $postcode, '-', 4, 0 ) );
			break;
	}

	return apply_filters( 'woocommerce_format_postcode', $postcode, $country );
}

/**
 * Normalize postcodes.
 *
 * Remove spaces and convert characters to uppercase.
 *
 * @since 2.6.0
 * @param string $postcode
 * @return string Sanitized postcode.
 */
function wc_normalize_postcode( $postcode ) {
	return preg_replace( '/[\s\-]/', '', trim( strtoupper( $postcode ) ) );
}

/**
 * format_phone function.
 *
 * @param mixed $tel
 * @return string
 */
function wc_format_phone_number( $tel ) {
	return str_replace( '.', '-', $tel );
}

/**
 * Make a string lowercase.
 * Try to use mb_strtolower() when available.
 *
 * @since  2.3
 * @param  string $string
 * @return string
 */
function wc_strtolower( $string ) {
	return function_exists( 'mb_strtolower' ) ? mb_strtolower( $string ) : strtolower( $string );
}

/**
 * Trim a string and append a suffix.
 * @param  string  $string
 * @param  integer $chars
 * @param  string  $suffix
 * @return string
 */
function wc_trim_string( $string, $chars = 200, $suffix = '...' ) {
	if ( strlen( $string ) > $chars ) {
		if ( function_exists( 'mb_substr' ) ) {
			$string = mb_substr( $string, 0, ( $chars - mb_strlen( $suffix ) ) ) . $suffix;
		} else {
			$string = substr( $string, 0, ( $chars - strlen( $suffix ) ) ) . $suffix;
		}
	}
	return $string;
}

/**
 * Format content to display shortcodes.
 *
 * @since  2.3.0
 * @param  string $raw_string
 * @return string
 */
function wc_format_content( $raw_string ) {
	return apply_filters( 'woocommerce_format_content', do_shortcode( shortcode_unautop( wpautop( $raw_string ) ) ), $raw_string );
}

/**
 * Format product short description.
 * Adds support for Jetpack Markdown.
 *
 * @since  2.4.0
 * @param  string $content
 * @return string
 */
function wc_format_product_short_description( $content ) {
	// Add support for Jetpack Markdown
	if ( class_exists( 'WPCom_Markdown' ) ) {
		$markdown = WPCom_Markdown::get_instance();

		return wpautop( $markdown->transform( $content, array( 'unslash' => false ) ) );
	}

	return $content;
}

add_filter( 'woocommerce_short_description', 'wc_format_product_short_description', 9999999 );

/**
 * Formats curency symbols when saved in settings.
 * @param  string $value
 * @param  array $option
 * @param  string $raw_value
 * @return string
 */
function wc_format_option_price_separators( $value, $option, $raw_value ) {
	return wp_kses_post( $raw_value );
}
add_filter( 'woocommerce_admin_settings_sanitize_option_woocommerce_price_decimal_sep', 'wc_format_option_price_separators', 10, 3 );
add_filter( 'woocommerce_admin_settings_sanitize_option_woocommerce_price_thousand_sep', 'wc_format_option_price_separators', 10, 3 );

/**
 * Formats decimals when saved in settings.
 * @param  string $value
 * @param  array $option
 * @param  string $raw_value
 * @return string
 */
function wc_format_option_price_num_decimals( $value, $option, $raw_value ) {
	return is_null( $raw_value ) ? 2 : absint( $raw_value );
}
add_filter( 'woocommerce_admin_settings_sanitize_option_woocommerce_price_num_decimals', 'wc_format_option_price_num_decimals', 10, 3 );

/**
 * Formats hold stock option and sets cron event up.
 * @param  string $value
 * @param  array $option
 * @param  string $raw_value
 * @return string
 */
function wc_format_option_hold_stock_minutes( $value, $option, $raw_value ) {
	$value = ! empty( $raw_value ) ? absint( $raw_value ) : ''; // Allow > 0 or set to ''

	wp_clear_scheduled_hook( 'woocommerce_cancel_unpaid_orders' );

	if ( '' !== $value ) {
		wp_schedule_single_event( time() + ( absint( $value ) * 60 ), 'woocommerce_cancel_unpaid_orders' );
	}

	return $value;
}
add_filter( 'woocommerce_admin_settings_sanitize_option_woocommerce_hold_stock_minutes', 'wc_format_option_hold_stock_minutes', 10, 3 );

/**
 * Sanitize terms from an attribute text based.
 *
 * @since  2.4.5
 * @param  string $term
 * @return string
 */
function wc_sanitize_term_text_based( $term ) {
	return trim( wp_unslash( strip_tags( $term ) ) );
}

if ( ! function_exists( 'wc_make_numeric_postcode' ) ) {
	/**
	 * Make numeric postcode.
	 *
	 * Converts letters to numbers so we can do a simple range check on postcodes.
	 * E.g. PE30 becomes 16050300 (P = 16, E = 05, 3 = 03, 0 = 00)
	 *
	 * @since 2.6.0
	 * @param string $postcode Regular postcode
	 * @return string
	 */
	function wc_make_numeric_postcode( $postcode ) {
		$postcode_length    = strlen( $postcode );
		$letters_to_numbers = array_merge( array( 0 ), range( 'A', 'Z' ) );
		$letters_to_numbers = array_flip( $letters_to_numbers );
		$numeric_postcode   = '';

		for ( $i = 0; $i < $postcode_length; $i ++ ) {
			if ( is_numeric( $postcode[ $i ] ) ) {
				$numeric_postcode .= str_pad( $postcode[ $i ], 2, '0', STR_PAD_LEFT );
			} elseif ( isset( $letters_to_numbers[ $postcode[ $i ] ] ) ) {
				$numeric_postcode .= str_pad( $letters_to_numbers[ $postcode[ $i ] ], 2, '0', STR_PAD_LEFT );
			} else {
				$numeric_postcode .= '00';
			}
		}

		return $numeric_postcode;
	}
}
