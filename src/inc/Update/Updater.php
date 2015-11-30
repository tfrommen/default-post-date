<?php # -*- coding: utf-8 -*-

namespace tfrommen\DefaultPostDate\Update;

/**
 * Handles all update-related stuff.
 *
 * @package tfrommen\DefaultPostDate\Update
 */
class Updater {

	/**
	 * @var string
	 */
	private $option_name = 'default_post_date_version';

	/**
	 * @var string
	 */
	private $version;

	/**
	 * Constructor. Sets up the properties.
	 *
	 * @param string $version Optional. Current plugin version. Defaults to '0'.
	 */
	public function __construct( $version = '0' ) {

		$this->version = (string) $version;
	}

	/**
	 * Returns the plugin version option name.
	 *
	 * @return string
	 */
	public function get_option_name() {

		return $this->option_name;
	}

	/**
	 * Updates the plugin data.
	 *
	 * @return bool
	 */
	public function update() {

		$old_version = (string) get_option( $this->option_name );
		if ( $old_version === $this->version ) {
			return false;
		}

		if ( version_compare( $old_version, '1.4.1' ) ) {
			$this->rename_option();
		}

		update_option( $this->option_name, $this->version );

		return true;
	}

	/**
	 * Renames the plugin option.
	 *
	 * @return void
	 */
	private function rename_option() {

		$old_option_name = '_default_post_date';

		$new_option_name = 'default_post_date';

		$value = get_option( $old_option_name );
		if ( ! $value ) {
			return;
		}

		update_option( $new_option_name, $value );

		delete_option( $old_option_name );
	}
}
