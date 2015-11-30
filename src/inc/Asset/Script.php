<?php # -*- coding: utf-8 -*-

namespace tfrommen\DefaultPostDate\Asset;

use tfrommen\DefaultPostDate\Setting\Option;

/**
 * Script model.
 *
 * @package tfrommen\DefaultPostDate\Asset
 */
class Script {

	/**
	 * @var string
	 */
	private $file;

	/**
	 * @var Option
	 */
	private $option;

	/**
	 * Constructor. Sets up the properties.
	 *
	 * @param string $file   Main plugin file
	 * @param Option $option Option model.
	 */
	public function __construct( $file, Option $option ) {

		$this->file = $file;

		$this->option = $option;
	}

	/**
	 * Enqueues the script file.
	 *
	 * @wp-hook admin_head-{$hook_suffix}
	 *
	 * @return bool
	 */
	public function enqueue() {

		$option_value = $this->option->get();
		if ( ! $option_value ) {
			return false;
		}

		$time = strtotime( $option_value );
		if ( ! $time ) {
			return false;
		}

		$handle = 'default-post-date-admin';

		$url = plugin_dir_url( $this->file );

		$file = 'assets/js/admin' . ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min' ) . '.js';

		$path = plugin_dir_path( $this->file );

		$version = filemtime( $path . $file );

		wp_enqueue_script(
			$handle,
			$url . $file,
			array( 'jquery' ),
			$version,
			true
		);

		wp_localize_script( $handle, 'defaultPostDateSettings', array(
			'day'   => date( 'd', $time ),
			'month' => date( 'm', $time ),
			'year'  => date( 'Y', $time ),
		) );

		return true;
	}
}
