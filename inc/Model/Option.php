<?php # -*- coding: utf-8 -*-

namespace tf\DefaultPostDate\Model;

/**
 * Class Option
 *
 * @package tf\DefaultPostDate\Model
 */
class Option {

	/**
	 * @var string
	 */
	private static $name = '_default_post_date';

	/**
	 * Get option name.
	 *
	 * @return string
	 */
	public static function get_name() {

		return self::$name;
	}

	/**
	 * Get option value.
	 *
	 * @param string $default Default option value (Optional)
	 *
	 * @return string
	 */
	public static function get( $default = '' ) {

		if ( ! is_string( $default ) ) {
			$default = '';
		}

		return get_option( self::$name, $default );
	}

}
