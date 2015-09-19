<?php # -*- coding: utf-8 -*-

namespace tfrommen\DefaultPostDate;

/**
 * Main controller.
 *
 * @package tfrommen\DefaultPostDate
 */
class Plugin {

	/**
	 * @var string
	 */
	private $file;

	/**
	 * @var string
	 */
	private $plugin_data;

	/**
	 * Constructor. Set up the properties.
	 *
	 * @param string $file Main plugin file.
	 */
	public function __construct( $file ) {

		$this->file = $file;

		$headers = array(
			'version'     => 'Version',
			'text_domain' => 'Text Domain',
			'domain_path' => 'Domain Path',
		);
		$this->plugin_data = get_file_data( $file, $headers );
	}

	/**
	 * Initialize the plugin.
	 *
	 * @return void
	 */
	public function initialize() {

		$update_controller = new Controllers\Update( $this->plugin_data[ 'version' ] );
		$update_controller->update();

		$text_domain = new Models\TextDomain(
			$this->file,
			$this->plugin_data[ 'text_domain' ],
			$this->plugin_data[ 'domain_path' ]
		);
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
