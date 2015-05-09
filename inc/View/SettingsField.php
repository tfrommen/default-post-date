<?php # -*- coding: utf-8 -*-

namespace tf\DefaultPostDate\View;

use tf\DefaultPostDate\Model\Settings;

/**
 * Class SettingsField
 *
 * @package tf\DefaultPostDate\View
 */
class SettingsField {

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
			$this->settings->get_settings_field_id(),
			$this->settings->get_option_name(),
			$this->settings->get(),
			$description
		);
	}

}
