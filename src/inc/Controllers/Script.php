<?php # -*- coding: utf-8 -*-

namespace tfrommen\DefaultPostDate\Controllers;

use tfrommen\DefaultPostDate\Views\Script as View;

/**
 * Script controller.
 *
 * @package tfrommen\DefaultPostDate\Controllers
 */
class Script {

	/**
	 * @var View
	 */
	private $view;

	/**
	 * Constructor. Set up the properties.
	 *
	 * @param View $view Script view.
	 */
	public function __construct( View $view ) {

		$this->view = $view;
	}

	/**
	 * Wire up all functions.
	 *
	 * @return void
	 */
	public function initialize() {

		add_action( 'post_submitbox_misc_actions', array( $this->view, 'render' ) );
	}

}