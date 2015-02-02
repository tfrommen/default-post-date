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
	 * Constructor. Init properties.
	 *
	 * @see init()
	 *
	 * @param string $file Main plugin file
	 */
	public function __construct( $file ) {

		$this->file = $file;
	}

	/**
	 * Init controllers.
	 *
	 * @see init()
	 *
	 * @return void
	 */
	public function init() {

		if ( is_admin() ) {
			$text_domain = new Model\TextDomain( $this->file );

			$admin_controller = new Controller\Admin( $text_domain );
			$admin_controller->init();
		}
	}

}
