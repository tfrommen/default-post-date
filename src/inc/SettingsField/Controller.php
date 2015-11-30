<?php # -*- coding: utf-8 -*-

namespace tfrommen\DefaultPostDate\SettingsField;

/**
 * Settings field controller.
 *
 * @package tfrommen\DefaultPostDate\SettingsField
 */
class Controller {

	/**
	 * @var View
	 */
	private $view;

	/**
	 * Constructor. Sets up the properties.
	 *
	 * @param View $view Settings field view.
	 */
	public function __construct( View $view ) {

		$this->view = $view;
	}

	/**
	 * Wires up all functions.
	 *
	 * @return void
	 */
	public function initialize() {

		add_action( 'admin_init', array( $this->view, 'add' ) );
	}
}
