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
	private $page = 'general';

	/**
	 * Get options page name.
	 *
	 * @return string
	 */
	public function get_page() {

		return $this->page;
	}

	/**
	 * Add settings field to general options.
	 *
	 * @wp-hook admin_init
	 *
	 * @return void
	 */
	public function add() {

		$option_name = Option::get_name();

		register_setting(
			$this->page,
			$option_name,
			array( $this, 'sanitize' )
		);

		$id = 'default-post-date';
		$title = esc_html_x( 'Default Post Date', 'Settings field title', 'default-post-date' );
		$title = sprintf(
			'<label for="%s">%s</label>',
			$id,
			$title
		);
		$settings_field = new View\SettingsField( $id, $option_name );
		add_settings_field(
			$option_name,
			$title,
			array( $settings_field, 'render' ),
			$this->page
		);
	}

	/**
	 * Sanitize setting.
	 *
	 * @see add()
	 *
	 * @param string $value Setting value
	 *
	 * @return string
	 */
	public function sanitize( $value ) {

		if ( preg_match( '/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/', $value ) ) {
			return $value;
		}

		return '';
	}

}
