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
	 * @var string[]
	 */
	private $plugin_data;

	/**
	 * Constructor. Sets up the properties.
	 *
	 * @param string $file Main plugin file.
	 */
	public function __construct( $file ) {

		$this->file = $file;

		$this->plugin_data = get_file_data( $file, array(
			'version'     => 'Version',
			'text_domain' => 'Text Domain',
			'domain_path' => 'Domain Path',
		) );
	}

	/**
	 * Initializes the plugin.
	 *
	 * @return void
	 */
	public function initialize() {

		$option = new Setting\Option();

		$updater = new Update\Updater( $this->plugin_data['version'] );
		$updater->update();

		$text_domain = new L10n\TextDomain( $this->plugin_data, $this->file );
		$text_domain->load();

		$setting_controller = new Setting\Controller(
			new Setting\Setting(
				$option,
				new Setting\Sanitizer()
			)
		);
		$setting_controller->initialize();

		$settings_field_controller = new SettingsField\Controller(
			new SettingsField\View( $option )
		);
		$settings_field_controller->initialize();

		$asset_controller = new Asset\Controller(
			new Asset\Script( $this->file, $option )
		);
		$asset_controller->initialize();
	}
}
