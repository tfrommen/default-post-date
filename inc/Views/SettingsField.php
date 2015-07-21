<?php # -*- coding: utf-8 -*-

namespace tf\DefaultPostDate\Views;

use tf\DefaultPostDate\Models\Settings;

/**
 * Class SettingsField
 *
 * @package tf\DefaultPostDate\Views
 */
class SettingsField {

	/**
	 * @var string
	 */
	private $id = 'default-post-date';

	/**
	 * @var string
	 */
	private $option_name;

	/**
	 * @var Settings
	 */
	private $settings;

	/**
	 * Constructor. Set up the properties.
	 *
	 * @param Settings $settings Settings model.
	 */
	public function __construct( Settings $settings ) {

		$this->settings = $settings;

		$this->option_name = $settings->get_option_name();
	}

	/**
	 * Add the settings field to the general options.
	 *
	 * @wp-hook admin_init
	 *
	 * @return void
	 */
	public function add() {

		$title = esc_html_x( 'Default Post Date', 'Settings field title', 'default-post-date' );
		$title = sprintf(
			'<label for="%s">%s</label>',
			$this->id,
			$title
		);

		add_settings_field(
			$this->option_name,
			$title,
			array( $this, 'render' ),
			'general'
		);
	}

	/**
	 * Render the HTML.
	 *
	 * @return void
	 */
	public function render() {

		$description = _x(
			'Please enter the default post date according to the %s date format.',
			'Settings field description, %s = date format',
			'default-post-date'
		);
		$description = sprintf(
			$description,
			'<code>YYYY-MM-DD</code>'
		);

		printf(
			'<input type="text" id="%s" name="%s" value="%s" maxlength="10" placeholder="YYYY-MM-DD">
			<p class="description">%s</p>',
			$this->id,
			$this->option_name,
			$this->settings->get(),
			$description
		);
	}

}
