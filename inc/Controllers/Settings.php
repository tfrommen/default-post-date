<?php # -*- coding: utf-8 -*-

namespace tf\DefaultPostDate\Controllers;

use tf\DefaultPostDate\Models\Settings as Model;
use tf\DefaultPostDate\Views\SettingsField as View;

/**
 * Class Settings
 *
 * @package tf\DefaultPostDate\Controllers
 */
class Settings {

	/**
	 * @var Model
	 */
	private $model;

	/**
	 * @var View
	 */
	private $view;

	/**
	 * Constructor. Set up the properties.
	 *
	 * @param Model $model Model.
	 * @param View  $view  View.
	 */
	public function __construct( Model $model, View $view ) {

		$this->model = $model;

		$this->view = $view;
	}

	/**
	 * Wire up all functions.
	 *
	 * @return void
	 */
	public function initialize() {

		add_action( 'admin_init', array( $this->model, 'register' ) );
		add_action( 'admin_init', array( $this->view, 'add' ) );
	}

}
