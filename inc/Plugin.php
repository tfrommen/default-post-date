<?php # -*- coding: utf-8 -*-

namespace tf\DefaultPostDate;

/**
 * Class Plugin
 *
 * @package tf\DefaultPostDate
 */
class Plugin {

	/**
	 * @var string
	 */
	private $file;

	/**
	 * Constructor. Set up the properties.
	 *
	 * @param string $file Main plugin file.
	 */
	public function __construct( $file ) {

		$this->file = $file;
	}

	/**
	 * Initialize the plugin.
	 *
	 * @return void
	 */
	public function initialize() {

		$text_domain = new Models\TextDomain( $this->file );
		$text_domain->load();

		$settings = new Models\Settings();
		$settings_field_view = new Views\SettingsField( $settings );
		$settings_controller = new Controllers\Settings( $settings, $settings_field_view );
		$settings_controller->initialize();

		$script = new Views\Script( $settings );
		$script_controller = new Controllers\Script( $script );
		$script_controller->initialize();
	}

}
