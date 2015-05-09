<?php # -*- coding: utf-8 -*-

namespace tf\DefaultPostDate\Model;

use tf\DefaultPostDate\View;

/**
 * Class Settings
 *
 * @package tf\DefaultPostDate\Model
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
	 * @var string
	 */
	private $page = 'general';

	/**
	 * @var string
	 */
	private $settings_field_id = 'default-post-date';

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
	 * Add the settings field to the general options.
	 *
	 * @wp-hook admin_init
	 *
	 * @return void
	 */
	public function add_settings_field() {

		$title = esc_html_x( 'Default Post Date', 'Settings field title', 'default-post-date' );
		$title = sprintf(
			'<label for="%s">%s</label>',
			$this->settings_field_id,
			$title
		);

		add_settings_field(
			$this->option_name,
			$title,
			array( new View\SettingsField( $this ), 'render' ),
			$this->page
		);
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

	/**
	 * Get the settings field ID.
	 *
	 * @return string
	 */
	public function get_settings_field_id() {

		return $this->settings_field_id;
	}

}
