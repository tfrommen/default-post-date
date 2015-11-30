<?php # -*- coding: utf-8 -*-

namespace tfrommen\DefaultPostDate\Setting;

/**
 * Setting model.
 *
 * @package tfrommen\DefaultPostDate\Setting
 */
class Setting {

	/**
	 * @var Option
	 */
	private $option;

	/**
	 * @var Sanitizer
	 */
	private $sanitizer;

	/**
	 * Constructor. Sets up the properties.
	 *
	 * @param Option    $option    Option model.
	 * @param Sanitizer $sanitizer Setting sanitizer object.
	 */
	public function __construct( Option $option, Sanitizer $sanitizer ) {

		$this->option = $option;

		$this->sanitizer = $sanitizer;
	}

	/**
	 * Registers the setting.
	 *
	 * @wp-hook admin_init
	 *
	 * @return void
	 */
	public function register() {

		register_setting(
			$this->option->get_group(),
			$this->option->get_name(),
			array( $this->sanitizer, 'sanitize' )
		);
	}
}
