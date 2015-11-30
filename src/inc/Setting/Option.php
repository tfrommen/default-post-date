<?php # -*- coding: utf-8 -*-

namespace tfrommen\DefaultPostDate\Setting;

/**
 * Option model.
 *
 * @package tfrommen\DefaultPostDate\Setting
 */
class Option {

	/**
	 * @var string
	 */
	private $group = 'writing';

	/**
	 * @var string
	 */
	private $name = 'default_post_date';

	/**
	 * Returns the option group.
	 *
	 * @return string
	 */
	public function get_group() {

		return $this->group;
	}

	/**
	 * Returns the option name.
	 *
	 * @return string
	 */
	public function get_name() {

		return $this->name;
	}

	/**
	 * Returns the option value.
	 *
	 * @param string $default Optional. Default option value. Defaults to ''.
	 *
	 * @return string
	 */
	public function get( $default = '' ) {

		$value = get_option( $this->name, $default );
		if ( ! is_string( $value ) ) {
			$value = $default;
		}

		return $value;
	}
}
