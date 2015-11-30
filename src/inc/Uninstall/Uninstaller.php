<?php # -*- coding: utf-8 -*-

namespace tfrommen\DefaultPostDate\Uninstall;

use tfrommen\DefaultPostDate\Setting\Option;
use tfrommen\DefaultPostDate\Update\Updater;

/**
 * Handles all uninstall-related stuff.
 *
 * @package tfrommen\DefaultPostDate\Uninstall
 */
class Uninstaller {

	/**
	 * @var Option
	 */
	private $option;

	/**
	 * @var string
	 */
	private $version_option_name;

	/**
	 * @var \wpdb
	 */
	private $wpdb;

	/**
	 * Constructor. Sets up the properties.
	 *
	 * @param Updater $updater Updater.
	 * @param \wpdb   $wpdb    Database object.
	 * @param Option  $option  Option model.
	 */
	public function __construct( Updater $updater, \wpdb $wpdb, Option $option ) {

		$this->version_option_name = $updater->get_option_name();

		$this->wpdb = $wpdb;

		$this->option = $option;
	}

	/**
	 * Uninstalls all plugin data.
	 *
	 * @return void
	 */
	public function uninstall() {

		if ( is_multisite() ) {
			foreach ( $this->wpdb->get_col( "SELECT blog_id FROM {$this->wpdb->blogs}" ) as $blog_id ) {
				switch_to_blog( $blog_id );

				$this->delete_options();

				restore_current_blog();
			}
		} else {
			$this->delete_options();
		}
	}

	/**
	 * Deletes all plugin options.
	 *
	 * @return void
	 */
	private function delete_options() {

		delete_option( $this->version_option_name );

		delete_option( $this->option->get_name() );
	}
}
