<?php # -*- coding: utf-8 -*-

namespace tfrommen\DefaultPostDate\Asset;

/**
 * Asset controller.
 *
 * @package tfrommen\DefaultPostDate\Controllers
 */
class Controller {

	/**
	 * @var Script
	 */
	private $script;

	/**
	 * Constructor. Sets up the properties.
	 *
	 * @param Script $script Script model.
	 */
	public function __construct( Script $script ) {

		$this->script = $script;
	}

	/**
	 * Wires up all functions.
	 *
	 * @return void
	 */
	public function initialize() {

		add_action( 'admin_head-post-new.php', array( $this->script, 'enqueue' ) );
	}
}
