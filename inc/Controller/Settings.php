<?php # -*- coding: utf-8 -*-

namespace tf\DefaultPostDate\Controller;

use tf\DefaultPostDate\Model\Settings as Model;
use tf\DefaultPostDate\View;

/**
 * Class Settings
 *
 * @package tf\DefaultPostDate\Controller
 */
class Settings {

	/**
	 * @var Model
	 */
	private $model;

	/**
	 * Constructor. Set up the properties.
	 *
	 * @param Model $model Model.
	 */
	public function __construct( Model $model ) {

		$this->model = $model;
	}

	/**
	 * Wire up all functions.
	 *
	 * @return void
	 */
	public function initialize() {

		add_action( 'admin_init', array( $this->model, 'register' ) );
		add_action( 'admin_init', array( $this->model, 'add_settings_field' ) );
	}

}
