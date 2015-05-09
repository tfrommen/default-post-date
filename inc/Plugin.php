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

		$text_domain = new Model\TextDomain( $this->file );
		$text_domain->load();

		$settings = new Model\Settings();
		$settings_controller = new Controller\Settings( $settings );
		$settings_controller->initialize();

		$script = new View\Script( $settings );
		$script_controller = new Controller\Script( $script );
		$script_controller->initialize();
	}

}
