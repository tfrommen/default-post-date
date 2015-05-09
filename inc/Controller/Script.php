<?php # -*- coding: utf-8 -*-

namespace tf\DefaultPostDate\Controller;

use tf\DefaultPostDate\View\Script as View;

/**
 * Class Script
 *
 * @package tf\DefaultPostDate\Controller
 */
class Script {

	/**
	 * @var View
	 */
	private $view;

	/**
	 * Constructor. Set up the properties.
	 *
	 * @param View $view Script tag view.
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
