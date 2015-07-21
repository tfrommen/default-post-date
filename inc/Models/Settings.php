<?php # -*- coding: utf-8 -*-

namespace tf\DefaultPostDate\Models;

/**
 * Class Settings
 *
 * @package tf\DefaultPostDate\Models
 */
class Settings {

	/**
	 * @var string
	 */
	private $option_group = 'general';

	/**
	 * @var string
	 */
	private $option_name = '_default_post_date';

	/**
	 * Register the settings.
	 *
	 * @wp-hook init
	 *
	 * @return void
	 */
	public function register() {

		register_setting(
			$this->option_group,
			$this->option_name,
			array( $this, 'sanitize' )
		);
	}

	/**
	 * Sanitize the setting value.
	 *
	 * @param string $value Setting value.
	 *
	 * @return string
	 */
	public function sanitize( $value ) {

		$time = strtotime( $value );
		if ( $time === FALSE ) {
			return '';
		}

		return date( 'Y-m-d', $time );
	}

	/**
	 * Get the option value.
	 *
	 * @return string
	 */
	public function get() {

		return get_option( $this->option_name, '' );
	}

	/**
	 * Get the option name.
	 *
	 * @return string
	 */
	public function get_option_name() {

		return $this->option_name;
	}

}
